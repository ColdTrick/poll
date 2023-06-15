<?php

namespace ColdTrick\Poll;

use Elgg\Database\Seeds\Seed;
use Elgg\Database\Update;
use Elgg\Exceptions\Seeding\MaxAttemptsException;
use Elgg\Values;

/**
 * Seed Polls in the database
 */
class Seeder extends Seed {
	
	/**
	 * {@inheritDoc}
	 */
	public function seed() {
		$this->advance($this->getCount());
		
		$allow_personal_poll = elgg_get_plugin_setting('enable_site', 'poll') === 'yes';
		$allow_group_poll = elgg_get_plugin_setting('enable_group', 'poll') === 'yes';
		
		$session_manager = elgg()->session_manager;
		$logger = elgg()->logger;
		$logged_in = $session_manager->getLoggedInUser();
		
		while ($this->getCount() < $this->limit) {
			$created = $this->getRandomCreationTimestamp();
			$owner = $this->getRandomUser();
			
			$session_manager->setLoggedInUser($owner);
			
			// where to create the poll
			$container_guid = $owner->guid;
			if ($allow_personal_poll && $allow_group_poll) {
				if ($this->faker()->boolean()) {
					$container_guid = $this->getRandomGroup()->guid;
				}
			} elseif ($allow_group_poll) {
				$container_guid = $this->getRandomGroup()->guid;
			} else {
				// unable to seed
				break;
			}
			
			// make poll close date
			$close_date = null;
			if ($this->faker()->boolean(30)) {
				$max_close = $this->create_until ?? time();
				$close = Values::normalizeTime($this->faker()->numberBetween($created, $max_close));
				$close->setTime(23, 59, 59);
				$close_date = $close->getTimestamp();
			}
			
			$properties = [
				'subtype' => \Poll::SUBTYPE,
				'owner_guid' => $owner->guid,
				'container_guid' => $container_guid,
				'time_created' => $created,
				'comments_allowed' => $this->faker()->boolean() ? 'yes' : 'no',
				'results_output' => $this->faker()->boolean(70) ? 'pie' : 'bar',
				'close_date' => $close_date,
			];
			
			/* @var $entity \Poll */
			try {
				$logger->disable();
				
				$entity = $this->createObject($properties);
				
				$logger->enable();
			} catch (MaxAttemptsException $e) {
				// unable to create with the given options
				$logger->enable();
				continue;
			}
			
			$this->createComments($entity);
			$this->createLikes($entity);
			$this->createAnswers($entity);
			$this->createVotes($entity);
			
			elgg_create_river_item([
				'view' => 'river/object/poll/create',
				'action_type' => 'create',
				'subject_guid' => $entity->owner_guid,
				'object_guid' => $entity->guid,
				'target_guid' => $entity->container_guid,
				'access_id' => $entity->access_id,
				'posted' => $entity->time_created,
			]);
			
			$entity->save();
			
			$this->advance();
		}
		
		if ($logged_in) {
			$session_manager->setLoggedInUser($logged_in);
		} else {
			$session_manager->removeLoggedInUser();
		}
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function unseed() {
		/* @var $entities \ElggBatch */
		$entities = elgg_get_entities([
			'type' => 'object',
			'subtype' => \Poll::SUBTYPE,
			'metadata_name' => '__faker',
			'limit' => false,
			'batch' => true,
			'batch_inc_offset' => false,
		]);
		
		/* @var $entity \Poll */
		foreach ($entities as $entity) {
			if ($entity->delete()) {
				$this->log("Deleted poll {$entity->guid}");
			} else {
				$this->log("Failed to delete poll {$entity->guid}");
			}
			
			$this->advance();
		}
	}
	
	/**
	 * {@inheritDoc}
	 */
	public static function getType(): string {
		return \Poll::SUBTYPE;
	}
	
	/**
	 * {@inheritDoc}
	 */
	protected function getCountOptions(): array {
		return [
			'type' => 'object',
			'subtype' => \Poll::SUBTYPE,
		];
	}
	
	/**
	 * Create a random number of answers for the Poll
	 *
	 * @param \Poll $entity the poll to add the answers to
	 *
	 * @return int
	 */
	protected function createAnswers(\Poll $entity): int {
		$max_answers = $this->faker->numberBetween(2, 5);
		$answers = [];
		for ($i = 0; $i < $max_answers; $i++) {
			$answers[] = [
				'name' => 'answer_' . $this->faker()->unixTime() . $this->faker()->numberBetween(0, 1000),
				'label' => $this->faker()->sentence(4),
			];
		}
		
		$entity->answers = json_encode($answers);
		
		return count($answers);
	}
	
	/**
	 * Create a random number of votes for a poll
	 *
	 * @param \Poll $entity the poll
	 *
	 * @return int
	 */
	protected function createVotes(\Poll $entity): int {
		$max_votes = $this->faker()->numberBetween(1, 20);
		$votes = 0;
		$answers = $entity->getAnswersOptions();
		$already_voted = [];
		
		for ($i = 0; $i < $max_votes; $i++) {
			$voter = $this->getRandomUser($already_voted);
			
			$vote_key = array_rand($answers);
			$entity->vote($answers[$vote_key], $voter->guid);
			$already_voted[] = $voter->guid;
			
			// backdate the vote
			/* @var $vote \ElggAnnotation */
			$vote = $entity->getVote(false, $voter->guid);
			
			$vote_closed = $entity->close_date ?? time();
			$seeder_max_time = $this->create_until ?? time();
			
			$max_vote_time = min($vote_closed, $seeder_max_time);
			$vote_time = $this->faker()->numberBetween($entity->time_created, $max_vote_time);
			
			$update_vote = Update::table('annotations');
			$update_vote->set('time_created', $update_vote->param($vote_time, ELGG_VALUE_TIMESTAMP))
				->where($update_vote->compare('id', '=', $vote->id, ELGG_VALUE_ID));
			
			elgg()->db->updateData($update_vote);
			
			// backdate vote river item
			$river = elgg_get_river([
				'limit' => 1,
				'annotation_id' => $vote->id,
				'action_type' => 'vote',
				'object_guid' => $entity->guid,
			]);
			if (!empty($river)) {
				/* @var $river \ElggRiverItem */
				$river = $river[0];
				
				$update_river = Update::table('river');
				$update_river->set('posted', $update_river->param($vote_time, ELGG_VALUE_TIMESTAMP))
					->set('last_action', $update_river->param($vote_time, ELGG_VALUE_TIMESTAMP))
					->where($update_river->compare('id', '=', $river->id, ELGG_VALUE_ID));
				
				elgg()->db->updateData($update_river);
			}
		}
		
		return $votes;
	}
}

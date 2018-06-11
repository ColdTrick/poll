<?php

namespace ColdTrick\Poll;

class MenuHandler {
	
	/**
	 * Add a menu item to the site menu
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function siteMenu($hook, $type, $return_value, $params) {
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'poll',
			'text' => elgg_echo('poll:menu:site'),
			'href' => 'poll/all',
			'icon' => 'chart-pie',
		]);
		
		return $return_value;
	}
	
	/**
	 * Add a menu item to user owner block menu
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function userOwnerBlock($hook, $type, $return_value, $params) {
		
		if (empty($params) || !is_array($params)) {
			return;
		}
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \ElggUser)) {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'poll',
			'text' => elgg_echo('poll:menu:site'),
			'href' => "poll/owner/{$entity->username}",
			'icon' => 'chart-pie',
		]);
		
		return $return_value;
	}
	
	/**
	 * Add a menu item to group owner block menu
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function groupOwnerBlock($hook, $type, $return_value, $params) {
		
		if (empty($params) || !is_array($params)) {
			return;
		}
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \ElggGroup)) {
			return;
		}
		
		if (!poll_is_enabled_for_group($entity)) {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'poll',
			'text' => elgg_echo('poll:menu:owner_block:group'),
			'href' => "poll/group/{$entity->getGUID()}/all",
			'icon' => 'chart-pie',
		]);
		
		return $return_value;
	}
	
	/**
	 * Add a menu item to poll tabs
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function pollTabs($hook, $type, $return_value, $params) {
		
		if (empty($params) || !is_array($params)) {
			return;
		}
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \Poll)) {
			return;
		}
		
		if ($entity->canVote()) {
			$return_value[] = \ElggMenuItem::factory([
				'name' => 'vote_form',
				'text' => elgg_echo('poll:menu:poll_tabs:vote'),
				'href' => '#',
				'selected' => (bool) !$entity->getVote(),
				'data-toggle-selector' => '#poll-vote-form',
			]);
		}
		
		if ($entity->getVotes()) {
			$selected = !$entity->canVote() || (bool) $entity->getVote();
			
			$return_value[] = \ElggMenuItem::factory([
				'name' => 'results',
				'text' => elgg_echo('poll:menu:poll_tabs:results'),
				'href' => '#',
				'selected' => $selected,
				'data-toggle-selector' => '#poll-result-chart-wrapper',
				'data-is-chart' => true,
			]);
		}
		
		return $return_value;
	}
	
	/**
	 * Add a menu item to poll entity menu
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function entityMenu($hook, $type, $return_value, $params) {
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \Poll) || !$entity->canEdit()) {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'export',
			'icon' => 'download',
			'text' => elgg_echo('export'),
			'href' => elgg_http_add_url_query_elements('action/poll/export', [
				'guid' => $entity->guid,
			]),
			'is_action' => true,
		]);
		
		return $return_value;
	}
}

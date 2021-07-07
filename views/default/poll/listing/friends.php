<?php
/**
 * Show a listing of Polls from friends
 *
 * @uses $vars['entity'] the entity to show friends polls for
 * @uses $vars['options'] additional options for the listing
 */

$entity = elgg_extract('entity', $vars);

$options = (array) elgg_extract('options', $vars, []);

$options['relationship'] = 'friend';
$options['relationship_guid'] = $entity->guid;
$options['relationship_join_on'] = 'owner_guid';

$vars['options'] = $options;

echo elgg_view('poll/listing/all', $vars);

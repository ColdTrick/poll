<?php
/**
 * Show a listing of Polls in a group
 *
 * @uses $vars['entity'] the group to show polls for
 * @uses $vars['options'] additional options for the listing
 */

$entity = elgg_extract('entity', $vars);

$options = (array) elgg_extract('options', $vars, []);

$options['container_guid'] = $entity->guid;
$options['preload_containers'] = false;

$vars['options'] = $options;

echo elgg_view('poll/listing/all', $vars);

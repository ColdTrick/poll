<?php
/**
 * Show a listing of Polls from an owner
 *
 * @uses $vars['entity'] the owner to show polls for
 * @uses $vars['options'] additional options for the listing
 */

$entity = elgg_extract('entity', $vars);

$options = (array) elgg_extract('options', $vars, []);

$options['owner_guid'] = $entity->guid;
$options['preload_owners'] = false;

$vars['options'] = $options;

echo elgg_view('poll/listing/all', $vars);

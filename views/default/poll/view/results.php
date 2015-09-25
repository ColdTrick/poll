<?php

$entity = elgg_extract('entity', $vars);
if (!($entity instanceof Poll)) {
	return;
}

$results = $entity->getVotes();
var_dump($results);

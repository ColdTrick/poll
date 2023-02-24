<?php

$item = elgg_extract('item', $vars);
if (!$item instanceof \ElggRiverItem) {
	return;
}

$entity = $item->getObjectEntity();
if (!$entity instanceof \Poll) {
	return;
}

$vars['message'] = elgg_get_excerpt($entity->description);

echo elgg_view('river/elements/layout', $vars);

<?php

$guid = (int) get_input('guid');
$entity = get_entity($guid);
if (!$entity instanceof Poll) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

if (!$entity->canEdit()) {
	return elgg_error_response(elgg_echo('actionunauthorized'));
}

$votes = $entity->getVotes();
if (empty($votes)) {
	return elgg_error_response(elgg_echo('poll:action:export:error:no_votes'));
}

$temp_file = new ElggTempFile();
$tmp_file = $temp_file->open('write');

fputcsv($tmp_file, [
	elgg_echo('poll:edit:answers'),
	elgg_echo('total'),
], ';', '"');

foreach ($votes as $vote) {
	fputcsv($tmp_file, [
		elgg_extract('full_label', $vote),
		elgg_extract('value', $vote),
	], ';', '"');
}

$temp_file->close();

$content = $temp_file->grabFile();
$temp_file->delete();

$filename = 'poll-results-' . elgg_get_friendly_title($entity->getDisplayName()) . '-' .  date('Y-m-d-Hi') . '.csv';

header('Content-Type: text/csv');
header('Content-Disposition: Attachment; filename="' . $filename . '"');
header('Content-Length: ' . strlen($content));
header('Pragma: public');

echo $content;

exit();

<?php

if (elgg_get_plugin_setting('enable_site', 'poll', 'no') === 'no') {
	$vars['add_users'] = false;
}
if (elgg_get_plugin_setting('enable_group', 'poll', 'no') === 'no') {
	$vars['add_groups'] = false;
}

echo elgg_view('input/entity_tools_container', $vars);

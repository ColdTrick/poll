<?php

return [
	
	'item:object:poll' => 'Poll',
	'river:create:object:default' => "%s created a new poll %s",
	'river:vote:object:default' => "%s voted on the poll %s",
	
	// settings
	'poll:settings:enable_site' => "Enable polls for site",
	'poll:settings:enable_site:info' => "Are users allowed to create personal polls?",
	'poll:settings:enable_group' => "Enable polls for groups",
	'poll:settings:enable_group:info' => "Are users allowed to create polls in groups? Groups still have to enable this feature if they wish to use it.",
	
	'poll:none' => "No polls found",
	'poll:group' => "Group polls",
	'poll:add' => "Add a new poll",
	
	'poll:all:title' => "All site polls",
	'poll:owner:title' => "%s's polls",
	'poll:friends:title' => "Friends' polls",
	'poll:edit:title' => "Edit poll \"%s\"",
	'poll:edit:answers' => "Answers",
	'poll:edit:answers:name' => "Name",
	'poll:edit:answers:label' => "Label",
	'poll:edit:close_date' => "Close date (optional)",
	'poll:edit:error:cant_edit' => "You're not allowed to edit this poll",
	
	'poll:vote:title' => "Vote for this poll",
	'poll:vote' => "Vote",
	
	'poll:menu:site' => "Polls",
	'poll:menu:owner_block:group' => "Group polls",
	'poll:menu:poll_tabs:vote' => "Vote",
	'poll:menu:poll_tabs:pie' => "Results pie-chart",
	'poll:menu:poll_tabs:bar' => "Results bar-chart",
	
	'poll:group_tool:title' => "Enable group polls",
	'poll:group_settings:title' => "Poll group member settings",
	'poll:group_settings:members' => "Allow group members to create polls",
	'poll:group_settings:members:description' => "When this setting is set to 'no', only group owners/admins can create polls in this group.",
	
	// widgets
	'poll:widgets:single_poll:title' => "Featured poll",
	'poll:widgets:single_poll:description' => "Show a single poll",
	'poll:widgets:single_poll:poll_guid' => "Enter the guid of the poll that should be shown in the widget",
	'poll:widgets:single_poll:misconfigured' => "You need to configure this widget",
	
	'poll:widgets:recent_polls:title' => "Recent polls",
	'poll:widgets:recent_polls:description' => "Show a list of the recently created polls",
	
	'poll:container_gatekeeper:user' => "Poll is not enabled for personal use",
	'poll:container_gatekeeper:group' => "Poll is not enabled for use in groups",
	
	// notifications
	'poll:notification:create:subject' => "A new poll \"%s\" was created",
	'poll:notification:create:summary' => "New poll \"%s\"",
	'poll:notification:create:body' => "Hi,

%s created a new poll \"%s\".

%s

To view the poll click the link:
%s",
	
	// actions
	'poll:action:edit:error:title' => "Please provide a title",
	
	'poll:action:vote:error:input' => "You need to choose an answer",
	'poll:action:vote:error:can_vote' => "You're not allowed to vote on this poll",
	'poll:action:vote:error:vote' => "An error occured while saving your vote",
	'poll:action:vote:success' => "Your vote was saved",
];

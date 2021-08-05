<?php

return [
	
	'item:object:poll' => 'Poll',
	'collection:object:poll' => 'Polls',
	'river:object:poll:create' => "%s created a new poll %s",
	'river:object:poll:vote' => "%s voted on the poll %s",
	'river:object:poll:comment' => "%s commented on the poll %s",
	'add:object:poll' => "Add a new poll",
	'notification:object:poll:create' => 'Send a notification when a poll is created',
	
	// settings
	'poll:settings:enable_site' => "Enable polls for site",
	'poll:settings:enable_site:info' => "Are users allowed to create personal polls?",
	'poll:settings:enable_group' => "Enable polls for groups",
	'poll:settings:enable_group:info' => "Are users allowed to create polls in groups? Groups still have to enable this feature if they wish to use it.",
	'poll:settings:group_create' => "By default, who can create polls in a group?",
	'poll:settings:group_create:info' => "When enabling group polls, this setting will control who can create the polls by default. Group owners can configure otherwise.",
	'poll:settings:group_create:options:members' => "Group members",
	'poll:settings:group_create:options:owners' => "Group owners",
	'poll:settings:close_date_required' => "Close date required?",
	'poll:settings:close_date_required:info' => "By default a close date is not required for a poll. This setting will make it required.",
	'poll:settings:vote_change_allowed' => "Is it allowed to change your vote?",
	'poll:settings:vote_change_allowed:info' => "This settings allows users to change their vote after they have voted.",
	'poll:settings:add_vote_to_river' => "Add poll vote activity to the river",
	'poll:settings:add_vote_to_river:info' => "This settings determines if voting on a poll is added to the activity stream.",
	
	'poll:none' => "No polls found",
	'poll:group' => "Group polls",
	
	'poll:all:title' => "All site polls",
	'poll:owner:title' => "%s's polls",
	'poll:friends:title' => "Friends' polls",
	'poll:edit:title' => "Edit poll \"%s\"",
	'poll:edit:answers' => "Answers",
	'poll:edit:answers:name' => "Name",
	'poll:edit:answers:label' => "Label",
	'poll:edit:answers:show_internal_names' => "Show internal names",
	'poll:edit:close_date' => "Close date",
	'poll:edit:results_output' => "Show poll results as",
	'poll:edit:results_output:pie' => "pie chart",
	'poll:edit:results_output:bar' => "bar chart",
	'poll:edit:error:cant_edit' => "You're not allowed to edit this poll",
	'poll:edit:error:answer_count' => "You need at least two answers when creating a poll",
	
	'poll:closed' => "This poll is closed since:",
	'poll:closed:future' => "Poll closes:",
	'poll:no_votes' => "No vote has been cast yet",
	'poll:vote:title' => "Vote for this poll",
	'poll:vote' => "Vote",
	
	'poll:menu:site' => "Polls",
	'poll:menu:owner_block:group' => "Group polls",
	'poll:menu:poll_tabs:vote' => "Vote",
	'poll:menu:poll_tabs:results' => "Results",
	
	'poll:group_tool:title' => "Enable group polls",
	'poll:group_settings:title' => "Poll group member settings",
	'poll:group_settings:members' => "Allow group members to create polls",
	'poll:group_settings:members:description' => "When this setting is set to 'no', only group owners/admins can create polls in this group.",
	
	// widgets
	'widgets:single_poll:name' => "Featured poll",
	'widgets:single_poll:description' => "Show a single poll",
	'poll:widgets:single_poll:poll_guid:object' => "Enter the poll title and select from the list",
	
	'widgets:recent_polls:name' => "Recent polls",
	'widgets:recent_polls:description' => "Show a list of the recently created polls",
	
	'poll:container_gatekeeper:user' => "Poll is not enabled for personal use",
	'poll:container_gatekeeper:group' => "Poll is not enabled for use in groups",
	
	// notifications
	'poll:notification:create:subject' => "A new poll \"%s\" was created",
	'poll:notification:create:summary' => "New poll \"%s\"",
	'poll:notification:create:body' => "%s created a new poll \"%s\".

%s

To view the poll click the link:
%s",

	'poll:notification:close:owner:subject' => "Your poll \"%s\" is now closed",
	'poll:notification:close:owner:summary' => "Your poll \"%s\" is now closed",
	'poll:notification:close:owner:body' => "Your poll \"%s\" is now closed. Users can no longer vote.

To view the results check out the poll here:
%s",
	
	'poll:notification:close:participant:subject' => "The poll \"%s\" you voted on is closed",
	'poll:notification:close:participant:summary' => "The poll \"%s\" you voted on is closed",
	'poll:notification:close:participant:body' => "The poll \"%s\" you voted on is now closed.

To view the results check out the poll here:
%s",
	
	// actions
	'poll:action:edit:error:title' => "Please provide a title",
	
	'poll:action:vote:error:input' => "You need to choose an answer",
	'poll:action:vote:error:can_vote' => "You're not allowed to vote on this poll",
	'poll:action:vote:error:vote' => "An error occured while saving your vote",
	'poll:action:vote:success' => "Your vote was saved",
	
	'poll:action:export:error:no_votes' => "No votes available to export",
];

<?php
/**
 * All helper functions are bundled here
 */

/**
 * Get a plugin setting
 *
 * @param string $setting the name of the setting to get
 *
 * @return mixed
 */
function poll_get_plugin_setting($setting) {
	static $settings;
	
	if (!isset($settings)) {
		$defaults = [
			'enable_site' => 'no',
			'enable_group' => 'no',
		];
		
		$plugin = elgg_get_plugin_from_id('poll');
		$plugin_settings = $plugin->getAllSettings();
		
		$settings = array_merge($defaults, $plugin_settings);
	}
	
	return elgg_extract($setting, $settings);
}

/**
 * Gatekeeper function to check if poll is enabled
 *
 * @param ElggEntity $container the container to check for (defaults to page_owner)
 */
function poll_container_gatekeeper(ElggEntity $container = null) {
	
	if (empty($container)) {
		$container = elgg_get_page_owner_entity();
	}
	
	if (poll_is_enabled_for_container($container)) {
		return;
	}
	
	if ($container instanceof ElggUser) {
		register_error(elgg_echo('poll:container_gatekeeper:user'));
	} elseif ($container instanceof ElggGroup) {
		register_error(elgg_echo('poll:container_gatekeeper:group'));
	}
	
	forward(REFERER);
}

/**
 * Check if poll is enabled for a container
 *
 * @param ElggEntity $container the container entity to check
 *
 * @return bool
 */
function poll_is_enabled_for_container(ElggEntity $container) {
	
	if ($container instanceof ElggUser) {
		if (poll_get_plugin_setting('enable_site') === 'yes') {
			return true;
		}
	} elseif ($container instanceof ElggGroup) {
		if (poll_is_enabled_for_group($container)) {
			return true;
		}
	}
	
	return false;
}

/**
 * Check if poll is enabled for groups
 *
 * @param ElggGroup $group (optional) the group to check for
 *
 * @return bool
 */
function poll_is_enabled_for_group(ElggGroup $group = null) {
	
	if (poll_get_plugin_setting('enable_group') === 'no') {
		return false;
	}
	
	if (!($group instanceof ElggGroup)) {
		return true;
	}
	
	if ($group->poll_enable === 'yes') {
		return true;
	}
	
	return false;
}

/**
 * Prepare form values for add/edit poll
 *
 * @param Poll $entity (optional) the entity to edit
 *
 * @return array
 */
function poll_prepare_form_vars(Poll $entity = null) {
	
	$values = [
		'title' => null,
		'description' => null,
		'access_id' => null,
		'tags' => null,
		'guid' => null,
		'answers' => null,
		'container_guid' => elgg_get_page_owner_guid(),
		'comments_allowed' => 'no',
	];
	
	// edit form
	if ($entity instanceof Poll) {
		foreach ($values as $key => $value) {
			$values[$key] = $entity->$key;
		}
		
		if (!empty($values['answers'])) {
			$values['answers'] = json_decode($values['answers'], true);
		}
		
		$values['entity'] = $entity;
	}
	
	// sticky form values
	if (elgg_is_sticky_form('poll')) {
		$sticky_values = elgg_get_sticky_values('poll');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
		
		elgg_clear_sticky_form('poll');
	}
	
	return $values;
}
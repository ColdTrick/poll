<?php
/**
 * All helper functions are bundled here
 */

/**
 * Check if poll is enabled for a container
 *
 * @param \ElggEntity $container the container entity to check
 *
 * @return bool
 */
function poll_is_enabled_for_container(\ElggEntity $container): bool {
	if ($container instanceof \ElggUser) {
		if (elgg_get_plugin_setting('enable_site', 'poll') === 'yes') {
			return true;
		}
	} elseif ($container instanceof \ElggGroup) {
		if (poll_is_enabled_for_group($container)) {
			return true;
		}
	}
	
	return false;
}

/**
 * Check if poll is enabled for groups
 *
 * @param \ElggGroup $group (optional) the group to check for
 *
 * @return bool
 */
function poll_is_enabled_for_group(\ElggGroup $group = null): bool {
	if (elgg_get_plugin_setting('enable_group', 'poll') === 'no') {
		return false;
	}
	
	if (!$group instanceof \ElggGroup) {
		return true;
	}
	
	return $group->isToolEnabled('poll');
}

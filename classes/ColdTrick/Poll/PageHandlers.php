<?php

namespace ColdTrick\Poll;

class PageHandlers {
	
	/**
	 * /poll page handler
	 *
	 * @param array $page url segments
	 *
	 * @return bool
	 */
	public static function pollHandler($page) {
		
		$pages_root = elgg_get_plugins_path() . 'poll/pages/';
		$include_file = false;
		
		switch ($page[0]) {
			case 'add':
				$include_file = "{$pages_root}poll/add.php";
				break;
			case 'view':
				if (isset($page[1]) && is_numeric($page[1])) {
					set_input('guid', $page[1]);
				}
				$include_file = "{$pages_root}poll/view.php";
				break;
			case 'all':
				$include_file = "{$pages_root}poll/all.php";
				break;
			case 'owner':
				$include_file = "{$pages_root}poll/owner.php";
				break;
			case 'friends':
				$include_file = "{$pages_root}poll/friends.php";
				break;
			case 'group':
				if (isset($page[1]) && is_numeric($page[1])) {
					elgg_set_page_owner_guid($page[1]);
				}
				$include_file = "{$pages_root}poll/owner.php";
				break;
			case 'edit':
				if (isset($page[1]) && is_numeric($page[1])) {
					set_input('guid', $page[1]);
				}
				$include_file = "{$pages_root}poll/edit.php";
				break;
			default:
				forward('poll/all');
				break;
		}
		
		if (!empty($include_file)) {
			elgg_push_breadcrumb(elgg_echo('poll:menu:site'), 'poll/all');
			
			include($include_file);
			return true;
		}
		
		return false;
	}
}

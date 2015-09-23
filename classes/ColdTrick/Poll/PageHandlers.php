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
		}
		
		if (!empty($include_file)) {
			include($include_file);
			return true;
		}
		
		return false;
	}
}

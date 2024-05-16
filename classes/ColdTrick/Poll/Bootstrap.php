<?php

namespace ColdTrick\Poll;

use Elgg\DefaultPluginBootstrap;

/**
 * Plugin bootstrap
 */
class Bootstrap extends DefaultPluginBootstrap {
	
	/**
	 * {@inheritdoc}
	 */
	public function init() {
		elgg_register_esm('chart.js', elgg_get_simplecache_url('chart.js/chart.umd.js'));
	}
}

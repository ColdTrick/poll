<?php

namespace ColdTrick\Poll\Middleware;

use Elgg\HttpException;
use Elgg\Request;
use Elgg\GatekeeperException;

/**
 * Protects a route from non-authenticated users
 */
class ContainerGatekeeper extends \Elgg\Router\Middleware\Gatekeeper {

	/**
	 * Gatekeeper
	 *
	 * @param Request $request Request
	 *
	 * @return void
	 * @throws HttpException
	 */
	public function __invoke(Request $request) {
		
		parent::__invoke($request);
		
		$container = elgg_get_page_owner_entity();
		
		if (poll_is_enabled_for_container($container)) {
			return;
		}
		
		if ($container instanceof \ElggUser) {
			throw new GatekeeperException(elgg_echo('poll:container_gatekeeper:user'));
		} elseif ($container instanceof \ElggGroup) {
			throw new GatekeeperException(elgg_echo('poll:container_gatekeeper:group'));
		}
	}
}

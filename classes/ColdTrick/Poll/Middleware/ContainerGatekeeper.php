<?php

namespace ColdTrick\Poll\Middleware;

use Elgg\HttpException;
use Elgg\Request;

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
		
		if ($container instanceof ElggUser) {
			register_error(elgg_echo('poll:container_gatekeeper:user'));
		} elseif ($container instanceof ElggGroup) {
			register_error(elgg_echo('poll:container_gatekeeper:group'));
		}
		
		forward(REFERER);
	}
}

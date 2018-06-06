<?php

namespace App;

use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;

class RouterFactory
{

    /**
     * Vytváří router pro aplikaci.
     * @return RouteList výsledný router pro aplikaci
     */
	public static function createRouter()
	{
		$router = new RouteList;

        $router[] = new Route('timer/', 'Track:Timer:default');
        $router[] = new Route('projects/', 'Track:Projects:default');
        $router[] = new Route('requests/', 'Track:Requests:default');
        $router[] = new Route('stats/', 'Track:Stats:default');
        $router[] = new Route('login/', 'Track:Login:default');
        $router[] = new Route('register/', 'Track:Login:register');

        $router[] = new Route('<presenter=Projects>/<action=default>/<id=>', ['module' => 'Track'] );

        $router[] = new Route('<presenter>/<action>[/<id>]', ':Track:Login:default');
/**
        $router[] = new Route('<presenter>/<action>[/<id>]', 'Track:Timer:default');

*/
		return $router;
	}
}

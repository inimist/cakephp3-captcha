<?php
/**
 * Helper for the use of Captcha
 * @author     Arvind Kumar
 * @link       http://inimist.com/
 * @copyright  Copyright © 2014 http://inimist.com/
 * @version 3.0 - Tested with Cakephp 3.5.x
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\Router;

Router::defaultRouteClass(DashedRoute::class);

Router::plugin(
    'Captcha',
    ['path' => '/'],
    function ($routes) {
        $routes->connect('/create-captcha', ['controller' => 'Captcha', 'action' => 'create']);
    }
);
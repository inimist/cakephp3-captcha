<?php
/**
 * captcha/src/routes.php
 * @author     Arvind Kumar
 * @link       https://captcha.inimisttech.com
 * @copyright  Copyright © 2019 https://inimisttech.com
 * @version 1.1 - Tested with Cakephp 3.8.x
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
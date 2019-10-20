<?php
/**
 * captcha/src/routes.php
 * @author     Arvind Kumar
 * @link       https://captcha.inimisttech.com
 * @copyright  Copyright © 2019 https://inimisttech.com
 * @version 1.2 - Tested with Cakephp 3.8.x
 */

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'Captcha',
    ['path' => '/'],
    function (RouteBuilder $routes) {
        $routes->connect('/create-captcha', ['controller' => 'Captcha', 'action' => 'create']);
    }
);
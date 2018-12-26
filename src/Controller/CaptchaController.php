<?php
/**
 * Controller for the use of Captcha
 * @author     Arvind K.
 * @link       http://inimisttech.com/
 * @copyright  Copyright © 2018 http://inimisttech.com/
 * @License  MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @version 1.0 - Tested with Cakephp 3.6
 */

namespace Captcha\Controller;

use Captcha\Controller\AppController;

/**
 * Captcha Controller
 *
 */
class CaptchaController extends AppController
{
    public function initialize()
    {
      parent::initialize();
      //$this->loadComponent('Captcha.Captcha');
    }
    public function beforeFilter(\Cake\Event\Event $event)
    {
        if(isset($this->Auth) && is_object($this->Auth)) $this->Auth->allow(['create']);
    }
    function create()	{
        $this->autoRender = false;
        $this->loadComponent('Captcha.Captcha'); //or load on the fly!
        $this->viewBuilder()->setLayout('ajax');
        $this->Captcha->create();
    }
}

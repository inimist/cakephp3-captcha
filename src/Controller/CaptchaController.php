<?php
/**
 * captcha/src/Controller/CaptchaController.php
 * @author     Arvind Kumar
 * @link       https://captcha.inimisttech.com
 * @copyright  Copyright © 2019 https://inimisttech.com
 * @version 1.1 - Tested with Cakephp 3.8.x
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
        $this->loadComponent('Captcha.Captcha'); //or load on the fly!
        $this->viewBuilder()->setLayout('ajax');
        $data = $this->Captcha->generate();
        if(!$data['error'])
        {
            return $this->response->withType('jpg')->withStringBody($data['data']);
        }
        //set error
    }
}

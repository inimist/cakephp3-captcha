<?php
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
      $this->loadComponent('Captcha.Captcha');
    }
    public function beforeFilter(\Cake\Event\Event $event)
    {
        if(is_object($this->Auth)) $this->Auth->allow(['create']);
    }
    function create()	{
        $this->autoRender = false;
        //$this->loadComponent('Captcha'); //or load on the fly!
        $this->viewBuilder()->layout('ajax');
        $this->Captcha->create();
    }
    public function add()
    {
    }
}

<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        //$this->loadComponent('Captcha.Captcha');
    }
    public function beforeFilter(\Cake\Event\Event $event)
    {
        //if(is_object($this->Auth)) $this->Auth->allow(['add', 'captcha']);
    }
    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        $this->loadComponent('Captcha.Captcha'); //load on the fly!
        if ($this->request->is('post')) {
            $this->Users->setCaptcha('securitycode', $this->Captcha->getCode('securitycode'));
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }
}

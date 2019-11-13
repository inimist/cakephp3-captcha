<?php
/**
 * captcha/src/View/Helper/CaptchaHelper.php
 * @author     Arvind Kumar
 * @link       https://captcha.inimisttech.com
 * @copyright  Copyright © 2019 https://inimisttech.com
 * @version 1.1 - Tested with Cakephp 3.8.x
 */

namespace Captcha\View\Helper;

use Cake\Core\Configure;
use Cake\View\Helper;
use Cake\View\View;

class CaptchaHelper extends Helper {

/**
 * helpers
 *
 * @var array
 */

  public $helpers = ['Html', 'Form'];

    /*protected $_captchaConfig = [
        'plugin'=>'Captcha',
        'controller'=>'Captcha',
        'action'=>'create',
    ];*/

    protected $_defaultConfig = [
        'type'=>'image',
        'theme'=>'default',
        'width'=>120,
        'height'=>40,
        'length'=>6
    ];

    protected $errors = null;

    protected function setErrror($error)  {
        $this->errors[] = $error;
    }

/**
 * Constructor
 *
 * ### Settings:
 *
 * - Get settings set from Component.
 *
 * @param View $View the view object the helper is attached to.
 * @param array $config Settings array Settings array
 */
    public function __construct(View $View, $config = []) {
        //$this->setConfig(Configure::read('Recaptcha'));
        $this->View = $View;
        parent::__construct($View, $config);
    }

    function create($field='captcha', $config=array()) {
        //debug($config);
        // Merge Options given by user in config/recaptcha
        
        $this->setConfig(Configure::read('Captcha'));
        $this->setConfig( $config );

        if( !$this->isValidConfig())    {
            throw new \Exception(__d('captcha', 'Invalid or missing captcha config value'));
        }

        $html = '';

        $this->_config = $this->getConfig();
	      $this->_config['width'] = ($this->_config['width'] > 500) ? 500 : $this->_config['width'];
	    
	      $this->_config['height'] = ($this->_config['height'] > 500) ? 500 : $this->_config['height'];

        $this->_config['reload_txt'] = isset( $this->_config['reload_txt']) ? __($this->_config['reload_txt']) : __('Can\'t read? Reload');

        $this->_config['clabel'] = isset( $this->_config['clabel']) ? __($this->_config['clabel']) : __('Enter security code shown above:');

        $this->_config['mlabel'] = isset( $this->_config['mlabel']) ? __($this->_config['mlabel']) : __('Answer Simple Math');

        $plugin = $this->_config['plugin'];
        $controller = ucfirst( $this->_config['controller']);
        //debug($controller);exit;
        $action =  $this->_config['action'];
        $qstring = array(
            'type' =>   $this->_config['type'],
            'field' =>  $field
        );

        switch( $this->_config['type']):
            case 'image':

                $qstring = array_merge($qstring, array(
                    'width' =>  $this->_config['width'],
                    'height'=>  $this->_config['height'],
                    'theme' =>  $this->_config['theme'],
                    'length' => $this->_config['length'],
                ));

                $html .= $this->Html->image(array('plugin'=>$plugin, 'controller'=>$controller, 'action'=>$action, '?'=> $qstring), array('hspace'=>2));
                $html .= $this->Html->link( $this->_config['reload_txt'], '#', array('class' => 'creload', 'escape' => false));
                $html .= $this->Form->control($field, array('autocomplete'=>'off','label'=> $this->_config['clabel'],'class'=>'clabel'));
            break;
            case 'math':
                $qstring = array_merge($qstring, array('type'=>'math'));
                /*if(isset($this->_config['stringOperation']))   {
                    $html .= $this->_config['mlabel'] .  $this->_config['stringOperation'].' = ?';
                }   else    {
                    ob_start();
					//pr(array('plugin'=>$plugin, 'controller'=>$controller, 'action'=>$action, '?'=> $qstring));
                    @$this->View->requestAction(array('plugin'=>$plugin, 'controller'=>$controller, 'action'=>$action, '?'=> $qstring));
                    $mathstring = ob_get_contents();
                    ob_end_clean();
                }*/
                $errorclass='';
                if($this->Form->isFieldError($field)) $errorclass = 'error';
                $html .= '<div class="input text required '.$errorclass.'">' . $this->Form->label($field, $this->_config['mlabel']) . '</div>';
                $html .= $this->Html->image(array('plugin'=>$plugin, 'controller'=>$controller, 'action'=>$action, '?'=> $qstring), array('hspace'=>2));
                //$html .= '<div><strong>' . $mathstring . '</strong>' . ' = ?</div>';
                $html .= $this->Form->control($field, array('autocomplete'=>'off','label'=>false,'class'=>''));
            break;
            case 'recaptcha':
                if(!isset($this->_config['sitekey']) OR empty($this->_config['sitekey']))	{
                    $html .= sprintf('<div class="captcha-error">%s</div>', __('Missing Repatcha Site Key'));
                }	else	{
                    $html .= $this->Form->control($field, array('value'=>'grecaptcha', 'label'=>__('Human Check'), 'style'=>'visibility:hidden;margin:0;padding:0;height:0;'));
                    $html .= '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
                    $html .= '<div class="g-recaptcha" data-sitekey="'.$this->_config['sitekey'].'"></div>';
                }
            break;
        endswitch;

        return $html;
    }

    function isValidConfig()    {
        $config = $this->getConfig();
        if( $config['type'] == 'recaptcha' )  {
            if(!isset($config['sitekey']) OR empty($config['sitekey'])) {
                $this->setErrror('Invalid sitekey for recaptcha'); 
                return false;
            }
            if(!isset($config['secret']) OR empty($config['secret'])) {
                $this->setErrror('Invalid secret for recaptcha'); 
                return false;
            }
        }
        //debug($config);
        return true;
    }
}

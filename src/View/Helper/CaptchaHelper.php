<?php
/**
 * Helper for the use of Captcha
 * @author     Arvind Kumar
 * @link       http://inimisttech.com/
 * @copyright  Copyright © 2014 http://inimisttech.com/
 * @version 3.0 - Tested with Cakephp 3.5.x
 */

namespace Captcha\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

class CaptchaHelper extends Helper {

/**
 * helpers
 *
 * @var array
 */

  public $helpers = ['Html', 'Form'];

    protected $_defaultConfig = [
        'type'=>'image',
        'theme'=>'default',
        'sitekey'=>'xxxxxxxxxxxxxxxxxxxxxx-xx', //add sitekey if it is Google Recaptcha
        'plugin'=>'Captcha',
        'controller'=>'Captcha',
        'action'=>'create',
        'width'=>120,
        'height'=>40,
        'length'=>6
        
    ];

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
        $this->View = $View;
        parent::__construct($View, $config);
    }

    function create($field='captcha', $config=array()) {

        $html = '';

        $this->_config = array_merge($this->_config, (array)$config);

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
                $html .= $this->Form->input($field, array('autocomplete'=>'off','label'=> $this->_config['clabel'],'class'=>'clabel'));
            break;
            case 'math':
                $qstring = array_merge($qstring, array('type'=>'math'));
                if(isset($this->_config['stringOperation']))   {
                    $html .= $this->_config['mlabel'] .  $this->_config['stringOperation'].' = ?';
                }   else    {
                    ob_start();
                    $this->View->requestAction(array('plugin'=>$plugin, 'controller'=>$controller, 'action'=>$action, '?'=> $qstring));
                    $mathstring = ob_get_contents();
                    ob_end_clean();
                }
                $errorclass='';
                if($this->Form->isFieldError($field)) $errorclass = 'error';
                $html .= '<div class="input text required '.$errorclass.'">' . $this->Form->label($field, $this->_config['mlabel']) . '</div>';
                $html .= '<div><strong>' . $mathstring . '</strong>' . ' = ?</div>';
                $html .= $this->Form->input($field, array('autocomplete'=>'off','label'=>false,'class'=>''));
            break;
            case 'recaptcha':
                if(!isset($this->_config['sitekey']) OR empty($this->_config['sitekey']))	{
                    $html .= sprintf('<div class="captcha-error">%s</div>', __('Missing Repatcha Site Key'));
                }	else	{
                    $html .= $this->Form->input($field, array('value'=>'grecaptcha', 'label'=>__('Human Check'), 'style'=>'visibility:hidden;margin:0;padding:0;height:0;'));
                    $html .= '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
                    $html .= '<div class="g-recaptcha" data-sitekey="'.$this->_config['sitekey'].'"></div>';
                }
            break;
        endswitch;

        return $html;
    }
}

<?php
/**
 * Captcha Behavior
 *
 * Behavior to handles Captcha verification
 *
 * PHP version 5+ and CakePHP version 2.6+
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the copyright notice.
 *
 * @category    Behavior
 * @version     1.2
 * @author      Arvind Kumar <arvind.mailto@gmail.com>
 * @copyright   Copyright (C) Arvind Kumar
 * @license     MIT License (http://www.opensource.org/licenses/mit-license.php)
 *
 * Version history
 *
 * 2014-09-08  Initial version
 * 2014-12-27  Add configuration settings
 *
 */
namespace Captcha\ORM\Behavior;

use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\Validation\Validator;

class CaptchaBehavior extends Behavior
{

	protected $_defaultConfig = [
		'field' => 'captcha',
		'message' => 'Captcha validation failed',
		'secret'=>'6LduQEIUAAAAAMnyTuphvophucpjtr0DN62gS1yL',
	];

	private $captcha = null;

	/**
	 * Custom rule to validate captcha value
	 *
	 */
	public function validateCaptcha($value, array $context) {
		if(isset($context['data']['g-recaptcha-response']))	{
			$g_recaptcha_response = $context['data']['g-recaptcha-response'];
			$secret = $this->_config['secret'];
			$remote_addr = $_SERVER['REMOTE_ADDR'];
			$response_json = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$g_recaptcha_response."&remoteip=" . $remote_addr);
			$response = json_decode($response_json, true);
			return $response['success'];
		}
		return $value == $this->captcha[$this->_config['field']];
	}

	/**
	 * Store captcha value in controller
	 *
	 */
	public function setCaptcha($field, $captcha) {
			$this->captcha[$field] = $captcha;
	}

	/**
	 * Default validation rules.
	 *
	 * @param \Cake\Validation\Validator $validator Validator instance.
	 * @return \Cake\Validation\Validator
	 */
	public function buildValidator(Event $event, Validator $validator, $name)
	{
		$validator->add($this->_config['field'], 'captcha', [
			'rule' => 'validateCaptcha', 
			'message'=>$this->_config['message'],
			'provider'=>'table'
		]);

		return $validator;
	}

	/*public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
	{
	}*/
}

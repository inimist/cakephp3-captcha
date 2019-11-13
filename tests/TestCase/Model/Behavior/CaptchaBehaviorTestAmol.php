<?php
namespace Captcha\Test\TestCase\Model\Behavior;

use Cake\TestSuite\TestCase;
use Captcha\Model\Behavior\CaptchaBehavior;

/**
 * Captcha\Model\Behavior\CaptchaBehavior Test Case
 */
class CaptchaBehaviorTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Captcha\Model\Behavior\CaptchaBehavior
     */
    public $Captcha;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
		parent::setUp();
		//$this->behavior = new Behavior();
		//$this->behavior->behaviors()->get('Captcha\Model\Behavior\CaptchaBehavior;');
        $this->Captcha = new CaptchaBehavior();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Captcha);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
	/**
	 * Test Store captcha value in controller
	 *
	 */
	public function setCaptcha($field, $captcha) {
		$field = 'captcha_input_field_name';
		$captcha = 'b9hzmr';
		$this->Captcha->setCaptcha($field,$captcha);
		$this->assertNotEquals(null, $this->captcha);
	}
}

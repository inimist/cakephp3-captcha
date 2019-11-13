<?php
namespace Captcha\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use Captcha\View\Helper\CaptchaHelper;

use Cake\Core\Configure;
use Cake\Network\Request;
use Cake\Network\Session;
use Cake\Routing\Router;


/**
 * Captcha\View\Helper\CaptchaHelper Test Case
 */
class CaptchaHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Captcha\View\Helper\CaptchaHelper
     */
    public $CaptchaHelper;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->CaptchaHelper = new CaptchaHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CaptchaHelper);

        parent::tearDown();
    }

    /**
     * Test create method
     *
     * @return void
     */
    public function testCreate()
    {
		$result = $this->CaptchaHelper->create('captcha_input_field_name',
			['type'=>'image',
			'theme'=>'random', //two themes, "default" and "random",
			'width'=>220,
			'height'=>90,
			'controller'=>'Captcha',
			'action'=>'create',
			'plugin'=>false,
			'theme'=>'default',]);
		$expected_results='<img src="/captcha/create?type=image&amp;field=captcha_input_field_name&amp;width=220&amp;height=90&amp;theme=default&amp;length=6" hspace="2" alt=""/><a href="#" class="creload">Can\'t read? Reload</a><div class="input text"><label for="captcha-input-field-name">Enter security code shown above:</label><input type="text" name="captcha_input_field_name" autocomplete="off" class="clabel" id="captcha-input-field-name"/></div>';
        $this->assertSame($expected_results,$result);
    }
}

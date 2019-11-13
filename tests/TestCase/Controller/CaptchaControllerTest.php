<?php
namespace Captcha\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Captcha\Controller\CaptchaController;
use Cake\Controller\Controller;

/**
 * Captcha\Controller\CaptchaController Test Case
 *
 * @uses \Captcha\Controller\CaptchaController
 */
class CaptchaControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        //'plugin.Captcha.Captcha'
    ];

    public function setUp()
    {
        $Controller = new Controller();
        $this->CaptchaController = new CaptchaController($Controller);
    }

    /**
     * Test create method
     *
     * @return void
     */
    public function testCreate()
    {
        $id = 1;
        $this->get(['plugin' => 'Captcha', 'controller' => 'Captcha', 'action' => 'create', $id]);
        $this->assertResponseCode(200);
        $this->assertContentType('image/png');
        $this->assertHeaderContains('Content-Transfer-Encoding', 'binary');
        $this->assertResponseNotEmpty();
    }
}

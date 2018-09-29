<?php
use PHPUnit\Framework\TestCase;
use App\Util\Util;

require dirname(dirname(dirname(__FILE__))).'/vendor/autoload.php';

class UtilTest extends TestCase
{
    public function testReturnJson()
    {
        $util = new Util();
        $status = 'error';
        $message = 'forbidden';
        $this->assertEquals('error', json_decode($util->returnJson($status, $message))->status);
        $this->assertEquals('forbidden', json_decode($util->returnJson($status, $message))->message);
    }

    public function testGetData()
    {
        $util = new Util();
        $_GET =  array(
            'username' => 'testuser',
            'password' => '123456'
        );
        $this->assertEquals('testuser', $util->getData('username'));
        $this->assertEquals('123456', $util->getData('password'));
        
        $_POST =  array(
            'username' => 'testuser',
            'password' => '123456'
        );
        $this->assertEquals('testuser', $util->getData('username'));
        $this->assertEquals('123456', $util->getData('password'));
        
        $_POST =  array(
            'hobby' => array('football','basketball','dance')
        );
        $this->assertEquals('basketball', $util->getData('hobby')['1']);
        $this->expectExceptionMessage('username can not be empty');
        
        $_POST =  array();
        $_GET =  array();
        $util->getData('username');
    }

    public function testGetTwig()
    {
        $util = new Util();
        $this->assertObjectHasAttribute('loader', $util->getTwig());
    }

    public function testGetDbh()
    {
        $util = new Util();
        $this->assertEquals('mysql', $util->getDbh()->getAttribute(PDO::ATTR_DRIVER_NAME));
    }
}

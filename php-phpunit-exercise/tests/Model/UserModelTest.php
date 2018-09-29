<?php
use PHPUnit\Framework\TestCase;
use App\Model\UserModel;

require dirname(dirname(dirname(__FILE__))).'/vendor/autoload.php';

class UserModelTest extends TestCase
{
    public function setUp() {
        $mysqlConfig = require dirname(dirname(dirname(__FILE__)))."/config.php";
        $dbh = new \PDO("mysql:host={$mysqlConfig['host']};",$mysqlConfig['user'],$mysqlConfig['password'], array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES'utf8';"));
        $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $stmt = $dbh->prepare("show databases;");
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if (!in_array(array('Database'=>"{$mysqlConfig['test_dbname']}"), $result)) {
            $dbh->query("CREATE DATABASE `{$mysqlConfig['test_dbname']}` DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;");
            $dbh->query("USE `{$mysqlConfig['test_dbname']}`;");
            $sql = file_get_contents(dirname(dirname(dirname(__FILE__))).'/bootcamp.sql');
            $sqlArray = explode(';', $sql);
            foreach ($sqlArray as $value) {
                $dbh->query($value.';');
            }
        }else{
            $dbh->query("USE `{$mysqlConfig['test_dbname']}`;");
            $dbh->query("Truncate TABLE user");
            
        }
        $this->userModel = new UserModel();
        $this->userModel->dbh = new \PDO("mysql:host={$mysqlConfig['host']};dbname={$mysqlConfig['test_dbname']}", $mysqlConfig['user'], $mysqlConfig['password'], array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES'utf8';"));
    }

    public function testAddUser()
    {
        $user = $this->makeOneUser();
        $result = $this->userModel->addUser($user);
        $this->assertEquals($user->username, $result['username']);
        $this->assertEquals('admin', $result['role']);
        $this->assertEquals('用户名已存在', $this->userModel->addUser($user));
        $user2 = $this->makeOneUser();
        $result = $this->userModel->addUser($user2);
        $this->assertEquals($user2->username, $result['username']);
        $this->assertEquals('member', $result['role']);
    }

    public function testGetUserByUsername()
    {
        $user = $this->makeOneUser();
        $this->userModel->addUser($user);
        $result = $this->userModel->getUserByUsername($user->username);
        $this->assertEquals($user->username, $result['username']);
        $result = $this->userModel->getUserByUsername('testName1');
        $this->assertEquals(null, $result);
    }

    public function testGetUserByMail()
    {
        $user = $this->makeOneUser();
        $this->userModel->addUser($user);
        $result = $this->userModel->getUserByMail($user->mail);
        $this->assertEquals($user->username, $result['username']);
        $result = $this->userModel->getUserByMail('2@qq.com');
        $this->assertEquals(null, $result);
    }

    public function testGetUserByUserId()
    {
        $user = $this->makeOneUser();
        $result = $this->userModel->addUser($user);
        $result = $this->userModel->getUserByUserId($result['id']);
        $this->assertEquals($user->username, $result['username']);
        $result = $this->userModel->getUserByUserId(2);
        $this->assertEquals(null, $result);
    }

    public function testGetPagesNumByWork()
    {
        $result = $this->userModel->getPagesNumByWork(0,10);
        $this->assertEquals(0, $result);
        $user = $this->makeOneUser();
        $result = $this->userModel->addUser($user);
        $this->assertEquals($user->username, $result['username']);
    }

    public function testDelUser()
    {
        $user = $this->makeOneUser();
        $this->userModel->addUser($user);
        $result = $this->userModel->getUserByUsername($user->username);
        $this->assertEquals($user->username, $result['username']);
        $this->userModel->delUser($result['id']);
        $this->assertEquals(null, $this->userModel->getUserByUsername($user->username));
    }

    public function makeOneUser()
    {
        $user = json_decode("{}");
        $user->username = uniqid();
        $user->password = '123123';
        $user->realname = '张博一';
        $user->mail = uniqid().'@qq.com';
        $user->age = 17;
        $user->work = 0;
        $user->org = '浙江大学';
        $user->hobby = 'football#basketball';
        return $user;
    }

    public function testUpdateUser()
    {
        $user = $this->makeOneUser();
        $this->userModel->addUser($user);
        $result = $this->userModel->getUserByUsername($user->username);
        $this->assertEquals($user->username, $result['username']);
        $user->id = $result['id'];
        $user->age = 18;
        $user->org = '北京大学';
        $this->userModel->updateUser($user);
        $result = $this->userModel->getUserByUsername($user->username);
        $this->assertEquals(18, $result['age']);
        $this->assertEquals('北京大学', $result['org']);
    }

    public function testFindUsersByWork()
    {
        $user = $this->makeOneUser();
        $this->userModel->addUser($user);
        $user = $this->makeOneUser();
        $user->work = 1;
        $this->userModel->addUser($user);
        $result = $this->userModel->findUsersByWork('all',1,10);
        $this->assertEquals(2, count($result));
        $result = $this->userModel->findUsersByWork('0',1,10);
        $this->assertEquals(1, count($result));
        $this->assertEquals(0, $result['0']['work']);
        $result = $this->userModel->findUsersByWork('1',1,10);
        $this->assertEquals(1, count($result));
        $this->assertEquals(1, $result['0']['work']);
    }

    public function testIsUserExist()
    {
        $user = $this->makeOneUser();
        $this->userModel->addUser($user);
        $result = $this->userModel->isUserExist($user);
        $this->assertEquals('用户名已存在', $result);
        $user->username = 'testName';
        $result = $this->userModel->isUserExist($user);
        $this->assertEquals('邮箱已存在', $result);
        $user->mail = 'q@qq.com';
        $result = $this->userModel->isUserExist($user);
        $this->assertEquals(null, $result);
    }
}

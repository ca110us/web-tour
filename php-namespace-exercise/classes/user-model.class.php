<?php
namespace App\Model;
class UserModel
{
    public $id;
    public $username;
    public $password;
    public $realname;
    public $mail;
    public $age;
    public $work;
    public $org;
    public $hobby;
    public $role;

    protected $dbh;

    public function __construct()
    {
        $mysqlConfig = require dirname(dirname(__FILE__))."/config.php";
        $this->dbh = new \PDO("mysql:host={$mysqlConfig['host']};dbname={$mysqlConfig['dbname']}", $mysqlConfig['user'], $mysqlConfig['password'],array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES'utf8';"));
        $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function isUserExist($user)
    {
        $users = $this->findUsers(0);
        foreach ($users as $key => $value) {
            if ($users[$key]['username']==$user->username) {
                return "用户名已存在";
            } elseif ($users[$key]['mail']==$user->mail) {
                return "该邮箱已注册";
            }
        }
        return null;
    }

    public function getUserByUsername($username)
    {
        try {
            $stmt = $this->dbh->prepare("SELECT * FROM user WHERE username = ?");
            $stmt->execute(array($username));
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);
            if ($user) {
                return $user;
            }else{
                return null;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getUserByMail($mail)
    {
        try {
            $stmt = $this->dbh->prepare("SELECT * FROM user WHERE mail = ?");
            $stmt->execute(array($mail));
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);
            if ($user) {
                return $user;
            }else{
                return null;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getUserByUserId($userId)
    {
        try {
            $stmt = $this->dbh->prepare("SELECT * FROM user WHERE id = ?");
            $stmt->execute(array($userId));
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);
            if ($user) {
                return $user;
            }else{
                return null;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getPagesNumByWork($work)
    {
        $users = $this->findUsers(0);
        $userCount = 0;
        if ($work=='all') {
            $userCount = count($users);
            return ceil($userCount/10);
        } else {
            foreach ($users as $key => $value) {
                if ($users[$key]['work']==$work) {
                    $userCount++;
                }
            }
            return ceil($userCount/10);
        }
    }

    public function addUser($user)
    {
        $CommonLib = new \App\Lib\CommonLib();
        $user = $CommonLib->characterFilter($user);
        if (empty($this->findUsers(0))) {
            $user->role = 'admin';
        } else {
            $user->role = 'member';
        }
        if ($this->checkUser($user) && $this->isUserExist($user)==null) {
            try {
                $stmt = $this->dbh->prepare("INSERT INTO user (id, username, password, realname, mail, age, work, org, hobby, role) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute(
                    array($user->username, 
                    $user->password, 
                    $user->realname, 
                    $user->mail, 
                    $user->age, 
                    $user->work, 
                    $user->org, 
                    $user->hobby, 
                    $user->role
                ));
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            return null;
        } else {
            return $this->isUserExist($user);
        }
    }

    public function delUser($userId)
    {
        try {
            $stmt = $this->dbh->prepare("DELETE FROM user WHERE id = ?");
            $stmt->execute(array($userId));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function updateUser($user)
    {
        $CommonLib = new \App\Lib\CommonLib();
        $user = $CommonLib->characterFilter($user);
        $currentRole = $this->getUserByUserId($user->id)['role'];
        try {
            $stmt = $this->dbh->prepare("UPDATE user SET realname = ?, mail = ?, age = ?, work = ?, org = ?, hobby = ?, role = ? WHERE id = ? ");
            $stmt->execute(
                array(
                    $user->realname,
                    $user->mail,
                    $user->age,
                    $user->work,
                    $user->org,
                    $user->hobby,
                    $user->role ? $user->role : $currentRole,
                    $user->id
                ));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function findUsers($page)
    {
        $sth = $this->dbh->prepare("SELECT * FROM user");
        $sth->execute();
        $users = $sth->fetchAll(\PDO::FETCH_ASSOC);
        if ($page==0) {
            return $users;
        } else {
            $users = array_slice($users, 10*($page-1), 10);
            return $users;
        }
    }

    public function findUsersByWork($work, $page)
    {
        $users = $this->findUsers(0);
        if ($page==0) {
            return $users;
        } elseif ($work=='all') {
            $users = array_slice($users, 10*($page-1), 10);
            return $users;
        } else {
            foreach ($users as $key => $value) {
                if ($users[$key]['work']!==$work) {
                    unset($users[$key]);
                }
            }
            $users = array_slice($users, 10*($page-1), 10);
            return $users;
        }
    }

    public function checkUser($user)
    {
        foreach ($user as $key=>$val) {
            if ($key!='id' && $key != 'role') {
                if (empty($val)) {
                    return false;
                }
            }
        }
        
        try{
            if(!preg_match('/^[\x{4e00}-\x{9fa5}_a-zA-Z0-9]+$/u',$user->username)){
                throw new Exception('用户名格式不正确！');
            }
            if(!preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/',$user->mail)){
                throw new Exception('邮箱格式不正确！');
            }
            if(!preg_match('/^[0-9]+$/u',$user->age)){
                throw new Exception('年龄格式不正确！');
            }
            if(!preg_match('/^[\x{4e00}-\x{9fa5}]+$/u',$user->realname)){
                throw new Exception('真实姓名格式不正确！');
            }
            if(!preg_match('/^[0|1]/',$user->work)){
                throw new Exception('职业格式不正确！');
            }
            if(strlen(iconv('UTF-8', 'GB2312', $user->org))>100){
                throw new Exception('学校/公司格式不正确！');
            }
        }catch(Exception $e){
            header("HTTP/1.0 500");
            exit();
        }
        return true;
    }
}

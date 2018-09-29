<?php
namespace App\Model;

use App\Util\Util;
use App\Util\Validator;

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

    public $dbh;

    public function __construct()
    {
        $util = new Util();
        $this->dbh = $util->getDbh();
    }

    public function getUserByUsername($username)
    {
        $stmt = $this->dbh->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->execute(array($username));
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($user) {
            return $user;
        } else {
            return null;
        }
    }

    public function getUserByMail($mail)
    {
        $stmt = $this->dbh->prepare("SELECT * FROM user WHERE mail = ?");
        $stmt->execute(array($mail));
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($user) {
            return $user;
        } else {
            return null;
        }
    }

    public function getUserByUserId($userId)
    {
        $stmt = $this->dbh->prepare("SELECT * FROM user WHERE id = ?");
        $stmt->execute(array($userId));
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($user) {
            return $user;
        } else {
            return null;
        }
    }

    public function getPagesNumByWork($work,$limit)
    {
        if ($work=='all') {
            $stmt = $this->dbh->prepare("SELECT COUNT(*) FROM user");
        } else {
            $stmt = $this->dbh->prepare("SELECT COUNT(*) FROM user WHERE work = ?");
        }
        $stmt->execute(array($work));
        $userCount = $stmt->fetch();
        return ceil($userCount[0]/$limit);
    }

    public function addUser($user)
    {
        $util = new Util();
        if ($this->getPagesNumByWork('all',1)<=0) {
            $user->role = 'admin';
        } else {
            $user->role = 'member';
        }
        if ($this->checkUser($user) && $this->isUserExist($user)==null) {
            $stmt = $this->dbh->prepare("INSERT INTO user (id, username, password, realname, mail, age, work, org, hobby, role) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $user =  array(
                $user->username,
                md5($user->password),
                $user->realname,
                $user->mail,
                $user->age,
                $user->work,
                $user->org,
                $user->hobby,
                $user->role
            );
            $stmt->execute($user);
            return $this->getUserByUsername($user['0']);
        } else {
            return $this->isUserExist($user);
        }
    }

    public function delUser($userId)
    {
        $stmt = $this->dbh->prepare("DELETE FROM user WHERE id = ?");
        $stmt->execute(array($userId));
    }

    public function updateUser($user)
    {
        $util = new Util();
        $currentRole = $this->getUserByUserId($user->id)['role'];
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
            )
        );
    }

    public function checkLogin($user)
    {
        $userInfo = $this->getUserByUsername($user->username);
        if (empty($userInfo)) {
            return false;
        }
        if($userInfo['password'] == md5($user->password)) {
            return true;
        }
    }

    public function findUsersByWork($work, $page,$limit)
    {
        if ($work=='all') {
            $sql = 'SELECT * FROM user LIMIT ' . $limit*($page-1) . ',' . $limit;
            $sth = $this->dbh->prepare($sql);
            $sth->execute();
        }
        if ($work!==null && $work!='all') {
            $sql = 'SELECT * FROM user WHERE work = '.$work.' LIMIT ' . $limit*($page-1) . ',' . $limit;
            $sth = $this->dbh->prepare($sql);
            $sth->execute();
        }
        $users = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $users;
    }

    public function isUserExist($user)
    {
        $stmt = $this->dbh->prepare("SELECT COUNT(*) FROM user WHERE username = ?");
        $stmt->execute(array($user->username));
        $userCount = $stmt->fetch();
        if ($userCount[0]>0) {
            return "用户名已存在";
        }
        $stmt = $this->dbh->prepare("SELECT COUNT(*) FROM user WHERE mail = ?");
        $stmt->execute(array($user->mail));
        $userCount = $stmt->fetch();
        if ($userCount[0]>0) {
            return "邮箱已存在";
        }
        return null;
    }

    public function checkUser($user)
    {
        $validator = new Validator();
        if (!$validator->hasChinese($user->username) && !$validator->hasEnglish($user->username) && !$validator->hasNumber($user->username) || $validator->hasSymbol($user->username) ) {
            throw new \Exception('用户名格式不正确！');
        }
        if (!$validator->isEmail($user->mail)) {
            throw new \Exception('邮箱格式不正确！');
        }
        if (!$user->age>0 && !$user->age<=100 && !$validator->isNumber($user->age)) {
            throw new \Exception('年龄格式不正确！');
        }
        if (!$validator->isChinese($user->realname)) {
            throw new \Exception('真实姓名格式不正确！');
        }
        if (!preg_match('/^[0|1]/', $user->work)) {
            throw new \Exception('职业格式不正确！');
        }
        if (!$validator->valiteLength($user->org,1,100)) {
            throw new \Exception('学校/公司格式不正确！');
        }
        return true;
    }
}

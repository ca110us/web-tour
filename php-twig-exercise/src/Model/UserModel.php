<?php
namespace App\Model;

use App\Util\Util;

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

    public function getPagesNumByWork($work)
    {
        if ($work=='all') {
            $stmt = $this->dbh->prepare("SELECT COUNT(*) FROM user");
        } else {
            $stmt = $this->dbh->prepare("SELECT COUNT(*) FROM user WHERE work = ?");
        }
        $stmt->execute(array($work));
        $userCount = $stmt->fetch();
        return ceil($userCount[0]/10);
    }

    public function addUser($user)
    {
        $util = new Util();
        $user = $util->characterFilter($user);
        if (empty($this->findUsers())) {
            $user->role = 'admin';
        } else {
            $user->role = 'member';
        }
        if ($this->checkUser($user) && $this->isUserExist($user)==null) {
            $stmt = $this->dbh->prepare("INSERT INTO user (id, username, password, realname, mail, age, work, org, hobby, role) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute(
                array($user->username,
                md5($user->password),
                $user->realname,
                $user->mail,
                $user->age,
                $user->work,
                $user->org,
                $user->hobby,
                $user->role
            )
            );
            return null;
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
        $user = $util->characterFilter($user);
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

    public function findUsers($work=null, $page=1)
    {
        if ($work==null) {
            $sth = $this->dbh->prepare("SELECT * FROM user");
            $sth->execute();
        }
        if ($work=='all') {
            $sql = 'SELECT * FROM user LIMIT ' . 10*($page-1) . ',' . 10;
            $sth = $this->dbh->prepare($sql);
            $sth->execute();
        }
        if ($work!==null && $work!='all') {
            $sql = 'SELECT * FROM user WHERE work = '.$work.' LIMIT ' . 10*($page-1) . ',' . 10;
            $sth = $this->dbh->prepare($sql);
            $sth->execute();
        }
        $users = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $users;
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

    public function findUsersByWork($work, $page)
    {
        $users = $this->findUsers($work, $page);
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
        if (!preg_match('/^[\x{4e00}-\x{9fa5}_a-zA-Z0-9]+$/u', $user->username)) {
            throw new \Exception('用户名格式不正确！');
        }
        if (!preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/', $user->mail)) {
            throw new \Exception('邮箱格式不正确！');
        }
        if (!preg_match('/^[0-9]+$/u', $user->age)) {
            throw new \Exception('年龄格式不正确！');
        }
        if (!preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $user->realname)) {
            throw new \Exception('真实姓名格式不正确！');
        }
        if (!preg_match('/^[0|1]/', $user->work)) {
            throw new \Exception('职业格式不正确！');
        }
        if (strlen(iconv('UTF-8', 'GB2312', $user->org))>100) {
            throw new \Exception('学校/公司格式不正确！');
        }
        return true;
    }
}

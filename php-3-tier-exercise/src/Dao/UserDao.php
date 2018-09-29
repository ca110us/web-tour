<?php

namespace App\Dao;
use App\Util\Util;

Class UserDao
{
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
    
}

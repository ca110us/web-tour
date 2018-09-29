<?php

namespace App\Service;
use App\Util\Validator;
use App\Util\Util;
use App\Dao\UserDao;

Class UserService
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

    public function getUserByUsername($username)
    {
        return $this->getUserDao()->getUserByUsername($username);
    }

    public function getUserByMail($mail)
    {
        return $this->getUserDao()->getUserByMail($mail);
    }

    public function getUserByUserId($userId)
    {
        return $this->getUserDao()->getUserByUserId($userId);
    }

    public function getPagesNumByWork($work,$limit)
    {
        return $this->getUserDao()->getPagesNumByWork($work,$limit);
    }

    public function addUser($user)
    {
        $util = new Util();
        if ($this->getUserDao()->getPagesNumByWork('all',1)<=0) {
            $user->role = 'admin';
        } else {
            $user->role = 'member';
        }
        if ($this->checkUser($user) && $this->getUserDao()->isUserExist($user)==null) {
            return $this->getUserDao()->addUser($user);
        } else {
            return $this->getUserDao()->isUserExist($user);
        }
    }

    public function delUser($userId)
    {
        return $this->getUserDao()->delUser($userId);
    }

    public function updateUser($user)
    {
        return $this->getUserDao()->updateUser($user);
    }

    public function checkLogin($user)
    {
        return $this->getUserDao()->checkLogin($user);
    }

    public function findUsersByWork($work, $page,$limit)
    {
        return $this->getUserDao()->findUsersByWork($work, $page,$limit);
    }

    public function isUserExist($user)
    {
        return $this->getUserDao()->isUserExist($user);
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

    protected function getUserDao()
    {
        $userDao = new UserDao();
        return $userDao;
    }
}

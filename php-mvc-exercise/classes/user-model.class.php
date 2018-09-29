<?php

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

    protected $txtPath;

    public function __construct()
    {
        $this->txtPath = dirname(dirname(__FILE__))."/user.txt";;;
        $file = fopen($this->txtPath, "a");
        fclose($file);
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

    private function makeUsersArray()
    {
        $CommonLib = new CommonLib();
        $file = fopen($this->txtPath, "rw");
        $users = array();
        while (!feof($file)) {
            $line = fgets($file);
            $tmp = explode('|', $line);
            if ($tmp[0] == null) {
                break;
            }
            $users = $CommonLib->makeUser($users, $tmp);
        }
        return $users;
    }

    public function getUserByUsername($username)
    {
        $users = $this->makeUsersArray();
        foreach ($users as $key => $value) {
            if ($users[$key]['username']==$username) {
                return $users[$key];
            }
        }
        return null;
    }

    public function getUserByMail($mail)
    {
        $users = $this->makeUsersArray();
        foreach ($users as $key => $value) {
            if ($users[$key]['mail']==$mail) {
                return $users[$key];
            }
        }
        return null;
    }

    public function getUserByUserId($userId)
    {
        $users = $this->makeUsersArray();
        foreach ($users as $key => $value) {
            if ($users[$key]['id']==$userId) {
                return $users[$key];
            }
        }
        return null;
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
        $CommonLib = new CommonLib();
        $user = $CommonLib->characterFilter($user);
        $user->id = uniqid();
        if (empty($this->findUsers(0))) {
            $user->role = 'admin';
        } else {
            $user->role = 'member';
        }
        if ($this->checkUser($user) && $this->isUserExist($user)==null) {
            $file = fopen($this->txtPath, "a");
            fwrite($file, $user->id . '|' . $user->username . '|' . $user->password . '|' . $user->realname . '|' . $user->mail . '|' . $user->age . '|' . $user->work . '|' . $user->org . '|' .$user->hobby . '|' .$user->role . "\n");
            fclose($file);
            return null;
        } else {
            return $this->isUserExist($user);
        }
    }

    public function delUser($userId)
    {
        $users = $this->makeUsersArray();
        $file = fopen($this->txtPath, "a");
        foreach ($users as $key => $value) {
            if ($users[$key]['id']==$userId) {
                unset($users[$key]);
            }
        }
        if (count($users)<=0) {
            file_put_contents($this->txtPath, '');
        } else {
            file_put_contents($this->txtPath, '');
            foreach ($users as $key => $value) {
                fwrite($file, implode('|', $users[$key])."\n");
            }
        }
        fclose($file);
    }

    public function updateUser($user)
    {
        $CommonLib = new CommonLib();
        $user = $CommonLib->characterFilter($user);
        $users = $this->makeUsersArray();
        $file = fopen($this->txtPath, "a");
        foreach ($users as $key => $value) {
            if ($users[$key]['id']==$user->id) {
                $users[$key]['role'] = $user->role ? $user->role : $users[$key]['role'] ;
                $users[$key]['realname'] = $user->realname;
                $users[$key]['mail'] = $user->mail;
                $users[$key]['age'] = $user->age;
                $users[$key]['work'] = $user->work;
                $users[$key]['org'] = $user->org;
                $users[$key]['hobby'] = $user->hobby;
            }
        }
        if (count($users)<=0) {
            file_put_contents($this->txtPath, '');
        } else {
            file_put_contents($this->txtPath, '');
            foreach ($users as $key => $value) {
                fwrite($file, implode('|', $users[$key])."\n");
            }
        }
        fclose($file);
    }

    public function findUsers($page)
    {
        $users = $this->makeUsersArray();
        if ($page==0) {
            return $users;
        } else {
            $users = array_slice($users, 10*($page-1), 10);
            return $users;
        }
    }

    public function findUsersByWork($work, $page)
    {
        $users = $this->makeUsersArray();
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

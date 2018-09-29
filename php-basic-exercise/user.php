<?php

class user
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

    function __construct() {
        $file = fopen(dirname(__FILE__)."/user.txt","a");
        fclose($file);
    }

    public function checkObj($obj) {
        foreach($obj as $key=>$val){
            if (empty($val)) {
                return false;
            }else{
                return true;
            }
        }
    }

    public function existUser($user) {
        $users = $this->getDatas('');
        foreach ($users as $key => $value) {
            if ($users[$key]['username']==$user->username) {
                return "用户名已存在";
            }elseif($users[$key]['mail']==$user->mail){
                return "该邮箱已注册";
            }
        }
        return null;
    }

    public function getDatas($page) {
        $file = fopen(dirname(__FILE__)."/user.txt","rw");
        $users = array();
        while(!feof($file)){
            $line = fgets($file);
            $tmp = explode('|',$line);
            if($tmp[0] == NULL) break;
            $users[] = array(
                'id'   => $tmp[0],
                'username' => $tmp[1],
                'password'  => $tmp[2],
                'realname'  => $tmp[3],
                'mail'  => $tmp[4],
                'age'   => $tmp[5],
                'work' => $tmp[6],
                'org'  => $tmp[7],
                'hobby'  => $tmp[8],
                'role' => str_replace("\n","",$tmp[9]),
            );
        }
        if ($page=='') {
            return $users;
        } else {
            $users = array_slice($users,10*($page-1),10);
            return $users;
        }
        
    }

    public function getDatasByWork($work,$page) {
        $file = fopen(dirname(__FILE__)."/user.txt","rw");
        $users = array();
        while(!feof($file)){
            $line = fgets($file);
            $tmp = explode('|',$line);
            if($tmp[0] == NULL) break;
            $users[] = array(
                'id'   => $tmp[0],
                'username' => $tmp[1],
                'password'  => $tmp[2],
                'realname'  => $tmp[3],
                'mail'  => $tmp[4],
                'age'   => $tmp[5],
                'work' => $tmp[6],
                'org'  => $tmp[7],
                'hobby'  => $tmp[8],
                'role' => str_replace("\n","",$tmp[9]),
            );
        }
        if ($page=='') {
            return $users;
        } elseif($work=='all'){
            $users = array_slice($users,10*($page-1),10);
            return $users;
        }else{
            foreach ($users as $key => $value) {
                if ($users[$key]['work']!==$work) {
                    unset($users[$key]);
                }
            }
            $users = array_slice($users,10*($page-1),10);
            return $users;
        }
        
    }

    public function getUserByUsername($username)
    {
        $file = fopen(dirname(__FILE__)."/user.txt","rw");
        $users = array();
        while(!feof($file)){
            $line = fgets($file);
            $tmp = explode('|',$line);
            if($tmp[0] == NULL) break;
            $users[] = array(
                'id'   => $tmp[0],
                'username' => $tmp[1],
                'password'  => $tmp[2],
                'realname'  => $tmp[3],
                'mail'  => $tmp[4],
                'age'   => $tmp[5],
                'work' => $tmp[6],
                'org'  => $tmp[7],
                'hobby'  => $tmp[8],
                'role' => str_replace("\n","",$tmp[9]),
            );
        }
        foreach ($users as $key => $value) {
            if ($users[$key]['username']==$username) {
                return $users[$key];
            }
        }
        return null;
    }

    public function getUserByUserId($userId)
    {
        $file = fopen(dirname(__FILE__)."/user.txt","rw");
        $users = array();
        while(!feof($file)){
            $line = fgets($file);
            $tmp = explode('|',$line);
            if($tmp[0] == NULL) break;
            $users[] = array(
                'id'   => $tmp[0],
                'username' => $tmp[1],
                'password'  => $tmp[2],
                'realname'  => $tmp[3],
                'mail'  => $tmp[4],
                'age'   => $tmp[5],
                'work' => $tmp[6],
                'org'  => $tmp[7],
                'hobby'  => $tmp[8],
                'role' => str_replace("\n","",$tmp[9]),
            );
        }
        foreach ($users as $key => $value) {
            if ($users[$key]['id']==$userId) {
                return $users[$key];
            }
        }
        return null;
    }

    public function getPages($work){
        $users = $this->getDatas('');
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

    public function addUser($user){
        $user->id = uniqid();
        if (empty($this->getDatas(''))) {
            $user->role = 'admin';
        }else{
            $user->role = 'member';
        }
        if($this->checkObj($user) && $this->existUser($user)==''){
            $file = fopen(dirname(__FILE__)."/user.txt","a");
            fwrite($file, $user->id . '|' . $user->username . '|' . $user->password . '|' . $user->realname . '|' . $user->mail . '|' . $user->age . '|' . $user->work . '|' . $user->org . '|' .$user->hobby . '|' .$user->role . "\n");
            fclose($file);
            return '';
        }else{
            return $this->existUser($user);
        }
    }

    public function delUser($userId) {
        $file = fopen(dirname(__FILE__)."/user.txt","rw");
        $users = array();
        while(!feof($file)){
            $line = fgets($file);
            $tmp = explode('|',$line);
            if($tmp[0] == NULL) break;
            $users[] = array(
                'id'   => $tmp[0],
                'username' => $tmp[1],
                'password'  => $tmp[2],
                'realname'  => $tmp[3],
                'mail'  => $tmp[4],
                'age'   => $tmp[5],
                'work' => $tmp[6],
                'org'  => $tmp[7],
                'hobby'  => $tmp[8],
                'role' => str_replace("\n","",$tmp[9]),
            );
        }
        fclose($file);
        $file = fopen(dirname(__FILE__)."/user.txt","a");
        foreach ($users as $key => $value) {
            if ($users[$key]['id']==$userId) {
                unset($users[$key]);
            }
        }
        if (count($users)<=0) {
            file_put_contents(dirname(__FILE__)."/user.txt",'');
        }else{
            file_put_contents(dirname(__FILE__)."/user.txt",'');
            foreach ($users as $key => $value) {
                fwrite($file,implode('|', $users[$key])."\n");
            }
        }
        fclose($file);
    }

    public function updateUser($user) {
        $file = fopen(dirname(__FILE__)."/user.txt","rw");
        $users = array();
        while(!feof($file)){
            $line = fgets($file);
            $tmp = explode('|',$line);
            if($tmp[0] == NULL) break;
            $users[] = array(
                'id'   => $tmp[0],
                'username' => $tmp[1],
                'password'  => $tmp[2],
                'realname'  => $tmp[3],
                'mail'  => $tmp[4],
                'age'   => $tmp[5],
                'work' => $tmp[6],
                'org'  => $tmp[7],
                'hobby'  => $tmp[8],
                'role' => str_replace("\n","",$tmp[9]),
            );
        }
        fclose($file);
        $file = fopen(dirname(__FILE__)."/user.txt","a");
        foreach ($users as $key => $value) {
            if ($users[$key]['id']==$user->id) {
                $users[$key]['role'] = $user->role;
                $users[$key]['realname'] = $user->realname;
                $users[$key]['mail'] = $user->mail;
                $users[$key]['age'] = $user->age;
                $users[$key]['work'] = $user->work;
                $users[$key]['org'] = $user->org;
                $users[$key]['hobby'] = $user->hobby;
            }
        }
        if (count($users)<=0) {
            file_put_contents(dirname(__FILE__)."/user.txt",'');
        }else{
            file_put_contents(dirname(__FILE__)."/user.txt",'');
            foreach ($users as $key => $value) {
                fwrite($file,implode('|', $users[$key])."\n");
            }
        }
        fclose($file);
    }

}

<?php
require_once "functions.php";

class user{
    public $id;
    public $username;
    public $sex;
    public $age;
    public $profile;

    function __construct() {
        $file = fopen(dirname(__FILE__)."/user.txt","a");
        fclose($file);
    }

    public function check_user($user)
    {
        if (empty($user->username)||empty($user->sex)||empty($user->age)||empty($user->profile)) {
            return false;
        }else{
            return true;
        }
    }

    public function add_user($user){
        if($this->check_user($user)){
            $file = fopen(dirname(__FILE__)."/user.txt","a");
            fwrite($file, uniqid() . '|'. $user->username.'|'.$user->sex.'|'.$user->age.'|'.$user->profile."\n");
            fclose($file);
        }
    }

    public function get_users($page){
        $file=file(dirname(__FILE__)."/user.txt");
        $line = count($file);
        $users = array();
        $page = $page - 1;
        $endline = $line - $page * 10;
        if ($endline<=0){
            return $users;
        }else{
            $count = 0;
            while($count<10 && $endline>0){
                $user = $file[$endline-1];
                $user = explode('|',$user);
                $users[$endline]['id']=$user[0];
                $users[$endline]['username']=$user[1];
                $users[$endline]['sex']=$user[2];
                $users[$endline]['age']=$user[3];
                $users[$endline]['profile']=$user[4];
                $endline -= 1;
                $count += 1;
            }
            return $users;
        }
    }

    public function get_pages(){
        $file=file(dirname(__FILE__)."/user.txt");
        $line = count($file);
        $pages = ceil($line/10);
        return $pages;
    }

    public function get_user($id){
        if (PHP_OS=='Linux') {
            $code="sed -n '/^".$id."|/p' ".dirname(__FILE__)."/user.txt";
        }else{
            $code="sed -n '' '/^".$id."|/p' ".dirname(__FILE__)."/user.txt";
        } 
        exec($code, $res);
        $user=array();
        if (!empty($res)){
            $res = explode('|',$res[0]);
            $user['id']=$res[0];
            $user['username']=$res[1];
            $user['sex']=$res[2];
            $user['age']=$res[3];
            $user['profile']=$res[4];
        }
        return $user;
    }

    public function del_user($id){
        if (PHP_OS=='Linux') {
            $code = "sed -i '/^".$id."|/d' ".dirname(__FILE__)."/user.txt";
        }else{
            $code = "sed -i '' '/^".$id."|/d' ".dirname(__FILE__)."/user.txt";
        }  
        if(!empty($this->get_user($id))){
            exec($code);
            return true;
        }
        return false;
    }

    public function modify_user($id,$user){
        $user = $user->id.'|'.$user->username.'|'.$user->sex.'|'.$user->age.'|'.$user->profile."\n";
        if (PHP_OS=='Linux') {
            $code="sed -i '/^".$id."|/c ".$user."' ".dirname(__FILE__)."/user.txt";
        }else{
            $code="sed -i '' '/^".$id."|/c ".$user."' ".dirname(__FILE__)."/user.txt";
        }  
        exec($code);
    }
}
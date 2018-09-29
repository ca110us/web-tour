<?php

class CommonLib
{
    public function returnJson($status, $message)
    {
        $returnMessage = array('status' => $status,'message'=>$message);
        return json_encode($returnMessage);
    }

    public function detailErrors($message)
    {
        $errors = array(
            '错误提示内容' => '自定义内容',
        );
        foreach ($errors as $key => $value) {
            if (strstr($message, $key)) {
                return str_replace($key, $errors[$key], $message);
            }
        }
        return $message;
    }

    public function makeUser($users, $tmp)
    {
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
            'role' => str_replace("\n", "", $tmp[9]),
        );
        return $users;
    }

    public function characterFilter($obj)
    {
        foreach ($obj as $key=>$val) {
            $obj->$key = str_replace("|", "#", $obj->$key);
            $obj->$key = str_replace("<", "#", $obj->$key);
            $obj->$key = str_replace(">", "#", $obj->$key);
        }
        return $obj;
    }
}

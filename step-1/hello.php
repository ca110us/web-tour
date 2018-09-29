<?php
require_once "user.php";
$i=100000;
$user = new  user();
while ($i>0){
    $user->username=$i;
    $user->sex="男";
    $user->age=11;
    $user->profile="hello";
    $user->add_user($user);
    $i--;
}


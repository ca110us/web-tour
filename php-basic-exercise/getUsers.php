<?php
require 'user.php';
header('Content-type: application/json'); 
$user = new user();

if (isset($_POST['userType'])) {
    $users = $user->getDatasByWork($_POST['userType'],$_POST['page']);
    $pages = $user->getPages($_POST['userType']);
    $data = array('data' => $users, 'pages'=>$pages);
    echo json_encode($data);
}
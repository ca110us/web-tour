<?php

function message($type,$message){
    switch ($type){
        case 'fail':
            $dom = '<p style="color:red;" >'.$message.'</p>';
            break;
        case 'success':
            $dom = '<p style="color:green;" >'.$message.'</p>';
            break;
        default:
            $dom = '<p style="color:red;" >'.$message.'</p>';
    }
    return $dom;
}
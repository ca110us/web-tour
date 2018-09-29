<?php
namespace App\Util;

class Validator
{
    public function isChinese($string)
    {
        if (preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $string)) {
            return true;
        }
        return false;
    }
    public function isNumber($string)
    {
        if (preg_match('/^[0-9]+$/', $string)) {
            return true;
        }
        return false;
    }
    public function isEmail($string)
    {
        if(filter_var($string, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
    public function hasChinese($string)
    {
        if (preg_match("/[\x7f-\xff]/", $string)) {
            return true;
        }
        return false;
    }
    public function hasEnglish($string)
    {
        if (preg_match('/[a-zA-Z]+/', $string)) {
            return true;
        }
        return false;
    }
    public function hasNumber($string)
    {
        if (preg_match('/[0-9]+/', $string)) {
            return true;
        }
        return false;
    }
    public function hasSymbol($string)
    {
        if (preg_match('/[!@#$%^&*?,.]+/', $string)) {
            return true;
        }
        return false;
    }
    public function valiteLength($string,$min,$max)
    {
       $strLen = strlen(iconv('UTF-8', 'GB2312', $string));
       if ($strLen>=$min && $strLen<=$max) {
           return true;
       }
       return false;
    }
}

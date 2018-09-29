<?php
use App\Application;
use App\Util\Util;

error_reporting(0);
require 'vendor/autoload.php';
set_exception_handler("ErrorException");
$app = new Application();
$app->run();
function ErrorException($exception)
{
    $util = new Util();
    $util->handleError($exception);
}


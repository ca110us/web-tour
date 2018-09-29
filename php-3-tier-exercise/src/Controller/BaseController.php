<?php
namespace App\Controller;

use App\Service\UserService;
use App\Util\Util;

class BaseController
{
    protected $userService;
    protected $util;
    
    public function __construct()
    {
        $this->userService = new userService();
        $this->util = new Util();
    }
}

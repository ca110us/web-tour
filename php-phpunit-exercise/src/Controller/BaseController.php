<?php
namespace App\Controller;

use App\Model\UserModel;
use App\Util\Util;

class BaseController
{
    protected $userModel;
    protected $util;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->util = new Util();
    }
}

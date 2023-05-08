<?php
namespace Controller;

use Config\View;

class Home extends Base {
    
    public function __construct() {
        self::setTitle('Home');
    }

    public function index() 
    {
        View::view('home/index');
    }

}
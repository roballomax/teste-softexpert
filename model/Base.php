<?php 

namespace Model;

use Config\Database;

class Base extends Database
{
    public function __construct () {
        parent::__construct();
    }
}
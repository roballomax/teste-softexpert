<?php 

namespace Model;

use Model\Base;

class Tipo extends Base
{
    public function __construct () {
        parent::__construct();
        self::setTableName('produto.tipo');
    }
}
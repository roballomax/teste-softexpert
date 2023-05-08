<?php 

namespace Model;

class Venda extends Base
{
    public function __construct () {
        parent::__construct();
        self::setTableName('comercial.venda');
    }
}
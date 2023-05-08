<?php 

namespace Model;

class Produto extends Base
{
    public function __construct () {
        parent::__construct();
        self::setTableName('produto.produto');
    }
}
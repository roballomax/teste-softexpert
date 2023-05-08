<?php 

namespace Model;

class ProdutoVenda extends Base
{
    public function __construct () {
        parent::__construct();
        self::setTableName('comercial.produto_venda');
    }
}
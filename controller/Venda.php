<?php
namespace Controller;

use Config\View;
use Config\Helper;
use Model\Produto AS ProdutoModel;
use Model\Venda AS VendaModel;
use Model\ProdutoVenda AS ProdutoVendaModel;

class Venda extends Base {
    
    public function __construct() {
        self::setTitle('Venda de Produtos');
    }

    public function index() 
    {

        //busca os produtos para dar a opção de adicionar an tela de venda
        $_modelProduto = new ProdutoModel();
        $_produto  = $_modelProduto->select([
            'id',
            'nome'
        ]);

        //pega a venda que está em aberto
        $_modelVenda    = new VendaModel();
        $_vendaEmAberto = $_modelVenda->select(['id'], [
            'concluida' => [
                'condicao'      => 'AND', 
                'comparador'    => '=',
                'valor'         => 0
                ]
            ], [], 'id DESC')[0];

        
            //caso não haja uma venda em aberto, ele cria uma para ser administrada na tela de venda
            if($_vendaEmAberto == null) {
                
                $_vendaEmAberto = $_modelVenda->insert([
                    'concluida' => 0
                ], true);

            }


        //inicia a posição de produto, para conter o que será vendido
        $_vendaEmAberto['_produto'] = [];

        if($_vendaEmAberto != null) {
            //busca os produtos que ja estão associados a venda
            $_vendaEmAberto['_produto'] = $_modelProduto->select([
                'produto.produto.id AS produto_id', 
                'produto.produto.nome AS produto_nome',
                'produto.produto.valor AS produto_valor',

                'produto.tipo.nome AS tipo_nome',
                'produto.tipo.imposto AS tipo_imposto',
                
                'comercial.produto_venda.id',
                'comercial.produto_venda.quantidade',
            ], [
                'comercial.produto_venda.venda_id' => [
                    'condicao'      => 'AND', 
                    'comparador'    => '=',
                    'valor'         => $_vendaEmAberto['id']
                    ]
            ], [
                'LEFT JOIN produto.tipo ON (produto.produto.tipo_id = produto.tipo.id)',
                'LEFT JOIN comercial.produto_venda ON (produto.produto.id = comercial.produto_venda.produto_id)',
            ]);

        }

        //retorna dados para a view
        View::view('venda/index', [
            '_produto' => $_produto,
            '_vendaEmAberto' => $_vendaEmAberto,
            '_total' => [
                'produto'   => 0,
                'imposto'   => 0,
                'geral'     => 0,
            ]
        ]);
    }

    public function adicionarProduto() 
    {
        //verifica se o metodo de acesso a esta view é um post
        if(empty($_POST)) {
            Helper::redirect('Venda', 'index', ['msg' => 'Método não permitido']);
        }

        //trata os dados do produto que será associado a esta venda
        $_campo = [];
        $_campo['produto_id']   = intval($_POST['produto']);
        $_campo['venda_id']     = intval($_POST['venda_id']);
        $_campo['quantidade']   = intval($_POST['quantidade']);

        //associa o produto à venda        
        $_modelProdutoVenda = new ProdutoVendaModel();
        if($_modelProdutoVenda->insert($_campo)) {
            Helper::redirect('Venda', 'index');
        } else {
            Helper::redirect('Venda', 'index', ['msg' => 'Falha ao adicionar produto à venda!']);
        }
    }

    public function removerProduto() 
    {
        //verifica se o id do produto foi informado para desassocialo da venda
        if(empty($_GET['id'])) {
            Helper::redirect('Venda', 'index', ['msg' => 'Ocorreu um erro ao tentar remover o produto, tente novamente.']);
        }

        //busca o id da venda para remover o produto
        $_modelVenda    = new VendaModel();
        $_vendaEmAberto = $_modelVenda->select(['id'], [
            'concluida' => [
                'condicao'      => 'AND', 
                'comparador'    => '=',
                'valor'         => 0
                ]
            ], [], 'id DESC')[0];

        $id     = intval($_GET['produto_venda_id']);
        $model  = new ProdutoVendaModel();
        
        $_where = [
            'id' => [
                'condicao'      => 'AND',
                'comparador'    => '=',
                'valor'         => $id,
            ],
            'venda_id' => [
                'condicao'      => 'AND',
                'comparador'    => '=',
                'valor'         => $_vendaEmAberto ['id'],
            ],
        ];

        //remove o produto da venda
        if($model->delete($_where)) {
            Helper::redirect('Venda', 'index', ['msg' => 'Produto removido com sucesso.']);
        } else {
            Helper::redirect('Venda', 'index', ['msg' => 'Falha ao remover o produto, tente novamente.']);
        }
    }

    public function efetuarVenda() 
    {
        //busca os dados da venda em aberto
        $_modelVenda    = new VendaModel();
        $_vendaEmAberto = $_modelVenda->select(['id'], [
            'concluida' => [
                'condicao'      => 'AND', 
                'comparador'    => '=',
                'valor'         => 0
                ]
            ], [], 'id DESC')[0];

        $_campo = [
            'concluida' => 1
        ];

        $_where = [
            'id' => [
                'condicao'      => 'AND',
                'comparador'    => '=',
                'valor'         => $_vendaEmAberto['id'],
            ]
        ];

        //fecah a venda
        if($_modelVenda->update($_campo, $_where)) {

            //abre uma nova venda
            $_modelVenda->insert([
                'concluida' => 0
            ]);

            Helper::redirect('Venda', 'index', ['msg' => 'Venda efetuada com sucesso.']);
        } else {
            Helper::redirect('Venda', 'index', ['msg' => 'Falha ao efetuar a venda, tente novamente.']);
        }
    }

}
<?php
namespace Controller;

use Config\View;
use Config\Helper;
use Model\Produto AS ProdutoModel;
use Model\Tipo AS TipoModel;

class Produto extends Base {
    
    public function __construct() {
        self::setTitle('Produtos');
    }

    public function index() 
    {
        $_modelTipoProduto  = new TipoModel();
        $_modelProduto      = new ProdutoModel();
        $_produto           = $_modelProduto->select(
            [
                'produto.produto.id', 
                'produto.produto.nome', 
                'produto.produto.valor',
                't.nome AS tipo'
            ], 
            ['1' => ['condicao' => 'AND', 'comparador' => '=','valor' => 1]],
            [
                'LEFT JOIN produto.tipo t ON (produto.produto.tipo_id = t.id)'
            ]
        );
        $mostraListagem = $_modelTipoProduto->select(
            ['id']
        );

        View::view('produto/index', [
            'mostraListagem' => count($mostraListagem) > 0,
            '_produto' => $_produto,
        ]);
    }

    public function cadastrar() 
    {
        $_model = new TipoModel();

        $_tipo = $_model->select([
            'id',
            'nome'
        ]);

        View::view('produto/form', [
            'titulo'    => 'Cadastro',
            'submit'    => 'Cadastrar',
            'urlForm'   => 'adicionar',
            '_tipo'     => $_tipo
        ]);
    }

    public function adicionar() 
    {
        if(empty($_POST)) {
            Helper::redirect('Produto', 'index', ['msg' => 'Método não permitido']);
        }

        $_campo = [];
        $_campo['nome']     = $_POST['nome'];
        $_campo['tipo_id']  = intval($_POST['tipo']);
        $_campo['valor']    = Helper::doubleToSave($_POST['valor']);
        $_model = new ProdutoModel();
        
        if($_model->insert($_campo)) {
            Helper::redirect('Produto', 'index', ['msg' => 'Produto cadastrado com sucesso.']);
        } else {
            Helper::redirect('Produto', 'cadastrar', ['msg' => 'Falha ao cadastrar o produto, tente novamente.']);
        }
    }

    public function editar() 
    {
        if(empty($_GET['id'])) {
            Helper::redirect('Tipo', 'index', ['msg' => 'Ocorreu um erro ao tentar recuperar o produto para edição, tente novamente.']);
        }

        $id = intval($_GET['id']);

        $model  = new ProdutoModel();
        $_produto  = $model->select(['id', 'nome', 'valor', 'tipo_id'], [
            'id' => [
                'condicao'      => 'AND',
                'comparador'    => '=',
                'valor'         => $id,
            ]
        ])[0];

        $_modelTipo = new TipoModel();

        $_tipo = $_modelTipo->select([
            'id',
            'nome'
        ]);

        View::view('produto/form', [
            'titulo'    => 'Edição',
            'submit'    => 'Editar',
            'urlForm'   => 'atualizar',
            '_tipo'     => $_tipo,
            '_produto'  => $_produto,
        ]);
    }

    public function atualizar() 
    {
        if(empty($_POST)) {
            Helper::redirect('Produto', 'index', ['msg' => 'Método não permitido']);
        }
        
        $model  = new ProdutoModel();
        $_campo = [];
        $id                 = intval($_POST['id']);
        $_campo['nome']     = $_POST['nome'];
        $_campo['tipo_id']  = intval($_POST['tipo']);
        $_campo['valor']    = Helper::doubleToSave($_POST['valor']);

        $_where = [
            'id' => [
                'condicao'      => 'AND',
                'comparador'    => '=',
                'valor'         => $id,
            ]
        ];

        //Helper::pre_var_dump($model->update($_campo, $_where));

        if($model->update($_campo, $_where)) {
            Helper::redirect('Produto', 'index', ['msg' => 'Produto atualizado com sucesso.']);
        } else {
            Helper::redirect('Produto', 'editar', ['msg' => 'Falha ao atualizar o produto, tente novamente.', 'id' => $id]);
        }
    }
    public function deletar() 
    {
        if(empty($_GET['id'])) {
            Helper::redirect('Produto', 'index', ['msg' => 'Ocorreu um erro ao tentar deletar o produto, tente novamente.']);
        }

        $id = intval($_GET['id']);
        $model  = new ProdutoModel();
        
        $_where = [
            'id' => [
                'condicao'      => 'AND',
                'comparador'    => '=',
                'valor'         => $id,
            ]
        ];

        if($model->delete($_where)) {
            Helper::redirect('Produto', 'index', ['msg' => 'Produto deletado com sucesso.']);
        } else {
            Helper::redirect('Produto', 'index', ['msg' => 'Falha ao deletar o produto, tente novamente.']);
        }
    }

}
<?php
namespace Controller;

use Config\View;
use Config\Helper;
use Model\Tipo AS TipoModel;

class Tipo extends Base {
    
    public function __construct() {
        self::setTitle('Tipos');
    }

    public function index() 
    {

        $_tipo = new TipoModel();
        $_tipo = $_tipo->select(['id', 'nome', 'imposto']);
        
        View::view('tipo/index', [
            '_tipo' => $_tipo,
        ]);
    }

    public function cadastrar() 
    {
        View::view('tipo/form', [
            'titulo'    => 'Cadastro',
            'submit'    => 'Cadastrar',
            'urlForm'   => 'adicionar',
        ]);
    }

    public function adicionar() 
    {
        if(empty($_POST)) {
            Helper::redirect('Tipo', 'index', ['msg' => 'Método não permitido']);
        }

        $_campo = [];
        $_campo['nome'] = $_POST['nome'];
        $_campo['imposto'] = Helper::doubleToSave($_POST['imposto']);
        $_model = new TipoModel();
        
        if($_model->insert($_campo)) {
            Helper::redirect('Tipo', 'index', ['msg' => 'Tipo de produto cadastrado com sucesso.']);
        } else {
            Helper::redirect('Tipo', 'cadastrar', ['msg' => 'Falha ao cadastrar o tipo de produto, tente novamente.']);
        }
    }

    public function editar() 
    {

        if(empty($_GET['id'])) {
            Helper::redirect('Tipo', 'index', ['msg' => 'Ocorreu um erro ao tentar recuperar o tipo para edição, tente novamente.']);
        }

        $id = intval($_GET['id']);

        $model  = new TipoModel();
        $_tipo  = $model->select(['id', 'nome', 'imposto'], [
            'id' => [
                'condicao'      => 'AND',
                'comparador'    => '=',
                'valor'         => $id,
            ]
        ])[0];

        View::view('tipo/form', [
            '_tipo'         => $_tipo,
            'titulo'        => 'Edição',
            'submit'        => 'Editar',
            'urlForm'       => 'atualizar',
        ]);
    }

    public function atualizar() 
    {
        if(empty($_POST)) {
            Helper::redirect('Tipo', 'index', ['msg' => 'Método não permitido']);
        }
        
        $model  = new TipoModel();
        $_campo = [];
        $id                 = intval($_POST['id']);
        $_campo['nome']     = $_POST['nome'];
        $_campo['imposto']  = Helper::doubleToSave($_POST['imposto']);

        $_where = [
            'id' => [
                'condicao'      => 'AND',
                'comparador'    => '=',
                'valor'         => $id,
            ]
        ];

        if($model->update($_campo, $_where)) {
            Helper::redirect('Tipo', 'index', ['msg' => 'Tipo de produto atualizado com sucesso.']);
        } else {
            Helper::redirect('Tipo', 'editar', ['msg' => 'Falha ao atualizar o tipo de produto, tente novamente.', 'id' => $id]);
        }
    }
    public function deletar() 
    {
        if(empty($_GET['id'])) {
            Helper::redirect('Tipo', 'index', ['msg' => 'Ocorreu um erro ao tentar deletar o tipo, tente novamente.']);
        }

        $id = intval($_GET['id']);
        $model  = new TipoModel();
        
        $_where = [
            'id' => [
                'condicao'      => 'AND',
                'comparador'    => '=',
                'valor'         => $id,
            ]
        ];

        if($model->delete($_where)) {
            Helper::redirect('Tipo', 'index', ['msg' => 'Tipo de produto deletado com sucesso.']);
        } else {
            Helper::redirect('Tipo', 'index', ['msg' => 'Falha ao deletar o tipo de produto, tente novamente.']);
        }
    }
}
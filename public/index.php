<?php 

function autoload_projeto($className)
{
    //seta os diretorios que devem ser contados para verificar
    $_diretorio     = ['config', 'controller', 'model'];
    $_class         = [];
    $caminho_raiz   = '../';
    $caminho_classe = null;

    //busca os nomes dos arquivos que estão nesses diretórios
    foreach($_diretorio as $diretorio) {

        $_arquivo = scandir($caminho_raiz . $diretorio);

        foreach ($_arquivo as $file) {
            
            if(in_array($file, ['.', '..'])) {
                continue;
            }

            $_class[] = $file;
        }
    }
    
    //pega os dados da chamada da classe e os separa em um array
    $_className = explode('\\', $className);

    try {
        //caso a classe requerida não esteja em um dos namespaces pré setados, ele 
        if( !in_array( strtolower($_className[0]), $_diretorio ) || !in_array($_className[1] . '.php', $_class) ) {
            return true;
        }

        //monta o caminho da classe
        $caminho_classe = $caminho_raiz . strtolower($_className[0]) . '/' . $_className[1] . '.php';

        //verifica se o arquivo existe, se sim, o inclui
        if(file_exists($caminho_classe)) {
            require_once($caminho_classe);
            return true;
        }

        throw new Exception('Arquivo não encontrado autoload!');
    } catch (Exception $e) {
        //caso de algum problema, retorna um exception
        echo json_encode([
            'message' => $e->getMessage(),
            'data' => [
                $caminho_classe,
                $className
            ]
        ]);
        exit;
    }
}

//registra o autoload
spl_autoload_register("autoload_projeto");
require_once('../view/base/layout.php');
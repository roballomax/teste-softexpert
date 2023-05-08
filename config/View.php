<?php 

namespace Config;

class View {

    const VIEW_PATH = '../view/';

    public function __construct() {}

    /**
     * Método que busca a view e o mostra
     *
     * @param String $viewPath
     * @param array $_parameter
     * @return void
     */
    public static function view ($viewPath, $_parameter = null) 
    {
        //verifica se tem parâmetros para passar para a view
        if(!is_null($_parameter)) {
            //percorre os parâmetros e os distribui em variáveis
            foreach($_parameter as $key => $_item) {
                //verifica se o parãmetro tem um nome, se não, é gerado um para o mesmo
                if(!is_int($key))
                    $$key = $_item;
                else
                    ${"parametro_" . $key} = $_item;
            }
        }

        //busca o arquivo da view
        include_once self::VIEW_PATH . $viewPath . '.php';
    }
}
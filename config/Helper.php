<?php

namespace Config;

class Helper {

    /**
     * Vardump estilizado
     *
     * @param mixed $_data
     * @param boolean $exit
     * @return void
     */
    public static function pre_var_dump($_data, $exit = true) {
        echo '<pre>';
            var_dump($_data);
        echo '</pre>';

        if($exit) {
            exit;
        }
    }

    /**
     * Método de redirecionamento de páginas
     *
     * @param String $controller
     * @param String $action
     * @param array $_parameter
     * @return void
     */
    public static function redirect($controller, $action, $_parameter = null) {

        $redirect = 'Location: /' . strtolower($controller) . '/' . strtolower($action);

        if(!is_null($_parameter)) {
            $redirect.= '?';
            foreach($_parameter as $key => $item) {
                $redirect .= $key . '=' . $item;
            }
        }

        header($redirect);
    }

    /**
     * Método que trata números com vírgula par asalvar no banco de dados
     *
     * @param String $number
     * @return double
     */
    public static function doubleToSave($number) {
        return str_replace(',', '.', $number);
    }

    /**
     * Método que trata números com vírgula par asalvar no banco de dados
     *
     * @param String $number
     * @return double
     */
    public static function doubleToShow($number) {
        return str_replace('.', ',', $number);
    }

}
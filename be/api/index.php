<?php
header('Content-Type: application/json; charset=utf-8');

require_once 'class/Produto.php';

class Rest
{
    public static function open($requisicao)
    {
        $url = explode('/', $requisicao['url']);
        $classe = ucfirst($url[0]);
        array_shift($url);

        $metodo = $url[0];
        array_shift($url);

        $parametros = array();
        $parametros = $url;

        try {
            if (class_exists($classe)) {
                if (method_exists($classe, $metodo)) {
                    $retorno = call_user_func_array(array(new $classe, $metodo), $parametros);
                    return json_encode(array('status' => 'sucesso', 'data' => $retorno));
                } else {
                    return json_encode(array('status' => 'erro', 'data' => 'Método inexistente'));
                }
            } else {
                return json_encode(array('status' => 'erro', 'data' => 'Classe inexistente'));
            }
        } catch (Exception $e) {
            return json_encode(array('status' =>'erro', 'data' => $e->getMessage()));
        }
    }
}

if(isset($_REQUEST)) {
    echo Rest::open($_REQUEST);
}
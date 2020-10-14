<?php

namespace Recaptcha;

class Rest 
{
    private $request;
    private $class;
    private $method;
    private $params = array();

    public function __construct($req)
    {
        $this->request = $req;
        $this->load();
    }

    public function load()
    {
        $newUrl = explode('/', $this->request['url']);
        //array_shift($newUrl);

        if(isset($newUrl[0])) {            
            $this->class = ucfirst($newUrl[0]).'Controller';
            array_shift($newUrl);  
            if(isset($newUrl[0])) {
                $this->method = $newUrl[0];
                array_shift($newUrl);                

                if(isset($newUrl[0])) {
                    $this->params = $newUrl;
                }
            }
        }
    }

    public function run()
    {
        if(class_exists('Recaptcha\Controllers\\'.$this->class) && 
        method_exists('Recaptcha\Controllers\\'.$this->class, $this->method)) {
            try {
                $control = 'Recaptcha\Controllers\\'.$this->class;
                $response = call_user_func_array(array(new $control, $this->method), $this->params);
                return json_encode(array('data' => $response, 'status' => 'success'));

            } catch(\Exception $e) {
                return json_encode(array('data' => $e->getMessage(), 'status' => 'error'));
            }
        } else {
            return json_encode(array('data' => 'Operação inválida', 'status' => 'error'));
        }
    }
}
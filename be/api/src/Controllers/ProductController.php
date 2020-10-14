<?php
namespace Recaptcha\Controllers;

class ProductController
{
    public function show()
    {
        $con = new \PDO('mysql: host=localhost; dbname=base_teste;',
            'teste',
            '123@456'
        );

        $sql = "SELECT id, name FROM produtos";
        $sql = $con->prepare($sql);
        $sql->execute();

        $resultados = array();

        while($row = $sql->fetch(\PDO::FETCH_ASSOC)) {
            $resultados[] = $row;
        }

        if(!$resultados) {
            throw new \Exception("Nenhum produto no estoque!");
        }

        return $resultados;

    }
}
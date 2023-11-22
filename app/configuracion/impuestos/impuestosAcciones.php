<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../../clasesGenericas/DataTable.php';
require_once '../../../clasesGenericas/ConectorBD.php';
require_once '../../../clases/app/Impuesto.php';

if(isset($_POST['accion'])){
    switch ($_POST['accion']) {
        case 'Adicionar':
            $objeto = new Impuesto($_POST);
            $objeto->guardar();
            break;
        case 'Modificar':
            $objeto = new Impuesto($_POST);
            $objeto->modificar();
            break;
        case 'Eliminar':
            $objeto = new Impuesto(null);
            $objeto->setId($_POST['id']);
            $objeto->eliminar();
            break;
        case 'Listar':
            $table = 'impuesto';

            $primaryKey = 'id';

            $columns = array(
                array('db' => 'id', 'dt' => 0),
                array('db' => 'nombre', 'dt' => 1),
                array('db' => 'porcentaje', 'dt' => 2),
            );

            echo json_encode(DataTable::simple($_POST, $table, $primaryKey, $columns));
            break;
        default : break;
    }
}
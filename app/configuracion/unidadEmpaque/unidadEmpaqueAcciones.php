<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../../clasesGenericas/DataTable.php';
require_once '../../../clasesGenericas/ConectorBD.php';
require_once '../../../clases/app/UnidadEmpaque.php';

if(isset($_POST['accion'])){
    switch ($_POST['accion']) {
        case 'Adicionar':
            $objeto = new UnidadEmpaque($_POST);
            $objeto->guardar();
            break;
        case 'Modificar':
            $objeto = new UnidadEmpaque($_POST);
            $objeto->modificar();
            break;
        case 'Eliminar':
            $objeto = new UnidadEmpaque(null);
            $objeto->setId($_POST['id']);
            $objeto->eliminar();
            break;
        case 'Listar':
            $table = 'unidadEmpaque';

            $primaryKey = 'id';

            $columns = array(
                array('db' => 'id', 'dt' => 0),
                array('db' => 'unidad', 'dt' => 1),
                array('db' => 'observaciones', 'dt' => 2),
            );

            echo json_encode(DataTable::simple($_POST, $table, $primaryKey, $columns));
            break;
        default : break;
    }
}
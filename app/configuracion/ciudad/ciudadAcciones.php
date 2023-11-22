<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../../clasesGenericas/DataTable.php';
require_once '../../../clasesGenericas/ConectorBD.php';
require_once '../../../clases/app/Ciudad.php';

if(isset($_POST['accion'])){
    switch ($_POST['accion']) {
        case 'Adicionar':
            $objeto = new Ciudad($_POST);
            $objeto->guardar();
            break;
        case 'Modificar':
            $objeto = new Ciudad($_POST);
            $objeto->modificar($_POST['codigoAnterior']);
            break;
        case 'Eliminar':
            $objeto = new Ciudad(null);
            $objeto->setCodigo($_POST['codigo']);
            $objeto->eliminar();
            break;
        case 'Listar':
            $table = 'ciudad';

            $primaryKey = 'codigo';

            $columns = array(
                array('db' => 'codigo', 'dt' => 0),
                array('db' => 'nombre', 'dt' => 1),
                array(
                    'db'        => 'porcentaje',
                    'dt'        => 2,
                    'formatter' => function( $d, $row ) {
                        return $d * 100;
                    },
                    'field' => 'porcentaje', 'as' => 'flete'
                ),
            );

            echo json_encode(DataTable::simple($_POST, $table, $primaryKey, $columns));
            break;
        default : break;
    }
}
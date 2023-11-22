<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../../clasesGenericas/DataTable.php';
require_once '../../../clasesGenericas/ConectorBD.php';
require_once '../../../clases/app/Perfil.php';
require_once '../../../clases/app/Opcion.php';

if(isset($_POST['accion'])){
    switch ($_POST['accion']) {
        case 'Adicionar':
            $objeto = new Perfil($_POST);
            $objeto->guardar();
            break;
        case 'Modificar':
            $objeto = new Perfil($_POST);
            $objeto->modificar();
            break;
        case 'Eliminar':
            $objeto = new Perfil(null);
            $objeto->setId($_POST['id']);
            $objeto->eliminar();
            break;
        case 'Accesos':
            $accesos = '';
            $perfil = new Perfil($_POST['id']);
            foreach ($_POST as $variable => $valor) {
                $auxiliar = '';
                if ($accesos != '') $auxiliar = ',';
                if (substr($variable, 0, 3) == 'id_') $accesos .= $auxiliar . substr($variable, 3);
            }
            $perfil->guardarAccesos($accesos);
            break;
        case 'Listar':
            $table = 'perfil';

            $primaryKey = 'id';

            $columns = array(
                array('db' => 'id', 'dt' => 0, 'field' => 'id', 'as' => 'id'),
                array('db' => 'nombre', 'dt' => 1, 'field' => 'nombre', 'as' => 'nombre'),
                array('db' => 'descripcion', 'dt' => 2, 'field' => 'descripcion', 'as' => 'descripcion'),
            );

            echo json_encode(DataTable::simple($_POST, $table, $primaryKey, $columns));
            break; 
        default : break;
    }
}
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../../clasesGenericas/DataTable.php';
require_once '../../../clasesGenericas/ConectorBD.php';
require_once '../../../clases/app/Grupo.php';
require_once '../../../clases/app/Linea.php';

if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        case 'Adicionar':
            $objeto = new Grupo($_POST);
            $objeto->guardar();
            break;
        case 'Modificar':
            $objeto = new Grupo($_POST);
            $objeto->modificar();
            break;
        case 'Eliminar':
            $objeto = new Grupo(null);
            $objeto->setId($_POST['id']);
            $objeto->eliminar();
            break;
        case 'Mostrar':
            $lista = '';
            $objeto = new Grupo($_POST['id']);
            $array = array(
                "id" => $objeto->getId(),
                "nombre" => $objeto->getNombre(),
                "idLinea" => $objeto->getIdLinea()
            );
            echo json_encode($array);
            break;
        case 'SelectLinea':
            echo Linea::getListaEnOptions();
            break;
        case 'Listar':
            $table = '( select grupo.id, grupo.nombre as grupo, linea.nombre as linea from grupo join linea on idLInea=linea.id ) temp';

            $primaryKey = 'id';

            $columns = array(
                array('db' => 'id', 'dt' => 0),
                array('db' => 'grupo', 'dt' => 1),
                array('db' => 'linea', 'dt' => 2)
            );

            echo json_encode(DataTable::simple($_POST, $table, $primaryKey, $columns));
            break;
        default : break;
    }
}
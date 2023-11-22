<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../../clasesGenericas/DataTable.php';
require_once '../../../clasesGenericas/ConectorBD.php';
require_once '../../../clases/app/Producto.php';
require_once '../../../clases/app/DescuentoProducto.php';

if(isset($_POST['accion'])){
    switch ($_POST['accion']) {
        case 'Adicionar':
            $objeto = new DescuentoProducto($_POST);
            $objeto->guardar();
            break;
        case 'Modificar':
            $objeto = new DescuentoProducto($_POST);
            $objeto->modificar();
            break;
        case 'Eliminar':
            $objeto = new DescuentoProducto(null);
            $objeto->setId($_POST['id']);
            $objeto->eliminar();
            break;
        case 'Mostrar':
            $objeto = new DescuentoProducto($_POST['id']);
            $array = array(
                "nombreGrupo" => $objeto->getNombreGrupo(),
                "tipo" => $objeto->getTipo(),
                "margenXVolumen" => $objeto->getMargenXVolumen(),
                "margenXEmpaque" => $objeto->getMargenXEmpaque(),
                "margenXTipo" => $objeto->getMargenXTipo(),
            );
            echo json_encode($array);
            break;
        case 'Listar':
            $table = 'descuentoProducto';

            $primaryKey = 'id';

            $columns = array(
                array('db' => "id", 'dt' => 0),
                array('db' => "CASE WHEN tipo = '0' THEN 'Sin clasificar' WHEN tipo = '1' THEN 'Mayorista' WHEN tipo = '2' THEN 'Peluqueria' WHEN tipo = '3' THEN 'Publico' ELSE 'Desconocido' END", 'dt' => 1),
                array('db' => 'nombreGrupo', 'dt' => 2),
                array('db' => 'margenXVolumen', 'dt' => 3),
                array('db' => 'margenXEmpaque', 'dt' => 4),
                array('db' => 'margenXTipo', 'dt' => 5),
            );

            echo json_encode(DataTable::simple($_POST, $table, $primaryKey, $columns));
            break;
        default : break;
    }
}

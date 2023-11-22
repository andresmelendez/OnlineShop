<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../../clasesGenericas/DataTable.php';
require_once '../../../clasesGenericas/ConectorBD.php';
require_once '../../../clases/app/Inventario.php';

if(isset($_POST['accion'])){
    switch ($_POST['accion']) {
        case 'Listar':
            $table = '(SELECT inventario.id, codigo, descripcion, pedido, comprometido, stock, stock - comprometido AS disponible FROM inventario JOIN producto on codigoProducto=producto.codigo) temp';

            $primaryKey = 'id';

            $columns = array(
                array('db' => 'id', 'dt' => 0, 'field' => 'id'),
                array('db' => 'codigo', 'dt' => 1, 'field' => 'codigo'),
                array('db' => 'descripcion', 'dt' => 2, 'field' => 'descripcion'),
                array('db' => "pedido", 'dt' => 3, 'field' => "pedidoOC"),
                array('db' => "comprometido", 'dt' => 4, 'field' => "comprometido"),
                array('db' => "stock", 'dt' => 5, 'field' => "stock"),
                array('db' => "disponible", 'dt' => 6, 'field' => "disponible")
            );

            echo json_encode(DataTable::simple($_POST, $table, $primaryKey, $columns));
            break;
        case 'Modificar':
            $objeto = new Inventario($_POST['id']);
            $objeto->setId($_POST['id']);
            $objeto->setCodigoProducto($_POST['codigoProducto']);
            $objeto->setStock($_POST['stock']);
            $objeto->modificar();
            break;
    }
}
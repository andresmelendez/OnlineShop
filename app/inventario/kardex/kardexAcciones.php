<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../../clasesGenericas/DataTable.php';
require_once '../../../clasesGenericas/ConectorBD.php';
require_once '../../../clases/app/Producto.php';

if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        case 'Listar':
            $codigo = isset($_POST['product']) ? $_POST['product'] : '';
            
            $table = "(select * from kardex where codigo = '$codigo') temp";

            $primaryKey = 'id';

            $columns = array(
                array('db' => 'id', 'dt' => 0, 'field' => 'id'),
                array('db' => 'fecha', 'dt' => 1, 'field' => 'fecha'),
                array('db' => 'codigo', 'dt' => 2, 'field' => 'codigo'),
                array('db' => "empresa", 'dt' => 3, 'field' => "empresa"),
                array('db' => "descripcion", 'dt' => 4, 'field' => "descripcion"),
                array('db' => "cantidadRecibida", 'dt' => 5, 'field' => "cantidadRecibida"),
                array('db' => "balance", 'dt' => 6, 'field' => "balance"),
                array('db' => "tipoMovimiento", 'dt' => 7, 'field' => "tipoMovimiento")
            );

            echo json_encode(DataTable::simple($_POST, $table, $primaryKey, $columns));
            break;
        case 'Producto':
            $lista = '';
            $filtro = str_replace(" ", "%", !empty($_POST['producto']) ? $_POST['producto'] : '');
            $objeto = Producto::getLista("codigo like '%$filtro%' or descripcion like '%$filtro%'", 'codigo limit 30');
            if ($objeto != null) {
                $lista .= '<div class="dropdown-menu show" aria-labelledby="navbarDropdown" style="display: block; width: 100%; max-height:300px; overflow-y: scroll; border-radius: 10px; scroll-behavior: smooth;">';
                for ($i = 0; $i < count($objeto); $i++) {
                    $objetos = $objeto[$i];
                    $lista .= "<a class='dropdown-item' style='white-space: normal' data='{$objetos['codigo']} - {$objetos['descripcion']}' id='{$objetos['codigo']}'>{$objetos['codigo']} {$objetos['descripcion']}</a><div class='dropdown-divider'></div>";
                }
                $lista .= '</div>';
            }
            echo $lista;
            break;
        default : break;
    }
}
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../../clasesGenericas/DataTable.php';
require_once '../../../clasesGenericas/ConectorBD.php';
require_once '../../../clases/app/Usuarios.php';
require_once '../../../clases/app/Ciudad.php';

if(isset($_POST['accion'])){
    switch ($_POST['accion']) {
        case 'Adicionar':
            $objeto = new Usuarios(null);
            $objeto->setNit($_POST['nit']);
            $objeto->setNombres($_POST['nombres']);
            $objeto->setApellidos($_POST['apellidos']);
            $objeto->setNombreComercial($_POST['nombreComercial']);
            $objeto->setCelular($_POST['celular']);
            $objeto->setClave($_POST['clave']);
            $objeto->setCodigoCiudad($_POST['codigoCiudad']);
            $objeto->setObservaciones($_POST['observaciones']);
            $objeto->setIdPerfil(4);
            $objeto->setEstado('Y');
            $objeto->guardar();
            break;
        case 'Modificar':
            $objeto = new Usuarios(null);
            $objeto->setNit($_POST['nit']);
            $objeto->setNombres($_POST['nombres']);
            $objeto->setApellidos($_POST['apellidos']);
            $objeto->setNombreComercial($_POST['nombreComercial']);
            $objeto->setCelular($_POST['celular']);
            $objeto->setClave($_POST['clave']);
            $objeto->setCodigoCiudad($_POST['codigoCiudad']);
            $objeto->setObservaciones($_POST['observaciones']);
            $objeto->setIdPerfil(4);
            $objeto->setEstado('Y');
            $objeto->modificar($_POST['nitAnterior']);
            break;
        case 'Eliminar':
            $objeto = new Usuarios(null);
            $objeto->setNit($_POST['nit']);
            $objeto->eliminar();
            break;
        case 'Mostrar':
            $lista='';
            $objeto = new Usuarios($_POST['nit']);
            $array = array(
                "nit" => $objeto->getNit(),
                "nombres" => $objeto->getNombres(),
                "apellidos" => $objeto->getApellidos(),
                "nombreComercial" => $objeto->getNombreComercial(),
                "celular" => $objeto->getCelular(),
                "codigoCiudad" => $objeto->getCodigoCiudad(),
                "clave" => $objeto->getClave(),
                "observaciones" => $objeto->getObservaciones(),
            );
            echo json_encode($array);
            break;
        case 'SelectCiudad':
            echo Ciudad::getListaEnOptions();
            break; 
        case 'Listar':
            $table = '(SELECT nit, nombres, apellidos, nombreComercial, celular, ciudad.nombre AS ciudad, descuentoComercial, descuentoFinanciero, bonificacion, observaciones FROM usuarios LEFT JOIN ciudad ON codigoCiudad = ciudad.codigo WHERE idPerfil = 4) temp';

            $primaryKey = 'nit';

            $columns = array(
                array('db' => 'nit', 'dt' => 0),
                array('db' => 'nombres', 'dt' => 1),
                array('db' => 'apellidos', 'dt' => 2),
                array('db' => 'nombreComercial', 'dt' => 3),
                array('db' => 'celular', 'dt' => 4),
                array('db' => 'ciudad', 'dt' => 5),
                array('db' => 'observaciones', 'dt' => 6),
            );

            echo json_encode(DataTable::simple($_POST, $table, $primaryKey, $columns));
            break;
        default : break;
    }
}
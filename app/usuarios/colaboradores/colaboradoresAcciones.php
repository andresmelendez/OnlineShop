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
require_once '../../../clases/app/Perfil.php';

if(isset($_POST['accion'])){
    switch ($_POST['accion']) {
        case 'Adicionar':
            $objeto = new Usuarios(null);
            $objeto->setNit($_POST['identificacion']);
            $objeto->setNombres($_POST['nombres']);
            $objeto->setApellidos($_POST['apellidos']);
            $objeto->setClave($_POST['clave']);
            $objeto->setIdPerfil($_POST['perfil']);
            $objeto->setCodigoCiudad($_POST['codigoCiudad']);
            $objeto->guardar();
            break;
        case 'Modificar':
            $objeto = new Usuarios(null);
            $objeto->setNit($_POST['identificacion']);
            $objeto->setNombres($_POST['nombres']);
            $objeto->setApellidos($_POST['apellidos']);
            $objeto->setClave($_POST['clave']);
            $objeto->setIdPerfil($_POST['perfil']);
            $objeto->setCodigoCiudad($_POST['codigoCiudad']);
            $objeto->modificar($_POST['identificacionAnterior']);
            break;
        case 'Eliminar':
            $objeto = new Usuarios(null);
            $objeto->setNit($_POST['identificacion']);
            $objeto->eliminar();
            break;
        case 'Mostrar':
            $objeto = new Usuarios($_POST['identificacion']);
            $array = array(
                "identificacion" => $objeto->getNit(),
                "nombres" => $objeto->getNombres(),
                "apellidos" => $objeto->getApellidos(),
                "codigoCiudad" => $objeto->getCodigoCiudad(),
                "clave" => $objeto->getClave(),
                "perfil" => $objeto->getIdPerfil()
            );
            echo json_encode($array);
            break;
        case 'SelectCiudad':
            echo Ciudad::getListaEnOptions();
            break; 
        case 'SelectPerfil':
            echo Perfil::getListaEnOptions("id NOT IN (1,2,4)");
            break; 
        case 'Listar':
            $table = '(SELECT nit, nombres, apellidos, ciudad.nombre AS ciudad, perfil.nombre AS perfil FROM usuarios LEFT JOIN ciudad ON codigoCiudad = ciudad.codigo JOIN perfil ON perfil.id = usuarios.idPerfil WHERE idPerfil NOT IN (1,2,4)) temp';

            $primaryKey = 'nit';

            $columns = array(
                array('db' => 'nit', 'dt' => 0),
                array('db' => 'nombres', 'dt' => 1),
                array('db' => 'apellidos', 'dt' => 2),
                array('db' => 'ciudad', 'dt' => 3),
                array('db' => 'perfil', 'dt' => 4)
            );

            echo json_encode(DataTable::simple($_POST, $table, $primaryKey, $columns));
            break;
        default : break;
    }
}
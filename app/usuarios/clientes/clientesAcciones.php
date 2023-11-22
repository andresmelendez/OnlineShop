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
            $objeto->setEmail($_POST['email']);
            $objeto->setCodigoCiudad($_POST['codigoCiudad']);
            $objeto->setBarrio($_POST['barrio']);
            $objeto->setDireccion($_POST['direccion']);
            $objeto->setIdPerfil('2');
            $objeto->setTipoNegocios($_POST['tipoNegocio']);
            $objeto->setTipoPrecios($_POST['tipoPrecios']);
            $objeto->setClave($_POST['clave']);
            $objeto->setCupo($_POST['cupo']);
            $objeto->guardar();
            break;
        case 'Modificar':
            $objeto = new Usuarios(null);
            $objeto->setNit($_POST['nit']);
            $objeto->setNombres($_POST['nombres']);
            $objeto->setApellidos($_POST['apellidos']);
            $objeto->setNombreComercial($_POST['nombreComercial']);
            $objeto->setCelular($_POST['celular']);
            $objeto->setEmail($_POST['email']);
            $objeto->setCodigoCiudad($_POST['codigoCiudad']);
            $objeto->setBarrio($_POST['barrio']);
            $objeto->setDireccion($_POST['direccion']);
            $objeto->setIdPerfil('2');
            $objeto->setTipoNegocios($_POST['tipoNegocio']);
            $objeto->setTipoPrecios($_POST['tipoPrecios']);
            $objeto->setClave($_POST['clave']);
            $objeto->setCupo($_POST['cupo']);
            $objeto->modificar($_POST['nitAnterior']);
            break;
        case 'Eliminar':
            $objeto = new Usuarios(null);
            $objeto->setNit($_POST['nit']);
            $objeto->eliminar();
            break;
        case 'Mostrar':
            $objeto = new Usuarios($_POST['nit']);
            $array = array(
                "nit" => $objeto->getNit(),
                "nombres" => $objeto->getNombres(),
                "apellidos" => $objeto->getApellidos(),
                "nombreComercial" => $objeto->getNombreComercial(),
                "celular" => $objeto->getCelular(),
                "email" => $objeto->getEmail(),
                "codigoCiudad" => $objeto->getCodigoCiudad(),
                "barrio" => $objeto->getBarrio(),
                "direccion" => $objeto->getDireccion(),
                "tipoNegocios" => $objeto->getTipoNegocios(),
                "tipoPrecios" => $objeto->getTipoPrecios(),
                "clave" => $objeto->getClave(),
                "cupo" => $objeto->getCupo()
            );
            echo json_encode($array);
            break;
        case 'SelectCiudad':
            echo Ciudad::getListaEnOptions();
            break; 
        case 'Listar':
            $table = "(select nit, nombres, apellidos, nombreComercial, celular, CASE WHEN tipoPrecios = '0' THEN 'Sin clasificar' WHEN tipoPrecios = '1' THEN 'Mayorista' WHEN tipoPrecios = '2' THEN 'Peluqueria' WHEN tipoPrecios = '3' THEN 'Publico' ELSE 'Desconocido' END as tipoPreciosUsuario, tipoNegocios, ciudad.nombre as nombreCiudad, barrio, direccion from usuarios join ciudad on codigoCiudad=ciudad.codigo where idPerfil = '2') temp";

            $primaryKey = 'nit';

            $columns = array(
                array('db' => 'nit', 'dt' => 0),
                array('db' => 'nombres', 'dt' => 1),
                array('db' => 'apellidos', 'dt' => 2),
                array('db' => 'nombreComercial', 'dt' => 3),
                array('db' => 'celular', 'dt' => 4),
                array('db' => 'tipoPreciosUsuario', 'dt' => 5),
                array('db' => 'tipoNegocios', 'dt' => 6),
                array('db' => 'nombreCiudad', 'dt' => 7),
                array('db' => 'barrio', 'dt' => 8),
                array('db' => 'direccion', 'dt' => 9)
            );

            echo json_encode(DataTable::simple($_POST, $table, $primaryKey, $columns));
            break;
        default : break;
    }
}
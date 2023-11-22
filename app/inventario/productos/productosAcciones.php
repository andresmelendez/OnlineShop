<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../../clasesGenericas/DataTable.php';
require_once '../../../clasesGenericas/ConectorBD.php';
require_once '../../../clases/app/Almacen.php';
require_once '../../../clases/app/Grupo.php';
require_once '../../../clases/app/Linea.php';
require_once '../../../clases/app/Marca.php';
require_once '../../../clases/app/Producto.php';
require_once '../../../clases/app/UnidadEmpaque.php';
require_once '../../../clases/app/Impuesto.php';
require_once '../../../clases/app/Inventario.php';
require_once '../../../clases/app/DescuentoProducto.php';
require_once '../../../clases/app/ProductoUsuario.php';

if(isset($_POST['accion'])){
    switch ($_POST['accion']) {
        case 'Adicionar':
            $objeto = new Producto(null);
            $objeto->setCodigo($_POST['codigo']);
            $objeto->setDescripcion($_POST['descripcion']);
            $objeto->setIdMarca($_POST['idMarca']);
            $objeto->setIdGrupo($_POST['idGrupo']);
            $objeto->setIdImpuesto($_POST['idImpuesto']);
            $objeto->setIdUnidadCompra($_POST['idUnidadCompra']);
            $objeto->setCantidadCompra($_POST['cantidadCompra']);
            $objeto->setIdUnidadVenta($_POST['idUnidadVenta']);
            $objeto->setCantidadVenta($_POST['cantidadVenta']);
            $objeto->setCantidadVolumen($_POST['cantidadVolumen']);
            $objeto->setCodigoDeBarras($_POST['codigoDeBarras']);
            $objeto->setPrecio($_POST['precio']);
            $objeto->setCosto($_POST['costo']);
            $objeto->setPromocion($_POST['promocion']);
            $objeto->setTipoServicio($_POST['tipoServicio']);
            $objeto->setEstado($_POST['estado']);
            $objeto->setCaracteristicas($_POST['caracteristicas']);
            if (isset($_FILES['foto']['name'])) {
                $extension = substr($_FILES['foto']['name'], strripos($_FILES['foto']['name'], '.'));
                if (!empty($extension)) {
                    $foto = $_POST['codigo'] . $extension;
                    $objeto->setFoto($foto);
                    move_uploaded_file($_FILES['foto']['tmp_name'], '../../../../fotos/' . $foto);
                }else{
                    $objeto->setFoto($_POST['fotoAnterior']);
                }
            }
            if (isset($_FILES['foto1']['name'])) {
                $extension = substr($_FILES['foto1']['name'], strripos($_FILES['foto1']['name'], '.'));
                if (!empty($extension)) {
                    $foto1 = $_POST['codigo'] . '_1' . $extension;
                    $objeto->setFoto1($foto1);
                    move_uploaded_file($_FILES['foto1']['tmp_name'], '../../../../fotos/' . $foto1);
                }
            }
            if (isset($_FILES['foto2']['name'])) {
                $extension = substr($_FILES['foto2']['name'], strripos($_FILES['foto2']['name'], '.'));
                if (!empty($extension)) {
                    $foto2 = $_POST['codigo'] . '_2' . $extension;
                    $objeto->setFoto2($foto2);
                    move_uploaded_file($_FILES['foto2']['tmp_name'], '../../../../fotos/' . $foto2);
                }
            }
            $objeto->guardar();
            
            $proveedores = json_decode($_POST["nitProveedor"],TRUE);
            if(count($proveedores) > 0){
                for ($i = 0; $i < count($proveedores); $i++) {
                    $proveedor = $proveedores[$i];
                    $proveedorNit = new ProductoUsuario(null);
                    $proveedorNit->setNitUsuario($proveedor['value']);
                    $proveedorNit->setCodigoProducto($_POST['codigo']);
                    $proveedorNit->guardar();
                }
            }
            
            $bodegas = Almacen::getLista();
            if($bodegas != null){
                foreach ($bodegas as $indice => $arreglo) {
                    $inventario = new Inventario(null);
                    $inventario->setCodigoProducto($_POST['codigo']);
                    $inventario->setIdAlmacen($arreglo['id']);
                    $inventario->setComprometido(0);
                    $inventario->setPedido(0);
                    $inventario->setStock(0);
                    $inventario->setStockMaximo(0);
                    $inventario->setStockMinimo(0);
                    $inventario->guardar();
                }
            }
            break;
        case 'Modificar':
            $objeto = new Producto($_POST['codigo']);
            $objeto->setCodigo($_POST['codigo']);
            $objeto->setDescripcion($_POST['descripcion']);
            $objeto->setIdMarca($_POST['idMarca']);
            $objeto->setIdGrupo($_POST['idGrupo']);
            $objeto->setIdImpuesto($_POST['idImpuesto']);
            $objeto->setIdUnidadCompra($_POST['idUnidadCompra']);
            $objeto->setCantidadCompra($_POST['cantidadCompra']);
            $objeto->setIdUnidadVenta($_POST['idUnidadVenta']);
            $objeto->setCantidadVenta($_POST['cantidadVenta']);
            $objeto->setCantidadVolumen($_POST['cantidadVolumen']);
            $objeto->setCodigoDeBarras($_POST['codigoDeBarras']);
            $objeto->setPrecio($_POST['precio']);
            $objeto->setCosto($_POST['costo']);
            $objeto->setPromocion($_POST['promocion']);
            $objeto->setTipoServicio($_POST['tipoServicio']);
            $objeto->setEstado($_POST['estado']);
            $objeto->setCaracteristicas($_POST['caracteristicas']);
            if (isset($_FILES['foto']['name'])) {
                $extension = substr($_FILES['foto']['name'], strripos($_FILES['foto']['name'], '.'));
                if (!empty($extension)) {
                    $foto = $_POST['codigo'] . $extension;
                    $objeto->setFoto($foto);
                    move_uploaded_file($_FILES['foto']['tmp_name'], '../../../../fotos/' . $foto);
                }else{
                    $objeto->setFoto($objeto->getFoto());
                }
            }
            if (isset($_FILES['foto1']['name'])) {
                $extension = substr($_FILES['foto1']['name'], strripos($_FILES['foto1']['name'], '.'));
                if (!empty($extension)) {
                    $foto1 = $_POST['codigo'] . '_1' . $extension;
                    $objeto->setFoto1($foto1);
                    move_uploaded_file($_FILES['foto1']['tmp_name'], '../../../../fotos/' . $foto1);
                }else{
                    $objeto->setFoto1($objeto->getFoto1());
                }
            }
            if (isset($_FILES['foto2']['name'])) {
                $extension = substr($_FILES['foto2']['name'], strripos($_FILES['foto2']['name'], '.'));
                if (!empty($extension)) {
                    $foto2 = $_POST['codigo'] . '_2' . $extension;
                    $objeto->setFoto2($foto2);
                    move_uploaded_file($_FILES['foto2']['tmp_name'], '../../../../fotos/' . $foto2);
                }else{
                    $objeto->setFoto2($objeto->getFoto2());
                }
            }
            $objeto->modificar($_POST['codigoAnterior']);
            
            $proveedores = json_decode($_POST["nitProveedor"],TRUE);
            if(count($proveedores) > 0){
                $proveedorNit = new ProductoUsuario(null);
                $proveedorNit->setCodigoProducto($_POST['codigo']);
                $proveedorNit->eliminar();
                for ($i = 0; $i < count($proveedores); $i++) {
                    $proveedor = $proveedores[$i];
                    $proveedorNit->setNitUsuario($proveedor['value']);
                    $proveedorNit->setCodigoProducto($_POST['codigo']);
                    $proveedorNit->guardar();
                }
            }
            break;
        case 'Eliminar':
            $objeto = new Producto(null);
            $objeto->setCodigo($_POST['codigo']);
            $objeto->eliminar();
            break;
        case 'Mostrar':
            $objeto = new Producto($_POST['codigo']);
            $array = array(
                "codigo" => $objeto->getCodigo(),
                "descripcion" => $objeto->getDescripcion(),
                "idMarca" => $objeto->getIdMarca(),
                "idGrupo" => $objeto->getIdGrupo(),
                "idLinea" => $objeto->getGrupo()->getIdLinea(),
                "idImpuesto" => $objeto->getIdImpuesto(),
                "idUnidadCompra" => $objeto->getIdUnidadCompra(),
                "cantidadCompra" => $objeto->getCantidadCompra(),
                "idUnidadVenta" => $objeto->getIdUnidadVenta(),
                "cantidadVenta" => $objeto->getCantidadVenta(),
                "cantidadVolumen" => $objeto->getCantidadVolumen(),
                "codigoDeBarras" => $objeto->getCodigoDeBarras(),
                "precio" => $objeto->getPrecio(),
                "costo" => $objeto->getCosto(),
                "promocion" => $objeto->getPromocion(),
                "tipoServicio" => $objeto->getTipoServicio(),
                "foto" => $objeto->getFoto(),
                "foto1" => $objeto->getFoto1(),
                "foto2" => $objeto->getFoto2(),
                "estado" => $objeto->getEstado(),
                "caracteristicas" => $objeto->getCaracteristicas(),
            );
            echo json_encode($array);
            break;
        case 'CheckboxProveedor':
            $predeterminado = isset($_POST['predeterminado']) ? $_POST['predeterminado'] : '';
            echo ProductoUsuario::getListaEnOptions("codigoProducto='{$predeterminado}' where idPerfil = '4'");
        break;
        case 'SelectImpuesto':
            echo Impuesto::getListaEnOptions();
            break;
        case 'SelectUnidadEmpaque':
            echo UnidadEmpaque::getListaEnOptions();
            break;
        case 'SelectMarca':
            echo Marca::getListaEnOptions(null, null, $_POST['predeterminado']);
            break;
        case 'SelectLinea':
            echo Linea::getListaEnOptions(null, null, $_POST['predeterminado']);
            break;
        case 'SelectGrupo':
            echo Grupo::getListaEnOptions("idLinea='{$_POST['idLinea']}'", 'grupo.nombre', $_POST['predeterminado']);
            break;
        case 'Listar':
            case 'Listar':
            $table = "(select codigo, descripcion, idMarca, idGrupo, foto, precio, marca.nombre as nombreMarca, grupo.nombre as nombreGrupo, linea.nombre AS nombreLinea, CASE WHEN tipoServicio = '1' THEN 'Belleza' WHEN tipoServicio = '2' THEN 'Ferreteria' ELSE 'Desconocido' END AS servicio, CASE WHEN estado = 'Y' THEN 'Activo' WHEN estado = 'N' THEN 'Inactivo' ELSE 'Desconocido' END AS estado from producto JOIN grupo on idGrupo=grupo.id JOIN linea ON linea.id = grupo.idLinea join marca on marca.id = idMarca) temp";

            $primaryKey = 'codigo';

            $columns = array(
                array('db' => 'codigo', 'dt' => 0),
                array('db' => 'descripcion', 'dt' => 1),
                array('db' => 'nombreMarca', 'dt' => 2),
                array('db' => 'nombreGrupo', 'dt' => 3),
                array('db' => 'nombreLinea', 'dt' => 4),
                array('db' => 'servicio', 'dt' => 5),
                array(
                    'db' => 'precio',
                    'dt' => 6,
                    'formatter' => function( $d, $row ) {
                        return '$&nbsp;' . number_format($d, 0, ',', '.');
                    }
                ),
                array('db' => 'estado', 'dt' => 7),
                array('db' => 'foto', 'dt' => 8),
            );

            echo json_encode(DataTable::simple($_POST, $table, $primaryKey, $columns));
            break;
        default :break;
    }
}
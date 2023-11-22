<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../clasesGenericas/DataTable.php';
require_once '../../clasesGenericas/ConectorBD.php';
require_once '../../clases/app/Factura.php';
require_once '../../clases/app/FacturaDetalle.php';
require_once '../../clases/app/Usuarios.php';
require_once '../../clases/app/Producto.php';
require_once '../../clases/app/DescuentoProducto.php';
require_once '../../clases/app/Inventario.php';
require_once '../../clases/app/Ciudad.php';

if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        case 'Registrar':
            date_default_timezone_set('America/Bogota');
            $fechaActual = date("Y-m-d H:i:s");
            $cliente = new Usuarios($_POST['nit']);
            $cliente->setNit($_POST['nit']);
            $cliente->setNombres($_POST['nombres']);
            $cliente->setApellidos($_POST['apellidos']);
            $cliente->setNombreComercial($_POST['nombreComercial']);
            $cliente->setCelular($_POST['celular']);
            $cliente->setEmail($_POST['email']);
            $cliente->setCodigoCiudad($_POST['codigoCiudad']);
            $cliente->setBarrio($_POST['barrio']);
            $cliente->setDireccion($_POST['direccion']);
            $cliente->setTipoNegocios($_POST['tipoNegocio']);
            if (empty($cliente->getIdPerfil())) {
                $cliente->setClave($_POST['nit']);
                $cliente->setIdPerfil('2');
                $cliente->setTipoPrecios(0);
                $cliente->guardar();
            } else {
                $cliente->setCupo($cliente->getCupo());
                $cliente->setClave($cliente->getClave());
                $cliente->setTipoPrecios($cliente->getTipoPrecios());
                $cliente->setIdPerfil($cliente->getIdPerfil());
                $cliente->modificar($_POST['nit']);
            }

            $factura = new Factura(null);
            $factura->setTipo('2');
            $factura->setCodigo($factura->getProximoCodigo());
            $factura->setEstado('1');
            $factura->setNitCliente($_POST['nit']);
            $factura->setFechaHoraDocumento($_POST['fecha']);
            $factura->setTotal($_POST['total']);
            $factura->setFlete(0);
            $factura->setObservacion($_POST['observacion']);
            $factura->setTipo('2');
            session_start();
            if (isset($_SESSION['usuario'])) $factura->setNitVendedor($_SESSION['usuario']->getNit());
            $factura->guardar();
            for ($i = 0; $i < count($_POST['cantidad']); $i++) {
                $facturaDetalle = new FacturaDetalle(null);
                $facturaDetalle->setCodigoFactura($factura->getCodigo());
                $facturaDetalle->setIdAlmacen('1');
                $facturaDetalle->setCodigoProducto($_POST['codigo'][$i]);
                $facturaDetalle->setPrecio($_POST['precioUnitario'][$i]);
                $facturaDetalle->setCantidadSolicitada($_POST['cantidad'][$i]);
                $facturaDetalle->guardar();

                $inventario = Inventario::getListaEnObjetos("codigoProducto = '{$_POST['codigo'][$i]}' limit 1", null);
                if ($inventario != null) {
                    $inventario[0]->setId($inventario[0]->getId());
                    $inventario[0]->setComprometido($inventario[0]->getComprometido() + $_POST['cantidad'][$i]);
                    $inventario[0]->modificar();
                }
            }
            break;
        case 'OrdenCompra':
            date_default_timezone_set('America/Bogota');
            $fechaActual = date("Y-m-d H:i:s");

            $objeto = new Factura($_POST['codigoPedido']);
            $objeto->setCodigo($objeto->getCodigo());
            $objeto->setEstado('2');
            $objeto->setFechaHoraEntrega($fechaActual);
            $objeto->modificar($_POST['codigoPedido']);
            for ($i = 0; $i < count($_POST['cantidad']); $i++) {
                $objetoDetalle = new FacturaDetalle($_POST['id'][$i]);
                $objetoDetalle->setId($_POST['id'][$i]);
                $objetoDetalle->setCodigoFactura($objeto->getCodigo());
                $objetoDetalle->setIdAlmacen('1');
                $objetoDetalle->setCodigoProducto($_POST['codigoProducto'][$i]);
                $objetoDetalle->setCantidadRecibida($_POST['cantidadReal'][$i]);
                $objetoDetalle->modificar();

                $inventario = Inventario::getListaEnObjetos("codigoProducto = '{$_POST['codigoProducto'][$i]}' limit 1", null);
                if($inventario != null){
                    $inventario[0]->setId($inventario[0]->getId());
                    $inventario[0]->setComprometido($inventario[0]->getComprometido() - $_POST['cantidad'][$i]);
                    $inventario[0]->setStock($inventario[0]->getStock() - $_POST['cantidadReal'][$i]);
                    $inventario[0]->modificar();
                }
                
            }
            echo json_encode(array("status" => 'success', "mensaje" => 'Pedido subido a orden de compra'));
            break;
        case 'Anular':
            $pedido = new Factura($_POST['codigo']);
            if($pedido->getEstado() === '1') {
                $pedido->setCodigo($_POST['codigo']);
                $pedido->setEstado('3');
                $pedido->modificar($_POST['codigo']);
                
                $objetoDetalle = FacturaDetalle::getListaEnObjetos("codigoFactura='{$pedido->getCodigo()}'", 'id');
                if($objetoDetalle != null){
                    for ($i = 0; $i < count($objetoDetalle); $i++) {
                        $objetoDetalles = $objetoDetalle[$i];
                    
                        $inventario = Inventario::getListaEnObjetos("codigoProducto = '{$objetoDetalles->getCodigoProducto()}' limit 1", null);
                        if($inventario != null){
                            $inventario[0]->setId($inventario[0]->getId());
                            $inventario[0]->setComprometido($inventario[0]->getComprometido() - $objetoDetalles->getCantidadSolicitada());
                            $inventario[0]->modificar();
                        }
                    }
                }
            } else {
                $pedido->setCodigo($_POST['codigo']);
                $pedido->setEstado('3');
                $pedido->modificar($_POST['codigo']);
                
                $objetoDetalle = FacturaDetalle::getListaEnObjetos("codigoFactura='{$pedido->getCodigo()}'", 'id');
                if($objetoDetalle != null){
                    for ($i = 0; $i < count($objetoDetalle); $i++) {
                        $objetoDetalles = $objetoDetalle[$i];
                    
                        $inventario = Inventario::getListaEnObjetos("codigoProducto = '{$objetoDetalles->getCodigoProducto()}' limit 1", null);
                        if($inventario != null){
                            $inventario[0]->setId($inventario[0]->getId());
                            $inventario[0]->setStock($inventario[0]->getStock() + $objetoDetalles->getCantidadRecibida());
                            $inventario[0]->modificar();
                        }
                    }
                }
            }
            break;
        case 'Listar':
            $table = "(select factura.codigo, CASE WHEN clientes.tipoPrecios = '3' THEN concat(clientes.nombres, ' ', clientes.apellidos, ' Cliente Final') ELSE concat(clientes.nombres, ' ', clientes.apellidos) END as cliente, clientes.barrio, ciudad.nombre as ciudad, concat(usuarios.nombres, ' ', usuarios.apellidos) as facturador, clientes.direccion, fechaHoraDocumento, fechaHoraFacturacion, total, flete, (total + flete) as totalPedido, CASE WHEN factura.estado = '1' THEN 'Pendiente' WHEN factura.estado = '2' THEN 'Orden de compra' WHEN factura.estado = '3' THEN 'Cancelado' ELSE 'Desconocido' END as estadoPedido from factura left join usuarios on usuarios.nit = factura.nitVendedor LEFT JOIN usuarios as clientes on clientes.nit = factura.nitCliente LEFT JOIN ciudad ON ciudad.codigo = clientes.codigoCiudad WHERE factura.tipo = '2') temp";

            $primaryKey = 'codigo';

            $columns = array(
                array('db' => 'codigo', 'dt' => 0),
                array('db' => 'cliente', 'dt' => 1),
                array('db' => 'facturador', 'dt' => 2),
                array('db' => 'fechaHoraDocumento', 'dt' => 3),
                array('db' => 'fechaHoraFacturacion', 'dt' => 4),
                array(
                    'db' => 'total',
                    'dt' => 7,
                    'formatter' => function( $d, $row ) {
                        return '$&nbsp;' . number_format($d, 0, ',', '.');
                    }
                ),
                array(
                    'db' => 'flete',
                    'dt' => 8,
                    'formatter' => function( $d, $row ) {
                        return '$&nbsp;' . number_format($d, 0, ',', '.');
                    }
                ),
                array(
                    'db' => 'totalPedido',
                    'dt' => 9,
                    'formatter' => function( $d, $row ) {
                        return '$&nbsp;' . number_format($d, 0, ',', '.');
                    }
                ),
                array('db' => 'estadoPedido', 'dt' => 10),
                array('db' => 'direccion', 'dt' => 11),
                array('db' => 'barrio', 'dt' => 12),
                array('db' => 'ciudad', 'dt' => 13),
            );
            echo json_encode(DataTable::simple($_POST, $table, $primaryKey, $columns));
            break;
        case 'Cliente':
            $lista = '';
            $filtro = str_replace(" ", "%", !empty($_POST['cliente']) ? $_POST['cliente'] : '');
            $objeto = Usuarios::getLista("(CONCAT(nombres, ' ', apellidos) like '%$filtro%' or nombreComercial like '%$filtro%' or nit like '%$filtro%') and idPerfil = 2", 'nombres limit 8');
            if ($objeto != null) {
                $lista .= '<div class="dropdown-menu show" aria-labelledby="navbarDropdown" style="display: block; width: 100%; max-height:300px; overflow-y: scroll; border-radius: 10px; scroll-behavior: smooth;">';
                for ($i = 0; $i < count($objeto); $i++) {
                    $objetos = $objeto[$i];
                    $lista .= "<a class='dropdown-item' style='white-space: normal' data='{$objetos['nombres']} {$objetos['apellidos']}' id='{$objetos['nit']}'>{$objetos['nombres']} {$objetos['apellidos']} ({$objetos['nit']})</a><div class='dropdown-divider'></div>";
                }
                $lista .= '</div>';
            }
            echo $lista;
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
                "cupo" => $objeto->getCupo(),
                "totalFacturado" => $objeto->getTotalFacturado($objeto->getNit()),
                "cupoDisponible" => $objeto->getCupo() > 0 ? $objeto->getCupo() - $objeto->getTotalFacturado($objeto->getNit()) : 0
            );
            echo json_encode($array);
            break;
        case 'Productos':
            $lista = '';
        
            $where = "descuentoProducto.tipo = '{$_POST['tipoPrecios']}' and estado = 'Y' ";

            if (isset($_POST['filtro']) && !empty($_POST['filtro'])) {
                $filter = str_replace(" ", "%", $_POST['filtro']);
                $where .= "AND (producto.codigo like '%$filter%'";
                $where .= "OR producto.descripcion like '%$filter%')";
            }
            
            $ciudad = isset($_POST['ciudad']) && !empty($_POST['ciudad']) ? $_POST['ciudad'] : '52001';
            $porcentajeFlete = new Ciudad($ciudad);

            //Inicio paginacion
            $registrosXPagina = $_POST['registrosXPagina'];
            $cadenaSQL = "select count(*) as registros from producto JOIN inventario ON inventario.codigoProducto = producto.codigo JOIN descuentoProducto ON descuentoProducto.nombreGrupo = SUBSTRING(producto.codigo, 1, 4) where $where";
            $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
            $totalRegistros = $resultado[0]['registros'];
            $totalPaginas = (int) ceil(1.0 * $totalRegistros / $registrosXPagina);
            $pagina = $_POST['pagina'];
            $registroInicial = ($pagina - 1) * $registrosXPagina + 1;
            if ($pagina == $totalPaginas) $registroFinal = $totalRegistros;
            else $registroFinal = $registroInicial + $registrosXPagina - 1;
            $offset = $registroInicial - 1;
            //Fin paginacion

            $productos = Producto::getPreciosVentas($where, "SUBSTRING(producto.codigo, 1, 4), inventario.stock - inventario.comprometido desc limit $registrosXPagina offset $offset");
            if ($productos != null) {
                for ($i = 0; $i < count($productos); $i++) {
                    $producto = $productos[$i];
                    $lista .= "<tr>";
                    $lista .= "<td>{$producto['codigo']}</td>";
                    $lista .= "<td>{$producto['descripcion']}</td>";
                    $lista .= "<td>{$producto['cantidadVenta']}</td>";
                    $lista .= "<td>{$producto['disponible']}</td>";
                    $lista .= '<td>$' . number_format(round($producto['precio'] * (1 + $porcentajeFlete->getPorcentaje())), 0, ',', '.') . '</td>';
                    $lista .= "<td><input type='number' class='form-control form-control-sm cantidadModal' name='cantidadModal[]' min='1' max='100000' value='1'></td>";
                    $lista .= "<td><a class='btn btn-warning btnAgregarProductoPedido' id='boton{$producto['codigo']}'><i class='fa fa-plus'></i></a></td>";
                    $lista .= "<td>{$producto['cantidadVenta']}</td>";
                    $lista .= "<td>{$producto['margenXEmpaque']}</td>";
                    $lista .= "<td>{$producto['cantidadVolumen']}</td>";
                    $lista .= "<td>{$producto['margenXVolumen']}</td>";
                    $lista .= "</tr>";
                }
            }

            $paginacion = '';
            $paginacion .= '<div class="col-sm-12 col-md-3 col-12">';
            $paginacion .= '<div class="text-center">';
            $paginacion .= '<img id="primero" src="imagenes/primero.png" height="25" onclick="actualizarPagina(1)">';
            $paginacion .= '<img id="anterior" src="imagenes/anterior.png" height="25" onclick=actualizarPagina(document.getElementById("pagina").value-1)>';
            $paginacion .= "<input type='number' class='form-control-sm' name='pagina' id='pagina' min='1' max='$totalPaginas' value='$pagina'  onchange='actualizarPagina(this.value)'>";
            $paginacion .= '<img id="siguiente" src="imagenes/siguiente.png" height="25" onclick=actualizarPagina(document.getElementById("pagina").value-1+2)>';
            $paginacion .= "<img id='ultimo' src='imagenes/ultimo.png' height='25' onclick='actualizarPagina($totalPaginas)'>";
            $paginacion .= "</div></div><div class='col-md-5'><div class='text-center'>Mostrando del $registroInicial al $registroFinal de un total de $totalRegistros registros</div></div>";
            print_r("$lista|$paginacion");
            break;
        case 'AgregarProducto':
            $array = array();
            $ciudad = isset($_POST['ciudad']) && !empty($_POST['ciudad']) ? $_POST['ciudad'] : '52001';
            $porcentajeFlete = new Ciudad($ciudad);
            $productos = Producto::getPreciosVentas("descuentoProducto.tipo = '{$_POST['tipoPrecios']}' and producto.codigo = '{$_POST['codigo']}' limit 1");
            if (is_array($productos) && count($productos) > 0) {
                foreach ($productos as $indice => $arreglo) {
                    $precio = $arreglo['precio'] * (1 + $porcentajeFlete->getPorcentaje());
                    $descuento = 0;
                    if($arreglo['cantidadVolumen'] > 1 && $_POST['cantidad'] >= $arreglo['cantidadVolumen']){
                        $precio = ($arreglo['precio'] * (1 + $porcentajeFlete->getPorcentaje())) * (1 - ($arreglo['margenXVolumen'] / 100));
                        $descuento = $arreglo['margenXVolumen'];
                    } else if ($arreglo['cantidadVenta'] > 1 && $_POST['cantidad'] >= $arreglo['cantidadVenta']) {
                        $precio = ($arreglo['precio'] * (1 + $porcentajeFlete->getPorcentaje())) * (1 - ($arreglo['margenXEmpaque'] / 100));
                        $descuento = $arreglo['margenXEmpaque'];
                    } 
                    $array = array(
                        "codigo" => $arreglo['codigo'],
                        "descripcion" => $arreglo['descripcion'],
                        "precioLista" => $arreglo['precio'],
                        "precio" => round($precio),
                        "descuento" => $descuento,
                        "cantidad" => $_POST['cantidad'],
                        "precioTotal" => round($precio) * $_POST['cantidad']
                    );
                }
            }
            echo json_encode($array);
            break;
        default : break;
    }
}
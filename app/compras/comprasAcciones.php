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
require_once '../../clases/app/Inventario.php';
require_once '../../clases/app/Impuesto.php';

if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        case 'Registrar':
            date_default_timezone_set('America/Bogota');
            $fechaActual = date("Y-m-d h:i:s");

            $objeto = new Factura(null);
            $objeto->setTipo('1');
            $objeto->setCodigo($objeto->getProximoCodigo());
            $objeto->setFechaHoraDocumento($_POST['fecha']);
            $objeto->setNitProveedor($_POST['nit']);
            $objeto->setTotal($_POST['total']);
            $objeto->setObservacion($_POST['observacion']);
            session_start();
            if(isset($_SESSION['usuario'])) $objeto->setNitVendedor($_SESSION['usuario']->getNit());
            $objeto->setEstado('1');
            $objeto->guardar();
            for ($i = 0; $i < count($_POST['cantidad']); $i++) {
                $objetoDetalle = new FacturaDetalle(null);
                $objetoDetalle->setCodigoFactura($objeto->getCodigo());
                $objetoDetalle->setCodigoProducto($_POST['codigo'][$i]);
                $objetoDetalle->setPrecio($_POST['precioLista'][$i]);
                $objetoDetalle->setCantidadSolicitada($_POST['cantidad'][$i]);
                $objetoDetalle->setIdAlmacen(1);
                $objetoDetalle->guardar();

                $inventario = Inventario::getListaEnObjetos("codigoProducto = '{$_POST['codigo'][$i]}' limit 1", null);
                if($inventario !== null) {
                    $inventario[0]->setId($inventario[0]->getId());
                    $inventario[0]->setPedido($inventario[0]->getPedido() + $_POST['cantidad'][$i]);
                    $inventario[0]->modificar();
                }
            }
            break;
        case 'OrdenCompra':
            date_default_timezone_set('America/Bogota');
            $fechaActual = date("Y-m-d h:i:s");

            $objeto = new Factura($_POST['codigoCompras']);
            $objeto->setCodigo($objeto->getCodigo());
            $objeto->setEstado('2');
            $objeto->setFechaHoraEntrega($fechaActual);
            $objeto->modificar($_POST['codigoCompras']);
            for ($i = 0; $i < count($_POST['cantidad']); $i++) {
                $objetoDetalle = new FacturaDetalle($_POST['id'][$i]);
                $objetoDetalle->setId($_POST['id'][$i]);
                $objetoDetalle->setCodigoFactura($objeto->getCodigo());
                $objetoDetalle->setPrecio($_POST['precioUnitario'][$i]);
                $objetoDetalle->setCodigoProducto($_POST['codigoProducto'][$i]);
                $objetoDetalle->setCantidadRecibida($_POST['cantidadReal'][$i]);
                $objetoDetalle->setIdAlmacen(1);
                $objetoDetalle->modificar();

                $inventario = Inventario::getListaEnObjetos("codigoProducto = '{$_POST['codigoProducto'][$i]}' limit 1", null);
                if($inventario != null){
                    $inventario[0]->setId($inventario[0]->getId());
                    $inventario[0]->setPedido($inventario[0]->getPedido() - $_POST['cantidad'][$i]);
                    $inventario[0]->setStock($inventario[0]->getStock() + $_POST['cantidadReal'][$i]);
                    $inventario[0]->modificar();
                }
                
                $producto = new Producto($_POST['codigoProducto'][$i]);
                $impuesto = $producto->getImpuesto()->getPorcentaje() / 100;
                $producto->setCosto($_POST['precioUnitario'][$i] / (1 + $impuesto));
                $producto->setPrecio($_POST['precioUnitario'][$i]);
                $producto->modificar($_POST['codigoProducto'][$i]);
            }
            echo json_encode(array("status" => 'success', "mensaje" => 'Orden de compra subida al inventario'));
            break;
        case 'Regresar':
            $pedido = new Factura($_POST['codigo']);
            $pedido->setCodigo($_POST['codigo']);
            $pedido->setEstado('1');
            $pedido->modificar($_POST['codigo']);
            
            $objetoDetalle = FacturaDetalle::getListaEnObjetos("codigoFactura='{$pedido->getCodigo()}'", 'id');
            if($objetoDetalle != null){
                for ($i = 0; $i < count($objetoDetalle); $i++) {
                    $objetoDetalles = $objetoDetalle[$i];
                
                    $inventario = Inventario::getListaEnObjetos("codigoProducto = '{$objetoDetalles->getCodigoProducto()}' limit 1", null);
                    if($inventario != null){
                        $inventario[0]->setId($inventario[0]->getId());
                        $inventario[0]->setPedido($inventario[0]->getPedido() + $objetoDetalles->getCantidadSolicitada());
                        $inventario[0]->setStock($inventario[0]->getStock() - $objetoDetalles->getCantidadRecibida());
                        $inventario[0]->modificar();
                    }
                }
            }
            break;
        case 'Anular':
            $pedido = new Factura($_POST['codigo']);
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
                        $inventario[0]->setPedido($inventario[0]->getPedido() - $objetoDetalles->getCantidadSolicitada());
                        $inventario[0]->modificar();
                    }
                }
            }
            break;
        case 'Movimientos':
            $lista = '';
            $producto = $_POST['producto'];
            $objeto = new Factura(null);
            $resultado = $objeto->getMovimientos($producto);
            if(is_array($resultado) && count($resultado) > 0) {
                $cantidad = 0; 
                foreach ($resultado as $indice => $arreglo) {
                    $cantidad += $arreglo['year'] <> date('y') && $arreglo['mes'] <> date('m') ? $arreglo['cantidad']: 0;
                    $lista .= '<tr>';
                    $lista .= "<td>{$arreglo['year']}-{$arreglo['meses']}</td>";
                    $lista .= "<td>{$arreglo['cantidad']}</td>";
                    $lista .= '</tr>';
                }
                $lista .= '<tr class="bg-black text-light">';
                $lista .= "<td>Promedio</td>";
                $lista .= '<td>' . round($cantidad / 12) . '</td>';
                $lista .= '</tr>';
            } else {
                $lista .= '<tr>';
                $lista .= "<td colspan='2' class='text-center'>No tiene movientos</td>";
                $lista .= '</tr>';
            }
            echo json_encode(array("lista" => $lista));
            break;
        case 'Listar':
            $table = "(select factura.codigo, concat(usuarios.nombres, ' ', usuarios.apellidos) as vendedor, proveedor.nombreComercial as proveedor, factura.fechaHoraDocumento, factura.fechaHoraEntrega, CASE WHEN factura.estado = '1' THEN 'Solicitado' WHEN factura.estado = '2' THEN 'Orden de compra' WHEN factura.estado = '3' THEN 'Cancelado' ELSE 'Desconocido' END as estadoPedido, SUM(facturaDetalle.cantidadSolicitada * facturaDetalle.precio) AS total, SUM(facturaDetalle.cantidadRecibida * facturaDetalle.precio) AS totalRecibido from factura JOIN facturaDetalle ON facturaDetalle.codigoFactura = factura.codigo LEFT join usuarios on usuarios.nit = factura.nitVendedor LEFT JOIN usuarios AS proveedor ON proveedor.nit = factura.nitProveedor WHERE factura.tipo = '1' GROUP BY factura.codigo, concat(usuarios.nombres, ' ', usuarios.apellidos), proveedor.nombreComercial, factura.fechaHoraDocumento, factura.fechaHoraEntrega, CASE WHEN factura.estado = '1' THEN 'Solicitado' WHEN factura.estado = '2' THEN 'Orden de compra' WHEN factura.estado = '3' THEN 'Cancelado' ELSE 'Desconocido' END) temp";

            $primaryKey = 'codigo';

            $columns = array(
                array('db' => 'codigo', 'dt' => 0),
                array('db' => 'proveedor', 'dt' => 1),
                array('db' => 'fechaHoraDocumento', 'dt' => 2),
                array('db' => 'fechaHoraEntrega', 'dt' => 3),
                array('db' => 'estadoPedido', 'dt' => 4),
                array(
                    'db'        => 'total',
                    'dt'        => 5,
                    'formatter' => function( $d, $row ) {
                        return '$'.number_format($d);
                    }
                ),
                array(
                    'db'        => 'totalRecibido',
                    'dt'        => 6,
                    'formatter' => function( $d, $row ) {
                        return '$'.number_format($d);
                    }
                )
            );
            echo json_encode(DataTable::simple($_POST, $table, $primaryKey, $columns));
            break;
        case 'Cliente':
            $lista = '';
            $filtro = str_replace(" ", "%", !empty($_POST['cliente']) ? $_POST['cliente'] : '');
            $objeto = Usuarios::getLista("(CONCAT(nombres, ' ', apellidos) like '%$filtro%' or nombreComercial like '%$filtro%' or nit like '%$filtro%') and idPerfil = 4", 'nombres limit 8');
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
                "codigoCiudad" => $objeto->getCodigoCiudad(),
                "clave" => $objeto->getClave(),
                "descuentoComercial" => $objeto->getDescuentoComercial(),
                "descuentoFinanciero" => $objeto->getDescuentoFinanciero(),
                "bonificacion" => $objeto->getBonificacion()
            );
            echo json_encode($array);
            break;
        case 'Productos':
            $lista = '';
            $where = "productoUsuario.nitUsuario = '{$_POST['nit']}' and producto.estado = 'Y'";

            if (isset($_POST['filtro']) && !empty($_POST['filtro'])) {
                $filter = str_replace(" ", "%", $_POST['filtro']);
                $where .= "AND (producto.codigo like '%$filter%'";
                $where .= "OR producto.descripcion like '%$filter%')";
            }

            //Inicio paginacion
            $registrosXPagina = $_POST['registrosXPagina'];
            $cadenaSQL = "select count(*) as registros from producto JOIN productoUsuario ON producto.codigo = productoUsuario.codigoProducto where $where";
            $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
            $totalRegistros = $resultado[0]['registros'];
            $totalPaginas = (int) ceil(1.0 * $totalRegistros / $registrosXPagina);
            $pagina = $_POST['pagina'];
            $registroInicial = ($pagina - 1) * $registrosXPagina + 1;
            if ($pagina == $totalPaginas) $registroFinal = $totalRegistros;
            else $registroFinal = $registroInicial + $registrosXPagina - 1;
            $offset = $registroInicial - 1;
            //Fin paginacion

            $productos = Producto::getPreciosCompras($where, "disponible asc limit $registrosXPagina offset $offset");
            if ($productos != null) {
                for ($i = 0; $i < count($productos); $i++) {
                    $producto = $productos[$i];
                    $lista .= "<tr>";
                    $lista .= "<td class='item'>{$producto['codigo']}</td>";
                    $lista .= "<td>{$producto['descripcion']}</td>";
                    $lista .= '<td>$' . number_format(round($producto['costo']), 0, ',', '.') . '</td>';
                    $lista .= "<td>{$producto['porcentaje']}</td>";
                    $lista .= '<td>$' . number_format(round($producto['precio']), 0, ',', '.') . '</td>';
                    $lista .= "<td class='text-center'>{$producto['cantidadVenta']}</td>";
                    $lista .= "<td class='text-center'>{$producto['disponible']}</td>";
                    $lista .= "<td class='text-center'>{$producto['pedido']}</td>";
                    $lista .= "<td><input type='number' class='form-control form-control-sm cantidadModal' name='cantidadModal[]' min='1' max='1000' value='1'></td>";
                    $lista .= "<td><a class='btn btn-warning btnAgregarProductoPedido' id='boton{$producto['codigo']}'><i class='fa fa-plus'></i></a></td>";
                    $lista .= "<td><img class='text-center imgProduct' height='60' src='http://fotos.ossadistribuciones.com/{$producto['foto']}'></td>";
                    $lista .= "</tr>";
                }
            }

            $paginacion = '';
            $paginacion .= '<div class="col-sm-12 col-lg-3 col-12">';
            $paginacion .= '<div class="text-center">';
            $paginacion .= '<img id="primero" src="imagenes/primero.png" height="25" onclick="actualizarPagina(1)">';
            $paginacion .= '<img id="anterior" src="imagenes/anterior.png" height="25" onclick=actualizarPagina(document.getElementById("pagina").value-1)>';
            $paginacion .= "<input type='number' class='form-control-sm' name='pagina' id='pagina' min='1' max='$totalPaginas' value='$pagina'  onchange='actualizarPagina(this.value)'>";
            $paginacion .= '<img id="siguiente" src="imagenes/siguiente.png" height="25" onclick=actualizarPagina(document.getElementById("pagina").value-1+2)>';
            $paginacion .= "<img id='ultimo' src='imagenes/ultimo.png' height='25' onclick='actualizarPagina($totalPaginas)'>";
            $paginacion .= "</div></div><div class='col-lg-5'><div class='text-center'>Mostrando del $registroInicial al $registroFinal de un total de $totalRegistros registros</div></div>";
            print_r("$lista|$paginacion");
            break;
        default : break;
    }
}
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require '../clasesGenericas/ConectorBD.php';
require '../clases/app/Usuarios.php';
require '../clases/app/Factura.php';
require '../clases/app/FacturaDetalle.php';
require '../clases/app/Producto.php';
require '../clases/app/Inventario.php';
require '../clases/app/Ciudad.php';

if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        case 'Ingresar':
            if (isset($_POST['usuario']) && $_POST['usuario'] != '' && isset($_POST['clave']) && $_POST['clave'] != '') {

                if (preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["usuario"])) {

                    $array = array();
                    $usuario = $_POST['usuario'];
                    $clave = hash('sha3-512', $_POST['clave']);

                    $persona = Usuarios::validar($usuario, $clave);
                    if ($persona != null) {
                        session_start();
                        $_SESSION['usuario'] = $persona;
                        if ($persona->getTipoPrecios() != '0') {
                            switch ($persona->getIdPerfil()) {
                                case '1':
                                    $array = array("status" => 'success', "redireccion" => 'principal.php?CONTENIDO=app/pedidos/pedidos.php', "type" => 'success');
                                    break;
                                case '2':
//                                    $object = Pedido::getPedidoSugerido("pedido.identificacionCliente = '{$_SESSION["usuario"]->getIdentificacion()}' AND descuentoProducto.tipo = '{$_SESSION["usuario"]->getTipo()}'", 'cantidadCompras DESC, cantidad DESC');
//                                    if ($object != null) {
//                                        foreach ($object as $indice => $arreglo) {
//                                            $_SESSION["orderSuggested"][$arreglo['codigo']]['descuento'] = $arreglo['descuento'];
//                                            $_SESSION["orderSuggested"][$arreglo['codigo']]['precio'] = $arreglo['precio'];
//                                            $_SESSION["orderSuggested"][$arreglo['codigo']]['precioLista'] = $arreglo['precioLista'];
//                                            $_SESSION["orderSuggested"][$arreglo['codigo']]['descripcion'] = $arreglo['descripcion'];
//                                            $_SESSION["orderSuggested"][$arreglo['codigo']]['codigo'] = $arreglo['codigo'];
//                                            $_SESSION["orderSuggested"][$arreglo['codigo']]['imagen'] = $arreglo['imagen'];
//                                            $_SESSION["orderSuggested"][$arreglo['codigo']]['cantidad'] = $arreglo['cantidad'];
//                                        }
//                                    }
                                    $array = array("status" => 'success', "redireccion" => 'listing.php', "type" => 'failure');
                                    break;
                                case '3':
                                    $array = array("status" => 'success', "redireccion" => 'principal.php?CONTENIDO=app/pedidos/pedidos.php', "type" => 'success');
                                    break;
                                default:
                                    break;
                            }
                        } else {
                            $array = array("status" => 'warning', "mensaje" => 'Aun no puede ingresar ya que no se le han aplicado los descuentos correspondientes');
                        }
                    } else {
                        $array = array("status" => 'error', "mensaje" => 'Usuario y/o contraseña incorrecta');
                    }

                    echo json_encode($array);
                }
            }
            break;
        case 'Notificaciones':
            $lista = '';
            $contador = 0;
            $objeto = Factura::getListaEnObjetos("estado='1' AND tipo = ('2') limit 3", null);
            if ($objeto != null) {
                $contador += count($objeto);
                for ($i = 0; $i < count($objeto); $i++) {
                    $objetos = $objeto[$i];
                    $lista .= "<a href='principal.php?CONTENIDO=app/pedidos/pedidos.php'>";
                    $lista .= '<div class="notif-icon notif-success"> <i class="fas fa-truck" style="width: 60px; text-align:center;"></i> </div>';
                    $lista .= '<div class="notif-content">';
                    $lista .= '<span class="block">';
                    $lista .= "Pedido usuario {$objetos->getCliente()->getNombres()} {$objetos->getCliente()->getApellidos()}";
                    $lista .= '</span>';
                    $lista .= "<span class='time'>{$objetos->getFechaHoraDocumento()}</span>";
                    $lista .= '</div>';
                    $lista .= '</a>';
                }
            }

            $usuario = Usuarios::getListaEnObjetos("tipoPrecios='0' limit 3", null);
            if ($usuario != null) {
                $contador += count($usuario);
                for ($i = 0; $i < count($usuario); $i++) {
                    $usuarios = $usuario[$i];
                    $lista .= "<a href='principal.php?CONTENIDO=app/usuarios/clientes/clientes.php'>";
                    $lista .= '<div class="notif-icon notif-primary"> <i class="fas fa-user" style="width: 60px; text-align:center;"></i> </div>';
                    $lista .= '<div class="notif-content">';
                    $lista .= '<span class="block">';
                    $lista .= "Usuario registro ({$usuarios})";
                    $lista .= '</span>';
                    $lista .= "<span class='time'></span>";
                    $lista .= '</div>';
                    $lista .= '</a>';
                }
            }
            echo json_encode(array("datos" => $lista, "contador" => $contador));
            break;
        case 'Registrarse':
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
            $objeto->setIdPerfil(2);
            $objeto->setTipoNegocios($_POST['tipoNegocio']);
            $objeto->setTipoPrecios(0);
            $objeto->setClave($_POST['nit']);
            $objeto->setEstado('Y');
            $objeto->guardar();
            break;
        case 'Order':
            session_start();
            date_default_timezone_set('America/Bogota');
            $fechaActual = date("Y-m-d h:i:s");
            
            $cliente = new Usuarios($_POST['identificacionCliente']);
            if(empty($cliente->getNit())) {
                $cliente->setNit($_POST['identificacionCliente']);
                $cliente->setNombres($_POST['nombres']);
                $cliente->setApellidos($_POST['apellidos']);
                $cliente->setNombreComercial('');
                $cliente->setCelular('3224449444');
                $cliente->setEmail('ossadistrubcionespasto@gmail.com');
                $cliente->setCodigoCiudad('52001');
                $cliente->setBarrio('');
                $cliente->setDireccion($_POST['direccion']);
                $cliente->setTipoNegocios('Sin negocio');
                $cliente->setTipoPrecios(3);
                $cliente->setCupo(0);
                $cliente->setClave($_POST['identificacionCliente']);
                $cliente->setIdPerfil('2');
                $cliente->guardar();
            } else {
                $total = $_POST['total'];
                $cupo = $cliente->getCupo();
                $totalFacturado = $cliente->getTotalFacturado($cliente->getNit());
                $cupoDisponible = $cupo > 0 ? $cupo - $totalFacturado : 0;
                if(($cupo > 0 && $total > $cupoDisponible)) {
                    echo json_encode(array("status" => 'error', "mensaje" => 'No puede pasar el pedido ya que el cupo disponible es menor al total del pedido'));
                    break;
                }
            }

            $envio = "";
            if ($cliente->getTipoPrecios() != '3') {
                if($_POST['total'] <= 40000) $envio = 4000;
                else if($_POST['total'] >= 40001 && $_POST['total'] <= 60000) $envio = 3000;
                else if($_POST['total'] >= 60001 && $_POST['total'] <= 80000) $envio = 2000;
                else if($_POST['total'] >= 80001 && $_POST['total'] <= 100000) $envio = 1000;
            } else {
                if($_POST['total'] <= 40000) $envio = 4000;
                else if($_POST['total'] >= 40001 && $_POST['total'] <= 60000) $envio = 3000;
                else if($_POST['total'] >= 60001 && $_POST['total'] <= 80000) $envio = 2000;
                else if($_POST['total'] >= 80001 && $_POST['total'] <= 100000) $envio = 1000;
            }
            
            $factura = new Factura(null);
            $factura->setTipo('2');
            $factura->setCodigo($factura->getProximoCodigo());
            $factura->setEstado('1');
            $factura->setNitCliente($_POST['identificacionCliente']);
            $factura->setFechaHoraDocumento($fechaActual);
            $factura->setTotal($_POST['total']);
            $factura->setFlete($envio);
            $factura->setObservacion($_POST['observacion']);
            $factura->setTipo('2');
            $factura->guardar();
            if (!empty($factura->getCodigo())) {
                if (isset($_SESSION["carrito"])) {
                    foreach ($_SESSION["carrito"] as $indice => $arreglo) {
                        $facturaDetalle = new FacturaDetalle(null);
                        $facturaDetalle->setCodigoFactura($factura->getCodigo());
                        $facturaDetalle->setCodigoProducto($arreglo['codigo']);
                        $facturaDetalle->setPrecio($arreglo['precio']);
                        $facturaDetalle->setIdAlmacen('1');
                        $facturaDetalle->setCantidadSolicitada($arreglo['cantidad']);
                        $facturaDetalle->guardar();

                        $inventario = Inventario::getListaEnObjetos("codigoProducto = '{$arreglo['codigo']}' limit 1", null);
                        if ($inventario != null) {
                            $inventario[0]->setId($inventario[0]->getId());
                            $inventario[0]->setComprometido($inventario[0]->getComprometido() + $arreglo['cantidad']);
                            $inventario[0]->modificar();
                        }
                    }
                }
                unset($_SESSION["carrito"]);
                echo json_encode(array("status" => 'success', "mensaje" => 'Pedido enviado corretamente'));
            } else {
                echo json_encode(array("status" => 'error', "mensaje" => 'Error al guardar el pedido'));
            }
            break;
        case 'AgregarProducto':
            session_start();
            $ciudad = isset($_SESSION['usuario']) && !empty($_SESSION['usuario']->getTipoPrecios()) ? $_SESSION['usuario']->getCodigoCiudad() : '52001';
            $porcentajeFlete = new Ciudad($ciudad);

            $productos = Producto::getPreciosVentas("descuentoProducto.tipo = '{$_POST['tipo']}' and producto.codigo = '{$_POST['producto']}' limit 1");

            if (is_array($productos) && count($productos) > 0) {
                $inventario = Inventario::getListaEnObjetos("codigoProducto = '{$_POST['producto']}' limit 1", null);

                if ($inventario != null && $_POST['cantidad'] <= ($inventario[0]->getStock() - $inventario[0]->getComprometido())) {
                    foreach ($productos as $indice => $arreglo) {
                        $codigoProducto = $arreglo['codigo'];
                        $cantidadAnterior = isset($_SESSION["carrito"][$codigoProducto]['cantidad']) ? $_SESSION["carrito"][$codigoProducto]['cantidad'] : 0;
                        $cantidad = isset($_SESSION["carrito"][$codigoProducto]['cantidad']) ? $_SESSION["carrito"][$codigoProducto]['cantidad'] + $_POST['cantidad'] : $_POST['cantidad'];

                        if ($cantidad > ($inventario[0]->getStock() - $inventario[0]->getComprometido())) {
                            $response = [
                                'status' => 'error',
                                'message' => "Ya agregaste este producto con {$cantidadAnterior} unidades por lo cual no se puede agregar {$_POST['cantidad']} unidades mas debido a que el disponible es de " . ($inventario[0]->getStock() - $inventario[0]->getComprometido()) . " unidades."
                            ];
                            echo json_encode($response);
                            break;
                        }
                        $valorUnitario = $arreglo['precio'] * (1 + $porcentajeFlete->getPorcentaje());
                        $descuentoProducto = 0;

                        if ($arreglo['cantidadVolumen'] > 1 && $_POST['cantidad'] >= $arreglo['cantidadVolumen']) {
                            $valorUnitario = round(($arreglo['precio'] * (1 + $porcentajeFlete->getPorcentaje())) * (1 - ($arreglo['margenXVolumen'] / 100)));
                            $descuentoProducto = $arreglo['margenXVolumen'];
                        } else if ($arreglo['cantidadVenta'] > 1 && $_POST['cantidad'] >= $arreglo['cantidadVenta']) {
                            $valorUnitario = round(($arreglo['precio'] * (1 + $porcentajeFlete->getPorcentaje())) * (1 - ($arreglo['margenXEmpaque'] / 100)));
                            $descuentoProducto = $arreglo['margenXEmpaque'];
                        }

                        $_SESSION["carrito"][$codigoProducto] = [
                            'descuento' => $descuentoProducto,
                            'precio' => $valorUnitario,
                            'precioLista' => $arreglo['precio'],
                            'descripcion' => $arreglo['descripcion'],
                            'codigo' => $codigoProducto,
                            'imagen' => $arreglo['foto'],
                            'cantidad' => $cantidad
                        ];

                        $response = [
                            'status' => 'success',
                            'message' => 'Producto agregado al carrito.'
                        ];
                        echo json_encode($response);
                    }
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'Lo sentimos no se puedo agregar el producto ya que que supera la cantidad disponible de ' . ($inventario[0]->getStock() - $inventario[0]->getComprometido()) . ' unidades'
                    ];
                    echo json_encode($response);
                }
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'No se encontró el producto.'
                ];
                echo json_encode($response);
            }

            break;
        case 'Carrito':
            session_start();
            $lista = '';
            if (isset($_SESSION["carrito"])) {
                foreach ($_SESSION["carrito"] as $indice => $arreglo) {
                    $total = $arreglo['precio'] * $arreglo['cantidad'];
                    $lista .= '<div class="col-12">';
                    $lista .= '<div class="cart-item cart-item-sm">';
                    $lista .= '<div class="row align-items-center">';
                    $lista .= '<div class="col-lg-9">';
                    $lista .= '<div class="media media-product">';
                    $lista .= "<a href='#!'><img src='app/inventario/fotos/{$arreglo['imagen']}'></a>";
                    $lista .= '<div class="media-body">';
                    $lista .= "<h5 class='media-title'>{$arreglo['descripcion']}</h5>";
                    $lista .= "<span class='media-subtitle'>Cantidad: {$arreglo['cantidad']}</span>";
                    $lista .= '</div>';
                    $lista .= '</div>';
                    $lista .= '</div>';
                    $lista .= '<div class="col-lg-3 text-center text-lg-right">';
                    $lista .= "<span class='cart-item-price'>$" . number_format($total, 0, ',', '.') . "</span>";
                    $lista .= '</div>';
                    $lista .= "<a href='#!' class='cart-item-close' delete={$arreglo['codigo']}><i class='icon-x'></i></a>";
                    $lista .= '</div>';
                    $lista .= '</div>';
                    $lista .= '</div>';
                }
            }
            echo $lista;
            break;
        case 'QuitarProducto':
            session_start();
            if (isset($_SESSION["carrito"])) {
                $codigo = $_POST['codigo'];
                unset($_SESSION["carrito"][$codigo]);
            }
            if (isset($_SESSION["orderSuggested"])) {
                $codigo = $_POST['codigo'];
                unset($_SESSION["orderSuggested"][$codigo]);
            }
            break;
        case 'ModificarProducto':
            session_start();
            $codigo = $_POST['codigo'];
            $cantidad = $_POST['cantidad'];
            $inventario = Inventario::getListaEnObjetos("codigoProducto = '{$codigo}' limit 1", null);
            if ($inventario != null && $_POST['cantidad'] <= ($inventario[0]->getStock() - $inventario[0]->getComprometido())) {
                $_SESSION["carrito"][$codigo]['cantidad'] = $cantidad;
                if (isset($_SESSION["carrito"]) && is_array($_SESSION["carrito"])) {
                    $_SESSION["carrito"][$codigo]['cantidad'] = $cantidad;
                }
                if (isset($_SESSION["orderSuggested"]) && is_array($_SESSION["orderSuggested"])) {
                    $_SESSION["orderSuggested"][$codigo]['cantidad'] = $cantidad;
                }
                $response = [
                    'status' => 'success'
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'No se puede agregar mas unidades porque supera al inventario disponible.',
                    'max' => ($inventario[0]->getStock() - $inventario[0]->getComprometido())
                ];
            }
            echo json_encode($response);
            break;
        case 'VaciarCarrito':
            session_start();
            unset($_SESSION["carrito"]);
            break;
        case 'Pass':
            $array = array();
            session_start();
            if(isset($_SESSION['usuario'])){
                if (!empty($_POST['contrasenaActual']) && !empty($_POST['contrasenaNueva'])) {
                    $claveActual = hash('sha3-512', $_POST['contrasenaActual']);
                    $claveNueva = $_POST['contrasenaNueva'];
                    $identificacion = $_SESSION['usuario']->getNit();
                    $usuario = Usuarios::validar($identificacion, $claveActual);
                    if ($usuario != null) {
                        $usuario = new Usuarios($identificacion);
                        $usuario->setClave($claveNueva);
                        $usuario->modificar($usuario->getNit());
                        $array = array("status" => 'success', "mensaje" => 'Su contraseña se ha actualizado con exito');
                    } else {
                        $array = array("status" => 'error', "mensaje" => 'La contraseña actual es incorrecta');
                    }
                }
            } else {
                $array = array("status" => 'error', "mensaje" => 'Error al actualizar la contraseña');
            }
            echo json_encode($array);
            break;
        case 'MirarPedidos':
            session_start();
            $lista = '';
            if (isset($_SESSION["usuario"])) {
                $myOrders = FacturaDetalle::getLista("codigoFactura = '{$_POST['codigo']}'", null);
                if ($myOrders != null) {
                    foreach ($myOrders as $indice => $arreglo) {
                        $total = number_format($arreglo['cantidadSolicitada'] * $arreglo['precio']);
                        $lista .= '<tr>';
                        $lista .= "<td>{$arreglo['descripcion']}</td>";
                        $lista .= "<td>{$arreglo['cantidadSolicitada']}</td>";
                        $lista .= "<td>$total</td>";
                        $lista .= '</tr>';
                    }
                }
            }
            echo $lista;
            break;
        case 'FichaTecnica':
            $productos = new Producto($_POST['codigo']);
            $array = array(
                "descripcion" => $productos->getDescripcion(),
                "fichaTecnica" => $productos->getCaracteristicas(),
                "foto" => $productos->getFoto()
            );
            json_encode($array);
            echo json_encode($array);
            break;
        default: break;
    }
}
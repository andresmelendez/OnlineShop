<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

@session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php?mensaje=Acceso no autorizado");
}

require_once 'clases/app/Perfil.php';

$lista = '';

switch ($usuario->getIdPerfil()) {
    case '1':
        $lista = '<li class="nav-item">
                <a data-toggle="collapse" href="#configuracion" title="Despliega las opciones">
                    <i class="fas fa-cog"></i>
                    <p>Configuracion</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="configuracion">
                    <ul class="nav nav-collapse">
                        <li>
                            <a href="principal.php?CONTENIDO=app/configuracion/ciudad/ciudad.php">
                                <span class="sub-item">Ciudades</span>
                            </a>
                        </li>
                        <li>
                            <a href="principal.php?CONTENIDO=app/configuracion/marca/marca.php">
                                <span class="sub-item">Marcas</span>
                            </a>
                        </li>
                        <li>
                            <a href="principal.php?CONTENIDO=app/configuracion/linea/linea.php">
                                <span class="sub-item">Lineas</span>
                            </a>
                        </li>
                        <li>
                            <a href="principal.php?CONTENIDO=app/configuracion/grupo/grupo.php">
                                <span class="sub-item">Grupos</span>
                            </a>
                        </li>
                        <li>
                            <a href="principal.php?CONTENIDO=app/configuracion/almacen/almacen.php">
                                <span class="sub-item">Almacen</span>
                            </a>
                        </li>
                        <li>
                            <a href="principal.php?CONTENIDO=app/configuracion/impuestos/impuestos.php">
                                <span class="sub-item">Impuestos</span>
                            </a>
                        </li>
                        <li>
                            <a href="principal.php?CONTENIDO=app/configuracion/medioDePago/medioDePago.php">
                                <span class="sub-item">Medio de pago</span>
                            </a>
                        </li>
                        <li>
                            <a href="principal.php?CONTENIDO=app/configuracion/unidadEmpaque/unidadEmpaque.php">
                                <span class="sub-item">Unidades de empaque</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-toggle="collapse" href="#usuarios" title="Despliega las opciones">
                    <i class="fas fa-cog"></i>
                    <p>Usuarios</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="usuarios">
                    <ul class="nav nav-collapse">
                        <li>
                            <a href="principal.php?CONTENIDO=app/usuarios/perfil/perfil.php">
                                <span class="sub-item">Perfil</span>
                            </a>
                        </li>
                        <li>
                            <a href="principal.php?CONTENIDO=app/usuarios/clientes/clientes.php">
                                <span class="sub-item">Clientes</span>
                            </a>
                        </li>
                        <li>
                            <a href="principal.php?CONTENIDO=app/usuarios/proveedores/proveedores.php">
                                <span class="sub-item">Proveedores</span>
                            </a>
                        </li>
                        <li>
                            <a href="principal.php?CONTENIDO=app/usuarios/colaboradores/colaboradores.php">
                                <span class="sub-item">Colaboradores</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-toggle="collapse" href="#inventario">
                    <i class="fas fa-th-list"></i>
                    <p>Inventario</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="inventario">
                    <ul class="nav nav-collapse">
                        <li>
                            <a href="principal.php?CONTENIDO=app/inventario/productos/productos.php">
                                <span class="sub-item">Productos</span>
                            </a>
                        </li>
                        <li>
                            <a href="principal.php?CONTENIDO=app/inventario/inventario/inventario.php">
                                <span class="sub-item">Inventario</span>
                            </a>
                        </li>
                        <li>
                            <a href="principal.php?CONTENIDO=app/inventario/kardex/kardex.php">
                                <span class="sub-item">Kardex</span>
                            </a>
                        </li>
                        <li>
                            <a href="principal.php?CONTENIDO=app/inventario/descuentoProducto/descuentoProducto.php">
                                <span class="sub-item">Descuentos</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-toggle="collapse" href="#compras">
                    <i class="fas fa-tag"></i>
                    <p>Compras</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="compras">
                    <ul class="nav nav-collapse">
                        <li>
                            <a href="principal.php?CONTENIDO=app/compras/compras.php">
                                <span class="sub-item">Compras</span>
                            </a>
                        </li>
                        <li>
                            <a href="principal.php?CONTENIDO=app/compras/comprasFormulario.php">
                                <span class="sub-item">Agregar compra</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-toggle="collapse" href="#ventas">
                    <i class="fas fa-tag"></i>
                    <p>Ventas</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="ventas">
                    <ul class="nav nav-collapse">
                        <li>
                            <a href="principal.php?CONTENIDO=app/ventas/factura.php">
                                <span class="sub-item">Ventas</span>
                            </a>
                        </li>
                        <li>
                            <a href="principal.php?CONTENIDO=app/ventas/facturaFormulario.php">
                                <span class="sub-item">Agregar venta</span>
                            </a>
                        </li>
                        <li>
                            <a href="principal.php?CONTENIDO=app/ventas/reporteVenta.php">
                                <span class="sub-item">Reporte</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-toggle="collapse" href="#pedidos">
                    <i class="fas fa-tag"></i>
                    <p>Pedidos</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="pedidos">
                    <ul class="nav nav-collapse">
                        <li>
                            <a href="principal.php?CONTENIDO=app/pedidos/pedidos.php">
                                <span class="sub-item">Pedidos</span>
                            </a>
                        </li>
                        <li>
                            <a href="principal.php?CONTENIDO=app/pedidos/pedidosFormulario.php">
                                <span class="sub-item">Agregar pedido</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>';
        break;
    case '3':
        $lista = '<li class="nav-item">
                <a data-toggle="collapse" href="#pedidos">
                    <i class="fas fa-tag"></i>
                    <p>Ventas</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="pedidos">
                    <ul class="nav nav-collapse">
                        <li>
                            <a href="principal.php?CONTENIDO=app/pedidos/pedidos.php">
                                <span class="sub-item">Pedidos</span>
                            </a>
                        </li>
                        <li>
                            <a href="principal.php?CONTENIDO=app/pedidos/pedidosFormulario.php">
                                <span class="sub-item">Agregar pedido</span>
                            </a>
                        </li>
                        <li>
                            <a href="principal.php?CONTENIDO=app/pedidos/facturaFormulario.php">
                                <span class="sub-item">Agregar venta</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>';
        break;
    default:
        break;
}
?>
<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
        <div class="user">
            <div class="avatar-sm float-left mr-2">
                <img src="imagenes/distribucionesOssa.jpg" alt="..." class="avatar-img rounded-circle">
            </div>
            <div class="info">
                <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                    <span style="white-space: normal">
                        <?= $usuario ?>
                        <span class="user-level"><?= $usuario->getPerfil() ?></span>
                        <span class="caret"></span>
                    </span>
                </a>
                <div class="clearfix"></div>

                <div class="collapse in" id="collapseExample">
                    <ul class="nav">
                        <li>
                            <a href="principal.php?CONTENIDO=pedidos/perfil/perfil/perfil.php">
                                <span class="link-collapse">Mi perfil</span>
                            </a>
                        </li>
                        <li>
                            <a href="principal.php?CONTENIDO=pedidos/perfil/cambiarClave/cambiarClave.php">
                                <span class="link-collapse">Cambiar clave</span>
                            </a>
                        </li>
                        <li>
                            <a href="#settings">
                                <span class="link-collapse">Configuracion</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav nav-primary">
            <li class="nav-item active">
                <a data-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
                    <i class="fas fa-home"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-section">
                <span class="sidebar-mini-icon">
                    <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Modulos</h4>
            </li>
            <?= $lista ?>
        </ul>
    </div>
</div>
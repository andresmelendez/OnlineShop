<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

@session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php?mensaje=Acceso no autorizado");
}

require_once 'clases/app/Factura.php';
require_once 'clases/app/FacturaDetalle.php';
require_once 'clases/app/Usuarios.php';
require_once 'clases/app/Producto.php';
require_once 'clases/app/Ciudad.php';

$lista = '';
$facturaTotal = 0;
$pedido = new Factura($_GET['codigoPedido']);
$cliente = new Usuarios($pedido->getNitCliente());
$tipoPrecios = $cliente->getTipoPrecios() === '1' ? 'Mayorista' : ($cliente->getTipoPrecios() === '2' ? 'Peluqueria' : 'Publico' );
$pedidoDetalle = FacturaDetalle::getListaEnObjetos("codigoFactura='{$pedido->getCodigo()}'", 'descripcion');
if ($pedidoDetalle != null) {
    for ($i = 0; $i < count($pedidoDetalle); $i++) {
        $pedidoDetalles = $pedidoDetalle[$i];
        $total = $pedidoDetalles->getCantidadSolicitada() * $pedidoDetalles->getPrecio();
        $facturaTotal += $pedidoDetalles->getCantidadSolicitada() * $pedidoDetalles->getPrecio();
        $lista .= "<tr>";
        $lista .= "<td class='d-none'><input class='id' type='hidden' name='id[]' value='{$pedidoDetalles->getId()}'>{$pedidoDetalles->getId()}</td>";
        $lista .= "<td><input class='codigoProducto' type='hidden' name='codigoProducto[]' value='{$pedidoDetalles->getCodigoProducto()}'>{$pedidoDetalles->getCodigoProducto()}</td>";
        $lista .= "<td><input class='descripcion' type='hidden' name='descripcion[]' value='{$pedidoDetalles->getProducto()->getDescripcion()}'>{$pedidoDetalles->getProducto()->getDescripcion()}</td>";
        $lista .= "<td><input class='cantidad' type='hidden' name='cantidad[]' value='{$pedidoDetalles->getCantidadSolicitada()}'>{$pedidoDetalles->getCantidadSolicitada()}</td>";
        $lista .= "<td><input class='precioUnitario' type='hidden' name='precioUnitario[]' value='{$pedidoDetalles->getPrecio()}' min='0' max='1000000000'>$&nbsp;" . number_format($pedidoDetalles->getPrecio(), 0, ',', '') . "</td>";
        $lista .= "<td><input class='cantidadReal' type='number' name='cantidadReal[]' min='0' max='100000' onClick='actualizar($(this))' onkeyup='actualizar($(this))' value='{$pedidoDetalles->getCantidadSolicitada()}'><p class='d-none cantidadR'>{$pedidoDetalles->getCantidadSolicitada()}</p></td>";
        $lista .= '</tr>';
    }
}

?>
<style>
    .ancho {
        white-space: nowrap;
        width: 200px;
    }
</style>
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Pedidos</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="#">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Pedidos</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-table mr-1"></i>
                        Pedidos
                    </div>
                </div>
                <form id="formularioDatos" name="formularioDatos" method="post">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha">Fecha</label>
                                    <input class="form-control" id="fecha" name="fecha" type="text" value="<?= $pedido->getFechaHoraDocumento() ?>" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha">Estado</label>
                                    <select class="form-control select2" id="estado" name="estado" readonly>
                                        <option value="F">Orden de compra</option>
                                        <option value="A">Anulado</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <hr>
                            <label>Datos del cliente</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="nit">Nit / Identificacion  <span class="required-label">*</span></label>
                                    <input class="form-control" id="nit" name="nit" type="text" value="<?= $cliente->getNit() ?>" placeholder="" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="nombres">Nombres  <span class="required-label">*</span></label>
                                    <input class="form-control" id="nombres" name="nombres" type="text" value="<?= $cliente->getNombres() ?>" placeholder="" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="apellidos">Apellidos  <span class="required-label">*</span></label>
                                    <input class="form-control" id="apellidos" name="apellidos" type="text" value="<?= $cliente->getApellidos() ?>" placeholder="" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="nombreComercial">Nombre comercial</label>
                                    <input class="form-control" id="nombreComercial" name="nombreComercial" type="text" value="<?= $cliente->getNombreComercial() ?>" placeholder="">
                                </div>
                                <div class="col-md-4">
                                    <label for="Celular">Celular  <span class="required-label">*</span></label>
                                    <input class="form-control" id="celular" name="celular" type="text" value="<?= $cliente->getCelular() ?>" placeholder="" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="Barrio">Tipo de precios <span class="required-label">*</span></label>
                                    <input type="text" class="form-control" id="tipoPrecios" value="<?= $tipoPrecios ?>" placeholder="" name="tipoPrecios" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="Ciudad">Ciudad <span class="required-label">*</span></label>
                                    <input type="text" class="form-control" id="codigoCiudad" placeholder="" name="codigoCiudad"  value="<?= $cliente->getCiudad()->getNombre() ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="Barrio">Barrio <span class="required-label">*</span></label>
                                    <input type="text" class="form-control" id="barrio" placeholder="" name="barrio"  value="<?= $cliente->getBarrio() ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="Direccion">Direccion <span class="required-label">*</span></label>
                                    <input type="text" class="form-control" id="direccion" placeholder="" name="direccion"  value="<?= $cliente->getDireccion() ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                            <div class="table-responsive mt-3">
                                <table class="table table-hover" id="tablaProductosAgregados" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="d-none"></th>
                                            <th>Codigo producto</th>
                                            <th>Producto</th>
                                            <th>Cantidad solicitada</th>
                                            <th>Precio unitario</th>
                                            <th>Cantidad entregada</th>
                                        </tr>
                                    </thead>
                                    <tbody id="lista">
                                        <?= $lista ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td><h4 class="font-weight-bold">Total Pedido</h4></td>
                                            <td><h4 class="font-weight-bold">$&nbsp;<?= number_format($facturaTotal) ?></h4></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td><h4 class="font-weight-bold">Total Facturado</h4></td>
                                            <td><h4 class="font-weight-bold" id="totalFacturado">$&nbsp;<?= number_format($facturaTotal) ?></h4></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="row justify-content-center align-items-center">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="Observaciones">Observaciones</label>
                                    <textarea type="text" class="form-control" id="observacion" placeholder="" name="observacion"><?= $pedido->getObservacion() ?></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group d-flex align-items-center justify-content-center mt-4 mb-1">
                            <a href="principal.php?CONTENIDO=app/pedidos/pedidos.php" class="btn btn-danger btn-round mx-1" id="cancelar">Cancelar</a>
                            <input type="hidden" class="btn btn-primary btn-round" id="codigoPedido" name="codigoPedido" value="<?= $pedido->getCodigo() ?>">
                            <input type="submit" class="btn btn-primary btn-round" id="accion" name="accion" value="orden de compra">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#formularioDatos').submit(function (e) {
        e.preventDefault();
        var accion = $('#accion').val() === 'orden de compra' ? 'OrdenCompra' : $('#accion').val();
        var datos = new FormData(this);
        datos.append('accion', accion);
        $.ajax({
            url: "app/pedidos/pedidosAcciones.php",
            type: "POST",
            datatype: "json",
            data: datos,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                document.getElementById('formularioDatos').innerHTML = '<h1 class="text-center text-danger">Por favor espere un momento</h1>';
            },
            success: function (datos) {
                console.log(datos);
                datos = JSON.parse(datos); 
                if(datos.status === 'success') {
                    alert(datos.mensaje);
                    window.location.href = 'principal.php?CONTENIDO=app/pedidos/pedidos.php';
                }
            }
        });
    });
    
    const formatoMoneda = new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 0
    });
    
    $(document).on('change', '.cantidadReal', function () {
        var totalFacturado = 0;

        $('#tablaProductosAgregados tbody tr').each(function () {
            var cantidadReal = parseFloat($(this).find(".cantidadReal").val()) || 0;
            var precioUnitario = parseFloat($(this).find(".precioUnitario").val()) || 0;
            var total = cantidadReal * precioUnitario;
            totalFacturado += total;
        });

        $('#totalFacturado').html(formatoMoneda.format(totalFacturado));
    });
</script>
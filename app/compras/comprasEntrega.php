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

$lista = '';
$facturaTotal = 0;
$unidadesTotal = 0;
$pedido = new Factura($_GET['codigoCompras']);
$pedidoDetalle = FacturaDetalle::getListaEnObjetos("codigoFactura='{$pedido->getCodigo()}'", 'descripcion');
if ($pedidoDetalle != null) {
    for ($i = 0; $i < count($pedidoDetalle); $i++) {
        $pedidoDetalles = $pedidoDetalle[$i];
        $total = $pedidoDetalles->getCantidadSolicitada() * $pedidoDetalles->getPrecio();
        $facturaTotal += $pedidoDetalles->getCantidadSolicitada() * $pedidoDetalles->getPrecio();
        $unidadesTotal += $pedidoDetalles->getCantidadSolicitada();
        $lista .= "<tr>";
        $lista .= "<td class='d-none'><input class='id' type='hidden' name='id[]' value='{$pedidoDetalles->getId()}'>{$pedidoDetalles->getId()}</td>";
        $lista .= "<td><input class='codigoProducto' type='hidden' name='codigoProducto[]' value='{$pedidoDetalles->getCodigoProducto()}'>{$pedidoDetalles->getCodigoProducto()}</td>";
        $lista .= "<td><input class='descripcion' type='hidden' name='descripcion[]' value='{$pedidoDetalles->getProducto()->getDescripcion()}'>{$pedidoDetalles->getProducto()->getDescripcion()}</td>";
        $lista .= "<td><input class='cantidad' type='hidden' name='cantidad[]' value='{$pedidoDetalles->getCantidadSolicitada()}'>{$pedidoDetalles->getCantidadSolicitada()}</td>";
        $lista .= "<td><input class='cantidadReal' type='number' name='cantidadReal[]' min='0' max='100000' value='{$pedidoDetalles->getCantidadSolicitada()}'></td>";
        $lista .= "<td><input class='precioUnitario' type='number' name='precioUnitario[]' value='{$pedidoDetalles->getPrecio()}' min='0' max='1000000000'></td>";
        $lista .= '<td><input class="proceso" type="checkbox"></td>';
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
                <a href="#">Compras</a>
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
                        Compras
                    </div>
                </div>
                <form id="formularioDatos" name="formularioDatos" method="post">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fecha">Fecha</label>
                                    <input class="form-control" id="fecha" name="fecha" type="text" value="<?= $pedido->getFechaHoraDocumento() ?>" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fecha">Estado</label>
                                    <select class="form-control select2" id="estado" name="estado" readonly>
                                        <option value="F">Orden de compra</option>
                                        <option value="A">Anulado</option>
                                    </select>
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
                                            <th>Cantidad entregada</th>
                                            <th>Costo con iva</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="lista">
                                        <?= $lista ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="row justify-content-center align-items-center">
                            <label>
                                Total: <b id="total"><?= number_format($facturaTotal) ?></b><br>
                                Total Unidades: <b id="totalUnidades"><?= number_format($unidadesTotal) ?></b>
                            </label>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="Observaciones">Observaciones</label>
                                    <textarea type="text" class="form-control" id="observacion" placeholder="" name="observacion"><?= $pedido->getObservacion() ?></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group d-flex align-items-center justify-content-center mt-4 mb-1">
                            <a href="principal.php?CONTENIDO=app/compras/compras.php" class="btn btn-danger btn-round mx-1" id="cancelar">Cancelar</a>
                            <input type="hidden" class="btn btn-primary btn-round" id="codigoCompras" name="codigoCompras" value="<?= $pedido->getCodigo() ?>">
                            <input type="submit" class="btn btn-primary btn-round" id="accion" name="accion" value="Orden de compra">
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
        var accion = $('#accion').val() === 'Orden de compra' ? 'OrdenCompra' : $('#accion').val();
        var datos = new FormData(this);
        datos.append('accion', accion);
        Swal.fire({
            title: 'Esta seguro de registrar la orden de compra?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, registrar!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "app/compras/comprasAcciones.php",
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
                        datos = JSON.parse(datos); 
                        if(datos.status === 'success') {
                            alert(datos.mensaje);
                            window.location.href = 'principal.php?CONTENIDO=app/compras/compras.php';
                        }
                    }
                });
            }
        });
    });
    
    const formatoMoneda = new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 0
    });
    
    $(document).on('click', '.proceso', function () {
        if (!$(this).closest('tr').hasClass('bg-success')){
            $(this).closest('tr').addClass('bg-success text-light');
        } else {
            $(this).closest('tr').removeClass('bg-success text-light');
        }
    });
    
    $(document).on('keyup', '.cantidadReal, .precioUnitario', function () {
        sumPrice = 0;
        sumUn = 0;
        $('.cantidadReal').each(function () {
            cantidadReal = $(this).closest('tr').find(".cantidadReal").val();
            precioUnitario = $(this).closest('tr').find(".precioUnitario").val();
            sumPrice += cantidadReal * precioUnitario;
            sumUn += parseInt(cantidadReal);
        });
        $('#total').text(new Intl.NumberFormat().format(sumPrice));
        $('#totalUnidades').text(new Intl.NumberFormat().format(sumUn));
    });
</script>
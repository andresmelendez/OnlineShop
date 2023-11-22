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

date_default_timezone_set('America/Bogota');
$fechaActual = date("Y-m-d H:i:s");
?>
<style>
    .ancho {
        white-space: nowrap;
        width: 100%;
    }

    @media (min-width:992px){
        .modal-grande{
            max-width:1300px
        }
    }
</style>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-grande" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formulario">
                <div class="modal-body">
                    <div class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_length">
                                    <label>Mostrar 
                                        <select name="registrosXPagina" id="registrosXPagina" class="form-control form-control-sm">
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                        </select> registros
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-5">
                                <div id="tablaAlmacen_filter" class="dataTables_filter">
                                    <label>Buscar:<input type="search" class="form-control form-control-sm searchFilter" placeholder="" id="buscar" name="buscar" autocomplete="off"></label>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-hover text-truncate" id="tablaProductos">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Producto</th>
                                        <th>Unidad de empaque</th>
                                        <th>Disponible</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Accion</th>
                                    </tr>
                                <tbody id="lista">
                                </tbody>
                            </table>
                        </div>
                        <div class="row text-center align-items-center justify-content-center mt-4 mb-4" id="paginacion">

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="imagemodal" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formulario">
                <div class="modal-body">
                    <img class="img-fluid" id="imagepreview" src="">
                </div>
            </form>
        </div>
    </div>
</div>

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Agregar Venta</h4>
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
                <a href="#">Ventas</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Agregar Venta</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-table mr-1"></i>
                        Ventas
                    </div>
                </div>
                <form id="formularioDatos" name="formularioDatos" method="post">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha">Fecha</label>
                                    <input class="form-control" id="fecha" name="fecha" type="text" value="<?= $fechaActual ?>" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha">Estado</label>
                                    <select class="form-control" id="estado" name="estado" readonly>
                                        <option value="P">Pendiente</option>
                                        <option value="F">Orden de compra</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <hr>
                            <label>Datos del cliente</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="Cliente">Cliente</label>
                                    <ul class="list-group list-group-bordered list">
                                        <div class="nav-item dropdown">
                                            <div class="input-group">
                                                <input class="form-control border border-primary" id="datosBuscar" name="datosBuscar" identificacionCliente="" placeholder="Buscar cliente" autocomplete="off">
                                                <div class="input-group-append" id="borrarDatosInput">
                                                    <span class="input-group-text text-danger"><i class="fas fa-times-circle"></i></span>
                                                </div>
                                            </div>
                                            <div id="listaClientes">
                                            </div>
                                        </div>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <label for="nit">Nit / Identificacion  <span class="required-label">*</span></label>
                                    <input class="form-control" id="nit" name="nit" type="text" value="" placeholder="" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="nombres">Nombres  <span class="required-label">*</span></label>
                                    <input class="form-control" id="nombres" name="nombres" type="text" value="" placeholder="" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="apellidos">Apellidos  <span class="required-label">*</span></label>
                                    <input class="form-control" id="apellidos" name="apellidos" type="text" value="" placeholder="" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="Celular">Celular  <span class="required-label">*</span></label>
                                    <input class="form-control" id="celular" name="celular" type="text" value="" placeholder="" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="Ciudad">Ciudad <span class="required-label">*</span></label>
                                    <select class="form-control select2" id="codigoCiudad" placeholder="" name="codigoCiudad"  value="" required></select>
                                </div>
                                <div class="col-md-4">
                                    <label for="Barrio">Tipo de precios <span class="required-label">*</span></label>
                                    <select type="text" class="form-control" id="tipoPrecios" placeholder="" name="tipoPrecios" required>
                                        <option value="1">Mayorista</option>
                                        <option value="2">Peluqueria</option>
                                        <option value="3" selected>Publico</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group d-flex align-items-center justify-content-between mt-1 mb-1">
                            <button type="button" id="btnAgregarProducto" class="btn btn-primary btn-round" data-toggle="modal" data-target="#exampleModal">
                                Agregar producto
                            </button>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-hover" id="tablaProductosAgregados" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Codigo producto</th>
                                        <th>Producto</th>
                                        <th>Precio lista</th>
                                        <th>Descuento</th>
                                        <th>Precio U</th>
                                        <th>cantidad</th>
                                        <th>Valor total</th>
                                        <th style="text-align: right">Gestion</th>
                                    </tr>
                                </thead>
                                <tbody id="nuevoProducto">
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <div class="row justify-content-center align-items-center">
                            <div class="col-md-3">
                                <input type="hidden" name="numItems" id="numItems">
                                <input type="hidden" name="numProductos" id="numProductos">
                                <input type="hidden" name="total" id="total">
                                <h4 class="text-success">Subtotal: <b id="Subtotal"></b></h4>
                                <h4 class="text-success">Total a pagar: <b id="valorFinal"></b></h4>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="Observaciones">Observaciones</label>
                                    <textarea type="text" class="form-control" id="observacion" placeholder="" name="observacion"  value=""></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group d-flex align-items-center justify-content-center mt-4 mb-1">
                            <a id="cancelar" class="btn btn-danger btn-round mx-1 text-light">Cancelar</a>
                            <input type="submit" class="btn btn-primary btn-round" id="accion" name="accion" value="Registrar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    const formatoMoneda = new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 0
    });

    //filters

    $.ajax({
        type: "POST",
        url: "app/usuarios/colaboradores/colaboradoresAcciones.php",
        data: {accion: 'SelectCiudad'},
        success: function (datos) {
            $('#codigoCiudad').html(datos).fadeIn();
        }
    });

    //filters
    
    $(document).ready(function (e) {
        $('#datosBuscar').on('keyup', function () {
            $.ajax({
                type: "POST",
                url: "app/ventas/facturaAcciones.php",
                data: {
                    cliente: $('#datosBuscar').val(),
                    accion: 'Cliente'
                },
                success: function (data) {
                    if ($('#datosBuscar').val() !== '') {
                        $('#listaClientes').fadeIn(1000).html(data);
                        $('.dropdown-item').on('click', function () {
                            $('#datosBuscar').val($('#' + $(this).attr('id')).attr('data'));
                            $('#datosBuscar').attr("identificacionCliente", $(this).attr('id'));
                            $('#listaClientes').fadeOut();
                            $.ajax({
                                type: "POST",
                                url: "app/pedidos/pedidosAcciones.php",
                                data: {nit: $(this).attr('id'), accion: 'Mostrar'}
                            }).done(function (datos) {
                                datos = JSON.parse(datos);
                                $("#nit").val(datos.nit);
                                $("#nombres").val(datos.nombres);
                                $("#apellidos").val(datos.apellidos);
                                $("#nombreComercial").val(datos.nombreComercial);
                                $("#celular").val(datos.celular);
                                $("#email").val(datos.email);
                                $("#barrio").val(datos.barrio);
                                $("#direccion").val(datos.direccion);
                                $("#tipoNegocio").val(datos.tipoNegocios);
                                $("#tipoPrecios").val(datos.tipoPrecios);
                                $('#codigoCiudad option[value="' + datos.codigoCiudad + '"]').prop('selected', true);
                                $("#cupo").val(datos.cupo);
                            });
                        });
                    } else {
                        $('#listaClientes').fadeOut();
                        $('#datosBuscar').attr("identificacionCliente", '');
                    }
                }
            });
        });
    });
    
    $(document).on("click", ".btnAgregarProductoPedido", function () {
        $.ajax({
            type: "POST",
            url: "app/ventas/facturaAcciones.php",
            data: {codigo: $(this).closest('tr').find('td:eq(0)').text(), cantidad: $(this).closest('tr').find(".cantidadModal").val(), tipoPrecios: $('#tipoPrecios').val(), accion: 'AgregarProducto'},
        }).done(function (datos) {
            datos = JSON.parse(datos);
            $('#tablaProductosAgregados').append(
                '<tr>' +
                    "<td><input class='codigo' type='hidden' name='codigo[]' value='" + datos.codigo + "'>" + datos.codigo + "</td>" +
                    "<td class='ancho'><input class='descripcion' type='hidden' name='descripcion[]' value='" + datos.descripcion + "'>" + datos.descripcion + "</td>" +
                    "<td><input class='precioLista' type='hidden' name='precioLista[]' value='" + datos.precioLista + "'>" + formatoMoneda.format(datos.precioLista) + "</td>" +
                    "<td><input class='descuento' type='hidden' name='descuento[]' value='" + datos.descuento + "'>" + datos.descuento + "</td>" +
                    "<td><input class='precioUnitario' type='hidden' name='precioUnitario[]' value='" + datos.precio + "'>" + formatoMoneda.format(datos.precio) + "</td>" +
                    "<td><input class='cantidad form-comtrol-sm' type='number' name='cantidad[]' min='1' max='5000' value='" + datos.cantidad + "' onClick='datosCalculados($(this))' onkeyup='datosCalculados($(this))'></td>" +
                    "<td class='valorTotal'>" + formatoMoneda.format(datos.precioTotal) + "</td>" +
                    '<td class="btnQuitarProducto text-center"><i class="fas fa-trash-alt"></i></td>' +
                    "<td class='d-none precioTotalFila'>" + datos.precioTotal + "</td>" +
                    "<td class='d-none codigoPro'>" + datos.codigo + "</td>" +
                    "<td class='d-none cantidadSumar'>" + datos.cantidad + "</td>" +
                '</tr>'
            );
            actualizar();
        });
    });
    
    $('.searchFilter').on('keyup', function () {
        onload(1);
    });

    $(document).on('click', '.btnQuitarProducto', function () {
        $(this).closest('tr').remove(); onload(1); actualizar();
    });
    
    $(document).on('change', '#tipoPrecios', function () {
        onload(1);
    });
    
    $('#formularioDatos').submit(function (e) {
        e.preventDefault();
        formData = new FormData(this);
        formData.append('accion', 'Factura');
        formData.append('total', $.trim($('#valorFinal').text().replace('.', '').replace('$', '')));
        if (document.getElementById('tablaProductosAgregados').rows.length > 1 && $("#tipoPrecios").val() == '3') {
            $.ajax({
                type: "POST",
                url: "app/ventas/facturaAcciones.php",
                datatype: "json",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
            }).done(function (datos) {
                console.log(datos);
                alert('Pedido registrado');
                $("#formularioDatos").trigger("reset");
                $("#tablaProductosAgregados > tbody").html("");
                $("#valorFinal").html("");
                var hoy = new Date();
                var fecha = hoy.getFullYear() + '-' + (hoy.getMonth() + 1) + '-' + hoy.getDate();
                var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
                $("#fecha").val(fecha + ' ' + hora);
                actualizar();
            });
        } else {
            alert('Lo sentimos pero no se pudo enviar el pedido debido a que no hay productos en la lista o el tipo de precios no es el de publico');
        }
    });

    $("#cancelar").click(function () {
        var tabla = document.getElementById('tablaProductosAgregados');
        if (tabla.rows.length > 1) {
            var respuesta = confirm("¿Esta seguro de cancelar el pedido?\nSi le da aceptar se perderan los datos del pedido");
            if (respuesta) {
                window.location.href = 'principal.php?CONTENIDO=app/ventas/factura.php';
            }
        } else {
            window.location.href = 'principal.php?CONTENIDO=app/ventas/factura.php';
        }
    });
    
    $('#borrarDatosInput').click(function (e) {
        e.preventDefault();
        $('#nombres').val('');
        $('#listaClientes').fadeOut();
        vaciarDatos();
    });
    
    onload(1);
    function onload(pagina) {
        $.ajax({
            type: 'POST',
            url: "app/ventas/facturaAcciones.php",
            data: {
                accion: 'Productos',
                pagina: pagina,
                filtro: $('.searchFilter').val(),
                registrosXPagina: $('#registrosXPagina').val(),
                tipoPrecios: $('#tipoPrecios').val()
            },
            success: function (datos) {
                if (datos != null) {
                    datos = datos.split('|');
                    $('#lista').fadeIn(2000).html(datos[0]);
                    document.getElementById("paginacion").innerHTML = datos[1];
                    bloquear();
                }
            }
        });
    }
    
    function bloquear() {
        if (document.getElementById('pagina').max === $("#pagina").val()) {
            $("#siguiente").removeAttr('onclick');
            $("#ultimo").removeAttr('onclick');
        }

        if ($("#pagina").val() === 1) {
            $("#primero").removeAttr('onclick');
            $("#anterior").removeAttr('onclick');
        }
    }

    function actualizarPagina(pagina) {
        onload(pagina);
    }

    function datosCalculados(fila) {
        var cantidad = fila.closest('tr').find(".cantidad").val();
        var precioUnitario = fila.closest('tr').find(".precioUnitario").val();
        var precioTotal = precioUnitario * cantidad;
        fila.closest('tr').find(".valorTotal").text(formatoMoneda.format(precioTotal));
        fila.closest('tr').find(".precioTotalFila").text(precioTotal);
        fila.closest('tr').find(".cantidadSumar").text(cantidad);
        actualizar();
    }

    function actualizar() {
        var valorFinal = 0;
        var cantidadProductos = 0;
        var tabla = document.getElementById('tablaProductosAgregados');
        for (var i = 1; i < tabla.rows.length; i++) {
            for (var j = 0; j < 11; j++) {
                if (j == 8) valorFinal += parseInt(tabla.rows[i].cells[j].innerText);
                if (j == 9) $("#boton"+tabla.rows[i].cells[9].innerText).addClass('d-none');
                if (j == 10) cantidadProductos += parseInt(tabla.rows[i].cells[j].innerText);
            }
        }
        $('#numProductos').val(cantidadProductos);
        $('#numItems').val(tabla.rows.length - 1);
        $("#total").val(valorFinal);
        $("#Subtotal").text(formatoMoneda.format(valorFinal));
        $("#valorFinal").html(formatoMoneda.format(valorFinal));
    }

    function vaciarDatos() {
        $("#nit").val('');
        $("#nombres").val('');
        $("#apellidos").val('');
        $("#nombreComercial").val('');
        $("#celular").val('');
        $("#email").val('');
        $("#barrio").val('');
        $("#direccion").val('');
        $("#tipoNegocio").val('');
        $("#cupo").val('');
    }
    
    $(document).on('click', '.imgProduct', function () {
       $('#imagepreview').attr('src', $(this).attr('src')); // here asign the image to the modal when the user click the enlarge link
       $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
    });
</script>
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
$fechaActual = date("Y-m-d h:i:s");
?>
<style>
    .ancho {
        white-space: nowrap;
        width: 100%;
    }

    @media (min-width:992px){
        .modal-grande{
            max-width:1600px
        }
    }
    
    @media (min-width:992px){
        .modal-lg{
            max-width:1200px
        }
    }
    
    .rtable {
        display: inline-block;
        vertical-align: top;
        max-width: 100%;
        overflow-x: auto;
        white-space: nowrap;
        border-collapse: collapse;
        border-spacing: 0;
    }

    .rtable,
    .rtable--flip tbody {
        -webkit-overflow-scrolling: touch;
        background: radial-gradient(left, ellipse, rgba(0, 0, 0, 0.2) 0%, rgba(0, 0, 0, 0) 75%) 0 center, radial-gradient(right, ellipse, rgba(0, 0, 0, 0.2) 0%, rgba(0, 0, 0, 0) 75%) 100% center;
        background-size: 10px 100%, 10px 100%;
        background-attachment: scroll, scroll;
        background-repeat: no-repeat;
    }

    .rtable td:first-child,
    .rtable--flip tbody tr:first-child {
        background-image: linear-gradient(to right, white 50%, rgba(255, 255, 255, 0) 100%);
        background-repeat: no-repeat;
        background-size: 20px 100%;
    }

    .rtable td:last-child,
    .rtable--flip tbody tr:last-child {
        background-image: linear-gradient(to left, white 50%, rgba(255, 255, 255, 0) 100%);
        background-repeat: no-repeat;
        background-position: 100% 0;
        background-size: 20px 100%;
    }

    .rtable th {
        font-size: 11px;
        text-align: left;
        text-transform: uppercase;
        background: #f2f0e6;
    }

    .rtable th,
    .rtable td {
        border: 1px solid #d9d7ce;
    }

    .rtable--flip {
        display: flex;
        overflow: hidden;
        background: none;
    }

    .rtable--flip thead {
        display: flex;
        flex-shrink: 0;
        min-width: -webkit-min-content;
        min-width: -moz-min-content;
        min-width: min-content;
    }

    .rtable--flip tbody {
        display: flex;
        position: relative;
        overflow-x: auto;
        overflow-y: hidden;
    }

    .rtable--flip tr {
        display: flex;
        flex-direction: column;
        min-width: -webkit-min-content;
        min-width: -moz-min-content;
        min-width: min-content;
        flex-shrink: 0;
    }

    .rtable--flip td,
    .rtable--flip th {
        display: block;
    }

    .rtable--flip td {
        background-image: none !important;
        border-left: 0;
    }

    .rtable--flip th:not(:last-child),
    .rtable--flip td:not(:last-child) {
        border-bottom: 0;
    }
    
    .table-container {
        max-height: 500px; /* Ajusta la altura según tus necesidades */
        overflow: auto;
    }
    
    .sticky-thead th {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        background-color: #f5f5f5; /* Cambia el color de fondo según tus preferencias */
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
                            <div class="col-sm-12 col-lg-7">
                                <div class="dataTables_length">
                                    <label>Mostrar 
                                        <select name="registrosXPagina" id="registrosXPagina" class="form-control form-control-sm">
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="30">30</option>
                                        </select> registros
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-5">
                                <div id="tablaAlmacen_filter" class="dataTables_filter">
                                    <label>Buscar:<input type="search" class="form-control form-control-sm searchFilter" placeholder="" id="buscar" name="buscar" autocomplete="off"></label>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive table-container mt-3">
                            <table class="table table-hover" id="tablaProductos">
                                <thead class="sticky-thead">
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Producto</th>
                                        <th>Costo <br>sin iva</th>
                                        <th>Iva</th>
                                        <th>Costo <br>con iva</th>
                                        <th>U.E.</th>
                                        <th>Disponible</th>
                                        <th>Pedido</th>
                                        <th>Cantidad</th>
                                        <th>Accion</th>
                                        <th>Foto</th>
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

<div class="modal fade" id="modalMovimiento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-movimientos-title">Movimientos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive mt-3">
                    <table class="table-sm table-hover text-truncate rtable rtable--flip">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Venta</th>
                            </tr>
                        <tbody id="listaMovimiento">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="imagemodal" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-image">Producto</h5>
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
        <h4 class="page-title">Compras</h4>
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
            <li class="nav-item">
                <a href="#">Agregar Compras</a>
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
                            <label>Datos del proveedor</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="Cliente">Proveedor</label>
                                    <ul class="list-group list-group-bordered list">
                                        <div class="nav-item dropdown">
                                            <div class="input-group">
                                                <input class="form-control" id="datosBuscar" name="datosBuscar" nit placeholder="Proveedor" autocomplete="off">
                                                <div class="input-group-append" id="borrarDatosInput">
                                                    <span class="input-group-text text-danger"><i class="fas fa-times-circle"></i></span>
                                                </div>
                                            </div>
                                            <div id="listaUsuarios">
                                            </div>
                                        </div>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <label for="Identificacion">Nit  <span class="required-label">*</span></label>
                                    <input class="form-control" id="nit" name="nit" type="text" value="" placeholder="" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="razonSocial">Nombre comercial</label>
                                    <input class="form-control" id="nombreComercial" name="nombreComercial" type="text" value="" placeholder="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="Celular">Nombres  <span class="required-label">*</span></label>
                                    <input class="form-control" id="nombres" name="nombres" type="text" value="" placeholder="" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email">Apellidos <span class="required-label">*</span></label>
                                    <input type="text" class="form-control" id="apellidos" placeholder="" name="apellidos"  value="" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="Celular">Celular  <span class="required-label">*</span></label>
                                    <input class="form-control" id="celular" name="celular" type="text" value="" placeholder="" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="Ciudad">Ciudad <span class="required-label">*</span></label>
                                    <select class="form-control select2" id="codigoCiudad" placeholder="" name="codigoCiudad"  value="" required></select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group d-flex align-items-center justify-content-between mt-1 mb-1">
                            <button type="button" id="btnAgregarProducto" class="btn btn-primary btn-round">
                                Agregar producto
                            </button>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-hover" id="tablaProductosAgregados" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Codigo producto</th>
                                        <th>Producto</th>
                                        <th>Costo con iva</th>
                                        <th>Cantidad</th>
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
                            <a id="cancelar" href="principal.php?CONTENIDO=app/compras/compras.php" class="btn btn-danger btn-round mx-1 text-light">Cancelar</a>
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

    $('#datosBuscar').on('keyup', function () {
        $.ajax({
            type: "POST",
            url: "app/compras/comprasAcciones.php",
            data: {
                cliente: $('#datosBuscar').val(),
                accion: 'Cliente'
            },
            success: function (data) {
                if ($('#datosBuscar').val() !== '') {
                    $('#listaUsuarios').fadeIn(1000).html(data);
                    $('.dropdown-item').on('click', function () {
                        $('#datosBuscar').val($('#' + $(this).attr('id')).attr('data'));
                        $('#datosBuscar').attr("nit", $(this).attr('id'));
                        $('#listaUsuarios').fadeOut();
                        $.ajax({
                            type: "POST",
                            url: "app/compras/comprasAcciones.php",
                            data: {nit: $(this).attr('id'), accion: 'Mostrar'}
                        }).done(function (datos) {
                            datos = JSON.parse(datos);
                            $("#nit").val(datos.nit);
                            $("#nombres").val(datos.nombres);
                            $("#apellidos").val(datos.apellidos);
                            $("#nombreComercial").val(datos.nombreComercial);
                            $("#celular").val(datos.celular);
                            $("#clave").val(datos.clave);
                            $("#codigoCiudad").val(datos.codigoCiudad);
                        });
                    });
                } else {
                    $('#listaUsuarios').fadeOut();
                    $('#datosBuscar').attr("nit", '');
                }
            }
        });
    });

    $(document).on("click", "#btnAgregarProducto", function () {
        onload(1); $('#exampleModal').modal('show');
    });

    $('.searchFilter').on('keyup', function () {
        onload(1);
    });

    $("#registrosXPagina").change(function () {
        onload(1);
    });
    
    $(document).on("click", ".item", function () {
        var codigo = $(this).closest('tr').find('td:eq(0)').text();
        var descripcion = $(this).closest('tr').find('td:eq(1)').text();
        var value = $(this).text();

        $.ajax({
            type: "POST",
            url: "app/compras/comprasAcciones.php",
            datatype: "json",
            data: {producto: value, accion: 'Movimientos'},
        }).done(function (datos) {
            datos = JSON.parse(datos);
            $('#listaMovimiento').html(datos.lista);
            $('#modalMovimiento').modal('show');
            $('#modal-movimientos-title').text(descripcion + '(' + codigo + ')');
        });
    });

    $(document).on("click", ".btnAgregarProductoPedido", function () {
        var codigo = $(this).closest('tr').find('td:eq(0)').text();
        var descripcion = $(this).closest('tr').find('td:eq(1)').text();
        var costo = $(this).closest('tr').find('td:eq(2)').text().replace('.', '').replace('$', '');
        var impuesto = $(this).closest('tr').find('td:eq(3)').text();
        var precio = $(this).closest('tr').find('td:eq(4)').text().replace('.', '').replace('$', '');
        var cantidadModal = $(this).closest('tr').find(".cantidadModal").val();
        var precioTotal = precio * cantidadModal;
        $('#tablaProductosAgregados').append(
                '<tr>' +
                "<td><input class='codigo' type='hidden' name='codigo[]' value='" + codigo + "'>" + codigo + "</td>" +
                "<td class='ancho'><input class='descripcion' type='hidden' name='descripcion[]' value='" + descripcion + "'>" + descripcion + "</td>" +
                "<td><input class='precioLista' type='hidden' name='precioLista[]' value='" + precio + "'>" + formatoMoneda.format(precio) + "</td>" +
                "<td><input class='cantidad form-comtrol-sm' type='number' name='cantidad[]' min='1' max='5000' value='" + cantidadModal + "' onClick='datosCalculados($(this))' onkeyup='datosCalculados($(this))'></td>" +
                "<td class='valorTotal'>" + formatoMoneda.format(precioTotal) + "</td>" +
                '<td class="btnQuitarProducto text-center"><i class="fas fa-trash-alt"></i></td>' +
                "<td class='d-none precioTotalFila'>" + precioTotal + "</td>" +
                "<td class='d-none codigoPro'>" + codigo + "</td>" +
                "<td class='d-none cantidadSumar'>" + cantidadModal + "</td>" +
                '</tr>'
                );
        actualizar();
    });
    
    $(document).on('click', '.btnQuitarProducto', function () {
        $(this).closest('tr').remove();
        onload(1)
    });
    
    $('#formularioDatos').submit(function (e) {
        e.preventDefault();
        formData = new FormData(this);
        formData.append('accion', 'Registrar');
        formData.append('total', $.trim($('#valorFinal').text().replace('.', '').replace('$', '')));
        if (document.getElementById('tablaProductosAgregados').rows.length > 1) {
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
                        type: "POST",
                        url: "app/compras/comprasAcciones.php",
                        datatype: "json",
                        data: formData,
                        contentType: false,
                        cache: false,
                        processData: false,
                    }).done(function (datos) {
                        Swal.fire( 'Registrada!', 'Su orden a si guardada.', 'success' );
                        $("#formularioDatos").trigger("reset");
                        $("#tablaProductosAgregados > tbody").html("");
                        $("#valorFinal").html("");
                        var hoy = new Date();
                        var fecha = hoy.getFullYear() + '-' + (hoy.getMonth() + 1) + '-' + hoy.getDate();
                        var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
                        $("#fecha").val(fecha + ' ' + hora);
                    });
                }
            })
        } else {
            alert('No agregado ningun producto a la lista');
        }
    });

    $('#borrarDatosInput').click(function (e) {
        e.preventDefault();
        $('#nombres').val('');
        $('#listaUsuarios').fadeOut();
        vaciarDatos();
    });

    function onload(pagina) {
        if ($("#nit").val() !== '') {
            $.ajax({
                type: 'POST',
                url: "app/compras/comprasAcciones.php",
                data: {
                    accion: 'Productos',
                    pagina: pagina,
                    filtro: $('.searchFilter').val(),
                    registrosXPagina: $('#registrosXPagina').val(),
                    nit: $('#nit').val()
                },
                success: function (datos) {
                    if (datos != null) {
                        datos = datos.split('|');
                        $('#lista').fadeIn(2000).html(datos[0]);
                        document.getElementById("paginacion").innerHTML = datos[1];
                        bloquear();
                        actualizar();
                    }
                }
            });
        }
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
        var precioUnitario = fila.closest('tr').find(".precioLista").val();
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
                if (j === 6) valorFinal += parseInt(tabla.rows[i].cells[j].innerText);
                if (j === 7) $("#boton" + tabla.rows[i].cells[7].innerText).addClass('d-none');
                if (j === 8) cantidadProductos += parseInt(tabla.rows[i].cells[j].innerText);
            }
        }
        $("#valorFinal").text(formatoMoneda.format(valorFinal));
    }

    function vaciarDatos() {
        $("#datosBuscar").val('');
        $("#nit").val('');
        $("#nombres").val('');
        $("#apellidos").val('');
        $("#nombreComercial").val('');
        $("#celular").val('');
        $("#clave").val('');
    }
    
    $(document).on('click', '.imgProduct', function () {
        var codigo = $(this).closest('tr').find('td:eq(0)').text();
        var descripcion = $(this).closest('tr').find('td:eq(1)').text();
        $('#modal-image').text(descripcion + '(' + codigo + ')');
        $('#imagepreview').attr('src', $(this).attr('src')); // here asign the image to the modal when the user click the enlarge link
        $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
    });
</script>
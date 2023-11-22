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
?>
<div class="modal fade" id="modalCatalogo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Linea">Linea <span class="required-label">*</span></label>
                        <select class="custom-select d-block w-100" id="lineaCatalogo" placeholder="" name="lineaCatalogo" required></select>
                    </div>
                </div>               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark catalogo">Catalogo</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formulario">    
                <div class="modal-body">
                    <div class="modal-body">
                        <ul class="nav nav-tabs nav-line nav-color-secondary" role="tablist">
                            <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#general" role="tab" aria-selected="true">General</a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#purchaser" role="tab" aria-selected="false">Datos de compras</a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#sales" role="tab" aria-selected="false">Datos de ventas</a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#fotosProductos" role="tab" aria-selected="false">Fotos producto</a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#fichaTecnica" role="tab" aria-selected="false">Ficha tecnica</a> </li>
                        </ul>
                        <div class="tab-content mt-3">
                            <div class="tab-chat tab-pane fade show active" id="general" role="tabpanel">
                                <div class="form-group">
                                    <label for="Codigo">Codigo <span class="required-label">*</span></label>
                                    <input type="text" class="form-control" id="codigo" placeholder="" name="codigo"  value="" maxlength="12" required>
                                </div>
                                <div class="form-group">
                                    <label for="Descripcion">Descripcion <span class="required-label">*</span></label>
                                    <input type="text" class="form-control" id="descripcion" placeholder="" name="descripcion"  value="" maxlength="255" required>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="Marcas">Marcas <span class="required-label">*</span></label>
                                            <select class="custom-select d-block w-100" id="idMarca" placeholder="" name="idMarca" required></select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="Linea">Linea <span class="required-label">*</span></label>
                                            <select class="custom-select d-block w-100" id="idLinea" placeholder="" name="idLinea" onchange="cargarGrupo(this.value)" required></select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="Grupo">Grupo <span class="required-label">*</span></label>
                                            <select class="custom-select d-block w-100" id="idGrupo" placeholder="" name="idGrupo" required></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="codigoDeBarras">Codigo de barras </label>
                                            <input type="text" class="form-control" id="codigoDeBarras" placeholder="" name="codigoDeBarras"  value="">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="promocion">Promocion <span class="required-label">*</span></label>
                                            <select class="form-control" id="promocion" name="promocion">
                                                <option value="Y">Si</option>
                                                <option value="N">No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="tipoServicio">Tipo de servicio <span class="required-label">*</span></label>
                                            <select class="form-control" id="tipoServicio" name="tipoServicio">
                                                <option value="1">Belleza</option>
                                                <option value="2">Ferreteria</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="estado">Estado <span class="required-label">*</span></label>
                                    <select class="custom-select d-block w-100" id="estado" placeholder="" name="estado" required>
                                        <option value="Y">Activo</option>
                                        <option value="N">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="purchaser" role="tabpanel">
                                <div class="form-group">
                                    <label for="costo">Costo sin iva <span class="required-label">*</span></label>
                                    <input type="text" class="form-control" id="costo" placeholder="" name="costo" value="" required>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="idUnidadCompra">Unidad de empaque compra <span class="required-label">*</span></label>
                                            <select class="form-control" id="idUnidadCompra" name="idUnidadCompra"></select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="cantidadCompra">Cantidad de empaque compra <span class="required-label">*</span></label>
                                            <input type="number" class="form-control" id="cantidadCompra" name="cantidadCompra" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="idImpuesto">Impuesto <span class="required-label">*</span></label>
                                            <select class="form-control" id="idImpuesto" name="idImpuesto"></select>
                                        </div>
                                        <div class="col-md-12"><label class="text-center" for="">Proveedores</label></div>
                                        <div class="col-md-12" id="datosProveedor"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="sales" role="tabpanel">
                                <div class="form-group">
                                    <label for="costo">Costo con iva <span class="required-label">*</span></label>
                                    <input type="text" class="form-control" id="precio" placeholder="" name="precio" value="" maxlength="20" required>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="idUnidadCompra">Unidad de empaque venta <span class="required-label">*</span></label>
                                            <select class="form-control" id="idUnidadVenta" name="idUnidadVenta"></select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="cantidadCompra">Cantidad de empaque venta <span class="required-label">*</span></label>
                                            <input type="number" class="form-control" id="cantidadVenta" name="cantidadVenta" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="cantidadCompra">Cantidad de volumen venta <span class="required-label">*</span></label>
                                            <input type="number" class="form-control" id="cantidadVolumen" name="cantidadVolumen" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="fotosProductos" role="tabpanel">
                                <div class="form-group row justify-content-center">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <label>Foto</label>
                                        <div class="input-file input-file-image">
                                            <img class="img-upload-preview img-circle img-thumbnail" id="archivoFoto" width="100" height="100" src="imagenes/distribucionesOssa.jpg" alt="preview">
                                            <input type="file" class="form-control form-control-file" id="foto" name="foto" accept="image/*">
                                            <label for="foto" class="btn btn-primary btn-round btn-lg"><i class="fa fa-file-image"></i> Seleccione una imagen</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <label>Foto 1</label>
                                        <div class="input-file input-file-image">
                                            <img class="img-upload-preview img-circle img-thumbnail" id="archivoFoto1" width="100" height="100" src="imagenes/distribucionesOssa.jpg" alt="preview">
                                            <input type="file" class="form-control form-control-file" id="foto1" name="foto1" accept="image/*">
                                            <label for="foto1" class="btn btn-primary btn-round btn-lg"><i class="fa fa-file-image"></i> Seleccione una imagen</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <label>Foto 2</label>
                                        <div class="input-file input-file-image">
                                            <img class="img-upload-preview img-circle img-thumbnail" id="archivoFoto2" width="100" height="100" src="imagenes/distribucionesOssa.jpg" alt="preview">
                                            <input type="file" class="form-control form-control-file" id="foto2" name="foto2" accept="image/*">
                                            <label for="foto2" class="btn btn-primary btn-round btn-lg"><i class="fa fa-file-image"></i> Seleccione una imagen</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="fichaTecnica" role="tabpanel">
                                <div class="form-group">
                                    <textarea class="form-control" id="caracteristicas" name="caracteristicas" rows="15"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>               
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="accion" placeholder="" name="accion"  value="" required>
                    <input type="hidden" id="fotoAnterior" placeholder="" name="fotoAnterior"  value="" required>
                    <input type="hidden" id="codigoAnterior" placeholder="" name="codigoAnterior"  value="" required>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
                </div>
            </form>    
        </div>
    </div>
</div>

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Productos</h4>
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
                <a href="#">Productos</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Productos</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-table mr-1"></i>
                        Productos
                        <a class="btn btn-outline-primary btn-round ml-auto btnCatalogo">
                            Catalogo
                        </a>
                        <a href="app/productos/productos/notificacion.php" target="_blank" class="btn btn-outline-primary btn-round">
                            Notificacion
                        </a>
                        <button id="btnNuevo" type="button" class="btn btn-outline-primary btn-round ml-auto" data-toggle="modal">
                            Adicionar
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" id="tabla" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Gestion</th>
                                    <th>Codigo</th>
                                    <th>Producto</th>
                                    <th>Marca</th>
                                    <th>Grupo</th>
                                    <th>Linea</th>
                                    <th>Servicio</th>
                                    <th>Costo con iva</th>
                                    <th>Estado</th>
                                    <th>Foto</th>
                                </tr>
                            </thead>
                            <tbody id="lista">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var codigo, accion, descripcion, idCategoria;
    
    //filters
    $.ajax({
        type: "POST",
        url: "app/inventario/productos/productosAcciones.php",
        data: {accion: 'SelectUnidadEmpaque'},
        success: function (datos) {
            $('#idUnidadCompra').html(datos).fadeIn();
            $('#idUnidadVenta').html(datos).fadeIn();
        }
    });
    
    $.ajax({
        type: "POST",
        url: "app/inventario/productos/productosAcciones.php",
        data: {accion: 'SelectImpuesto'},
        success: function (datos) {
            $('#idImpuesto').html(datos).fadeIn();
        }
    });
    //filters
    
    $(document).ready(function () {
        tabla = $('#tabla').DataTable({
            "bDeferRender": true,
            "responsive": true,
            "stateSave": true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "app/inventario/productos/productosAcciones.php",
                "type": "POST",
                "data": { "accion": 'Listar' }
            },
            "columns": [
                {"data": "9",
                    "className": "d-md-none d-xs-block",
                    "defaultContent": ""
                },
                {"data": "10",
                    "targets": -1,
                    "defaultContent": "<a class='btnEditar'><img src='imagenes/ModificarP.png'></a><a class='btnBorrar'><img src='imagenes/EliminarP.png' title='Eliminar'></a>"
                },
                {"data": "0"},
                {"data": "1"},
                {"data": "2"},
                {"data": "3"},
                {"data": "4"},
                {"data": "5"},
                {"data": "6"},
                {"data": "7"},
                {"data": "8",
                    "render": function ( data, type, row ) {
                        return '<img class="mx-auto d-block" src="https://fotos.ossadistribuciones.com/' + row[8] + '" style="height: 60px; max-width: 200px">';
                    }
                }
            ],
            "pagingType": "full_numbers",
            "lengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
            "language": {
                "url": "presentacion/DistOssaPasto/json/Spanish.json"
            }
        });

        $('#formulario').submit(function (e) {
            e.preventDefault();
            formData = new FormData(this);
            formData.append('nitProveedor', JSON.stringify($('[name="nitProveedor[]"]').serializeArray()));
            $.ajax({
                url: "app/inventario/productos/productosAcciones.php",
                type: "POST",
                datatype: "json",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    tabla.ajax.reload( null, false );
                }
            });
            $('#modalCRUD').modal('hide');
        });
        
        $(".btnCatalogo").click(function () {
            cargarLinea();
            $(".modal-header").css("background-color", "#17a2b8");
            $(".modal-header").css("color", "white");
            $(".modal-title").text("ADICIONAR PRODUCTO");
            $('#modalCatalogo').modal('show');
        });
        
        $(".catalogo").click(function () {
            var nuevaVentana = window.open('app/inventario/productos/catalogo.php?idLinea=' + $('#lineaCatalogo').val(), "_blank");
            nuevaVentana.focus();
        });

        $("#btnNuevo").click(function () {
            cargarMarca();
            cargarLinea();
            cargarProveedor();
            $("#formulario").trigger("reset");
            $(".modal-header").css("background-color", "#17a2b8");
            $(".modal-header").css("color", "white");
            $(".modal-title").text("ADICIONAR PRODUCTO");
            $("#btnGuardar").text("Guardar");
            $("#accion").val("Adicionar");
            $('#modalCRUD').modal('show');
        });

        $(document).on("click", ".btnEditar", function () {
            codigo = $(this).closest("tr").find('td:eq(2)').text();
            $.ajax({
                url: "app/inventario/productos/productosAcciones.php",
                type: "POST",
                datatype: "json",
                data: {codigo: codigo, accion: 'Mostrar'},
                success: function (datos) {
                    datos = JSON.parse(datos); 
                    $("#caracteristicas").val(datos.caracteristicas);
                    $("#codigo").val(datos.codigo);
                    $("#codigoAnterior").val(datos.codigo);
                    $("#descripcion").val(datos.descripcion);
                    $("#idImpuesto").val(datos.idImpuesto);
                    $("#idUnidadCompra").val(datos.idUnidadCompra);
                    $("#cantidadCompra").val(datos.cantidadCompra);
                    $("#idUnidadVenta").val(datos.idUnidadVenta);
                    $("#cantidadVenta").val(datos.cantidadVenta);
                    $("#cantidadVolumen").val(datos.cantidadVolumen);
                    $("#codigoDeBarras").val(datos.codigoDeBarras);
                    $("#precio").val(datos.precio);
                    $("#costo").val(datos.costo);
                    $("#promocion").val(datos.promocion);
                    $("#tipoServicio").val(datos.tipoServicio);
                    $("#foto").val('');
                    $("#foto1").val('');
                    $("#foto2").val('');
                    $("#estado").val(datos.estado);
                    $("#archivoFoto").attr("src", "https://fotos.ossadistribuciones.com/" + datos.foto);
                    $("#archivoFoto1").attr("src", "https://fotos.ossadistribuciones.com/" + datos.foto1);
                    $("#archivoFoto2").attr("src", "https://fotos.ossadistribuciones.com/" + datos.foto2);
                    $("#caracteristicas").val(datos.caracteristicas);
                    $("#margenXVolumenMayorista").val(datos.margenXVolumenMayorista);
                    $("#margenXEmpaqueMayorista").val(datos.margenXEmpaqueMayorista);
                    $("#margenXTipoMayorista").val(datos.margenXTipoMayorista);
                    $("#margenXVolumenPeluqueria").val(datos.margenXVolumenPeluqueria);
                    $("#margenXEmpaquePeluqueria").val(datos.margenXEmpaquePeluqueria);
                    $("#margenXTipoPeluqueria").val(datos.margenXTipoPeluqueria);
                    $("#margenXVolumenPublico").val(datos.margenXVolumenPublico);
                    $("#margenXEmpaquePublico").val(datos.margenXEmpaquePublico);
                    $("#margenXTipoPublico").val(datos.margenXTipoPublico);
                    cargarLinea(datos.idLinea);
                    cargarGrupo(datos.idLinea, datos.idGrupo);
                    cargarMarca(datos.idMarca);
                    cargarProveedor(datos.codigo);
                    $(".modal-header").css("background-color", "#007bff");
                    $(".modal-header").css("color", "white");
                    $(".modal-title").text("MODIFICAR PRODUCTO");
                    $("#btnGuardar").text("Modificar");
                    $("#accion").val("Modificar");
                    $('#modalCRUD').modal('show');
                }
            });
        });

        $(document).on("keyup, change", "#precio, #idImpuesto", function () {
            var impuesto = $('#idImpuesto').val() === '1' ? 1.19 : 1;
            console.log(impuesto);
            $('#costo').val(Math.round($('#precio').val() / impuesto));
        });
        
        $(document).on("click", ".btnBorrar", function () {
            codigo = $(this).closest('tr').find('td:eq(2)').text();
            var respuesta = confirm("¿Esta seguro de borrar el registro " + codigo + "?");
            if (respuesta) {
                $.ajax({
                    url: "app/inventario/productos/productosAcciones.php",
                    type: "POST",
                    datatype: "json",
                    data: {accion: 'Eliminar', codigo: codigo},
                    success: function (datos) {
                        tabla.ajax.reload( null, false );
                    }
                });
            }
        });
    });
    
    function cargarProveedor(codigo = null) {
        $(document).ready(function () {
            $.ajax({
                type: "POST",
                url: "app/inventario/productos/productosAcciones.php",
                data: {predeterminado: codigo, accion: 'CheckboxProveedor'},
                success: function (datos) {
                    $('#datosProveedor').html(datos).fadeIn();
                }
            });
        });
    }

    function cargarMarca(idMarca = null) {
        $(document).ready(function () {
            $.ajax({
                type: "POST",
                url: "app/inventario/productos/productosAcciones.php",
                data: {predeterminado: idMarca, accion: 'SelectMarca'},
                success: function (datos) {
                    $('#idMarca').html(datos).fadeIn();
                }
            });
        });
    }

    function cargarLinea(idLinea = '') {
        $(document).ready(function () {
            $.ajax({
                type: "POST",
                url: "app/inventario/productos/productosAcciones.php",
                data: {predeterminado: idLinea, accion: 'SelectLinea'},
                success: function (datos) {
                    $('#idLinea').html(datos).fadeIn();
                    $('#lineaCatalogo').html(datos).fadeIn();
                    if (idLinea === '') cargarGrupo($('#idLinea').val());
                }
            });
        });
    }

    function cargarGrupo(idLinea = null, idGrupo = null) {
        $(document).ready(function () {
            $.ajax({
                type: "POST",
                url: "app/inventario/productos/productosAcciones.php",
                data: {
                    predeterminado: idGrupo,
                    idLinea: idLinea,
                    accion: 'SelectGrupo'
                },
                success: function (datos) {
                    $('#idGrupo').html(datos).fadeIn();
                }
            });
        });
    }
</script>
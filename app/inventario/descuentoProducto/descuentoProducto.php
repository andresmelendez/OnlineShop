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
                        <div class="form-group">
                            <label for="Tipo">Tipo</label>
                            <select type="text" class="form-control" id="tipo" placeholder="" name="tipo" required>
                                <option value="1">Mayorista</option>
                                <option value="2">Peluqueria</option>
                                <option value="3">Publico</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Grupo</label>
                            <input type="text" class="form-control" id="nombreGrupo" placeholder="" name="nombreGrupo" required>
                        </div>
                        <div class="form-group">
                            <label for="">Margenes</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="idUnidadCompra">Descuento X Volumen <span class="required-label">*</span></label>
                                    <input type="number" class="form-control" id="margenXVolumen" step="0.001" name="margenXVolumenPeluqueria" value="0">
                                </div>
                                <div class="col-md-4">
                                    <label for="cantidadCompra">Descuento X Empaque <span class="required-label">*</span></label>
                                    <input type="number" class="form-control" id="margenXEmpaque" step="0.001" name="margenXEmpaquePeluqueria" value="0" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="cantidadCompra">Margen X Tipo <span class="required-label">*</span></label>
                                    <input type="number" class="form-control" id="margenXTipo" step="0.001" name="margenXTipoPeluqueria" value="0" required>
                                </div>
                            </div>
                        </div>
                    </div>               
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
                </div>
            </form>    
        </div>
    </div>
</div>

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Descuentos</h4>
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
                <a href="#">Descuentos</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-table mr-1"></i>
                        Precios
                        <button id="btnNuevo" type="button" class="btn btn-outline-primary btn-round ml-auto" data-toggle="modal">
                            Adicionar
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group row justify-content-center">
                        <label class="col-md-2 col-form-label">
                            Grupo:
                        </label>
                        <div class="col-md-6">
                            <input class="form-control" id="grupoBuscar" name="grupoBuscar" valor="" placeholder="Buscar" autocomplete="off">
                                        
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" id="tabla" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Gestion</th>
                                    <th>id</th>
                                    <th>Tipo</th>
                                    <th>Grupo</th>
                                    <th>Descuento X Volumen</th>
                                    <th>Descuento X Empaque</th>
                                    <th>Margen X Tipo</th>
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
    var id, accion;

    $(document).ready(function () {
        tabla = $('#tabla').DataTable({
            "bDeferRender": true,
            "responsive": true,
            "stateSave": true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "app/inventario/descuentoProducto/descuentoProductoAcciones.php",
                "type": "POST",
                "data": { "accion": 'Listar' }
            },
            "columns": [
                {"data": "6",
                    "className": "d-md-none d-xs-block",
                    "defaultContent": ""
                },
                {"data": "7",
                    "targets": -1,
                    "defaultContent": "<a class='btnEditar'><img src='imagenes/ModificarP.png'></a><a class='btnBorrar'><img src='imagenes/EliminarP.png' title='Eliminar'></a>"
                },
                {"data": "0", "className": "d-none"},
                {"data": "1"},
                {"data": "2"},
                {"data": "3"},
                {"data": "4"},
                {"data": "5"},
            ],
            "pagingType": "full_numbers",
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "language": {
                "url": "presentacion/DistOssaPasto/json/Spanish.json"
            }
        });
        
        $(document).on("keyup", "#grupoBuscar", function (e) {
            e.preventDefault();
            if ($('#grupoBuscar').val() !== '') {
                tabla.column(4).search($('#grupoBuscar').val()).draw();
            } else {
                tabla.column(4).search("").draw();
            }
        });

        $('#formulario').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: "app/inventario/descuentoProducto/descuentoProductoAcciones.php",
                type: "POST",
                datatype: "json",
                data: {
                    id: id, 
                    tipo: $.trim($('#tipo').val()), 
                    nombreGrupo: $.trim($('#nombreGrupo').val()), 
                    margenXVolumen: $.trim($('#margenXVolumen').val()), 
                    margenXEmpaque: $.trim($('#margenXEmpaque').val()), 
                    margenXTipo: $.trim($('#margenXTipo').val()), 
                    accion: $('#btnGuardar').text()
                },
                success: function (data) {
                    console.log(data);
                    tabla.ajax.reload( null, false );
                }
            });
            $('#modalCRUD').modal('hide');
        });

        $("#btnNuevo").click(function () {
            accion = 'Adicionar';
            id = null;
            $("#formulario").trigger("reset");
            $(".modal-header").css("background-color", "#17a2b8");
            $(".modal-header").css("color", "white");
            $(".modal-title").text("ADICIONAR DESCUENTO");
            $("#btnGuardar").text("Adicionar");
            $('#modalCRUD').modal('show');
        });

        $(document).on("click", ".btnEditar", function () {
            accion = 'Modificar';
            id = $(this).closest("tr").find('td:eq(2)').text();
            $.ajax({
                url: "app/inventario/descuentoProducto/descuentoProductoAcciones.php",
                type: "POST",
                datatype: "json",
                data: {id: id, accion: 'Mostrar'},
                success: function (datos) {
                    datos = JSON.parse(datos);
                    $("#nombreGrupo").val(datos.nombreGrupo);
                    $("#margenXVolumen").val(datos.margenXVolumen);
                    $("#margenXEmpaque").val(datos.margenXEmpaque);
                    $("#margenXTipo").val(datos.margenXTipo);
                    $('#tipo option[value="' + datos.tipo + '"]').prop('selected', true);
                    $(".modal-header").css("background-color", "#007bff");
                    $(".modal-header").css("color", "white");
                    $(".modal-title").text("MODIFICAR DESCUENTO");
                    $("#btnGuardar").text("Modificar");
                    $('#modalCRUD').modal('show');
                }
            });
        });

        $(document).on("click", ".btnBorrar", function () {
            id = $(this).closest('tr').find('td:eq(2)').text();
            accion = 'Eliminar';
            var respuesta = confirm("¿Esta seguro de borrar el registro " + id + "?");
            if (respuesta) {
                $.ajax({
                    url: "app/inventario/descuentoProducto/descuentoProductoAcciones.php",
                    type: "POST",
                    datatype: "json",
                    data: {accion: accion, id: id},
                    success: function (datos) {
                        tabla.ajax.reload( null, false );
                    }
                });
            }
        });
    });
</script>
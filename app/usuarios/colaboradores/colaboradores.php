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
                            <label for="Ciudad">Perfil <span class="required-label">*</span></label>
                            <select class="form-control select2" id="idPerfil" name="idPerfil" required></select>
                        </div>
                        <div class="form-group">
                            <label for="identificacion">Identificacion <span class="required-label">*</span></label>
                            <input type="text" class="form-control" id="identificacion" placeholder="" name="identificacion"  value="" required>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="nombres">Nombres <span class="required-label">*</span></label>
                                    <input type="text" class="form-control" id="nombres" placeholder="" name="nombres"  value="" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="Apellidos">Apellidos <span class="required-label">*</span></label>
                                    <input type="text" class="form-control" id="apellidos" placeholder="" name="apellidos"  value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="Ciudad">Ciudad <span class="required-label">*</span></label>
                                    <select class="form-control select2" id="codigoCiudad" placeholder="" name="codigoCiudad"  value="" required></select>
                                </div>
                                <div class="col-md-6">
                                    <label for="clave">Clave <span class="required-label">*</span></label>
                                    <input type="password" class="form-control" id="clave" placeholder="" name="clave"  value="" required>
                                </div>
                            </div>
                        </div>
                    </div>               
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="identificacionAnterior" placeholder="" name="identificacionAnterior"  value="">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
                </div>
            </form>    
        </div>
    </div>
</div>

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Colaboradores</h4>
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
                <a href="#">Colaboradores</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-table mr-1"></i>
                        Colaboradores
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
                                    <th>Usuario</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Ciudad</th>
                                    <th>Perfil</th>
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
    var identificacion, accion;
    
    //filters
    $.ajax({
        type: "POST",
        url: "app/usuarios/colaboradores/colaboradoresAcciones.php",
        data: {accion: 'SelectCiudad'},
        success: function (datos) {
            $('#codigoCiudad').html(datos).fadeIn();
        }
    });
    
    $.ajax({
        type: "POST",
        url: "app/usuarios/colaboradores/colaboradoresAcciones.php",
        data: {accion: 'SelectPerfil'},
        success: function (datos) {
            $('#idPerfil').html(datos).fadeIn();
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
                "url": "app/usuarios/colaboradores/colaboradoresAcciones.php",
                "type": "POST",
                "data": { "accion": 'Listar' }
            },
            "columns": [
                {"data": "5",
                    "className": "d-md-none d-xs-block",
                    "defaultContent": ""
                },
                {"data": "6",
                    "targets": -1,
                    "defaultContent": "<a class='btnEditar'><img src='imagenes/ModificarP.png'></a><a class='btnBorrar'><img src='imagenes/EliminarP.png' title='Eliminar'></a>"
                },
                {"data": "0"},
                {"data": "1"},
                {"data": "2"},
                {"data": "3"},
                {"data": "4"}
            ],
            "pagingType": "full_numbers",
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "language": {
                "url": "presentacion/DistOssaPasto/json/Spanish.json"
            }
        });

        $('#formulario').submit(function (e) {
            e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la pagina
            $.ajax({
                url: "app/usuarios/colaboradores/colaboradoresAcciones.php",
                type: "POST",
                datatype: "json",
                data: {
                    identificacion: $('#identificacion').val(),
                    identificacionAnterior: $('#identificacionAnterior').val(),
                    nombres: $.trim($('#nombres').val()),
                    apellidos: $.trim($('#apellidos').val()),
                    codigoCiudad: $.trim($('#codigoCiudad').val()),
                    clave: $.trim($('#clave').val()),
                    perfil: $.trim($('#idPerfil').val()),
                    accion: $("#btnGuardar").text()
                },
                success: function (data) {
                    tabla.ajax.reload( null, false );
                }
            });
            $('#modalCRUD').modal('hide');
        });

        $("#btnNuevo").click(function () {
            $("#formulario").trigger("reset");
            $(".modal-header").css("background-color", "#17a2b8");
            $(".modal-header").css("color", "white");
            $(".modal-title").text("ADICIONAR VENDEDOR");
            $("#btnGuardar").text("Adicionar");
            $('#modalCRUD').modal('show');
        });

        $(document).on("click", ".btnEditar", function () {
            identificacion = $(this).closest("tr").find('td:eq(2)').text(); //capturo el ID
            $.ajax({
                url: "app/usuarios/colaboradores/colaboradoresAcciones.php",
                type: "POST",
                datatype: "json",
                data: {accion: 'Mostrar', identificacion: identificacion},
                success: function (datos) {
                    datos = JSON.parse(datos); 
                    $("#identificacion").val(datos.identificacion);
                    $("#identificacionAnterior").val(datos.identificacion);
                    $("#nombres").val(datos.nombres);
                    $("#apellidos").val(datos.apellidos);
                    $("#clave").val(datos.clave);
                    $("#codigoCiudad").val(datos.codigoCiudad);
                    $("#idPerfil").val(datos.perfil);
                    $(".modal-header").css("background-color", "#007bff");
                    $(".modal-header").css("color", "white");
                    $(".modal-title").text("MODIFICAR VENDEDOR");
                    $("#btnGuardar").text("Modificar");
                    $('#modalCRUD').modal('show');
                }
            });
        });

        $(document).on("click", ".btnBorrar", function () {
            identificacion = $(this).closest('tr').find('td:eq(2)').text();
            var respuesta = confirm("¿Esta seguro de borrar el registro " + identificacion + "?");
            if (respuesta) {
                $.ajax({
                    url: "app/usuarios/colaboradores/colaboradoresAcciones.php",
                    type: "POST",
                    datatype: "json",
                    data: {accion: 'Eliminar', identificacion: identificacion},
                    success: function (datos) {
                        tabla.ajax.reload( null, false );
                    }
                });
            }
        });
    });
</script>
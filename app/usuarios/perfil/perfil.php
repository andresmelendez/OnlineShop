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
?>
<div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
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
                            <label for="Nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" placeholder="" name="nombre"  value="" required>
                        </div>
                        <div class="form-group">
                            <label for="siglas">Descripcion</label>
                            <input type="text" class="form-control" id="descripcion" placeholder="" name="descripcion"  value="" required>
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

<div class="modal fade" id="modalPermisos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formularioPermissions">    
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped text-center" id="tablaPermissions" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Permisos</th>
                                        <th>Opcion</th>
                                    </tr>
                                </thead>
                                <tbody id="permissions"></tbody>
                            </table>
                        </div>
                    </div>               
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark">Accesos</button>
                </div>
            </form>    
        </div>
    </div>
</div>

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Perfil</h4>
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
                <a href="#">Usuarios</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Perfil</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-table mr-1"></i>
                        Perfil
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
                                    <th>id</th>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var id, accion, nombre, descripcion;

        tabla = $('#tabla').DataTable({
            "bDeferRender": true,
            "stateSave": true,
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "lengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
            "ajax": {
                "url": "app/usuarios/perfil/perfilAcciones.php",
                "type": "POST",
                "data": { "accion": 'Listar' }
            },
            "columns": [
                { "data": "3" ,
                    "className": "d-md-none d-xs-block",
                    "defaultContent": ""
                },
                { "data": "4" ,
                    "targets": -1,
                    "defaultContent": "<a class='btnEditar'><img src='imagenes/ModificarP.png'></a><a class='btnBorrar'><img src='imagenes/EliminarP.png' title='Eliminar'></a>"
                },
                { "data": "0", className: "d-none" },
                { "data": "1" },
                { "data": "2" }
            ],
            "language": {
                "url": "presentacion/DistOssaPasto/json/Spanish.json"
            }
        });

        $('#formulario').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: "app/usuarios/perfil/perfilAcciones.php",
                type: "POST",
                data: {
                    id: id, 
                    nombre: $.trim($('#nombre').val()), 
                    descripcion: $.trim($('#descripcion').val()), 
                    accion: $('#btnGuardar').text()
                }
            }).done(function () {
                tabla.ajax.reload(null, false);
                $('#modalCRUD').modal('hide');
            });
        });

        $("#btnNuevo").click(function () {
            id = null;
            $("#formulario").trigger("reset");
            $(".modal-header").css("background-color", "#17a2b8");
            $(".modal-header").css("color", "white");
            $(".modal-title").text("ADICIONAR PERFIL");
            $("#btnGuardar").text("Adicionar");
            $('#modalCRUD').modal('show');
        });

        $(document).on("click", ".btnEditar", function () {
            id = $(this).closest("tr").find('td:eq(2)').text();
            nombre = $(this).closest("tr").find('td:eq(3)').text();
            descripcion = $(this).closest("tr").find('td:eq(4)').text();
            $("#nombre").val(nombre);
            $("#descripcion").val(descripcion);
            $(".modal-header").css("background-color", "#007bff");
            $(".modal-header").css("color", "white");
            $(".modal-title").text("MODIFICAR PERFIL");
            $("#btnGuardar").text("Modificar");
            $('#modalCRUD').modal('show');
        });

        $(document).on("click", ".btnBorrar", function () {
            id = $(this).closest('tr').find('td:eq(2)').text();
            accion = 'Eliminar';
            var respuesta = confirm("¿Esta seguro de borrar el registro " + id + "?");
            if (respuesta) {
                $.ajax({
                    url: "app/usuarios/perfil/perfilAcciones.php",
                    type: "POST",
                    datatype: "json",
                    data: {accion: accion, id: id},
                    success: function (datos) {
                        tabla.ajax.reload();
                    }
                });
            }
        });
    });
</script>
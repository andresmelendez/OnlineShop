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
                            <input type="text" class="form-control" id="nombre" placeholder="" name="nombre"  value="" maxlength="50" required>
                        </div>
                        <div class="form-group">
                            <label for="Linea">Linea</label>
                            <select class="custom-select d-block w-100" id="idLinea" placeholder="" name="idLinea" required></select>
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
        <h4 class="page-title">Grupos</h4>
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
                <a href="#">Configuracion</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Grupos</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-table mr-1"></i>
                        Grupos
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
                                    <th>Gestion</th>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Linea</th>
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
    var id, accion, nombre, idLinea;
    var fila;

    $(document).ready(function () {
        tabla = $('#tabla').DataTable({
            "bDeferRender": true,
            "responsive": true,
            "stateSave": true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "app/configuracion/grupo/grupoAcciones.php",
                "type": "POST",
                "data": {"accion": 'Listar'}
            },
            "columns": [
                {"data": "3",
                    "targets": -1,
                    "defaultContent": "<a class='btnEditar'><img src='imagenes/ModificarP.png'></a><a class='btnBorrar'><img src='imagenes/EliminarP.png' title='Eliminar'></a>"
                },
                {"data": "0", "className": "d-none"},
                {"data": "1"},
                {"data": "2"}
            ],
            "pagingType": "full_numbers",
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "language": {
                "url": "presentacion/DistOssaPasto/json/Spanish.json"
            }
        });

        $('#formulario').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: "app/configuracion/grupo/grupoAcciones.php",
                type: "POST",
                datatype: "json",
                data: {
                    id: id, 
                    nombre: $.trim($('#nombre').val()), 
                    idLinea: $.trim($('#idLinea').val()), 
                    accion: $('#btnGuardar').text()
                },
                success: function (data) {
                    tabla.ajax.reload( null, false );
                }
            });
            $('#modalCRUD').modal('hide');
        });

        $("#btnNuevo").click(function () {
            accion = 'Adicionar'; //alta           
            id = null;
            $("#formulario").trigger("reset");
            $(".modal-header").css("background-color", "#17a2b8");
            $(".modal-header").css("color", "white");
            $(".modal-title").text("ADICIONAR GRUPO");
            $("#btnGuardar").text("Adicionar");
            $('#modalCRUD').modal('show');
        });

        $(document).on("click", ".btnEditar", function () {
            accion = 'Modificar';
            id = $(this).closest("tr").find('td:eq(1)').text();
            $.ajax({
                url: "app/configuracion/grupo/grupoAcciones.php",
                type: "POST",
                datatype: "json",
                data: {id: id, accion: 'Mostrar'},
                success: function (datos) {
                    datos = JSON.parse(datos); 
                    $("#nombre").val(datos.nombre);
                    $("#idLinea").val(datos.idLinea);
                    $(".modal-header").css("background-color", "#007bff");
                    $(".modal-header").css("color", "white");
                    $(".modal-title").text("MODIFICAR GRUPO");
                    $("#btnGuardar").text("Modificar");
                    $('#modalCRUD').modal('show');
                }
            });
        });

        $(document).on("click", ".btnBorrar", function () {
            id = $(this).closest('tr').find('td:eq(1)').text();
            accion = 'Eliminar';
            var respuesta = confirm("¿Esta seguro de borrar el registro " + id + "?");
            if (respuesta) {
                $.ajax({
                    url: "app/configuracion/grupo/grupoAcciones.php",
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
    
    //filtros
    
    $.ajax({
        type: "POST",
        url: "app/configuracion/grupo/grupoAcciones.php?accion=SelectLinea",
        data: {accion: 'SelectLinea'},
        success: function (datos) {
            $('#idLinea').html(datos).fadeIn();
        }
    });
    
    //filtros
</script>
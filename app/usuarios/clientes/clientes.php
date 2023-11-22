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
                            <label for="nit">Identificacion / Nit <span class="required-label">*</span></label>
                            <input type="text" class="form-control" id="nit" placeholder="" name="nit"  value="" required>
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
                            <label for="razonSocial">Nombre comercial</label>
                            <input type="text" class="form-control" id="nombreComercial" placeholder="" name="nombreComercial"  value="">
                        </div>
                        <div class="form-group">
                            <label for="celular">Celular</label>
                            <input type="text" class="form-control" id="celular" placeholder="" name="celular"  value="">
                        </div>
                        <div class="form-group">
                            <label for="email">Correo electronico <span class="required-label">*</span></label>
                            <input type="email" class="form-control" id="email" placeholder="" name="email"  value="" required>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="Ciudad">Ciudad <span class="required-label">*</span></label>
                                    <select class="form-control select2" id="codigoCiudad" placeholder="" name="codigoCiudad"  value="" required></select>
                                </div>
                                <div class="col-md-4">
                                    <label for="Barrio">Barrio <span class="required-label">*</span></label>
                                    <input type="text" class="form-control" id="barrio" placeholder="" name="barrio"  value="" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="direccion">Direccion <span class="required-label">*</span></label>
                                    <input type="text" class="form-control" id="direccion" placeholder="" name="direccion"  value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="tipoNegocio">Tipo de negocio <span class="required-label">*</span></label>
                                    <input type="text" class="form-control" id="tipoNegocio" placeholder="" name="tipoNegocio"  value="" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="Barrio">Tipo de precios <span class="required-label">*</span></label>
                                    <select type="text" class="form-control" id="tipoPrecios" placeholder="" name="tipoPrecios" required>
                                        <option value="1">Mayorista</option>
                                        <option value="2">Peluqueria</option>
                                        <option value="3">Publico</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="clave">Clave <span class="required-label">*</span></label>
                                    <input type="password" class="form-control" id="clave" placeholder="" name="clave"  value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cupo">Cupo <span class="required-label">*</span></label>
                            <input type="number" class="form-control" id="cupo" placeholder="" name="cupo"  value="">
                        </div>
                    </div>               
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="nitAnterior" placeholder="" name="nitAnterior"  value="">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
                </div>
            </form>    
        </div>
    </div>
</div>

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Clientes</h4>
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
                <a href="#">Clientes</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-table mr-1"></i>
                        Clientes
                        <button id="btnNuevo" type="button" class="btn btn-outline-primary btn-round ml-auto" data-toggle="modal">
                            Adicionar
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped text-truncate" id="tabla" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Gestion</th>
                                    <th>Usuario</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Nombre comercial</th>
                                    <th>Celular</th>
                                    <th>Tipo precios</th>
                                    <th>Tipo de negocio</th>
                                    <th>Ciudad</th>
                                    <th>Barrio</th>
                                    <th>Direccion</th>
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
    var nit, accion;
    
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

    $(document).ready(function () {
        tabla = $('#tabla').DataTable({
            "bDeferRender": true,
            "responsive": true,
            "stateSave": true,
            "processing": true,
            "serverSide": true,
            "order": [[ 7, "desc" ]],
            "ajax": {
                "url": "app/usuarios/clientes/clientesAcciones.php",
                "type": "POST",
                "data": { "accion": 'Listar' }
            },
            "columns": [
                {"data": "10",
                    "defaultContent": ""
                },
                {"data": "11",
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
                {"data": "8"},
                {"data": "9"}
            ],
            "createdRow": function( row, data, dataIndex ) {        
                if ( data[5] === "Sin clasificar" ) {      
                    $(row).addClass('bg-success text-light');
                }         
            },
            "pagingType": "full_numbers",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            "language": {
                "url": "presentacion/DistOssaPasto/json/Spanish.json"
            }
        });

        $('#formulario').submit(function (e) {
            e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la pagina
            $.ajax({
                url: "app/usuarios/clientes/clientesAcciones.php",
                type: "POST",
                datatype: "json",
                data: {
                    nit: $('#nit').val(),
                    nitAnterior: $('#nitAnterior').val(),
                    nombres: $.trim($('#nombres').val()),
                    apellidos: $.trim($('#apellidos').val()),
                    nombreComercial: $.trim($('#nombreComercial').val()),
                    celular: $.trim($('#celular').val()),
                    email: $.trim($('#email').val()),
                    direccion: $.trim($('#direccion').val()),
                    barrio: $.trim($('#barrio').val()),
                    codigoCiudad: $.trim($('#codigoCiudad').val()),
                    clave: $.trim($('#clave').val()),
                    tipoNegocio: $.trim($('#tipoNegocio').val()),
                    tipoPrecios: $.trim($('#tipoPrecios').val()),
                    cupo: $.trim($('#cupo').val()),
                    accion: $("#btnGuardar").text()
                },
                success: function (data) {
                    tabla.ajax.reload( null, false );
                }
            });
            $('#modalCRUD').modal('hide');
        });

        $("#btnNuevo").click(function () {
            accion = 'Adicionar'; //alta           
            $(".modal-header").css("background-color", "#17a2b8");
            $(".modal-header").css("color", "white");
            $(".modal-title").text("ADICIONAR CLIENTE");
            $("#btnGuardar").text("Adicionar");
            $('#modalCRUD').modal('show');
            $('#codigoCiudad option[value="' + 52001 + '"]').prop('selected', true);
        });

        $(document).on("click", ".btnEditar", function () {
            nit = $(this).closest("tr").find('td:eq(2)').text(); //capturo el ID
            $.ajax({
                url: "app/usuarios/clientes/clientesAcciones.php",
                type: "POST",
                datatype: "json",
                data: {nit: nit, accion: 'Mostrar'},
                success: function (datos) {
                    datos = JSON.parse(datos); 
                    $("#nit").val(datos.nit);
                    $("#nitAnterior").val(datos.nit);
                    $("#nombres").val(datos.nombres);
                    $("#apellidos").val(datos.apellidos);
                    $("#nombreComercial").val(datos.nombreComercial);
                    $("#celular").val(datos.celular);
                    $("#email").val(datos.email);
                    $("#barrio").val(datos.barrio);
                    $("#direccion").val(datos.direccion);
                    $("#tipoNegocio").val(datos.tipoNegocios);
                    $('#codigoCiudad option[value="' + datos.codigoCiudad + '"]').prop('selected', true);
                    $("#clave").val(datos.clave);
                    $("#cupo").val(datos.cupo);
                    $(".modal-header").css("background-color", "#007bff");
                    $(".modal-header").css("color", "white");
                    $(".modal-title").text("MODIFICAR CLIENTE");
                    $("#btnGuardar").text("Modificar");
                    $('#modalCRUD').modal('show');
                }
            });
        });

        $(document).on("click", ".btnBorrar", function () {
            nit = parseInt($(this).closest('tr').find('td:eq(2)').text());
            var respuesta = confirm("¿Esta seguro de borrar el registro " + nit + "?");
            if (respuesta) {
                $.ajax({
                    url: "app/usuarios/clientes/clientesAcciones.php",
                    type: "POST",
                    datatype: "json",
                    data: {accion: 'Eliminar', nit: nit},
                    success: function (datos) {
                        tabla.ajax.reload( null, false );
                    }
                });
            }
        });
    });
</script>
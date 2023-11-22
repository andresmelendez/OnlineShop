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
                            <label for="Nombre">Articulo</label>
                            <input type="text" class="form-control" id="descripcion" placeholder="" name="descripcion"  value="" maxlength="50" readonly>
                        </div>
                        <div class="form-group">
                            <label for="Nombre">Codigo</label>
                            <input type="text" class="form-control" id="codigoProducto" placeholder="" name="codigoProducto"  value="" maxlength="50">
                        </div>
                        <div class="form-group">
                            <label for="Nombre">Stock</label>
                            <input type="text" class="form-control" id="stock" placeholder="" name="stock"  value="" maxlength="50" >
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
                            <label for="Nombre">Articulo</label>
                            <input type="text" class="form-control" id="descripcion" placeholder="" name="descripcion"  value="" maxlength="50" readonly>
                        </div>
                        <div class="form-group">
                            <label for="Nombre">Codigo</label>
                            <input type="text" class="form-control" id="codigoProducto" placeholder="" name="codigoProducto"  value="" maxlength="50">
                        </div>
                        <div class="form-group">
                            <label for="Nombre">Stock</label>
                            <input type="text" class="form-control" id="stock" placeholder="" name="stock"  value="" maxlength="50" >
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
        <h4 class="page-title">Inventario</h4>
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
                <a href="#">Inventario</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Inventario</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-table mr-1"></i>
                        Inventario Productos
                    </div>
                </div>
                <div class="card-body">
                    <form id="motorDeBusqueda">
                        <div class="form-group row justify-content-center">
                            <div class="col-md-6">
                                <ul class="list-group list-group-bordered list">
                                    <div class="nav-item dropdown">
                                        <div class="input-group">
                                            <input class="form-control" id="productoBuscar" name="productoBuscar" valor="" placeholder="Buscar" autocomplete="off">
                                            <div class="input-group-append" id="borrarDatosInputProducto">
                                                <span class="input-group-text text-danger"><i class="fas fa-times-circle"></i></span>
                                            </div>
                                        </div>
                                        <div id="listaProductos">
                                        </div>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" id="tabla" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Codigo producto</th>
                                    <th>Descripcion</th>
                                    <th>Pedido OC</th>
                                    <th>Comprometido</th>
                                    <th>Stock</th>
                                    <th>Disponible</th>
                                    <th>Gestion</th>
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
    var id, accion, nombre;

    $(document).ready(function () {
        tabla = $('#tabla').DataTable({
            "bDeferRender": true,
            "stateSave": true,
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "lengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
            "ajax": {
                "url": "app/inventario/inventario/inventarioAcciones.php",
                "type": "POST",
                "data": { "accion": 'Listar' }
            },
            "columns": [
                {"data": "0", "className" : 'd-none'},
                {"data": "1"},
                {"data": "2"},
                {"data": "3"},
                {"data": "4"},
                {"data": "5"},
                {"data": "6"},
                {"data": "7",
                    "targets": -1,
                    "defaultContent": "<a class='btnEditar'><img src='imagenes/ModificarP.png'></a>"
                },
            ],
            "language": {
                "url": "presentacion/DistOssaPasto/json/Spanish.json"
            }
        });

        $(document).on("keyup", "#productoBuscar", function (e) {
            e.preventDefault();
            tabla.column(2).search($('#productoBuscar').val()).draw();
        });
        
        $('#borrarDatosInputProducto').click(function (e) {
            e.preventDefault();
            $('#productoBuscar').val('');
            tabla.column(2).search("").draw();
        });
        
        $('#formulario').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: "app/inventario/inventario/inventarioAcciones.php",
                type: "POST",
                datatype: "json",
                data: {
                    id: id, 
                    stock: $('#stock').val(), 
                    codigoProducto: $('#codigoProducto').val(), 
                    accion: 'Modificar'
                },
                success: function (data) {
                    tabla.ajax.reload( null, false );
                }
            });
            $('#modalCRUD').modal('hide');
        });
        
        $(document).on("click", ".btnEditar", function () {
            accion = 'Modificar';
            id = $(this).closest("tr").find('td:eq(0)').text();
            codigo = $(this).closest("tr").find('td:eq(1)').text();
            nombre = $(this).closest("tr").find('td:eq(2)').text();
            stock = $(this).closest("tr").find('td:eq(5)').text();
            $("#descripcion").val(nombre);
            $("#codigoProducto").val(codigo);
            $("#stock").val(stock);
            $(".modal-header").css("background-color", "#007bff");
            $(".modal-header").css("color", "white");
            $(".modal-title").text("MODIFICAR LINEA");
            $("#btnGuardar").text("Modificar");
            $('#modalCRUD').modal('show');
        });
    });
</script>
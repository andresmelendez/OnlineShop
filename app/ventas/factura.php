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
<script src="librerias/jspdf/dist/jspdf.min.js"></script>
<script src="librerias/jspdf/jspdf.plugin.autotable.js"></script>
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Facturas</h4>
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
                <a href="#">Facturas</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Facturas</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-table mr-1"></i>
                        Facturas
                        <a href="principal.php?CONTENIDO=app/ventas/facturaFormulario.php" type="button" class="btn btn-outline-primary btn-round ml-auto">
                            Adicionar
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="motorDeBusqueda">
                        <div class="form-group">
                            <div class="card mt-4">
                                <h5 class="card-header text-center">
                                    <a data-toggle="collapse" href="#collapse-example" aria-expanded="true" aria-controls="collapse-example" id="heading-example" class="d-block">
                                        <i class="fa fa-chevron-down pull-right"></i>
                                        MOTOR DE BUSQUEDA
                                    </a>
                                </h5>
                                <div id="collapse-example" class="collapse" aria-labelledby="heading-example">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label">
                                                <input class="form-check-label" type="checkbox" name="cIdentificacionCliente" id="cIdentificacionCliente">Cliente:
                                            </label>
                                            <div class="col-md-5">
                                                <ul class="list-group list-group-bordered list">
                                                    <div class="nav-item dropdown">
                                                        <div class="input-group">
                                                            <input class="form-control" id="nombres" name="nombres" identificacionCliente="" placeholder="Nombre del cliente" autocomplete="off">
                                                            <div class="input-group-append" id="borrarDatosInput">
                                                                <span class="input-group-text text-danger"><i class="fas fa-times-circle"></i></span>
                                                            </div>
                                                        </div>
                                                        <div id="listaClientes">
                                                        </div>
                                                    </div>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label">
                                                <input class="form-check-label" type="checkbox" name="cEstado" id="cEstado">Estado:
                                            </label>
                                            <div class="col-md-5">
                                                <select class="form-control" id="estadoBuscar" name="estadoBuscar">
                                                    <option value="Pendiente">Pendiente</option>
                                                    <option value="Orden de compra">Orden de compra</option>
                                                    <option value="Cancelado">Cancelado</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex align-items-center justify-content-center">
                                            <input type="submit" name="buscar" id="buscar" class="btn btn-outline-primary btn-round" value="Consultar">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="form-group d-flex align-items-center justify-content-center mx-2" id="exportar">
                        <button name="pdf" id="pdf" class="btn btn-outline-danger mx-2"><i class="fas fa-file-pdf fa-2x"></i></button>
                        <button name="word" id="word" class="btn btn-outline-primary mx-2"><i class="fas fa-file-word fa-2x"></i></button>
                        <button name="excel" id="excel" class="btn btn-outline-success mx-2"><i class="fas fa-file-excel fa-2x"></i></button>
                    </div>

                    <div class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                        <div class="table-responsive">
                            <table class="table table-hover text-truncate" id="tabla" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Estado</th>
                                        <th>Informacion</th>
                                        <th>Codigo</th>
                                        <th>Total</th>
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
</div>
<script type="text/javascript">
    var codigo, accion;

    $(document).ready(function () {
        tabla = $('#tabla').DataTable({
            "bDeferRender": true,
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "order": [[0, "desc"], [2, "desc"]],
            "ajax": {
                "url": "app/ventas/facturaAcciones.php",
                "type": "POST",
                "data": { "accion": 'Listar' }
            },
            "columns": [
                {"data": "10",
                    "render": function (data, type, row) {
                        var clase = row[10] == 'Pendiente' ? 'badge-primary' : row[10] == 'Orden de compra' ? 'badge-success' : 'badge-danger';
                        return '<span class="badge ' + clase + '">' + row[10] + '</span>';
                    }
                },
                {"data": "1",
                    "render": function (data, type, row) {
                        var fechaFac = row[4] != null ? row[4] : '';
                        var Fac = row[2] != null ? row[2] : '';
                        var barrio = row[12] != null ? row[12] : '';
                        var ciudad = row[13] != null ? row[13] : '';
                        var direccion = row[11] + ' ' + barrio + ' ' + ciudad;
                        return '<h6>Cliente: ' + row[1] + '</h6>' + '<h6>Vendedor: ' + Fac + '</h6>' + '<h6>Fecha documento: ' + row[3] + '</h6>';
                    }
                },
                {"data": "0",
                    "render": function (data, type, row) {
                        return '<h6 class="small">' + row[0] + '</h6>';
                    }
                },
                {"data": "7",
                    "render": function (data, type, row) {
                        return '<h6>Subtotal: ' + row[7] + '</h6>';
                    }
                },
                {"data": null,
                    "className": "text-center",
                    "render": function (data, type, row) {
                        var detalle = "<a target='_blank' href='app/pedidos/pedidosPdf.php?codigoPedido=" + row[0] + "' class='btnDetalle'><img src='imagenes/facturaDetalle.png'></a>";
                        var entregar = "<a class='btnEntregar'><img src='imagenes/pedidos.png'></a>";
                        var eliminar = "<a class='ml-4 btnAnular'><img src='imagenes/anularFactura.png' title='Eliminar'></a>";
                        return row[10] == 'Pendiente' ? entregar + eliminar : row[10] == 'Orden de compra' ? detalle + eliminar : detalle + eliminar;
                    }
                },
            ],
            stateLoadParams: function (settings, data) {
                if (data.order) delete data.order;
            },
            "pagingType": "full_numbers",
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "language": {
                "url": "presentacion/DistOssaPasto/json/Spanish.json"
            }
        });

        $(document).on("click", "#buscar", function (e) {
            e.preventDefault();
            var cIdentificacionCliente = document.getElementById('cIdentificacionCliente').checked;
            var cEstado = document.getElementById('cEstado').checked;
            if (cIdentificacionCliente) {
                tabla.column(1).search($('#nombres').val()).draw();
            } else {
                tabla.column(1).search("").draw();
            }
            if (cEstado) {
                tabla.column(0).search($('#estadoBuscar').val()).draw();
            } else {
                tabla.column(0).search("").draw();
            }
        });
        
        $('#nombres').on('keyup', function () {
            $.ajax({
                type: "POST",
                url: "app/ventas/facturaAcciones.php",
                data: {cliente: $('#nombres').val(), accion: 'Cliente'}
            }).done(function (datos) {
                if ($('#nombres').val() !== '') {
                    $('#listaClientes').fadeIn(1000).html(datos);
                    $('.dropdown-item').on('click', function () {
                        $('#nombres').val($('#' + $(this).attr('id')).attr('data'));
                        $('#nombres').attr("identificacionCliente", $(this).attr('id'));
                        $('#listaClientes').fadeOut();
                    });
                } else {
                    $('#listaClientes').fadeOut();
                    $('#nombres').attr("identificacionCliente", '');
                }
            });
        });
    });

    $('#exportar button').click(function (e) {
        e.preventDefault();
        switch ($(this).attr('id')) {
            case 'word':
                exportarWordExcel('word');
                break;
            case 'excel':
                exportarWordExcel('excel');
                break;
            case 'pdf':
                exportarPdf();
                break;
        }
    });

    function exportarPdf() {
        var pdf = new jsPDF("l", "pt");
        pdf.text("GESTION DE PEDIDOS", 230, 25);

        var resultado = pdf.autoTableHtmlToJson(document.getElementById("tabla"));
        pdf.autoTable(resultado.columns, resultado.data, {margin: {top: 40}});

        pdf.save("Reporte.pdf");

    }


    function exportarWordExcel(tipo) {
        var contenidoTabla = document.getElementById('tabla');
        var tabla = contenidoTabla.outerHTML.replace(/ /g, '%20');
        var descarga;
        var nombreArchivo = "";
        var contenido = "";
        var nombre = "";
        switch (tipo) {
            case 'word':
                contenido = 'application/msword';
                nombreArchivo = 'doc';
                break;
            case 'excel':
                contenido = 'application/vnd.ms-excel';
                nombreArchivo = 'xls';
                break;
        }
        nombre = nombre ? nombre + '.' + nombreArchivo : 'Reporte.' + nombreArchivo;
        descarga = document.createElement("a");
        document.body.appendChild(descarga);
        if (navigator.msSaveOrOpenBlob) {
            var blob = new Blob(['\ufeff', tabla], {
                type: contenido
            });
            navigator.msSaveOrOpenBlob(blob, nombre);
        } else {
            descarga.href = 'data:' + contenido + ', ' + tabla;
            descarga.download = nombre;
            descarga.click();
        }
    }

    $('#borrarDatosInput').click(function (e) {
        e.preventDefault();
        $('#nombres').val('');
        $('#listaClientes').fadeOut();
    });
</script>
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
                <a href="#">Compras</a>
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
                        <a href="principal.php?CONTENIDO=app/compras/comprasFormulario.php" type="button" class="btn btn-outline-primary btn-round ml-auto">
                            Adicionar
                        </a>
                    </div>
                </div>
                <div class="card-body">
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
                                        <th>Codigo</th>
                                        <th>Proveedor</th>
                                        <th>Fecha solicitado</th>
                                        <th>Fecha entregado</th>
                                        <th>Total Solicitado</th>
                                        <th>Total Recibido</th>
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
            "order": [[0, "desc"], [1, "desc"]],
            "ajax": {
                "url": "app/compras/comprasAcciones.php",
                "type": "POST",
                "data": { "accion": 'Listar' }
            },
            "columns": [
                {"data": "4",
                    "render": function (data, type, row) {
                        var clase = row[4] == 'Solicitado' ? 'badge-primary' : row[4] == 'Orden de compra' ? 'badge-success' : 'badge-danger';
                        return '<span class="badge ' + clase + '">' + row[4] + '</span>';
                    }
                },
                {"data": "0"},
                {"data": "1"},
                {"data": "2"},
                {"data": "3"},
                {"data": "5"},
                {"data": "6"},
                {"data": null,
                    "className": "text-center",
                    "render": function (data, type, row) {
                        var detalleSolicitado = "<a class='ml-4' target='_blank' href='app/compras/comprasPdf.php?tipo=solicitado&codigoCompras=" + row[0] + "' class='btnDetalle'><img src='imagenes/list.png'></a>";
                        var detalleRecibido = "<a class='ml-4' target='_blank' href='app/compras/comprasPdf.php?tipo=recibido&codigoCompras=" + row[0] + "' class='btnDetalle'><img src='imagenes/facturaDetalle.png'></a>";
                        var entregar = "<a class='btnEntregar'><img src='imagenes/pedidos.png'></a>";
                        var eliminar = "<a class='ml-4 btnAnular'><img src='imagenes/anularFactura.png' title='Eliminar'></a>";
                        var regresar = "<a class='ml-4 btnRegresar'><img src='imagenes/anularFactura.png' title='Regresar a pendiente'></a>";
                        return row[4] == 'Solicitado' ? entregar + eliminar : row[4] == 'Orden de compra' ? detalleSolicitado + detalleRecibido + regresar : detalleSolicitado + detalleRecibido;
                    }
                },
            ],
            stateLoadParams: function (settings, data) {
                if (data.order) delete data.order;
            },
            "pagingType": "full_numbers",
            "lengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
            "language": {
                "url": "presentacion/DistOssaPasto/json/Spanish.json"
            }
        });

        $(document).on("click", ".btnAnular", function () {
            codigo = $(this).closest('tr').find('td:eq(1)').text();
            var respuesta = confirm("¿Esta seguro de anular el pedido " + codigo + "?");
            if (respuesta) {
                $.ajax({
                    url: "app/compras/comprasAcciones.php",
                    type: "POST",
                    datatype: "json",
                    data: {accion: 'Anular', codigo: codigo},
                    success: function (datos) {
                        tabla.ajax.reload(null, false);
                    }
                });
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

        $(document).on("click", ".btnEntregar", function () {
            codigo = $(this).closest('tr').find('td:eq(1)').text();
            Swal.fire({
                text: "¿La solicitud la va a  pasar a orden de compra?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'NO',
                confirmButtonText: 'SI'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = 'principal.php?CONTENIDO=app/compras/comprasEntrega.php&codigoCompras=' + codigo;
                } else {
                    window.open('app/compras/comprasPdf.php?tipo=solicitado&codigoCompras=' + codigo, '_blank');
                }
            });
        });
        
        $(document).on("click", ".btnRegresar", function () {
            codigo = $(this).closest('tr').find('td:eq(1)').text();
            Swal.fire({
                text: "¿La solicitud la va a  pasar a orden de compra de nuevo a pendiente?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'NO',
                confirmButtonText: 'SI'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "app/compras/comprasAcciones.php",
                        type: "POST",
                        data: { accion: 'Regresar', codigo: codigo },
                        success: function (datos) {
                            console.log(datos);
                            alert('Accion exitosa');
                            tabla.ajax.reload(null, false);
                        }
                    });
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
        pdf.text("GESTION DE COMPRAS", 230, 25);

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
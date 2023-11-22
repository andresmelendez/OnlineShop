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
                                        <th>Codigo</th>
                                        <th>Descripcion</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody id="lista">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" style="text-align:right">Total:</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
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
            "ordering": false,
            "bDeferRender": true,
            "processing": true,
            "serverSide": true,
            "paging": false,
            "ajax": {
                "url": "app/ventas/facturaAcciones.php",
                "type": "POST",
                "data": { "accion": 'Ventas' }
            },
            "columns": [
                {"data": "0"},
                {"data": "1"},
                {"data": "2"},
                {"data": "3"},
                {"data": "4"},
            ],
            footerCallback: function (row, data, start, end, display) {
                var api = this.api();

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
                };

                // Total over all pages
                total = api
                    .column(4)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total over this page
                pageTotal = api
                    .column(4, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                $(api.column(4).footer()).html('<h4 class="font-weight-bold">$' + pageTotal + '</h4>');
            },
            stateLoadParams: function (settings, data) {
                if (data.order) delete data.order;
            },
            "pagingType": "full_numbers",
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "language": {
                "url": "presentacion/DistOssaPasto/json/Spanish.json"
            }
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
</script>
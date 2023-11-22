<?php
require_once './clasesGenericas/ConectorBD.php';
require_once './clases/app/Producto.php';
require_once './clases/app/Usuarios.php';
require_once './clases/app/Factura.php';

$lista = '';
session_start();
if (isset($_SESSION['usuario'])) {
    $myOrders = Factura::getLista("nitCliente = '{$_SESSION['usuario']->getNit()}'", 'fechaHoraDocumento desc');
    if ($myOrders != null) {
        for ($i = 0; $i < count($myOrders); $i++) {
            $myOrder = $myOrders[$i];
            $lista .= '<div class="col-12">';
            $lista .= '<div class="order">';
            $lista .= '<div class="row align-items-center">';
            $lista .= '<div class="col-lg-4">';
            $lista .= "<h3 class='order-number'>Orden {$myOrder['codigo']}</h3>";
            $lista .= "<a href='#!' class='action eyebrow underline' orderCode='{$myOrder['codigo']}' data-toggle='modal' data-target='#exampleModal-1'>Mirar orden</a>";
            $lista .= '</div>';
            $lista .= '<div class="col-lg-4">';
            $lista .= "<span>{$myOrder['fechaHoraDocumento']}</span>";
            $lista .= '</div>';
            $lista .= '<div class="col-lg-4">';
            $lista .= "<span class='order-status sent'>{$myOrder['estadoPedido']}</span>";
            $lista .= '</div>';
            $lista .= '</div>';
            $lista .= '</div>';
            $lista .= '</div>';
        }
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">

        <title>Ossa Distribuciones</title>
        <link rel="icon" href="imagenes/distribucionesOssa.jpg" type="image/x-icon"/>

        <link rel="stylesheet" href="presentacion/DistOssaPasto/css/vendor.css" />
        <link rel="stylesheet" href="presentacion/DistOssaPasto/css/style.css" />

        <style>
            .imgLineas{
                height: 238px;
                max-width: 100%
            }
        </style>
    </head>
    <body>

        <header class="header header-dark header-sticky">
            <?php require_once './extensiones/headerPrincipal.php'; ?>
        </header>

        <!-- hero -->
        <section class="hero hero-small bg-purple text-white">
            <div class="container">
                <div class="row gutter-2 gutter-md-4 align-items-end">
                    <div class="col-md-6 text-center text-md-left">
                        <h1 class="mb-0">Mis pedidos</h1>
                    </div>
                    <div class="col-md-6 text-center text-md-right">
                        <a href="#!" class="btn btn-sm btn-outline-white">Cerrar sesion</a>
                    </div>
                </div>
            </div>
        </section>



        <!-- listing -->
        <section class="pt-5">
            <div class="container">
                <div class="row gutter-4 justify-content-between">


                    <!-- sidebar -->
                    <aside class="col-lg-3">
                        <div class="nav nav-pills flex-column lavalamp" id="sidebar-1" role="tablist">
                            <a class="nav-link active" data-toggle="tab" href="#sidebar-1-2" role="tab" aria-controls="sidebar-1-2" aria-selected="true">Pedidos</a>
                        </div>
                    </aside>
                    <!-- / sidebar -->

                    <!-- content -->
                    <div class="col-lg-9">
                        <div class="modal fade" id="exampleModal-1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Orden</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <td>Articulo</td>
                                                        <td>Cantidad</td>
                                                        <td>Precio</td>
                                                    </tr>
                                                </thead>
                                                <tbody id="dataTable">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="container-fluid">
                                            <div class="row gutter-0">
                                                <div class="col">
                                                    <button type="button" class="btn btn-block btn-secondary" data-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="tab-content" id="myTabContent">

                                    <!-- orders -->
                                    <div class="tab-pane fade show active" id="sidebar-1-2" role="tabpanel" aria-labelledby="sidebar-1-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <h3 class="mb-0">Pedidos</h3>
                                            </div>
                                        </div>
                                        <div class="row gutter-2" id="misPedidos">
                                            <?= $lista ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / content -->

                </div>
            </div>
        </section>
        <!-- listing -->



        <footer class="bg-dark text-white py-0">
            <?php require_once './extensiones/footerPrincipal.php'; ?>
        </footer>

        <?php require_once './extensiones/modals.php'; ?>
        <?php require_once './extensiones/menuMovil.php'; ?>

        <script src="presentacion/DistOssaPasto/js/vendor.min.js"></script>
        <script src="presentacion/DistOssaPasto/js/app.js"></script>
        <script src="presentacion/DistOssaPasto/js/main.js?v6"></script>
        <script>
            $(document).on('click', '.underline', function () {
                $.ajax({
                    type: "POST",
                    url: "funciones/funciones.php",
                    data: {accion: 'MirarPedidos', codigo: $(this).attr("orderCode")}
                }).done(function (datos) {
                    $('#dataTable').html(datos);
                });
            });
        </script>
    </body>
</html>
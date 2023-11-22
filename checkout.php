<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once './clasesGenericas/ConectorBD.php';
require_once './clases/app/Producto.php';
require_once './clases/app/Usuarios.php';
require_once './clases/app/Ciudad.php';

session_start();
$lista = '';
$cliente = '';
$envio = 0;
$totalPedido = 0;
$totalPedidoSinDescuento = 0;
$numProductos = 0;
$numItems = 0;
if (isset($_SESSION["carrito"])) {
    foreach ($_SESSION["carrito"] as $indice => $arreglo) {
        $total = $arreglo['precio'] * $arreglo['cantidad'];
        $totalPedido += $total;
        $totalPedidoSinDescuento += $arreglo['precioLista'] * $arreglo['cantidad'];
        $lista .= '<li class="list-group-item d-flex justify-content-between text-dark align-items-center">';
        $lista .= $arreglo['descripcion'];
        $lista .='<span>$&nbsp;' . number_format($total, 0, ',', '.') . '</span>';
        $lista .= '</li>';
        $lista .= '<li class="mb-2">';
        $lista .="<small>Cantidad: {$arreglo['cantidad']}</small>";
        $lista .= '</li>';
        $numProductos += $arreglo['cantidad'];
        $numItems++;
    }
}

if (isset($_SESSION['usuario'])) {
    $cliente = new Usuarios($_SESSION['usuario']->getNit());
    if($totalPedido <= 50000) $envio = 4000;
    else if($totalPedido >= 50001 && $totalPedido <= 100000) $envio = 3000;
    else if($totalPedido >= 100001 && $totalPedido <= 150000) $envio = 2000;
    else if($totalPedido >= 150001 && $totalPedido <= 180000) $envio = 1000;
} else {
    $cliente = new Usuarios(null);
    if($totalPedido <= 30000) $envio = 4000;
    else if($totalPedido >= 30001 && $totalPedido <= 50000) $envio = 3000;
    else if($totalPedido >= 50001 && $totalPedido <= 80000) $envio = 2000;
    else if($totalPedido >= 80001 && $totalPedido <= 100000) $envio = 1000;
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

    </head>
    <body>

        <header class="header header-dark bg-dark header-sticky">
            <?php require_once './extensiones/headerPrincipal.php'; ?>
        </header>

        <section class="breadcrumbs separator-bottom">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                                <li class="breadcrumb-item"><a href="listing.php">Tienda</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Verificar</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col text-center">
                        <h1>Verificar</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="no-overflow pt-0">
            <div class="container">
                <div class="row gutter-4 justify-content-between">
                    <div class="col-lg-8">
                        <div class="row align-items-end mb-2">
                            <div class="col-md-6">
                                <h2 class="h3 mb-0"><span class="text-muted">01.</span> Informacion</h2>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <a class="eyebrow unedrline action" href="listing.php">Seguir comprando</a>
                            </div>
                        </div>
                        <div class="row gutter-1 mb-6">
                            <div class="form-group col-md-6">
                                <label for="firstName">Nombres</label>
                                <input type="text" class="form-control" id="nombres" name="nombres" placeholder="" value="<?= $cliente->getNombres() ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="lastName">Apellidos</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="" value="<?= $cliente->getApellidos() ?>" required>
                            </div>
                            <div class="form-group col">
                                <label for="Identificacion">Identificacion</label>
                                <input type="text" class="form-control" id="identificacion" name="identificacion" placeholder="" value="<?= $cliente->getNit() ?>" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Direccion">Direccion</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="" value="<?= $cliente->getDireccion() ?>" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Celular">Ciudad</label>
                                <select class="form-control" name="ciudad" id="ciudad"><?= strtoupper(Ciudad::getListaEnOptions(null, 'nombre', '52001')) ?></select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Celular">Celular</label>
                                <input type="text" class="form-control" id="celular" name="celular" placeholder="" value="<?= $cliente->getCelular() ?>">
                            </div>
                        </div>
                        <div class="row align-items-end mb-2">
                            <div class="col-md-6">
                                <h2 class="h3 mb-0"><span class="text-muted">02.</span> Observaciones</h2>
                            </div>
                        </div>
                        <div class="row gutter-1">
                            <div class="col-md-12">
                                <div class="custom-control custom-choice">
                                    <textarea class="form-control" id="observacion" name="observacion" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>


                    <aside class="col-lg-4">
                        <div class="row">

                            <div class="col-12">
                                <div class="card card-data bg-light">
                                    <div class="card-header py-2 px-3">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h3 class="fs-18 mb-0">Carrito</h3>
                                            </div>
                                            <div class="col text-right">
                                                <a href="cart.php" class="underline eyebrow">Editar</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-line">
                                            <?= $lista ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-1">
                                <div class="card card-data bg-light">
                                    <div class="card-header py-2 px-3">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h3 class="fs-18 mb-0">Resumen de la orden</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-minimal">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Total sin descuento
                                                <span>$&nbsp;<?= number_format($totalPedidoSinDescuento, 0, ',', '.') ?></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Numero de productos
                                                <span id="numProduct"><?= $numProductos ?></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Numero de items
                                                <span id="numItems"><?= $numItems ?></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <a href="listing.php" class="text-primary action underline">Seguir comprando</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-footer py-2">
                                        <ul class="list-group list-group-minimal">
                                            <li class="list-group-item d-flex justify-content-between align-items-center text-dark fs-18">
                                                Total
                                                <span id="sales" sales="<?= $totalPedido ?>">$&nbsp;<?= number_format($totalPedido, 0, ',', '.') ?></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center text-dark fs-18">
                                                Envio
                                                <span freight="<?= $envio ?>" id="envio">$&nbsp;<?= number_format($envio, 0, ',', '.') ?></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center text-dark fs-18">
                                                Total + Envio
                                                <span>$&nbsp;<?= number_format($totalPedido + $envio, 0, ',', '.') ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-1">
                                <button type="button" class="btn btn-primary btn-lg btn-block actionOrder" >Enviar pedido</button>
                            </div>

                        </div>
                    </aside>

                </div>
            </div>
        </section>


        <footer class="bg-dark text-white py-0">
            <?php //require_once './extensiones/footerPrincipal.php'; ?>
        </footer>

        <?php require_once './extensiones/modals.php'; ?>
        <?php require_once './extensiones/menuMovil.php'; ?>

        <script src="presentacion/DistOssaPasto/js/vendor.min.js"></script>
        <script src="presentacion/DistOssaPasto/js/app.js"></script>
        <script src="presentacion/DistOssaPasto/js/main.js?v6"></script>
    </body>
</html>
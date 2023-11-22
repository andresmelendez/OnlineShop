<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once './clasesGenericas/ConectorBD.php';
require_once './clases/app/Producto.php';
require_once './clases/app/Usuarios.php';

session_start();
$lista = '';
$envio = 0;
$totalPedido = 0;
$totalPedidoSinDescuento = 0;
if (isset($_SESSION["carrito"])) {
    foreach ($_SESSION["carrito"] as $indice => $arreglo) {
        $total = $arreglo['precio'] * $arreglo['cantidad'];
        $totalPedido += $total;
        $totalPedidoSinDescuento += $arreglo['precioLista'] * $arreglo['cantidad'];
        $lista .= '<div class="cart-item">';
        $lista .= '<div class="row justify-content-center align-items-center">';
        $lista .= '<div class="col-12 col-lg-3">';
        $lista .= '<div class="media media-product">';
        $lista .= "<a href='#!'><img src='https://fotos.ossadistribuciones.com/{$arreglo['imagen']}' alt='Image'></a>";
        $lista .= '<div class="media-body bg-warning">';
        $lista .= "<h5 class='media-title'>{$arreglo['descripcion']}</h5>";
        $lista .= '</div>';
        $lista .= '</div>';
        $lista .= '</div>';
        $lista .= '<div class="col-12 col-lg-2 text-center">';
        $lista .= "<span class='d-sm-block d-md-none'>Precio: </span><span class='cart-item-price'>$ {$arreglo['precioLista']}</span>";
        $lista .= '</div>';
        $lista .= '<div class="col-12 col-lg-1 text-center">';
        $lista .= "<span class='d-sm-block d-md-none'>Descuento por caja: </span><span class='cart-item-price'>{$arreglo['descuento']}%</span>";
        $lista .= '</div>';
        $lista .= '<div class="col-12 col-lg-2 text-center">';
        $lista .= "<span class='d-sm-block d-md-none'>Precio con descuento adicional: </span><span class='cart-item-price'>$ {$arreglo['precio']}</span>";
        $lista .= '</div>';
        $lista .= '<div class="col-12 col-lg-2 text-center">';
        $lista .= '<span class="d-sm-block d-md-none">Cantidad: </span><div class="counter">';
        $lista .= "<span class='counter-minus icon-minus' field='qty-{$arreglo['codigo']}'></span>";
        $lista .= "<input type='number' name='qty-{$arreglo['codigo']}' class='counter-value' value='{$arreglo['cantidad']}' min='1' max='10' sku='{$arreglo['codigo']}' price='{$arreglo['precio']}'>";
        $lista .= "<span class='counter-plus icon-plus' field='qty-{$arreglo['codigo']}'></span>";
        $lista .= '</div>';
        $lista .= '</div>';
        $lista .= '<div class="col-12 col-lg-2 text-center">';
        $lista .= '<span class="d-sm-block d-md-none">Precio Total: </span><span class="cart-item-price total">$ ' . number_format($total, 0, ',', '.') . '</span>';
        $lista .= '</div>';
        $lista .= "<a href='#!' class='cart-item-close'><i class='icon-x'></i></a>";
        $lista .= '</div>';
        $lista .= '</div>';
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

        <title>Carrito</title>

        <link rel="icon" href="imagenes/distribucionesOssa.jpg" type="image/x-icon"/>

        <link rel="stylesheet" href="presentacion/DistOssaPasto/css/vendor.css" />
        <link rel="stylesheet" href="presentacion/DistOssaPasto/css/style.css" />
        
        <meta name="google" content="notranslate">

    </head>
    <body>

        <header class="header header-dark bg-dark header-sticky">
            <?php require_once './extensiones/headerPrincipal.php'; ?>
        </header>

        <section class="hero">
            <div class="container">
                <div class="row">
                    <div class="col text-center">
                        <h1>Su Carrito</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="pt-2 mx-lg-5">
            <div class="container-fluid">
                <div class="row mb-1 d-none d-lg-flex">
                    <div class="col-lg-8">
                        <div class="row pr-6">
                            <div class="col-lg-3"><span class="eyebrow">Producto</span></div>
                            <div class="col-lg-2 text-center h5"><span class="eyebrow">Precio</span></div>
                            <div class="col-lg-1 text-center h5"><span class="eyebrow">Descuento por caja</span></div>
                            <div class="col-lg-2 text-center h5"><span class="eyebrow">Precio con descuento adicional</span></div>
                            <div class="col-lg-2 text-center h5"><span class="eyebrow">Cantidad</span></div>
                            <div class="col-lg-2 text-center h5"><span class="eyebrow">Total</span></div>
                        </div>
                    </div>
                </div>
                <div class="row gutter-2 gutter-lg-4 justify-content-end">

                    <div class="col-lg-8 cart-item-list">

                        <?= $lista ?>
                    </div>

                    <div class="col-lg-4">
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
                                        <a href="listing.php" class="badge bg-warning text-dark action underline"><h3>Seguir comprando</h3></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-footer py-2">
                                <ul class="list-group list-group-minimal">
                                    <li class="list-group-item d-flex justify-content-between align-items-center text-dark fs-18">
                                        Total
                                        <span id="sales">$&nbsp;<?= number_format($totalPedido, 0, ',', '.') ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center text-dark fs-18">
                                        Envio
                                        <span freight="<?= $envio ?>" id="envio">$&nbsp;<?= number_format($envio, 0, ',', '.') ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <a href="checkout.php" class="btn btn-lg btn-primary btn-block mt-1">Siguiente</a>
                    </div>

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
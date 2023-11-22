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
        
        <div class="swiper-container d-none d-lg-block d-xl-block d-md-block">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="image image-overlay image-zoom" style="background-image:url(imagenes/distribucionesOssa.jpg)"></div>
                    <div class="container">
                        <div class="row align-items-end vh-100">
                            <div class="col-lg-12" data-swiper-parallax-x="-100%">
                                <h1 class="display-4 mt-1 mb-3 font-weight-bold text-dark">Con los pies en la tierra, pero con la mirada al cielo.</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="image image-overlay image-zoom" style="background-image:url(imagenes/fondo.jpg)"></div>
                    <div class="container">
                        <div class="row align-items-center vh-100">
                            <div class="col-lg-12" data-swiper-parallax-x="-100%">
                                <h1 class="display-2 mt-1 mb-3 font-weight-light text-light">Ossa <b class="d-block">Distribuiones</b></h1>
                                <h1 class="display-4 mt-1 mb-3 font-weight-bold text-light">Con los pies en la tierra, pero con la mirada al cielo.</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-footer">
                <div class="container">
                    <div class="row align-items-center mb-5">
                        <div class="col-lg-6">
                            <div class="swiper-pagination"></div>
                        </div>
                        <div class="col-lg-6 text-right">
                            <div class="swiper-navigation">
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container mt-5 d-block d-lg-none d-xl-none d-md-none">
            <div class="row">
                <div class="col-md-12">
                    <img class="img-fluid mt-5" src="imagenes/distribucionesOssa.jpg">
                </div>
            </div>
        </div>

        <!-- latest products -->
        <section class="pt-1">
            <div class="container">
                <div class="row gutter-1 align-items-end">
                    <div class="col-md-6">
                        <h2>Lineas</h2>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <ul class="nav nav-tabs lavalamp" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Lineas</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel">
                                <div class="row justify-content-center gutter-2 gutter-md-3">

                                    <div class="col-6 col-lg-4">
                                        <div class="product">
                                            <figure class="product-image">
                                                <a href="listing.php?linea=5">
                                                    <img class="mx-auto d-block imgLineas" src="imagenes/lineas/limpieza-facial-min.jpg" alt="Image">
                                                </a>
                                            </figure>
                                            <div class="product-meta">
                                                <h3 class="product-title"><a href="listing.php?linea=5">Facial</a></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-4">
                                        <div class="product">
                                            <figure class="product-image">
                                                <a href="listing.php?linea=1">
                                                    <img class="mx-auto d-block imgLineas" src="imagenes/lineas/accesorios.jpg" alt="Image">
                                                </a>
                                            </figure>
                                            <div class="product-meta">
                                                <h3 class="product-title"><a href="listing.php?linea=1">Accesorios</a></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-4">
                                        <div class="product">
                                            <figure class="product-image">
                                                <a href="listing.php?linea=2">
                                                    <img class="mx-auto d-block imgLineas" src="imagenes/lineas/capilar.jpeg" alt="Image">
                                                </a>
                                            </figure>
                                            <div class="product-meta">
                                                <h3 class="product-title"><a href="listing.php?linea=2">Capilar</a></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-4">
                                        <div class="product">
                                            <figure class="product-image">
                                                <a href="listing.php?linea=4">
                                                    <img class="mx-auto d-block imgLineas" src="imagenes/lineas/corporal.jpg" alt="Image">
                                                </a>
                                            </figure>
                                            <div class="product-meta">
                                                <h3 class="product-title"><a href="listing.php?linea=4">Corporal</a></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-4">
                                        <div class="product">
                                            <figure class="product-image">
                                                <a href="listing.php?linea=6">
                                                    <img class="mx-auto d-block imgLineas" src="imagenes/lineas/hombre.jpg" alt="Image">
                                                </a>
                                            </figure>
                                            <div class="product-meta">
                                                <h3 class="product-title"><a href="listing.php?linea=6">Hombre</a></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-4">
                                        <div class="product">
                                            <figure class="product-image">
                                                <a href="listing.php?linea=7">
                                                    <img class="mx-auto d-block imgLineas" src="imagenes/lineas/manicura.jfif" alt="Image">
                                                </a>
                                            </figure>
                                            <div class="product-meta">
                                                <h3 class="product-title"><a href="listing.php?linea=7">Manicura</a></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-4">
                                        <div class="product">
                                            <figure class="product-image">
                                                <a href="listing.php?linea=9">
                                                    <img class="mx-auto d-block imgLineas" src="imagenes/lineas/peluqueria.jpg" alt="Image">
                                                </a>
                                            </figure>
                                            <div class="product-meta">
                                                <h3 class="product-title"><a href="listing.php?linea=9">Peluqueria</a></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-4">
                                        <div class="product">
                                            <figure class="product-image">
                                                <a href="listing.php?linea=3">
                                                    <img class="mx-auto d-block imgLineas" src="imagenes/lineas/nuevo.jpg" alt="Image">
                                                </a>
                                            </figure>
                                            <div class="product-meta">
                                                <h3 class="product-title"><a href="listing.php?linea=3">Nuevos</a></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-4">
                                        <div class="product">
                                            <figure class="product-image">
                                                <a href="listing.php?linea=8">
                                                    <img class="mx-auto d-block imgLineas" src="imagenes/lineas/otros.png" alt="Image">
                                                </a>
                                            </figure>
                                            <div class="product-meta">
                                                <h3 class="product-title"><a href="listing.php?linea=8">Otros</a></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="bg-dark text-white py-0">
            <?php require_once './extensiones/footerPrincipal.php'; ?>
        </footer>

        <?php require_once './extensiones/modals.php'; ?>
        <?php require_once './extensiones/menuMovil.php'; ?>

        <script src="presentacion/DistOssaPasto/js/vendor.min.js"></script>
        <script src="presentacion/DistOssaPasto/js/app.js"></script>
        <script src="presentacion/DistOssaPasto/js/main.js"></script>
    </body>
</html>
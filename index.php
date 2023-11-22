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
            
        </header>

        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="image image-zoom" style="background-image:url(imagenes/distribucionesOssa.jpg)"></div>
                    <div class="container d-none d-lg-block d-xl-block d-md-block">
                        <div class="row align-items-center justify-content-center vh-100 d-flex flex-nowrap">
                            <div class="col-lg-2" data-swiper-parallax-x="-100%">
                                <a href="login" class="btn btn-dark btn-rounded text-light h3">Soy Cliente Mayorista</a>
                            </div>
                            <div class="col-lg-2" data-swiper-parallax-x="-100%">
                                <a href="listing" class="btn btn-dark btn-rounded text-light">Soy Cliente Final</a>
                            </div>
                        </div>
                    </div>
                    <div class="container d-block d-lg-none d-xl-none d-md-none mt-5">
                        <div class="row align-items-center justify-content-center d-flex flex-nowrap">
                            <div class="col-lg-2" data-swiper-parallax-x="-100%">
                                <a href="login" class="btn btn-dark btn-rounded text-light h4">Soy Cliente Mayorista</a>
                            </div>
                            <div class="col-lg-2" data-swiper-parallax-x="-100%">
                                <a href="listing" class="btn btn-dark btn-rounded text-light h4">Soy Cliente Final</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-footer">
                <div class="container d-none d-lg-block d-xl-block d-md-block">
                    <div class="row align-items-center mb-5">
                        <div class="col-lg-6">
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

        <!-- latest products -->
        <!-- categories -->
        <section class="pt-1">
            <div class="container-fluid">
                <h3 class="text-center">LINEAS</h3>
                <div class="row masonry gutter-1">
                    <div class="col-md-4">
                        <a href="#" class="card card-equal equal-50 equal-md-100 card-scale">
                            <span class="image image-overlay" style="background-image: url(imagenes/lineas/limpieza-facial-min.jpg)"></span>
                            <div class="card-body text-center text-white">
                                <h3>Facial</h3>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="#" class="card card-equal equal-50 equal-md-100 card-scale">
                            <span class="image image-overlay" style="background-image: url(imagenes/lineas/accesorios.jpg)"></span>
                            <div class="card-body text-center text-white">
                                <h3>Accesorios</h3>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="#" class="card card-equal equal-50 equal-md-100 card-scale">
                            <span class="image image-overlay" style="background-image: url(imagenes/lineas/capilar.jpeg)"></span>
                            <div class="card-body text-center text-white">
                                <h3>Capilar</h3>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="#" class="card card-equal equal-50 equal-md-100 card-scale">
                            <span class="image image-overlay" style="background-image: url(imagenes/lineas/corporal.jpg)"></span>
                            <div class="card-body text-center text-white">
                                <h3>Corporal</h3>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="#" class="card card-equal equal-50 equal-md-100 card-scale">
                            <span class="image image-overlay" style="background-image: url(imagenes/lineas/hombre.jpg)"></span>
                            <div class="card-body text-center text-white">
                                <h3>Hombre</h3>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="#" class="card card-equal equal-50 equal-md-100 card-scale">
                            <span class="image image-overlay" style="background-image: url(imagenes/lineas/manicura.jfif)"></span>
                            <div class="card-body text-center text-white">
                                <h3>Manicura</h3>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="#" class="card card-equal equal-50 equal-md-100 card-scale">
                            <span class="image image-overlay" style="background-image: url(imagenes/lineas/peluqueria.jpg)"></span>
                            <div class="card-body text-center text-white">
                                <h3>Peluqueria</h3>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="#" class="card card-equal equal-50 equal-md-100 card-scale">
                            <span class="image image-overlay" style="background-image: url(imagenes/lineas/nuevo.jpg)"></span>
                            <div class="card-body text-center text-white">
                                <h3>Nuevos</h3>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="#" class="card card-equal equal-50 equal-md-100 card-scale">
                            <span class="image image-overlay" style="background-image: url(imagenes/lineas/otros.png)"></span>
                            <div class="card-body text-center text-white">
                                <h3>Otros</h3>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <footer class="bg-dark text-white py-0">
            <?php require_once './extensiones/footerPrincipal.php'; ?>
        </footer>


        <script src="presentacion/DistOssaPasto/js/vendor.min.js"></script>
        <script src="presentacion/DistOssaPasto/js/app.js"></script>
        <script src="presentacion/DistOssaPasto/js/main.js"></script>
    </body>
</html>
<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../../clasesGenericas/ConectorBD.php';
require_once '../../../clases/app/Producto.php';

$lista = '';
$idLinea = isset($_GET['idLinea']) ? $_GET['idLinea'] : '';
$objeto = Producto::getPreciosVentas("precio > 0 AND idLinea=$idLinea AND tipo = '1'", "CASE WHEN idLinea = '3' THEN 1 WHEN idLinea = '7' THEN 2 WHEN idLinea = '2' THEN 3 WHEN idLinea = '4' THEN 4 WHEN idLinea = '5' THEN 5 WHEN idLinea = '9' THEN 6 WHEN idLinea = '6' THEN 7 WHEN idLinea = '1' THEN 8 WHEN idLinea = '8' THEN 9 END, idGrupo, descripcion");
if ($objeto != null) {
    $lista .= '<div class="col-lg-12">';
    $lista .= '<div class="row justify-content-center">';
    for ($i = 0; $i < count($objeto); $i++) {
        $objetos = $objeto[$i];
        $lista .= '<div class="col-lg-4 col-md-4 mb-4">';
        $lista .= '<div class="card h-100">';
        $lista .= "<a href='#!'><span class='badge bg-dark text-white position-absolute' style='top: 0.5rem; right: 0.5rem'></span><img class='img-fluid mx-auto d-block imgCatalogo' src='https://fotos.ossadistribuciones.com/{$objetos['foto']}' alt='...'/></a>";
        $lista .= '<div class="card-body">';
        //$lista .= '<h5>' . number_format($objetos['precio'], 0, ',', '.') . '</h5>';
        $lista .= "<p class='card-text' style='height: 80px'>{$objetos['descripcion']} <br> Cod: {$objetos['codigo']}</p>";
        $lista .= '</div>';
        $lista .= '</div>';
        $lista .= '</div>';
    }
    $lista .= '</div>';
    $lista .= '</div>';
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sistema DistOssaPasto</title>
        <link rel="icon" href="../../../imagenes/distribucionesOssa.jpg" type="image/x-icon"/>

        <script src="../../../presentacion/DistOssaPasto/js/webfont.min.js"></script>
        <script src="../../../presentacion/DistOssaPasto/js/jquery-3.5.1.min.js"></script>
        <script>
            WebFont.load({
                google: {"families": ["Lato:300,400,700,900"]},
                custom: {"families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../../../presentacion/DistOssaPasto/css/fonts.min.css']},
                active: function () {
                    sessionStorage.fonts = true;
                }
            });
        </script>
        <link rel="stylesheet" href="../../../presentacion/DistOssaPasto/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../../presentacion/DistOssaPasto/css/index.css">
        <style>
            .imgCatalogo {
                height: 239.75px; 
                max-width: 100%;
            }
        </style>
    </head>
    <body onload="window.print()">
<!--        <div class="row justify-content-center align-content-center">
            <div class="col-lg-12">
                <img class="mx-auto d-block" src="../../../imagenes/PORTADACATALOGOOSSA.jpg" style="height: 1520px; max-width: 900px; margin-bottom: 2.6rem !important">
            </div>
        </div>-->
        <section class="bg-light text-center">
            <div class="container my-2">
                <div class="row" id="lista">
                    <?= $lista ?>
                </div>
            </div>
        </section>
        <script src="../../../presentacion/DistOssaPasto/js/jquery-ui.min.js"></script>
        <script src="../../../presentacion/DistOssaPasto/js/popper.min.js"></script>
        <script src="../../../presentacion/DistOssaPasto/js/bootstrap.min.js"></script>
        <script src="../../../presentacion/DistOssaPasto/js/DistOssaPasto.js"></script>
    </body>
</html>
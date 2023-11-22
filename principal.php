<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

ob_start();

require_once './clasesGenericas/ConectorBD.php';
require_once './clases/app/Usuarios.php';

session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php?mensaje=Acceso no autorizado");
} else if($_SESSION['usuario']->getIdPerfil() === '2' || $_SESSION['usuario']->getIdPerfil() === '4') {
    header("Location: listing.php");
}
$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>Sistema DistOssaPasto</title>
        <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
        <link rel="icon" href="imagenes/distribucionesOssa.jpg" type="image/x-icon"/>

        <script src="presentacion/DistOssaPasto/js/jquery-3.5.1.min.js"></script>
        <script src="presentacion/DistOssaPasto/js/webfont.min.js"></script>
        <script>
            WebFont.load({
                google: {"families": ["Lato:300,400,700,900"]},
                custom: {"families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['presentacion/DistOssaPasto/css/fonts.min.css']},
                active: function () {
                    sessionStorage.fonts = true;
                }
            });
        </script>

        <link rel="stylesheet" href="presentacion/DistOssaPasto/css/bootstrap.min.css">
        <link rel="stylesheet" href="presentacion/DistOssaPasto/css/DistOssaPasto.css">
        <link rel="stylesheet" href="presentacion/DistOssaPasto/css/demo.css">
        <link rel="stylesheet" href="presentacion/DistOssaPasto/css/responsive.dataTables.min.css">
        <script src="presentacion/DistOssaPasto/js/sweetalert2@11.js"></script>
    </head>
    <body style="overscroll-behavior-y: contain;">
        <div class="wrapper">
            <div class="main-header">
                <?php require_once './extensiones/header.php'; ?>
            </div>
            <div class="sidebar sidebar-style-2">
                <?php require_once './extensiones/menu.php'; ?>
            </div>
            <div class="main-panel">
                <div class="container">
                    <?php require_once $_GET['CONTENIDO']; ?>
                </div>
                <footer class="footer">
                    <?php require_once './extensiones/footer.php'; ?>
                </footer>
            </div>
            <div class="quick-sidebar">
                <?php require_once './extensiones/barraLateral.php'; ?>
            </div>
            <div class="custom-template">
                <?php require_once './extensiones/colores.php'; ?>
            </div>
        </div>
        <script src="presentacion/DistOssaPasto/js/datatables.min.js"></script>
        <script src="presentacion/DistOssaPasto/js/popper.min.js"></script>
        <script src="presentacion/DistOssaPasto/js/bootstrap.min.js"></script>
        <script src="presentacion/DistOssaPasto/js/jquery-ui.min.js"></script>
        <script src="presentacion/DistOssaPasto/js/jquery.ui.touch-punch.min.js"></script>
        <script src="presentacion/DistOssaPasto/js/bootstrap-toggle.min.js"></script>
        <script src="presentacion/DistOssaPasto/js/jquery.scrollbar.min.js"></script>
        <script src="presentacion/DistOssaPasto/js/dataTables.responsive.min.js"></script>
        <script src="presentacion/DistOssaPasto/js/DistOssaPasto.js"></script>
        <script src="presentacion/DistOssaPasto/js/setting-demo2.js"></script>
    </body>
</html>
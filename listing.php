<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once './clasesGenericas/ConectorBD.php';
require_once './clases/app/Producto.php';
require_once './clases/app/Usuarios.php';
require_once './clases/app/Grupo.php';
require_once './clases/app/DescuentoProducto.php';
require_once './clases/app/Ciudad.php';
require_once './clases/app/Marca.php';

session_start();

$registrosXPagina = 36;
$paginacion = '';
$filtro = '';
$grupo = '';
$url = '';
$orden = 'producto.idGrupo, descripcion';
$tipoProducto = '1';
$tipo = '3';
$ciudad = '52001';
$encabezado = 'Lista de precios publico';
$descuentoCiudad = '';
if(isset($_SESSION['usuario']) && !empty($_SESSION['usuario']->getTipoPrecios())){
    $tipo = $_SESSION['usuario']->getTipoPrecios();
    $ciudad = $_SESSION['usuario']->getCodigoCiudad();
    $encabezado = 'Lista de precios mayorista';
}
//filtros
if (isset($_GET['linea']) && !empty($_GET['linea'])) {
    $linea = $_GET['linea'];
    $filtro .= "and idLinea = '$linea'";
    $url .= "&linea=$linea";
}
if (isset($_GET['tipoProducto']) && !empty($_GET['tipoProducto'])) {
    $tipoProducto = $_GET['tipoProducto'];
    $filtro .= "and tipoServicio = '$tipoProducto'";
    $url .= "&tipoProducto=$tipoProducto";
}
if (isset($_GET['marca']) && !empty($_GET['marca'])) {
    $marca = $_GET['marca'];
    $filtro .= "and idMarca = '$marca'";
    $url .= "&marca=$marca";
}
if (isset($_GET['descripcion']) && !empty($_GET['descripcion'])) {
    $descripcion = str_replace(" ", "%", !empty($_GET['descripcion']) ? $_GET['descripcion'] : '');
    $filtro .= "and (descripcion like '%$descripcion%' or codigo like '%$descripcion%')";
    $url .= "&descripcion=$descripcion";
}
if (isset($_GET['orden']) && !empty($_GET['orden'])) {
    $orden = $_GET['orden'];
}
$porcentajeFlete = new Ciudad($ciudad);
$descuentoCiudad = isset($_SESSION['usuario']) && $_SESSION['usuario']->getCodigoCiudad() <> '52001' ? '<br><h6 class="bg-warning text-center">Descuento retirando mercancia en Pasto ' . ($porcentajeFlete->getPorcentaje() * 100) . '%</h6>' : '';
//filtros
//Paginacion
if (isset($_GET["pagina"])) $pagina = $_GET["pagina"];
else $pagina = 1;
$start_from = ($pagina - 1) * $registrosXPagina;
$cadenaSQL = "select count(DISTINCT producto.codigo) as registros from producto JOIN inventario ON inventario.codigoProducto = producto.codigo JOIN grupo ON grupo.id = producto.idGrupo JOIN descuentoProducto ON descuentoProducto.nombreGrupo = SUBSTRING(producto.codigo, 1, 4) where descuentoProducto.tipo = '$tipo' AND producto.estado = 'Y' $filtro";
$resultado = ConectorBD::ejecutarQuery($cadenaSQL);
$total_records = $resultado[0]['registros'];
$total_pages = ceil($total_records / $registrosXPagina);
$start_loop = $pagina;
$diferencia = $total_pages - $pagina;
if ($diferencia <= 5) $start_loop = $total_pages - 5;
$end_loop = $start_loop + 5;
$paginacion .= '<ul class="pagination justify-content-center">';
if ($pagina > 1) {
    $paginacion .= "<li class='page-item'><a class='page-link rounded-pill' href='listing.php?pagina=1$url'><i class='ci-arrow-left me-2'></i>PRI</a></li>";
    $paginacion .= "<li class='page-item'><a class='page-link rounded-pill' href='listing.php?pagina=" . ($pagina - 1) . "$url'>ANT</a></li>";
}
for ($i = $start_loop; $i <= $end_loop; $i++) {
    $auxiliar = '';
    if ($i > 0) {
        if ($i == $pagina) $auxiliar .= 'active';
        $paginacion .= "<li class='page-item $auxiliar'><a class='page-link rounded-pill' href='listing.php?pagina=$i$url'>$i</a></li>";
    }
}
if ($pagina < $total_pages) {
    $paginacion .= "<li class='page-item'><li><a class='page-link rounded-pill' href='listing.php?pagina=" . ($pagina + 1) . "$url'>SIG</a></li>";
    $paginacion .= "<li class='page-item'><a class='page-link rounded-pill' href='listing.php?pagina=$total_pages$url'>ULT<i class='ci-arrow-right ms-2'></i></a></li>";
}
$paginacion .= '</ul>';
//Paginacion
$lista = '';

$day = date("l");
switch ($day) {
    case "Sunday":
        $ordenLinea = "CASE WHEN idLinea = '5' THEN 1 WHEN idLinea = '7' THEN 2 WHEN idLinea = '6' THEN 3 WHEN idLinea = '1' THEN 4 WHEN idLinea = '11' THEN 5 WHEN idLinea = '9' THEN 6 WHEN idLinea = '2' THEN 7 WHEN idLinea = '4' THEN 8 WHEN idLinea = '8' THEN 9 WHEN idLinea = '10' THEN 10 END";
    break;
    case "Monday":
        $ordenLinea = "CASE WHEN idLinea = '2' THEN 1 WHEN idLinea = '4' THEN 2 WHEN idLinea = '5' THEN 3 WHEN idLinea = '7' THEN 4 WHEN idLinea = '6' THEN 5 WHEN idLinea = '1' THEN 6 WHEN idLinea = '11' THEN 7 WHEN idLinea = '9' THEN 8 WHEN idLinea = '8' THEN 9 WHEN idLinea = '10' THEN 10 END";
    break;
    case "Tuesday":
        $ordenLinea = "CASE WHEN idLinea = '9' THEN 1 WHEN idLinea = '2' THEN 2 WHEN idLinea = '4' THEN 3 WHEN idLinea = '5' THEN 4 WHEN idLinea = '7' THEN 5 WHEN idLinea = '6' THEN 6 WHEN idLinea = '1' THEN 7 WHEN idLinea = '11' THEN 8 WHEN idLinea = '8' THEN 9 WHEN idLinea = '10' THEN 10 END";
    break;
    case "Wednesday":
        $ordenLinea = "CASE WHEN idLinea = '11' THEN 1 WHEN idLinea = '9' THEN 2 WHEN idLinea = '2' THEN 3 WHEN idLinea = '4' THEN 4 WHEN idLinea = '5' THEN 5 WHEN idLinea = '7' THEN 6 WHEN idLinea = '6' THEN 7 WHEN idLinea = '1' THEN 8 WHEN idLinea = '8' THEN 9 WHEN idLinea = '10' THEN 10 END";
    break;
    case "Thursday":
        $ordenLinea = "CASE WHEN idLinea = '1' THEN 1 WHEN idLinea = '11' THEN 2 WHEN idLinea = '9' THEN 3 WHEN idLinea = '2' THEN 4 WHEN idLinea = '4' THEN 5 WHEN idLinea = '5' THEN 6 WHEN idLinea = '7' THEN 7 WHEN idLinea = '6' THEN 8 WHEN idLinea = '8' THEN 9 WHEN idLinea = '10' THEN 10 END";
    break;
    case "Friday":
        $ordenLinea = "CASE WHEN idLinea = '6' THEN 1 WHEN idLinea = '1' THEN 2 WHEN idLinea = '11' THEN 3 WHEN idLinea = '9' THEN 4 WHEN idLinea = '2' THEN 5 WHEN idLinea = '4' THEN 6 WHEN idLinea = '5' THEN 7 WHEN idLinea = '9' THEN 8 WHEN idLinea = '8' THEN 9 WHEN idLinea = '10' THEN 10 END";
    break;
    case "Saturday":
        $ordenLinea = "CASE WHEN idLinea = '7' THEN 1 WHEN idLinea = '6' THEN 2 WHEN idLinea = '1' THEN 3 WHEN idLinea = '11' THEN 4 WHEN idLinea = '9' THEN 5 WHEN idLinea = '2' THEN 6 WHEN idLinea = '4' THEN 7 WHEN idLinea = '5' THEN 8 WHEN idLinea = '8' THEN 9 WHEN idLinea = '10' THEN 10 END";
    break;
}

$productos = Producto::getPreciosVentas("descuentoProducto.tipo = '$tipo' AND producto.estado = 'Y' $filtro", "CASE WHEN disponible > 0 THEN 1 ELSE 2 END, $ordenLinea, $orden limit $registrosXPagina  offset $start_from");
if (is_array($productos) && count($productos) > 0) {
    foreach ($productos as $indice => $arreglo) {
        $precio = $arreglo['precio'] * (1 + $porcentajeFlete->getPorcentaje());
        $lista .= '<div class="col-6 col-md-4 col-lg-2 card border border-dark">';
        //$lista .= "<span class='badge badge-primary'>{$productos['nombreLinea']}</span>";
        $lista .= "<div class='row'>";
        $lista .= "<span class='badge badge-danger mx-2'>Stock {$arreglo['disponible']}</span>";
        $lista .= "</span><span class='badge badge-success mx-2 ml-auto'>U.E: {$arreglo['cantidadVenta']}</span>";
        $lista .= "</div>";
        $lista .= '<a href="#!" class="product-like"></a>';
        $lista .= '<div class="product">';
        $lista .= '<figure class="product-image">';
        $lista .= '<a href="#!">';
        $lista .= "<img class='mx-auto d-block imgProducto' producto='{$arreglo['codigo']}' data-toggle='modal' data-target='#fichaTecnica' src='https://fotos.ossadistribuciones.com/{$arreglo['foto']}' alt='Image'>";
        $lista .= '</a>';
        if ($arreglo['disponible'] <= 0) $lista .= '<span class="badge badge-dark text-rotation">Agotado</span>';
        $lista .= '</figure>';
        $lista .= '<div class="product-meta p-0">';
        $lista .= "<h3 class='product-title'><a href='#!'>{$arreglo['descripcion']} </a></h3>";
        $lista .= "<h3 class='product-title text-danger'>Vr x Un $" . number_format($precio) . "</h3>";
        if ($arreglo['cantidadVenta'] > 1 && $arreglo['margenXEmpaque'] > 0) {
            $precio = number_format($arreglo['precio'] * (1 + $porcentajeFlete->getPorcentaje()) * (1 - ($arreglo['margenXEmpaque'] / 100)));
            $lista .= "<h3 class='product-title'>Vr x {$arreglo['cantidadVenta']} $$precio</h3>";
        }
        if ($arreglo['cantidadVolumen'] > 1 && $arreglo['margenXVolumen'] > 0) {
            $precio = number_format($arreglo['precio'] * (1 + $porcentajeFlete->getPorcentaje()) * (1 - ($arreglo['margenXVolumen'] / 100)));
            $lista .= "<h3 class='product-title'>Vr x {$arreglo['cantidadVolumen']} $$precio</h3>";
        }
        $lista .= '<div class="product-price">';
        $lista .= "<span class='product-action badge bg-warning letterCart' producto='{$arreglo['codigo']}' tipo='{$tipo}' status='" . ($arreglo['disponible'] <= 0 ? "Agotado" : "Activo") . "'><a class='text-dark' href='javascript:void(0)'>Agregar al carro</a></span>";
        $lista .= '</div>';
        $lista .= '</div>';
        $lista .= '</div>';
        $lista .= '</div>';
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

        <script src="presentacion/DistOssaPasto/js/sweetalert2@11.js"></script>
        
        <meta name="google" content="notranslate">

        <style>
            .imgProducto{
                height: 180px;
                max-width: 100%;
            }
            
            .letterCart{
                font-size: 0.8rem;
            }
            
            .dropdown-scrollable {
                max-height: 200px;
                overflow-y: auto;
            }

            .dropdown-scrollable::-webkit-scrollbar {
                width: 6px; 
            }

            .dropdown-scrollable::-webkit-scrollbar-track {
                background: #f1f1f1; 
            }

            .dropdown-scrollable::-webkit-scrollbar-thumb {
                background: #888; 
            }

            .dropdown-scrollable::-webkit-scrollbar-thumb:hover {
                background: #555; 
            }
        </style>
    </head>
    <body>

        <header class="header header-dark header-sticky d-flex flex-wrap mb-4 border-bottom bg-dark">
            <?php require_once './extensiones/headerPrincipal.php'; ?>
        </header>

        <div class="swiper-container mt-5 d-none d-lg-block d-xl-block d-md-block">
            <div class="swiper-wrapper" style="height: 450px">
                <div class="swiper-slide">
                    <div class="image image-overlay image-zoom" style="background-image:url(imagenes/distribucionesOssa1.jpg)"></div>
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

        <section class="pt-1">
            <div class="container">
                <div class="row justify-content-end">
                    <div class="col-lg-12">
                        <div class="row gutter-2 align-items-center">
                            <div class="col-md-8">
                                <h1 class="mb-0"><?= $encabezado ?></h1>
                                <span class="eyebrow"><?= $total_records ?> productos</span>
                                <?= $descuentoCiudad ?>    
                            </div>
                            <div class="col-md-4">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle rounded-pill bg-dark text-light p-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Categoria
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="listing.php?linea=3">Nuevo</a></li>
                                        <li><a class="dropdown-item" href="#">Promociones</a></li>
                                        <li><a class="dropdown-item" href="listing.php?linea=7">Manicura</a></li>
                                        <li><a class="dropdown-item" href="listing.php?linea=2">Cabello</a></li>
                                        <li><a class="dropdown-item" href="listing.php?linea=4">Corporal</a></li>
                                        <li><a class="dropdown-item" href="listing.php?linea=5">Facial</a></li>
                                        <li><a class="dropdown-item" href="listing.php?linea=9">Peluqueria</a></li>
                                        <li><a class="dropdown-item" href="listing.php?linea=6">Hombre</a></li>
                                        <li><a class="dropdown-item" href="listing.php?linea=1">Accesorios</a></li>
                                        <li><a class="dropdown-item" href="listing.php?linea=11">Niños</a></li>
                                        <li><a class="dropdown-item" href="listing.php?linea=10">Ferreteria</a></li>
                                        <li><a class="dropdown-item" href="listing.php?linea=8">Otros</a></li>
                                    </ul>
                                </div>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle rounded-pill bg-dark text-light p-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Marca
                                    </button>
                                    <ul class="dropdown-menu dropdown-scrollable" aria-labelledby="dropdownMenuButton">
                                        <?= Marca::getDropdownMenu(null, 'nombre') ?>
                                    </ul>
                                </div>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle rounded-pill bg-dark text-light p-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ordenar
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="<?= "listing.php?pagina=$pagina$url&orden=descripcion" ?>">Alfabetico</a></li>
                                        <li><a class="dropdown-item" href="<?= "listing.php?pagina=$pagina$url&orden=precio desc" ?>">Precio Mayor a menor</a></li>
                                        <li><a class="dropdown-item" href="<?= "listing.php?pagina=$pagina$url&orden=precio asc" ?>">Precio menor a mayor</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-lg-12">
                        <div class="row justify-content-center gutter-2 gutter-lg-3">
                            <?= $lista ?>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col">
                                <h6 class="text-center">Paginas</h6>
                                <nav>
                                    <?= $paginacion ?>
                                </nav>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <footer class="bg-dark text-white py-0">
            <?php // require_once './extensiones/footerPrincipal.php'; ?>
        </footer>

        <?php require_once './extensiones/modals.php'; ?>
        <?php require_once './extensiones/menuMovil.php'; ?>

        <script src="presentacion/DistOssaPasto/js/vendor.min.js"></script>
        <script src="presentacion/DistOssaPasto/js/app.js"></script>
        <script src="presentacion/DistOssaPasto/js/main.js?v6"></script>
    </body>
</html>
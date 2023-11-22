<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$menu = '';
$cupoDisponible = '';
if (isset($_SESSION['usuario'])) {
    $cupoDisponible = $_SESSION['usuario']->getCupoCliente($_SESSION['usuario']->getNit()) > 0 ? 'Cupo Disponible: <br>$' . number_format($_SESSION['usuario']->getCupoCliente($_SESSION['usuario']->getNit()) - $_SESSION['usuario']->getTotalFacturado($_SESSION['usuario']->getNit())) : '';
    $menu .= '<div class="dropdown">';
    $menu .= '<button class="btn text-light text-capitalize p-0 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="rounded-circle" height="50px" src="imagenes/micuenta.png"><br>Mayorista</button>';
    $menu .= '<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
    $menu .= '<li><a class="dropdown-item" data-toggle="modal" data-target="#pass">Cambiar clave</a></li>';
    $menu .= '<li><a href="myOrders.php" class="dropdown-item">Mis pedidos</a></li>';
    if ($_SESSION['usuario']->getIdPerfil() === '1') $menu .= '<li><a class="dropdown-item" href="principal.php?CONTENIDO=app/pedidos/pedidos.php">Pedidos</a></li>';
    $menu .= '<div class="dropdown-divider"></div>';
    $menu .= '<li><a class="dropdown-item" href="extensiones/cerrarSesion.php">Cerrar sesion</a></li>';
    $menu .= '</ul>';
    $menu .= '</div>';
} else {
    $menu .= '<div class="dropdown">';
    $menu .= '<a href="login.php" class="btn text-light text-capitalize p-0"><img class="rounded-circle" height="50px" src="imagenes/micuenta.png"><br>Mi cuenta</a>';
    $menu .= '</div>';
}
?>
<div class="container d-block d-lg-none d-xl-none d-md-none">
    <div class="row">
        <nav class="navbar navbar-expand-lg navbar-dark p-1">
            <?= $menu ?>
            <button class="navbar-toggler order-2" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <h6 class="text-light text-center"><?= $cupoDisponible ?></h6>

            <div class="collapse navbar-collapse order-3 order-lg-1" id="navbarMenu">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="inicio.php" id="navbarDropdown-11">
                            Inicio
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="listing.php" id="navbarDropdown-11">
                            Productos
                        </a>
                    </li>
                    <li class="nav-item dropdown megamenu">
                        <a class="nav-link dropdown-toggle" href="#!" id="navbarDropdown-4" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Paginas
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown-4">
                            <div class="row">
                                <ul class="col-6 col-md-3 col-lg-2">
                                    <li><span class="megamenu-title">Inicio</span></li>
                                    <li><a class="dropdown-item" href="inicio.php">Inicio</a></li>
                                    <li><span class="megamenu-title">Tienda</span></li>
                                    <li><a class="dropdown-item" href="listing.php">Listado</a></li>
                                </ul>
                                <ul class="col-6 col-md-3 col-lg-2">
                                    <li><span class="megamenu-title">Pedido</span></li>
                                    <li><a class="dropdown-item" href="cart.php">Carrito</a></li>
                                    <li><a class="dropdown-item" href="checkout.php">Verificar</a></li>
                                    <li><a class="dropdown-item" href="suggestedOrder.php">Pedido sugerido</a></li>
                                </ul>
                                <ul class="col-6 col-md-3 col-lg-2">
                                    <li><span class="megamenu-title">Paginas</span></li>
                                    <li><a class="dropdown-item" href="about.html">Acerca de</a></li>
                                    <li><a class="dropdown-item" href="contact.html">Contacto</a></li>
                                    <li><a class="dropdown-item" href="faq.html">Preguntas mas frecuentes</a></li>
                                    <li><span class="megamenu-title">Blog</span></li>
                                    <li><a class="dropdown-item" href="doc.html">Blog - tarjetas</a></li>
                                    <li><a class="dropdown-item" href="doc.html">Blog - publicaciones</a></li>
                                    <li><a class="dropdown-item" href="doc.html">Correo</a></li>
                                </ul>
                                <ul class="col-6 col-md-3 col-lg-2">
                                    <li><span class="megamenu-title">Docs</span></li>
                                    <li><a class="dropdown-item" href="doc.html">Documentacion</a></li>
                                    <li><a class="dropdown-item" href="changelog.html">Registros de cambios</a></li>
                                </ul>
                                <div class="col-lg-4">
                                    <div class="promo">
                                        <span class="image image-overlay" style="background-image: url(imagenes/distribucionesOssa.jpg)"></span>
                                        <div class="promo-footer p-4 text-white">
                                            <h3 class="mb-0">Nueva coleccion</h3>
                                            <a href="#!" class="eyebrow underline text-white">Compra ahora</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!--<li class="nav-item cart">
                      <a data-toggle="modal" data-target="#cart" class="nav-link"><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Carro</font></font></span><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">2</font></font></span></a>
                    </li>-->
                </ul>
            </div>

            <div class="collapse navbar-collapse order-4 order-lg-3" id="navbarMenu2">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="login.php">Iniciar sesion</a></li>                    <li class="nav-item">
                        <a data-toggle="modal" data-target="#search" class="nav-link"><i class="icon-search"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<div class="container my-lg-1">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
            <img class="bi me-2 d-none d-lg-block d-xl-block d-md-block rounded-pill" width="150" height="80" src="imagenes/distribucionesOssa1.jpg">
        </a>

        <ul class="nav col-12 col-lg-4 col-md-4 me-lg-auto mb-1 justify-content-center mb-md-0">
            <li><a href="inicio.php" class="nav-link px-1 text-white"><h5>Inicio</h5></a></li>
            <?php if (isset($_GET['tipoProducto']) && $_GET['tipoProducto'] === '2') { ?>
                <li><a href="listing.php?tipoProducto=1" class="nav-link px-1 text-white"><h5>Belleza</h5></a></li>
                <li><a href="listing.php?tipoProducto=2" class="nav-link px-1 text-dark bg-white rounded-pill"><h5>Ferreteria</h5></a></li>
                <li><a href="#" class="nav-link px-1 text-white"><h5>Otros</h5></a></li>
            <?php } else { ?>
                <li><a href="listing.php?tipoProducto=1" class="nav-link px-1 text-dark bg-white rounded-pill"><h5>Belleza</h5></a></li>
                <li><a href="listing.php?tipoProducto=2" class="nav-link px-1 text-white"><h5>Ferreteria</h5></a></li>
                <li><a href="#" class="nav-link px-1 text-white"><h5>Otros</h5></a></li>
            <?php } ?>
        </ul>

        <form class="col-12 col-lg-3 mb-3 mb-lg-0 me-lg-3 d-none d-lg-block d-xl-block d-md-block" role="search" name="formularioMovil" method="GET" action="listing.php">
            <input type="search" class="form-control form-control-dark text-bg-dark bg-light rounded-pill" name="descripcion" placeholder="Buscar..." aria-label="Search">
        </form>

        <div class="text-end d-none d-lg-block d-xl-block d-md-block">
            <?= $menu ?>
            <a href="cart.php" class="btn btn-light btn-rounded text-dark p-1 cart1"><span><img class="img-fluid rounded" src="imagenes/cart.png"></span>&nbsp;<span class="bg-danger text-light rounded-pill">0</span><br><b class="text-info totalModal">0</b></a>
        </div>
        <a href="#" class="d-none d-lg-block d-xl-block d-md-block"><h6 class="text-light text-center"><?= $cupoDisponible ?></h6></a>
    </div>
</div>
<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

@session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php?mensaje=Acceso no autorizado");
}
?>
<div class="logo-header" data-background-color="blue">

    <a href="#" class="logo text-white">
        <img src="imagenes/distribucionesOssa.jpg" alt="navbar brand" class="navbar-brand imgRedonda"> Dist. Ossa
    </a>
    <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon">
            <i class="icon-menu"></i>
        </span>
    </button>
    <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
    <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar">
            <i class="icon-menu"></i>
        </button>
    </div>
</div>
<nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
    <div class="container-fluid">
        <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
            <li class="nav-item toggle-nav-search hidden-caret">
                <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
                    <i class="fa fa-search"></i>
                </a>
            </li>
            <li class="nav-item dropdown hidden-caret">
                <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-envelope"></i>
                </a>
                <ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">
                    <li>
                        <div class="dropdown-title d-flex justify-content-between align-items-center">
                            Mensajes 									
                        </div>
                    </li>
                    <li>
                        <div class="message-notif-scroll scrollbar-outer">
                            <div class="notif-center">
                                <a href="#">
                                    <div class="notif-img"> 
                                        <img src="imagenes/ferrecol.png" alt="Img Profile">
                                    </div>
                                    <div class="notif-content">
                                        <span class="subject">Andres Ortega</span>
                                        <span class="block">
                                            Realizar pedido (Andres Ortega) ?
                                        </span>
                                        <span class="time">Hace 5 minutos</span> 
                                    </div>
                                </a>
                                <a href="#">
                                    <div class="notif-img"> 
                                        <img src="imagenes/distribucionesOssa.jpg" alt="Img Profile">
                                    </div>
                                    <div class="notif-content">
                                        <span class="subject">Victor Cordaba</span>
                                        <span class="block">
                                            Reunion para el dia viernes 28 a las 7:30 AM!
                                        </span>
                                        <span class="time">Hace 12 minutos</span> 
                                    </div>
                                </a>
                                <a href="#">
                                    <div class="notif-img"> 
                                        <img src="imagenes/distribucionesOssa.jpg" alt="Img Profile">
                                    </div>
                                    <div class="notif-content">
                                        <span class="subject">Ricardo Andres Ossa</span>
                                        <span class="block">
                                            Capacitacion espacialidad contrucampo
                                        </span>
                                        <span class="time">Hace 2 horas</span> 
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a class="see-all" href="javascript:void(0);">See all messages<i class="fa fa-angle-right"></i> </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown hidden-caret">
                <input type="hidden" name="tipoUsuario" id="tipoUsuario" value="<?= $usuario->getIdPerfil() ?>">
                <input type="hidden" name="identificacionNotificacion" id="identificacionNotificacion" value="<?= $usuario->getNit() ?>">
                <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    <span class="notification" id="cantidadNotificacion"></span>
                </a>
                <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                    <li>
                        <div class="dropdown-title" id="tituloNotificacion"></div>
                    </li>
                    <li>
                        <div class="notif-center" id="notificaciones">

                        </div>
                    </li>
                    <li>
                        <a class="see-all" href="javascript:void(0);">Ver todas las notificaciones<i class="fa fa-angle-right"></i> </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown hidden-caret">
                <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                    <i class="fas fa-layer-group"></i>
                </a>
                <div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">
                    <div class="quick-actions-header">
                        <span class="title mb-1">Acciones rapidas</span>
                        <span class="subtitle op-8">Atajos</span>
                    </div>
                    <div class="quick-actions-scroll scrollbar-outer">
                        <div class="quick-actions-items">
                            <div class="row justify-content-center m-0">
                                <a class="col-6 col-md-4 p-0" href="principal.php?CONTENIDO=app/pedidos/pedidos.php">
                                    <div class="quick-actions-item">
                                        <div class="avatar-item bg-danger rounded-circle">
                                            <i class="fas fa-file-signature"></i>
                                        </div>
                                        <span class="text">Pedidos</span>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 p-0" href="principal.php?CONTENIDO=app/pedidos/pedidosFormulario.php">
                                    <div class="quick-actions-item">
                                        <div class="avatar-item bg-warning rounded-circle">
                                            <i class="fas fa-truck"></i>
                                        </div>
                                        <span class="text">Agregar pedidos</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link quick-sidebar-toggler">
                    <i class="fa fa-th"></i>
                </a>
            </li>
            <li class="nav-item dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                    <div class="avatar-sm">
                        <img src="imagenes/distribucionesOssa.jpg" alt="..." class="avatar-img rounded-circle">
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                        <li>
                            <div class="user-box">
                                <div class="avatar-lg"><img src="imagenes/distribucionesOssa.jpg" alt="image profile" class="avatar-img rounded"></div>
                                <div class="u-text">
                                    <h4><?= $usuario ?></h4>
                                    <p class="text-muted"><?= $usuario->getEmail() ?></p><a href="principal.php?CONTENIDO=app/perfil/perfil/perfil.php" class="btn btn-xs btn-secondary btn-sm">Perfil</a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="principal.php?CONTENIDO=app/perfil/perfil/perfil.php">Mi perfil</a>
                            <a class="dropdown-item" href="principal.php?CONTENIDO=app/perfil/cambiarClave/cambiarClave.php">Cambiar clave</a>
                            <a class="dropdown-item" href="#">Mensajes</a>
                            <a class="dropdown-item" href="#">Actividades</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Configuracion</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" target="_blank" href="listing">Catalogo</a>
                            <a class="dropdown-item" href="extensiones/cerrarSesion.php">Salir</a>
                        </li>
                    </div>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<script type="text/javascript">
    cargarNotificacion();
    function cargarNotificacion() {
        $.ajax({
            type: 'POST',
            url: "funciones/funciones.php",
            data: {accion: 'Notificaciones'}
        }).done(function (datos) {
            datos = JSON.parse(datos); 
            $('#notificaciones').html(datos.datos);
            $('#cantidadNotificacion').html(datos.contador);
            if (datos.contado > 1 || datos.contado < 1) {
                $('#tituloNotificacion').html("Tienes " + datos.contador + " notificaciones nuevas");
            } else {
                $('#tituloNotificacion').html("Tiene " + datos.contador + " notificacion nueva");
            }
        });
    }

    setInterval(cargarNotificacion, 10000);
</script>
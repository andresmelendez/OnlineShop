<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$mensaje = isset($_GET['mensaje']) ? $_REQUEST['mensaje'] : '';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>Login | DistOssaPasto</title>
        <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
        <link rel="icon" href="imagenes/distribucionesOssa.jpg" type="image/x-icon"/>

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
        <style>
            .fondo {
                background-image: url(imagenes/fondo.jpg);
                background-position: center center;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
                background-color: #66999;

            }
        </style>
        <link rel="stylesheet" href="presentacion/DistOssaPasto/css/bootstrap.min.css">
        <link rel="stylesheet" href="presentacion/DistOssaPasto/css/DistOssaPasto.css">
        <script src="presentacion/DistOssaPasto/js/sweetalert2@11.js"></script>
    </head>
    <body class="login">
        <div class="wrapper wrapper-login wrapper-login-full p-0">
            <div class="login-aside w-50 flex align-items-center justify-content-center text-center bg-danger fondo d-none d-lg-block d-xl-block d-md-block">
                <h1 class="title fw-bold text-white mb-3">Unete a nuestra comunidad OSSA Distribuciones <br>Aliados de tu negocio</h1>
                <p class="subtitle fw-bold text-light">Conozca nuestra gran variedad de productos</p>
            </div>
            <div class="login-aside w-50 d-flex align-items-center justify-content-center bg-white p-0">
                <div class="container container-login container-transparent animated fadeIn" style="padding: 15px !important;">
                    <img height="50" class="img-circle mx-auto d-block" src="imagenes/distribucionesOssa.jpg">
                    <h3 class="text-center mb-0">Iniciar sesion</h3>
                    <form name="login" id="login" action="" method="post">
                        <font color="red"><p class="text-center" id="mensaje"><?= $mensaje ?></p></font>
                        <div class="login-form">
                            <div class="form-group">
                                <label for="username" class="placeholder">Identificacion</label>
                                <input name="usuario" id="usuario" type="number" class="form-control border border-dark"  pattern="[A-Za-z0-9]{1,12}" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="placeholder">Contraseña</label>
                                <div class="position-relative">
                                    <input name="clave" id="clave" type="password" class="form-control border border-dark"  pattern="[A-Za-z0-9]{1,32}" required>
                                    <div class="show-password">
                                        <i class="icon-eye"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-sub m-0">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="rememberme">
                                    <label class="custom-control-label" for="rememberme">Recuerdame</label>
                                </div>

                                <a href="#" class="link float-right">Contraseña olvidada?</a>
                            </div>
                            <div class="form-action mb-3">
                                <button type="submit" class="btn btn-primary btn-rounded btn-login">Iniciar sesion</button>
                            </div>
                            <div class="login-account">
                                <span class="msg">Aun no tienes una cuenta?</span>
                                <a href="#" id="show-signup" class="link">Registrarse</a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="container container-signup container-transparent animated fadeIn">
                    <h3 class="text-center">Registrarse</h3>
                    <form id="registrar" name="registrar" method="post">
                        <div class="form-group">
                            <label for="identificacion" class="h6">Identificacion</label>
                            <input  id="nit" name="nit" type="text" class="form-control border border-dark" required>
                        </div>
                        <div class="form-group">
                            <label for="nombres" class="h6">Nombres</label>
                            <input  id="nombres" name="nombres" type="text" class="form-control border border-dark" required>
                        </div>
                        <div class="form-group">
                            <label for="apellidos" class="h6">Apellidos</label>
                            <input  id="apellidos" name="apellidos" type="text" class="form-control border border-dark" required>
                        </div>
                        <div class="form-group">
                            <label for="razonSocial" class="placeholder">Nombre del local</label>
                            <input  id="nombreComercial" name="nombreComercial" type="text" class="form-control border border-dark" required>
                        </div>
                        <div class="form-group">
                            <label for="celular" class="h6">Celular</label>
                            <input  id="celular" name="celular" type="number" class="form-control border border-dark" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="placeholder">Correo</label>
                            <input  id="email" name="email" type="email" class="form-control border border-dark" required>
                        </div>
                        <div class="form-group form-floating-label">
                            <select id="codigoCiudad" name="codigoCiudad" type="text" class="form-control input-border-bottom text-uppercase" required="">
                              <option value="0001">Buesaco</option>
                              <option value="52240">CHACHAGUI</option>
                              <option value="52207">CONSACA</option>
                              <option value="4">Cumbal</option>
                              <option value="1212">El estrecho</option>
                              <option value="52287">FUNES</option>
                              <option value="3">Guachucal</option>
                              <option value="52320">GUAITARILLA</option>
                              <option value="20">Ipiales</option>
                              <option value="52500">La Union (N)</option>
                              <option value="80">La Cruz</option>
                              <option value="98765">Remolino</option>
                              <option value="52">RICAURTE</option>
                              <option value="5">Samaniego</option>
                              <option value="52683">SANDONA</option>
                              <option value="52687">SAN LORENZO</option>
                              <option value="52207">Tambo</option>
                              <option value="52786">TAMINANGO</option>
                              <option value="52838">TUQUERRES</option>
                              <option value="52540">POLICARPA</option>
                              <option value="52001" selected>Pasto</option>
                              <option value="52885">YACUANQUER</option>
                            </select>

                            <label for="codigoCiudad" class="placeholder">Ciudad</label>
                        </div>
                        <div class="form-group">
                            <label for="direccion" class="h6">Barrio</label>
                            <input  id="barrio" name="barrio" type="text" class="form-control border border-dark" required>
                        </div>
                        <div class="form-group">
                            <label for="direccion" class="h6">Direccion</label>
                            <input  id="direccion" name="direccion" type="text" class="form-control border border-dark" required>
                        </div>
                        <div class="form-group">
                            <label for="tipoNegocio" class="h6">Tipo negocio</label>
                            <input  id="tipoNegocio" name="tipoNegocio" type="text" class="form-control border border-dark" required>
                        </div>
                        <div class="row form-sub m-0">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="agree" id="agree">
                                <label class="custom-control-label" for="agree">Acepto los terminos y condiciones.</label>
                                <p class="text-center text-danger" id="terminos"></p>
                            </div>
                        </div>
                        <div class="form-action">
                            <a href="#" id="show-signin" class="btn btn-danger btn-link btn-login mr-3">Cancel</a>
                            <button type="submit" class="btn btn-primary btn-rounded btn-login">Crear cuenta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="presentacion/DistOssaPasto/js/jquery-3.5.1.min.js"></script>
        <script src="presentacion/DistOssaPasto/js/jquery-ui.min.js"></script>
        <script src="presentacion/DistOssaPasto/js/popper.min.js"></script>
        <script src="presentacion/DistOssaPasto/js/bootstrap.min.js"></script>
        <script src="presentacion/DistOssaPasto/js/DistOssaPasto.js"></script>
        <script src="presentacion/DistOssaPasto/js/main.js?v3"></script>
    </body>
</html>
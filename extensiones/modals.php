<div class="modal fade sidebar" id="cart" tabindex="-1" role="dialog" aria-labelledby="cartLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartLabel">Carrito</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row gutter-3" id="carrito">

                </div>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row gutter-0">
                        <div class="col">
                            <a href="cart.php" class="btn btn-lg btn-block btn-primary">Siguiente</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade search" id="search" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <form class="form-inline"  name="formulario" method="GET" action="listing.php">
                    <input type="text" class="form-control pr-10" placeholder="Escriba su busqueda aqui" name="descripcion" id="descripcion" aria-label="Type your search here" aria-describedby="button-addon2">
                    <button type="submit" class="btn btn-primary btn-rounded btn-sm mx-7" style="position: absolute; right: 1.875rem">
                        <span class="d-none d-lg-block d-xl-block d-md-block" aria-hidden="true">Buscar</span><span class="d-block d-lg-none d-xl-none d-md-none" aria-hidden="true"><i class="icon-search"></i></span>
                    </button>
                    <button type="button" class="close btn btn-sm" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="pass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formulario">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="placeholder">Contraseña actual</label>
                        <input type="password" class="form-control" id="contraseñaActual" name="contraseñaActual" value="" size="32" maxlength="32" required>
                    </div>
                    <div class="form-group">
                        <label class="placeholder">Nueva contraseña</label>
                        <input type="password" class="form-control" id="contraseñaNueva" name="contraseñaNueva" value="" size="32" maxlength="32" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Debe contener al menos un número y una letra mayúscula y minúscula, y al menos 8 caracteres o más" required>
                    </div>
                    <div class="form-group form-floating-label">
                        <label class="placeholder">Confirmar contraseña</label>
                        <input type="password" class="form-control" id="confirmarContraseña" name="confirmarContraseña" value="" size="32" maxlength="32" required>
                    </div>
                    <div class="mensaje" style="display:none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="fichaTecnica" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img class="img-thumbnail" id="imagenFichaTecnica">
                    </div>
                    <div class="col-md-6" id="datosFichaTecnica">
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

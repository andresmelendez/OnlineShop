/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on('submit', '#login', function (e) {
    e.preventDefault();
    var usuario = $.trim($("#usuario").val());
    var clave = $.trim($("#clave").val());
    $.ajax({
        url: "funciones/funciones.php",
        type: "POST",
        data: {accion: 'Ingresar', usuario: usuario, clave: clave},
        success: function (datos) {
            if (datos != "") {
                datos = JSON.parse(datos);
                if (datos.status === 'success') {
                    if(datos.type === 'failure') {
                        Swal.fire({
                            title: 'Con que catalogo deseas iniciar?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ferreteria!',
                            cancelButtonText: 'Belleza!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'listing.php?tipoProducto=2';
                            } else {
                                window.location.href = 'listing.php?tipoProducto=1';
                            }
                        });
                    } else {
                        window.location.href = datos.redireccion;
                    }
                } else if (datos.status === 'warning') {
                    $('#mensaje').html(datos.mensaje);
                } else {
                    $('#mensaje').html('Usuario y/o contraseña incorrecta');
                }
            }
        }
    });
});

$(document).on('submit', '#registrar', function (e) {
    e.preventDefault();
    var condiciones = $("#agree").is(":checked");
    if (condiciones) {
        $.ajax({
            url: "funciones/funciones.php",
            type: "POST",
            datatype: "json",
            data: {
                nit: $.trim($('#nit').val()),
                nombres: $.trim($('#nombres').val()),
                apellidos: $.trim($('#apellidos').val()),
                nombreComercial: $.trim($('#nombreComercial').val()),
                celular: $.trim($('#celular').val()),
                email: $.trim($('#email').val()),
                direccion: $.trim($('#direccion').val()),
                barrio: $.trim($('#barrio').val()),
                tipoNegocio: $.trim($('#tipoNegocio').val()),
                codigoCiudad: $.trim($('#codigoCiudad').val()),
                accion: 'Registrarse'
            },
            success: function (data) {
                $('#mensaje').html('Usuario registrado correctamente.<br>Su registro se envio correctamente. Le informaremos a su whats app en el momento que este habilitado para ingresar a nuestra plataforma, esto puede tardar maximo 24 horas, si este mensaje no le llega por favor escribir al whats app 322 444 94 44.');
                $("#registrar").trigger("reset");
            }
        });
        $('.container-signup').hide();
        $('#registrar').removeClass('filled');
        $('#terminos').html('');
        $('.container-login').show();
    } else {
        $('#terminos').html('Su registro no se ha enviado por favor de click en el recuadro para aceptar los terminos y condiciones');
    }
});

const formatoMoneda = new Intl.NumberFormat('es-CO', {
    style: 'currency',
    currency: 'COP',
    minimumFractionDigits: 0
});

onload();
function onload() {
    $.ajax({
        type: 'POST',
        url: "funciones/funciones.php",
        data: {accion: 'Carrito'},
        success: function (datos) {
            $('#carrito').html(datos);
            $('.cart span:eq(1)').html($('#carrito .cart-item').length);
            $('.cart1 span:eq(1)').html($('#carrito .cart-item').length);
            sumPrice = 0;
            $('.cart-item-price').each(function () {
                sumPrice += parseInt($.trim($(this).text().replace('$', '').replace('.', '')));
            });
            $('.totalModal').text(formatoMoneda.format(sumPrice));
        }
    });
}

$(document).on('click', '.product-action', function () {
    var itemName = $(this).closest(".product-meta").find(".product-title").text();
    var producto = $(this).attr("producto");
    var tipo = $(this).attr("tipo");
    var status = $(this).attr("status");
    
    if(status == 'Activo') {
        Swal.fire({
            title: `${itemName}\n\nCantidad`,
            position: 'top',
            html: `<input type="number" id="cantidad" min="1" class="form-control" placeholder="Cantidad">`,
            confirmButtonText: 'Confirmar',
            focusConfirm: false,
            preConfirm: () => {
                const cantidad = Swal.getPopup().querySelector('#cantidad').value;
                if (!cantidad) {
                    Swal.showValidationMessage(`Por favor ingrese un cantidad`);
                }
                return {cantidad: cantidad}
            }
        }).then((result) => {
            if($('#cantidad').val() != ''){
                $.ajax({
                    type: 'POST',
                    url: "funciones/funciones.php",
                    data: {producto: producto, tipo: tipo, cantidad: result.value.cantidad, accion: 'AgregarProducto'},
                    success: function (rs) {
                        rs = JSON.parse(rs);
                        if (rs.status == 'success') {
                            Swal.fire({
                                position: 'top-center',
                                icon: 'success',
                                title: 'Producto agregado al carrito',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            onload();
                        } else {
                            alert(rs.message);
                        }

                    }
                });
            }
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Lo sentimos pero el producto no se pudo agregar al carrito debido a que esta agotado',
        })
    }
});

$(document).on('click', '.cart-item-close', function () {
    $.ajax({
        type: 'POST',
        url: "funciones/funciones.php",
        data: {codigo: $(this).attr("delete"), accion: 'QuitarProducto'}
    }).done(function () {
        onload();
    });
});

$(document).on('click', '.order-suggested', function () {
    $.ajax({
        type: 'POST',
        url: "app/ajax/funciones.php",
        data: {accion: 'PedidoSugerido'}
    }).done(function () {
        $('.cart-item-list').html(''); onload();
    });
});

$(document).on('click', '.actionOrder', function () {
    var error = false;
    if ($('#identificacion').val() == '') {
        alert('EL campo de identificacion no puede ser vacio');
        error = true;
    } else if ($('#nombres').val() == '') {
        alert('EL campo de nombres no puede ser vacio');
        error = true;
    } else if ($('#apellidos').val() == '') {
        alert('EL campo de apellidos no puede ser vacio');
        error = true;
    } else if ($('#direccion').val() == '') {
        alert('EL campo de direccion no puede ser vacio');
        error = true;
    } else if ($('#celular').val() == '') {
        alert('EL campo de celular no puede ser vacio');
        error = true;
    } else if ($('#numItems').text() == 0) {
        alert('Error al pasar el pedido debido a que el carrito se encuentra vacio');
        error = true;
    }
    if (error == false) {
        $.ajax({
            type: 'POST',
            url: "funciones/funciones.php",
            data: {
                identificacionCliente: $('#identificacion').val(),
                nombres: $('#nombres').val(),
                apellidos: $('#apellidos').val(),
                direccion: $('#direccion').val(),
                celular: $('#celular').val(),
                numItems: $('#numItems').text(),
                numProductos: $('#numProduct').text(),
                total: $('#sales').attr("sales"),
                observacion: $('#observacion').val(),
                accion: 'Order'
            }
        }).done(function (datos) {
            datos = JSON.parse(datos);
            if (datos.status === 'success') {
                alert(datos.mensaje);
                window.location = 'listing.php';
            } else {
                alert(datos.mensaje);
            }

        }).fail(function (jqXHR, textStatus) {
            console.log('jqXHR: ' + jqXHR + ' - Status: ' + textStatus);
            alert('Lo sentimos ocurrio un problema y no se pudo guardar el pedido');
        });
    }
});

$(document).on('click keyup', '.counter-plus, .counter-minus, .counter-value', function (e) {
    var fila = $(this);
    var sumPrice = 0;
    $.ajax({
        type: 'POST',
        url: "funciones/funciones.php",
        data: {accion: 'ModificarProducto', codigo: $(this).closest('div').find(".counter-value").attr('sku'), cantidad: $(this).closest('div').find(".counter-value").val()}
    }).done(function (rs) {
        console.log(rs);
        rs = JSON.parse(rs);
        if(rs.status !== 'error'){
            var price = fila.closest('div').find(".counter-value").attr('price');
            var count = fila.closest('div').find(".counter-value").val();
            fila.closest('.cart-item').find("#sales").text(formatoMoneda.format(price * count));
            fila.closest('.cart-item').find(".total").text(formatoMoneda.format(price * count));
            $('.total').each(function () {
                sumPrice += parseInt($.trim($(this).text().replace('$', '').replace('.', '')));
            });
            $('#sales').text(formatoMoneda.format(sumPrice));
        } else {
            alert(rs.message);
            fila.closest('div').find(".counter-value").val(rs.max);
        }
    });
});

$(".icon-x").click(function () {
    $(this).closest('.cart-item').remove();
    $.ajax({
        type: 'POST',
        url: "funciones/funciones.php",
        data: {accion: 'QuitarProducto', codigo: $(this).closest('.cart-item').find(".counter-value").attr('sku')}
    }).done(function () {
        alert('Producto eliminado del carrito');
        var sumPrice = 0;
        $('.total').each(function () {
            sumPrice += parseInt($.trim($(this).text().replace('$', '').replace('.', '')));
        });
        $('#sales').text(formatoMoneda.format(sumPrice));
    });
});

$('#formulario').submit(function (e) {
    e.preventDefault();
    var contrasenaActual = $('#contraseñaActual').val();
    var contrasenaNueva = $('#contraseñaNueva').val();
    var confirmarContraseña = $('#confirmarContraseña').val();
    if (contrasenaNueva !== confirmarContraseña) {
        $('.mensaje').html('<p class="text-center" style="color:red;">Las contraseñas no coinciden</p>');
        $('.mensaje').slideDown();
        return false;
    }
    $.ajax({
        url: 'funciones/funciones.php',
        type: 'POST',
        data: {accion: 'Pass', contrasenaActual: contrasenaActual, contrasenaNueva: contrasenaNueva},
        success: function (datos) {
            datos = JSON.parse(datos);
            if (datos.status == 'success') {
                $('.mensaje').html('<p class="text-center" style="color:green;">' + datos.mensaje + '</p>');
                $("#formulario").trigger("reset");
            } else {
                $('.mensaje').html('<p class="text-center" style="color:green;">' + datos.mensaje + '</p>');
            }
            $('.mensaje').slideDown();
            setTimeout(function () {
                $(".mensaje").fadeOut(1500);
            }, 3000);
        }
    });
});

$('#optionSelect').change(function() {
    switch ($(this).val()) {
        case '1': window.location.href = 'listing.php'; break;
        case '2': window.location.href = 'login.php'; break;
        default: break;
    }
});

$(document).on('click', '.imgProducto', function () {
    var producto = $(this).attr("producto");
    $.ajax({
        type: 'POST',
        url: "funciones/funciones.php",
        data: {codigo: producto, accion: 'FichaTecnica'}
    }).done(function (datos) {
        datos = JSON.parse(datos);
        $('#imagenFichaTecnica').attr('src', 'app/inventario/fotos/' + datos.foto);
        $('#datosFichaTecnica').html('<h5>' + datos.descripcion + '</h5><p>' + datos.fichaTecnica + '</p>');
    });
});
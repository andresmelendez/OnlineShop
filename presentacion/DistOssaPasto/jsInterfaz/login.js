/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {
    $('#formulario').submit(function (e) {
        e.preventDefault();
        var usuario = $.trim($("#usuario").val());
        var clave = $.trim($("#clave").val());
        $.ajax({
            url: "app/validar.php",
            type: "POST",
            data: {usuario: usuario, clave: clave},
            success: function (datos) {
                if (datos != "") {
                    datos = JSON.parse(datos); 
                    if(datos.status === 'success') {
                        window.location.href = datos.redireccion;
                    } else if (datos.status === 'warning') {
                        $('#mensaje').html(datos.mensaje);
                    } else {
                        $('#mensaje').html('Usuario y/o contraseña incorrecta');
                    }
                }
            }
        });
    });
});

cargarCiudad();
function cargarCiudad(codigoCiudad) {
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: "app/clientes/clientesAcciones.php?accion=SelectCiudad",
            data: {predeterminado: codigoCiudad},
            success: function (datos) {
                $('#codigoCiudad').html(datos).fadeIn();
            }
        });
    });
}

$(document).ready(function () {
    $('#formularioRegstrarse').submit(function (e) {
        e.preventDefault();
        var accion = 'Adicionar';
        var identificacion = $.trim($('#identificacion').val());
        var nombres = $.trim($('#nombres').val());
        var apellidos = $.trim($('#apellidos').val());
        var razonSocial = $.trim($('#razonSocial').val());
        var telefono = $.trim($('#telefono').val());
        var celular = $.trim($('#celular').val());
        var email = $.trim($('#email').val());
        var direccion = $.trim($('#direccion').val());
        var barrio = $.trim($('#barrio').val());
        var clave = $.trim($('#contraseña').val());
        var tipo = '2';
        var tipoNegocio = $.trim($('#tipoNegocio').val());
        var tipoPrecios = '0';
        var codigoCiudad = $.trim($('#codigoCiudad').val());
        var condiciones = $("#agree").is(":checked");
        if (condiciones) {
            $.ajax({
                url: "app/clientes/clientesAcciones.php",
                type: "POST",
                datatype: "json",
                data: {
                    identificacion: identificacion,
                    nombres: nombres,
                    apellidos: apellidos,
                    razonSocial: razonSocial,
                    telefono: telefono,
                    celular: celular,
                    email: email,
                    direccion: direccion,
                    barrio: barrio,
                    clave: clave,
                    tipo: tipo,
                    tipoNegocio: tipoNegocio,
                    tipoPrecios: tipoPrecios,
                    codigoCiudad: codigoCiudad,
                    accion: accion
                },
                success: function (data) {
                    $('#mensaje').html('Usuario registrado correctamente.<br>Su registro se envió correctamente. Le informaremos a su whats app en el moemnto que esté habilitado para ingresar a nuestra plataforma, esto puede tardar maximo 24 horas, si este mensaje no le llega por favor escribir al whats app 322 444 94 44.');
                    $("#formularioRegstrarse").trigger("reset");
                }
            });
            $('.container-signup').hide();
            $('#identificacion').removeClass('filled');
            $('#nombres').removeClass('filled');
            $('#apellidos').removeClass('filled');
            $('#razonSocial').removeClass('filled');
            $('#telefono').removeClass('filled');
            $('#celular').removeClass('filled');
            $('#email').removeClass('filled');
            $('#direccion').removeClass('filled');
            $('#contraseña').removeClass('filled');
            $('#tipoNegocio').removeClass('filled');
            $('#codigoCiudad').removeClass('filled');
            $('#terminos').html('');
            $('.container-login').show();
        } else {
            $('#terminos').html('Su registro no se ha enviado por favor de click en el recuadro para aceptar los términos y condiciones');
        }
    });
});
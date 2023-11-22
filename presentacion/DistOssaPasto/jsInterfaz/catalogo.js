/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


cargarTabla();
function cargarTabla(filtro = "", pagina = 1, registrosXPagina = 12) {
    $('#lista').html('<tr class="odd"><td valign="top" colspan="10" style="width:100%;text-align:center;padding-top: 100px;margin-top:40px;height:290px;">Cargando...</td></tr>');
    var accion = 'Listar';
    $.ajax({
        type: 'POST',
        url: "catalogoAcciones.php?accion=Listar",
        data: {
            accion: accion,
            filtro: filtro,
            pagina: pagina,
            registrosXPagina: registrosXPagina,
            tipoPrecios: document.getElementById('tipoPrecios').value
        },
        success: function (datos) {
            if (datos != null) {
                datos = datos.split('|');
                $('#lista').fadeIn(2000).html(datos[0]);
                bloquear();
            }
        }
    });
}

$("#registrosXPagina").change(function () {
    var pagina = 1;
    var registrosXPagina = $('#registrosXPagina').val();
    var filtro = $('#filtro').val();
    cargarTabla(filtro, pagina, registrosXPagina);
});

function bloquear() {
    if (document.getElementById('pagina').max == $("#pagina").val()) {
        $("#siguiente").removeAttr('onclick');
        $("#ultimo").removeAttr('onclick');
    }

    if ($("#pagina").val() == 1) {
        $("#primero").removeAttr('onclick');
        $("#anterior").removeAttr('onclick');
    }
}

function actualizarPagina(pagina) {
    var registrosXPagina = $('#registrosXPagina').val();
    var filtro = $('#filtro').val();
    cargarTabla(filtro, pagina, registrosXPagina);
}

$('#buscar').keyup(function () {
    var filtro = "descripcion like '%" + $('#buscar').val() + "%' or codigo like '%" + $('#buscar').val() + "%' or grupo.nombre like '%" + $('#buscar').val() + "%'";
    var registrosXPagina = $('#registrosXPagina').val();
    var pagina = 1;
    cargarTabla(filtro, pagina, registrosXPagina);
});

function agregarProducto(codigo, precio) {
    var cantidad = $('#cantidad' + codigo).val();
    var descuento = $('#descuento' + codigo).val();
    $.ajax({
        url: "catalogoAcciones.php?accion=AgregarProducto",
        type: "POST",
        datatype: "json",
        data: {codigo: codigo, cantidad: cantidad, descuento: descuento, precio: precio},
        success: function (datos) {
            alert(datos);
        }
    });
}
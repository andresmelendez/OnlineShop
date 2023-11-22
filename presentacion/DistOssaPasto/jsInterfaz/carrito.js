/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


cargarTabla();
function cargarTabla() {
    $.ajax({
        type: 'POST',
        url: "catalogoAcciones.php?accion=Carrito",
        data: {
        },
        success: function (datos) {
            if (datos != null) {
                datos = datos.split('||');
                var datos1 = datos[1].split('|');
                if (datos[0] != '')
                    document.getElementById('lista').innerHTML = datos[0];
                else
                    document.getElementById('lista').innerHTML = '';
                document.getElementById('valorFinal').innerHTML = new Intl.NumberFormat().format(datos1[0]);
                document.getElementById('total').value = datos1[0];
                document.getElementById('numProductos').value = datos1[1];
                document.getElementById('numItems').value = datos1[2];
            }
        }
    });
}

$(document).on("click", ".btnQuitar", function () {
    var codigo = $(this).closest('tr').find('td:eq(0)').text();
    $.ajax({
        type: 'POST',
        url: "catalogoAcciones.php?accion=QuitarProducto",
        data: {
            codigo: codigo
        },
        success: function (datos) {
            cargarTabla();
        }
    });
});

$(document).on("click", ".vaciarCarrito", function () {
    var respuesta = confirm("¿Esta seguro de quitar todos los productos del carrito?");
    if (respuesta) {
        $.ajax({
            type: 'POST',
            url: "catalogoAcciones.php?accion=VaciarCarrito",
            data: {
            },
            success: function (datos) {
                cargarTabla();
            }
        });
    }
});

$('#formularioDatos').submit(function (e) {
    e.preventDefault();
    if (!verificar()) {
        $.ajax({
            url: "catalogoAcciones.php?accion=Registrar",
            type: "POST",
            datatype: "json",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (datos) {
                alert('Pedido enviado');
                window.location.href = 'catalogo.php';
            }
        });
    }
});

function verificar() {
    var estado = false;
    var tabla = document.getElementById('tablaProductosAgregados');
    if (tabla.rows.length < 2) {
        alert('No agregado ningun producto a la lista');
        estado = true;
    }
    return estado;
}

function datosCalculados(fila) {
    var codigo = fila.closest('tr').find(".codigo").val();
    var cantidad = fila.closest('tr').find(".cantidad").val();
    var precioUnitario = fila.closest('tr').find(".precioUnitario").val();
    fila.closest('tr').find(".totalPedido").text(cantidad * precioUnitario);
    $.ajax({
        type: 'POST',
        url: "catalogoAcciones.php?accion=ModificarProducto",
        data: {
            codigo: codigo,
            cantidad: cantidad
        },
        success: function (datos) {
            actualizar();
        }
    });
}

function actualizar(){
    var total = 0;
    var numProductos = 0;
    $('.totalPedido').each(function () {
        total += parseInt($(this).text());
    });
    $('.cantidad').each(function () {
        numProductos += parseInt($(this).val());
    });
    $('#valorFinal').text(new Intl.NumberFormat().format(total));
    $('#total').val(total);
    $('#numProductos').val(numProductos);
}
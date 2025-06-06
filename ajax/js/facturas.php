<script>
var row = 0;

$(document).ready(function() {
    getCajero();
    getConsumidorFinal();
    getConsultarAperturaCaja();
    validarAperturaCajaUsuario();
    getEstadoFactura();
    getBanco();
    getTotalFacturasDisponibles();
    getReporteCotizacion();
    getReporteFactura();
    getEstadoFacturaCredito();
    getCollaboradoresModalPagoFacturas();
    getFacturador();
    getVendedores();
    getClientesFacturasCXC(); 
});

function getClientesFacturasCXC() {
    var url = '<?php echo SERVERURL; ?>core/getClientesCXC.php';

    $.ajax({
        type: "POST",
        url: url,
        async: true,
        success: function(data) {
            $('#formulario_busqueda_cuentas_cobrar_clientes #cobrar_clientes').html("");
            $('#formulario_busqueda_cuentas_cobrar_clientes #cobrar_clientes').html(data);
            $('#formulario_busqueda_cuentas_cobrar_clientes #cobrar_clientes').selectpicker('refresh');
        }
    });
}

function getFacturador() {
    var url = '<?php echo SERVERURL; ?>core/getFacturador.php';

    $.ajax({
        type: "POST",
        url: url,
        async: true,
        success: function(data) {
            $('#formulario_bill #facturador').html("");
            $('#formulario_bill #facturador').html(data);
            $('#formulario_bill #facturador').selectpicker('refresh');
        }
    });
}

function getVendedores() {
    var url = '<?php echo SERVERURL; ?>core/getColaboradores.php';

    $.ajax({
        type: "POST",
        url: url,
        async: true,
        success: function(data) {

            $('#formulario_bill #vendedor').html("");
            $('#formulario_bill #vendedor').html(data);
            $('#formulario_bill #vendedor').selectpicker('refresh');
        }
    });
}

//INICIO CONSULTA FACTURAS BORRADOR
$(document).ready(function() {
    $("#modal_buscar_bill_draft").on('shown.bs.modal', function() {
        $(this).find('#formulario_bill_draft #buscar').focus();
    });
});
//FIN CONSULTA FACTURAS BORRADOR

//INIICO CONSULTA DE FACTURAS
$(document).ready(function() {
    $("#modal_buscar_bill").on('shown.bs.modal', function() {
        $(this).find('#formulario_bill #buscar').focus();
    });
});

$('#formulario_bill #tipo_factura_reporte').on("change", function(e) {
    listar_busqueda_bill();
});

$('#formulario_bill #facturador').on("change", function(e) {
    listar_busqueda_bill();
});

$('#formulario_bill #vendedor').on("change", function(e) {
    listar_busqueda_bill();
});

$('#formulario_bill #fechai').on("change", function(e) {
    listar_busqueda_bill();
});

$('#formulario_bill #fechaf').on("change", function(e) {
    listar_busqueda_bill();
});
//FIN CONSULTA DE FACTURAS

//INICIO CUENTAS POR COBRAR CLIENTES
$('#formulario_busqueda_cuentas_cobrar_clientes #cobrar_clientes_estado').on("change", function(e) {
    listar_busqueda_bill();
});

$('#formulario_busqueda_cuentas_cobrar_clientes #cobrar_clientes').on("change", function(e) {
    listar_busqueda_cuentas_por_cobrar_clientes();
});

$('#formulario_busqueda_cuentas_cobrar_clientes #fechai').on("change", function(e) {
    listar_busqueda_cuentas_por_cobrar_clientes();
});

$('#formulario_busqueda_cuentas_cobrar_clientes #fechaf').on("change", function(e) {
    listar_busqueda_cuentas_por_cobrar_clientes();
});

//FIN CUENTAS POR COBRAR CLIENTES

function resetRow() {
    $("#invoice-form #bill_row").val(0);
}

$('#formulario_busqueda_productos_facturacion #almacen').on('change', function() {
    listar_productos_factura_buscar();
});

//INICIO BUSQUEDA FROMULARIO CLIENTES FACTURACION
$("#invoice-form #add_cliente").on("click", function(e) {
    e.preventDefault();
    searchCustomersBill();
});

function searchCustomersBill() {
    listar_clientes_factura_buscar();
    $('#modal_buscar_clientes_facturacion').modal({
        show: true,
        keyboard: false,
        backdrop: 'static'
    });
}

$("#invoice-form #btn_apertura").on("click", function(e) {
    e.preventDefault();
    formAperturaBill();
});

function formAperturaBill() {
    $('#formAperturaCaja #proceso_aperturaCaja').val("Aperturar Caja");
    $('#open_caja').show();
    $('#close_caja').hide();
    $('#formAperturaCaja #monto_apertura_grupo').show();

    $('#formAperturaCaja').attr({
        'data-form': 'save'
    });
    $('#formAperturaCaja').attr({
        'action': '<?php echo SERVERURL; ?>ajax/addAperturaCajaAjax.php'
    });

    $('#modal_apertura_caja').modal({
        show: true,
        keyboard: false,
        backdrop: 'static'
    });
}

$('#reg_factura').on('click', function(e) {
    $('#invoice-form').attr({
        'data-form': 'save'
    });
    $('#invoice-form').attr({
        'action': '<?php echo SERVERURL; ?>ajax/addFacturaAjax.php'
    });
    $("#invoice-form").submit();
});

$("#guardar_factura").on("click", function(e) {
    $('#invoice-form').attr({
        'data-form': 'save'
    });
    $('#invoice-form').attr({
        'action': '<?php echo SERVERURL; ?>ajax/addFacturaOpenAjax.php'
    });
    $("#invoice-form").submit();
});


$("#invoice-form #btn_cierre").on("click", function(e) {
    e.preventDefault();
    formCierreBill();
});

function formCierreBill() {
    $('#formAperturaCaja #proceso_aperturaCaja').val("Cerrar Caja");
    $('#open_caja').hide();
    $('#close_caja').show();
    $('#formAperturaCaja #monto_apertura_grupo').hide();

    $('#formAperturaCaja').attr({
        'data-form': 'save'
    });
    $('#formAperturaCaja').attr({
        'action': '<?php echo SERVERURL; ?>ajax/addCierreCajaAjax.php'
    });

    $('#modal_apertura_caja').modal({
        show: true,
        keyboard: false,
        backdrop: 'static'
    });
}
//FIN BUSQUEDA FROMULARIO CLIENTES FACTURACION	

//INICIO INVOICES
//INICIO BUSQUEDA CLIENTES EN FACTURACION
$('#invoice-form #buscar_clientes').on('click', function(e) {
    e.preventDefault();
    listar_clientes_factura_buscar();
    $('#modal_buscar_clientes_facturacion').modal({
        show: true,
        keyboard: false,
        backdrop: 'static'
    });
});

var listar_clientes_factura_buscar = function() {
    var table_clientes_factura_buscar = $("#DatatableClientesBusquedaFactura").DataTable({
        "destroy": true,
        "ajax": {
            "method": "POST",
            "url": "<?php echo SERVERURL; ?>core/llenarDataTableClientes.php"
        },
        "columns": [{
                "defaultContent": "<button class='table_view btn btn-primary ocultar'><span class='fas fa-copy'></span></button>"
            },
            {
                "data": "cliente"
            },
            {
                "data": "rtn"
            },
            {
                "data": "telefono"
            },
            {
                "data": "correo"
            }
        ],
        "lengthMenu": lengthMenu,
        "stateSave": true,
        "bDestroy": true,
        "language": idioma_español,
        "dom": dom,
        "buttons": [{
                text: '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
                titleAttr: 'Actualizar Clientes',
                className: 'table_actualizar btn btn-secondary ocultar',
                action: function() {
                    listar_clientes_factura_buscar();
                }
            },
            {
                text: '<i class="fas fas fa-plus fa-lg crear"></i> Ingresar',
                titleAttr: 'Agregar Clientes',
                className: 'table_crear btn btn-primary ocultar',
                action: function() {
                    modal_clientes();
                }
            }
        ],
        "drawCallback": function(settings) {
            getPermisosTipoUsuarioAccesosTable(getPrivilegioTipoUsuario());
        }
    });
    table_clientes_factura_buscar.search('').draw();
    $('#buscar').focus();

    view_clientes_busqueda_factura_dataTable("#DatatableClientesBusquedaFactura tbody",
        table_clientes_factura_buscar);
}

var view_clientes_busqueda_factura_dataTable = function(tbody, table) {
    $(tbody).off("click", "button.table_view");
    $(tbody).on("click", "button.table_view", function(e) {
        e.preventDefault();
        var data = table.row($(this).parents("tr")).data();
        $('#invoice-form #cliente_id').val(data.clientes_id);
        $('#invoice-form #cliente').val(data.cliente);
        $('#invoice-form #client-customers-bill').html("<b>Cliente:</b> " + data.cliente);
        $('#invoice-form #rtn-customers-bill').html("<b>RTN:</b> " + data.rtn);
        $('#modal_buscar_clientes_facturacion').modal('hide');
    });
}
//FIN BUSQUEDA CLIENTES EN FACTURACION

//INICIO BUSQUEDA COLABORADORES EN FACTURACION
function serchColaboradoresBill() {
    listar_colaboradores_buscar_factura();
    $('#modal_buscar_colaboradores_facturacion').modal({
        show: true,
        keyboard: false,
        backdrop: 'static'
    });
}

$('#invoice-form #add_vendedor').on('click', function(e) {
    e.preventDefault();
    serchColaboradoresBill();
});

var listar_colaboradores_buscar_factura = function() {
    var table_colaboradores_buscar_factura = $("#DatatableColaboradoresBusquedaFactura").DataTable({
        "destroy": true,
        "ajax": {
            "method": "POST",
            "url": "<?php echo SERVERURL; ?>core/llenarDataTableColaboradoresFacturas.php"
        },
        "columns": [{
                "defaultContent": "<button class='table_view btn btn-primary ocultar'><span class='fas fa-copy'></span></button>"
            },
            {
                "data": "colaborador"
            },
            {
                "data": "identidad"
            },
            {
                "data": "telefono"
            }
        ],
        "lengthMenu": lengthMenu,
        "stateSave": true,
        "bDestroy": true,
        "language": idioma_español,
        "dom": dom,
        "columnDefs": [{
                width: "25%",
                targets: 0
            },
            {
                width: "25%",
                targets: 1
            },
            {
                width: "25%",
                targets: 2
            },
            {
                width: "25%",
                targets: 3
            }
        ],
        "buttons": [{
                text: '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
                titleAttr: 'Actualizar Productos',
                className: 'table_actualizar btn btn-secondary ocultar',
                action: function() {
                    listar_colaboradores_buscar_factura();
                }
            },
            {
                text: '<i class="fas fas fa-plus fa-lg crear"></i> Ingresar',
                titleAttr: 'Agregar Productos',
                className: 'table_crear btn btn-primary ocultar',
                action: function() {
                    modal_colaboradores();
                }
            }
        ],
        "drawCallback": function(settings) {
            getPermisosTipoUsuarioAccesosTable(getPrivilegioTipoUsuario());
        }
    });
    table_colaboradores_buscar_factura.search('').draw();
    $('#buscar').focus();

    view_colaboradores_busqueda_factura_dataTable("#DatatableColaboradoresBusquedaFactura tbody",
        table_colaboradores_buscar_factura);
}

var view_colaboradores_busqueda_factura_dataTable = function(tbody, table) {
    $(tbody).off("click", "button.table_view");
    $(tbody).on("click", "button.table_view", function(e) {
        e.preventDefault();
        var data = table.row($(this).parents("tr")).data();
        $('#invoice-form #colaborador_id').val(data.colaborador_id);
        $('#invoice-form #colaborador').val(data.colaborador);
        $('#invoice-form #colaborador').val(data.colaborador);
        $('#invoice-form #vendedor-customers-bill').html("<b>Vendedor:</b> " + data.colaborador);
        $('#modal_buscar_colaboradores_facturacion').modal('hide');
    });
}
//FIN BUSQUEDA COLABORADORES EN FACTURACION

//INICIO BUSQUEDA PRODUCTOS FACTURA
$(document).ready(function() {
    $("#invoice-form #invoiceItem").on('click', '.buscar_productos', function(e) {
        e.preventDefault();
        listar_productos_factura_buscar();
        var row_index = $(this).closest("tr").index();
        var col_index = $(this).closest("td").index();

        $('#formulario_busqueda_productos_facturacion #row').val(row_index);
        $('#formulario_busqueda_productos_facturacion #col').val(col_index);
        $('#modal_buscar_productos_facturacion').modal({
            show: true,
            keyboard: false,
            backdrop: 'static'
        });
    });
});

var listar_productos_factura_buscar = function() {
    var bodega = $("#formulario_busqueda_productos_facturacion #almacen").val() === "" ? 1 : $(
        "#formulario_busqueda_productos_facturacion #almacen").val();

    var table_productos_factura_buscar = $("#DatatableProductosBusquedaFactura").DataTable({
        "destroy": true,
        "ajax": {
            "method": "POST",
            "url": "<?php echo SERVERURL; ?>core/llenarDataTableProductosFacturas.php",
            "data": {
                "bodega": bodega
            }
        },
        "columns": [{
                "defaultContent": "<button class='table_view btn btn-primary ocultar'><span class='fas fa-cart-plus fa-lg'></span></button>"
            },
            {
                "data": "image",
                "render": function(data, type, row, meta) {
                    var defaultImageUrl = '<?php echo SERVERURL; ?>vistas/plantilla/img/products/image_preview.png';
                    var imageUrl = data ? '<?php echo SERVERURL; ?>vistas/plantilla/img/products/' + data : defaultImageUrl;

                    var img = new Image();

                    img.onload = function() {
                        $('img.table-image', meta.settings.oInstance.api().row(meta.row).node()).attr('src', imageUrl);
                    };

                    img.onerror = function() {
                        $('img.table-image', meta.settings.oInstance.api().row(meta.row).node()).attr('src', defaultImageUrl);
                    };

                    img.src = imageUrl;

                    var altText = data ? data : 'Image Preview';

                    return '<img class="table-image" src="' + imageUrl + '" alt="' + altText + '" height="100px" width="100px"/>';
                }
            },
            {
                "data": "barCode"
            },
            {
                "data": "nombre"
            },
            {
                "data": "cantidad",
                render: function(data, type) {
                    if (data == null) {
                        data = 0;
                    }

                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, '')
                        .display(data);

                    if (type === 'display') {
                        let color = 'green';
                        if (data < 0) {
                            color = 'red';
                        }

                        return '<span style="color:' + color + '">' + number + '</span>';
                    }

                    return number;
                },
            },
            {
                "data": "medida"
            },
            {
                "data": "tipo_producto_nombre"
            },
            {
                "data": "precio_venta",
                render: function(data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, 'L ')
                        .display(data);

                    if (type === 'display') {
                        let color = 'green';
                        if (data < 0) {
                            color = 'red';
                        }

                        return '<span style="color:' + color + '">' + number + '</span>';
                    }

                    return number;
                },
            },
            {
                "data": "almacen"
            }
        ],
        "lengthMenu": lengthMenu,
        "stateSave": true,
        "bDestroy": true,
        "responsive": true,
        "language": idioma_español,
        "dom": dom,
        "columnDefs": [{
                width: "2%",
                targets: 0
            },
            {
                width: "17%",
                targets: 1
            },
            {
                width: "17%",
                targets: 2
            },
            {
                width: "10%",
                targets: 3
            },
            {
                width: "10%",
                targets: 4
            },
            {
                width: "10%",
                targets: 5
            },
            {
                width: "12%",
                targets: 6
            },
            {
                width: "12%",
                targets: 7
            },
            {
                width: "0%",
                targets: 8,
                visible: false
            }
        ],
        "buttons": [{
                text: '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
                titleAttr: 'Actualizar Productos',
                className: 'table_actualizar btn btn-secondary ocultar',
                action: function() {
                    listar_productos_cotizacion_buscar();
                }
            },
            {
                text: '<i class="fas fas fa-plus fa-lg crear"></i> Ingresar',
                titleAttr: 'Agregar Productos',
                className: 'table_crear btn btn-primary ocultar',
                action: function() {
                    modal_productos();
                }
            }
        ],
        "drawCallback": function(settings) {
            getPermisosTipoUsuarioAccesosTable(getPrivilegioTipoUsuario());
        }
    });

    table_productos_factura_buscar.search('').draw();
    $('#buscar').focus();

    view_productos_busqueda_factura_dataTable("#DatatableProductosBusquedaFactura tbody",
        table_productos_factura_buscar);
}

var view_productos_busqueda_factura_dataTable = function(tbody, table) {
    $(tbody).off("click", "button.table_view, td img");
    $(tbody).on("click", "button.table_view, td img", function(e) {
        e.preventDefault();

        row = $("#invoice-form #bill_row").val();

        if (getConsultarAperturaCaja() == 2) {
            swal({
                title: "Error",
                text: "Lo sentimos debe aperturar la caja antes de continuar",
                icon: "error",
                dangerMode: true,
                closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera 
            });
        } else {
            getTotalFacturasDisponibles();

            if ($("#invoice-form #cliente_id").val() != "" && $("#invoice-form #cliente").val() != "" && $(
                    "#invoice-form #colaborador_id").val() != "" && $("#invoice-form #colaborador").val() !=
                "") {
                var data = table.row($(this).parents("tr")).data();
                var facturar_cero = facturarEnCeroAlmacen(data.almacen_id);

                if (data.tipo_producto_id !== "2") {
                    if (data.almacen_id === null || data.almacen_id === "") {
                        swal({
                            title: "Error",
                            content: {
                                element: "span",
                                attributes: {
                                    innerHTML: "Lo sentimos, el producto no está asignado a una bodega. Por favor, <a href='<?php echo SERVERURL; ?>inventario/' style='color: blue; text-decoration: none;' onmouseover='this.style.color=`purple`' onmouseout='this.style.color=`blue`' onmousedown='this.style.color=`purple`' target='_blank'>ingrese el movimiento</a> de este registro antes de continuar."
                                }
                            },
                            icon: "warning",
                            buttons: {
                                confirm: {
                                    text: "¡Cerrar el mensaje!",
                                    closeModal: false
                                }
                            },
                            dangerMode: true,
                            closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                            closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera 
                        }).then((willConfirm) => {
                            if (willConfirm) {
                                sendMultipleSMSUnDiaAntes($('#form_agenda_main #fecha').val(), $('#form_agenda_main #servicio').val());
                            }
                        });
                        return false;
                    }
                }

                if (data.cantidad <= 0) {
                    if (facturar_cero == 'false' || facturar_cero == false) {
                        swal({
                            title: "Error",
                            text: "No se puede facturar este producto inventario en cero",
                            icon: "error",
                            dangerMode: true,
                            closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                            closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera 
                        });
                        return false
                    }
                }

                $('#invoice-form #invoiceItem #productos_id_' + row).val(data.productos_id);
                $('#invoice-form #invoiceItem #bar-code-id_' + row).val(data.barCode);
                $('#invoice-form #invoiceItem #productName_' + row).val(data.nombre);
                $('#invoice-form #invoiceItem #quantity_' + row).val(1);
                $('#invoice-form #invoiceItem #quantity_' + row).focus();
                $('#invoice-form #invoiceItem #price_' + row).val(data.precio_venta);
                $('#invoice-form #invoiceItem #discount_' + row).val(0);
                $('#invoice-form #invoiceItem #isv_' + row).val(data.impuesto_venta);
                $('#invoice-form #invoiceItem #precio_mayoreo_' + row).val(data.precio_mayoreo);
                $('#invoice-form #invoiceItem #cantidad_mayoreo_' + row).val(data.cantidad_mayoreo);
                $('#invoice-form #invoiceItem #medida_' + row).val(data.medida);
                $('#invoice-form #invoiceItem #bodega_' + row).val(data.almacen_id);

                $('#invoice-form #invoiceItem #precio_real_' + row).val(data.precio_venta);

                var isv = 0;
                var isv_total = 0;
                var porcentaje_isv = 0;
                var porcentaje_calculo = 0;
                var isv_neto = 0;

                if (data.impuesto_venta == 1) {
                    porcentaje_isv = parseFloat(getPorcentajeISV("Facturas") / 100);
                    if ($('#invoice-form #taxAmount').val() == "" || $('#invoice-form #taxAmount').val() ==
                        0) {
                        porcentaje_calculo = (parseFloat(data.precio_venta) * porcentaje_isv).toFixed(2);
                        isv_neto = porcentaje_calculo;
                        $('#invoice-form #taxAmount').val(porcentaje_calculo);
                        $('#invoice-form #invoiceItem #valor_isv_' + row).val(porcentaje_calculo);
                    } else {
                        isv_total = parseFloat($('#invoice-form #taxAmount').val());
                        porcentaje_calculo = (parseFloat(data.precio_venta) * porcentaje_isv).toFixed(2);
                        isv_neto = parseFloat(isv_total) + parseFloat(porcentaje_calculo);
                        $('#invoice-form #taxAmount').val(isv_neto);
                        $('#invoice-form #invoiceItem #valor_isv_' + row).val(porcentaje_calculo);
                    }
                }

                calculateTotalFacturas();
                addRowFacturas();

                if (row > 0) {
                    var icon_search = row - 1;
                }

                $("#invoice-form #invoiceItem #icon-search-bar_" + row).hide();
                $("#invoice-form #invoiceItem #icon-search-bar_" + icon_search).hide();

                $('#modal_buscar_productos_facturacion').modal('hide');

                row++;
            } else {
                swal({
                    title: "Error",
                    text: "Lo sentimos no se puede seleccionar un producto, por favor antes de continuar, verifique que los siguientes campos: clientes, vendedor no se encuentren vacíos",
                    icon: "error",
                    dangerMode: true,
                    closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                    closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera 
                });
            }
        }

        e.preventDefault();
    });
}
//FIN BUSQUEDA PRODUCTOS FACTURA

$(document).ready(function() {
    $("#invoice-form #invoiceItem").on('blur', '.buscar_cantidad', function() {
        var row_index = $(this).closest("tr").index();
        var col_index = $(this).closest("td").index();

        var impuesto_venta = parseFloat($('#invoice-form #invoiceItem #isv_' + row_index).val());
        var cantidad = parseFloat($('#invoice-form #invoiceItem #quantity_' + row_index).val());

        //EVALUAMOS ANTES QUE LA CANTIDAD DE MAYOREO Y EL PRECIO DE MAYOREO NO ESTEN VACIOS
        if (parseFloat($('#invoice-form #invoiceItem #cantidad_mayoreo_' + row_index).val()) != 0 &&
            parseFloat($('#invoice-form #invoiceItem #precio_mayoreo_' + row_index).val()) != 0) {
            //SI LA CANTIDAD A VENDER ES MAYOR O IGUAL A LA CANTIDAD DE MAYOREO PERMITIDA, SE CAMBIA EL PRECIO POR EL PRECIO DE MAYOREO
            if (parseFloat($('#invoice-form #invoiceItem #quantity_' + row_index).val()) >= parseFloat(
                    $('#invoice-form #invoiceItem #cantidad_mayoreo_' + row_index).val())) {
                $('#invoice-form #invoiceItem #price_' + row_index).val($(
                    '#invoice-form #invoiceItem #precio_mayoreo_' + row_index).val());
            } else {
                $('#invoice-form #invoiceItem #price_' + row_index).val($(
                    '#invoice-form #invoiceItem #precio_real_' + row_index).val());
            }
        } else {
            $('#invoice-form #invoiceItem #price_' + row_index).val($(
                '#invoice-form #invoiceItem #precio_real_' + row_index).val());
        }

        var precio = parseFloat($('#invoice-form #invoiceItem #price_' + row_index).val());
        var total = parseFloat($('#invoice-form #invoiceItem #total_' + row_index).val());
        var descuento = parseFloat($('#invoice-form #invoiceItem #discount_' + row_index).val());
        $('#invoice-form #invoiceItem #discount_' + row_index).val(descuento * cantidad);

        var isv = 0;
        var isv_total = 0;
        var porcentaje_isv = 0;
        var porcentaje_calculo = 0;
        var isv_neto = 0;

        if (impuesto_venta == 1) {
            porcentaje_isv = parseFloat(getPorcentajeISV("Facturas") / 100);
            if (total == "" || total == 0) {
                porcentaje_calculo = (parseFloat(precio) * parseFloat(cantidad) * porcentaje_isv).toFixed(2);
                isv_neto = parseFloat(porcentaje_calculo);
                $('#invoice-form #invoiceItem #valor_isv_' + row_index).val(porcentaje_calculo);
            } else {
                isv_total = parseFloat($('#invoice-form #taxAmount').val());
                porcentaje_calculo = (parseFloat(precio) * parseFloat(cantidad) * porcentaje_isv).toFixed(2);
                isv_neto = parseFloat(isv_total) + parseFloat(porcentaje_calculo);
                $('#invoice-form #invoiceItem #valor_isv_' + row_index).val(porcentaje_calculo);
            }
        }

        calculateTotalFacturas();
    });
});

$(document).ready(function() {
    $("#invoice-form #invoiceItem").on('keyup', '.buscar_cantidad', function() {
        var row_index = $(this).closest("tr").index();
        var col_index = $(this).closest("td").index();

        var impuesto_venta = parseFloat($('#invoice-form #invoiceItem #isv_' + row_index).val());
        var cantidad = parseFloat($('#invoice-form #invoiceItem #quantity_' + row_index).val());

        //EVALUAMOS ANTES QUE LA CANTIDAD DE MAYOREO Y EL PRECIO DE MAYOREO NO ESTEN VACIOS
        if (parseFloat($('#invoice-form #invoiceItem #cantidad_mayoreo_' + row_index).val()) != 0 &&
            parseFloat($('#invoice-form #invoiceItem #precio_mayoreo_' + row_index).val()) != 0) {
            //SI LA CANTIDAD A VENDER ES MAYOR O IGUAL A LA CANTIDAD DE MAYOREO PERMITIDA, SE CAMBIA EL PRECIO POR EL PRECIO DE MAYOREO
            if (parseFloat($('#invoice-form #invoiceItem #quantity_' + row_index).val()) >= parseFloat(
                    $('#invoice-form #invoiceItem #cantidad_mayoreo_' + row_index).val())) {
                $('#invoice-form #invoiceItem #price_' + row_index).val($(
                    '#invoice-form #invoiceItem #precio_mayoreo_' + row_index).val());
            } else {
                $('#invoice-form #invoiceItem #price_' + row_index).val($(
                    '#invoice-form #invoiceItem #precio_real_' + row_index).val());
            }
        } else {
            $('#invoice-form #invoiceItem #price_' + row_index).val($(
                '#invoice-form #invoiceItem #precio_real_' + row_index).val());
        }

        var precio = parseFloat($('#invoice-form #invoiceItem #price_' + row_index).val());
        var total = parseFloat($('#invoice-form #invoiceItem #total_' + row_index).val());
        var descuento = parseFloat($('#invoice-form #invoiceItem #discount_' + row_index).val());
        $('#invoice-form #invoiceItem #discount_' + row_index).val(descuento * cantidad);

        var isv = 0;
        var isv_total = 0;
        var porcentaje_isv = 0;
        var porcentaje_calculo = 0;
        var isv_neto = 0;

        if (impuesto_venta == 1) {
            porcentaje_isv = parseFloat(getPorcentajeISV("Facturas") / 100);
            if (total == "" || total == 0) {
                porcentaje_calculo = (parseFloat(precio) * parseFloat(cantidad) * porcentaje_isv).toFixed(2);
                isv_neto = parseFloat(porcentaje_calculo);
                $('#invoice-form #invoiceItem #valor_isv_' + row_index).val(porcentaje_calculo);
            } else {
                isv_total = parseFloat($('#invoice-form #taxAmount').val());
                porcentaje_calculo = (parseFloat(precio) * parseFloat(cantidad) * porcentaje_isv).toFixed(2);
                isv_neto = parseFloat(isv_total) + parseFloat(porcentaje_calculo);
                $('#invoice-form #invoiceItem #valor_isv_' + row_index).val(porcentaje_calculo);
            }
        }

        calculateTotalFacturas();
    });
});

function limpiarTablaFactura() {
    $("#invoice-form #invoiceItem > tbody").empty(); //limpia solo los registros del body
    var count = 0;
    var htmlRows = '';
    htmlRows += '<tr>';
    htmlRows += '<td><input class="itemRow" id="itemRow_' + count + '" type="checkbox"></td>';
    htmlRows += '<td><input type="hidden" name="referenciaProducto[]" id="referenciaProducto_' + count +
        '" class="form-control" placeholder="Referencia Producto Precio" autocomplete="off"><input type="hidden" name="isv[]" id="isv_' +
        count +
        '" class="form-control" placeholder="Producto ISV" autocomplete="off"><input type="hidden" name="valor_isv[]" id="valor_isv_' +
        count +
        '" class="form-control" placeholder="Valor ISV" autocomplete="off"><input type="hidden" name="facturas_detalle_id[]" id="facturas_detalle_id_' +
        count +
        '" class="form-control" placeholder="Código Producto" autocomplete="off"><input type="hidden" name="productos_id[]" id="productos_id_' +
        count +
        '" class="form-control inputfield-details1" placeholder="Código del Producto" autocomplete="off">	<div class="input-group mb-3"><div class="input-group-append"><span data-toggle="tooltip" data-placement="top" title="Búsqueda de Productos" id="icon-search-bar_' +
        count +
        '"><a data-toggle="modal" href="#" class="btn btn-link form-control buscar_productos"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg icon-color"></i></a></span><input type="text" name="bar-code-id[]" id="bar-code-id_' +
        count +
        '" class="form-control product-bar-code inputfield-details1" placeholder="Código del Producto" autocomplete="off"></div></div></td>';
    htmlRows += '<td><input type="text" name="productName[]" id="productName_' + count +
        '" readonly placeholder="Descripción del Producto" class="form-control inputfield-details1" autocomplete="off"></td>';
    htmlRows += '<td><input type="number" name="quantity[]" id="quantity_' + count +
        '" step="0.01" placeholder="Cantidad" class="buscar_cantidad form-control inputfield-details" autocomplete="off"><input type="hidden" name="cantidad_mayoreo[]" id="cantidad_mayoreo_' +
        count +
        '" step="0.01" placeholder="Cantidad Mayoreo" class="buscar_cantidad form-control inputfield-details" autocomplete="off"></td>';
    htmlRows += '<td><input type="text" name="medida[]" id="medida_' + count +
        '" readonly class="form-control buscar_medida" autocomplete="off" placeholder="Medida"><input type="hidden" name="bodega[]" id="bodega_' +
        count + '" readonly class="form-control buscar_bodega" autocomplete="off"></td>';
    htmlRows += '<td><div class="input-group mb-3"><input type="number" name="price[]" id="price_' + count +
        '" class="form-control" step="0.01" placeholder="Precio" readonly autocomplete="off"><div id="suggestions_producto_0" class="suggestions"></div><div class="input-group-append"><a data-toggle="modal" href="#" class="btn btn-outline-success"><div class="sb-nav-link-icon"></div><i class="aplicar_precio fas fa-plus fa-lg"></i></a></div></div><input type="hidden" name="pprecio_mayoreo[]" id="precio_mayoreo_' +
        count +
        '" placeholder="Precio Mayoreo" class="form-control inputfield-details" readonly autocomplete="off"><input type="hidden" name="precio_real[]" id="precio_real_' +
        count + '" placeholder="Precio Real" class="form-control inputfield-details" readonly autocomplete="off"></td>';
    htmlRows += '<td><div class="input-group mb-3"><input type="number" name="discount[]" id="discount_' + count +
        '" class="form-control" step="0.01" placeholder="Descuento" readonly autocomplete="off"><div id="suggestions_producto_0" class="suggestions"></div><div class="input-group-append"><a data-toggle="modal" href="#" class="btn btn-outline-success"><div class="sb-nav-link-icon"></div><i class="aplicar_descuento fas fa-plus fa-lg"></i></a></div></div></td>';
    htmlRows += '<td><input type="number" name="total[]" id="total_' + count +
        '" placeholder="Total" class="form-control total inputfield-details" readonly autocomplete="off" step="0.01"></td>';
    htmlRows += '</tr>';
    $('#invoiceItem').append(htmlRows);
    $("#invoice-form .tableFixHead").scrollTop($(document).height());
    $("#invoice-form #invoiceItem #bar-code-id_" + count).focus();
}

function limpiarTablaFacturaDetalles(count) {
    $("#invoice-form #invoiceItem > tbody").empty(); //limpia solo los registros del body
    var htmlRows = '';
    htmlRows += '<tr>';
    htmlRows += '<td><input class="itemRow" id="itemRow_' + count + '" type="checkbox"></td>';
    htmlRows += '<td><input type="hidden" name="referenciaProducto[]" id="referenciaProducto_' + count +
        '" class="form-control" placeholder="Referencia Producto Precio" autocomplete="off"><input type="hidden" name="isv[]" id="isv_' +
        count +
        '" class="form-control" placeholder="Producto ISV" autocomplete="off"><input type="hidden" name="valor_isv[]" id="valor_isv_' +
        count +
        '" class="form-control" placeholder="Valor ISV" autocomplete="off"><input type="hidden" name="facturas_detalle_id[]" id="facturas_detalle_id_' +
        count +
        '" class="form-control" placeholder="Código Producto" autocomplete="off"><input type="hidden" name="productos_id[]" id="productos_id_' +
        count +
        '" class="form-control inputfield-details1" placeholder="Código del Producto" autocomplete="off">	<div class="input-group mb-3"><div class="input-group-append"><span data-toggle="tooltip" data-placement="top" title="Búsqueda de Productos" id="icon-search-bar_' +
        count +
        '"><a data-toggle="modal" href="#" class="btn btn-link form-control buscar_productos"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg icon-color"></i></a></span><input type="text" name="bar-code-id[]" id="bar-code-id_' +
        count +
        '" class="form-control product-bar-code inputfield-details1" placeholder="Código del Producto" autocomplete="off"></div></div></td>';
    htmlRows += '<td><input type="text" name="productName[]" id="productName_' + count +
        '" readonly placeholder="Descripción del Producto" class="form-control inputfield-details1" autocomplete="off"></td>';
    htmlRows += '<td><input type="number" name="quantity[]" id="quantity_' + count +
        '" step="0.01" placeholder="Cantidad" class="buscar_cantidad form-control inputfield-details" autocomplete="off"><input type="hidden" name="cantidad_mayoreo[]" id="cantidad_mayoreo_' +
        count +
        '" step="0.01" placeholder="Cantidad Mayoreo" class="buscar_cantidad form-control inputfield-details" autocomplete="off"></td>';
    htmlRows += '<td><input type="text" name="medida[]" id="medida_' + count +
        '" readonly class="form-control buscar_medida" autocomplete="off" placeholder="Medida"><input type="hidden" name="bodega[]" id="bodega_' +
        count + '" readonly class="form-control buscar_bodega" autocomplete="off"></td>';
    htmlRows += '<td><div class="input-group mb-3"><input type="number" name="price[]" id="price_' + count +
        '" class="form-control" step="0.01" placeholder="Precio" readonly autocomplete="off"><div id="suggestions_producto_0" class="suggestions"></div><div class="input-group-append"><a data-toggle="modal" href="#" class="btn btn-outline-success"><div class="sb-nav-link-icon"></div><i class="aplicar_precio fas fa-plus fa-lg"></i></a></div></div><input type="hidden" name="pprecio_mayoreo[]" id="precio_mayoreo_' +
        count +
        '" placeholder="Precio Mayoreo" class="form-control inputfield-details" readonly autocomplete="off"><input type="hidden" name="precio_real[]" id="precio_real_' +
        count + '" placeholder="Precio Real" class="form-control inputfield-details" readonly autocomplete="off"></td>';
    htmlRows += '<td><div class="input-group mb-3"><input type="number" name="discount[]" id="discount_' + count +
        '" class="form-control" step="0.01" placeholder="Descuento" readonly autocomplete="off"><div id="suggestions_producto_0" class="suggestions"></div><div class="input-group-append"><a data-toggle="modal" href="#" class="btn btn-outline-success"><div class="sb-nav-link-icon"></div><i class="aplicar_descuento fas fa-plus fa-lg"></i></a></div></div></td>';
    htmlRows += '<td><input type="number" name="total[]" id="total_' + count +
        '" placeholder="Total" class="form-control total inputfield-details" readonly autocomplete="off" step="0.01"></td>';
    htmlRows += '</tr>';
    $('#invoiceItem').append(htmlRows);
    $("#invoice-form .tableFixHead").scrollTop($(document).height());
    $("#invoice-form #invoiceItem #bar-code-id_" + count).focus();
}

function addRowFacturas() {
    var count = parseInt($("#invoice-form #bill_row").val()) + 1;

    var htmlRows = '';
    htmlRows += '<tr>';
    htmlRows += '<td><input class="itemRow" id="itemRow_' + count + '" type="checkbox"></td>';
    htmlRows += '<td><input type="hidden" name="referenciaProducto[]" id="referenciaProducto_' + count +
        '" class="form-control" placeholder="Referencia Producto Precio" autocomplete="off"><input type="hidden" name="isv[]" id="isv_' +
        count +
        '" class="form-control" placeholder="Producto ISV" autocomplete="off"><input type="hidden" name="valor_isv[]" id="valor_isv_' +
        count +
        '" class="form-control" placeholder="Valor ISV" autocomplete="off"><input type="hidden" name="facturas_detalle_id[]" id="facturas_detalle_id_' +
        count +
        '" class="form-control" placeholder="Código Producto" autocomplete="off"><input type="hidden" name="productos_id[]" id="productos_id_' +
        count +
        '" class="form-control inputfield-details1" placeholder="Código del Producto" autocomplete="off">	<div class="input-group mb-3"><div class="input-group-append"><span data-toggle="tooltip" data-placement="top" title="Búsqueda de Productos" id="icon-search-bar_' +
        count +
        '"><a data-toggle="modal" href="#" class="btn btn-link form-control buscar_productos"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg icon-color"></i></a></span><input type="text" name="bar-code-id[]" id="bar-code-id_' +
        count +
        '" class="form-control product-bar-code inputfield-details1" placeholder="Código del Producto" autocomplete="off"></div></div></td>';
    htmlRows += '<td><input type="text" name="productName[]" id="productName_' + count +
        '" readonly placeholder="Descripción del Producto" class="form-control inputfield-details1" autocomplete="off"></td>';
    htmlRows += '<td><input type="number" name="quantity[]" id="quantity_' + count +
        '" step="0.01" placeholder="Cantidad" class="buscar_cantidad form-control inputfield-details" autocomplete="off"><input type="hidden" name="cantidad_mayoreo[]" id="cantidad_mayoreo_' +
        count +
        '" step="0.01" placeholder="Cantidad Mayoreo" class="buscar_cantidad form-control inputfield-details" autocomplete="off"></td>';
    htmlRows += '<td><input type="text" name="medida[]" id="medida_' + count +
        '" readonly class="form-control buscar_medida" autocomplete="off" placeholder="Medida"><input type="hidden" name="bodega[]" id="bodega_' +
        count + '" readonly class="form-control buscar_bodega" autocomplete="off"></td>';
    htmlRows += '<td><div class="input-group mb-3"><input type="number" name="price[]" id="price_' + count +
        '" class="form-control" step="0.01" placeholder="Precio" readonly autocomplete="off"><div id="suggestions_producto_0" class="suggestions"></div><div class="input-group-append"><a data-toggle="modal" href="#" class="btn btn-outline-success"><div class="sb-nav-link-icon"></div><i class="aplicar_precio fas fa-plus fa-lg"></i></a></div></div><input type="hidden" name="pprecio_mayoreo[]" id="precio_mayoreo_' +
        count +
        '" step="0.01" placeholder="Precio Mayoreo" class="form-control inputfield-details" readonly autocomplete="off"><input type="hidden" name="precio_real[]" id="precio_real_' +
        count + '" placeholder="Precio Real" class="form-control inputfield-details" readonly autocomplete="off"></td>';
    htmlRows += '<td><div class="input-group mb-3"><input type="number" name="discount[]" id="discount_' + count +
        '" class="form-control" step="0.01" placeholder="Descuento" readonly autocomplete="off"><div id="suggestions_producto_0" class="suggestions"></div><div class="input-group-append"><a data-toggle="modal" href="#" class="btn btn-outline-success"><div class="sb-nav-link-icon"></div><i class="aplicar_descuento fas fa-plus fa-lg"></i></a></div></div></td>';
    htmlRows += '<td><input type="number" name="total[]" id="total_' + count +
        '" placeholder="Total" class="form-control total inputfield-details" readonly autocomplete="off" step="0.01"></td>';
    htmlRows += '</tr>';
    $('#invoiceItem').append(htmlRows);

    //MOVER SCROLL FACTURA TO THE BOTTOM
    $("#invoice-form .tableFixHead").scrollTop($(document).height());
    $("#invoice-form #invoiceItem #bar-code-id_" + count).focus();

    if (count > 0) {
        var icon_search = count - 1;
    }

    $("#invoice-form #invoiceItem #icon-search-bar_" + icon_search).hide();
    $("#invoice-form #invoiceItem #icon-search-bar_" + icon_search).hide();
    $("#invoice-form #bill_row").val(count);
}

$(document).ready(function() {
    $("#invoice-form #invoiceItem #bar-code-id_0").focus();

    $(document).on('click', '#checkAll', function() {
        $(".itemRow").attr("checked", this.checked);
    });
    $(document).on('click', '.itemRow', function() {
        if ($('.itemRow:checked').length == $('.itemRow').length) {
            $('#checkAll').attr('checked', true);
        } else {
            $('#checkAll').attr('checked', false);
        }
    });
    var count = $(".itemRow").length;
    $(document).on('click', '#addRows', function() {
        if ($("#invoice-form #cliente").val() != "") {
            addRowFacturas();
        } else {
            swal({
                title: "Error",
                text: "Lo sentimos no puede agregar más filas, debe seleccionar un usuario antes de poder continuar",
                icon: "error",
                dangerMode: true,
                closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera 
            });
        }
    });
    $(document).on('click', '#removeRows', function() {
        if ($('.itemRow ').is(':checked')) {
            $(".itemRow:checked").each(function() {
                $(this).closest('tr').remove();
                count--;
            });
            $('#checkAll').attr('checked', false);
            calculateTotalFacturas();
        } else {
            swal({
                title: "Error",
                text: "Lo sentimos debe seleccionar un fila antes de intentar eliminarla",
                icon: "error",
                dangerMode: true,
                closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera 
            });
        }
    });
    $(document).on('blur', "[id^=quantity_]", function() {
        calculateTotalFacturas();
    });
    $(document).on('keyup', "[id^=quantity_]", function() {
        calculateTotalFacturas();
    });
    $(document).on('blur', "[id^=price_]", function() {
        calculateTotalFacturas();
    });
    $(document).on('keyup', "[id^=price_]", function() {
        calculateTotalFacturas();
    });
    $(document).on('blur', "[id^=discount_]", function() {
        calculateTotalFacturas();
    });
    $(document).on('keyup', "[id^=discount_]", function() {
        calculateTotalFacturas();
    });
    $(document).on('blur', "#taxRate", function() {
        calculateTotalFacturas();
    });
    $(document).on('blur', "#amountPaid", function() {
        var amountPaid = $(this).val();
        var totalAftertax = $('#totalAftertax').val();
        if (amountPaid && totalAftertax) {
            totalAftertax = totalAftertax - amountPaid;
            $('#amountDue').val(totalAftertax);
        } else {
            $('#amountDue').val(totalAftertax);
        }
    });
    $(document).on('click', '.deleteInvoice', function() {
        var id = $(this).attr("id");
        if (confirm("Are you sure you want to remove this?")) {
            $.ajax({
                url: "action.php",
                method: "POST",
                dataType: "json",
                data: {
                    id: id,
                    action: 'delete_invoice'
                },
                success: function(response) {
                    if (response.status == 1) {
                        $('#' + id).closest("tr").remove();
                    }
                }
            });
        } else {
            return false;
        }
    });
});

function calculateTotalFacturas(){
    var totalAmount = 0;
    var totalAmountGeneral = 0;
    var totalDiscount = 0;
    var totalISV = 0;
    var totalGeneral = 0;

    $("[id^='price_']").each(function() {
        var id = $(this).attr('id');
        id = id.replace("price_", '');
        var price = $('#price_' + id).val();
        var isv_calculo = $('#valor_isv_' + id).val();
        var discount = $('#discount_' + id).val();
        var quantity = $('#quantity_' + id).val();

        if (!discount) {
            discount = 0;
        }
        if (!quantity) {
            quantity = 1;
            discount = 0;
            $('#discount_' + id).val(0);
        }

        if (!isv_calculo) {
            isv_calculo = 0;
        }

        var total = (price * quantity);
        $('#total_' + id).val(customRound(parseFloat(price * quantity) - parseFloat(discount)).toFixed(4));
        totalAmount += total;
        totalGeneral += (price * quantity);
        totalISV += parseFloat(isv_calculo);

        totalDiscount += parseFloat(discount);
    });
    console.log("" + totalAmount);
    console.log("" + totalISV);
    $('#subTotal').val(parseFloat(totalAmount).toFixed(2));
    $('#subTotalFooter').val(parseFloat(totalAmount).toFixed(2));
    $('#taxDescuento').val(parseFloat(totalDiscount).toFixed(2));

    $('#taxDescuentoFooter').val(parseFloat(totalDiscount));
    var taxRate = $("#taxRate").val();
    var subTotal = totalAmount;
    if (subTotal) {
        $('#subTotalImporte').val(parseFloat(totalGeneral).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#taxAmount').val(parseFloat(totalISV).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#taxAmountFooter').val(parseFloat(totalISV).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        subTotal = (parseFloat(subTotal) + totalISV) - parseFloat(totalDiscount);
        $('#totalAftertax').val(parseFloat(subTotal).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#totalAftertaxFooter').val(parseFloat(subTotal).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));

        var totalAftertax = $('#totalAftertax').val();
        var cambioDolar = $('#cambioBill').val();
        $('#totalHNLBill').val(customRound(parseFloat(totalAftertax * cambioDolar).toFixed(2)));
    }
}

function customRound(number) {
    var truncated = Math.floor(number * 100) / 100; // Trunca a dos decimales
    var secondDecimal = Math.floor((number * 100) % 10); // Obtiene el segundo decimal

    if (secondDecimal >= 5) { // Si el segundo decimal es mayor o igual a 5, redondea hacia arriba
        return parseFloat((truncated + 0.01).toFixed(2)); // Redondea hacia arriba
    } else { // Si el segundo decimal es menor que 5, no redondea
        return parseFloat(truncated.toFixed(2)); // No redondea
    }
}

function cleanFooterValueBill() {
    $('#subTotalFooter').val("");
    $('#taxDescuentoFooter').val("");
    $('#taxAmountFooter').val("");
    $('#totalAftertaxFooter').val("");
}
//FIN INVOICE BILL

/*INICIO BARCODE*/
//INICIO FACTURAS
function redondearEnteroCercano(numero) {
    var entero = Math.floor(numero); // Obtenemos la parte entera del número
    var decimal = numero - entero; // Obtenemos la parte decimal

    if (decimal < 0.5) {
        return entero; // Redondeamos hacia abajo si la parte decimal es menor que 0.5
    } else {
        return entero + 1; // Redondeamos hacia arriba si la parte decimal es mayor o igual a 0.5
    }
}

$(document).ready(function() {
    $("#invoice-form #invoiceItem").on('keypress', '.product-bar-code', function(event) {
        var row_index = $(this).closest("tr").index();

        if (event.which === 10 || event.which === 13) {
            manejarPresionEnter(row_index);
        }

        if (event.which === 43 || event.which === 45) {
            manejarPresionTeclaMasMenos(event.which, row_index);
        }
    });
});

function manejarPresionEnter(row_index) {
    event.preventDefault();
    $(".product-bar-code").focus();

    var barCodeInput = $("#invoice-form #invoiceItem #bar-code-id_" + row_index);
    var barcode = barCodeInput.val();

    if (barcode !== "") {
        var url = '<?php echo SERVERURL; ?>core/getProductoBarCode.php';
        var element = barcode.split('*');
        var cantidad = element[0] || 1;
        var barcodeValue = element[1] || cantidad;

        $.ajax({
            type: 'POST',
            url: url,
            data: 'barcode=' + barcodeValue,
            async: false,
            success: function(registro) {
                getTotalFacturasDisponibles();
                var valores = eval(registro);

                if (valores[9] !== "2") {
                    if (valores[7] === null || valores[7] === "") {
                        swal({
                            title: "Error",
                            content: {
                                element: "span",
                                attributes: {
                                    innerHTML: "Lo sentimos, el producto no está asignado a una bodega. Por favor, <a href='<?php echo SERVERURL; ?>inventario/' style='color: blue; text-decoration: none;' onmouseover='this.style.color=`purple`' onmouseout='this.style.color=`blue`' onmousedown='this.style.color=`purple`' target='_blank'>ingrese el movimiento</a> de este registro antes de continuar."
                                }
                            },
                            icon: "error",
                            buttons: {
                                confirm: {
                                    text: "Aceptar",
                                }
                            },
                            dangerMode: true,
                            closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                            closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera 
                        });

                        return false;
                    }
                }

                if (valores[0]) {
                    var facturar_cero = facturarEnCeroAlmacen(valores[7]);

                    if (valores[6] <= 0) {
                        if (facturar_cero == 'false') {
                            swal({
                                title: "Error",
                                text: "No se puede facturar este producto inventario en cero",
                                icon: "error",
                                dangerMode: true,
                                closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                                closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera 
                            });
                            return false;
                        }
                    }

                    $("#invoice-form #invoiceItem #bar-code-id_" + row_index).val(barcode);

                    // Verificar si el valor ingresado contiene un '*'
                    if (barcode.includes('*')) {
                        var parts = barcode.split('*');
                        var cantidad = parseFloat(parts[0]) ||
                            1; // Ahora se utiliza parseFloat para valores decimales
                        var nuevoBarcode = parts[1];

                        // Asignar la cantidad y el código del producto a los campos correspondientes
                        $("#invoice-form #invoiceItem #quantity_" + row_index).val(cantidad);
                        $("#invoice-form #invoiceItem #bar-code-id_" + row_index).val(nuevoBarcode);
                    } else {
                        // Si no hay '*', asumir que la cantidad es 1 y el código es el valor ingresado
                        $("#invoice-form #invoiceItem #quantity_" + row_index).val(1);
                        $("#invoice-form #invoiceItem #bar-code-id_" + row_index).val(barcode);
                    }

                    $("#invoice-form #invoiceItem #productName_" + row_index).val(valores[0]);
                    $("#invoice-form #invoiceItem #price_" + row_index).val(valores[1]);
                    $("#invoice-form #invoiceItem #precio_real_" + row_index).val(valores[1]);
                    $("#invoice-form #invoiceItem #productos_id_" + row_index).val(valores[2]);
                    $("#invoice-form #invoiceItem #isv_" + row_index).val(valores[3]);
                    $("#invoice-form #invoiceItem #cantidad_mayoreo_" + row_index).val(valores[4]);
                    $("#invoice-form #invoiceItem #precio_mayoreo_" + row_index).val(valores[5]);
                    $('#invoice-form #invoiceItem #bodega_' + row).val(valores[7]);
                    $('#invoice-form #invoiceItem #medida_' + row).val(valores[8]);

                    var impuesto_venta = parseFloat($('#invoice-form #invoiceItem #isv_' + row_index)
                        .val());
                    var cantidad1 = parseFloat($('#invoice-form #invoiceItem #quantity_' + row_index)
                        .val());
                    var precio = parseFloat($('#invoice-form #invoiceItem #price_' + row_index).val());
                    var total = parseFloat($('#invoice-form #invoiceItem #total_' + row_index).val());

                    var isv = 0;
                    var isv_total = 0;
                    var porcentaje_isv = 0;
                    var porcentaje_calculo = 0;
                    var isv_neto = 0;

                    if (impuesto_venta == 1) {
                        porcentaje_isv = parseFloat(getPorcentajeISV("Facturas") / 100);

                        if (total == "" || total == 0) {
                            porcentaje_calculo = (parseFloat(precio) * parseFloat(cantidad1) *
                                porcentaje_isv).toFixed(2);
                            isv_neto = parseFloat(porcentaje_calculo);
                            $('#invoice-form #invoiceItem #valor_isv_' + row_index).val(porcentaje_calculo);
                        } else {
                            isv_total = parseFloat($('#invoice-form #taxAmount').val());
                            porcentaje_calculo = (parseFloat(precio) * parseFloat(cantidad1) *
                                porcentaje_isv).toFixed(2);
                            isv_neto = parseFloat(isv_total) + parseFloat(porcentaje_calculo);
                            $('#invoice-form #invoiceItem #valor_isv_' + row_index).val(porcentaje_calculo);
                        }
                    }

                    addRowFacturas();

                    if (row_index > 0) {
                        var icon_search = row_index - 1;
                    }

                    $("#invoice-form #invoiceItem #icon-search-bar_" + row_index).hide();
                    $("#invoice-form #invoiceItem #icon-search-bar_" + icon_search).hide();

                    calculateTotalFacturas();
                } else {
                    swal({
                        title: "Error",
                        text: "Producto no encontrado, por favor corregir",
                        icon: "error",
                        dangerMode: true,
                        closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                        closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera 
                    });
                    $("#invoice-form #invoiceItem #bar-code-id_" + row_index).val("");
                }
            }
        });
    }
}

function manejarPresionTeclaMasMenos(codigoTecla, row_index) {
    event.preventDefault();
    var cantidadInput = $("#invoice-form #invoiceItem #quantity_" + row_index);
    var cantidad = parseFloat(cantidadInput.val()) || 1;

    if (codigoTecla === 43) { // Tecla de suma
        cantidad++;
    } else if (codigoTecla === 45) { // Tecla de resta
        cantidad = Math.max(cantidad - 1, 1);
    }

    cantidadInput.val(cantidad);

    var impuesto_venta = parseFloat($('#invoice-form #invoiceItem #isv_' + row_index).val());
    var cantidad1 = parseFloat($('#invoice-form #invoiceItem #quantity_' + row_index).val());
    var precio = parseFloat($('#invoice-form #invoiceItem #price_' + row_index).val());
    var total = parseFloat($('#invoice-form #invoiceItem #total_' + row_index).val());

    var isv = 0;
    var isv_total = 0;
    var porcentaje_isv = 0;
    var porcentaje_calculo = 0;
    var isv_neto = 0;

    if (impuesto_venta == 1) {
        porcentaje_isv = parseFloat(getPorcentajeISV("Facturas") / 100);

        if (total == "" || total == 0) {
            porcentaje_calculo = (parseFloat(precio) * parseFloat(cantidad1) * porcentaje_isv).toFixed(2);
            isv_neto = parseFloat(porcentaje_calculo);
            $('#invoice-form #invoiceItem #valor_isv_' + row_index).val(porcentaje_calculo);
        } else {
            isv_total = parseFloat($('#invoice-form #taxAmount').val());
            porcentaje_calculo = (parseFloat(precio) * parseFloat(cantidad1) * porcentaje_isv).toFixed(2);
            isv_neto = parseFloat(isv_total) + parseFloat(porcentaje_calculo);
            $('#invoice-form #invoiceItem #valor_isv_' + row_index).val(porcentaje_calculo);
        }
    }

    calculateTotalFacturas();
}

$(document).ready(function() {
    $('#view_bill').on("keydown", function(e) {
        if (e.which === 118) { //TECLA F7 (COBRAR)
            $("#invoice-form").submit();
            e.preventDefault();
        }

        if (e.which === 119) { //TECLA F8 (CLIENTES)
            searchCustomersBill();
            e.preventDefault();
        }

        if (e.which === 120) { //TECLA F9 (Colaboradores)
            serchColaboradoresBill();
            e.preventDefault();
        }

        if (e.which === 121) { //TECLA F10 (APERTURAR CAJA)
            e.preventDefault();
            if (getConsultarAperturaCaja() == 2) {
                formAperturaBill();
            } else {
                swal({
                    title: "Caja abierta",
                    text: "La caja se encuentra abierta",
                    icon: "warning",
                    dangerMode: true,
                    closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                    closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera 
                });
            }
        }

        if (e.which === 122) { //TECLA F11 (CERRAR CAJA)			
            e.preventDefault();
            if (getConsultarAperturaCaja() != 2) {
                formCierreBill()
            } else {
                swal({
                    title: "Caja cerrada",
                    text: "La caja se encuentra cerrada",
                    icon: "warning",
                    dangerMode: true,
                    closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                    closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera 
                });
            }
        }
    });
});

//INICIO ADD TASA DE CAMBIO
$(document).ready(function() {
    $("#modalTasaCambio").on('shown.bs.modal', function() {
        $(this).find('#formTasaCambio #tasa_compra').focus();
    });
});

$("#invoice-form #addCambio").on("click", function(e) {
    e.preventDefault();
    $('#modalTasaCambio #pro_tasaCambio').val("Registro");


    $('#formTasaCambio').attr({
        'data-form': 'save'
    });
    $('#formTasaCambio').attr({
        'action': '<?php echo SERVERURL; ?>ajax/addTasaCambioAjax.php'
    });

    $('#modalTasaCambio').modal({
        show: true,
        keyboard: false,
        backdrop: 'static'
    });
});

$("#formTasaCambio").on("submit", function(e) {
    var compra = $('#formTasaCambio #tasa_compra').val();
    var totalUSD = $('#invoice-form #totalAftertax').val();
    var totalHND = 0;

    if (compra > 0) {
        totalHND = totalUSD * compra;
    }

    $('#invoice-form #totalHNLBill').val(parseFloat(totalHND).toFixed(2));

    e.preventDefault();
});
//FIN ADD TASA DE CAMBIO

function modalAyuda() {
    $('#modalAyuda').modal({
        show: true,
        keyboard: false,
        backdrop: 'static'
    });
}

//INICIO AYUDA
$("#invoice-form #help_factura").on("click", function(e) {
    modalAyuda();
    e.preventDefault();
});

//INICIO DESCUENTO PRODUCTO EN FACTURACION
$(document).ready(function() {
    $("#formDescuentoFacturacion #porcentaje_descuento_fact").on("keyup", function() {
        var precio;
        var porcentaje;

        if ($("#formDescuentoFacturacion #porcentaje_descuento_fact").val()) {
            precio = parseFloat($('#formDescuentoFacturacion #precio_descuento_fact').val());
            porcentaje = parseFloat($('#formDescuentoFacturacion #porcentaje_descuento_fact').val());

            $('#formDescuentoFacturacion #descuento_fact').val(parseFloat(precio * (porcentaje / 100))
                .toFixed(2));
        } else {
            $('#formDescuentoFacturacion #descuento_fact').val(0);
        }
    });

    $("#formDescuentoFacturacion #descuento_fact").on("keyup", function() {
        var precio;
        var descuento_fact;

        if ($("#formDescuentoFacturacion #descuento_fact").val() != "") {
            precio = parseFloat($('#formDescuentoFacturacion #precio_descuento_fact').val());
            descuento_fact = parseFloat($('#formDescuentoFacturacion #descuento_fact').val());

            $('#formDescuentoFacturacion #porcentaje_descuento_fact').val(parseFloat((descuento_fact /
                precio) * 100).toFixed(2));
        } else {
            $('#formDescuentoFacturacion #porcentaje_descuento_fact').val(0);
        }
    });
});

$("#reg_DescuentoFacturacion").on("click", function(e) {
    e.preventDefault();
    var row_index = $('#formDescuentoFacturacion #row_index').val();
    var col_index = $('#formDescuentoFacturacion #col_index').val();

    var descuento = parseFloat($('#formDescuentoFacturacion #descuento_fact').val()).toFixed(2);

    var precio = $("#invoice-form #invoiceItem #price_" + row_index).val();
    var cantidad = $("#invoice-form #invoiceItem #quantity_" + row_index).val();
    var impuesto_venta = $("#invoice-form #invoiceItem #isv_" + row_index).val();
    $("#invoice-form #invoiceItem #discount_" + row_index).val(descuento);

    var isv = 0;
    var isv_total = 0;
    var porcentaje_isv = 0;
    var porcentaje_calculo = 0;
    var isv_neto = 0;
    var total_ = (precio * cantidad) - descuento;

    if (total_ > 0) {
        if (impuesto_venta == 1) {
            porcentaje_isv = parseFloat(getPorcentajeISV("Facturas") / 100);
            if ($('#invoice-form #taxAmount').val() == "" || $('#invoice-form #taxAmount').val() == 0) {
                porcentaje_calculo = (parseFloat(total_) * porcentaje_isv).toFixed(2);
                isv_neto = porcentaje_calculo;
                $('#invoice-form #taxAmount').val(porcentaje_calculo);
                $('#invoice-form #invoiceItem #valor_isv_' + row_index).val(porcentaje_calculo);
            } else {
                isv_total = parseFloat($('#invoice-form #taxAmount').val());
                porcentaje_calculo = (parseFloat(total_) * porcentaje_isv).toFixed(2);
                isv_neto = parseFloat(isv_total) + parseFloat(porcentaje_calculo);
                $('#invoice-form #taxAmount').val(isv_neto);
                $('#invoice-form #invoiceItem #valor_isv_' + row_index).val(porcentaje_calculo);
            }
        }

        $('#modalDescuentoFacturacion').modal('hide');
        calculateTotalFacturas();
    } else {
        swal({
            title: "warning",
            text: "El valor del descuento es mayor al precio total del artículo, por favor corregir",
            icon: "warning",  
            dangerMode: true,
            closeOnEsc: false, // Desactiva el cierre con la tecla Esc
            closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera                      
        });
    }
});
//FIN DESCUENTO PRODUCTO EN FACTURACION

//INICIO CAMBIAR PRECIO A PRODUCTO EN FACTURACION
$(document).ready(function() {
    $('#invoice-form #invoiceItem').on("keydown", '.product-bar-code', function(e) {
        if (e.which === 112) { //TECLA F1
            //modalLogin();
            modalAyuda();
            e.preventDefault();
        }

        //INICIO BUSQUEDA PRODUCTO EN FACTURACION
        if (e.which === 113) { //TECLA F2
            listar_productos_factura_buscar();
            var row_index = $(this).closest("tr").index();
            var col_index = $(this).closest("td").index();

            $('#formulario_busqueda_productos_facturacion #row').val(row_index);
            $('#formulario_busqueda_productos_facturacion #col').val(col_index);
            $('#modal_buscar_productos_facturacion').modal({
                show: true,
                keyboard: false,
                backdrop: 'static'
            });
            e.preventDefault();
        }

        if (e.which === 114) { //TECLA F3
            listar_productos_factura_buscar();
            var row_index = $(this).closest("tr").index();
            var col_index = $(this).closest("td").index();

            $('#formulario_busqueda_productos_facturacion #row').val(row_index);
            $('#formulario_busqueda_productos_facturacion #col').val(col_index);
            $('#modal_buscar_productos_facturacion').modal({
                show: true,
                keyboard: false,
                backdrop: 'static'
            });
            e.preventDefault();
        }
        //FIN BUSQUEDA PRODUCTO EN FACTURACION

        if (e.which === 115) { //TECLA F4
            var row_index = $(this).closest("tr").index();
            var col_index = $(this).closest("td").index();

            $('#formDescuentoFacturacion #row_index').val(row_index);
            $('#formDescuentoFacturacion #col_index').val(col_index);

            if ($("#invoice-form #invoiceItem #productos_id_" + row_index).val() != "") {
                $('#formDescuentoFacturacion')[0].reset();
                var productos_id = $("#invoice-form #invoiceItem #productos_id_" + row_index).val();
                var producto = $("#invoice-form #invoiceItem #productName_" + row_index).val();
                var precio = $("#invoice-form #invoiceItem #price_" + row_index).val();

                $('#formDescuentoFacturacion #descuento_productos_id').val(productos_id);
                $('#formDescuentoFacturacion #producto_descuento_fact').val(producto);
                $('#formDescuentoFacturacion #precio_descuento_fact').val(precio);

                $('#formDescuentoFacturacion #pro_descuento_fact').val("Registrar");

                $('#modalDescuentoFacturacion').modal({
                    show: true,
                    keyboard: false,
                    backdrop: 'static'
                });
            }
            e.preventDefault();
        }

        if (e.which === 117) { //TECLA F6
            var row_index = $(this).closest("tr").index();
            var col_index = $(this).closest("td").index();
            $('#formModificarPrecioFacturacion #row_index').val(row_index);
            $('#formModificarPrecioFacturacion #col_index').val(col_index);

            if ($("#invoice-form #invoiceItem #productos_id_" + row_index).val() != "") {
                $('#formModificarPrecioFacturacion')[0].reset();
                var clientes_id = $("#invoice-form #cliente_id").val();
                var fecha = $("#invoice-form #fecha").val();
                var productos_id = $("#invoice-form #invoiceItem #productos_id_" + row_index).val();
                var producto = $("#invoice-form #invoiceItem #productName_" + row_index).val();
                var precio = $("#invoice-form #invoiceItem #price_" + row_index).val();

                $('#formModificarPrecioFacturacion #modificar_precio_fecha').val(fecha);
                $('#formModificarPrecioFacturacion #modificar_precio_clientes_id').val(clientes_id);
                $('#formModificarPrecioFacturacion #modificar_precio_productos_id').val(productos_id);
                $('#formModificarPrecioFacturacion #producto_modificar_precio_fact').val(producto);

                $('#formModificarPrecioFacturacion #pro_modificar_precio').val("Aplicar Nuevo Precio");

                $('#modalModificarPrecioFacturacion').modal({
                    show: true,
                    keyboard: false,
                    backdrop: 'static'
                });
            }
            e.preventDefault();
        }
    });
});

$("#reg_modificar_precio_fact").on("click", function(e) {
    e.preventDefault();
    var row_index = $('#formModificarPrecioFacturacion #row_index').val();
    var col_index = $('#formModificarPrecioFacturacion #col_index').val();

    var referencia = $('#formModificarPrecioFacturacion #referencia_modificar_precio_fact').val();
    var cantidad = $("#invoice-form #invoiceItem #quantity_" + row_index).val();
    var precio = parseFloat($('#formModificarPrecioFacturacion #precio_modificar_precio_fact').val()).toFixed(
        2);
    var descuento = $("#invoice-form #invoiceItem #discount_" + row_index).val();

    var aplica_isv = $("#invoice-form #invoiceItem #isv_" + row_index).val();

    var isv = 0;
    var isv_total = 0;
    var porcentaje_isv = 0;
    var porcentaje_calculo = 0;
    var isv_neto = 0;
    var total_ = (precio * cantidad) - descuento;

    if (aplica_isv == 1) {
        porcentaje_isv = parseFloat(getPorcentajeISV("Facturas") / 100);
        if ($('#invoice-form #taxAmount').val() == "" || $('#invoice-form #taxAmount').val() == 0) {
            porcentaje_calculo = (parseFloat(total_) * porcentaje_isv).toFixed(2);
            isv_neto = porcentaje_calculo;
            $('#invoice-form #taxAmount').val(porcentaje_calculo);
            $('#invoice-form #invoiceItem #valor_isv_' + row_index).val(porcentaje_calculo);
        } else {
            isv_total = parseFloat($('#invoice-form #taxAmount').val());
            porcentaje_calculo = (parseFloat(total_) * porcentaje_isv);
            isv_neto = parseFloat(isv_total) + parseFloat(porcentaje_calculo);
            $('#invoice-form #taxAmount').val(isv_neto);
            $('#invoice-form #invoiceItem #valor_isv_' + row_index).val(porcentaje_calculo);
        }
    }

    $('#modalDescuentoFacturacion').modal('hide');

    $("#invoice-form #invoiceItem #price_" + row_index).val(precio);
    $("#invoice-form #invoiceItem #referenciaProducto_" + row_index).val(referencia);
    $('#modalModificarPrecioFacturacion').modal('hide');
    calculateTotalFacturas();
});
//FIN CAMBIAR PRECIO A PRODUCTO EN FACTURACION
//FIN FACTURAS

function validarAperturaCajaUsuario(){
    if (getConsultarAperturaCaja() == 2) {
        $("#invoice-form #reg_factura").attr("disabled", true);
        $("#invoice-form #guardar_factura").attr("disabled", true);
        $("#invoice-form #add_cliente").attr("disabled", true);
        $("#invoice-form #add_vendedor").attr("disabled", true);
        $("#invoice-form #addCambio").attr("disabled", true);
        $("#invoice-form #addQuotetoBill").attr("disabled", true);
        $("#invoice-form #addPayCustomers").attr("disabled", true);
        $("#invoice-form #addRows").attr("disabled", true);
        $("#invoice-form #removeRows").attr("disabled", true);
        $("#invoice-form #addDraft").attr("disabled", true);
        $("#invoice-form #notasFactura").attr("disabled", true);
        $("#invoice-form #btn_apertura").show();
        $("#invoice-form #btn_cierre").hide();
    } else {
        $("#invoice-form #btn_apertura").hide();
        $("#invoice-form #reg_factura").attr("disabled", false);
        $("#invoice-form #guardar_factura").attr("disabled", false);
        $("#invoice-form #add_cliente").attr("disabled", false);
        $("#invoice-form #add_vendedor").attr("disabled", false);
        $("#invoice-form #addCambio").attr("disabled", false);
        $("#invoice-form #addQuotetoBill").attr("disabled", false);
        $("#invoice-form #addPayCustomers").attr("disabled", false);
        $("#invoice-form #addRows").attr("disabled", false);
        $("#invoice-form #removeRows").attr("disabled", false);
        $("#invoice-form #notasFactura").attr("disabled", false);
        $("#invoice-form #addDraft").attr("disabled", false);
        $("#invoice-form #btn_cierre").show();
        $("#invoice-form #btn_apertura").hide();
    }
}

function getConsultarAperturaCaja() {
    var url = '<?php echo SERVERURL; ?>core/getAperturaCajaUsuario.php';

    var estado_apertura;

    $.ajax({
        type: 'POST',
        url: url,
        async: false,
        success: function(registro) {
            var valores = eval(registro);
            estado_apertura = valores[0];
        }
    });
    return estado_apertura;
}

function facturarEnCeroAlmacen(almacen_id) {

    var url = '<?php echo SERVERURL; ?>core/getFacturarCeroAlmacen.php';
    var estado = true;

    $.ajax({
        type: 'POST',
        url: url,
        data: 'almacen_id=' + almacen_id,
        async: false,
        success: function(res) {
            estado = res;
        }
    });
    return estado;
}


//INICIO ESTADOS
function getEstadoFactura() {
    $('#invoice-form #label_facturas_activo').html("Contado");
    $('#invoice-form #facturas_activo').attr('checked', true);
}

$(document).ready(function() {
    //INICIO FACTURA
    $('#invoice-form #label_facturas_activo').html("Contado");

    $('#invoice-form .switch').change(function() {
        if ($('input[name=facturas_activo]').is(':checked')) {
            $('#invoice-form #label_facturas_activo').html("Contado");
            return true;
        } else {
            $('#invoice-form #label_facturas_activo').html("Crédito");
            return false;
        }
    });


    $('#invoice-form #label_facturas_proforma').html("No");

    $('#invoice-form .switch').change(function() {
        if ($('input[name=facturas_proforma]').is(':checked')) {
            $('#invoice-form #label_facturas_proforma').html("Si");
            return true;
        } else {
            $('#invoice-form #label_facturas_proforma').html("No");
            return false;
        }
    });    
    //FIN FACTURA

});

$(document).ready(function() {
    $("#modalDescuentoFacturacion").on('shown.bs.modal', function() {
        $(this).find('#formDescuentoFacturacion #porcentaje_descuento_fact').focus();
    });
});

$(document).ready(function() {
    $("#modalModificarPrecioFacturacion").on('shown.bs.modal', function() {
        $(this).find('#formModificarPrecioFacturacion #referencia_modificar_precio_fact').focus();
    });
});

$(document).ready(function() {
    $("#modal_buscar_productos_facturacion").on('shown.bs.modal', function() {
        $(this).find('#formulario_busqueda_productos_facturacion #buscar').focus();
    });
});

$(document).ready(function() {
    $("#modal_buscar_colaboradores_facturacion").on('shown.bs.modal', function() {
        $(this).find('#formulario_busqueda_colaboradores_facturacion #buscar').focus();
    });
});

$(document).ready(function() {
    $("#modal_buscar_clientes_facturacion").on('shown.bs.modal', function() {
        $(this).find('#formulario_busqueda_clientes_facturacion #buscar').focus();
    });
});

$('#invoice-form #notesBill').keyup(function() {
    var max_chars = 2000;
    var chars = $(this).val().length;
    var diff = max_chars - chars;

    $('#invoice-form #charNum_notasBills').html(diff + ' Caracteres');

    if (diff == 0) {
        return false;
    }
});

function caracteresNotasBills() {
    var max_chars = 2000;
    var chars = $('#invoice-form #notesBill').val().length;
    var diff = max_chars - chars;

    $('#invoice-form #charNum_notasBills').html(diff + ' Caracteres');

    if (diff == 0) {
        return false;
    }
}

$("#invoice-form #cambiar_valor").on("click", function(e) {
    e.preventDefault();
    $('#invoice-form #cambioBillValor').val(1);
    $('#invoice-form #cambioBill').attr("readonly", false);
    $('#invoice-form #cambioBill').focus();
});

$("#invoice-form #cambioBill").on('keypress', function(event) {
    calculateTotalFacturas();
});

$("#invoice-form #cambioBill").on('keyup', function(event) {
    calculateTotalFacturas();
});

$("#invoice-form #cambioBill").on('blur', function(event) {
    calculateTotalFacturas();
});

//INICIO CONVERTIR COTIZACION EN FACTURAS
$(document).ready(function() {
    $("#modal_buscar_cotizaciones").on('shown.bs.modal', function() {
        $(this).find('#formulario_busqueda_cotizaciones #buscar').focus();
    });
});

$("#invoice-form #addQuotetoBill").on("click", function(e) {
    e.preventDefault();
    listar_busqueda_cotizaciones();

    $('#modal_buscar_cotizaciones').modal({
        show: true,
        keyboard: false,
        backdrop: 'static'
    });
});

var listar_busqueda_cotizaciones = function() {
    var tipo_cotizacion_reporte = 1;
    if ($("#formulario_busqueda_cotizaciones #tipo_cotizacion_reporte").val() == null || $(
            "#formulario_busqueda_cotizaciones #tipo_cotizacion_reporte").val() == "") {
        tipo_cotizacion_reporte = 1;
    } else {
        tipo_cotizacion_reporte = $("#formulario_busqueda_cotizaciones #tipo_cotizacion_reporte").val();
    }

    var fechai = $("#formulario_busqueda_cotizaciones #fechai").val();
    var fechaf = $("#formulario_busqueda_cotizaciones #fechaf").val();

    var table_busqueda_Cotizaciones = $("#DatatableBusquedaCotizaciones").DataTable({
        "destroy": true,
        "ajax": {
            "method": "POST",
            "url": "<?php echo SERVERURL; ?>core/llenarDataTableReporteCotizaciones.php",
            "data": {
                "tipo_cotizacion_reporte": tipo_cotizacion_reporte,
                "fechai": fechai,
                "fechaf": fechaf
            }
        },
        "columns": [{
                "defaultContent": "<button class='table_view pay_fact_cot btn btn-dark ocultar'><span class='fab fa-amazon-pay fa-lg'></span></button>"
            },
            {
                "defaultContent": "<button class='table_reportes print_cotizaciones btn btn-dark ocultar'><span class='fas fa-file-download fa-lg'></span></button>"
            },
            {
                "data": "fecha"
            },
            {
                "data": "tipo_documento"
            },
            {
                "data": "cliente"
            },
            {
                "data": "numero"
            },
            {
                "data": "subtotal",
                render: function(data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, 'L ')
                        .display(data);

                    if (type === 'display') {
                        let color = 'black';
                        if (data < 0) {
                            color = 'red';
                        }

                        return '<span style="color:' + color + '">' + number + '</span>';
                    }

                    return number;
                },
            },
            {
                "data": "isv",
                render: function(data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, 'L ')
                        .display(data);

                    if (type === 'display') {
                        let color = 'black';
                        if (data < 0) {
                            color = 'red';
                        }

                        return '<span style="color:' + color + '">' + number + '</span>';
                    }

                    return number;
                },
            },
            {
                "data": "descuento",
                render: function(data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, 'L ')
                        .display(data);

                    if (type === 'display') {
                        let color = 'black';
                        if (data < 0) {
                            color = 'red';
                        }

                        return '<span style="color:' + color + '">' + number + '</span>';
                    }

                    return number;
                },
            },
            {
                "data": "total",
                render: function(data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, 'L ')
                        .display(data);

                    if (type === 'display') {
                        let color = 'black';
                        if (data < 0) {
                            color = 'red';
                        }

                        return '<span style="color:' + color + '">' + number + '</span>';
                    }

                    return number;
                },
            }
        ],
        "lengthMenu": lengthMenu,
        "stateSave": true,
        "bDestroy": true,
        "language": idioma_español, //esta se encuenta en el archivo main.js
        "dom": dom,
        "columnDefs": [{
                width: "2%",
                targets: 0
            },
            {
                width: "2%",
                targets: 1
            },
            {
                width: "8%",
                targets: 2
            },
            {
                width: "8%",
                targets: 3
            },
            {
                width: "20%",
                targets: 4
            },
            {
                width: "12%",
                targets: 5
            },
            {
                width: "12%",
                targets: 6
            },
            {
                width: "12%",
                targets: 7
            },
            {
                width: "12%",
                targets: 8
            },
            {
                width: "12%",
                targets: 9
            }
        ],
        "buttons": [{
            text: '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
            titleAttr: 'Actualizar Cotizaciones',
            className: 'table_actualizar btn btn-secondary ocultar',
            action: function() {
                listar_busqueda_cotizaciones();
            }
        }],
        "drawCallback": function(settings) {
            getPermisosTipoUsuarioAccesosTable(getPrivilegioTipoUsuario());
        }
    });
    table_busqueda_Cotizaciones.search('').draw();
    $('#buscar').focus();

    pay_factura_cotizaciones_dataTable("#DatatableBusquedaCotizaciones tbody", table_busqueda_Cotizaciones);
    view_factura_cotizaciones_dataTable("#DatatableBusquedaCotizaciones tbody", table_busqueda_Cotizaciones);
}

var pay_factura_cotizaciones_dataTable = function(tbody, table) {
    $(tbody).off("click", "button.pay_fact_cot");
    $(tbody).on("click", "button.pay_fact_cot", function(e) {
        e.preventDefault();
        var data = table.row($(this).parents("tr")).data();
        convertirCotizacion(data.cotizacion_id);
    });
}

var view_factura_cotizaciones_dataTable = function(tbody, table) {
    $(tbody).off("click", "button.print_cotizaciones");
    $(tbody).on("click", "button.print_cotizaciones", function(e) {
        e.preventDefault();
        var data = table.row($(this).parents("tr")).data();
        printQuote(data.cotizacion_id);
    });
}
//FIN CONVERTIR COTIZACION EN FACTURAS

//INICIO CUENTAS POR COBRAR CLIENTES
$(document).ready(function() {
    $("#modal_buscar_cuentas_cobrar_clientes").on('shown.bs.modal', function() {
        $(this).find('#formulario_busqueda_cuentas_cobrar_clientes #buscar').focus();
    });
});

$("#invoice-form #addPayCustomers").on("click", function(e) {
    e.preventDefault();
    listar_busqueda_cuentas_por_cobrar_clientes();

    $('#modal_buscar_cuentas_cobrar_clientes').modal({
        show: true,
        keyboard: false,
        backdrop: 'static'
    });
});

var listar_busqueda_cuentas_por_cobrar_clientes = function() {
    var estado = $("#formulario_busqueda_cuentas_cobrar_clientes #cobrar_clientes_estado").val() === "" ? 1 : $(
        "#formulario_busqueda_cuentas_cobrar_clientes #cobrar_clientes_estado").val();
    var clientes_id = $("#formulario_busqueda_cuentas_cobrar_clientes #cobrar_clientes").val();
    var fechai = $("#formulario_busqueda_cuentas_cobrar_clientes #fechai").val();
    var fechaf = $("#formulario_busqueda_cuentas_cobrar_clientes #fechaf").val();

    var table_busqueda_cuentas_por_cobrar_clientes = $("#DatatableBusquedaCuentasCobrarClientes").DataTable({
        "destroy": true,
        "ajax": {
            "method": "POST",
            "url": "<?php echo SERVERURL; ?>core/llenarDataTableCobrarClientes.php",
            "data": {
                "estado": estado,
                "clientes_id": clientes_id,
                "fechai": fechai,
                "fechaf": fechaf
            }
        },
        "columns": [{
                "data": "fecha"
            },
            {
                "data": "cliente"
            },
            {
                "data": "numero"
            },
            {
                data: 'credito',
                render: function(data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, 'L ')
                        .display(data);

                    if (type === 'display') {
                        let color = 'green';
                        if (data < 0) {
                            color = 'red';
                        }

                        return '<span style="color:' + color + '">' + number + '</span>';
                    }

                    return number;
                },
            },
            {
                data: "abono",
                render: function(data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, 'L ')
                        .display(data);

                    if (type === 'display') {
                        let color = 'green';
                        if (data < 0) {
                            color = 'red';
                        }

                        return '<span style="color:' + color + '">' + number + '</span>';
                    }

                    return number;
                },
            },
            {
                data: "saldo",
                render: function(data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, 'L ')
                        .display(data);

                    if (type === 'display') {
                        let color = 'green';
                        if (data < 0) {
                            color = 'red';
                        }

                        return '<span style="color:' + color + '">' + number + '</span>';
                    }

                    return number;
                },
            },
            {
                "defaultContent": "<button class='table_abono btn btn-dark'><span class='fas fa-cash-register fa-lg'></span></button>"
            },
            {
                "defaultContent": "<button class='table_reportes abono_factura btn btn-dark ocultar'><span class='fa fa-money-bill-wave fa-solid'></span></button>"
            },
            {
                "defaultContent": "<button class='table_reportes print_factura btn btn-dark ocultar'><span class='fas fa-file-download fa-lg'></span></button>"
            }
        ],
        "pageLength": 10,
        "lengthMenu": lengthMenu,
        "stateSave": true,
        "bDestroy": true,
        "language": idioma_español,
        "dom": dom,
        "columnDefs": [{
                width: "12.11%",
                targets: 0
            },
            {
                width: "21.11%",
                targets: 1
            },
            {
                width: "21.11%",
                targets: 2
            },
            {
                width: "13.11%",
                targets: 3,
                className: "text-center"
            },
            {
                width: "13.11%",
                targets: 4,
                className: "text-center"
            },
            {
                width: "13.11%",
                targets: 5,
                className: "text-center"
            },
            {
                width: "2.11%",
                targets: 6
            },
            {
                width: "2.11%",
                targets: 7
            },
            {
                width: "2.11%",
                targets: 8
            },
        ],
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            $('td', nRow).addClass(aData['color']);
            for (let index = 0; index < aData.length; index++) {
                console.log(aData[i]["credito"]);
            }
            $(row).find('td:eq(2)').css('color', 'red');
            $('#credito-cxc').html('L. ' + aData['total_credito'])
            $('#abono-cxc').html('L. ' + aData['total_abono'])
            $('#total-footer-cxc').html('L. ' + aData['total_pendiente'])

        },
        "buttons": [{
            text: '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
            titleAttr: 'Actualizar Cuentas por Cobrar Clientes',
            className: 'table_actualizar btn btn-secondary ocultar',
            action: function() {
                listar_busqueda_cuentas_por_cobrar_clientes();
            }
        }],
        "drawCallback": function(settings) {
            getPermisosTipoUsuarioAccesosTable(getPrivilegioTipoUsuario());
        }
    });
    table_busqueda_cuentas_por_cobrar_clientes.search('').draw();
    $('#buscar').focus();

    registrar_abono_cxc_clientes_dataTable("#DatatableBusquedaCuentasCobrarClientes tbody",
        table_busqueda_cuentas_por_cobrar_clientes);
    ver_abono_cxc_clientes_dataTable("#DatatableBusquedaCuentasCobrarClientes tbody",
        table_busqueda_cuentas_por_cobrar_clientes);
    view_reporte_facturas_dataTable("#DatatableBusquedaCuentasCobrarClientes tbody",
        table_busqueda_cuentas_por_cobrar_clientes);
}

var view_reporte_facturas_dataTable = function(tbody, table) {
    $(tbody).off("click", "button.print_factura");
    $(tbody).on("click", "button.print_factura", function(e) {
        e.preventDefault();
        var data = table.row($(this).parents("tr")).data();
        printBillReporteVentas(data.facturas_id);
    });
}

var registrar_abono_cxc_clientes_dataTable = function(tbody, table) {
    $(tbody).off("click", "button.table_abono");
    $(tbody).on("click", "button.table_abono", function(e) {
        e.preventDefault();
        var data = table.row($(this).parents("tr")).data();
        if (data.estado == 2 || data.saldo <=
            0) { //no tiene acceso a la accion si la factura ya fue cancelada							
            swal({
                title: 'Error',
                text: 'No puede realizar esta accion a las facturas canceladas!',
                icon: 'error',
                dangerMode: true,
                closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera 
            });
        } else {
            console.log('cxc', data.facturas_id, 2)
            pago(data.facturas_id, 2);
        }
    });
}

var ver_abono_cxc_clientes_dataTable = function(tbody, table) {
    $(tbody).off("click", "button.abono_factura");
    $(tbody).on("click", "button.abono_factura", function(e) {
        e.preventDefault();
        var data = table.row($(this).parents("tr")).data();
        $('#ver_abono_cxc').modal('show');
        $("#formulario_ver_abono_cxc #abono_facturas_id").val(data.facturas_id);
        listar_AbonosCXC();
    });
}

var ver_abono_cxp_proveedor_dataTable = function(tbody, table) {
    $(tbody).off("click", "button.abono_proveedor");
    $(tbody).on("click", "button.abono_proveedor", function(e) {
        e.preventDefault();
        var data = table.row($(this).parents("tr")).data();
        $('#ver_abono_cxc').modal('show');
        getAbonosCXP(data.compras_id);
    });
}
//FIN CUENTAS POR COBRAR CLIENTES

function getTotalFacturasDisponibles() {
    var url = '<?php echo SERVERURL; ?>core/getTotalFacturasDisponibles.php';

    $.ajax({
        type: 'POST',
        url: url,
        async: false,
        success: function(registro) {
                var datos = JSON.parse(registro);  // Parseamos el JSON recibido
                var mensaje = "";
                var facturasDisponibles = datos.facturasPendientes;
                var diasTranscurridos = datos.contador;
                var fechaLimite = datos.fechaLimite;

                // Habilitar/deshabilitar el botón de facturación según el número de facturas
                if (facturasDisponibles >= 10 && facturasDisponibles <= 30) {
                    mensaje = "Total Facturas disponibles: " + facturasDisponibles;
                    $("#mensajeFacturas").html(mensaje).addClass("alert alert-warning");
                    $("#mensajeFacturas").removeClass("alert alert-danger");
                    $("#mensajeFacturas").attr("disabled", true);
                    //$("#invoice-form #reg_factura").attr("disabled", false);
                } else if (facturasDisponibles >= 0 && facturasDisponibles <= 9) {
                    mensaje = "Total Facturas disponibles: " + facturasDisponibles;
                    $("#mensajeFacturas").html(mensaje).addClass("alert alert-danger");
                    $("#mensajeFacturas").removeClass("alert alert-warning");
                    $("#mensajeFacturas").attr("disabled", true);
                    $("#invoice-form #reg_factura").attr("disabled", false);
                } else {
                    mensaje = "";
                    //$("#invoice-form #reg_factura").attr("disabled", false);
                    $("#mensajeFacturas").html(mensaje).addClass("alert alert-danger");
                    $("#mensajeFacturas").removeClass("alert alert-warning");
                }

                if (facturasDisponibles == 0) {
                    mensaje = "Total Facturas disponibles: " + facturasDisponibles;
                    mensaje += "<br/>Solo esta factura puede realizar";
                    $("#mensajeFacturas").html(mensaje).addClass("alert alert-danger");
                    $("#mensajeFacturas").removeClass("alert alert-warning");
                    $("#mensajeFacturas").attr("disabled", true);
                    //$("#invoice-form #reg_factura").attr("disabled", false);
                }

                if (facturasDisponibles < 0) {
                    mensaje = "No puede seguir facturando. La secuencia de facturación proporcionada por la SAR no ha sido habilitada aún. Dirígete al módulo de configuración de <a href='" + "<?php echo SERVERURL; ?>" + "secuencia/' target='_blank' class='no-hover-link'>Secuencias</a> para completar la configuración necesaria.";

                    $("#invoice-form #reg_factura").attr("disabled", true);
                    $("#mensajeFacturas").html(mensaje).addClass("alert alert-danger");
                    $("#mensajeFacturas").removeClass("alert alert-warning");
                }

				// Si la fecha límite no está definida, deshabilitamos ambos botones (facturación y apertura)
				if (fechaLimite.trim() !== "Sin definir") {
					// Procesamiento si fechaLimite tiene un valor definido
					if (diasTranscurridos == 1) {
						mensaje += "<br/>Su fecha límite es: " + fechaLimite;
						mensaje += "<br/>Le queda un día más, para seguir facturando";
						//$("#invoice-form #reg_factura").attr("disabled", false);
						$("#mensajeFacturas").html(mensaje).addClass("alert alert-warning");
						$("#mensajeFacturas").removeClass("alert alert-danger");
					} else if (diasTranscurridos === 0) {
						mensaje += "<br/>Su fecha limite de facturación es hoy";
						$("#mensajeFacturas").html(mensaje).addClass("alert alert-danger");
						$("#mensajeFacturas").removeClass("alert alert-warning");
					} else if (diasTranscurridos < 0) {
						mensaje += "<br/>Ya alcanzó su fecha límite de facturación.";
						//$("#invoice-form #reg_factura").attr("disabled", true);
						$("#mensajeFacturas").html(mensaje).addClass("alert alert-danger");
						$("#mensajeFacturas").removeClass("alert alert-warning");
					}
				} else {
					// En caso de que la fecha límite esté como 'Sin definir'
					mensaje = "La secuencia de facturación y la fecha límite de facturación no están definidas. Dirígete al módulo de configuración de <a href='" + "<?php echo SERVERURL; ?>" + "secuencia/' target='_blank' class='no-hover-link'>Secuencias</a> para completar la configuración necesaria.";
					$("#mensajeFacturas").html(mensaje).addClass("alert alert-warning");
					$("#mensajeFacturas").removeClass("alert alert-danger");

					// Bloqueamos el botón de facturación y apertura
					$("#invoice-form #reg_factura").attr("disabled", true);
					$("#invoice-form #btn_apertura").attr("disabled", true);
				}

                // Si ya hay facturas disponibles, habilitar el botón de apertura
                if (facturasDisponibles > 0) {
                    $("#invoice-form #btn_apertura").attr("disabled", false);
                }
        }
    });
}


setInterval('getTotalFacturasDisponibles()',1000);

function getReporteCotizacion() {
    var url = '<?php echo SERVERURL; ?>core/getTipoFacturaReporte.php';

    $.ajax({
        type: "POST",
        url: url,
        async: true,
        success: function(data) {
            $('#formulario_busqueda_cotizaciones #tipo_cotizacion_reporte').html("");
            $('#formulario_busqueda_cotizaciones #tipo_cotizacion_reporte').html(data);
            $('#formulario_busqueda_cotizaciones #tipo_cotizacion_reporte').selectpicker('refresh');
        }
    });
}

$("#formulario_busqueda_cotizaciones #search").on("click", function(e) {
    e.preventDefault();
    listar_busqueda_cotizaciones();
});

$("#formulario_busqueda_cuentas_cobrar_clientes #search").on("click", function(e) {
    e.preventDefault();
    listar_busqueda_cuentas_por_cobrar_clientes();
});

function convertirCotizacion(cotizacion_id) {
    var url = '<?php echo SERVERURL; ?>core/convertirCotizacion.php';

    $.ajax({
        type: 'POST',
        url: url,
        async: false,
        data: 'cotizacion_id=' + cotizacion_id,
        success: function(data) {
            var valores = eval(data);

            if (valores[0] == 1) {
                pago(valores[1]);
                listar_busqueda_cotizaciones();
            }
        }
    });
}

//BUSQUEDA DE FACTURAS EN BORRADOR
$("#addDraft").on("click", function(e) {
    e.preventDefault();

    listar_busqueda_bill_draf();

    $('#modal_buscar_bill_draft').modal({
        show: true,
        keyboard: false,
        backdrop: 'static'
    });
});

var listar_busqueda_bill_draf = function() {
    var fechai = $("#formulario_bill_draft #fechai").val();
    var fechaf = $("#formulario_bill_draft #fechaf").val();

    var table_busqueda_bill_draft = $("#DatatableBusquedaBillDraft").DataTable({
        "destroy": true,
        "ajax": {
            "method": "POST",
            "url": "<?php echo SERVERURL; ?>core/llenarDataTableFacturasBorrador.php",
            "data": {
                "fechai": fechai,
                "fechaf": fechaf
            }
        },
        "columns": [{
                "defaultContent": "<button class='table_pay pay btn btn-dark ocultar'><span class='fas fa-play fa-lg'></span></button>"
            },
            {
                "defaultContent": "<button class='table_eliminar eliminar btn btn-dark ocultar'><span class='fa fa-trash fa-lg'></span></button>"
            },
            {
                "data": "fecha"
            },
            {
                "data": "tipo_documento"
            },
            {
                "data": "cliente"
            },
            {
                "data": "numero"
            },
            {
                "data": "subtotal",
                render: function(data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, 'L ')
                        .display(data);

                    if (type === 'display') {
                        let color = 'black';
                        if (data < 0) {
                            color = 'red';
                        }

                        return '<span style="color:' + color + '">' + number + '</span>';
                    }

                    return number;
                },
            },
            {
                "data": "isv",
                render: function(data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, 'L ')
                        .display(data);

                    if (type === 'display') {
                        let color = 'black';
                        if (data < 0) {
                            color = 'red';
                        }

                        return '<span style="color:' + color + '">' + number + '</span>';
                    }

                    return number;
                },
            },
            {
                "data": "descuento",
                render: function(data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, 'L ')
                        .display(data);

                    if (type === 'display') {
                        let color = 'black';
                        if (data < 0) {
                            color = 'red';
                        }

                        return '<span style="color:' + color + '">' + number + '</span>';
                    }

                    return number;
                },
            },
            {
                "data": "total",
                render: function(data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, 'L ')
                        .display(data);

                    if (type === 'display') {
                        let color = 'black';
                        if (data < 0) {
                            color = 'red';
                        }

                        return '<span style="color:' + color + '">' + number + '</span>';
                    }

                    return number;
                },
            }
        ],
        "pageLength": 5,
        "lengthMenu": lengthMenu,
        "stateSave": true,
        "bDestroy": true,
        "language": idioma_español,
        "dom": dom,
        "buttons": [{
            text: '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
            titleAttr: 'Actualizar Facturas Borrador',
            className: 'table_actualizar btn btn-secondary ocultar',
            action: function() {
                listar_busqueda_bill_draf();
            }
        }],
        "drawCallback": function(settings) {
            getPermisosTipoUsuarioAccesosTable(getPrivilegioTipoUsuario());
        }
    });
    table_busqueda_bill_draft.search('').draw();
    $('#buscar').focus();

    continue_bill_draft_dataTable("#DatatableBusquedaBillDraft tbody", table_busqueda_bill_draft);
    delete_bill_draft_dataTable("#DatatableBusquedaBillDraft tbody", table_busqueda_bill_draft);
}

var continue_bill_draft_dataTable = function(tbody, table) {
    $(tbody).off("click", "button.pay");
    $(tbody).on("click", "button.pay", function(e) {
        e.preventDefault();
        var data = table.row($(this).parents("tr")).data();

        $("#invoice-form #facturas_id").val(data.facturas_id);

        var url = '<?php echo SERVERURL; ?>core/getDraftBills.php';

        $.ajax({
            type: 'POST',
            url: url,
            async: false,
            data: 'facturas_id=' + data.facturas_id,
            success: function(data) {
                var datos = eval(data);
                limpiarTablaFacturaDetalles(0);
                for (var fila = 0; fila < datos.length; fila++) {
                    var barCode = datos[fila]["barCode"];
                    var facturas_detalle_id = datos[fila]["facturas_detalle_id"];
                    var productoID = datos[fila]["productos_id"];
                    var productName = datos[fila]["producto"];
                    var quantity = datos[fila]["cantidad"];
                    var precio_venta = datos[fila]["precio_venta"];
                    var price = datos[fila]["precio"];
                    var discount = datos[fila]["descuento"];
                    var isv = datos[fila]["isv_valor"];
                    var producto_isv = datos[fila]["isv_venta"];
                    var cantidad_mayoreo = datos[fila]["cantidad_mayoreo"];
                    var almacen_id = datos[fila]["almacen_id"];
                    var medida = datos[fila]["medida"];

                    $("#invoice-form #invoiceItem #facturas_detalle_id_" + fila).val(
                        facturas_detalle_id);
                    $("#invoice-form #invoiceItem #bar-code-id_" + fila).val(barCode);
                    $("#invoice-form #invoiceItem #productos_id_" + fila).val(productoID);
                    $("#invoice-form #invoiceItem #productName_" + fila).val(productName);
                    $("#invoice-form #invoiceItem #price_" + fila).val(price);
                    $("#invoice-form #invoiceItem #precio_real_" + fila).val(price);
                    $("#invoice-form #invoiceItem #isv_" + fila).val(producto_isv);
                    $("#invoice-form #invoiceItem #valor_isv_" + fila).val(isv);
                    $("#invoice-form #invoiceItem #cantidad_mayoreo_" + fila).val(
                        cantidad_mayoreo);
                    $("#invoice-form #invoiceItem #precio_mayoreo_" + fila).val(precio_mayoreo);
                    $("#invoice-form #invoiceItem #quantity_" + fila).val(quantity);
                    $("#invoice-form #invoiceItem #discount_" + fila).val(discount);
                    $('#invoice-form #invoiceItem #bodega_' + fila).val(almacen_id);
                    $('#invoice-form #invoiceItem #medida_' + fila).val(medida);
                    addRowFacturas();
                }

                calculateTotalFacturas();

                $('#modal_buscar_bill_draft').modal('hide');
            }
        });
    });
}

var delete_bill_draft_dataTable = function(tbody, table) {
    $(tbody).off("click", "button.eliminar");
    $(tbody).on("click", "button.eliminar", function(e) {
        e.preventDefault();
        var data = table.row($(this).parents("tr")).data();
        deleteBillDraft(data.facturas_id)
    });
}

function deleteBillDraft(facturas_id) {
    swal({
        title: "¿Estas seguro?",
        text: "¿Desea anular la factura: # " + getNumeroFactura(facturas_id) + "?",
        icon: "warning",
        buttons: {
            cancel: {
                text: "Cancelar",
                visible: true
            },
            confirm: {
                text: "¡Sí, anular la factura!",
            }
        },
        dangerMode: true,
        closeOnEsc: false, // Desactiva el cierre con la tecla Esc
        closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera 
    }).then((willConfirm) => {
        if (willConfirm === true) {
            deleteBill(facturas_id);
        }
    });
}

function deleteBill(facturas_id) {
    var url = '<?php echo SERVERURL; ?>core/deleteBillDraft.php';

    $.ajax({
        type: 'POST',
        url: url,
        async: false,
        data: 'facturas_id=' + facturas_id,
        success: function(data) {
            if (data == 1) {
                swal({
                    title: "Success",
                    text: "La factura en borrador ha sido eliminada con éxito",
                    icon: "success",
                    closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                    closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera                     
                });
                listar_busqueda_bill_draf();
            } else {
                swal({
                    title: "Error",
                    text: "La factura no se puede eliminar",
                    icon: "error",
                    dangerMode: true,
                    closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                    closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera 
                });
            }
        }
    });
}

//BUSQUEDA FACTURAS AL CREDITO Y CONTADO
$("#BillReports").on("click", function(e) {
    e.preventDefault();

    listar_busqueda_bill();

    $('#modal_buscar_bill').modal({
        show: true,
        keyboard: false,
        backdrop: 'static'
    });
});

function getTipoDocumento() {
    var url = '<?php echo SERVERURL; ?>core/getTipoDocumento.php';
	var Documento;
    $.ajax({
        type: 'POST',
        url: url,
        async: false,
        success: function(response) {
			var datos = eval(response);
	
			Documento = datos[0];				
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud:", error);
        }
    });
	
	return Documento;
}

var listar_busqueda_bill = function() {
    var tipo_factura_reporte = 1;
    if ($("#formulario_bill #tipo_factura_reporte").val() == null || $("#formulario_bill #tipo_factura_reporte")
        .val() == "") {
        tipo_factura_reporte = 1;
    } else {
        tipo_factura_reporte = $("#formulario_bill #tipo_factura_reporte").val();
    }

    var fechai = $("#formulario_bill #fechai").val();
    var fechaf = $("#formulario_bill #fechaf").val();
    var facturador = $("#formulario_bill #facturador").val();
    var vendedor = $("#formulario_bill #vendedor").val();
	var factura = getTipoDocumento();
	
    if (factura === "No hay datos que mostrar" || factura === "Error en la solicitud") {
        swal({
            title: "Error",
            text: "Lo sentimos, hubo un error al obtener la información de la factura.",
            icon: "error",
            dangerMode: true,
            closeOnEsc: false, // Desactiva el cierre con la tecla Esc
            closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera 
        });
        return;
    }
	
    var table_busqueda_bill = $("#DatatableBusquedaBill").DataTable({
        "destroy": true,
        "ajax": {
            "method": "POST",
            "url": "<?php echo SERVERURL; ?>core/llenarDataTableReporteVentas.php",
            "data": {
                "tipo_factura_reporte": tipo_factura_reporte,
                "facturador": facturador,
                "vendedor": vendedor,
				"factura": factura,
                "fechai": fechai,
                "fechaf": fechaf
            }
        },
        "columns": [{
                "data": "fecha"
            },
            {
                "data": "tipo_documento"
            },
            {
                "data": "cliente"
            },
            {
                "data": "numero"
            },
            {
                "data": "subtotal",
                render: function(data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, 'L ')
                        .display(data);

                    if (type === 'display') {
                        let color = 'black';
                        if (data < 0) {
                            color = 'red';
                        }

                        return '<span style="color:' + color + '">' + number + '</span>';
                    }

                    return number;
                },
            },
            {
                "data": "isv",
                render: function(data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, 'L ')
                        .display(data);

                    if (type === 'display') {
                        let color = 'black';
                        if (data < 0) {
                            color = 'red';
                        }

                        return '<span style="color:' + color + '">' + number + '</span>';
                    }

                    return number;
                },
            },
            {
                "data": "descuento",
                render: function(data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, 'L ')
                        .display(data);

                    if (type === 'display') {
                        let color = 'black';
                        if (data < 0) {
                            color = 'red';
                        }

                        return '<span style="color:' + color + '">' + number + '</span>';
                    }

                    return number;
                },
            },
            {
                "data": "total",
                render: function(data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, 'L ')
                        .display(data);

                    if (type === 'display') {
                        let color = 'black';
                        if (data < 0) {
                            color = 'red';
                        }

                        return '<span style="color:' + color + '">' + number + '</span>';
                    }

                    return number;
                },
            },
            {
                "defaultContent": "<button class='table_reportes print_factura btn btn-dark ocultar'><span class='fas fa-file-download fa-lg'></span></button>"
            },
            {
                "defaultContent": "<button class='table_reportes print_comprobante btn btn-dark ocultar'><span class='far fa-file-pdf fa-lg'></span></button>"
            },
            {
                "defaultContent": "<button class='table_reportes email_factura btn btn-dark ocultar'><span class='fas fa-paper-plane fa-lg'></span></button>"
            },
            {
                "defaultContent": "<button class='table_cancelar cancelar_factura btn btn-dark ocultar'><span class='fas fa-ban fa-lg'></span></button>"
            }
        ],
        "lengthMenu": lengthMenu,
        "stateSave": true,
        "bDestroy": true,
        "language": idioma_español,
        "dom": dom,
        "columnDefs": [{
                width: "9.09%",
                targets: 0
            },
            {
                width: "9.09%",
                targets: 1
            },
            {
                width: "19.09%",
                targets: 2
            },
            {
                width: "18.09%",
                targets: 3
            },
            {
                width: "9.09%",
                targets: 4
            },
            {
                width: "9.09%",
                targets: 5
            },
            {
                width: "9.09%",
                targets: 6
            },
            {
                width: "9.09%",
                targets: 7
            },
            {
                width: "3.09%",
                targets: 8
            },
            {
                width: "3.09%",
                targets: 9
            },
            {
                width: "2.09%",
                targets: 10
            }
        ],
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            $('td', nRow).addClass(aData['color']);
        },
        "buttons": [{
            text: '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
            titleAttr: 'Actualizar Facturas Borrador',
            className: 'table_actualizar btn btn-secondary ocultar',
            action: function() {
                listar_busqueda_bill();
            }
        }],
        "drawCallback": function(settings) {
            getPermisosTipoUsuarioAccesosTable(getPrivilegioTipoUsuario());
        }
    });
    table_busqueda_bill.search('').draw();
    $('#buscar').focus();

    view_correo_bills_dataTable("#DatatableBusquedaBill tbody", table_busqueda_bill);
    view_reporte_bill_dataTable("#DatatableBusquedaBill tbody", table_busqueda_bill);
    view_comoprobante_bill_dataTable("#DatatableBusquedaBill tbody", table_busqueda_bill);
    view_anular_bill_dataTable("#DatatableBusquedaBill tbody", table_busqueda_bill);
}

var view_anular_bill_dataTable = function(tbody, table) {
    $(tbody).off("click", "button.cancelar_factura");
    $(tbody).on("click", "button.cancelar_factura", function(e) {
        e.preventDefault();
        var data = table.row($(this).parents("tr")).data();
        anularFacturas(data.facturas_id);
    });
}

var view_correo_bills_dataTable = function(tbody, table) {
    $(tbody).off("click", "button.email_factura");
    $(tbody).on("click", "button.email_factura", function(e) {
        e.preventDefault();
        var data = table.row($(this).parents("tr")).data();
        mailBill(data.facturas_id);
    });
}

var view_reporte_bill_dataTable = function(tbody, table) {
    $(tbody).off("click", "button.print_factura");
    $(tbody).on("click", "button.print_factura", function(e) {
        e.preventDefault();
        var data = table.row($(this).parents("tr")).data();
        printBill(data.facturas_id);
    });
}

var view_comoprobante_bill_dataTable = function(tbody, table) {
    $(tbody).off("click", "button.print_comprobante");
    $(tbody).on("click", "button.print_comprobante", function(e) {
        e.preventDefault();
        var data = table.row($(this).parents("tr")).data();
        var url_comprobante = '<?php echo SERVERURL; ?>core/generaComprobante.php?facturas_id=' + data
            .facturas_id;
        window.open(url_comprobante);
    });
}

function anularFacturas(facturas_id) {
    swal({
        title: "¿Estas seguro?",
        text: "¿Desea anular la factura: # " + getNumeroFactura(facturas_id) + "?",
        icon: "warning",
        buttons: {
            cancel: {
                text: "Cancelar",
                visible: true
            },
            confirm: {
                text: "¡Sí, anular la factura!",
            }
        },
        dangerMode: true,
        closeOnEsc: false, // Desactiva el cierre con la tecla Esc
        closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera 
    }).then((willConfirm) => {
        if (willConfirm === true) {
            anular(facturas_id);
        }
    });
}

function anular(facturas_id) {
    var url = '<?php echo SERVERURL; ?>core/anularFactura.php';

    $.ajax({
        type: 'POST',
        url: url,
        async: false,
        data: 'facturas_id=' + facturas_id,
        success: function(data) {
            if (data == 1) {
                swal({
                    title: "Success",
                    text: "La factura ha sido anulada con éxito",
                    icon: "success",
                    closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                    closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera                     
                });
                listar_busqueda_bill();
            } else {
                swal({
                    title: "Error",
                    text: "La factura no se puede anular",
                    icon: "error",
                    dangerMode: true,
                    closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                    closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera 
                });
            }
        }
    });
}

function getReporteFactura() {
    var url = '<?php echo SERVERURL; ?>core/getTipoFacturaReporte.php';

    $.ajax({
        type: "POST",
        url: url,
        async: true,
        success: function(data) {
            $('#formulario_bill #tipo_factura_reporte').html("");
            $('#formulario_bill #tipo_factura_reporte').html(data);
            $('#formulario_bill #tipo_factura_reporte').selectpicker('refresh');
        }
    });
}

function getEstadoFacturaCredito() {
    var url = '<?php echo SERVERURL; ?>core/getEstadoFacturaCredito.php';

    $.ajax({
        type: "POST",
        url: url,
        async: true,
        success: function(data) {
            $('#formulario_busqueda_cuentas_cobrar_clientes #cobrar_clientes_estado').html("");
            $('#formulario_busqueda_cuentas_cobrar_clientes #cobrar_clientes_estado').html(data);
            $('#formulario_busqueda_cuentas_cobrar_clientes #cobrar_clientes_estado').selectpicker(
                'refresh');
        }
    });
}

$('#formulario_bill_draft #search').on("click", function(e) {
    e.preventDefault();
    listar_busqueda_bill_draf();
});

$('#formulario_bill #search').on("click", function(e) {
    e.preventDefault();
    listar_busqueda_bill();
});

//INICIO DESCUENTO PRODUCTO EN FACTURACION
$(() => {
    $("#invoice-form #invoiceItem").on('click', '.aplicar_descuento', function(e) {
        e.preventDefault();
        $('#formDescuentoFacturacion')[0].reset();

        var row_index = $(this).closest("tr").index();
        var col_index = $(this).closest("td").index();

        if ($('#invoice-form #cliente_id').val() != "" && $("#invoice-form #invoiceItem #productos_id_" + row_index).val() != "") {
            $('#formDescuentoFacturacion #row_index').val(row_index);
            $('#formDescuentoFacturacion #col_index').val(col_index);

            var productos_id = $("#invoice-form #invoiceItem #productos_id_" + row_index).val();
            var producto = $("#invoice-form #invoiceItem #productName_" + row_index).val();
            var precio = $("#invoice-form #invoiceItem #price_" + row_index).val();
            var cantidad = $("#invoice-form #invoiceItem #quantity_" + row_index).val();
            var total = precio * cantidad;

            $('#formDescuentoFacturacion #descuento_productos_id').val(productos_id);
            $('#formDescuentoFacturacion #producto_descuento_fact').val(producto);
            $('#formDescuentoFacturacion #precio_descuento_fact').val(total); // Guardamos el total, no el precio unitario
            $('#formDescuentoFacturacion #cantidad_descuento_fact').val(cantidad); // Guardamos la cantidad

            $('#formDescuentoFacturacion #pro_descuento_fact').val("Aplicar Descuento");

            $('#modalDescuentoFacturacion').modal({
                show: true,
                keyboard: false,
                backdrop: 'static'
            });
        } else {
            showNotify('error', 'Error', 'Debe seleccionar un cliente y un producto antes de continuar');
        }
    });

    // Cálculo del descuento en porcentaje
    $("#formDescuentoFacturacion #porcentaje_descuento_fact").on("keyup", function() {
        var total = parseFloat($('#formDescuentoFacturacion #precio_descuento_fact').val());
        var porcentaje = parseFloat($(this).val()) || 0;

        var descuento = total * (porcentaje / 100);
        $('#formDescuentoFacturacion #descuento_fact').val(descuento.toFixed(2));
    });

    // Cálculo del porcentaje cuando se ingresa el monto directo
    $("#formDescuentoFacturacion #descuento_fact").on("keyup", function() {
        var total = parseFloat($('#formDescuentoFacturacion #precio_descuento_fact').val());
        var descuento = parseFloat($(this).val()) || 0;

        var porcentaje = (descuento / total) * 100;
        $('#formDescuentoFacturacion #porcentaje_descuento_fact').val(porcentaje.toFixed(2));
    });
});

// Aplicar el descuento
$("#reg_DescuentoFacturacion").on("click", function(e) {
    e.preventDefault();
    var row_index = $('#formDescuentoFacturacion #row_index').val();
    var col_index = $('#formDescuentoFacturacion #col_index').val();

    var descuento = parseFloat($('#formDescuentoFacturacion #descuento_fact').val()) || 0;
    var precio = parseFloat($("#invoice-form #invoiceItem #price_" + row_index).val());
    var cantidad = parseFloat($("#invoice-form #invoiceItem #quantity_" + row_index).val());
    var impuesto_venta = $("#invoice-form #invoiceItem #isv_" + row_index).val();
    
    // Guardamos el descuento en la fila
    $("#invoice-form #invoiceItem #discount_" + row_index).val(descuento.toFixed(2));

    var total_sin_descuento = precio * cantidad;
    var total_con_descuento = total_sin_descuento - descuento;

    if (total_con_descuento >= 0) {
        // Cálculo de ISV
        if (impuesto_venta == 1) {
            var porcentaje_isv = parseFloat(getPorcentajeISV("Facturas") / 100);
            var isv_actual = parseFloat($('#invoice-form #taxAmount').val()) || 0;
            var isv_nuevo = (total_con_descuento * porcentaje_isv).toFixed(2);
            
            // Actualizamos el ISV
            $('#invoice-form #taxAmount').val(parseFloat(isv_actual) + parseFloat(isv_nuevo));
            $('#invoice-form #invoiceItem #valor_isv_' + row_index).val(isv_nuevo);
        }

        $('#modalDescuentoFacturacion').modal('hide');
        calculateTotalFacturas();
    } else {
        showNotify('warning', 'Advertencia', 'El valor del descuento es mayor al precio total del artículo, por favor corregir');
    }
});
//FIN DESCUENTO PRODUCTO EN FACTURACION

//INICIO MODIFICAR PRECIO EN PRODUCTO FACTURACION
$(document).ready(function() {
    $("#invoice-form #invoiceItem").on('click', '.aplicar_precio', function(e) {
        e.preventDefault();
        $('#formModificarPrecioFacturacion')[0].reset();

        var row_index = $(this).closest("tr").index();
        var col_index = $(this).closest("td").index();
        $('#formModificarPrecioFacturacion #row_index').val(row_index);
        $('#formModificarPrecioFacturacion #col_index').val(col_index);

        if ($("#invoice-form #invoiceItem #productos_id_" + row_index).val() != "") {
            $('#formModificarPrecioFacturacion')[0].reset();
            var clientes_id = $("#invoice-form #cliente_id").val();
            var fecha = $("#invoice-form #fecha").val();
            var productos_id = $("#invoice-form #invoiceItem #productos_id_" + row_index).val();
            var producto = $("#invoice-form #invoiceItem #productName_" + row_index).val();
            var precio = $("#invoice-form #invoiceItem #price_" + row_index).val();

            $('#formModificarPrecioFacturacion #modificar_precio_fecha').val(fecha);
            $('#formModificarPrecioFacturacion #modificar_precio_clientes_id').val(clientes_id);
            $('#formModificarPrecioFacturacion #modificar_precio_productos_id').val(productos_id);
            $('#formModificarPrecioFacturacion #producto_modificar_precio_fact').val(producto);

            $('#formModificarPrecioFacturacion #pro_modificar_precio').val("Aplicar Nuevo Precio");

            $('#modalModificarPrecioFacturacion').modal({
                show: true,
                keyboard: false,
                backdrop: 'static'
            });
        } else {
            swal({
                title: "Error",
                text: "Debe seleccionar un cliente y un producto antes de continuar",
                icon: "error",
                dangerMode: true,
                closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera 
            });
        }
    });
});
//FIN MODIFICAR PRECIO EN PRODUCTO FACTURACION
</script>
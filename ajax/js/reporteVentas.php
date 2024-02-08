<script>
$(document).ready(function() {
    getReporteFactura();
    getFacturador();
    getVendedores();
    listar_reporte_ventas();
    $('#form_main_ventas #tipo_factura_reporte').val(1);
    $('#form_main_ventas #tipo_factura_reporte').selectpicker('refresh');
});

$('#form_main_ventas #tipo_factura_reporte').on("change", function(e) {
    listar_reporte_ventas();
});

$('#form_main_ventas #facturador').on("change", function(e) {
    listar_reporte_ventas();
});

$('#form_main_ventas #vendedor').on("change", function(e) {
    listar_reporte_ventas();
});

$('#form_main_ventas #fechai').on("change", function(e) {
    listar_reporte_ventas();
});

$('#form_main_ventas #fechaf').on("change", function(e) {
    listar_reporte_ventas();
});

function customRound(number) {
    var truncated = Math.floor(number * 100) / 100; // Trunca a dos decimales
    var secondDecimal = Math.floor((number * 100) % 10); // Obtiene el segundo decimal

    if (secondDecimal >= 5) { // Si el segundo decimal es mayor o igual a 5, redondea hacia arriba
        return parseFloat((truncated + 0.01).toFixed(2)); // Redondea hacia arriba
    } else { // Si el segundo decimal es menor que 5, no redondea
        return parseFloat(truncated.toFixed(2)); // No redondea
    }
}

//INICIO REPORTE DE VENTAS
var listar_reporte_ventas = function() {
    var tipo_factura_reporte = 1;

    if ($("#form_main_ventas #tipo_factura_reporte").val() == null || $("#form_main_ventas #tipo_factura_reporte")
        .val() == "") {
        tipo_factura_reporte = 1;
    } else {
        tipo_factura_reporte = $("#form_main_ventas #tipo_factura_reporte").val();
    }

    var fechai = $("#form_main_ventas #fechai").val();
    var fechaf = $("#form_main_ventas #fechaf").val();
    var facturador = $("#form_main_ventas #facturador").val();
    var vendedor = $("#form_main_ventas #vendedor").val();

    var table_reporteVentas = $("#dataTablaReporteVentas").DataTable({
        "destroy": true,
        "footer": true,
        "ajax": {
            "method": "POST",
            "url": "<?php echo SERVERURL;?>core/llenarDataTableReporteVentas.php",
            "data": {
                "tipo_factura_reporte": tipo_factura_reporte,
                "facturador": facturador,
                "vendedor": vendedor,
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
                        let color = 'green';
                        if (data < 0) {
                            color = 'red';
                        }

                        // Aplicar el redondeo personalizado a 'data' antes de mostrarlo
                        var roundedNumber = customRound(parseFloat(data));

                        // Formatear el número redondeado con punto para decimales y coma para separar miles
                        var formattedNumber = new Intl.NumberFormat('es-ES', {
                            style: 'currency',
                            currency: 'HNL', // Utilizar la moneda HNL (Lempira hondureño)
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }).format(roundedNumber).replace(',', '.');

                        // Separar miles con coma
                        formattedNumber = formattedNumber.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                        return '<span style="color:' + color + '">' + formattedNumber + '</span>';
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
                        let color = 'green';
                        if (data < 0) {
                            color = 'red';
                        }

                        // Aplicar el redondeo personalizado a 'data' antes de mostrarlo
                        var roundedNumber = customRound(parseFloat(data));

                        // Formatear el número redondeado con punto para decimales y coma para separar miles
                        var formattedNumber = new Intl.NumberFormat('es-ES', {
                            style: 'currency',
                            currency: 'HNL', // Utilizar la moneda HNL (Lempira hondureño)
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }).format(roundedNumber).replace(',', '.');

                        // Separar miles con coma
                        formattedNumber = formattedNumber.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                        return '<span style="color:' + color + '">' + formattedNumber + '</span>';
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
                        let color = 'green';
                        if (data < 0) {
                            color = 'red';
                        }

                        // Aplicar el redondeo personalizado a 'data' antes de mostrarlo
                        var roundedNumber = customRound(parseFloat(data));

                        // Formatear el número redondeado con punto para decimales y coma para separar miles
                        var formattedNumber = new Intl.NumberFormat('es-ES', {
                            style: 'currency',
                            currency: 'HNL', // Utilizar la moneda HNL (Lempira hondureño)
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }).format(roundedNumber).replace(',', '.');

                        // Separar miles con coma
                        formattedNumber = formattedNumber.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                        return '<span style="color:' + color + '">' + formattedNumber + '</span>';
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
                        let color = 'green';
                        if (data < 0) {
                            color = 'red';
                        }

                        // Aplicar el redondeo personalizado a 'data' antes de mostrarlo
                        var roundedNumber = customRound(parseFloat(data));

                        // Formatear el número redondeado con punto para decimales y coma para separar miles
                        var formattedNumber = new Intl.NumberFormat('es-ES', {
                            style: 'currency',
                            currency: 'HNL', // Utilizar la moneda HNL (Lempira hondureño)
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }).format(roundedNumber).replace(',', '.');

                        // Separar miles con coma
                        formattedNumber = formattedNumber.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                        return '<span style="color:' + color + '">' + formattedNumber + '</span>';
                    }

                    return number;
                },
            },
            {
                "data": "ganancia",
                render: function(data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, 'L ')
                        .display(data);

                    if (type === 'display') {
                        let color = 'green';
                        if (data < 0) {
                            color = 'red';
                        }

                        // Aplicar el redondeo personalizado a 'data' antes de mostrarlo
                        var roundedNumber = customRound(parseFloat(data));

                        // Formatear el número redondeado con punto para decimales y coma para separar miles
                        var formattedNumber = new Intl.NumberFormat('es-ES', {
                            style: 'currency',
                            currency: 'HNL', // Utilizar la moneda HNL (Lempira hondureño)
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }).format(roundedNumber).replace(',', '.');

                        // Separar miles con coma
                        formattedNumber = formattedNumber.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                        return '<span style="color:' + color + '">' + formattedNumber + '</span>';
                    }

                    return number;
                },
            },
            {
                "data": "vendedor"
            },
            {
                "data": "facturador"
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
        "lengthMenu": lengthMenu10,
        "stateSave": true,
        "bDestroy": true,
        "language": idioma_español, // esta se encuentra en el archivo main.js
        "dom": dom,
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            $('td', nRow).addClass(aData['color']);
        },
        "footerCallback": function(row, data, start, end, display) {
            // Aquí puedes calcular los totales y actualizar el footer
            var totalSubtotal = data.reduce(function(acc, row) {
                return acc + (parseFloat(row.subtotal) || 0);
            }, 0);

            var totalIsv = data.reduce(function(acc, row) {
                return acc + (parseFloat(row.isv) || 0);
            }, 0);

            var totalDescuento = data.reduce(function(acc, row) {
                return acc + (parseFloat(row.descuento) || 0);
            }, 0);

            var totalVentas = data.reduce(function(acc, row) {
                return acc + (parseFloat(row.total) || 0);
            }, 0);

            var totalGanancia = data.reduce(function(acc, row) {
                return acc + (parseFloat(row.ganancia) || 0);
            }, 0);

            // Formatear los totales con separadores de miles y coma para decimales
            var formatter = new Intl.NumberFormat('es-HN', {
                style: 'currency',
                currency: 'HNL',
                minimumFractionDigits: 2,
            });

            var totalSubtotalFormatted = "L. " + formatter.format(totalSubtotal);
            var totalIsvFormatted = "L. " + formatter.format(totalIsv);
            var totalDescuentoFormatted = "L. " + formatter.format(totalDescuento);
            var totalVentasFormatted = "L. " + formatter.format(totalVentas);
            var totalGananciaFormatted = "L. " + formatter.format(totalGanancia);

            // Asignar los totales a los elementos HTML en el footer
            $('#subtotal-i').html(totalSubtotalFormatted);
            $('#impuesto-i').html(totalIsvFormatted);
            $('#descuento-i').html(totalDescuentoFormatted);
            $('#total-footer-ingreso').html(totalVentasFormatted);
            $('#ganancia').html(totalGananciaFormatted);
        },
        "buttons": [{
                text: '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
                titleAttr: 'Actualizar Reporte de Ventas',
                className: 'table_actualizar btn btn-secondary ocultar',
                action: function() {
                    listar_reporte_ventas();
                    total_ingreso_footer();
                }
            },
            {
                extend: 'excelHtml5',
                footer: true,
                text: '<i class="fas fa-file-excel fa-lg"></i> Excel',
                titleAttr: 'Excel',
                title: 'Reporte de Ventas',
                messageTop: 'Fecha desde: ' + convertDateFormat(fechai) + ' Fecha hasta: ' +
                    convertDateFormat(fechaf),
                messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                },
                className: 'table_reportes btn btn-success ocultar'
            },
            {
                extend: 'pdf',
                footer: true,
                orientation: 'landscape',
                text: '<i class="fas fa-file-pdf fa-lg"></i> PDF',
                titleAttr: 'PDF',
                orientation: 'landscape',
                pageSize: 'LETTER',
                title: 'Reporte de Ventas',
                messageTop: 'Fecha desde: ' + convertDateFormat(fechai) + ' Fecha hasta: ' +
                    convertDateFormat(fechaf),
                messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
                className: 'table_reportes btn btn-danger ocultar',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                },
                customize: function(doc) {
                    doc.content.splice(1, 0, {
                        margin: [0, 0, 0, 2],
                        alignment: 'left',
                        image: imagen,
                        width: 100,
                        height: 45
                    });
                }
            }
        ],
        "drawCallback": function(settings) {
            getPermisosTipoUsuarioAccesosTable(getPrivilegioTipoUsuario());
        }
    });

    table_reporteVentas.search('').draw();
    $('#buscar').focus();

    view_correo_facturas_dataTable("#dataTablaReporteVentas tbody", table_reporteVentas);
    view_reporte_facturas_dataTable("#dataTablaReporteVentas tbody", table_reporteVentas);
    view_reporte_comprobante_dataTable("#dataTablaReporteVentas tbody", table_reporteVentas);
    view_anular_facturas_dataTable("#dataTablaReporteVentas tbody", table_reporteVentas);

    // Función para determinar el color de fondo de la fila
    function determinarColorFila(saldo) {
        return saldo < 0 ? 'fila-roja' : 'fila-verde'; // Puedes ajustar los nombres de las clases según tu estilo
    }

    // Callback para colorear las filas según el saldo
    table_reporteVentas.on('draw', function() {
        table_reporteVentas.rows().every(function(index, element) {
            var saldo = parseFloat(this.data().saldo) || 0;
            var color = determinarColorFila(saldo);

            $(this.node()).removeClass('fila-roja fila-verde').addClass(color);
        });
    });
};

var view_anular_facturas_dataTable = function(tbody, table) {
    $(tbody).off("click", "button.cancelar_factura");
    $(tbody).on("click", "button.cancelar_factura", function(e) {
        e.preventDefault();
        var data = table.row($(this).parents("tr")).data();
        anularFacturas(data.facturas_id);
    });
}

var view_correo_facturas_dataTable = function(tbody, table) {
    $(tbody).off("click", "button.email_factura");
    $(tbody).on("click", "button.email_factura", function(e) {
        e.preventDefault();
        var data = table.row($(this).parents("tr")).data();
        mailBill(data.facturas_id);
    });
}

var view_reporte_facturas_dataTable = function(tbody, table) {
    $(tbody).off("click", "button.print_factura");
    $(tbody).on("click", "button.print_factura", function(e) {
        e.preventDefault();
        var data = table.row($(this).parents("tr")).data();
        printBillReporteVentas(data.facturas_id);
    });
}

var view_reporte_comprobante_dataTable = function(tbody, table) {
    $(tbody).off("click", "button.print_comprobante");
    $(tbody).on("click", "button.print_comprobante", function(e) {
        e.preventDefault();
        var data = table.row($(this).parents("tr")).data();
        printBillComprobanteReporteVentas(data.facturas_id);
    });
}

function anularFacturas(facturas_id) {
    swal({
        title: "¿Esta seguro?",
        text: "¿Desea anular la factura: # " + getNumeroFactura(facturas_id) + "?",
        type: "input",
        showCancelButton: true,
        closeOnConfirm: false,
        inputPlaceholder: "Comentario",
        cancelButtonText: "Cancelar",
        confirmButtonText: "¡Sí, cancelar la factura!",
        confirmButtonClass: "btn-warning"
    }, function(inputValue) {
        if (inputValue === false) return false;
        if (inputValue === "") {
            swal.showInputError("¡Necesita escribir algo!");
            return false
        }
        anular(facturas_id, inputValue);
    });
}

function anular(facturas_id, comentario) {
    var url = '<?php echo SERVERURL; ?>core/anularFactura.php';

    $.ajax({
        type: 'POST',
        url: url,
        async: false,
        data: 'facturas_id=' + facturas_id + '&comentario=' + comentario,
        success: function(data) {
            if (data == 1) {
                swal({
                    title: "Success",
                    text: "La factura ha sido anulada con éxito",
                    type: "success",
                });
                listar_reporte_ventas();
            } else {
                swal({
                    title: "Error",
                    text: "La factura no se puede anular",
                    type: "error",
                    confirmButtonClass: "btn-danger",
                });
            }
        }
    });
}

function getReporteFactura() {
    var url = '<?php echo SERVERURL;?>core/getTipoFacturaReporte.php';

    $.ajax({
        type: "POST",
        url: url,
        async: true,
        success: function(data) {
            $('#form_main_ventas #tipo_factura_reporte').html("");
            $('#form_main_ventas #tipo_factura_reporte').html(data);
            $('#form_main_ventas #tipo_factura_reporte').selectpicker('refresh');
        }
    });
}

function getFacturador() {
    var url = '<?php echo SERVERURL;?>core/getFacturador.php';

    $.ajax({
        type: "POST",
        url: url,
        async: true,
        success: function(data) {
            $('#form_main_ventas #facturador').html("");
            $('#form_main_ventas #facturador').html(data);
            $('#form_main_ventas #facturador').selectpicker('refresh');
        }
    });
}

function getVendedores() {
    var url = '<?php echo SERVERURL;?>core/getColaboradores.php';

    $.ajax({
        type: "POST",
        url: url,
        async: true,
        success: function(data) {

            $('#form_main_ventas #vendedor').html("");
            $('#form_main_ventas #vendedor').html(data);
            $('#form_main_ventas #vendedor').selectpicker('refresh');
        }
    });
}
//FIN REPORTE DE VENTAS
</script>
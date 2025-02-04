<script>
//DASHBOARD
function setTotalCustomers() {
    var url = '<?php echo SERVERURL;?>core/getTotalCustomers.php';

    var isv;
    $.ajax({
        type: 'POST',
        url: url,
        async: false,
        success: function(data) {
            $('#main_clientes').html(data);
        }
    });
    return isv;
}

function setTotalSuppliers() {
    var url = '<?php echo SERVERURL;?>core/getTotalSuppliers.php';

    var isv;
    $.ajax({
        type: 'POST',
        url: url,
        async: false,
        success: function(data) {
            $('#main_proveedores').html(data);
        }
    });
    return isv;
}

function setTotalBills() {
    var url = '<?php echo SERVERURL;?>core/getTotalBills.php';

    var isv;
    $.ajax({
        type: 'POST',
        url: url,
        async: false,
        success: function(data) {
            $('#main_facturas').html("L. " + data);
        }
    });
    return isv;
}

function setTotalPurchases() {
    var url = '<?php echo SERVERURL;?>core/getTotalPurchases.php';

    var isv;
    $.ajax({
        type: 'POST',
        url: url,
        async: false,
        success: function(data) {
            $('#main_compras').html("L. " + data);
        }
    });
    return isv;
}

$(document).ready(function() {
    // DASHBOARD
    setTotalCustomers();
    setTotalSuppliers();
    setTotalBills();
    setTotalPurchases();
    getMesFacturaCompra();
    listar_secuencia_fiscales_dashboard();
    $(window).scrollTop(0);

    setInterval('setTotalCustomers()', 120000);
    setInterval('setTotalSuppliers()', 120000);
    setInterval('setTotalBills()', 120000);
    setInterval('setTotalPurchases()', 120000);

    // GRAPHICS
    showTopProductosTresMeses();
    showVentasAnuales();
    showComprasAnuales();

    setInterval('showVentasAnuales()', 120000);
    setInterval('showComprasAnuales()', 120000);
});

// GRAFICAS
function showTopProductosTresMeses() {
    var url = '<?php echo SERVERURL; ?>core/getTopProductosTresMeses.php';

    $.ajax({
        type: 'POST',
        url: url,
        success: function(data) {
            var datos = JSON.parse(data);
            var meses = [];
            var productos = {};

            datos.forEach(function(item) {
                if (!meses.includes(item.mes)) {
                    meses.push(item.mes);
                }
                if (!productos[item.producto]) {
                    productos[item.producto] = new Array(meses.length).fill(0);
                }
                productos[item.producto][meses.indexOf(item.mes)] = item.total_vendido || 0;
            });

            var datasets = Object.keys(productos).map(function(producto, index) {
                var colores = ['#4099ff', '#FF6384', '#FFCE56', '#4BC0C0', '#9966FF'];
                return {
                    label: producto,
                    backgroundColor: colores[index % colores.length],
                    borderColor: colores[index % colores.length],
                    borderWidth: 1,
                    data: productos[producto]
                };
            });

            var ctx = document.getElementById('graphTopProductosporAno').getContext('2d');

            if (window.chartTopProductosAnoActual) {
                window.chartTopProductosAnoActual.destroy();
            }

            window.chartTopProductosAnoActual = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: meses,
                    datasets: datasets
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                }
            });
        }
    });
}

function showVentasAnuales() {
    var url = '<?php echo SERVERURL;?>core/getFacturaporAno.php';

    $.ajax({
        type: 'POST',
        url: url,
        async: false,
        success: function(data) {
            var datos = eval(data);
            var mes = [];
            var total = [];

            for (var fila = 0; fila < datos.length; fila++) {
                mes.push(datos[fila]["mes"]);
                total.push(datos[fila]["total"]);
            }

            var ctx = document.getElementById('graphVentas').getContext('2d');

            // Destruir el gráfico existente si hay uno
            if (window.chartVentas) {
                window.chartVentas.destroy();
            }

            window.chartVentas = new Chart(ctx, {
                // The type of chart we want to create
                type: 'bar',

                // The data for our dataset
                data: {
                    labels: mes,
                    datasets: [{
                        label: 'Reporte de Ventas Año <?php echo date("Y"); ?>',
                        backgroundColor: '#4099ff',
                        borderColor: '#4099ff',
                        hoverBackgroundColor: '#73b4ff',
                        hoverBorderColor: '#FAFAFA',
                        borderWidth: 1,
                        data: total,
                        datalabels: {
                            color: '#4099ff',
                            anchor: 'end',
                            align: 'top',
                            labels: {
                                title: {
                                    font: {
                                        weight: 'bold'
                                    }
                                }
                            }
                        }
                    }]
                },

                // Configuration options go here
                plugins: [ChartDataLabels],
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                }
            });

            return false;
        }
    });
}

function showComprasAnuales() {
    var url = '<?php echo SERVERURL;?>core/getCompraporAno.php';

    $.ajax({
        type: 'POST',
        url: url,
        async: false,
        success: function(data) {
            var datos = eval(data);
            var mes = [];
            var total = [];

            for (var fila = 0; fila < datos.length; fila++) {
                mes.push(datos[fila]["mes"]);
                total.push(datos[fila]["total"]);
            }

            var ctx = document.getElementById('graphCompras').getContext('2d');

            // Destruir el gráfico existente si hay uno
            if (window.chartCompras) {
                window.chartCompras.destroy();
            }

            window.chartCompras = new Chart(ctx, {
                // The type of chart we want to create
                type: 'bar',

                // The data for our dataset
                data: {
                    labels: mes,
                    datasets: [{
                        label: 'Reporte de Compras Año <?php echo date("Y"); ?>',
                        backgroundColor: '#2ed8b6',
                        borderColor: '#2ed8b6',
                        hoverBackgroundColor: '#59e0c5',
                        hoverBorderColor: '#FAFAFA',
                        borderWidth: 1,
                        data: total,
                        datalabels: {
                            color: '#2ed8b6',
                            anchor: 'end',
                            align: 'top',
                            labels: {
                                title: {
                                    font: {
                                        weight: 'bold'
                                    }
                                }
                            }
                        }
                    }]
                },

                // Configuration options go here
                plugins: [ChartDataLabels],
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                }
            });

            return false;
        }
    });
}


var listar_secuencia_fiscales_dashboard = function() {
    var table_secuencia_fiscales_dashboard = $("#dataTableSecuenciaDashboard").DataTable({
        "destroy": true,
        "ajax": {
            "method": "POST",
            "url": "<?php echo SERVERURL; ?>core/llenarDataTableDocumentosFiscalesDashboard.php"
        },
        "columns": [{
                "data": "empresa"
            },
            {
                "data": "documento"
            },
            {
                "data": "inicio"
            },
            {
                "data": "fin"
            },
            {
                "data": "siguiente"
            },
            {
                "data": "fecha"
            }
        ],
        "lengthMenu": lengthMenu,
        "stateSave": true,
        "bDestroy": true,
        "language": idioma_español, //esta se encuenta en el archivo main.js
        "dom": dom,
        "columnDefs": [{
                width: "40.66%",
                targets: 0
            },
            {
                width: "12.66%",
                targets: 1
            },
            {
                width: "12.66%",
                targets: 2
            },
            {
                width: "12.66%",
                targets: 3
            },
            {
                width: "8.66%",
                targets: 4
            },
            {
                width: "12.66%",
                targets: 5
            }
        ],
        "buttons": [{
                text: '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
                titleAttr: 'Actualizar Documentos Fiscales',
                className: 'table_actualizar btn btn-secondary ocultar',
                action: function() {
                    listar_secuencia_fiscales_dashboard();
                }
            },
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel fa-lg"></i> Excel',
                titleAttr: 'Excel',
                orientation: 'landscape',
                pageSize: 'LETTER',
                title: 'Reporte Documentos Fiscales',
                messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
                className: 'table_reportes btn btn-success ocultar',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                },
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf fa-lg"></i> PDF',
                titleAttr: 'PDF',
                orientation: 'landscape',
                pageSize: 'LETTER',
                title: 'Reporte Documentos Fiscales',
                messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
                className: 'table_reportes btn btn-danger ocultar',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                },
                customize: function(doc) {
                    if (imagen) { // Solo agrega la imagen si 'imagen' tiene contenido válido
                        doc.content.splice(0, 0, {
                            image: imagen,  
                            width: 100,
                            height: 45,
                            margin: [0, 0, 0, 12]
                        });
                    }
                }
            }
        ],
        "drawCallback": function(settings) {
            getPermisosTipoUsuarioAccesosTable(getPrivilegioTipoUsuario());
        }
    });
    table_secuencia_fiscales_dashboard.search('').draw();
    $('#buscar').focus();

}
//DASHBOARD

function getMesFacturaCompra() {
    var url = '<?php echo SERVERURL;?>core/getMes.php';

    $.ajax({
        type: "POST",
        url: url,
        async: true,
        success: function(data) {
            $('#mes_factura').html(data);
            $('#mes_compra').html(data);
        }
    });
}
</script>
<script>
$(document).ready(function() {
	inventario_transferencia();
	getTipoProductos();
});

$('#form_main_movimientos #inventario_tipo_productos_id').on('change',function(){
inventario_transferencia();
});

$('#form_main_movimientos #fechai').on('change',function(){
inventario_transferencia();
});

$('#form_main_movimientos #fechaf').on('change',function(){
inventario_transferencia();
});

$('#form_main_movimientos #almacen').on('change',function(){
inventario_transferencia();
});

$('#form_main_movimientos #search').on("click", function(e){
	e.preventDefault();
	inventario_transferencia();
});

//INVENTARIO TRANSFERENCIA
var inventario_transferencia = function(){
	var tipo_producto_id;
	
	if ($('#form_main_movimientos #inventario_tipo_productos_id').val() == "" || $('#form_main_movimientos #inventario_tipo_productos_id').val() == null){
		tipo_producto_id = '';
	}else{
		tipo_producto_id = $('#form_main_movimientos #inventario_tipo_productos_id').val();
	}
	
	var fechai = $("#form_main_movimientos #fechai").val();
	var fechaf = $("#form_main_movimientos #fechaf").val();
	var bodega = $("#form_main_movimientos #almacen").val();
	
	var table_movimientos  = $("#dataTablaMovimientos").DataTable({
		"destroy":true,
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL;?>core/llenarDataTableInvetarioTransferencia.php",
			"data":{
				"tipo_producto_id":tipo_producto_id,
				"fechai":fechai,
				"fechaf":fechaf,
				"bodega":bodega
			}
		},
	"columns":[
		{"data":"fecha_registro"},
		{"data":"barCode"},
		{"data":"producto"},
		{"data":"medida"},
		{"data":"entrada"},
		{"data":"salida"},
		{"data":"saldo"},
		{"data":"bodega"},
		{"defaultContent":"<button class='table_transferencia btn btn-dark'><span class='fa fa-exchange-alt fa-lg'></span></button>"},	

	],
	"lengthMenu": lengthMenu,
	"stateSave": true,
	"bDestroy": true,
	"language": idioma_español,//esta se encuenta en el archivo main.js
	"dom": dom,
	"columnDefs": [
		{ width: "13.5%", targets: 0 },
		{ width: "10.5%", targets: 1 },
		{ width: "20.5%", targets: 2 },
		{ width: "5.5%", targets: 3 },
		{ width: "18.5%", targets: 4 },
		{ width: "10.5%", targets: 5 },
		{ width: "10.5%", targets: 6 },
		{ width: "10.5%", targets: 7 },
		{ width: "10.5%", targets: 8 },
	],
	"buttons":[
		{
			text:      '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
			titleAttr: 'Actualizar Movimientos',
			className: 'table_actualizar btn btn-secondary ocultar',
			action: 	function(){
				inventario_transferencia();
			}
		},
		{
			extend:    'excelHtml5',
			text:      '<i class="fas fa-file-excel fa-lg"></i> Excel',
			titleAttr: 'Excel',
			title: 'Reporte Movimientos',
			messageTop: 'Fecha desde: ' + convertDateFormat(fechai) + ' Fecha hasta: ' + convertDateFormat(fechaf),
			messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
			className: 'table_reportes btn btn-success ocultar',
			exportOptions: {
					columns: [0,1,2,3,4,5,6,7]
			},
		},
		{
			extend:    'pdf',
			text:      '<i class="fas fa-file-pdf fa-lg"></i> PDF',
			titleAttr: 'PDF',
			orientation: 'landscape',
			title: 'Reporte Movimientos',
			messageTop: 'Fecha desde: ' + convertDateFormat(fechai) + ' Fecha hasta: ' + convertDateFormat(fechaf),
			messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
			className: 'table_reportes btn btn-danger ocultar',
			exportOptions: {
					columns: [0,1,2,3,4,5,6,7]
			},
			customize: function ( doc ) {
				doc.content.splice( 1, 0, {
					margin: [ 0, 0, 0, 12 ],
					alignment: 'left',
					image: imagen,
					width:100,
					height:45
				} );
			}
		}
	],
	"drawCallback": function( settings ) {
		getPermisosTipoUsuarioAccesosTable(getPrivilegioTipoUsuario());
	}
});
table_movimientos.search('').draw();
$('#buscar').focus();

transferencia_producto_dataTable("#dataTablaMovimientos tbody",table_movimientos);

}
//FIN TRANSFERENCIA

//TRANSFERIR PRODUCTO/BODEGA
var transferencia_producto_dataTable = function(tbody, table){

	$(tbody).off("click", "button.table_transferencia");
	$(tbody).on("click", "button.table_transferencia", function(){
		var data = table.row( $(this).parents("tr") ).data();
		
		$('#formTransferencia #productos_id').val(data.productos_id);
		$('#formTransferencia #nameProduct').html(data.producto);

		$('#modal_transferencia_producto').modal({
			show:true,
			keyboard: false,
			backdrop:'static'
		});
	})
};

$('#putEditarBodega').on('click', function(e){
	event.preventDefault();
	var form = $("#formTransferencia");
	var respuesta=form.children('.RespuestaAjax');
	var url = '<?php echo SERVERURL;?>ajax/modificarBodegaProductosAjax.php';
	$.ajax({
		type:'POST',
		url:url,
		data:$('#formTransferencia').serialize(),
			beforeSend: function() {
				$('#modal_transferencia_producto').modal({
					show:false,
					keyboard: false,
					backdrop:'static'
				});
			},
			success: function(data){
				$('#modal_transferencia_producto').modal('toggle');
				respuesta.html(data);				
			}
	});	
});
//TRANSFERIR PRODUCTO/BODEGA

//INIICO OBTENER EL TIPO DE PRODUCTO
function getTipoProductos(){
    var url = '<?php echo SERVERURL;?>core/getTipoProductoMovimientos.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#form_main_movimientos #inventario_tipo_productos_id').html("");
			$('#form_main_movimientos #inventario_tipo_productos_id').html(data);
			
		    $('#formMovimientos #movimientos_tipo_producto_id').html("");
			$('#formMovimientos #movimientos_tipo_producto_id').html(data);			
		}
     });
}
//FIN OBTENER EL TIPO DE PRODUCTO

</script>
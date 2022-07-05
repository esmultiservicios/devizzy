<script>
$(document).ready(function() {
	
	//LLAMAMOS LOS METODOS CORRESPONDIENTES AL LOS MENUS
	getMenu(getPrivilegioUsuario());
	getSubMenu(getPrivilegioUsuario());
	getSubMenu1(getPrivilegioUsuario());	

	validarAperturaCajaUsuario();

	//LLAMAMOS LOS METODOS QUE OBTIENEN LOS PERMISOS DE LOS USUARIOS PARA LOS ACCESOS
	getPermisosTipoUsuarioAccesosForms(getPrivilegioTipoUsuario());
	getPermisosTipoUsuarioAccesosTable(getPrivilegioTipoUsuario());

	//LLAMAMOS EL METODO QUE IDENTIFICA EL USUARIO QUE HA INICIADO SESION
	getUserSessionStart();

    getAlmacen();
    getMedida(); 
    getTipoProducto();
    getEmpresaProductos();  
    getCategoriaProductos(); 	
	getEmpresaColaboradores();
	getPuestoColaboradores();
});



//INICIO MENUS
function getPermisosTipoUsuarioAccesosTable(privilegio_id){
	var url = '<?php echo SERVERURL;?>core/getTipoUsuarioAccesos.php';	

	$.ajax({
		type:'POST',
		url:url,
		data:'permisos_tipo_user_id='+privilegio_id,
		success: function(registro){
			valores_tipoUsuarioAccesos = JSON.parse(registro);
			
			try{
				for(var i=0; i < valores_tipoUsuarioAccesos.length; i++){					
					if(valores_tipoUsuarioAccesos[i].estado == 1){
						$('.table_' + valores_tipoUsuarioAccesos[i].tipo_permiso).show();
						$('.table_' + valores_tipoUsuarioAccesos[i].tipo_permiso).attr("disabled", false);
					}else{
						$('.table_' + valores_tipoUsuarioAccesos[i].tipo_permiso).hide();
						$('.table_' + valores_tipoUsuarioAccesos[i].tipo_permiso).attr("disabled", true);
					}					
				}
			}catch(e){

			}
		}
	});	
}

function getPermisosTipoUsuarioAccesosForms(privilegio_id){
	var url = '<?php echo SERVERURL;?>core/getTipoUsuarioAccesos.php';	

	$.ajax({
		type:'POST',
		url:url,
		data:'permisos_tipo_user_id='+privilegio_id,
		success: function(registro){
			valores_tipoUsuarioAccesos = JSON.parse(registro);
			
			try{
				for(var i=0; i < valores_tipoUsuarioAccesos.length; i++){					
					if(valores_tipoUsuarioAccesos[i].estado == 1){
						$('.' + valores_tipoUsuarioAccesos[i].tipo_permiso).show();
						$('.' + valores_tipoUsuarioAccesos[i].tipo_permiso).attr("disabled", false);
					}else{
						$('.' + valores_tipoUsuarioAccesos[i].tipo_permiso).hide();
						$('.' + valores_tipoUsuarioAccesos[i].tipo_permiso).attr("disabled", true);
					}					
				}
			}catch(e){

			}
		}
	});	
}

function getPermisosTipoUsuarioAccesosTableAccion(privilegio_id, tipo){
	var url = '<?php echo SERVERURL;?>core/getTipoUsuarioAccesos.php';	

	$.ajax({
		type:'POST',
		url:url,
		data:'permisos_tipo_user_id='+privilegio_id,
		success: function(registro){
			valores_tipoUsuarioAccesos = JSON.parse(registro);
			
			try{
				for(var i=0; i < valores_tipoUsuarioAccesos.length; i++){					
					if(valores_tipoUsuarioAccesos[i].estado == 1){
						if(valores_tipoUsuarioAccesos[i].tipo_permiso == tipo){
							$('.' + valores_tipoUsuarioAccesos[i].tipo_permiso).show();
							$('.' + valores_tipoUsuarioAccesos[i].tipo_permiso).attr("disabled", false);
						}else{
							$('.' + valores_tipoUsuarioAccesos[i].tipo_permiso).hide();
							$('.' + valores_tipoUsuarioAccesos[i].tipo_permiso).attr("disabled", true);
						}
					}else{
						$('.' + valores_tipoUsuarioAccesos[i].tipo_permiso).hide();
						$('.' + valores_tipoUsuarioAccesos[i].tipo_permiso).attr("disabled", true);
					}					
				}
			}catch(e){

			}
		}
	});	
}

function getMenu(privilegio_id){
	var url = '<?php echo SERVERURL;?>core/getMenuPrivilegios.php';	
	
	$.ajax({
		type:'POST',
		url:url,
		data:'privilegio_id='+privilegio_id,
		success: function(registro){
			valores_menu = JSON.parse(registro);
			
			try{
				for(var i=0; i < valores_menu.length; i++){					
					if(valores_menu[i].estado == 1){
						$('#' + valores_menu[i].menu).show();
					}else{
						$('#' + valores_menu[i].menu).hide();
					}					
				}
			}catch(e){

			}
		}
	});	
}

function getSubMenu(privilegio_id){
	var url = '<?php echo SERVERURL;?>core/getSubMenuPrivilegios.php';	
	
	$.ajax({
		type:'POST',
		url:url,
		data:'privilegio_id='+privilegio_id,
		success: function(registro){
			valores_submenu = JSON.parse(registro);
			
			try{
				for(var i=0; i < valores_submenu.length; i++){
					if(valores_submenu[i].estado == 1){
						$('#' + valores_submenu[i].submenu).show();
					}else{
						$('#' + valores_submenu[i].submenu).hide();
					}					
				}
			}catch(e){
				
			}
		}
	});	
}

function getSubMenu1(privilegio_id){
	var url = '<?php echo SERVERURL;?>core/getSubMenuPrivilegios1.php';	
	
	$.ajax({
		type:'POST',
		url:url,
		data:'privilegio_id='+privilegio_id,
		success: function(registro){
			valores_submenu = JSON.parse(registro);
			
			try{
				for(var i=0; i < valores_submenu.length; i++){
					if(valores_submenu[i].estado == 1){
						$('#' + valores_submenu[i].submenu1).show();
					}else{
						$('#' + valores_submenu[i].submenu1).hide();
					}					
				}
			}catch(e){
				
			}
		}
	});	
}

function getPrivilegioUsuario(){
	var url = '<?php echo SERVERURL;?>core/getPrivilegioUsuario.php';
	var privilegio;
	
	$.ajax({
		type:'POST',
		url:url,
		async: false,
		success: function(valores){
			var datos = eval(valores);
			privilegio = datos[0];
		}
	});
	return privilegio;
}

function getPrivilegioTipoUsuario(){
	var url = '<?php echo SERVERURL;?>core/getPrivilegioUsuarioTipo.php';
	var privilegio;
	
	$.ajax({
		type:'POST',
		url:url,
		async: false,
		success: function(valores){
			var datos = eval(valores);
			privilegio = datos[0];
		}
	});
	return privilegio;
}
//FIN MENUS

//INICIO OBTETNER EL NOMBRE DE USUARIO QUE INICIO SESIÓN
function getUserSessionStart(){
    var url = '<?php echo SERVERURL;?>core/getUserSession.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#user_session').html(data);
		}
     });
}
//FIN OBTETNER EL NOMBRE DE USUARIO QUE INICIO SESIÓN

//INICIO VALORES PARA DATATABLE
//INICIO IDIOMA
var idioma_español = {
    "processing": "Procesando...",
    "lengthMenu": "Mostrar _MENU_ registros",
    "zeroRecords": "No se encontraron resultados",
    "emptyTable": "Ningún dato disponible en esta tabla",
    "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
    "search": "Buscar:",
    "infoThousands": ",",
    "loadingRecords": "Cargando...",
    "paginate": {
        "first": "Primero",
        "last": "Último",
        "next": "Siguiente",
        "previous": "Anterior"
    },
    "aria": {
        "sortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sortDescending": ": Activar para ordenar la columna de manera descendente"
    },
    "buttons": {
        "copy": "Copiar",
        "colvis": "Visibilidad",
        "collection": "Colección",
        "colvisRestore": "Restaurar visibilidad",
        "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
        "copySuccess": {
            "1": "Copiada 1 fila al portapapeles",
            "_": "Copiadas %d fila al portapapeles"
        },
        "copyTitle": "Copiar al portapapeles",
        "csv": "CSV",
        "excel": "Excel",
        "pageLength": {
            "-1": "Mostrar todas las filas",
            "1": "Mostrar 1 fila",
            "_": "Mostrar %d filas"
        },
        "pdf": "PDF",
        "print": "Imprimir"
    },
    "autoFill": {
        "cancel": "Cancelar",
        "fill": "Rellene todas las celdas con <i>%d<\/i>",
        "fillHorizontal": "Rellenar celdas horizontalmente",
        "fillVertical": "Rellenar celdas verticalmentemente"
    },
    "decimal": ",",
    "searchBuilder": {
        "add": "Añadir condición",
        "button": {
            "0": "Constructor de búsqueda",
            "_": "Constructor de búsqueda (%d)"
        },
        "clearAll": "Borrar todo",
        "condition": "Condición",
        "conditions": {
            "date": {
                "after": "Despues",
                "before": "Antes",
                "between": "Entre",
                "empty": "Vacío",
                "equals": "Igual a",
                "not": "No",
                "notBetween": "No entre",
                "notEmpty": "No Vacio"
            },
            "moment": {
                "after": "Despues",
                "before": "Antes",
                "between": "Entre",
                "empty": "Vacío",
                "equals": "Igual a",
                "not": "No",
                "notBetween": "No entre",
                "notEmpty": "No vacio"
            },
            "number": {
                "between": "Entre",
                "empty": "Vacio",
                "equals": "Igual a",
                "gt": "Mayor a",
                "gte": "Mayor o igual a",
                "lt": "Menor que",
                "lte": "Menor o igual que",
                "not": "No",
                "notBetween": "No entre",
                "notEmpty": "No vacío"
            },
            "string": {
                "contains": "Contiene",
                "empty": "Vacío",
                "endsWith": "Termina en",
                "equals": "Igual a",
                "not": "No",
                "notEmpty": "No Vacio",
                "startsWith": "Empieza con"
            }
        },
        "data": "Data",
        "deleteTitle": "Eliminar regla de filtrado",
        "leftTitle": "Criterios anulados",
        "logicAnd": "Y",
        "logicOr": "O",
        "rightTitle": "Criterios de sangría",
        "title": {
            "0": "Constructor de búsqueda",
            "_": "Constructor de búsqueda (%d)"
        },
        "value": "Valor"
    },
    "searchPanes": {
        "clearMessage": "Borrar todo",
        "collapse": {
            "0": "Paneles de búsqueda",
            "_": "Paneles de búsqueda (%d)"
        },
        "count": "{total}",
        "countFiltered": "{shown} ({total})",
        "emptyPanes": "Sin paneles de búsqueda",
        "loadMessage": "Cargando paneles de búsqueda",
        "title": "Filtros Activos - %d"
    },
    "select": {
        "1": "%d fila seleccionada",
        "_": "%d filas seleccionadas",
        "cells": {
            "1": "1 celda seleccionada",
            "_": "$d celdas seleccionadas"
        },
        "columns": {
            "1": "1 columna seleccionada",
            "_": "%d columnas seleccionadas"
        }
    },
    "thousands": "."
}
//FIN IDIOMA

//INICIO CONVETIR IMAGEN BASE 64
function toDataURL(src, callback, outputFormat) {
  var img = new Image();
  img.crossOrigin = 'Anonymous';
  img.onload = function() {
    var canvas = document.createElement('CANVAS');
    var ctx = canvas.getContext('2d');
    var dataURL;
    canvas.height = this.naturalHeight;
    canvas.width = this.naturalWidth;
    ctx.drawImage(this, 0, 0);
    dataURL = canvas.toDataURL(outputFormat);
    callback(dataURL);
  };
  img.src = src;
  if (img.complete || img.complete === undefined) {
    img.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
    img.src = src;
  }
}
//FIN CONVERTIR IMAGEN BASE 64

var lengthMenu = [[5, 10, 20, 30, 50, 100, -1], [5, 10, 20, 30, 50, 100, "Todo"]];

var dom = "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>";
//FIN VALORES PARA DATATABLE

//INICIO CONSUMIDOR FINAL PARA COTIZACION Y FACTURACION
function getConsumidorFinal(){
	var url = '<?php echo SERVERURL;?>core/getConsumidorFinal.php';

	$.ajax({
		type:'POST',
		url:url,
		success: function(valores){
			var datos = eval(valores);
			$('#invoice-form #cliente_id').val(datos[0]);
			$('#invoice-form #cliente').val(datos[1]);
			$('#invoice-form #client-customers-bill').html("<b>Cliente:</b> "  + datos[1]);
			$('#invoice-form #rtn-customers-bill').html("<b>RTN:</b> " + datos[2]);

			$('#quoteForm #cliente_id').val(datos[0]);
			$('#quoteForm #cliente').val(datos[1]);
			$('#quoteForm #client-customers-quote').html("<b>Cliente:</b> "  + datos[1]);
			$('#quoteForm #rtn-customers-quote').html("<b>RTN:</b> " + datos[2]);		
			return false;
		}
	});
}

function getCajero(){
	var url = '<?php echo SERVERURL;?>core/getCajero.php';

	$.ajax({
		type:'POST',
		url:url,
		success: function(valores){
			var datos = eval(valores);
			$('#invoice-form #colaborador_id').val(datos[0]);
			$('#invoice-form #colaborador').val(datos[1]);

			$('#quoteForm #colaborador_id').val(datos[0]);
			$('#quoteForm #colaborador').val(datos[1]);			
			
			$('#formAperturaCaja #colaboradores_id_apertura').val(datos[0]);
			$('#formAperturaCaja #usuario_apertura').val(datos[1]);				
			return false;
		}
	});
}

function getPorcentajeISV(documento){
    var url = '<?php echo SERVERURL;?>core/getISV.php';

	var isv;
	$.ajax({
	    type:'POST',
		url:url,
		data:'documento='+documento,
		async: false,
		success:function(data){
		  var datos = eval(data);
          isv = datos[0];
		}
	});
	return isv;
}

$(document).ready(function(){	
	showTime();
	showDate();
});

function showDate(){
	var fecha = new Date();	
	$('#invoice-form #fecha-customers-bill').html("<b>Fecha:</b> " + fecha.getDate() + "/" + (fecha.getMonth() +1) + "/" + fecha.getFullYear());
	$('#quoteForm #fecha-customers-quote').html("<b>Fecha:</b> " + fecha.getDate() + "/" + (fecha.getMonth() +1) + "/" + fecha.getFullYear());	
}

function showTime(){
	myDate = new Date();
	hours = myDate.getHours();
	minutes = myDate.getMinutes();
	seconds = myDate.getSeconds();
	if (hours < 10) hours = 0 + hours;
	if (minutes < 10) minutes = "0" + minutes;
	if (seconds < 10) seconds = "0" + seconds;
	$('#invoice-form #hora-customers-bill').html("<b>Hora:</b> " + hours+ ":" + minutes+ ":" + seconds);
	$('#quoteForm #hora-customers-quote').html("<b>Hora:</b> " + hours+ ":" + minutes+ ":" + seconds);
}

setTimeout("showTime(); showDate()", 1000);
//FIN CONSUMIDOR FINAL PARA COTIZACION Y FACTURACION

//INICIO PRODUCTOS
/*INICIO FORMULARIO PRODUCTOS*/
function modal_productos(){
	$('#formProductos').attr({ 'data-form': 'save' });
	$('#formProductos').attr({ 'action': '<?php echo SERVERURL;?>ajax/agregarProductosAjax.php' });
	$('#formProductos')[0].reset();
	$('#reg_producto').show();
	$('#edi_producto').hide();
	$('#delete_producto').hide();

	//HABILITAR OBJETOS
	$('#formProductos #producto').attr("readonly", false);
	$('#formProductos #categoria').attr("disabled", false);
	$('#formProductos #medida').attr("disabled", false);
	$('#formProductos #almacen').attr("disabled", false);
	$('#formProductos #cantidad').attr("readonly", false);
	$('#formProductos #precio_compra').attr("readonly", false);
	$('#formProductos #precio_venta').attr("readonly", false);
	$('#formProductos #descripcion').attr("readonly", false);
	$('#formProductos #cantidad_minima').attr("readonly", false);
	$('#formProductos #cantidad_maxima').attr("readonly", false);
	$('#formProductos #producto_isv_factura').attr("disabled", false);
	$('#formProductos #producto_isv_compra').attr("disabled", false);	
	$('#formProductos #bar_code_product').attr("readonly", false);
	$('#formProductos #producto_empresa_id').attr("disabled", false);
	$('#formProductos #producto_categoria').attr("disabled", false);
	$('#formProductos #tipo_producto').attr("disabled", false);
	$('#formProductos #precio_mayoreo').attr("readonly", false);
	$('#formProductos #porcentaje_venta').attr("readonly", false);
	$('#formProductos #cantidad_mayoreo').attr("readonly", false);	
	$('#formProductos #producto_isv_compra').attr('checked', false);
	$('#formProductos #cantidad').attr("disabled", false);

	$('#formProductos #buscar_producto_empresa').show();
	$('#formProductos #buscar_producto_categorias').show();
	
	$('#formProductos #producto_activo').attr('checked', true);
	$('#formProductos #producto_isv_factura').attr('checked', true);
	$('#formProductos #estado_producto').hide();	
	
	$("#formProductos #preview").attr("src", "<?php echo SERVERURL;?>vistas/plantilla/img/products/image_preview.png");
	
	$('#formProductos #proceso_productos').val("Registro");
	$('#modal_registrar_productos').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});
}
/*FIN FORMULARIO PRODUCTOS*/

function getEmpresaProductos(){
    var url = '<?php echo SERVERURL;?>core/getEmpresa.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formProductos #producto_empresa_id').html("");
			$('#formProductos #producto_empresa_id').html(data);			
		}
     });
}

function getMedida(){
    var url = '<?php echo SERVERURL;?>core/getMedida.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formProductos #medida').html("");
			$('#formProductos #medida').html(data);
		}
     });
}

function getAlmacen(){
    var url = '<?php echo SERVERURL;?>core/getAlmacen.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formProductos #almacen').html("");
			$('#formProductos #almacen').html(data);

			$('#form_main_movimientos #almacen').append("");
			$('#form_main_movimientos #almacen').append("<option value='0'>Todos</option>"+data);

			$('#formulario_busqueda_productos_facturacion #almacen').append("");
			$('#formulario_busqueda_productos_facturacion #almacen').append("<option value='0'>Todos</option>"+data);

			$('#formTransferencia #id_bodega').html("");
			$('#formTransferencia #id_bodega').html(data);
		}
     });
}

function getTipoProducto(){
    var url = '<?php echo SERVERURL;?>core/getTipoProducto.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formProductos #tipo_producto').html("");
			$('#formProductos #tipo_producto').html(data);
		}
     });
}

function getCategoriaProductos(){
    var url = '<?php echo SERVERURL;?>core/getCategoriaProductos.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formProductos #producto_categoria').html("");
			$('#formProductos #producto_categoria').html(data);
		}
     });
}
//FIN PRODUCTOS

//INICIO CLIENTES
/*INICIO FORMULARIO CLIENTES*/
function modal_clientes(){	
	getDepartamentoClientes();
	$('#formClientes').attr({ 'data-form': 'save' });
	$('#formClientes').attr({ 'action': '<?php echo SERVERURL;?>ajax/agregarClientesAjax.php' });
	$('#formClientes')[0].reset();
	$('#reg_cliente').show();
	$('#edi_cliente').hide();
	$('#delete_cliente').hide();
	$('#formClientes #fecha_clientes').attr('disabled', false);

	//HABILITAR OBJETOS
	$('#formClientes #nombre_clientes').attr("readonly", false);
	$('#formClientes #identidad_clientes').attr("readonly", false);
	$('#formClientes #fecha_clientes').attr("readonly", false);
	$('#formClientes #departamento_cliente').attr("disabled", false);
	$('#formClientes #municipio_cliente').attr("disabled", false);
	$('#formClientes #dirección_clientes').attr("disabled", false);
	$('#formClientes #telefono_clientes').attr("readonly", false);
	$('#formClientes #correo_clientes').attr("readonly", false);
	$('#formClientes #clientes_activo').attr("disabled", false);
	$('#formClientes #estado_clientes').hide();

	$('#formClientes #proceso_clientes').val("Registro");
	$('#modal_registrar_clientes').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});
}

function getDepartamentoClientes(){
    var url = '<?php echo SERVERURL;?>core/getDepartamentos.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formClientes #departamento_cliente').html("");
			$('#formClientes #departamento_cliente').html(data);
		}
     });
}
/*FIN FORMULARIO CLIENTES*/
//FIN CLIENTES

//INICIO PROVEEDORES
/*INICIO FORMULARIO PROVEEDORES*/
function modal_proveedores(){
	getDepartamentoProveedores();
	$('#formProveedores').attr({ 'data-form': 'save' });
	$('#formProveedores').attr({ 'action': '<?php echo SERVERURL;?>ajax/agregarProveedoresAjax.php' });
	$('#formProveedores')[0].reset();
	$('#reg_proveedor').show();
	$('#edi_proveedor').hide();
	$('#delete_proveedor').hide();
	$('#formProveedores #fecha_proveedores').attr('disabled', false);

	//HABILITAR OBJETOS
	$('#formProveedores #nombre_proveedores').attr("readonly", false);
	$('#formProveedores #apellido_proveedores').attr("readonly", false);
	$('#formProveedores #rtn_proveedores').attr("readonly", false);
	$('#formProveedores #fecha_proveedores').attr("readonly", false);
	$('#formProveedores #departamento_proveedores').attr("disabled", false);
	$('#formProveedores #municipio_proveedores').attr("disabled", false);
	$('#formProveedores #dirección_proveedores').attr("disabled", false);
	$('#formProveedores #telefono_proveedores').attr("readonly", false);
	$('#formProveedores #correo_proveedores').attr("readonly", false);
	$('#formProveedores #proveedores_activo').attr("disabled", false);
	$('#formProveedores #estado_proveedores').hide();

	$('#formProveedores #proceso_proveedores').val("Registro");
	$('#modal_registrar_proveedores').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});
}

function getDepartamentoProveedores(){
    var url = '<?php echo SERVERURL;?>core/getDepartamentos.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formProveedores #departamento_proveedores').html("");
			$('#formProveedores #departamento_proveedores').html(data);
		}
     });
}

function getMunicipiosProveedores(departamentos_id, municipios_id){
	var url = '<?php echo SERVERURL;?>core/getMunicipios.php';

	var departamentos_id = $('#formProveedores #departamento_proveedores').val();

	$.ajax({
	   type:'POST',
	   url:url,
	   data:'departamentos_id='+departamentos_id,
	   success:function(data){
		  $('#formProveedores #municipio_proveedores').html("");
		  $('#formProveedores #municipio_proveedores').html(data);
		  $('#formProveedores #municipio_proveedores').val(municipios_id);
	  }
  });
  return false;
}

$('#formProveedores #departamento_proveedores').on('change', function(){
		var url = '<?php echo SERVERURL;?>core/getMunicipios.php';

		var departamentos_id = $('#formProveedores #departamento_proveedores').val();

	    $.ajax({
		   type:'POST',
		   url:url,
		   data:'departamentos_id='+departamentos_id,
		   success:function(data){
		      $('#formProveedores #municipio_proveedores').html("");
			  $('#formProveedores #municipio_proveedores').html(data);
		  }
	  });
	  return false;
});
//FIN PROVEEDORES

//INICIO FORMULARIO CAMBIAR CONTRAEÑA
$(document).ready(function(e) {
    $('#form-cambiarcontra #repcontra').on('blur', function(){
		if($('#form-cambiarcontra #repcontra').val() != ""){
		  if ($('#form-cambiarcontra #nuevacontra').val() != $('#form-cambiarcontra #repcontra').val()){ 
			swal({
				title: "Error", 
				text: "Contraseñas no coinciden",
				type: "error", 
				confirmButtonClass: "btn-danger"
			});
			$("#form-cambiarcontra #Modalcambiarcontra_Edit").attr('disabled', true);
			$("#form-cambiarcontra #repcontra").css("border-color", "red");
			return false;
		  }else{
			$("#form-cambiarcontra #repcontra").css("border-color", "none");
			$("#form-cambiarcontra #Modalcambiarcontra_Edit").attr('disabled', false); 
		  }		
		}else{
			$("#form-cambiarcontra #repcontra").css("border-color", "none");
			$("#form-cambiarcontra #Modalcambiarcontra_Edit").attr('disabled', true); 
		  }	
	});		
});

$(document).ready(function(e) {
    $('#form-cambiarcontra #repcontra').on('keyup', function(){
		if($('#form-cambiarcontra #repcontra').val() != ""){
		  if ($('#form-cambiarcontra #nuevacontra').val() != $('#form-cambiarcontra #repcontra').val()){ 
			$("#form-cambiarcontra #Modalcambiarcontra_Edit").attr('disabled', true);
			$("#form-cambiarcontra #repcontra").css("border-color", "red");
			return false;
		  }else{
			$("#form-cambiarcontra #repcontra").css("border-color", "green");
			$("#form-cambiarcontra #Modalcambiarcontra_Edit").attr('disabled', false); 
		  }		
		}else{
			$("#form-cambiarcontra #repcontra").css("border-color", "none");
			$("#form-cambiarcontra #Modalcambiarcontra_Edit").attr('disabled', true); 
		  }	
	});		
});

function limpiarForm(){
	$('#form-cambiarcontra #contranaterior').val("");
	$('#form-cambiarcontra #nuevacontra').val("");
	$('#form-cambiarcontra #repcontra').val("");
    $('#form-cambiarcontra #mensaje').html("");
	$('#form-cambiarcontra #mayus').show();
	$('#form-cambiarcontra #special').show();
	$('#form-cambiarcontra #numbers').show();
	$('#form-cambiarcontra #lower').show();
	$('#form-cambiarcontra #len').show();	
	$('#form-cambiarcontra #contranaterior').focus();
	$("#form-cambiarcontra #Modalcambiarcontra_Edit").attr('disabled', true);
	$('#form-cambiarcontra #mensaje_cambiar_contra').html("");
	$("#form-cambiarcontra #contranaterior").css("border-color", "none");
    $("#form-cambiarcontra #repcontra").css("border-color", "none");
    $("#form-cambiarcontra #nuevacontra").css("border-color", "none");	
}

$(document).ready(function(e) {
    $('#form-cambiarcontra #contranaterior').on('blur', function(){
		if($('#form-cambiarcontra #contranaterior').val() != ""){
		     var url = '<?php echo SERVERURL; ?>core/consultar_pass.php';
		 
		     $.ajax({
		       type:'POST',
		       url:url,
		       data:$('#form-cambiarcontra').serialize(),
		       success: function(datos){
			     if (datos == 0){	
					swal({
						title: "Error", 
						text: "La contraseña que ingreso no coincide con la anterior",
						type: "error", 
						confirmButtonClass: "btn-danger"
					});
					$("#form-cambiarcontra #contranaterior").css("border-color", "red");
					$("#form-cambiarcontra #Modalcambiarcontra_Edit").attr('disabled', true); 
					return false;
			     }else{
					 $("#form-cambiarcontra #contranaterior").css("border-color", "green");
					 $("#form-cambiarcontra #Modalcambiarcontra_Edit").attr('disabled', false); 
				 }
		       }
	         });
	        return false;	
		}
	});
});

$(function(){
    var mayus = new RegExp("^(?=.*[A-Z])");
	var special = new RegExp("^(?=.*[!@#$%&*¡?¿|°/\+-.:,;()~<>])");
	var numbers = new RegExp("^(?=.*[0-9])");
	var lower = new RegExp("^(?=.*[a-z])");
	var len = new RegExp("^(?=.{8,})");
	
	
    var regExpr = [mayus,special,numbers,lower,len];
	var elementos = [$('#form-cambiarcontra #mayus'),$('#form-cambiarcontra #special'),$('#form-cambiarcontra #numbers'),$('#form-cambiarcontra #lower'),$('#form-cambiarcontra #len')];
	
	$('#form-cambiarcontra #nuevacontra').on("keyup", function(){
		if($('#form-cambiarcontra #nuevacontra').val() != ""){
		   var pass = $('#form-cambiarcontra #nuevacontra').val();
		   var check = 0;
		   
		   for(var i = 0; i < 5; i++){
			  if(regExpr[i].test(pass)){
			  	  elementos[i].hide();
				  check++;
			  }else{
				  elementos[i].show();
			  }
		  }
		  
		  $('#form-cambiarcontra #check').val(check);
		  if(check >= 0 && check <= 2){
			  $('#form-cambiarcontra #mensaje_cambiar_contra').html("<strong>Contraseña Insegura</strong>").css("color","red");
			  $("#form-cambiarcontra #Modalcambiarcontra_Edit").attr('disabled', true);
		  }else if(check >= 3 && check <= 4){
			  $('#form-cambiarcontra #mensaje_cambiar_contra').html("<strong>Contraseña poco segura</strong>").css("color","orange");
			  $("#form-cambiarcontra #Modalcambiarcontra_Edit").attr('disabled', true);
		  }else if(check == 5){
              $('#form-cambiarcontra #mensaje_cambiar_contra').html("<strong>Contraseña muy segura</strong>").css("color","green");
			  $("#form-cambiarcontra #Modalcambiarcontra_Edit").attr('disabled', true);
		  }			
		}else{
			$('#form-cambiarcontra #mensaje_cambiar_contra').html("").css("color","none");
			$('#form-cambiarcontra #mayus').show();
			$('#form-cambiarcontra #special').show();
			$('#form-cambiarcontra #numbers').show();
			$('#form-cambiarcontra #lower').show();
			$('#form-cambiarcontra #len').show();
			$("#form-cambiarcontra #Modalcambiarcontra_Edit").attr('disabled', true);
		}
	});
});

//MOSTRAR CONTRASEÑA
$(document).ready(function () {
	//CAMPO CONTRASEÑA ANTERIOR
    $('#form-cambiarcontra #show_password1').on('mousedown',function(){
		var cambio = $("#form-cambiarcontra #contranaterior")[0];
		if(cambio.type == "password"){
			cambio.type = "text";
			$('#icon1').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambio.type = "password";
			$('#icon1').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
		return false;
    });

    $('#form-cambiarcontra #show_password1').on('mousedown',function(){
		$('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
		return false;
    });	
	
	//CAMPO NUEVA CONTRASEÑA
    $('#form-cambiarcontra #show_password2').on('mousedown',function(){
		var cambio = $("#form-cambiarcontra #nuevacontra")[0];
		if(cambio.type == "password"){
			cambio.type = "text";
			$('#icon2').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambio.type = "password";
			$('#icon2').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
		return false;
    });

    $('#form-cambiarcontra #show_password2').on('click',function(){
		$('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
		return false;
    });	

    //CAMPO REPETIR CONTRASEÑA
    $('#form-cambiarcontra #show_password3').on('click',function(){
		var cambio = $("#form-cambiarcontra #repcontra")[0];
		if(cambio.type == "password"){
			cambio.type = "text";
			$('#icon3').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambio.type = "password";
			$('#icon3').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
		return false;
    });

    $('#form-cambiarcontra #show_password3').on('click',function(){
		$('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
		return false;
    });	
	
    //OCULTAR CONTRASEÑA	
    $('#form-cambiarcontra #show_password1').on('mouseout', function(){
		 $('#icon1').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
         var cambio = $("#form-cambiarcontra #contranaterior")[0];
         cambio.type = "password";
		 $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
		 return false;
    });	
	
    $('#form-cambiarcontra #show_password2').on('mouseout', function(){
		 $('#icon2').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
         var cambio = $("#form-cambiarcontra #nuevacontra")[0];
         cambio.type = "password";
		 $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
    });	

    $('#form-cambiarcontra #show_password3').on('mouseout', function(){
		 $('#icon3').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
         var cambio = $("#form-cambiarcontra #repcontra")[0];
         cambio.type = "password";
		 $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
    });			
});
//FIN FORMULARIO CAMBIAR CONTRASEÑA

//INICIO FUNCIONES ADICIONALES
function convertDateFormat(string) {
  if(string == null || string == ""){
    var hoy = new Date();
    string = convertDate(hoy);	  
  }

  var info = string.split('-');
  return info[2] + '/' + info[1] + '/' + info[0];
}

function convertDate(inputFormat) {
  function pad(s) { return (s < 10) ? '0' + s : s; }
  var d = new Date(inputFormat);
  return [d.getFullYear(), pad(d.getMonth()+1), pad(d.getDate())].join('-');
}

function today(){
    var hoy = new Date();
    return convertDate(hoy);	
}
//FIN FUNCIONES ADICIONALES

//INICIO IMPRIMIR FACTURACION
function printQuote(cotizacion_id){
	var url = '<?php echo SERVERURL; ?>core/generaCotizacion.php?cotizacion_id='+cotizacion_id;
    window.open(url);
}

function printBill(facturas_id,$print_comprobante){
	
	var url = "<?php echo SERVERURL;?>core/llenarDataTableImpresora.php";

	$.ajax({
		type:'POST',
		url:url,
		data:{
			id: 1,
		},
			success: function(data){
				$.each(JSON.parse(data), function(){						
					if(this.tipo == 1 && this.estado == 1){
						var url = '<?php echo SERVERURL;?>core/generaFactura.php?facturas_id='+facturas_id;
						window.open(url);
					}
					
					if(this.tipo == 2 && this.estado == 1){
						var url = '<?php echo SERVERURL;?>core/generaTicket.php?facturas_id='+facturas_id;
						window.open(url);	

					}
					
					if($print_comprobante == 1){
						if(this.tipo == 3 && this.estado == 1){
							var url_comprobante = '<?php echo SERVERURL;?>core/generaComprobante.php?facturas_id='+facturas_id;
							window.open(url_comprobante);		
						}

						if(this.tipo == 4 && this.estado == 1){
							var url = '<?php echo SERVERURL;?>core/generaTicketComprobante.php?facturas_id='+facturas_id;
							window.open(url);
						}
					}			
				}
	
			)}
		});	
		
		return false;

}

function printBillReporteVentas(facturas_id,$print_comprobante){
	
	var url = "<?php echo SERVERURL;?>core/llenarDataTableImpresora.php";

	$.ajax({
		type:'POST',
		url:url,
		data:{
			id: 1,
		},
			success: function(data){
				$.each(JSON.parse(data), function(){	
			
					if(this.tipo == 1 && this.estado == 1){
					var url = '<?php echo SERVERURL;?>core/generaFactura.php?facturas_id='+facturas_id;
					window.open(url);
					}
					
					if(this.tipo == 2 && this.estado == 1){
						var url = '<?php echo SERVERURL;?>core/generaTicket.php?facturas_id='+facturas_id;
						window.open(url);	

					}
				}
	
			)}
		});	
}

function printBillComprobanteReporteVentas(facturas_id,$print_comprobante){
	
	var url = "<?php echo SERVERURL;?>core/llenarDataTableImpresora.php";

	$.ajax({
		type:'POST',
		url:url,
		data:{
			id: 1,
		},
			success: function(data){
				$.each(JSON.parse(data), function(){						
					if(this.tipo == 3 && this.estado == 1){
						var url_comprobante = '<?php echo SERVERURL;?>core/generaComprobante.php?facturas_id='+facturas_id;
						window.open(url_comprobante);
						console.log('compriante',this.tipo)			

					}

					if(this.tipo == 4 && this.estado == 1){
						var url = '<?php echo SERVERURL;?>core/generaTicketComprobante.php?facturas_id='+facturas_id;
						window.open(url);	

					}
			
				}
	
			)}
		});	
}

function printPurchase(compras_id){
	var url = '<?php echo SERVERURL; ?>core/generaCompra.php?compras_id='+compras_id;
    window.open(url);
}

//INICIO ENVIAR COTIZACION POR CORREO ELECTRONICO
function mailQuote(cotizacion_id){
	swal({
	  title: "¿Estas seguro?",
	  text: "¿Desea enviar la cotización: # " + getNumeroCotizacion(cotizacion_id) + "?",
	  type: "info",
	  showCancelButton: true,
	  confirmButtonClass: "btn-primary",
	  confirmButtonText: "¡Sí, enviar la cotización!",
	  cancelButtonText: "Cancelar",
	  closeOnConfirm: false
	},
	function(){
		sendQuote(cotizacion_id);
	});
}

function sendQuote(cotizacion_id){
	var url = '<?php echo SERVERURL; ?>core/sendCotizacion.php';
	var bill = '';

	$.ajax({
	   type:'POST',
	   url:url,
	   async: false,
	   data:'cotizacion_id='+cotizacion_id,
	   success:function(data){
	      bill = data;
	      if(bill == 1){
				swal({
					title: "Success",
					text: "La cotización ha sido enviada por correo satisfactoriamente",
					type: "success",
				});
		  }
	  }
	});
	return bill;
}

function getNumeroCotizacion(cotizacion_id){
	var url = '<?php echo SERVERURL; ?>core/getNoCotizacion.php';
	var noFactura = '';

	$.ajax({
	   type:'POST',
	   url:url,
	   async: false,
	   data:'cotizacion_id='+cotizacion_id,
	   success:function(data){
			var datos = eval(data);
			noFactura = datos[0];
	  }
	});
	return noFactura;
}
//FIN ENVIAR COTIZACION POR CORREO ELECTRONICO

//INICIO ENVIAR FACTURA POR CORREO ELECTRONICO
function mailBill(facturas_id){
	swal({
	  title: "¿Estas seguro?",
	  text: "¿Desea enviar este numero de factura: # " + getNumeroFactura(facturas_id) + "?",
	  type: "info",
	  showCancelButton: true,
	  confirmButtonClass: "btn-primary",
	  confirmButtonText: "¡Sí, enviar la factura!",
	  cancelButtonText: "Cancelar",
	  closeOnConfirm: false
	},
	function(){
		sendMail(facturas_id);
	});
}

function sendMail(facturas_id){
	var url = '<?php echo SERVERURL; ?>core/sendFactura.php';
	var bill = '';

	$.ajax({
	   type:'POST',
	   url:url,
	   async: false,
	   data:'facturas_id='+facturas_id,
	   success:function(data){
	      bill = data;
	      if(bill == 1){
				swal({
					title: "Success",
					text: "La factura ha sido enviada por correo satisfactoriamente",
					type: "success",
				});
		  }
	  }
	});
	return bill;
}

function getNumeroFactura(facturas_id){
	var url = '<?php echo SERVERURL; ?>core/getNoFactura.php';
	var noFactura = '';

	$.ajax({
	   type:'POST',
	   url:url,
	   async: false,
	   data:'facturas_id='+facturas_id,
	   success:function(data){
			var datos = eval(data);
			noFactura = datos[0];
	  }
	});
	return noFactura;
}

function getNumeroCompra(compras_id){
	var url = '<?php echo SERVERURL; ?>core/getNoCompra.php';
	var noCompra = '';

	$.ajax({
	   type:'POST',
	   url:url,
	   async: false,
	   data:'compras_id='+compras_id,
	   success:function(data){
			var datos = eval(data);
			noCompra = datos[0];
	  }
	});
	return noCompra;
}
//FIN ENVIAR FACTURA POR CORREO ELECTRONICO

/*INICIO FORMULARIO COLABORADORES*/
function modal_colaboradores(){
	getPuestoColaboradores();
	$('#formColaboradores').attr({ 'data-form': 'save' });
	$('#formColaboradores').attr({ 'action': '<?php echo SERVERURL;?>ajax/agregarColaboradorAjax.php' });
	$('#formColaboradores')[0].reset();
	$('#reg_colaborador').show();
	$('#edi_colaborador').hide();
	$('#delete_colaborador').hide();

	//HABILITAR OBJETOS
	$('#formColaboradores #nombre_colaborador').attr('readonly', false);
	$('#formColaboradores #apellido_colaborador').attr('readonly', false);
	$('#formColaboradores #identidad_colaborador').attr('readonly', false);
	$('#formColaboradores #telefono_colaborador').attr('readonly', false);
	$('#formColaboradores #puesto_colaborador').attr('disabled', false);
	$('#formColaboradores #estado_colaborador').attr('disabled', false);
	$('#formColaboradores #colaboradores_activo').attr('disabled', false);
	$('#formColaboradores #colaborador_empresa_id').attr('disabled', false);
	$('#formColaboradores #buscar_colaborador_empresa').show();
	$('#formColaboradores #estado_colaboradores').hide();

	$('#formColaboradores #proceso_colaboradores').val("Registro");
	$('#modal_registrar_colaboradores').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});
}

function getPuestoColaboradores(){
    var url = '<?php echo SERVERURL;?>core/getPuestoColaboradores.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formColaboradores #puesto_colaborador').html("");
			$('#formColaboradores #puesto_colaborador').html(data);
		}
     });
}

function getEmpresaColaboradores(){
    var url = '<?php echo SERVERURL;?>core/getEmpresa.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formColaboradores #colaborador_empresa_id').html("");
			$('#formColaboradores #colaborador_empresa_id').html(data);			
		}
     });
}
/*FIN FORMULARIO COLABORADORES*/

//INICIO CAMBIAR CONTRASEÑA
$('#cambiar_contraseña_usuarios_sistema').on('click',function(e){
	e.preventDefault();
	$('#form-cambiarcontra').attr({ 'data-form': 'update' });
	$('#form-cambiarcontra').attr({ 'action': '<?php echo SERVERURL;?>ajax/modificarContrasenaAjax.php' });
	$('#form-cambiarcontra')[0].reset();
	
	$('#ModalContraseña').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});	
});
//FIN CAMBIAR CONTRASEÑA

//INICIO MODIFICAR PERFIL USUARIO SISTEMA
$('#modificar_perfil_usuario_sistema').on('click',function(e){
	e.preventDefault();
	var url = '<?php echo SERVERURL;?>core/editarColaboradoresUsuario.php';

	$.ajax({
		type:'POST',
		url:url,
		success: function(registro){
			var valores = eval(registro);
			$('#formColaboradores').attr({ 'data-form': 'update' });
			$('#formColaboradores').attr({ 'action': '<?php echo SERVERURL;?>ajax/modificarColaboradorAjaxMain.php' });
			$('#formColaboradores')[0].reset();
			$('#reg_colaborador').hide();
			$('#edi_colaborador').show();
			$('#delete_colaborador').hide();			
			$('#formColaboradores #nombre_colaborador').val(valores[0]);
			$('#formColaboradores #apellido_colaborador').val(valores[1]);
			$('#formColaboradores #identidad_colaborador').val(valores[2]);
			$('#formColaboradores #telefono_colaborador').val(valores[3]);
			$('#formColaboradores #puesto_colaborador').val(valores[4]);
			$('#formColaboradores #colaborador_empresa_id').val(valores[5]);
			$('#formColaboradores #colaborador_id').val(valores[7]);

			if(valores[6] == 1){
				$('#formColaboradores #colaboradores_activo').attr('checked', true);
			}else{
				$('#formColaboradores #colaboradores_activo').attr('checked', false);
			}

			//DESHABIITAR OBJETOS
			$('#formColaboradores #puesto_colaborador').attr('disabled', true);

			//HABILITAR OBJETOS
			$('#formColaboradores #nombre_colaborador').attr('readonly', false);
			$('#formColaboradores #apellido_colaborador').attr('readonly', false);
			$('#formColaboradores #identidad_colaborador').attr('readonly', false);
			$('#formColaboradores #telefono_colaborador').attr('readonly', false);
			$('#formColaboradores #estado_colaborador').attr('disabled', false);
			$('#formColaboradores #colaboradores_activo').attr('disabled', true);
			$('#formColaboradores #colaborador_empresa_id').attr('disabled', true);			
			$('#formColaboradores #buscar_colaborador_empresa').hide();	

			$('#formColaboradores #proceso_colaboradores').val("Editar");
			$('#modal_registrar_colaboradores').modal({
				show:true,
				keyboard: false,
				backdrop:'static'
			});
		}
	});
});
//FIN MODIFICAR PERFIL USUARIO SISTEMA

var imagen;
toDataURL(
  '<?php echo SERVERURL;?>vistas/plantilla/img/logo.png',
  function(dataUrl) {
	imagen = dataUrl;
  }
)

function validarAperturaCajaUsuario(){
	if(getConsultarAperturaCaja() == 2){
		$("#invoice-form #btn_apertura").show();
		$("#invoice-form #reg_factura").attr("disabled", true);
		$("#invoice-form #add_cliente").attr("disabled", true);		
		$("#invoice-form #add_vendedor").attr("disabled", true);
		$("#invoice-form #addRows").attr("disabled", true);
		$("#invoice-form #removeRows").attr("disabled", true);
		$("#invoice-form #notasFactura").attr("disabled", true);
		$("#invoice-form #btn_apertura").show();
		$("#invoice-form #btn_cierre").hide();		
	}else{
		$("#invoice-form #btn_apertura").hide();
		$("#invoice-form #reg_factura").attr("disabled", false);
		$("#invoice-form #add_cliente").attr("disabled", false);			
		$("#invoice-form #add_vendedor").attr("disabled", false);
		$("#invoice-form #addRows").attr("disabled", false);
		$("#invoice-form #removeRows").attr("disabled", false);	
		$("#invoice-form #notasFactura").attr("disabled", false);
		$("#invoice-form #btn_cierre").show();
		$("#invoice-form #btn_apertura").hide();		
	}	
}

function getConsultarAperturaCaja(){
    var url = '<?php echo SERVERURL;?>core/getAperturaCajaUsuario.php';

	var estado_apertura;
	
	$.ajax({
	    type:'POST',
		url:url,
		async: false,
		success:function(registro){
		   var valores = eval(registro);
		   estado_apertura = valores[0];
		}
	});
	return estado_apertura;	
}

//INICIO CUENTAS POR COBRAR CLIENTES
var listar_cuentas_por_cobrar_clientes = function(){
	var tipo_busqueda = $("#form_main_cobrar_clientes #tipo_busqueda").val();
	var fechai = $("#form_main_cobrar_clientes #fechai").val();
	var fechaf = $("#form_main_cobrar_clientes #fechaf").val();
	
	var table_cuentas_por_cobrar_clientes = $("#dataTableCuentasPorCobrarClientes").DataTable({
		"destroy":true,
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL;?>core/llenarDataTableCobrarClientes.php",
			"data":{
				"tipo_busqueda":tipo_busqueda,
				"fechai":fechai,
				"fechaf":fechaf
			}
		},
		"columns":[
			{"defaultContent":"<button class='table_pay pay btn btn-dark ocultar'><span class='fas fa-hand-holding-usd fa-lg'></span></button>"},
			{"defaultContent":"<button class='table_pay abono btn btn-dark ocultar'><span class='fas fa-cash-register fa-lg'></span></button>"},
			{"data":"fecha"},
			{"data":"cliente"},
			{"data":"numero"},
			{"data":"credito"},
			{"data":"abono"},
			{"data":"saldo"}
		],
		"pageLength": 10,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,
		"dom": dom,
		"columnDefs": [
		  { width: "2.5%", targets: 0 },
		  { width: "2.5%", targets: 1 },
		  { width: "12.5%", targets: 2 },
		  { width: "20.5%", targets: 3 },
		  { width: "24.5%", targets: 4 },
		  { width: "12.5%", targets: 5 },
		  { width: "12.5%", targets: 6 },
		  { width: "12.5%", targets: 7 }		  	  
		],			
		"buttons":[
			{
				text:      '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
				titleAttr: 'Actualizar Cuentas por Cobrar Clientes',
				className: 'table_actualizar btn btn-secondary ocultar',
				action: 	function(){
					listar_cuentas_por_cobrar_clientes();
				}
			},
			{
				extend:    'excelHtml5',
				text:      '<i class="fas fa-file-excel fa-lg"></i> Excel',
				titleAttr: 'Excel',
				title: 'Reporte Cuents por Cobrar Clientes',
				exportOptions: {
						columns: [2,3,4,5,6,7]
				},
				className: 'table_reportes btn btn-success ocultar'
			},
			{
				extend:    'pdf',
				text:      '<i class="fas fa-file-pdf fa-lg"></i> PDF',
				titleAttr: 'PDF',
				title: 'Reporte Cuentas por Cobrar Clientes',
				messageTop: 'Fecha desde: ' + convertDateFormat(fechai) + ' Fecha hasta: ' + convertDateFormat(fechaf),
				messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),				
				className: 'table_reportes btn btn-danger ocultar',
				exportOptions: {
						columns: [2,3,4,5,6,7]
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
	table_cuentas_por_cobrar_clientes.search('').draw();
	$('#buscar').focus();

	registrar_pago_clientes_dataTable("#dataTableCuentasPorCobrarClientes tbody", table_cuentas_por_cobrar_clientes);
}

var registrar_pago_clientes_dataTable = function(tbody, table){
	$(tbody).off("click", "button.table_pay");
	$(tbody).on("click", "button.table_pay", function(){
		var data = table.row( $(this).parents("tr") ).data();
		pago(data.facturas_id);
	});
}

//INICIO CUENTAS POR PAGAR PROVEEDORES
var listar_cuentas_por_pagar_proveedores = function(){
	var tipo_busqueda = $("#form_main_pagar_proveedores #tipo_busqueda").val();
	var fechai = $("#form_main_pagar_proveedores #fechai").val();
	var fechaf = $("#form_main_pagar_proveedores #fechaf").val();

	var table_cuentas_por_pagar_proveedores = $("#dataTableCuentasPorPagarProveedores").DataTable({
		"destroy":true,
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL;?>core/llenarDataTablePagarProveedores.php",
			"data":{
				"tipo_busqueda":tipo_busqueda,
				"fechai":fechai,
				"fechaf":fechaf
			}
		},
		"columns":[
			{"defaultContent":"<button class='table_pay btn btn-dark ocultar'><span class='fas fa-hand-holding-usd fa-lg'></span></button>"},
			{"data":"fecha"},
			{"data":"proveedores"},
			{"data":"factura"},
			{"data":"credito"},
			{"data":"abono"},			
			{"data":"saldo"}
		],
		"pageLength": 10,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,
		"dom": dom,
		"buttons":[
			{
				text:      '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
				titleAttr: 'Actualizar Cuentas Pagar Proveedores',
				className: 'table_actualizar btn btn-secondary ocultar',
				action: 	function(){
					listar_cuentas_por_pagar_proveedores();
				}
			},
			{
				extend:    'excelHtml5',
				text:      '<i class="fas fa-file-excel fa-lg"></i> Excel',
				titleAttr: 'Excel',
				title: 'Reporte Cuentas por Pagar Proveedores',
				messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
				className: 'table_reportes btn btn-success ocultar',
				exportOptions: {
						columns: [1,2,3,4,5,6]
				}				
			},
			{
				extend:    'pdf',
				text:      '<i class="fas fa-file-pdf fa-lg"></i> PDF',
				titleAttr: 'PDF',
				title: 'Reporte Cuentas por Pagar Proveedores',
				messageTop: 'Fecha desde: ' + convertDateFormat(fechai) + ' Fecha hasta: ' + convertDateFormat(fechaf),
				messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),				
				className: 'table_reportes btn btn-danger ocultar',
				exportOptions: {
						columns: [1,2,3,4,5,6]
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
	table_cuentas_por_pagar_proveedores.search('').draw();
	$('#buscar').focus();

	registrar_pago_proveedores_dataTable("#dataTableCuentasPorPagarProveedores tbody", table_cuentas_por_pagar_proveedores);
}

var registrar_pago_proveedores_dataTable = function(tbody, table){
	$(tbody).off("click", "button.table_pay");
	$(tbody).on("click", "button.table_pay", function(){
		var data = table.row( $(this).parents("tr") ).data();
		pagoCompras(data.compras_id);
	});
}
//FIN LLENAR TABLAS

/*INICIO FUNCION OBTENER MUNICIPIOS*/
function getMunicipiosClientes(departamentos_id, municipios_id){
	var url = '<?php echo SERVERURL;?>core/getMunicipios.php';

	var departamentos_id = $('#formClientes #departamento_cliente').val();

	$.ajax({
	   type:'POST',
	   url:url,
	   data:'departamentos_id='+departamentos_id,
	   success:function(data){
		  $('#formClientes #municipio_cliente').html("");
		  $('#formClientes #municipio_cliente').html(data);
		  $('#formClientes #municipio_cliente').val(municipios_id);
	  }
  });
  return false;
}

$('#formClientes #departamento_cliente').on('change', function(){
		var url = '<?php echo SERVERURL;?>core/getMunicipios.php';

		var departamentos_id = $('#formClientes #departamento_cliente').val();

	    $.ajax({
		   type:'POST',
		   url:url,
		   data:'departamentos_id='+departamentos_id,
		   success:function(data){
		      $('#formClientes #municipio_cliente').html("");
			  $('#formClientes #municipio_cliente').html(data);
		  }
	  });
	  return false;
});

$(document).ready(function(){
	$("#modal_registrar_clientes").on('shown.bs.modal', function(){
		$(this).find('#formClientes #nombre_clientes').focus();
	});
});	

//INICIO ACCIONES FROMULARIO CLIENTES
var listar_clientes = function(){
	var table_clientes = $("#dataTableClientes").DataTable({
		"destroy":true,
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL;?>core/llenarDataTableClientes.php"
		},
		"columns":[
			{"data":"cliente"},
			{"data":"rtn"},
			{"data":"localidad"},
			{"data":"telefono"},
			{"data":"correo"},
			{"data":"departamento"},
			{"data":"municipio"},
			{"defaultContent":"<button class='table_editar btn btn-dark ocultar'><span class='fas fa-edit fa-lg'></span></button>"},
			{"defaultContent":"<button class='table_eliminar btn btn-dark ocultar'><span class='fa fa-trash fa-lg'></span></button>"}
		],
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,
		"dom": dom,
		"columnDefs": [
		  { width: "21.11%", targets: 0 },
		  { width: "11.11%", targets: 1 },
		  { width: "19.11%", targets: 2 },
		  { width: "11.11%", targets: 3 },
		  { width: "11.11%", targets: 4 },
		  { width: "11.11%", targets: 5 },
		  { width: "11.11%", targets: 6 },
		  { width: "2.11%", targets: 7 },
		  { width: "2.11%", targets: 8 }
		],
		"buttons":[
			{
				text:      '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
				titleAttr: 'Actualizar Clientes',
				className: 'table_actualizar btn btn-secondary ocultar',
				action: 	function(){
					listar_clientes();
				}
			},
			{
				text:      '<i class="fas fas fa-plus fa-lg crear"></i> Crear',
				titleAttr: 'Agregar Clientes',
				className: 'table_crear btn btn-primary ocultar',
				action: 	function(){
					modal_clientes();
				}
			},
			{
				extend:    'excelHtml5',
				text:      '<i class="fas fa-file-excel fa-lg"></i> Excel',
				titleAttr: 'Excel',
				title: 'Reporte de Clientes',
				messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
				exportOptions: {
						columns: [0,1,2,3,4,5,6,6]
				},
				className: 'table_reportes btn btn-success ocultar'
			},
			{
				extend:    'pdf',
				orientation: 'landscape',
				text:      '<i class="fas fa-file-pdf fa-lg"></i> PDF',
				titleAttr: 'PDF',
				pageSize: 'LEGAL',	
				title: 'Reporte de Clientes',
				messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
				className: 'table_reportes btn btn-danger ocultar',
				exportOptions: {
						columns: [0,1,2,3,4,5,6]
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
	table_clientes.search('').draw();
	$('#buscar').focus();

	editar_clientes_dataTable("#dataTableClientes tbody", table_clientes);
	eliminar_clientes_dataTable("#dataTableClientes tbody", table_clientes);
}

var editar_clientes_dataTable = function(tbody, table){
	$(tbody).off("click", "button.table_editar");
	$(tbody).on("click", "button.table_editar", function(){
		var data = table.row( $(this).parents("tr") ).data();
		var url = '<?php echo SERVERURL;?>core/editarClientes.php';
		$('#formClientes #clientes_id').val(data.clientes_id)

		$.ajax({
			type:'POST',
			url:url,
			data:$('#formClientes').serialize(),
			success: function(registro){
				var valores = eval(registro);
				$('#formClientes').attr({ 'data-form': 'update' });
				$('#formClientes').attr({ 'action': '<?php echo SERVERURL;?>ajax/modificarClientesAjax.php' });
				$('#formClientes')[0].reset();
				$('#reg_cliente').hide();
				$('#edi_cliente').show();
				$('#delete_cliente').hide();
				
				$('#formClientes #nombre_clientes').val(valores[0]);
				$('#formClientes #identidad_clientes').val(valores[1]);
				$('#formClientes #fecha_clientes').attr('disabled', true);
				$('#formClientes #fecha_clientes').val(valores[2]);
				$('#formClientes #departamento_cliente').val(valores[3]);
				getMunicipiosClientes(valores[4], valores[4]);
				$('#formClientes #dirección_clientes').val(valores[5]);
				$('#formClientes #telefono_clientes').val(valores[6]);
				$('#formClientes #correo_clientes').val(valores[7]);

				if(valores[8] == 1){
					$('#formClientes #clientes_activo').attr('checked', true);
				}else{
					$('#formClientes #clientes_activo').attr('checked', false);
				}

				//HABILITAR OBJETOS
				$('#formClientes #nombre_clientes').attr("readonly", false);
				$('#formClientes #departamento_cliente').attr("disabled", false);
				$('#formClientes #municipio_cliente').attr("disabled", false);
				$('#formClientes #dirección_clientes').attr("disabled", false);
				$('#formClientes #telefono_clientes').attr("readonly", false);
				$('#formClientes #correo_clientes').attr("readonly", false);
				$('#formClientes #clientes_activo').attr("disabled", false);

				//DESHABILITAR
				$('#formClientes #identidad_clientes').attr("readonly", true);
				$('#formClientes #fecha_clientes').attr("readonly", true);
				$('#formClientes #estado_clientes').show();
				
				$('#formClientes #proceso_clientes').val("Editar");
				$('#modal_registrar_clientes').modal({
					show:true,
					keyboard: false,
					backdrop:'static'
				});
			}
		});
	});
}

var eliminar_clientes_dataTable = function(tbody, table){
	$(tbody).off("click", "button.table_eliminar");
	$(tbody).on("click", "button.table_eliminar", function(){
		var data = table.row( $(this).parents("tr") ).data();
		var url = '<?php echo SERVERURL;?>core/editarClientes.php';
		$('#formClientes #clientes_id').val(data.clientes_id);

		$.ajax({
			type:'POST',
			url:url,
			data:$('#formClientes').serialize(),
			success: function(registro){
				var valores = eval(registro);
				$('#formClientes').attr({ 'data-form': 'delete' });
				$('#formClientes').attr({ 'action': '<?php echo SERVERURL;?>ajax/eliminarClientesAjax.php' });
				$('#formClientes')[0].reset();
				$('#reg_cliente').hide();
				$('#edi_cliente').hide();
				$('#delete_cliente').show();
				
				$('#formClientes #nombre_clientes').val(valores[0]);
				$('#formClientes #identidad_clientes').val(valores[1]);
				$('#formClientes #fecha_clientes').attr('disabled', true);
				$('#formClientes #fecha_clientes').val(valores[2]);
				$('#formClientes #departamento_cliente').val(valores[3]);
				getMunicipiosClientes(valores[4], valores[4]);
				$('#formClientes #dirección_clientes').val(valores[5]);
				$('#formClientes #telefono_clientes').val(valores[6]);
				$('#formClientes #correo_clientes').val(valores[7]);

				if(valores[8] == 1){
					$('#formClientes #clientes_activo').attr('checked', true);
				}else{
					$('#formClientes #clientes_activo').attr('checked', false);
				}

				//DESHABILITAR OBJETOS
				$('#formClientes #nombre_clientes').attr("readonly", true);
				$('#formClientes #identidad_clientes').attr("readonly", true);
				$('#formClientes #fecha_clientes').attr("readonly", true);
				$('#formClientes #departamento_cliente').attr("disabled", true);
				$('#formClientes #municipio_cliente').attr("disabled", true);
				$('#formClientes #dirección_clientes').attr("disabled", true);
				$('#formClientes #telefono_clientes').attr("readonly", true);
				$('#formClientes #correo_clientes').attr("readonly", true);
				$('#formClientes #clientes_activo').attr("disabled", true);
				$('#formClientes #estado_clientes').hide();

				$('#formClientes #proceso_clientes').val("Eliminar");
				$('#modal_registrar_clientes').modal({
					show:true,
					keyboard: false,
					backdrop:'static'
				});
			}
		});
	});
}

$('#formClientes #label_clientes_activo').html("Activo");

$('#formClientes .switch').change(function(){    
    if($('input[name=clientes_activo]').is(':checked')){
        $('#formClientes #label_clientes_activo').html("Activo");
        return true;
    }
    else{
        $('#formClientes #label_clientes_activo').html("Inactivo");
        return false;
    }
});
//FIN ACCIONES FROMULARIO CLIENTES

//INICIO MODAL REGSITRAR PAGO FACTURACIÓN CLIENTES
function pago(facturas_id){
	var url = '<?php echo SERVERURL;?>core/editarPagoFacturas.php';
	
	$.ajax({
		type:'POST',
		url:url,
		data:'facturas_id='+facturas_id,
		success: function(valores){
			var datos = eval(valores);
			$('#formEfectivoBill .border-right a:eq(0) a').tab('show');			
			$("#customer-name-bill").html("<b>Cliente:</b> " + datos[0]);
		    $("#customer_bill_pay").val(datos[3]);
			$('#bill-pay').html("L. " + parseFloat(datos[3]).toFixed(2));
			
			//EFECTIVO
			$('#formEfectivoBill')[0].reset();			
			$('#formEfectivoBill #monto_efectivo').val(datos[3]);
			$('#formEfectivoBill #factura_id_efectivo').val(facturas_id);
			$('#formEfectivoBill #pago_efectivo').attr('disabled', true);
			
			//TARJETA
			$('#formTarjetaBill')[0].reset();
			$('#formTarjetaBill #monto_efectivo').val(datos[3]);
			$('#formTarjetaBill #factura_id_tarjeta').val(facturas_id);
			$('#formTarjetaBill #pago_efectivo').attr('disabled', true);	

			//MIXTO
			$('#formMixtoBill')[0].reset();
			$('#formMixtoBill #monto_efectivo_mixto').val(datos[3]);
			$('#formMixtoBill #factura_id_mixto').val(facturas_id);
			$('#formMixtoBill #pago_efectivo_mixto').attr('disabled', true);

			//TRANSFERENCIA
			$('#formTransferenciaBill')[0].reset();
			$('#formTransferenciaBill #monto_efectivo').val(datos[3]);
			$('#formTransferenciaBill #factura_id_transferencia').val(facturas_id);
			$('#formTransferenciaBill #pago_efectivo').attr('disabled', true);
			
			//CHEQUES
			$('#formChequeBill')[0].reset();
			$('#formChequeBill #monto_efectivo').val(datos[3]);
			$('#formChequeBill #factura_id_cheque').val(facturas_id);
			$('#formChequeBill #pago_efectivo').attr('disabled', true);			
			
			$('#modal_pagos').modal({
				show:true,
				keyboard: false,
				backdrop:'static'
			});

			return false;
		}
	});	
}

$(document).ready(function(){
	$("#tab1").on("click", function(){	
		$("#modal_pagos").on('shown.bs.modal', function(){
           $(this).find('#formTarjetaBill #efectivo_bill').focus();
		});			
	});
	
	$("#tab2").on("click", function(){	
		$("#modal_pagos").on('shown.bs.modal', function(){
           $(this).find('#formTarjetaBill #cr_bill').focus();
		});	
	});	
	
	$("#tab3").on("click", function(){	
		$("#modal_pagos").on('shown.bs.modal', function(){
           $(this).find('#formTarjetaBill #bk_nm').focus();
		});	
	});	
	
	$("#tab4").on("click", function(){	
		$("#modal_pagos").on('shown.bs.modal', function(){
           $(this).find('#formChequeBill #bk_nm_chk').focus();
		});	
	});	
	
	$("#tab5").on("click", function(){	
		$("#modal_pagos").on('shown.bs.modal', function(){
           $(this).find('#formMixtoBill #efectivo_bill_mixto').focus();
		});	
	});	
});

$(document).ready(function(){
	$('#formTarjetaBill #cr_bill').inputmask("9999");
});

$(document).ready(function(){
	$('#formTarjetaBill #exp').inputmask("99/99");
});

$(document).ready(function(){
	$('#formTarjetaBill #cvcpwd').inputmask("999999");
});

// MIXTO
$(document).ready(function(){
	$('#formMixtoBill #cr_bill_mixto').inputmask("9999");
});

$(document).ready(function(){
	$('#formMixtoBill #exp_mixto').inputmask("99/99");
});

$(document).ready(function(){
	$('#formMixtoBill #cvcpwd_mixto').inputmask("999999");
});

$(document).ready(function(){
	$("#formEfectivoBill #efectivo_bill").on("keyup", function(){	
		var efectivo = parseFloat($("#formEfectivoBill #efectivo_bill").val()).toFixed(2);
		var monto = parseFloat($("#formEfectivoBill #monto_efectivo").val()).toFixed(2);
		
		var total = efectivo - monto;				
		
		if(Math.floor(efectivo*100) >= Math.floor(monto*100)){			
			$('#formEfectivoBill #cambio_efectivo').val(parseFloat(total).toFixed(2));
			$('#formEfectivoBill #pago_efectivo').attr('disabled', false);				
		}else{
			$('#formEfectivoBill #cambio_efectivo').val(parseFloat(0).toFixed(2));
			$('#formEfectivoBill #pago_efectivo').attr('disabled', true);
		}				
	});

	//MIXTO
	$("#formMixtoBill #efectivo_bill_mixto").on("keyup", function(){	
		var efectivo = parseFloat($("#formMixtoBill #efectivo_bill_mixto").val()).toFixed(2);
		var monto = parseFloat($("#formMixtoBill #monto_efectivo_mixto").val()).toFixed(2);
		
		var total = efectivo - monto;				
		
		if(Math.floor(efectivo*100) >= Math.floor(monto*100)){			
			$('#formMixtoBill #pago_efectivo_mixto').attr('disabled', true);	
			$('#formMixtoBill #monto_tarjeta').val(parseFloat(0).toFixed(2));
			$('#formMixtoBill #monto_tarjeta').attr('disabled', true);			
		}else{
			var tarjeta = monto - efectivo;
			$('#formMixtoBill #monto_tarjeta').val(parseFloat(tarjeta).toFixed(2))
			$('#formMixtoBill #cambio_efectivo_mixto').val(parseFloat(0).toFixed(2));
			$('#formMixtoBill #pago_efectivo_mixto').attr('disabled', false);
		}				
	});
});

function getBanco(){
	var url = '<?php echo SERVERURL;?>core/getBanco.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formTransferenciaBill #bk_nm').html("");
			$('#formTransferenciaBill #bk_nm').html(data);

		    $('#formChequeBill #bk_nm_chk').html("");
			$('#formChequeBill #bk_nm_chk').html(data);
        }
     });
}
//FIN MODAL REGSITRAR PAGO FACTURACIÓN CLIENTES

//INICIO MODAL REGSITRAR PAGO COMPRAS PROVEEDORES
function pagoCompras(compras_id){
	var url = '<?php echo SERVERURL;?>core/editarPagoCompras.php';

	$.ajax({
		type:'POST',
		url:url,
		data:'compras_id='+compras_id,
		success: function(valores){
			var datos = eval(valores);	
			$('#formEfectivoPurchase .border-right a:eq(0) a').tab('show');
			$("#customer-name-Purchase").html("<b>Proveedor:</b> " + datos[0]);
		    $("#customer_Purchase_pay").val(datos[3]);
			$('#Purchase-pay').html("L. " + parseFloat(datos[3]).toFixed(2));
			
			//EFECTIVO
			$('#formEfectivoPurchase')[0].reset();
			$('#formEfectivoPurchase #monto_efectivoPurchase').val(datos[3]);
			$('#formEfectivoPurchase #compras_id_efectivo').val(compras_id);
			$('#formEfectivoPurchase #pago_efectivo').attr('disabled', true);
			
			//TARJETA
			$('#formTarjetaPurchase')[0].reset();
			$('#formTarjetaPurchase #monto_efectivoPurchase').val(datos[3]);
			$('#formTarjetaPurchase #compras_id_tarjeta').val(compras_id);
			$('#formTarjetaPurchase #pago_efectivo').attr('disabled', true);
			
			//mixto
			$('#formMixtoPurchaseBill')[0].reset();
			$('#formMixtoPurchaseBill #monto_efectivo_mixtoPurchase').val(datos[3]);
			$('#formMixtoPurchaseBill #compras_id_mixto').val(compras_id);
			$('#formMixtoPurchaseBill #pago_mixto_Purchase').attr('disabled', true);

			//TRANSFERENCIA
			$('#formTransferenciaPurchase')[0].reset();
			$('#formTransferenciaPurchase #monto_efectivoPurchase').val(datos[3]);
			$('#formTransferenciaPurchase #compras_id_transferencia').val(compras_id);
			$('#formTransferenciaPurchase #pago_efectivo').attr('disabled', true);		
			
			$('#modal_pagosPurchase').modal({
				show:true,
				keyboard: false,
				backdrop:'static'
			});

			return false;
		}
	});	
}

$(document).ready(function(){
	$("#tab1Purchase").on("click", function(){	
		$("#modal_pagos").on('shown.bs.modal', function(){
           $(this).find('#formEfectivoPurchase #efectivo_Purchase').focus();
		});			
	});
	
	$("#tab2Purchase").on("click", function(){	
		$("#modal_pagos").on('shown.bs.modal', function(){
           $(this).find('#formEfectivoPurchase #cr_Purchase').focus();
		});	
	});	
	
	$("#tab2Purchase").on("click", function(){	
		$("#modal_pagos").on('shown.bs.modal', function(){
           $(this).find('#formEfectivoPurchase #bk_nm').focus();
		});	
	});		
});

$(document).ready(function(){
	$('#formTarjetaPurchase #cr_Purchase').inputmask("9999");
});

$(document).ready(function(){
	$('#formTarjetaPurchase #exp').inputmask("99/99");
});

$(document).ready(function(){
	$('#formTarjetaPurchase #cvcpwd').inputmask("999999");
});

//mixto
$(document).ready(function(){
	$('#formMixtoPurchaseBill #cr_bill_mixtoPurchase').inputmask("9999");
});

$(document).ready(function(){
	$('#formMixtoPurchaseBill #exp_mixtoPurchase').inputmask("99/99");
});

$(document).ready(function(){
	$('#formMixtoPurchaseBill #cvcpwd_mixtoPurchase').inputmask("999999");
});

$(document).ready(function(){
	$("#formEfectivoPurchase #efectivo_Purchase").on("keyup", function(){				
		var efectivo = parseFloat($("#formEfectivoPurchase #efectivo_Purchase").val()).toFixed(2);
		var monto = parseFloat($("#formEfectivoPurchase #monto_efectivoPurchase").val()).toFixed(2);
		
		var total = efectivo - monto;				
		//Math.floor NOS PERMITE COMPARAR UN FLOAT CONVIRTIENDOLO A ENTERO CUANDO SE MULTIPLICA POR 100
		
		if(Math.floor(efectivo*100) >= Math.floor(monto*100)){	
			$('#formEfectivoPurchase #cambio_efectivoPurchase').val(parseFloat(total).toFixed(2));
			$('#formEfectivoPurchase #pago_efectivo').attr('disabled', false);				
		}else{				
			$('#formEfectivoPurchase #cambio_efectivoPurchase').val(parseFloat(0).toFixed(2));
			$('#formEfectivoPurchase #pago_efectivo').attr('disabled', true);
		}				
	});
});	

//mixto
$(document).ready(function(){
	$("#formMixtoPurchaseBill #efectivo_bill_mixtoPurchase").on("keyup", function(){				
		var efectivo = parseFloat($("#formMixtoPurchaseBill #efectivo_bill_mixtoPurchase").val()).toFixed(2);
		var monto = parseFloat($("#formMixtoPurchaseBill #monto_efectivo_mixtoPurchase").val()).toFixed(2);
		
		var total = efectivo - monto;				
		//Math.floor NOS PERMITE COMPARAR UN FLOAT CONVIRTIENDOLO A ENTERO CUANDO SE MULTIPLICA POR 100
		
		if(Math.floor(efectivo*100) >= Math.floor(monto*100)){	
			$('#formMixtoPurchaseBill #pago_mixto_Purchase').attr('disabled', true);
			$('#formMixtoPurchaseBill #monto_tarjeta_mixtoPurchase').val(parseFloat(0).toFixed(2));
			$('#formMixtoPurchaseBill #monto_tarjeta_mixtoPurchase').attr('disabled', true);			
		}else{				
			var tarjeta = monto - efectivo;
			$('#formMixtoPurchaseBill #monto_tarjeta_mixtoPurchase').val(parseFloat(tarjeta).toFixed(2))
			$('#formMixtoPurchaseBill #cambio_efectivo_mixtoPurchase').val(parseFloat(0).toFixed(2));
			$('#formMixtoPurchaseBill #pago_mixto_Purchase').attr('disabled', false);
		}				
	});
});	

function getBancoPurchase(){
	var url = '<?php echo SERVERURL;?>core/getBanco.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formTransferenciaPurchase #bk_nm').html("");
			$('#formTransferenciaPurchase #bk_nm').html(data);	
			
		    $('#formChequePurchase #bk_nm_chk').html("");
			$('#formChequePurchase #bk_nm_chk').html(data);				
        }
     });
}
//FIN MODAL REGSITRAR PAGO COMPRAS PROVEEDORES
</script>
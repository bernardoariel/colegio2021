<?php

require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";
require_once "../controladores/comprobantes.controlador.php";
require_once "../modelos/comprobantes.modelo.php";
require_once "../controladores/escribanos.controlador.php";
require_once "../modelos/escribanos.modelo.php";
require_once "../controladores/caja.controlador.php";
require_once "../modelos/caja.modelo.php";
require_once "../controladores/articulos.controlador.php";
require_once "../modelos/articulos.modelo.php";

require_once "../controladores/remitos.controlador.php";
require_once "../modelos/remitos.modelo.php";
require_once "../controladores/cuotas.controlador.php";
require_once "../modelos/cuotas.modelo.php";
class AjaxCrearVenta{

	/*=============================================
	CREAR NUEVA VENTA
	=============================================*/	
	public function ajaxNuevaVenta(){


		if ($_POST["tipoCliente"]=='delegacion'){

			$respuesta = ControladorRemitos::ctrCrearRemito();
		
			return $respuesta;

		}else{

			$respuesta = ControladorVentas::ctrCrearVenta();
		
			return $respuesta;
		}
		
		
		

	}

	/*=============================================
	EDITAR ULTIMA VENTA
	=============================================*/	
	public function ajaxEditarCuota(){

		$respuesta = ControladorCuotas::ctrEditarCuota();
	
		return $respuesta;

	}

	/*=============================================
	TRAER LA ULTIMA VENTA
	=============================================*/	
	public function ajaxUltimaVenta(){
	
		$respuesta =  ControladorVentas::ctrUltimoId();
		echo json_encode($respuesta);

	}

	/*=============================================
	REMITOS
	=============================================*/	
	public function ajaxRemito(){

		$respuesta = ControladorRemitos::ctrCrearRemito();
		return $respuesta;

	}
	
	/*=============================================
	FACTURA SIN HOMOLOGACION
	=============================================*/	
	public function ajaxSinHomologacion(){

		/**
		 * agrego esto para poder realizar la correlatividad... de los eje
		 */
		$listaProductos = json_decode($_POST["listaProductos"], true);
		#creo un array del afip
		$items=Array();
		#recorro $listaproductos para cargarlos en la tabla de comprobantes
		foreach ($listaProductos as $key => $value) {

		    $tablaComprobantes = "comprobantes";

		    $valor = $value["idnrocomprobante"];
		    $datos = $value["folio2"];

		    $actualizarComprobantes = ModeloComprobantes::mdlUpdateComprobante($tablaComprobantes, $valor,$datos);
		}
		
		$fecha = date("Y-m-d");

		if ($_POST["listaMetodoPago"]=="CTA.CORRIENTE"){
			
			$adeuda=$_POST["totalVenta"];

			$fechapago="0000-00-00";

		}else{

			$adeuda=0;

			$fechapago = $fecha;

			$caja = ControladorCaja::ctrMostrarCaja($item, $valor);
		         
		          
		          $efectivo = $caja[0]['efectivo'];
		          $tarjeta = $caja[0]['tarjeta'];
		          $cheque = $caja[0]['cheque'];
		          $transferencia = $caja[0]['transferencia'];

		          switch ($_POST["listaMetodoPago"]) {
		          	case 'EFECTIVO':
		          		# code...
		          		$efectivo = $efectivo + $_POST["totalVenta"];
		          		break;
		          	case 'TARJETA':
		          		# code...
		          		$tarjeta = $tarjeta + $_POST["totalVenta"];
		          		break;
		          	case 'CHEQUE':
		          		# code...
		          		$cheque = $cheque + $_POST["totalVenta"];
		          		break;
		          	case 'TRANSFERENCIA':
		          		# code...
		          		$transferencia = $transferencia + $_POST["totalVenta"];
		          		break;
		          }
		          

		          $datos = array("fecha"=>date('Y-m-d'),
		          
					             "efectivo"=>$efectivo,
					             "tarjeta"=>$tarjeta,
					             "cheque"=>$cheque,
					             "transferencia"=>$transferencia);
		          
		          $caja = ControladorCaja::ctrEditarCaja($item, $datos);
		}
		
		$tabla = 'ventas';
		$codigoFactura ="SIN HOMOLOGAR";
		$datos = array("id_vendedor"=>$_POST["idVendedor"],
					   "fecha"=>$fecha,
					   "tipo"=>$_POST["tipoFc"],
					   "id_cliente"=>$_POST["seleccionarCliente"],
					   "nombre"=>$_POST['nombreCliente'],
					   "documento"=>$_POST['documentoCliente'],
					   "tabla"=>$_POST['tipoCliente'],
					   "codigo"=>$codigoFactura,
					   "productos"=>$_POST["listaProductos"],
					   "impuesto"=>$_POST["nuevoPrecioImpuesto"],
					   "neto"=>$_POST["nuevoPrecioNeto"],
					   "total"=>$_POST["totalVenta"],
					   "adeuda"=>$adeuda,
					   "obs"=>'',
					   "metodo_pago"=>$_POST["listaMetodoPago"],
					   "referenciapago"=>$_POST["nuevaReferencia"],
					   "cae"=>'',
					   "fecha_cae"=>'',
					   "fechapago"=>$fechapago);

	   
		 
		$respuesta = ModeloVentas::mdlIngresarVenta($tabla, $datos);
		
		
		// ControladorArticulos::ctrPrepararIngresoArticulo();

		if ($_POST["listaMetodoPago"]!='CTA.CORRIENTE'){

			//AGREGAR A LA CAJA
		  $item = "fecha";
		  $valor = date('Y-m-d');

		  $caja = ControladorCaja::ctrMostrarCaja($item, $valor);
		 
		  
		  $efectivo = $caja[0]['efectivo'];
		  $tarjeta = $caja[0]['tarjeta'];
		  $cheque = $caja[0]['cheque'];
		  $transferencia = $caja[0]['transferencia'];

		  switch ($_POST["listaMetodoPago"]) {
			  case 'EFECTIVO':
				  # code...
				  $efectivo = $efectivo + $_POST["totalVenta"];
				  break;
			  case 'TARJETA':
				  # code...
				  $tarjeta = $tarjeta + $_POST["totalVenta"];
				  break;
			  case 'CHEQUE':
				  # code...
				  $cheque = $cheque + $_POST["totalVenta"];
				  break;
			  case 'TRANSFERENCIA':
				  # code...
				  $transferencia = $transferencia + $_POST["totalVenta"];
				  break;
		  }
		  

		  $datos = array("fecha"=>date('Y-m-d'),
		  
						 "efectivo"=>$efectivo,
						 "tarjeta"=>$tarjeta,
						 "cheque"=>$cheque,
						 "transferencia"=>$transferencia);
		  
		  $caja = ControladorCaja::ctrEditarCaja($item, $datos);
		}

		if(isset( $_POST['idVentaNro'])){
			
			ModeloCuotas::mdlEliminarVenta("cuotas", $_POST["idVentaNro"]);
			// echo '<center><pre>'; print_r($respuesta2 . ' '.$_POST["idVentaNro"]); echo '</pre></center>';
		}
		
	}

	/*=============================================
	FACTURA SIN HOMOLOGACION
	=============================================*/	
	public function ajaxEditarVentaSinHomologar(){

    	$tablaClientes = "escribanos";

		$item = "id";
		$valor = $_POST["seleccionarCliente"];

		$traerCliente = ModeloEscribanos::mdlMostrarEscribanos($tablaClientes, $item, $valor);
		if($traerCliente['facturacion']=="CUIT"){
				
			$nombre=$traerCliente['nombre'];
			$documento=$traerCliente['cuit'];
				
			}else{
					
			$nombre=$traerCliente['nombre'];
			$documento=$traerCliente['documento'];

		}	
		/*=============================================
		FORMATEO LOS DATOS
		=============================================*/	
	
		$fecha = date("Y-m-d");

		if ($_POST["listaMetodoPago"]=="CTA.CORRIENTE"){
			
			$adeuda=$_POST["totalVenta"];

			$fechapago="0000-00-00";


		}else{

			$adeuda=0;

			$fechapago = $fecha;
		}
			
		

		$tabla = "ventas";
		
		$datos = array("id_vendedor"=>1,
						   "fecha"=>date('Y-m-d'),
						   "codigo"=>"SIN HOMOLOGAR",
						   "tipo"=>$_POST['tipoCuota'],
						   "id_cliente"=>$_POST['seleccionarCliente'],
						   "nombre"=>$nombre,
						   "documento"=>$documento,
						   "tabla"=>$_POST['tipoCliente'],
						   "productos"=>$_POST['listaProductos'],
						   "impuesto"=>0,
						   "neto"=>0,
						   "total"=>$_POST["totalVenta"],
						   "adeuda"=>'0',
						   "obs"=>'',
						   "cae"=>'',
						   "fecha_cae"=>'',
						   "fechapago"=>$fechapago,
						   "metodo_pago"=>$_POST['listaMetodoPago'],
						   "referenciapago"=>$_POST['nuevaReferencia']
						   );


				$respuesta = ModeloVentas::mdlIngresarVenta($tabla, $datos);
				$eliminarCuota = ModeloCuotas::mdlEliminarVenta("cuotas", $_POST["idVentaSinHomologacion"]);

    	
	}
	/*=============================================
	HOLOGOGACION VENTA
	=============================================*/	
	public function ajaxHomogacionVenta(){


		$respuesta = ControladorVentas::ctrHomologacionVenta();
	
		return $respuesta;

	}
}
/*=============================================
Traer el ultimo id de factura
=============================================*/	

if(isset($_POST["ultimaFactura"])){

	$nuevaVenta = new AjaxCrearVenta();
	$nuevaVenta -> ajaxUltimaVenta();

}
/*=============================================
CREAR NUEVA VENTA CON FACTURA ELECTRONICA SI NO HAY NINGUN ERROR
=============================================*/	

if(isset($_POST["nuevaVenta"])){

	$nuevaVenta = new AjaxCrearVenta();
	$nuevaVenta -> nuevaVenta();

}
/*=============================================
CREAR NUEVA VENTA CON PENDIENTE A FACTURAR PERO SI EXISTE UN ERROR
=============================================*/	

if(isset($_POST["sinHomologacion"])){

	$nuevaVenta = new AjaxCrearVenta();
	$nuevaVenta -> ajaxSinHomologacion();

}

/*=============================================
EDITA UNA VENTA CUOTA O REINTEGRO PERO SI NO TIENE ERROR
=============================================*/	

if(isset($_POST["idVenta"])){

	$nuevaVenta = new AjaxCrearVenta();
	$nuevaVenta -> ajaxEditarCuota();

}
/*=============================================
EDITA UNA VENTA CUOTA O REINTEGRO PERO SI NO TIENE ERROR
=============================================*/	

if(isset($_POST["idVentaSinHomologacion"])){

	$nuevaVenta = new AjaxCrearVenta();
	$nuevaVenta -> ajaxEditarVentaSinHomologar();

}

// ControladorVentas();
//           $realizarHomologacion -> ctrHomologacionVenta();

/*=============================================
HOMOLOGA UNA FACTURA SI TIENE LOS DATOS CORRECTOS Y SI HAY INTERNET
=============================================*/	
if(isset($_POST["idVentaHomologacion"])){


	$nuevaVenta = new AjaxCrearVenta();
	$nuevaVenta -> ajaxHomogacionVenta();

}

if(isset($_POST["remito"])){


	$nuevaVenta = new AjaxCrearVenta();
	$nuevaVenta -> ajaxRemito();

}
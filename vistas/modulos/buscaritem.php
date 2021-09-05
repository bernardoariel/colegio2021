<!-- {"id":"12","descripcion":"PROTOCOLO","idnrocomprobante":"56","cantventaproducto":"10",
    "folio1":"368451","folio2":"368470","cantidad":"2","precio":"1000","total":"2000"},
{"id":"10","descripcion":"CONCUERDAS","idnrocomprobante":"54","cantventaproducto":"1",
    "folio1":"196925","folio2":"196944","cantidad":"20","precio":"100","total":"2000"},
{"id":"8","descripcion":"CERTIFICACION DE FIRMAS","idnrocomprobante":"52","cantventaproducto":"1",
    "folio1":"670565","folio2":"670584","cantidad":"20","precio":"100","total":"2000"}] -->


<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      BUSCAR ITEMS
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Buscar items</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      

      <div class="box-body">
        
      <?php
        //2018
        
        //2019
        // $fechaInicial='2019-01-01';
        // $fechaFinal='2019-12-31';
        //2020
        // $fechaInicial='2020-01-01';
        // $fechaFinal='2020-12-31';
        //2021
        // $fechaInicial='2021-01-01';
        // $fechaFinal='2021-12-31';

        function copiarVentas($fechaInicial, $fechaFinal){
            //DATOS DE TODAS LAS VENTAS DEL MES
            $respuesta = ControladorVentas::ctrRangoFechasVentasNuevo($fechaInicial,$fechaFinal);

            foreach ($respuesta as $key => $value) {
                #tomo los productos
                $datos = array();
                $listaProductos = json_decode($value["productos"], true);
                #recorro $listaproductos para cargarlos en la tabla de comprobantes
                foreach ($listaProductos as $key => $value2) {

                    $tablaComprobantes = "comprobantes";

                    $idVenta = $value['id'];
                    $idCodigoFc = $value['codigo'];
                    $fecha = $value['fecha'];
                    $nombreEscribano = $value['nombre'];
                    $nroComprobante = $value2["idnrocomprobante"];
                    $descripcionComprobante = $value2["descripcion"];
                    $folio1 = $value2["folio1"];
                    $folio2 = $value2["folio2"];

                    if($folio1 == $folio2){
                        $datos = array(
                            "idVenta"=>$idVenta,
                            "idCodigoFc"=>$idCodigoFc,
                            "fecha"=>$fecha,
                            "nombreEscribano"=>$nombreEscribano,
                            "nroComprobante"=>$nroComprobante,
                            "descripcionComprobante"=>$descripcionComprobante,
                            "folio1"=>$folio1,
                            "folio2"=>$folio2
                        );  
                        // echo '<h2>MISMO FOLIO</h2>';
                        echo '<pre>'.$fechaInicial.' '.$fechaFinal.'</pre>';
                        $respuesta = ControladorVentas::ctrGuardarItem($datos);
                        
                        echo '<pre>'; print_r($respuesta); echo '</pre>';
                    }else{
                        
                        for ($i=$folio1; $i < $folio2 ; $i++) { 
                            # code...
                            $datos = array(
                                "idVenta"=>$idVenta,
                                "idCodigoFc"=>$idCodigoFc,
                                "fecha"=>$fecha,
                                "nombreEscribano"=>$nombreEscribano,
                                "nroComprobante"=>$nroComprobante,
                                "descripcionComprobante"=>$descripcionComprobante,
                                "folio1"=>$folio1,
                                "folio2"=>$i
                            );  
                            // echo '<h2>DISTINTO FOLIO</h2>';
                            // echo '<pre>'; print_r($datos); echo '</pre>';
                            echo '<pre>'.$fechaInicial.' '.$fechaFinal.'</pre>';
                            $respuesta = ControladorVentas::ctrGuardarItem($datos);
                            echo '<pre>'; print_r($respuesta); echo '</pre>';
                        }

                    }
                    
            
                }
                
                
            }
            echo '<h1 class="text-danger">TERMINADO '.$fechaFinal.'</h1>';
        }
        
        // copiarVentas('2018-01-01','2018-01-14');
        // copiarVentas('2018-01-15','2018-01-31');

        // copiarVentas('2018-02-01','2018-02-14');
        // copiarVentas('2018-02-15','2018-02-28');

        // copiarVentas('2018-03-01','2018-03-14');
        // copiarVentas('2018-03-15','2018-03-31');

        // copiarVentas('2018-04-01','2018-04-14');
        // copiarVentas('2018-04-15','2018-04-30');

        // copiarVentas('2018-05-01','2018-05-14');
        // copiarVentas('2018-05-15','2018-05-31');

        // copiarVentas('2018-06-01','2018-06-14');
        // copiarVentas('2018-06-15','2018-06-30');

        // copiarVentas('2018-07-01','2018-07-14');
        // copiarVentas('2018-07-15','2018-07-31');

        // copiarVentas('2018-08-01','2018-08-14');
        // copiarVentas('2018-08-15','2018-08-31');

        // copiarVentas('2018-09-01','2018-09-14');
        // copiarVentas('2018-09-15','2018-09-30');

        // copiarVentas('2018-10-01','2018-10-14');
        copiarVentas('2018-10-15','2018-10-31');

        // copiarVentas('2018-11-01','2018-11-14');
        // copiarVentas('2018-11-15','2018-11-30');

        // copiarVentas('2018-12-01','2018-12-14');
        // copiarVentas('2018-12-15','2018-12-31');
        
        // copiarVentas('2019-01-01','2019-01-14');
        // copiarVentas('2019-01-15','2019-01-31');
        
        // copiarVentas('2019-02-01','2019-02-14');
        // copiarVentas('2019-02-15','2019-02-28');

        // copiarVentas('2019-03-01','2019-03-14');
        // copiarVentas('2019-03-15','2019-03-31');

        // copiarVentas('2019-04-01','2019-04-14');
        // copiarVentas('2019-04-15','2019-04-30');

        // copiarVentas('2019-05-01','2019-05-14');
        // copiarVentas('2019-05-15','2019-05-31');

        // copiarVentas('2019-06-01','2019-06-14');
        // copiarVentas('2019-06-15','2019-06-30');

        // copiarVentas('2019-07-01','2019-07-14');
        // copiarVentas('2019-07-15','2019-07-31');

        // copiarVentas('2019-08-01','2019-08-14');
        // copiarVentas('2019-08-15','2019-08-31');

        // copiarVentas('2019-09-01','2019-09-14');
        // copiarVentas('2019-09-15','2019-09-30');

        // copiarVentas('2019-10-01','2019-10-14');
        // copiarVentas('2019-10-15','2019-10-31');

        // copiarVentas('2019-11-01','2019-11-14');
        // copiarVentas('2019-11-15','2019-11-30');

        // copiarVentas('2019-12-01','2019-12-14');
        // copiarVentas('2019-12-15','2019-12-31');

        // copiarVentas('2020-01-01','2020-01-14');
        // copiarVentas('2020-01-15','2020-01-31');

        // copiarVentas('2020-02-01','2020-02-14');
        // copiarVentas('2020-02-15','2020-02-29');

        // copiarVentas('2020-03-01','2020-03-14');
        // copiarVentas('2020-03-15','2020-03-31');

        // copiarVentas('2020-04-01','2020-04-14');
        // copiarVentas('2020-04-15','2020-04-30');

        // copiarVentas('2020-05-01','2020-05-14');
        // copiarVentas('2020-05-15','2020-05-31');

        // copiarVentas('2020-06-01','2020-06-14');
        // copiarVentas('2020-06-15','2020-06-30');

        // copiarVentas('2020-07-01','2020-07-14');
        // copiarVentas('2020-07-15','2020-07-31');

        // copiarVentas('2020-08-01','2020-08-14');
        // copiarVentas('2020-08-15','2020-08-31');

        // copiarVentas('2020-09-01','2020-09-14');
        // copiarVentas('2020-09-15','2020-09-30');

        // copiarVentas('2020-10-01','2020-10-14');
        // copiarVentas('2020-10-15','2020-10-31');

        // copiarVentas('2020-11-01','2020-11-14');
        // copiarVentas('2020-11-15','2020-11-30');

        // copiarVentas('2020-12-01','2020-12-14');
        // copiarVentas('2020-12-15','2020-12-31');

        
        // copiarVentas('2021-01-01','2021-01-14');
        // copiarVentas('2021-01-15','2021-01-31');

        // copiarVentas('2021-02-01','2021-02-14');
        // copiarVentas('2021-02-15','2021-02-28');

        // copiarVentas('2021-03-01','2021-03-14');
        // copiarVentas('2021-03-15','2021-03-31');

        // copiarVentas('2021-04-01','2021-04-14');
        // copiarVentas('2021-04-15','2021-04-30');

        // copiarVentas('2021-05-01','2021-05-14');
        // copiarVentas('2021-05-15','2021-05-31');

        // copiarVentas('2021-06-01','2021-06-14');
        // copiarVentas('2021-06-15','2021-06-30');

        // copiarVentas('2021-07-01','2021-07-14');
        // copiarVentas('2021-07-15','2021-07-31');

        // copiarVentas('2021-08-01','2021-08-14');
        // copiarVentas('2021-08-15','2021-08-31');

        // copiarVentas('2021-09-01','2021-09-14');
        // copiarVentas('2021-09-15','2021-09-30');

        // copiarVentas('2021-10-01','2021-10-14');
        // copiarVentas('2021-10-15','2021-10-31');

        // copiarVentas('2021-11-01','2021-11-14');
        // copiarVentas('2021-11-15','2021-11-30');

        // copiarVentas('2021-12-01','2021-12-14');
        // copiarVentas('2021-12-15','2021-12-31');
        ?>

      </div>

    </div>

  </section>

</div>
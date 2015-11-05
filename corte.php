 <?php
 /**
 * Author: Ivan Eusebio
 * Date:   05/11/2015
 * 
 */
 include('cadenashelper.php');
 include('config.php'); 

 // Se se especificaron los datos desde el punto de Venta
 if(isset($_POST)){

    $ch = new CadenasHelper();

    $message = 'Se imprimio el Corte de Caja'; 

 	$message_error = 'Ocurrio un error al imprimir el Corte de Caja'; 

    $code_ok = 200;

 	$code_error = 500;

 	$datos_corte = $_POST;

    //Armar cabecera del Ticket
    $contenido_corte = 
    $ch->centrar($datos_corte['empresa_nombre'])."\r\n".
    $ch->centrar("RFC: ".$datos_corte['empresa_rfc'])."\r\n".
    $ch->centrar($datos_corte['empresa_calle']." ".$datos_corte['empresa_numero'])."\r\n".
    $ch->centrar($datos_corte['empresa_colonia']." ".$datos_corte['empresa_cp'])."\r\n".
    $ch->centrar($datos_corte['empresa_ciudad']." ".$datos_corte['empresa_estado']." ".$datos_corte['empresa_pais'])."\r\n".        
    $ch->centrar("CORTE DE CAJA")."\r\n"."\r\n".
    "Apertura:  ".$datos_corte['fecha_inicial']."\r\n".
    "Corte:     ".$datos_corte['fecha_corte']."\r\n".
    "Del Folio: ".$datos_corte['primer_folio']."\r\n".
    "Al Folio:  ".$datos_corte['ultimo_folio']."\r\n".
    "Usuario:   ".$datos_corte['usuario']."\r\n"."\r\n".
    "= TOTALES EN CAJA".$ch->derechaFix(strval(number_format($datos_corte['total_caja'],2, '.', '')), 22)."\r\n".
    "+ Efectivo".$ch->derechaFix(strval(number_format($datos_corte['efectivo'],2, '.', '')), 29)."\r\n".
    "+ Tarjeta de Credito".$ch->derechaFix(strval(number_format($datos_corte['tarjeta_credito'],2, '.', '')), 19)."\r\n".    
    "--------------------------------------"."\r\n"."\r\n".
    "= INGRESOS".$ch->derechaFix(strval(number_format($datos_corte['total_ingresos'],2, '.', '')), 29)."\r\n".
    "+ Contado".$ch->derechaFix(strval(number_format($datos_corte['monto_contado'],2, '.', '')), 30)."\r\n".
    "+ Apertura efectivo".$ch->derechaFix(strval(number_format($datos_corte['apertura_efectivo'],2, '.', '')), 20)."\r\n".
    "--------------------------------------"."\r\n"."\r\n".
    "= EGRESOS".$ch->derechaFix(strval(number_format($datos_corte['egresos'],2, '.', '')), 29)."\r\n".
    "- Devoluciones".$ch->derechaFix(strval(number_format($datos_corte['egresos'],2, '.', '')), 24)."\r\n".
    "--------------------------------------"."\r\n"."\r\n".
    $ch->izquierda("VENTAS POR TASA")."\r\n";

    // Iterar sobre las ventas por tasa
        
    if( count($datos_corte['impuestos_agrupados'])>0){

        foreach ($datos_corte['impuestos_agrupados'] as $key => $value) {
            $contenido_corte .= 
             $ch->izquierdaFix(strval(number_format(floatval($value['porcentaje'])*100,0))."%",18)
            .$ch->derechaFix(strval(number_format($value['totalNeto'],2, '.', '')), 10)
            .$ch->derechaFix(strval(number_format($value['totalImpuesto'],2, '.', '')), 10)."\r\n";
        }
    }
    else{
        $contenido_corte .= "No existen Ventas \r\n";
    }    

    $contenido_corte .= "\r\n";
    $contenido_corte .= "--------------------------------------"."\r\n";

    // Iterar sobre las decoluciones por tasa
    $contenido_corte .= $ch->izquierda("DEVOLUCIONES POR TASA")."\r\n";

    if(in_array('devoluciones_agrupados', $datos_corte)){
        if(count($datos_corte['devoluciones_agrupados'])>0){
            foreach ($datos_corte['devoluciones_agrupados'] as $key => $value) {
                    $contenido_corte .= 
                     $ch->izquierdaFix(strval(number_format(floatval($value['porcentaje'])*100,0))."%",18)
                    .$ch->derechaFix(strval(number_format($value['totalNeto'],2, '.', '')), 10)
                    .$ch->derechaFix(strval(number_format($value['totalImpuesto'],2, '.', '')), 10)."\r\n";
                }
        }
        else{
            $contenido_corte .= "No existen Devoluciones \r\n";
        }

    }    
    else{
        $contenido_corte .= "No existen Devoluciones \r\n";
    }
    

    /* Abrir la conexion a la impresora */
    $impresora = printer_open(constant('IMPRESORA'));
    
    header('Content-type: application/json');

    /* Mandar el texto a imprimir al print JOB */            
    if(printer_write($impresora, $contenido_corte)){        

        echo json_encode(array('message'=>$message,'data'=>$datos_corte,'status'=> $code_ok));
    }
    else{    

        echo json_encode(array('message'=>$message_error,array(),'status'=> $code_error));    

    }

    /* Cerrar Conexion */
    printer_close($impresora);

 }
 
?>
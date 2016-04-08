 <?php
 /**
 * Author: Ivan Eusebio
 * Date:   21/10/2015
 * 
 */
 include('cadenashelper.php');

 include('config.php');

 // Se se especificaron los datos desde el punto de Venta
 if(isset($_POST)){

    $ch = new CadenasHelper();

    $message = 'Se imprimio el Ticket'; 

 	$message_error = 'Ocurrio un error al imprimir el Ticket'; 

    $code_ok = 200;

 	$code_error = 500;

    $datos_ticket = $_POST;    
    
    //Armar cabecera del Ticket
    $contenido_ticket = 
    $ch->centrar($datos_ticket['empresa_nombre'])."\r\n".
    $ch->centrar("RFC: ".$datos_ticket['empresa_rfc'])."\r\n".
    $ch->centrar($datos_ticket['empresa_calle']." ".$datos_ticket['empresa_numero'])."\r\n".
    $ch->centrar($datos_ticket['empresa_colonia']." ".$datos_ticket['empresa_cp'])."\r\n".
    $ch->centrar($datos_ticket['empresa_ciudad']." ".$datos_ticket['empresa_estado']." ".$datos_ticket['empresa_pais'])."\r\n".
    $ch->centrar("EXPEDIDO EL: ".$datos_ticket['ov_fecha'])."\r\n".
    $ch->centrar("EN: ".$datos_ticket['sucursal_calle']." ".$datos_ticket['sucursal_numero']." ".$datos_ticket['sucursal_colonia'])."\r\n"."\r\n".
    $ch->centrar("PUNTO DE VENTA")."\r\n"."\r\n".
    "Nota de Venta: ".$datos_ticket['ov_codigo']."\r\n"."\r\n".
    "--------------------------------------"."\r\n".
    "Descripcion        Cant. Pr.Un. Importe"."\r\n".
    "--------------------------------------"."\r\n";

    // Iterar sobre los productos de la venta

    foreach ($datos_ticket['productos'] as $key => $value) {
        $contenido_ticket .= 
         $ch->izquierdaFix(substr($value['art_nombre'],0,18),18)
        .$ch->derechaFix(strval(number_format($value['cantidad'],2, '.', '')), 6)
        .$ch->derechaFix(strval(number_format($value['precio'],2, '.', '')), 7)
        .$ch->derechaFix(strval(number_format($value['total'],2, '.', '')), 8)."\r\n";
    }

    $contenido_ticket .= "\r\n";
    // Separador
    $contenido_ticket .= $ch->derecha("======")."\r\n";
    $contenido_ticket .= $ch->derecha(strval(number_format($datos_ticket['productos_total'],2, '.', '')))."\r\n";
    // Total en Letra
    $contenido_ticket .= $ch->izquierda("(".$datos_ticket['productos_total_letra'].")")."\r\n";

    $contenido_ticket .= "                  Impuestos: ".$ch->derechaFix("0.00",10)."\r\n";
    $contenido_ticket .= "                 Ud. ahorro: ".$ch->derechaFix("0.00",10)."\r\n"."\r\n";

    if($datos_ticket['pago_efectivo']!=0){

        $contenido_ticket .= "Pago Efectivo:".$ch->derechaFix(strval(number_format($datos_ticket['pago_efectivo'],2, '.', '')),25)."\r\n";
    }
    if($datos_ticket['pago_tarjeta']!=0){
            
        $contenido_ticket .= "Pago Tarjeta Credito:".$ch->derechaFix(strval(number_format($datos_ticket['pago_tarjeta'],2, '.', '')),18)."\r\n";
    }
    // Division
    $contenido_ticket .= $ch->derecha("======")."\r\n";
    // Pago y     // Total de los productos

    $contenido_ticket .= "Total Pago:".$ch->derechaFix(strval(number_format($datos_ticket['total_pago'],2, '.', '')),28)."\r\n";
    $contenido_ticket .= "Cambio:".$ch->derechaFix(strval(number_format($datos_ticket['cambio'],2, '.', '')),32)."\r\n";
    $contenido_ticket .= "Total de Articulos: ".$ch->izquierda(strval(number_format($datos_ticket['total_articulos'],2, '.', '')))."\r\n";
    $contenido_ticket .= "Cajero: ".$ch->izquierda($datos_ticket['usuario'])."\r\n"."\r\n";
    // Pie de Tickect
    $contenido_ticket .= "**************************************"."\r\n"."*".$ch->centrarFix("GRACIAS POR SU PREFERENCIA",37)."*"."\r\n"
    ."*".$ch->centrarFix("FUE UN PLACER ATENDERLE",37)."*"."\r\n"."**************************************";    


    /* Abrir la conexion a la impresora */
    $impresora = printer_open(constant('IMPRESORA'));
    
    header('Content-type: application/json');

    /* Mandar el texto a imprimir al print JOB */            
    if(printer_write($impresora, $contenido_ticket)){            

        echo json_encode(array('message'=>$message,'data'=>$contenido_ticket,'status'=> $code_ok));
    }
    else{    

        echo json_encode(array('message'=>$message_error,array(),'status'=> $code_error));    

    }

    /* Cerrar Conexion */
    printer_close($impresora);

 }
 
?>
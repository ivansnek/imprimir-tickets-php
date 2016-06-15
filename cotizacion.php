<?php
/**
 * Author: Ivan Eusebio
 * Date:   28/04/2016
 *
 */

include('config.php');

// Se se especificaron los datos desde el punto de Venta
if(isset($_POST)){

    $message = 'Se imprimio la Cotizacion';

    $message_error = 'Ocurrio un error al imprimir la Cotizacion';

    $code_ok = 200;

    $code_error = 500;

    $datos_cotizacion = $_POST;

    $contenido_cotizacion = '';

    for ($fila = 0; $fila < count($datos_cotizacion); $fila ++) {
        $contenido_cotizacion .= $datos_cotizacion[$fila]."\r\n";
    }

    /* Abrir la conexion a la impresora */
    $impresora = printer_open(constant('IMPRESORA'));

    header('Content-type: application/json');

    /* Mandar el texto a imprimir al print JOB */
    if(printer_write($impresora, $contenido_cotizacion)){
        echo json_encode(array('message'=>$message,'data'=>$contenido_cotizacion,'status'=> $code_ok));
    }
    else{
        echo json_encode(array('message'=>$message_error,'data'=>array(),'status'=> $code_error));
    }

    /* Cerrar Conexion */
    printer_close($impresora);

}

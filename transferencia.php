<?php
/**
 * Author: Ivan Eusebio
 * Date:   08/04/2016
 *
 */

include('config.php');

// Se se especificaron los datos desde el punto de Venta
if(isset($_POST)){

    $message = 'Se imprimieron las Transferencias';

    $message_error = 'Ocurrio un error al imprimir las Transferencias';

    $code_ok = 200;

    $code_error = 500;

    $datos_transferencias = $_POST;

    $contenido_transferencia = '';

    for ($fila = 0; $fila < count($datos_transferencias); $fila ++) {
        $contenido_transferencia .= $datos_transferencias[$fila]."\r\n";
    }

    /* Abrir la conexion a la impresora */
    $impresora = printer_open(constant('IMPRESORA'));

    header('Content-type: application/json');

    /* Mandar el texto a imprimir al print JOB */
    if(printer_write($impresora, $contenido_transferencia)){
        echo json_encode(array('message'=>$message,'data'=>$contenido_transferencia,'status'=> $code_ok));
    }
    else{
        echo json_encode(array('message'=>$message_error,'data'=>array(),'status'=> $code_error));
    }

    /* Cerrar Conexion */
    printer_close($impresora);

}

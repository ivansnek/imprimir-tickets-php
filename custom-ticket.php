<?php
/**
 * Author: Ivan Eusebio
 * Date:   08/04/2016
 *
 */

include('config.php');

// Se se especificaron los datos desde el punto de Venta
if(isset($_POST)){

    $message = 'Se imprimio el Ticket';

    $message_error = 'Ocurrio un error al imprimir el Ticket';

    $code_ok = 200;

    $code_error = 500;

    $datos = $_POST;

    $contenido_ticket = '';

    for ($fila = 0; $fila < count($datos); $fila ++) {
        $contenido_ticket .= $datos[$fila]."\r\n";
    }

    /* Abrir la conexion a la impresora */
    $impresora = printer_open(constant('IMPRESORA'));

    header('Content-type: application/json');

    /* Mandar el texto a imprimir al print JOB */
    if(printer_write($impresora, $contenido_ticket)){
        echo json_encode([ 
            'message' => $message,
            'data' => $contenido_ticket,
            'status' => $code_ok
        ]);
    }
    else{
        echo json_encode([
            'message' => $message_error,
            'data' => [] ,
            'status' => $code_error 
        ]);
    }

    /* Cerrar Conexion */
    printer_close($impresora);

}

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

    $contenido_corte = '';
    
    for ($fila = 0; $fila < count($datos_corte); $fila ++) {
      $contenido_corte .= $datos_corte[$fila]."\r\n";
      if(strpos($datos_corte[$fila],'Recoleccion') !==false || strpos($datos_corte[$fila],'Entrega')!==false || strpos($datos_corte[$fila],'Recibio')!==false) {
        $contenido_corte .= "\r\n";
      }
    }

    /* Abrir la conexion a la impresora */
    $impresora = printer_open(constant('IMPRESORA'));

    header('Content-type: application/json');

    /* Mandar el texto a imprimir al print JOB */
    if(printer_write($impresora, $contenido_corte)){

        echo json_encode(array('message'=>$message,'data'=>$contenido_corte,'status'=> $code_ok));
    }
    else{

        echo json_encode(array('message'=>$message_error,'data'=>array(),'status'=> $code_error));

    }

    /* Cerrar Conexion */
    printer_close($impresora);

 }

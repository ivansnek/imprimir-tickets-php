<?php

	/**Nombre del equipo en red en donde esta la computadora por default es nulo*/
	define('EQUIPO', ""); // EDITAR AL INSTALAR

 	/** Nombre de la Impresora, puede indicarse el nombre de red, si es que esta compartida.*/
 	define('NOMBRE_IMPRESORA', "Generic / Text Only"); // EDITAR AL INSTALAR

 	/**Ruta final de la impresora*/
 	define('IMPRESORA' ,(strval(constant('EQUIPO')).strval(constant('NOMBRE_IMPRESORA'))));
?>
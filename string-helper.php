<?php
	/**
	* Clase auxiliar para el manejo de las cadenas que son enviadas a imprimir en el ticket/corte	
	*/	
	class StringHelper {

		/*Numero maximo de caracteres en cada linea para el Ticket*/
		public $MAX_CARACTERES = 39;
		
		/*
		 * Devuelve una cadena con el texto centrado, 
		 * teniendo un maximo de caracteres especificados por $MAX_CARACTERES
		 *
		 * @param $cadena string
		 * @return string
		 */
    	public function centrar($cadena){
        	return str_pad($cadena, $this->MAX_CARACTERES, " ", STR_PAD_BOTH);
     	}

     	/*
		 * Devuelve una cadena con el texto centrado, 
		 * teniendo un maximo de caracteres especificados por $MAX_CARACTERES
		 *
		 * @param $numeroCaracteres int
		 * @param $cadena string
		 * @return string
		 */
    	public function centrarFix($cadena, $numeroCaracteres){
        	return str_pad($cadena, $numeroCaracteres, " " , STR_PAD_BOTH);
     	}

     	/*
		 * Devuelve una cadena con el texto cargada a la derecha, 
		 * teniendo un maximo de caracteres especificados por $MAX_CARACTERES

		 * @param $cadena string
		 * @return string
		 */
     	public function derecha($cadena){
        	return str_pad($cadena, $this->MAX_CARACTERES, " ", STR_PAD_LEFT);
     	}

     	/*
		 * Devuelve una cadena con el texto cargada a la derecha , 
		 * teniendo un maximo de caracteres especificados por $numeroCaracteres
		 *
		 * @param $cadena string
		 * @param $numeroCaracteres int
		 * @return string
		 */
     	public function derechaFix($cadena, $numeroCaracteres){
        	return str_pad($cadena, $numeroCaracteres, " " , STR_PAD_LEFT);
     	}

     	/*
		 * Devuelve una cadena con el texto cargada a la izquierda, 
		 * teniendo un maximo de caracteres especificados por $MAX_CARACTERES
		 *
		 * @param $cadena string
		 * @return string
		 */
     	public function izquierda($cadena){
        	return str_pad($cadena, $this->MAX_CARACTERES, " ", STR_PAD_RIGHT);
     	}

     	/*
		 * Devuelve una cadena con el texto cargada a la izquierda, 
		 * teniendo un maximo de caracteres especificados por $numeroCaracteres
		 *
		 * @param $cadena string
		 * @param $numeroCaracteres
		 * @return string
		 */
     	public function izquierdaFix($cadena, $numeroCaracteres){
        	return str_pad($cadena, $numeroCaracteres, " ", STR_PAD_RIGHT);
     	}
 }

?>
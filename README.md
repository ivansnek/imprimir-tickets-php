# imprimir-tickets-php

Este es un pequeño servidor de impresión de tickets hecho con PHP, usando la extensión http://php.net/manual/fa/book.printer.php.

Pasos para configurar:

1.- Tener un servidor con PHP, por ejemplo XAMPP o LAMPP

2.- Dependiendo de la versión de tu servidor PHP debes instalar la extension `php_printer` (Se descargan los archivos .dll y se trasladan a la carpeta /ext de tu instalación de PHP:
  http://windows.php.net/downloads/pecl/snaps/printer/0.1.0-dev/

3.- Dentro dentro de tu directorio publico del servidor por ejemplo: `/www`, pegar la carpeta del proyecto.

4.- Tener por lo menos una impresora de ticktes instalada, antes de ejecutar asegurarse de editar el archivo `config.php`, para que los datos locales de la impresora correspondan a los de la configuración.

5.- Tener siempre ejecutando el servidor, y asegurarse que la configuración del servidor local (XAMPP) no este direcionada a la carpeta raiz de alguna otra aplicación, o en el caso de que se desee que esa sea la unica aplicación en ejecución en este servidor, así se puede hacer.

6.- Ahora para mandar a imprimir se necesita mandar un request al servidor tipo **POST** con los datos que se deseen imprimir al ticket.
 Cabe aclarar que existen dos rutas posibles para hacer esto:
 
 a) `http://localhost/imprimir-tickets-php/ticket.php` : Esta ruta recibe parametros personalizados y contiene una estructura pre-definida para el ticket, esta fue la primera versión y el contenido es estatico, solo se cambia la información de cada ticket. Si se desea usar esta ruta, se debe ajustar a los datos y parametros de su aplciación.
 
 b) `http://localhost/imprimir-tickets-php/custom-ticket.php`: Esta ruta es personalizada y no tiene una estructura estatica, pero contrario a esto necesita recibir como parametros las lineas formateadas (espacios, tabs, caracteres) de cada una de las lineas que se desean imprimir, esto se logro usando un **store procedure** de MYSQL que regresaba el conenido del ticket como texto formateado.
 
 NOTA: Las rutas mostradas anteriormente dependeran mucho de su configuración local y del nombre de sus carpetas, asegurese de usar sus propios datos.
 
 Cabe destacar que esta aplicación no fue diseñada para adecuarse a cualquier tipo de implementación, necesita reciibr explicitamente los datos para imprimir y solo sirve como enlace para enviar los datos directamente a una impresora. Sientase libre de modificarla a su conveniencia y requerimientos propios.


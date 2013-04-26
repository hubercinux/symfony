Instalación Symfony 
========================

1. Crear la carpeta /var/www/miproyecto ejeacutar todo desde la raiz del proyecto

2. Ingresar a la carpeta creada

3. Clonar el proyecto
    
    $ git clone https://github.com/hubercinux/symfony.git

    Ingresar a la carpeta symfony

4. Instalar curl:
    
    $ sudo apt-get install curl

5. Instalar composer

    $ curl -s https://getcomposer.org/installer | php

6. Verificar que composer se haya instalado correctamente

    $ php composer.phar

7. Mover composer:

    $ sudo mv composer.phar /usr/local/bin/composer

8. Actualizar composer:

    $ sudo composer self-update

9. Descargar symfony y sus vendors:

    $ composer update

10. Tendremos symfony listo para poder probar nuestro proyecto

11. Para subir cambios hechos en los archivos de symfony hacer:
    
    $ git add .

    $ git commit -m "actualizando"

    $ git git push origin master


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## About stock-app-api

es una aplicación hecha con el Framework Laravel destinada a ofrecer una API que permita registrar y consultar el stockde productos y sus respectivos movimientos.

## Requirements
- Disponer de Docker/Docker Desktop.

## Setup proyecto

- Clonar el proyecto: ```git clone https://github.com/juanr10/stock-app-api.git```
- Nos movemos a la carpeta del proyecto y pasamos a instalar las respectivas dependencias del proyecto usando la imagen de laravelsail/composer (para poder inicializar laravel sail):
    ```bash
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v $(pwd):/var/www/html \
        -w /var/www/html \
        laravelsail/php81-composer:latest \
        composer install --ignore-platform-reqs 
    ```
- Inicializamos el proyecto ejecutando (para este caso y para facilitar el setup se ha añadido el .env): ```./vendor/bin/sail up -d``` 
- Corremos las migraciones y seeders del proyecto:  ```./vendor/bin/sail artisan migrate --seed``` 
- Corremos los tests del proyecto:  ```./vendor/bin/sail artisan test``` 

Notas:
- Acceso BD 
    -  host: mysql
    -  port: 3306
    -  db: stock_app_api
    -  usuario: sail | contraseña: password

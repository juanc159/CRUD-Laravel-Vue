//PROYECTO AGENDA DE CONTACTOS CON VUE Y LARAVEL

1. autenticacion de usuario con UI
    composer require laravel/ui
    php artisan ui vue --auth

2. creamos el modelo, migracion, factory y controlador con recursos api de CONTACT 
    php artisan make:model Contact -mfr --api

3. modificamos la tabla CONTACT y se creo su fabrica
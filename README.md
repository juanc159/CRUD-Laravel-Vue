# PROYECTO AGENDA DE CONTACTOS CON VUE Y LARAVEL
_proyecto elaborado con Laravel y Vue, con integracion de Datatable_

## 1. autenticacion de usuario con UI
    ```
    composer require laravel/ui
    php artisan ui vue --auth 
    ```

## 2. creamos el modelo, migracion, factory y controlador con recursos api de CONTACT 
    ```
    php artisan make:model Contact -mfr --api
    ```

## 3. modificamos la tabla CONTACT y se creo su fabrica

## 4. modificamos el modelo contact y el controlador.

# 5. agregar DATATABLE a laravel con vue:

### a. Forma con NPM: [video youtube](https://www.youtube.com/watch?v=P1Ci-dY9Hes&t=60s)
_1) ir a la pagina de_ [Datatable](https://datatables.net/download/)
    _2) escoger el paquete de bootstrap 4 y los botones_
    _3)en CDN quitar el minificado_
    _4) copiar los comandos que estan en el NPM_
            ```
            npm install --save jszip
            npm install --save pdfmake
            npm install --save datatables.net-bs4
            npm install --save datatables.net-buttons-bs4
            ```
    _5) requerir los paquetes instalados_
        _5.1) importar en el componente en que es necesario el datatable_
                ```
                import datatable from 'datatables.net-bs4'
                ```
        _5.2) en el archivo global app.js de los componentes de vue solo si los requiere en todas las vistas pero como lo vamos a requeriri en una sola (EN ESTE CASO) lo importamos en el componente_
                    ```
                    require( 'jszip' );
                    require( 'pdfmake' );
                    require( 'datatables.net-bs4' )(); 
                    require( 'datatables.net-buttons-bs4' )();
                    require( 'datatables.net-buttons/js/buttons.colVis.js' )();
                    require( 'datatables.net-buttons/js/buttons.html5.js' )();
                    require( 'datatables.net-buttons/js/buttons.print.js' )();
                    ```
        _6) solo para listar sin botones:_
            _6.1) en la tabla en el elemento tbody no agregar td ni tr dentro_
            _6.2) agregar o modificar el metodo donde se listan los registros_
                ```
                list(){
                    axios.get('contacts').then(res=>{
                        $('#tabla_contacts').DataTable({
                            data: res.data,
                            columns: [
                                    {data: 'id'},
                                    {data: 'first_name'},
                                    {data: 'last_name'},
                                    {data: 'email'},
                                    {data: 'phone'},
                                    {data: 'address'}
                                ]
                        });
                    });
                    //this.contactos = res.data;
                }
                ```
        _7) PARA LISTAR CON BOTONES:_
            _7.1) en la tabla en el elemento tbody, se debe usar tr y td con el v-for de vue para recorer los registros de la lista_
            _7.2) se agregan estos dos metodos son mas cortos y mas entendibles_
                ```
                mytable(){
                this.$nextTick(()=>{
                    $('#tabla_contacts').DataTable();
                });
                },
                list(){
                    axios.get('contacts').then(res=>{
                        this.contactos = res.data;
                    });
                },
                ```


            




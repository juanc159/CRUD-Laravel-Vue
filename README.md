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
1. ir a la pagina de [Datatable](https://datatables.net/download/)
2. escoger el paquete de bootstrap 4 y los botones
3. en CDN quitar el minificado
4. copiar los comandos que estan en el NPM

```
npm install --save jszip
npm install --save pdfmake
npm install --save datatables.net-bs4
npm install --save datatables.net-buttons-bs4
```

5. requerir los paquetes instalados
* importar en el componente en que es necesario el datatable

```
import datatable from 'datatables.net-bs4'
```

* en el archivo global app.js de los componentes de vue solo si los requiere en todas las vistas pero como lo vamos a requeriri en una sola (EN ESTE CASO) lo importamos en el componente

```
require( 'jszip' );
require( 'pdfmake' );
require( 'datatables.net-bs4' )(); 
require( 'datatables.net-buttons-bs4' )();
require( 'datatables.net-buttons/js/buttons.colVis.js' )();
require( 'datatables.net-buttons/js/buttons.html5.js' )();
require( 'datatables.net-buttons/js/buttons.print.js' )();
```

6. solo para listar sin botones:
* en la tabla en el elemento tbody no agregar td ni tr dentro
* agregar o modificar el metodo donde se listan los registros

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

7. PARA LISTAR CON BOTONES:
* en la tabla en el elemento tbody, se debe usar tr y td con el v-for de vue para recorer los registros de la lista
* se agregan estos dos metodos son mas cortos y mas entendibles
* IMPORTANTE!!! si no funciona siguiendo estos pasos, debe revisar la tabla, puede que la cantidad de columnas en "thead" no sea igual a "tbody"

```
                mytable(){
                this.$nextTick(()=>{
                    $('#tabla_contacts').DataTable();
                })
                },
                list(){
                    axios.get('contacts').then(res=>{
                        this.contactos = res.data;
                        this.mytable();
                    });
                },
```

8. BOTONES ESPECIALES (COPY, PDF)
* Se debe modificar la parte de las importaciones de l siguiente manera
```
//PARA REUQERIR LOS BOTONES ESPECIALES
require( 'datatables.net-buttons/js/dataTables.buttons' );
require( 'datatables.net-buttons/js/buttons.html5' );

//PARA IMPORTAR EL DATATABLE
import datatable from 'datatables.net-bs4'
//PARA IMPORTAR LOS BOTONES ESPECILES
import print from 'datatables.net-buttons/js/buttons.print'
import jszip from 'jszip/dist/jszip'
import pdfMake from 'pdfmake/build/pdfmake'
import pdfFonts from 'pdfmake/build/vfs_fonts'
pdfMake.vfs = pdfFonts.pdfMake.vfs; //esto es para que funcione el boton PDF
window.JSZip = jszip; //esta linea es para que muestre y fucione el boton EXCEL
```
* Se agrega lo siguiente en (resource/sass/app.scss) para que muestre los mensajes en las acciones de los botones.
```
@import '~datatables.net-buttons-bs4/css/buttons.bootstrap4';
```
* para arreglar y dise;ar los botones ver el componente contacto.vue

            




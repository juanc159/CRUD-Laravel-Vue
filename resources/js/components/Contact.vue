<template>
    <div>
        <h1 class="text-center">Agenda de Contactos</h1>
        <hr>
        <!-- Button trigger modal -->
        <button  type="button" class="btn btn-primary mb-3" @click="update = false; open_modal()">
        Agregar
        </button>

        <!-- Modal -->
        <div class="modal " :class="{show:form_modal}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{tilte_modal}}</h5>
                    <button type="button" class="close" @click="close_modal()">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                        
                        <div class="form-group">
                            <label for="first_name">Nombres</label>
                            <input type="text" v-model="contact.first_name" class="form-control" id="first_name" placeholder="Nombres">
                            <small ></small>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Apellidos</label>
                            <input type="text" v-model="contact.last_name" class="form-control" id="last_name" placeholder="Apellidos">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" v-model="contact.email" class="form-control" id="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="phone">Telefono</label>
                            <input type="text" v-model="contact.phone" class="form-control" id="phone" placeholder="Telefono">
                        </div>
                        <div class="form-group">
                            <label for="address">Direccion</label>
                            <input type="text" v-model="contact.address" class="form-control" id="address" placeholder="Direccion">
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="close_modal()">Cerrar</button>
                    <button type="button" @click="save();" class="btn btn-success">Guardar Cambios</button>
                </div>
                </div>
            </div>
        </div>

        <table id="tabla_contacts" class="table table-striped table-hover table-bordered text-center" style="width:100%">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Email</th>
                    <th scope="col">Telefono</th>
                    <th scope="col">Direccion</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="contact in contactos" :key="contact.id">
                    <th scope="row">{{contact.id}}</th>
                    <td>{{contact.first_name}}</td>
                    <td>{{contact.last_name}}</td>
                    <td>{{contact.email}}</td>
                    <td>{{contact.phone}}</td>
                    <td>{{contact.address}}</td>
                    <td>
                        <button class="btn btn-warning"   @click="update = true; open_modal(contact)">Editar</button>
                        <button class="btn btn-danger" @click='eliminar(contact.id)'>Eliminar</button>
                    </td>
                </tr>
            </tbody>
            </table>
    </div>
</template>


<script>
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

    export default {
        data(){
            return{
                contactos: [],
                form_modal: false,
                tilte_modal:'',
                update : true,
                id : 0,
                contact: {
                    first_name : '',
                    last_name : '',
                    email : '',
                    phone : '',
                    address : ''
                }
            }
        },
        mounted() {
            this.list();
            
        },
        methods: {
            //METODO PARA LISTAR CON BOTONES
             mytable(){
                this.$nextTick(()=>{
                    $('#tabla_contacts').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                //Botón para COPY
                                'extend': 'copyHtml5',
                                'titleAttr': 'Copiar',
                                'className': 'btn btn-secondary',
                                'text': 'Copiar'
                            },
                            {
                                //Botón para Excel
                                'extend': 'excelHtml5',
                                'titleAttr': 'Excel',
                                'className': 'btn btn-success',
                                'text': '<i class="fas fa-file-excel"></i> Excel',
                                'filename': 'Listado Contactos'
                            },
                            //Botón para PDF
                            {
                                'extend': 'pdfHtml5',
                                'titleAttr': 'Pdf',
                                'className': 'btn btn-danger',
                                'text': '<i class="fas fa-file-pdf"></i> PDF',
                                'filename': 'Listado Contactos'
                            },
                            //Botón para CSV
                            {
                                'extend': 'csvHtml5',
                                'titleAttr': 'Csv',
                                'className': 'btn btn-info',
                                'text': '<i class="fas fa-file-csv"></i> Csv',
                                'filename': 'Listado Contactos'
                            },
                            //IMPRIMIR
                            {
                                'extend': 'print',
                                'titleAttr': 'Imprimir',
                                'className': 'btn btn-dark',
                                'text': 'Imprimir',
                                'autoPrint': false
                            }
                        ]
                    });
                })
            },
            list(){
                axios.get('contacts').then(res=>{
                    this.contactos = res.data;
                    this.mytable();
                });
            },
            //metodo para listar SIN BOTONES
            /*
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
            },*/
            async eliminar (id){
                const res = await axios.delete('contacts/'+id);
                this.list();
            },
            async save(){
                if(this.update){
                    const res = await axios.put('/contacts/'+this.id,this.contact);
                }else{
                    //console.log(this.contact);
                    const res = await axios.post('/contacts',this.contact);
                    
                }
                this.close_modal();
                this.list();
            },
            async open_modal(data){
                if(this.update){
                    this.tilte_modal='MODIFICAR CONTACTO ' +data.id;
                    this.id = data.id;
                    this.contact.first_name = data.first_name;
                    this.contact.last_name = data.last_name;
                    this.contact.email = data.email;
                    this.contact.phone = data.phone;
                    this.contact.address = data.address;
                    //console.log(this.contact);
                    
                }
                else{
                    this.tilte_modal='CREAR CONTACTO';
                    this.id = 0;
                    this.contact.first_name = '';
                    this.contact.last_name = '';
                    this.contact.email = '';
                    this.contact.phone = '';
                    this.contact.address = '';
                }
                this.form_modal = true;
                
            },
            async close_modal(){
                this.form_modal = false;
            },
        }
    }

    
</script>

<style>
.show{
    display: list-item;
    opacity:  1;
    background: rgba(44,38,75,0.5);
}
</style>
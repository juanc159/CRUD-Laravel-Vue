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

        <table id="tabla_contacts" class="table table-striped table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Email</th>
                    <th scope="col">Telefono</th>
                    <th scope="col">Direccion</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            </table>
    </div>
</template>


<script>
import datatable from 'datatables.net-bs4'
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
            //async mytable(){
            //    this.$nextTick(()=>{
            //        $('#tabla_contacts').DataTable();
            //    });
            //},
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
            },
            async eliminar (id){
                const res = await axios.delete('contacts/'+id);
                this.list();
            },
            async save(){
                if(this.update){
                    
                    const res = await axios.put('/contacts/'+this.id,this.contact);
                    console.log(res);
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
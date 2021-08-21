<template>
    <div class="mt-3 col-12">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h3 float-left">Adminstracion de Usuarios</h3>
                        <button type="button" class="btn btn-success btn-sm float-right"  @click="openModal">Agregar <i class="fas fa-plus"></i></button>
                    </div>
                    <div class="card-body ">
                        <div class="row p-3"> 
                            <div class="col-4 pt-2">
                                <b-form-group
                                    label="Por pagina"
                                    label-cols-sm="6"
                                    label-cols-md="3"
                                    label-cols-lg="3"
                                    label-size="sm"
                                    label-for="perPageSelect"
                                    class="mb-0"
                                    >
                                    <b-form-select class="col-3"
                                        v-model="perPage"
                                        id="perPageSelect"
                                        size="sm"
                                        :options="pageOptions"
                                    ></b-form-select>
                                </b-form-group>
                            </div>     
                            <div class="col-4"></div>
                            <div class="col-4 d-flex flex-row-reverse">
                                <div class="input-group col-8 pr-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text"  class="form-control"  
                                        @input="getUsers()" v-model="search"
                                        placeholder="Filtrar" aria-label="Filtrar" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <b-table class="col-12"
                            bordered
                            striped
                            small
                            responsive 
                            :current-page="currentPage"
                            :per-page="perPage"
                            :items="items"
                            :fields="fields"
                            :sort-by.sync="sortBy"
                            :sort-desc.sync="sortDesc"
                            sort-icon-left
                            responsive="sm">
                            <template v-slot:table-colgroup="scope">
                            
                                <col
                                v-for="field in scope.fields"
                                :key="field.key"
                                :style="{ width: field.key === 'accion' ? '180px' : '' || field.key === 'activo' ? '70px' : ''  || field.key === 'valor' ? '150px' : '' }"
                                >
                            </template>

                            <template v-slot:cell(accion)="row">
                                <b-button size="sm" variant="warning" @click="editModal(row.item)">
                                    <i class="fas fa-edit"></i>
                                </b-button>
                                <b-button size="sm" variant="secondary" @click="openChange(row.item.key_id)" >
                                    <i class="fas fa-lock"></i>
                                </b-button>
                                <b-button size="sm" variant="danger" @click="deleteUser(row.item.key_id)" >
                                    <i class="fas fa-trash"></i>
                                </b-button>
                            </template>
                        
                        </b-table>
                        <div class="row pl-3 pr-3">
                            <div class="col-3">
                                <b-pagination
                                    v-model="currentPage"
                                    :total-rows="totalRows"
                                    :per-page="perPage"
                                    align="fill"
                                    size="sm"
                                    class="my-0"
                                ></b-pagination>
                            </div>
                            <div class="col-5"></div>
                            <div class="col-4 text-right">
                                Organizado por: <b>{{ sortBy }}</b>, Orden:
                                <b>{{ sortDesc ? 'Descendente' : 'Ascendente' }}</b>
                            </div>
                        </div>
                        

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-lg" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editMode" id="createModalLabel">Crear Usuario</h5>
                        <h5 class="modal-title" v-show="editMode" id="createModalLabel">Actualizar Usuario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode === true ? updateUser() : createUser()">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Nombre</label>
                                    <input v-model="form.name" type="text" name="name"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                                <div class="form-group col-6">
                                    <label>Email</label>
                                    <input v-model="form.email" type="text" name="email"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                    <has-error :form="form" field="email"></has-error>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div v-if="!editMode" class="form-group col-4">
                                    <label>Contraseña</label>
                                    <input v-model="form.password" type="password" name="password"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                    <has-error :form="form" field="password"></has-error>
                                </div>
                                <div class="form-group col-4">
                                    <label>Username</label>
                                    <input v-model="form.username" type="text" name="username"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('username') }">
                                    <has-error :form="form" field="username"></has-error>
                                </div>
                                <div class="col-4 d-flex pt-3">
                                    <b-form-checkbox
                                        id="is_admin"
                                        v-model="form.is_admin"
                                        name="is_admin"
                                        value="si"
                                        unchecked-value="no"
                                        class="align-self-center"

                                        :class="{ 'is-invalid': form.errors.has('is') }"
                                        >
                                        Es Admin
                                    </b-form-checkbox>
                                    <has-error :form="form" field="is_admin"></has-error>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button v-show="editMode" type="submit" class="btn btn-warning">Actualizar</button>
                            <button v-show="!editMode" type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

         <div class="modal fade bd-example-modal-sm" id="changePwd" tabindex="-1" role="dialog" aria-labelledby="changePwdLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changePwdLabel">Cambiar Contraseña</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>                   
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-12">
                                <label>Nueva Contraseña</label>
                                <input v-model="newPass" min="6" type="password" name="password"  class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" @click="changePassword()" class="btn btn-success">Cambiar</button>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
            this.getUsers();
            Fire.$on('AfterEvent',()=>{
                this.getUsers();
            });
        },
        data() {
            return {
                pageOptions: [10, 25, 50, 100],
                currentPage: 1,
                perPage: 10,
                sortBy: 'Nombre',
                sortDesc: false,
                fields: [
                    { key: 'name', label:'Nombre', sortable: true },
                    { key: 'username', label:'Usuario', sortable: true },
                    { key: 'email', sortable: true , class: ''},
                    { key: 'is_admin',label:'Administrador', sortable: true, class: 'text-center' },
                    { key: 'accion', class: 'text-center'}
                ],
                items: [],
                totalRows:0,
                editMode: false,                
                search: '',
                form: new Form({
                    id: 0,
                    name: '',
                    email: '',
                    password: '',
                    username: '',
                    is_admin: 'no',
                    key_id: ''
                }),

                newPass: '',
                userKey: ''
            }
        },
        methods:{
            getUsers(url = base_url + '/api/usuario/'){
                axios.get(url, {params: {search:this.search}})
                .then(response => {
                    let data =  response.data;
                    this.items = data;
                    this.totalRows = data.length
                })
                .catch(errors => {
                    console.log(errors);
                });
            },
            openModal(){
                this.editMode = false;
                this.form.reset();
                $('#createModal').modal('show');
            },
            openChange(key){
                this.userKey = key;
                $('#changePwd').modal('show');
            },
            changePassword(){    

                let fData = new FormData();

                fData.append('key_id',  this.userKey);
                fData.append('password',  this.newPass);

                axios.post(base_url +'/api/usuario/change-pwd',fData,{
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(()=>{                                   
                    $('#changePwd').modal('hide');
                    this.userKey = '';
                    this.newPass = '';
                    toast.fire({
                        icon: 'success',
                        title: 'La contraseña ha sido modificada'
                    });                  
                })
                .catch(()=>{
                    swal.fire('Error!','Hubo un error','error');
                });
            },
            createUser(){          
                this.$Progress.start();  
                this.form.post('api/usuario')
                .then(()=>{            
                    Fire.$emit('AfterEvent');                           
                    $('#createModal').modal('hide');
                    toast.fire({
                        icon: 'success',
                        title: 'EL usuario ha sido creado.'
                    }); 
                    this.$Progress.finish();                   
                })
                .catch(()=>{
                    swal.fire('Error!','Hubo un error','error');
                });
            },
            editModal(supplier){               
                this.form.reset();
                this.editMode = true,                
                $('#createModal').modal('show');
                this.form.fill(supplier);
            },
            updateUser(){
                this.$Progress.start();
                this.form.put('api/usuario/'+this.form.key_id)
                .then(()=>{
                    $('#createModal').modal('hide');
                    swal.fire(
                        'Actualizado!',
                        'EL usuario ha sido actualizado',
                        'success'
                    );
                    this.$Progress.finish();
                    Fire.$emit('AfterEvent'); 
                    
                })
                .catch(()=>{
                    this.$Progress.fail();
                })
            },
            deleteUser(key_id){
                swal.fire({
                    title: 'Estas seguro?',
                    text: "No Podras Revertir Esta accion!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminalo!'
                }).then((result) => {
                    if (result.value) { 
                        this.form.delete('api/usuario/'+key_id).then(()=>{ 
                            swal.fire(
                                'Eliminado!',
                                'EL usuario ha sido eliminado.',
                                'success'
                            );
                            Fire.$emit('AfterEvent');    
                        }).catch(()=>{
                            swal.fire('Error!','Ha ocurrido un error','error');
                            this.$Progress.fail();
                        });
                    }
                    
                });
            },
        }
    }
</script>
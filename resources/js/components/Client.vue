<template>
    <div class="mt-3 col-12">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h3 float-left">Adminstracion de Clientes</h3>
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
                                        @input="" v-model="search"
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
                                :style="{ width: field.key === 'accion' ? '180px' : '' }"
                                >
                            </template>

                            <template v-slot:cell(accion)="row">
                                <b-button size="sm" @click="row.toggleDetails" class="mr-2" variant="primary">
                                    {{ row.detailsShowing ?  'Ocultar' : 'Mostrar'}} <i class="fas fa-eye"></i>
                                </b-button>
                                <b-button size="sm" variant="warning" @click="editModal(row.item)">
                                    <i class="fas fa-edit"></i>
                                </b-button>
                                <b-button size="sm" variant="danger" @click="deleteClient(row.item.key_id)" >
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

        <div class="modal fade bd-example-modal" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editMode" id="createModalLabel">Crear Cliente</h5>
                        <h5 class="modal-title" v-show="editMode" id="createModalLabel">Actualizar Cliente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode === true ? updateClient() : createClient()">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Nombre</label>
                                    <input v-model="form.nombre" type="text" name="nombre"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('nombre') }">
                                    <has-error :form="form" field="nombre"></has-error>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Cedula</label>
                                    <input v-model="form.cedula" type="text" name="cedula"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('cedula') }">
                                    <has-error :form="form" field="cedula"></has-error>
                                </div>
                                <div class="form-group col-6">
                                    <label>Telefono Referencia</label>
                                    <input v-model="form.telefono_referencia" type="text" name="telefono_referencia"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('telefono_referencia') }">
                                    <has-error :form="form" field="telefono_referencia"></has-error>
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
    </div>
</template>

<script>
    export default {
        created() {
            this.getClient();
            Fire.$on('AfterEvent',()=>{
                this.getClient();
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
                    { key: 'nombre', sortable: true },
                    { key: 'cedula', label:'cedula', sortable: true },
                    { key: 'telefono_referencia', sortable: true, class: 'text-center' },
                    { key: 'accion'}
                ],
                items: [],
                totalRows:0,
                editMode: false,                
                search: '',
                form: new Form({
                    id: 0,
                    nombre: '',
                    cedula: '',
                    telefono_referencia: '',
                    key_id: ''
                }),
            }
        },
        methods:{
            getClient(url = base_url + '/api/cliente/'){
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
            createClient(){          
                this.$Progress.start();  
                this.form.post('api/cliente')
                .then(()=>{            
                    Fire.$emit('AfterEvent');                           
                    $('#createModal').modal('hide');
                    toast.fire({
                        icon: 'success',
                        title: 'El cliente ha sido creada.'
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
            updateClient(){
                this.$Progress.start();
                this.form.put('api/cliente/'+this.form.key_id)
                .then(()=>{
                    $('#createModal').modal('hide');
                    swal.fire(
                        'Actualizado!',
                        'El cliente ha sido actializada',
                        'success'
                    );
                    this.$Progress.finish();
                    Fire.$emit('AfterEvent'); 
                    
                })
                .catch(()=>{
                    this.$Progress.fail();
                })
            },
            deleteClient(key_id){
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
                        this.form.delete('api/cliente/'+key_id).then(()=>{ 
                            swal.fire(
                                'Eliminado!',
                                'El cliente ha sido eliminada.',
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
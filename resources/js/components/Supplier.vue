<template>
    <div class="mt-3 col-12">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h3 float-left">Adminstracion de Suplidores</h3>
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
                                    <input type="text"  class="form-control" v-model="search"
                                        @input="getSuppliers()"
                                        placeholder="Filtrar" aria-label="Filtrar"
                                        aria-describedby="basic-addon1">
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
                                :style="{ width: field.key === 'accion' ? '180px' : ''|| field.key === 'correo' ? '260px' : '' || field.key === 'activo' ? '70px' : ''|| field.key === 'telefono'  }"
                                >
                            </template>

                            <template v-slot:cell(accion)="row">
                                <b-button size="sm" @click="row.toggleDetails" class="mr-2" variant="primary">
                                    {{ row.detailsShowing ? 'Ocultar' : 'Mostrar'}} <i class="fas fa-eye"></i>
                                </b-button>
                                <b-button size="sm" @click="editModal(row.item)" variant="warning">
                                    <i class="fas fa-edit"></i>
                                </b-button>
                                <b-button size="sm" @click="deleteSupplier(row.item.key_id)" variant="danger">
                                    <i class="fas fa-trash"></i>
                                </b-button>
                            </template>

                            <template v-slot:row-details="row">
                                <b-card>
                                    <b-row>                                        
                                        <div class="col-4 text-sm-left">
                                            <b-row class="mb-2">
                                                <b-col sm="3" class="text-sm-left"><b>Empresa:</b></b-col>
                                                <b-col class="pl-0">{{ row.item.empresa }}</b-col>
                                            </b-row>                                            
                                            
                                            <b-row class="mb-2">
                                                <b-col sm="3" class="text-sm-left"><b>Correo:</b></b-col>
                                                <b-col class="pl-0">{{ row.item.correo }}</b-col>
                                            </b-row>
                                        </div>
                                        <div class="col-4 text-sm-left">    
                                            <b-row class="mb-2">
                                                <b-col sm="3" class="text-sm-left"><b>Telefono:</b></b-col>
                                                <b-col class="pl-0">{{ row.item.telefono }}</b-col>
                                            </b-row>
                                            <b-row class="mb-2">
                                                <b-col sm="3" class="text-sm-left"><b>Activo:</b></b-col>
                                                <b-col class="pl-0">{{ row.item.activo}}</b-col>
                                            </b-row>
                                        </div> 
                                        <div class="col-4 text-sm-left">
                                            <b-row class="mb-2">
                                                <b-col sm="3" class="text-sm-left pl-0"><b>Comentario:</b></b-col>
                                                <b-col class="pl-0">{{ row.item.comentario }}</b-col>
                                            </b-row>
                                        </div>
                                    </b-row>                                  
                                    <b-button size="sm" variant="primary" @click="row.toggleDetails">Ocultar detalles</b-button>
                                </b-card>
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
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editMode" id="createModalLabel">Añadir Suplidor</h5>
                        <h5 class="modal-title" v-show="editMode" id="createModalLabel">Actualizar Suplidor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode === true ? updateSupplier() : createSupplier()">
                        <div class="modal-body">
                            <b-tabs content-class="mt-3">
                                <b-tab title="Informacion General" active>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label>Empresa</label>
                                            <input v-model="form.empresa" type="text" name="empresa"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('empresa') }">
                                            <has-error :form="form" field="empresa"></has-error>
                                        </div>                                                                     
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>Correo</label>
                                            <input v-model="form.correo" type="email" name="correo"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('correo') }">
                                            <has-error :form="form" field="correo"></has-error>
                                        </div>
                                        <div class="form-group col-6">
                                            <label>Telefono</label>
                                            <input v-model="form.telefono" type="text" v-mask="'# (###) ###-####'" name="telefono"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('telefono') }">
                                            <has-error :form="form" field="telefono"></has-error>
                                        </div>                                                                      
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label>Enlance</label>
                                            <input v-model="form.enlace" type="text" name="enlace"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('enlace') }">
                                            <has-error :form="form" field="enlace"></has-error>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-10">
                                            <label>Comentario</label>
                                            <textarea class="form-control" id="comentario" rows="3"
                                                v-model="form.comentario" 
                                                name="comentario"
                                                :class="{ 'is-invalid': form.errors.has('comentario') }">
                                            </textarea>
                                            <has-error :form="form" field="comentario"></has-error>
                                        </div>
                                        <div class="col-2 d-flex pt-3">
                                            <b-form-checkbox
                                                id="activo"
                                                v-model="form.activo"
                                                name="activo"
                                                value="si"
                                                unchecked-value="no"
                                                class="align-self-center"

                                                :class="{ 'is-invalid': form.errors.has('activo') }"
                                                >
                                                Activo
                                            </b-form-checkbox>
                                            <has-error :form="form" field="activo"></has-error>
                                        </div>
                                    </div>
                                </b-tab>
                                
                            </b-tabs>                           
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
        computed:{
        },
        created() {
            this.getSuppliers();
            Fire.$on('AfterEvent',()=>{
                this.getSuppliers();
            });
        },
        data() {
            return {
                pageOptions: [10, 25, 50, 100],
                currentPage: 1,
                perPage: 10,
                sortBy: 'Empresa',
                sortDesc: false,
                fields: [
                    { key: 'empresa', sortable: true },
                    { key: 'correo', sortable: true },                    
                    { key: 'telefono', sortable: true, class: 'text-center' },
                    { key: 'activo', sortable: true, class: 'text-center' },
                    { key: 'accion', class: 'text-center'}
                ],
                items: [],
                totalRows:0,
                editMode: false,
                search: '',
                form: new Form({
                    id: 0,
                    empresa: '',
                    telefono: '',
                    correo: '',
                    enlace: '',
                    comentario: '',
                    activo: 'no',
                    key_id: ''
                }),
            }
        },       
        methods:{
            getSuppliers(url = base_url + '/api/suplidor/'){
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
            createSupplier(){          
                this.$Progress.start();  
                this.form.post('api/suplidor')
                .then(()=>{            
                    Fire.$emit('AfterEvent');                           
                    $('#createModal').modal('hide');
                    toast.fire({
                        icon: 'success',
                        title: 'El suplidor creado correctamente.'
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
            updateSupplier(){
                this.$Progress.start();
                this.form.put('api/suplidor/'+this.form.key_id)
                .then(()=>{
                    $('#createModal').modal('hide');
                    swal.fire(
                        'Actualizado!',
                        'El suplidor ha sido actualizado.',
                        'success'
                    );
                    this.$Progress.finish();
                    Fire.$emit('AfterEvent'); 
                    
                })
                .catch(()=>{
                    this.$Progress.fail();
                })
            },
            deleteSupplier(key_id){
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
                        this.form.delete('api/suplidor/'+key_id).then(()=>{ 
                            swal.fire(
                                'Eliminado!',
                                'El suplidor ha sido eliminado.',
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
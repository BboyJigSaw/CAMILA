<template>
    <div class="mt-3 col-12">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h3 float-left">Adminstracion de Celulares</h3>

                        <button type="button" class="btn btn-primary btn-sm float-right" v-b-toggle.sidebar-right>
                            Buscar <i class="fas fa-search"></i>
                        </button>     

                        <button type="button" class="btn btn-success btn-sm float-right mr-2"  @click="openModal">Agregar <i class="fas fa-plus"></i></button>
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
                                    :style="{ width: field.key === 'accion' ? '240px' : '' ||  field.key === 'suplidor' ? '200px' : '' || field.key === 'activo' ? '70px' : ''}"
                                >
                            </template>                  

                            <template v-slot:cell(accion)="row">
                                <b-button size="sm" @click="row.toggleDetails" class="mr-2" variant="primary">
                                    {{ row.detailsShowing ? 'Ocultar' : 'Mostrar'}} <i class="fas fa-eye"></i>
                                </b-button>
                                <b-button size="sm" @click="editModal(row.item)" variant="warning">
                                    <i class="fas fa-edit"></i>
                                </b-button>
                                <b-button size="sm" @click="deleteSupply(row.item.key_id)" variant="danger">
                                    <i class="fas fa-trash"></i>
                                </b-button>
                            </template>

                            <template v-slot:row-details="row">
                                <b-card>
                                    <b-row>                                        
                                        <div class="col-4 text-sm-left">
                                            <b-row class="mb-2">
                                                <b-col sm="5" class="text-sm-left"><b>Nombre:</b></b-col>
                                                <b-col class="pl-0">{{ row.item.nombre }}</b-col>
                                            </b-row>                                            
                                            <b-row class="mb-2">
                                                <b-col sm="5" class="text-sm-left"><b>Suplidor:</b></b-col>
                                                <b-col class="pl-0">{{ row.item.suplidor}}</b-col>
                                            </b-row>                                                                                 
                                            
                                            <b-row class="mb-2">
                                                <b-col sm="5" class="text-sm-left"><b>Unidad de Medida:</b></b-col>
                                                <b-col class="pl-0">{{ row.item.unidad_medida }}</b-col>
                                            </b-row>
                                        </div>
                                        <div class="col-4 text-sm-left">                                                                                    
                                            
                                            <b-row class="mb-2">
                                                <b-col sm="5" class="text-sm-left"><b>Almacen:</b></b-col>
                                                <b-col class="pl-0">{{ row.item.almacen }}</b-col>
                                            </b-row>
                                            <b-row class="mb-2">
                                                <b-col sm="5" class="text-sm-left"><b>Categoria:</b></b-col>
                                                <b-col class="pl-0">{{ row.item.categoria}}</b-col>
                                            </b-row>
                                            <b-row class="mb-2">
                                                <b-col sm="5" class="text-sm-left"><b>Activo:</b></b-col>
                                                <b-col class="pl-0">{{ row.item.activo}}</b-col>
                                            </b-row>
                                        </div> 
                                        <div class="col-4 text-sm-left">
                                            <b-row class="mb-2">
                                                <b-col sm="4" class="text-sm-left pl-0"><b>Comentario:</b></b-col>
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
                        <h5 class="modal-title" v-show="!editMode" id="createModalLabel">Añadir Insumo</h5>
                        <h5 class="modal-title" v-show="editMode" id="createModalLabel">Actualizar Insumo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode === true ? updateSupply() : createSupply()">
                        
                        <div class="modal-body">
                            <b-tabs content-class="mt-3">
                                <b-tab title="Informacion del producto" active>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>Nombre</label>
                                            <input v-model="form.nombre" type="text" name="nombre"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('nombre') }">
                                            <has-error :form="form" field="nombre"></has-error>
                                        </div>
                                        <div class="form-group col-6">
                                            <label>Suplidor</label>
                                            <b-form-input list="suplidor-search" v-model="form.suplidor"
                                            :class="{ 'is-invalid': form.errors.has('suplidor') }"></b-form-input>                                            
                                            <b-form-datalist  id="suplidor-search">
                                                <option v-for="suplidor in suplidores" :key="suplidor.id" :value="suplidor.text"/>
                                            </b-form-datalist >
                                            <has-error :form="form" field="suplidor"></has-error>
                                        </div>                                     
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>Modelo</label>
                                            <input type="text" name="modelo" v-model="form.modelo"
                                                class="form-control" >
                                            <has-error :form="form" field="modelo"></has-error>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group col-10">
                                            <label>Descripcion</label>
                                            <textarea class="form-control" id="comentario" rows="3" v-model="form.comentario" name="comentario"
                                            :class="{ 'is-invalid': form.errors.has('comentario') }"></textarea>
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
                                <b-tab title="Inventario" v-if="editMode">
                                    
                                    <h3 class="mt-3">Entradas de inventario</h3>
                                    <div class="row mt-3">                                        
                                        <div class="form-group col-4">
                                            <label>IMEI</label>
                                            <input type="text" name="imei" v-model="inventario.imei"
                                                class="form-control" >
                                            <has-error :form="form" field="imei"></has-error>
                                        </div>  
                                        <div class="form-group col-4 text-right">
                                            <label>Costo</label>
                                            <input v-model.number="inventario.costo" type="text"
                                                class="form-control text-right">
                                        </div>  
                                        <div class="form-group col-1 p-2 text-center">
                                            <b-button  class="mt-4 " variant="success" @click="saveInventoryDetail()" >
                                                <i class="fas fa-plus"></i>
                                            </b-button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <b-table  ref="tabla_detalle_inventario" class="col-12"                                    
                                            striped
                                            small
                                            bordered 
                                            :fields="inventario.fields" 
                                            :items="inventario.list" 
                                            :per-page="inventario.perPage"
                                            :current-page="inventario.currentPage"
                                            responsive="sm">
                                            <template v-slot:table-colgroup="scope">                            
                                                <col
                                                v-for="field in scope.fields"
                                                :key="field.key"
                                                :style="{ width: field.key === 'accion' ? '80px' : ''|| field.key === 'costo' ? '150px' : ''|| 
                                                    field.key === 'created_at' ? '150px' : ''|| field.key === 'cantidad' ? '150px' : '' }"
                                                >
                                            </template>
                                            <template v-slot:cell(created_at)="row">
                                                {{ row.item.created_at | myDate}}
                                            </template>
                                            <template v-slot:cell(costo)="row">
                                                {{ row.item.costo | number_format}}
                                            </template> 
                                            <template v-slot:cell(accion)="row">                                               
                                                <b-button size="sm"  variant="danger" @click="deleteInventoryDetail(row.item.key_id)">
                                                    <i class="fas fa-trash"></i>
                                                </b-button>
                                            </template>
                                        </b-table>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <b-pagination
                                                v-model="inventario.currentPage"
                                                :total-rows="inventory_detail_count"
                                                :per-page="inventario.perPage"
                                                aria-controls="tabla_detalle_inventario"
                                            ></b-pagination>
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

        <b-sidebar id="sidebar-right" title="Busqueda" right shadow>
            <div class="px-3 py-2">
                <div class="form-group">
                    <label>Nombre</label>
                    <input v-model="search.nombre" type="text"
                        class="form-control">
                    
                </div>
                <div class="form-group">
                    <label>Suplidor</label>
                    <b-form-input list="suplidor-search" v-model="search.suplidor"></b-form-input>                                            
                    <b-form-datalist  id="suplidor-search">
                        <option v-for="suplidor in suplidores" :key="suplidor.id" :value="suplidor.text"/>
                    </b-form-datalist >
                </div>        
                <div class="form-group mt-5 float-left">
                    <button type="button" class="btn btn-primary" @click="getSupplies()">
                            Buscar <i class="fas fa-search"></i>
                    </button>
                </div>               
                <div class="form-group mt-5 float-right">
                    <button type="button" class="btn btn-secondary" @click="searchCleaner()">
                            Limpiar busqueda <i class="fas fa-trash"></i>
                    </button>
                </div> 
                                
            </div>
        </b-sidebar>
    </div>
</template>

<script>
    export default {
        computed:{
            inventory_detail_count() {
                return this.inventario.list.length;
            }
        },        
        created() {
            
            Fire.$on('AfterEvent',()=>{
                this.getSupplies();
            });
            this.getSupplies();
            this.getSuppliers();
        },
        
        data() {
            return {
                pageOptions: [10, 25, 50, 100],
                currentPage: 1,
                perPage: 10,
                sortBy: 'nombre',
                sortDesc: false,
                fields: [
                    { key: 'nombre', label:'Nombre', sortable: true , class: 'text-bold'},
                    { key: 'suplidor', label: 'Suplidor', sortable: true },
                    { key: 'activo', sortable: true, class: 'text-center' },
                    { key: 'accion', class: 'text-center'}
                ],
                items: [],
                suplidores:[],     
                editMode: false,
                search:{
                    nombre: '',     
                    suplidor: '', 
                },
                totalRows:0,
                inventario: {                    
                    inventory_key: '',
                    
                    //Detalle                   
                    imei: '',
                    costo: 0,

                    list: [] ,
                    fields: [                        
                        {key: 'created_at', label:'Fecha de Entrada', sortable: true, class: 'text-center'} ,
                        {key: 'imei', label:'IMEI', sortable: true, class: ''} ,
                        {key: 'cantidad', sortable: true, class: 'text-right'},
                        {key: 'costo', sortable: true, class: 'text-right'}, 
                        {key: 'accion', class: 'text-center'},
                    ],
                    currentPage: 1,
                    perPage: 5
                },
                form: new Form({
                    id: 0,
                    nombre: '',
                    suplidor: '',
                    modelo: ''  ,
                    comentario: '',
                    activo: 'no',
                    key_id: ''
                }),
            }
        },       

        methods:{
            

            getSuppliers(url = base_url + '/api/suplidorList/'){
                axios.get(url)
                .then(response => {
                    let data =  response.data.data;
                    this.suplidores = data;
                })
                .catch(errors => {
                    console.log(errors);
                });
            },
            
            getSupplies(url = base_url + '/api/insumo/'){
                axios.get(url, {params: {
                    nombre:this.search.nombre,
                    suplidor:this.search.suplidor,                    
                }})
                .then(response => {
                    let data =  response.data.data;
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
            
            createSupply(){          
                this.$Progress.start();  
                this.form.post('api/insumo')
                .then(()=>{            
                    Fire.$emit('AfterEvent');                           
                    $('#createModal').modal('hide');
                    toast.fire({
                        icon: 'success',
                        title: 'El insumo creado correctamente.'
                    }); 
                    this.$Progress.finish();                   
                })
                .catch(()=>{
                    swal.fire('Error!','Hubo un error','error');
                });
            },
            
            editModal(supply){               
                this.form.reset();
                this.editMode = true,                
                $('#createModal').modal('show');
                this.form.fill(supply);

                //detail
                this.getInventoryDetail();
            },

            updateSupply(){
                this.$Progress.start();
                this.form.put('api/insumo/'+this.form.key_id)
                .then(()=>{
                    $('#createModal').modal('hide');
                    swal.fire(
                        'Actualizado!',
                        'El insumo ha sido actualizado.',
                        'success'
                    );
                    this.$Progress.finish();
                    Fire.$emit('AfterEvent'); 
                    
                })
                .catch(()=>{
                    this.$Progress.fail();
                })
            },
            
            deleteSupply(key_id){
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
                        this.form.delete('api/insumo/'+key_id).then(()=>{ 
                            swal.fire(
                                'Eliminado!',
                                'El insumo ha sido eliminado.',
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
            
            getInventoryDetail(url = base_url + '/api/inventarioDetail/'){
                
                axios.get(url, {params: {supply_key: this.form.key_id}})
                .then(response => {
                    let data =  response.data;
                    
                    //set inventory data
                    this.inventario.inventory_key = data.key_id;

                    //set inventory detail list
                    this.inventario.list = data.inventory_detail;
                })
                .catch(errors => {
                    console.log(errors);
                });
            },

            saveInventoryDetail(){
                if( this.inventario.costo == 0 || this.inventario.imei == ''){
                    swal.fire('Error!','Debe introduccir todos los datos','error');
                }else{

                    let fData = new FormData();

                    fData.append('inventory_key',  this.inventario.inventory_key);
                    fData.append('imei',  this.inventario.imei);
                    fData.append('costo',  this.inventario.costo);

                    axios.post(base_url + '/api/inventarioDetail', fData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(()=>{
                            toast.fire({
                            icon: 'success',
                            title: 'Registro insertado correctamente.'
                        }); 
                    })
                    .catch(function (error) {
                        console.log(error);
                    });      
                    this.inventario.costo = 0;

                    this.getInventoryDetail();
                }
            },
            
            deleteInventoryDetail(key_id){
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
                        this.form.delete('api/inventarioDetail/'+key_id).then(()=>{ 
                            this.getInventoryDetail();
                            swal.fire(
                                'Eliminado!',
                                'El archivo ha sido eliminado.',
                                'success'
                            );
                        }).catch(()=>{
                            swal.fire('Error!','Ha ocurrido un error','error');
                            this.$Progress.fail();
                        });
                    }
                    
                });                
            },

            searchCleaner(){
                this.search.nombre = '';                    
                this.search.almacen = '';
                this.search.category_id = 0;
                this.search.medida = '';
                this.search.suplidor = '';
                
                this.getSupplies();
            }
        }
    }
</script>
<template>
    <div class="mt-3 col-12">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h3 float-left">Adminstracion de Pedidos</h3>
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
                                        @input="getStatus()" v-model="search"
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
                                :style="{ width: field.key === 'accion' ? '120px' : '' || field.key === 'created_at' ? '150px' : ''|| field.key === 'estado' ? '100px' : ''|| field.key === 'monto_total' ? '180px' : '' }"
                                >
                            </template>
                            <template v-slot:cell(estado)="row">
                                {{row.item.status.nombre}}
                            </template>
                            <template v-slot:cell(client)="row">
                                {{row.item.client.nombre}}
                            </template>
                            <template v-slot:cell(id)="row">
                                #{{row.item.id}}
                            </template>
                            <template v-slot:cell(monto_total)="row">
                                DOP$ {{row.item.monto_total | number_format}}
                            </template>
                            <template v-slot:cell(created_at)="row">
                                {{row.item.created_at | myDate}}
                            </template>
                            <template v-slot:cell(accion)="row">
                                <router-link :to="'/pedido-edit/' + row.item.key_id" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </router-link>
                                <b-button size="sm" variant="danger" :disabled="row.item.status_id == 3 || row.item.status_id == 5" @click="deletePedido(row.item.key_id)" >
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
                        <h5 class="modal-title" id="createModalLabel">Crear estatus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Producto</label>
                            <b-form-input list="producto-search" v-model="cliente_search" @input="getClientList()"></b-form-input>                                            
                            <b-form-datalist  id="producto-search" >
                                <option v-for="cliente in clientes" :key="cliente.id" :value="cliente.nombre"/>
                            </b-form-datalist > 
                        </div>  
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" @click="createPedido()">Guardar</button>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
            this.getPedidos();
            Fire.$on('AfterEvent',()=>{
                this.getPedidos();
            });
        },
        computed: {
        },
        data() {
            return {
                pageOptions: [10, 25, 50, 100],
                currentPage: 1,
                perPage: 10,
                sortBy: '',
                sortDesc: false,
                cliente_search:null,
                clientes: [],
                cliente: null,
                fields: [
                    { key: 'id', label: 'No.', sortable: true },
                    { key: 'client', label: 'Cliente', sortable: true },
                    { key: 'monto_total',label:'Monto', sortable: true,class:'text-right' },
                    { key: 'created_at', label: 'Fecha Creacion', sortable: true,class:'text-center' },
                    { key: 'estado', sortable: true, class:'text-center'},
                    { key: 'accion', class:'text-center'}
                ],
                items: [],
                totalRows:0,            
                search: '',
            }
        },
        methods:{
            getPedidos(url = base_url + '/api/pedido/'){
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
            getClientList(url = base_url + '/api/clientList/'){
                axios.get(url, {params: {search:this.cliente_search}})
                .then(response => {
                    let data = response.data.data;
                    this.clientes = data;
                    this.cliente = this.clientes[0];
                })
                .catch(errors => {
                    console.log(errors);
                });
            },
            openModal(){
                $('#createModal').modal('show');
            },
            createPedido(){          
                axios.post(base_url + '/api/pedido', this.cliente)
                .then(()=>{
                        toast.fire({
                        icon: 'success',
                        title: 'Registro insertado correctamente.'
                    }); 

                    this.cliente = null;
                    $('#createModal').modal('hide');
                    this.getPedidos();
                })
                .catch(function (error) {
                    console.log(error);
                });      
            },
            deletePedido(key_id){
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
                        this.form.delete('api/estatus/'+key_id).then(()=>{ 
                            swal.fire(
                                'Eliminado!',
                                'El estatus ha sido eliminada.',
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
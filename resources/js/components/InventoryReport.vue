<template>
    <div class="mt-3 col-12">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h3 float-left">Inventario de celulares</h3>
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
                                        :options="dataTableLine.pageOptions"
                                    ></b-form-select>
                                </b-form-group>
                            </div>     
                            <div class="col-4"></div>
                            <div class="col-4 d-flex flex-row-reverse">
                                <div class="input-group col-8 pr-0">
                                    
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
                            :items="dataTablePhone.data_phone"
                            :fields="dataTablePhone.fields"
                            :sort-by.sync="dataTablePhone.sortBy"
                            :sort-desc.sync="dataTablePhone.sortDesc"
                            sort-icon-left
                            responsive="sm">
                            <template v-slot:table-colgroup="scope">                            
                                <col
                                v-for="field in scope.fields"
                                :key="field.key"
                                :style="{ width: field.key === 'cantidad_notificacion' ? '110px' : ''|| field.key === 'cantidad_existencia' ? '110px' : ''|| field.key === 'almacen' ? '150px' : ''|| 
                                            field.key === 'moneda' ? '90px' : '' || field.key === 'categoria' ? '120px' : ''|| field.key === 'suplidor' ? '160px' : ''|| field.key === 'costo_total' ? '120px' : ''
                                            || field.key === 'pais' ? '140px' : '' || field.key == 'accion' ? '145px' : ''}" >
                            </template>                          

                            <template v-slot:cell(accion)="row">
                                <b-button size="sm" @click="openModalDetail(row.item.id)" class="mr-2" variant="primary">
                                    <i class="fas fa-eye"></i>
                                </b-button>
                            </template>
                        </b-table>
                        <div class="row pl-3 pr-3">
                            <div class="col-3">
                                <b-pagination
                                    v-model="dataTablePhone.currentPage"
                                    :total-rows="dataTablePhone.totalRowsPhone"
                                    :per-page="perPage"
                                    align="fill"
                                    size="sm"
                                    class="my-0"
                                ></b-pagination>
                            </div>
                            <div class="col-5"></div>
                            <div class="col-4 text-right">
                                Organizado por: <b>{{ dataTablePhone.sortBy }}</b>, Orden:
                                <b>{{ dataTablePhone.sortDesc ? 'Descendente' : 'Ascendente' }}</b>
                            </div>
                        </div>                        
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h3 class="h3 float-left">Inventario De lineas</h3>
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
                                        :options="dataTablePhone.pageOptions"
                                    ></b-form-select>
                                </b-form-group>
                            </div>     
                            <div class="col-4"></div>
                            <div class="col-4 d-flex flex-row-reverse">
                                <div class="input-group col-8 pr-0">
                                    
                                </div>
                            </div>
                        </div>
                        <b-table class="col-12"
                            bordered
                            striped
                            small
                            responsive 
                            :current-page="dataTableLine.currentPage"
                            :per-page="dataTableLine.perPage"
                            :items="dataTableLine.data_line"
                            :fields="dataTableLine.fields"
                            :sort-by.sync="dataTableLine.sortBy"
                            :sort-desc.sync="dataTableLine.sortDesc"
                            sort-icon-left
                            responsive="sm">
                            <template v-slot:cell(accion)="row">
                                <b-button size="sm" @click="openModalDetail(row.item.id)" class="mr-2" variant="primary">
                                    <i class="fas fa-eye"></i>
                                </b-button>
                            </template>
                        </b-table>
                        <div class="row pl-3 pr-3">
                            <div class="col-3">
                                <b-pagination
                                    v-model="dataTableLine.currentPage"
                                    :total-rows="dataTableLine.totalRowsLine"
                                    :per-page="dataTableLine.perPage"
                                    align="fill"
                                    size="sm"
                                    class="my-0"
                                ></b-pagination>
                            </div>
                            <div class="col-5"></div>
                            <div class="col-4 text-right">
                                Organizado por: <b>{{ dataTableLine.sortBy }}</b>, Orden:
                                <b>{{ dataTableLine.sortDesc ? 'Descendente' : 'Ascendente' }}</b>
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
                        <h5 class="modal-title" id="createModalLabel">Detalle de producto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="row">
                            <b-table class="col-12" ref="tabla_ingredientes_producto" striped
                                small
                                bordered 
                                :fields="item_details.fields" 
                                :items="item_details.data" 
                                responsive="sm">
                            </b-table>
                        </div>    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                    
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
            this.getReport();
        },
        data() {
            return {
                dataTableLine: {
                    pageOptions: [10, 25, 50, 100],
                    currentPage: 1,
                    perPage: 10,
                    sortBy: 'tipo',
                    sortDesc: false,
                    totalRowsLine:0,
                    fields:[
                        { key: 'tipo', sortable: true, class: 'text-bold' },
                        { key: 'suplidor', sortable: true },
                        { key: 'cantidad_existencia',label:'Cantidad Ex.', class: 'text-right text-bold'},
                        { key: 'costo_total', class: 'text-right text-bold'},
                        { key: 'accion', class: 'text-center'}
                    ],
                    data_line:[],
                },
                dataTablePhone: {
                    pageOptions: [10, 25, 50, 100],
                    currentPage: 1,
                    perPage: 10,
                    sortBy: 'nombre',
                    sortDesc: false,                    
                    totalRowsPhone:0,
                    fields:[
                        { key: 'nombre', sortable: true, class: 'text-bold' },
                        { key: 'suplidor', sortable: true },
                        { key: 'cantidad_existencia',label:'Cantidad Ex.', class: 'text-right text-bold'},
                        { key: 'costo_total', class: 'text-right text-bold'},
                        { key: 'accion', class: 'text-center'}
                    ],
                    data_phone:[]
                },
                item_details:{
                    data: [],
                    fields: [
                        { key: 'fecha_expiracion', sortable: true, class: 'text-center text-bold' },
                        { key: 'cantidad', class: 'text-right', sortable: true},
                        { key: 'costo', class: 'text-right text-bold', sortable: true},
                        { key: 'costo_unitario', class: 'text-right text-bold', sortable: true}
                    ]
                },
                currentPage: 1,
                perPage: 10
            }
        },       
        methods:{
            getReport(url = base_url + '/api/reporteInventario'){
                axios.get(url, {params: {search:this.search}})
                .then(response => {
                    let data =  response.data;
                    this.dataTableLine.data_line = data.data_line;
                    this.dataTablePhone.data_phone = data.data_phone;
                })
                .catch(errors => {
                    console.log(errors);
                });
            },
            openModalDetail(id){
                axios.get(base_url + '/api/actualInventoryDetail/' + id)
                .then(response => {
                    let data = response.data;
                    this.item_details.data = data;
                })
                .catch(errors => {
                    console.log(errors);
                });
                $('#createModal').modal('show');
            },
            
        }
    }
</script>
<template>
    <div class="mt-3 col-12">
        <div class="mt-3 mb-2 row">
            <div class="col-8">
                <h1 class="text-left">Pedido: #{{data.id}}</h1>
            </div>
            <div class="col-4">
                <h3 class="text-right">Estado: <b-badge>{{data.estatus}}</b-badge></h3>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-12">
                <!-- <button type="submit" class="btn btn-secondary mr-2" @click="sendToProduction()">Comprometer</button> -->
                <button :disabled="data.estatus_id == 3 || data.estatus_id == 5" type="submit" class="btn btn-success mr-2" @click="sendToProduction()">Procesar</button>
                <button :disabled="data.estatus_id == 3 || data.estatus_id == 5" type="submit" class="btn btn-danger mr-2" @click="cancelProduction()">Cancelar</button>
            </div>
        </div>
        <div class="row ">
            <div class="col-12 border pt-3 border-primary">
                <div class="row">
                    <div class="col-8">
                        <h3>Cliente: {{data.cliente_nombre}}</h3>
                    </div>
                    <div class="form-group col-4">
                        <h3>Fecha: {{data.fecha | myDate}}</h3>
                        
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-3">
                        <label>Suplidor</label>
                        <b-form-select v-model="supplier_id" :options="suppliers"  @change="getProductList()"
                        ></b-form-select>
                    </div> 
                    <div class="form-group col-6">
                        <label>Producto</label>
                        <b-form-input list="producto-search" v-model="product_search"></b-form-input>                                            
                        <b-form-datalist  id="producto-search" >
                            <option v-for="producto in productList" :key="producto.id" :value="producto.nombre"/>
                        </b-form-datalist >                             
                    </div>                       
                    <div class="form-group col-2 text-right">
                        <label>Percio</label>
                        <input v-model.number="precio" type="text"
                            class="form-control text-right">
                    </div>                 
                    <div class="form-group col-1 p-2 text-center">
                        <b-button :disabled="data.estatus_id == 3 || data.estatus_id == 5" class="mt-4 " variant="success"  @click="saveItem()">
                            <i class="fas fa-plus"></i>
                        </b-button>
                    </div>
                </div>
                <h4>Listado</h4>
                <b-list-group class="mb-3">
                    <b-list-group-item class="border border-primary justify-content-between align-items-center" v-for="item in itemList" :key="item.id">
                        <b>{{item.nombre}}</b>
                        <b-button  size="sm"  variant="danger"  class="float-right " @click="deleteItem(item.key_id)">
                            <i class="fas fa-trash"></i>
                        </b-button> 
                        <label class="ml-5">suplidor: {{item.suplidor }}</label>
                        <label class="float-right mr-5">Cantidad: {{item.cantidad | number_format }}</label>
                        <label class="float-right mr-5">Precio: {{item.precio | number_format }}</label>
                    </b-list-group-item>
                </b-list-group> 
                <h3 class="float-right">Precio Total: {{total | number_format}}</h3>               
            </div>
        </div>
        <div class="row float-right pt-3">            
            <router-link to="/pedido" class="btn btn-secondary">
                Atras
            </router-link>            
        </div>       
    </div>
    
</template>

<script>
export default {
    // props:{
    //     key_id: string
    // },
    created() {
        this.get();
        this.getSupplierList();
        this.getItemList();
    },
    computed: {
        minDate(){
            const now = new Date();
            return new Date(now.getFullYear(), now.getMonth(), now.getDate());
        }
    },
    data() {
        return {            
            key_id: this.$route.params.key_id,
            data: {
                id:0,
                fecha: '',
                estatus:'',
                estatus_id:0,
                cliente_nombre: ''
            },
            product: {},
            cantidad: 0,
            productList:[],
            product_search:'',
            itemList:[],
            ingredientes:{
                fields:[
                    { key: 'nombre', sortable: true, class: 'text-bold' },                    
                    { key: 'cantidad', sortable: true },
                    { key: 'unidad_medida', sortable: true },
                ],
                data:[]
            },
            precio: 0,
            dismissSecs: 10,
            dismissCountDown: 0,
            showDismissibleAlert: false,
            indicaciones: '',
            suppliers: [],
            supplier_id: 0,
            total: 0
        }
    },
    methods: {
        getSupplierList(url = base_url + '/api/suplidorList/'){
            axios.get(url)
            .then(response => {
                let data = response.data.data;
                this.suppliers = data;
            })
            .catch(errors => {
                console.log(errors);
            });
        },
        getProductList(url = base_url + '/api/productoList/'){
            axios.get(url, {params: {supplier_id:this.supplier_id}})
            .then(response => {
                let data = response.data;
                this.productList = data;
                
            })
            .catch(errors => {
                console.log(errors);
            });
        },
        
        get(url = base_url + '/api/pedido/'+this.key_id){
            axios.get(url)
            .then(response => {
                let data = response.data;
                this.data.id = data.id;
                this.data.fecha = data.created_at;
                this.data.estatus_id = data.status.id;
                this.data.estatus = data.status.nombre;
                this.data.cliente_nombre = data.client.nombre;

                // this.getItemList(data.id);
                // this.getTotalIngredients(data.id);
            })
            .catch(errors => {
                console.log(errors);
            });
            
        },
        getItemList(){
            axios.get(base_url + '/api/pedido-detail/', {params: {key_id:this.key_id}})
            .then(response => {
                let data = response.data.items;
                this.itemList = data;
                this.total = response.data.total;

            })
            .catch(errors => {
                console.log(errors);
            });
        },
        saveItem(){
            if(!this.product_search){
                swal.fire('Error!','Debe introduccir todos los datos correctamente','error');
            }else{
                let to_send = {
                    order_id : this.data.id,
                    product : this.product_search,
                    precio: this.precio
                };
                axios.post(base_url + '/api/pedido-detail', to_send)
                .then(()=>{
                    toast.fire({
                        icon: 'success',
                        title: 'Registro insertado correctamente.'
                    }); 
                    this.getItemList();
                })
                .catch(function (error) {
                    console.log(error);
                });  
                
                this.product_search = null;
                this.precio = 0;
            }
        },
        deleteItem(key_id){
            swal.fire({
                title: 'Estas seguro?',
                text: "No Podras Revertir Esta accion!",                    
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminalo!'
            }).then((result) => {
                if (result.value) { 
                    axios.delete(base_url+'/api/pedido-detail/'+key_id).then(()=>{                             
                        this.getItemList();
                        swal.fire(
                            'Eliminado!',
                            'El Producto ha sido eliminado.',
                            'success'
                        );

                    }).catch(()=>{
                        swal.fire('Error!','Ha ocurrido un error','error');
                        this.$Progress.fail();
                    });
                }
                
            });                
        },
        cancelProduction(){
            swal.fire({
                title: 'Estas seguro?',
                text: "No Podras Revertir Esta accion!",                    
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si!'
            }).then((result) => {
                if (result.value) { 
                    axios.post(base_url + '/api/pre-produccion-cancel', {'key_id' : this.key_id})
                    .then(()=>{
                        toast.fire({
                            icon: 'success',
                            title: 'Preproduccion cancelada correctamente.'
                        });
                        window.location.href = base_url + "/pre-produccion";

                    }).catch(function (error) {
                        console.log(error);
                        swal.fire(
                            'Sucedio un error',
                            'La informacion no se cancelo correctamente',
                            'error'
                        );
                    });
                }
            }); 
        },
        

    },

}
</script>

<style>

</style>
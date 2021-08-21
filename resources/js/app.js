/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./helpers/general');

window.Vue = require('vue');

import swal from 'sweetalert2';

window.swal = swal;

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

window.toast = toast;

window.Form = Form; 

window.base_url = window.location.origin;


import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

import VueRouter from 'vue-router';

import moment from 'moment';

//v-mask
// Or as a directive
import { VueMaskDirective } from 'v-mask';
Vue.directive('mask', VueMaskDirective);

window._ = require('lodash');


import { Form, HasError, AlertError} from 'vform';


import VueProgressBar from 'vue-progressbar';

///
import { VueEditor } from "vue2-editor";
 
///
window.Fire = new Vue();

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '5px'
});


Vue.component('vue-editor', VueEditor);


Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, HasError);

Vue.use(VueRouter);

let routes = [
    {path: '/home', component:require('./components/Dashboard.vue').default},
    {path: '/reporte-inventario', component:require('./components/InventoryReport.vue').default},
    {path: '/suplidor', component:require('./components/Supplier.vue').default},
    {path: '/celular', component:require('./components/Supply.vue').default},
    {path: '/cliente', component:require('./components/Client.vue').default},
    {path: '/linea', component:require('./components/PhoneLine.vue').default},
    {path: '/estatus', component:require('./components/Status.vue').default},
    {path: '/pedido', component:require('./components/pedido/Index.vue').default},
    {path: '/pedido-edit/:key_id', component:require('./components/pedido/Edit.vue').default},    
];

const router = new VueRouter({
    routes,
    mode: 'history'
})

Vue.filter('upText',function(text){
    return text.charAt(0).toUpperCase() + text.slice(1);
});

Vue.filter('myDate', function(date){
    moment.locale(); 
    return moment(date).format('DD/MM/YYYY');
});

Vue.filter('number_format', function(number){
    let newNumber = parseFloat(number);
    
    const formatter = new Intl.NumberFormat('en-US', {
        
        minimumFractionDigits: 2
    })

    if(isNaN(newNumber)){
        return 0;
    }else{ 
        return formatter.format(newNumber);
    }
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#app',
    router,
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



//cliente
Route::middleware('auth:api')->get('cliente/','ClientController@index');
Route::middleware('auth:api')->get('clientList/','ClientController@getList');
Route::middleware('auth:api')->post('cliente/','ClientController@store');
Route::middleware('auth:api')->put('cliente/{key_id}','ClientController@update');
Route::middleware('auth:api')->delete('cliente/{key_id}','ClientController@destroy');

//suplidor
Route::middleware('auth:api')->get('suplidor/','SupplierController@index');
Route::middleware('auth:api')->get('suplidorList/','SupplierController@getList');
Route::middleware('auth:api')->post('suplidor/','SupplierController@store');
Route::middleware('auth:api')->put('suplidor/{key_id}','SupplierController@update');
Route::middleware('auth:api')->delete('suplidor/{key_id}','SupplierController@destroy');
//archivos


//insumo Line
Route::middleware('auth:api')->get('insumo-line/','SupplyLineController@index');
Route::middleware('auth:api')->post('insumo-line/','SupplyLineController@store');
Route::middleware('auth:api')->put('insumo-line/{key_id}','SupplyLineController@update');
Route::middleware('auth:api')->delete('insumo-line/{key_id}','SupplyLineController@destroy');
Route::middleware('auth:api')->get('insumo-lineList/','SupplyLineController@getList');

//insumo
Route::middleware('auth:api')->get('insumo/','SupplyController@index');
Route::middleware('auth:api')->post('insumo/','SupplyController@store');
Route::middleware('auth:api')->put('insumo/{key_id}','SupplyController@update');
Route::middleware('auth:api')->delete('insumo/{key_id}','SupplyController@destroy');
Route::middleware('auth:api')->get('insumoList/','SupplyController@getList');


//Detalle
Route::middleware('auth:api')->get('inventarioDetail/','PhoneInventoryController@getInventoryDetail');
Route::middleware('auth:api')->post('inventarioDetail/','PhoneInventoryController@storeDetail');
Route::middleware('auth:api')->delete('inventarioDetail/{key_id}','PhoneInventoryController@destroyDetail');

//inventario linea
Route::middleware('auth:api')->get('inventario-lineaDetail/','LineInventoryController@getInventoryDetail');
Route::middleware('auth:api')->post('inventario-lineaDetail/','LineInventoryController@storeDetail');
Route::middleware('auth:api')->delete('inventario-lineaDetail/{key_id}','LineInventoryController@destroyDetail');

//Reportes
Route::middleware('auth:api')->get('reporteInventario/','ReportsController@reporteInventario');
Route::middleware('auth:api')->get('actualInventoryDetail/{id}','ReportsController@actualInventoryDetail');



Route::middleware('auth:api')->get('pedido/','OrderController@index');
Route::middleware('auth:api')->get('pedido/{key_id}','OrderController@get');
Route::middleware('auth:api')->post('pedido/','OrderController@store');
Route::middleware('auth:api')->put('pedido/','OrderController@update');
Route::middleware('auth:api')->delete('pedido/{key_id}','OrderController@destroy');
Route::middleware('auth:api')->get('productoList/','OrderController@productList');
//detalle

Route::middleware('auth:api')->get('pedido-detail/','OrderController@getDetail');
Route::middleware('auth:api')->post('pedido-detail/','OrderController@storeItem');
Route::middleware('auth:api')->delete('pedido-detail/{key_id}','OrderController@destroyItem');



// Route::middleware('auth:api')->post('pre-produccion-send-to-prod/','PreProductionController@sendToProduction');
// Route::middleware('auth:api')->post('pre-produccion-copy/','PreProductionController@clonePreProduction');
// Route::middleware('auth:api')->post('pre-produccion-cancel/','PreProductionController@cancelPreProduction');



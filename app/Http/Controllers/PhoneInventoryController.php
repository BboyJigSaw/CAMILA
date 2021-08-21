<?php

namespace App\Http\Controllers;

use App\PhoneInventory as Inventory;
use App\PhoneInventoryDetail as InventoryDetail;

use App\Supply;
use Illuminate\Http\Request;

class PhoneInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInventoryDetail(Request $request)
    {
        $supply_key = $request['supply_key'];

        $supply = Supply::where('key_id','=', $supply_key)->firstOrFail();        
        
        return Inventory::where('supply_id', '=', $supply->id)->with('inventoryDetail')->firstOrFail();

        //return ['data' => $result];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setInvetoryAlarm(Request $request)
    {
        $inventory_key = $request['inventory_key'];
        $cantidad_notificacion = $request['cantidad_notificacion'];
        
        $inventory = Inventory::where('key_id','=', $inventory_key)->firstOrFail();        

        $inventory->update([
            'cantidad_notificacion' => $cantidad_notificacion
        ]);

        return ['message' => 'Notificacion Actualizada'];
    }

    public function destroyDetail($key_id)
    {
        $inventoryDetail = InventoryDetail::where('key_id','=', $key_id)->firstOrFail();

        $phone_inventory_id = $inventoryDetail->phone_inventory_id;

        $inventoryDetail->delete();

        $inventory = Inventory::where('id','=', $phone_inventory_id)->firstOrFail();   

        $sum_cantidad = InventoryDetail::where('phone_inventory_id','=', $inventory->id)->sum('cantidad');
        
        $sum_costo = InventoryDetail::where('phone_inventory_id','=', $inventory->id)->sum('costo');
        
        $inventory->update([
            'cantidad_existencia' => $sum_cantidad,
            'costo_total' => $sum_costo
        ]);
        
        return ['message' => 'Entrada de inventario eliminada'];
    }

    public function storeDetail(Request $request)
    {
        $inventory_key = $request['inventory_key'];
        $inventory = Inventory::where('key_id','=', $inventory_key)->firstOrFail();   

        InventoryDetail::create([
            'phone_inventory_id' => $inventory->id,
            'imei' => $request['imei'],
            'cantidad' =>  1,
            'tipo' => 'E',
            'costo' =>  $request['costo'],
            'tipo' => 'E',
            'key_id' => generate_key(),
            'created_by' => current_user()->id            
        ]);

        $sum_cantidad = InventoryDetail::where('phone_inventory_id','=', $inventory->id)->sum('cantidad');
        $sum_costo = InventoryDetail::where('phone_inventory_id','=', $inventory->id)->sum('costo');
        
        $inventory->update([
            'cantidad_existencia' => $sum_cantidad,
            'costo_total' => $sum_costo
        ]);

        return['data'=>'registro insertado'];
    }

    public function confirmQuantity(Request $request){

        $item = Inventory::where('id','=', $request->id)->firstOrFail();

        if ($item['cantidad'] > $request->cantidad) {
            return [
                'message' => "La cantidad para el producto {$item['nombre']}, no es suficiente",
                'cantidad_actual' => $item['cantidad']
            ];
        }else{
            return true;
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\LineInventory as Inventory;
use App\LineInventoryDetail as InventoryDetail;

use App\PhoneLine as Supply;
use Illuminate\Http\Request;

class LineInventoryController extends Controller
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
        
        return Inventory::where('supply_line_id', '=', $supply->id)->with('inventoryDetail')->firstOrFail();

        //return ['data' => $result];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function destroyDetail($key_id)
    {
        $inventoryDetail = InventoryDetail::where('key_id','=', $key_id)->firstOrFail();

        $phone_inventory_id = $inventoryDetail->phone_inventory_id;

        $inventoryDetail->delete();

        $inventory = Inventory::where('id','=', $phone_inventory_id)->firstOrFail();   

        $sum_cantidad = InventoryDetail::where('line_inventory_id','=', $inventory->id)->sum('cantidad');
        
        $sum_costo = InventoryDetail::where('line_inventory_id','=', $inventory->id)->sum('costo');
        
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
            'line_inventory_id' => $inventory->id,
            'numero_serie' => $request['no_serie'],
            'cantidad' =>  1,
            'tipo' => 'E',
            'costo' =>  $request['costo'],
            'key_id' => generate_key(),
            'created_by' => current_user()->id            
        ]);

        $sum_cantidad = InventoryDetail::where('line_inventory_id','=', $inventory->id)->sum('cantidad');
        $sum_costo = InventoryDetail::where('line_inventory_id','=', $inventory->id)->sum('costo');
        
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

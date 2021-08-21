<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\PhoneInventory;
use App\LineInventory;

class ReportsController extends Controller
{
    public function reporteInventario(Request $request){

        $phone_inventory = PhoneInventory::with('supply')->get();
        $line_inventory = LineInventory::with('supply')->get();

        return [
                    'data_phone' => $phone_inventory,
                    'data_line' => $line_inventory
                ];
    }

    public function actualInventoryDetail($id){
        $query = "  SELECT id.* 
                        FROM inventory_details id
                    LEFT JOIN inventories i on id.inventory_id = i.id
                    WHERE id.deleted_at is null 
                        AND id.cantidad > 0 
                        AND id.fecha_expiracion >= CURDATE()
                        AND i.supply_id = {$id}";
        $result = DB::select($query);
        return ['data' => $result];
    }
}

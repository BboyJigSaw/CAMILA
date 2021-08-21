<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderItem;
use App\Status;
use App\Client;
use App\Supply;
use App\PhoneLine;
use App\Production;


use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Order::with('status')->with('client')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Order::create([           
            'client_id' => $request->id,
            'status_id' => Status::where('default', 'si')->firstOrFail()->id,
            'monto_total' => 0,
            'key_id' => generate_key(),
            'created_by' => current_user()->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get($key_id)
    {
        return Order::with('status')->with('client')->where('key_id', '=', $key_id)->firstOrFail();
    }



    //detalle

    public function storeItem(Request $request)
    {
        $item = explode('-', $request->product);
        $product_info = null;
        if($item[2] == 'C'){
            $product_info = Supply::where('nombre', $item[0])->firstOrFail();
        }else{
            $product_info = PhoneLine::where('tipo', $item[0])->firstOrFail();
        }
        $data = [
            'order_id' => $request->order_id,
            'product_id' => $product_info->id,
            'suplidor' =>  $product_info->suplidor,
            'nombre' => $item[0] . ' - ' . $item[1],
            'precio' => $request->precio,
            'cantidad'=> 1,
            'tipo'=> $item[2],
            'key_id' => generate_key(),
            'created_by' => current_user()->id
        ];
        $order_item = OrderItem::create($data);

        $sum_precio = OrderItem::where('order_id','=', $request->order_id)->sum('precio');
       
        $orden = Order::where('id', $request->order_id)->firstOrFail();

        $orden->update(['monto_total'=> $sum_precio]);

        return ['message' => 'producto insertado'];
    }

   
    public function destroyItem($key_id)
    {
        $order_item = OrderItem::where('key_id','=', $key_id)->firstOrFail();
        $orden = Order::where('id', $order_item->order_id)->firstOrFail();
        $order_item->delete();
        $sum_precio = OrderItem::where('order_id','=', $order_item->order_id)->sum('precio');
       
        

        $orden->update(['monto_total'=> $sum_precio]);

        return ['message' => 'Item eliminado'];
    }

    public function getDetail(Request $request)
    {        
        $orden =  Order::where('key_id', '=', $request->key_id)->firstOrFail();
        return[
            'items' =>OrderItem::where('order_id','=', $orden->id)->get(),
            'total'=>$orden->monto_total
        ];
    }


    public function cancelProduction(Request $request){
        $preProduction = PreProduction::where('key_id', '=', $request->key_id)->firstOrFail();
        $dataStatus = ['status_id' => Status::where('code', 'cancelada')->firstOrFail()->id];
        $preProduction->update($dataStatus);

        return ['message' => 'Cancelado Correctamente'];
    }

    public function productList(Request $request){
        $sql = "
            SELECT
                s.id,
                CONCAT(s.nombre,'-', s.modelo, '-', 'C') as nombre
            FROM supplies s
            WHERE s.supplier_id = {$request->supplier_id} AND s.deleted_at is null and s.activo = 'si'
            UNION
            SELECT
                sl.id,
                CONCAT(sl.tipo,'-', sl.suplidor,'-', 'L') as  nombre
            FROM supply_lines sl
            WHERE sl.supplier_id = {$request->supplier_id} AND sl.deleted_at is null and sl.activo = 'si'
        ";

        return DB::select($sql);
    }

}

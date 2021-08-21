<?php

namespace App\Http\Controllers;

use App\PhoneLine as Supply;
use App\LineInventory;
use App\Supplier;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class SupplyLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = "";

        if($request->nombre != ''){
            $search .= "AND s.tipo LIKE '%".$request->tipo. "%'"; 
        }
        
        if($request->suplidor != ''){
            $search .= "AND s.suplidor LIKE '%".$request->suplidor. "%'"; 
        }
        

        $query="SELECT
                    s.tipo,
                    s.suplidor,
                    s.supplier_id,                                 
                    s.comentario,
                    s.activo,
                    s.key_id
                FROM supply_lines as s
                WHERE s.deleted_at is null
                {$search}
                ";
        $result = DB::select($query);
        return ['data' => $result];

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'tipo' => 'string|max:191',
            'suplidor' => 'required',
            'activo' => 'string|max:2',
        ]);

        $supplier = Supplier::where('empresa','=', $request['suplidor'])->first();

        $data = [
            'tipo' => $request['tipo'],
            'supplier_id' =>  $supplier ? $supplier->id : 0,
            'suplidor' =>  $supplier ? $supplier->empresa : $request['suplidor'],        
            'comentario' => $request['comentario'],
            'activo' => $request['activo'],
            'key_id' => generate_key(),
            'created_by' => current_user()->id            
        ];

        $product = Supply::create($data);

        LineInventory::create([
            'supply_line_id' => $product->id,
            'tipo' => $request['tipo'] ,
            'key_id' => generate_key(),
            'created_by' => current_user()->id 
        ]);

        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $key_id)
    {          
        $this->validate($request,[
            'tipo' => 'string|max:191',
            'suplidor' => 'required',
            'activo' => 'string|max:2',
        ]);

        $supplier = Supplier::where('empresa','=', $request['suplidor'])->first();

        $supply = Supply::where('key_id','=', $key_id)->firstOrFail();

        $data = array(            
            'tipo' => $request['tipo'],
            'supplier_id' =>  $supplier ? $supplier->id : 0,
            'suplidor' =>  $supplier ? $supplier->empresa : $request['suplidor'],        
            'comentario' => $request['comentario'],
            'activo' => $request['activo'],
            'updated_by' => current_user()->id,
            'updated_at' => time_s_now()
        );
        
        $supply->update($data);
        
        return ['message' => 'Insumo Actualizado'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function destroy($key_id)
    {
        $supply = Supply::where('key_id','=', $key_id)->firstOrFail();
        $supply->delete();
        return ['message' => 'Insumo eliminado'];
    }


    //metodo para los ingredientes de un producto

    public function getList(Request $request){
        $search_1 = "";
        $search_2 = "";

        if($request->search != ''){
            $search_1 .= "AND s.nombre LIKE '%{$request->search}%' OR s.suplidor LIKE '%{$request->search}%'"; 
            $search_2 .= "AND pp.nombre LIKE '%{$request->search}%'";
        }

        $query="SELECT s.id, 
                CONCAT(s.nombre,'-',s.suplidor) nombre,'I' tipo,
                s.key_id

                FROM supplies s
                WHERE s.deleted_at is null 
                AND s.activo = 'si'
                {$search_1}

                UNION
                
                SELECT pp.id, pp.nombre, 'PP' tipo,
                pp.key_id
                FROM
                pre_products pp
                WHERE pp.deleted_at is null 
                AND pp.activo = 'si'
                {$search_2}                
                ";

        $result = DB::select($query);
        return ['data' => $result];
    }
}

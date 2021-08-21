<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Supplier;
use App\Http\Resources\Supplier as RSupplier;
use Illuminate\Http\Request;


class SupplierController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request['search'] === null) {
            return Supplier::all();
        }   
        
        if ($request['search']) {
            $query =  Supplier::where('empresa', 'like', '%' . $request['search'] . '%')
                ->orWhere('correo', 'like', '%' . $request['search'] . '%')
                ->orWhere('telefono', 'like', '%' . $request['search'] . '%')
                ->whereNull('deleted_at')->get();
            
            return $query;
        }

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
            'empresa' => 'required|string|max:191|unique:suppliers',
            'telefono' => 'required|max:20',
            'correo' => 'required|email|max:191',
            'enlace' => '',
            'comentario' => 'string',
            'activo' => 'string|max:2',
        ]);
        return Supplier::create([
            'empresa' => $request['empresa'],
            'telefono' => $request['telefono'],
            'correo' => $request['correo'],
            'enlace' => $request['enlace'],
            'comentario' => $request['comentario'],
            'activo' => $request['activo'],
            'key_id' => generate_key(),
            'created_by' => current_user()->id
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $key_id)
    {
        $supplier = Supplier::where('key_id','=', $key_id)->firstOrFail();
        
        $this->validate($request,[
            'empresa' => 'required|string|max:191',
            'telefono' => 'required|max:20',
            'correo' => 'required|email|max:191',
            'enlace' => 'string',
            'comentario' => '',
            'activo' => 'string|max:2',
        ]);

        $data = array(
            'empresa' => $request['empresa'],
            'telefono' => $request['telefono'],
            'correo' => $request['correo'],
            'enlace' => $request['enlace'],
            'comentario' => $request['comentario'],
            'activo' => $request['activo'],            
            'updated_by' => current_user()->id,
            'updated_at' => time_s_now()
        );
        
        $supplier->update($data);
        
        return ['message' => 'Suplidor Actualizado'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy( $key_id)
    {
        $supplier = Supplier::where('key_id','=', $key_id)->firstOrFail();
        $supplier->delete();
        return ['message' => 'Suplidor eliminado'];
    }

    public function getList()
    {
        return RSupplier::collection(Supplier::where('activo', '=', 'si')->get());
    }

}

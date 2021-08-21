<?php

namespace App\Http\Controllers;

use App\Status;
use Illuminate\Http\Request;

use App\Http\Resources\Status as Rstatus;

class StatusController extends Controller
{
    public function index(Request $request)
    {
        if ($request['search'] === null) {
            return Status::all();
        }   
        
        if ($request['search']) {
            $query =  Status::where('nombre', 'like', '%' . $request['search'] . '%')->get();
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
            'nombre' => 'required|string|max:191|unique:categories',
            'code' => 'required|string|max:191',
            'default' => 'string|max:2',
            'activo' => 'string|max:2',
        ]);
        return Status::create([           
            'nombre' => $request['nombre'],
            'default' => $request['default'],
            'code' => $request['code'],
            'activo' => $request['activo'],
            'key_id' => generate_key(),
            'created_by' => current_user()->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Status  $Status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $key_id)
    {
        $categoria = Status::where('key_id','=', $key_id)->firstOrFail();
        
        $this->validate($request,[
            'nombre' => 'required|string|max:191',
            'code' => 'required|string|max:191',
            'default' =>  'string|max:2',
            'activo' => 'required|string|max:2',
        ]);

        $data = array(
            'nombre' => $request['nombre'],
            'code' => $request['code'],
            'default' => $request['default'],
            'activo' => $request['activo'],            
            'updated_by' => current_user()->id,
            'updated_at' => time_s_now()
        );
        
        $categoria->update($data);
        
        return ['message' => 'Categoria Actualizada'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Status  $Status
     * @return \Illuminate\Http\Response
     */
    public function destroy($key_id)
    {
        $Status = Status::where('key_id','=', $key_id)->firstOrFail();
        $Status->delete();
        return ['message' => 'Categoria eliminada!'];
    }

    public function getList()
    {
        return RStatus::collection(Status::where('activo', '=', 'si')->get());
    }
}

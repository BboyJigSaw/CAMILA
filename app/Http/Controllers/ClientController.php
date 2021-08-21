<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;


class ClientController extends Controller
{
    public function index(Request $request)
    {
        if ($request['search'] === null) {
            return Client::all();
        }   
        
        if ($request['search']) {
            $query =  Client::where('nombre', 'like', '%' . $request['search'] . '%')->get();
            return $query;
        }
    }

    
    public function store(Request $request)
    {
        $this->validate($request,[
            'nombre' => 'required|string|max:191|unique:clients',
            'cedula' => 'required|string|max:20|unique:clients',
            'telefono_referencia' => 'string|max:20',
        ]);
        return Client::create([           
            'nombre' => $request['nombre'],
            'cedula' => $request['cedula'],
            'telefono_referencia' => $request['telefono_referencia'],
            'key_id' => generate_key(),
            'created_by' => current_user()->id
        ]);
    }


    public function update(Request $request, $key_id)
    {
        $categoria = Client::where('key_id','=', $key_id)->firstOrFail();
        
        $this->validate($request,[
            'nombre' => 'required|string|max:191',
            'cedula' => 'required|string|max:20',
            'telefono_referencia' => 'string|max:20',
        ]);

        $data = array(
            'nombre' => $request['nombre'],
            'cedula' => $request['cedula'],
            'telefono_referencia' => $request['telefono_referencia'],
            'updated_by' => current_user()->id,
            'updated_at' => time_s_now()
        );
        
        $categoria->update($data);
        
        return ['message' => 'Cliente Actualizado'];
    }

    
    public function destroy($key_id)
    {
        $Status = Client::where('key_id','=', $key_id)->firstOrFail();
        $Status->delete();
        return ['message' => 'Cliente eliminado!'];
    }

    public function getList(Request $request){
        $result = Client::where('nombre','like', '%'.$request->client_name.'%')->get();
        return ['data' => $result];
    }
}

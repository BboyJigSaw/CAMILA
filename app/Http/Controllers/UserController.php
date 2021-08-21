<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request['search'] === null) {
            return User::all();
        }   
        
        if ($request['search']) {
            $query =  User::where('name', 'like', '%' . $request['search'] . '%')->get();
            return $query;
        }
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:191|unique:users',
            'password' => 'string',
        ]);
        return User::create([           
            'name' => $request['name'],
            'email' => $request['email'],
            'username' => $request['username'],
            'password' => Hash::make($request['password']), 
            'is_admin'  => $request['is_admin'],
            'key_id' => generate_key(),
        ]);
    }

    public function update(Request $request, $key_id)
    {
        $user = User::where('key_id','=', $key_id)->firstOrFail();
        
        $this->validate($request,[
                'name' => 'required|string|max:191',
        ]);

        $data = array(           
            'name' => $request['name'],
            'email' => $request['email'],
            'username' => $request['username'], 
            'is_admin'  => $request['is_admin'],
            'updated_at' => time_s_now()
        );
        
        $user->update($data);
        
        return ['message' => 'Usuario actualizado'];
    }

    public function changePassword(Request $request)
    {
        $user = User::where('key_id','=', $request['key_id'])->firstOrFail();

        $data = array(           
            'password' => Hash::make($request['password'])
        );
        
        $user->update($data);
        
        return ['message' => 'Contraseña actualizada'];
    }

    public function destroy($key_id)
    {
        $user = User::where('key_id','=', $key_id)->firstOrFail();
        $user->delete();
        return ['message' => 'Usuario eliminado!'];
    }
}
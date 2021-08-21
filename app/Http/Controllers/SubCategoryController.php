<?php

namespace App\Http\Controllers;

use App\SubCategory;
use Illuminate\Http\Request;
use App\Http\Resources\SubCategory as RSubCategory;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request['search'] === null) {
            return SubCategory::with('category')->get();
        }   
        
        if ($request['search']) {
            $query =  SubCategory::with('category')->where('nombre', 'like', '%' . $request['search'] . '%')->get();
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
            'nombre' => 'required|string|max:191|unique:sub_categories',
            'category_id' => 'required',
            'activo' => 'string|max:2',
        ]);
        return SubCategory::create([           
            'nombre' => $request['nombre'],
            'category_id' => $request['category_id'],
            'activo' => $request['activo'],
            'key_id' => generate_key(),
            'created_by' => current_user()->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubCategory  $SubCategory
     * @return \Illuminate\Http\SubCategory
     */
    public function update(Request $request, $key_id)
    {
        $categoria = SubCategory::where('key_id','=', $key_id)->firstOrFail();
        
        $this->validate($request,[
            'nombre' => 'required|string|max:191',
            'category_id' => 'required',
            'activo' => 'required|string|max:2',
        ]);

        $data = array(
            'nombre' => $request['nombre'],
            'category_id' => $request['category_id'],
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
     * @param  \App\SubCategory  $SubCategory
     * @return \Illuminate\Http\SubCategory
     */
    public function destroy($key_id)
    {
        $category = SubCategory::where('key_id','=', $key_id)->firstOrFail();
        $category->delete();
        return ['message' => 'Categoria eliminada!'];
    }

    public function getList($category_id)
    {
        return RSubCategory::collection(SubCategory::where('activo', '=', 'si')->where('category_id', '=', $category_id )->get());
    }
}

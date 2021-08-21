<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ordenes_produccion_ejecutadas_query = "
            SELECT count(*) ordenes_ejecutadas
            FROM productions p
            LEFT join statuses s on p.status_id = s.id
            WHERE s.code = 'ejecutada' and p.deleted_at is null";

        $ordenes_produccion_ejecutadas = DB::select($ordenes_produccion_ejecutadas_query);

        $costo_total_inventario_query = "
            SELECT SUM(i.costo_total) costo_inventario
            FROM inventories i
            left join supplies s on  i.supply_id = s.id
            where i.deleted_at is null and s.activo = 'si'
        ";

        $costo_total_inventario = DB::select($costo_total_inventario_query);

        $monto_total_producido_query = "            
            SELECT SUM(id.costo) monto_total
            FROM inventory_details id 
            LEFT JOIN inventories i on id.inventory_id = i.id 
            WHERE id.tipo = 'S' and i.deleted_at is null and id.deleted_at is null
        ";
        $monto_total_producido = DB::select($monto_total_producido_query);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

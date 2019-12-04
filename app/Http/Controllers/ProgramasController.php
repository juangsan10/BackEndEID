<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\programas;
use App\objetivos_programa;
use Illuminate\Support\Facades\DB;

class ProgramasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //programas que tengan un cruso asociado, tengan cupos, estan activos 
         return programas::all();
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
        $programa = new programas;
        $programa->id_programa = $request->codigo;
        $programa->nombre = $request->nombre;
        $programa->descripcion = $request->descripcion;
        $programa->save();
        // {
        //     return response()
        //     ->json(['status' => '200', 'response' => 'Guardado']);
        // }else
        // {
        //     return response()
        //     ->json(['status' => '504', 'response' => 'No se pudo guardar']);
        // }
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

    public function getDetalleByPrograma($id)
    {
        return DB::table('programas')
        ->join('detalle', 'detalle.Programas_id_programa', '=', 'programas.id_programa')
        ->select('programas.nombre', 'detalle.edad_min', 'detalle.edad_max' , 'detalle.hora_min' , 'detalle.hora_max' , 'detalle.id_detalle','detalle.nombre as nombre_detalle')
        ->where('programas.id_programa', '=', $id)
        ->get();
    }

    public function getObjetivosByPrograma($id)
    {
        return objetivos_programa::where("Programas_id_programa",$id)->first();
    }
    
    
}

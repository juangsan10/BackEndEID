<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\cursos;
use App\personas_has_cursos;

class CursosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return cursos::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cursos =  new cursos;
        $cursos->id_curso = $request->codigo;
        $cursos->cupos = $request->cupos;
        $cursos->nombre = $request->nombre;
        $cursos->Programas_id_programa = $request->programa;
        $cursos->save();
        $matricula = new personas_has_cursos;
        $matricula->Cursos_id_curso = $cursos->id_curso;
        $matricula->Personas_numero_doc =$request->profesor;
        $matricula->save();
        
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

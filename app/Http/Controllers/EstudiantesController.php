<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\documentos;

class EstudiantesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estudiantes = DB::table('personas')
        ->join('usuarios', 'personas.Usuarios_id_usuario', '=', 'usuarios.id_usuario')
        ->join('roles', 'usuario.Roles_id_rol', '=', 'roles.id_rol')
        ->select('personas.*')
        ->where('roles.rol','Estudiante')
        ->get();
        return $estudiantes;
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
  /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeDocuments($id, Request $request)
    {

//upload Image in server 
        // $file = $request->file('file');
        // $path = public_path() . '/img';
        // $fileName = uniqid() . $file->getClientOriginalName();
        // $file->move($path, $fileName);
        // print_r($path.$fileName.$id);

//upload image base 64 database
        // $documento = new documentos;
        // $file = $request->file('file');
        // $documento->documento =  base64_encode(file_get_contents($file));
        // $documento->Personas_numero_doc = $id;
        // $documento->save();
        // return "ok";
        
        //store binary 

        $documento = new documentos;
        $file = $request->file('file');
        $documento->documento =  file_get_contents($file);
        $documento->Personas_numero_doc = $id;
        $documento->save();
        return "ok";
        
    }



      /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDocuments($id)
    {   
        $documento  = documentos::where("Personas_numero_doc",$id)->first();
        $documento->documento = base64_encode($documento->documento);
        return $documento;
    }
    


}

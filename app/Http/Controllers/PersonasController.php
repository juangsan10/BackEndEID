<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\personas;

class PersonasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        personas::all();
        print_r( personas::all()->toJson());
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
       //recoger los datos del usurio por post
       $personas = new personas;
       $personas->tipo_doc=  $request->tipo_doc;
               $personas->numero_doc= $request->numero_doc;
                                          $personas->lugarExpedicion_doc = $request->lugarExpedicion_doc;
                                          $personas->nombre_completo = $request->nombre_completo;
                                          $personas->apellidos =$request->apellidos;
                                          $personas->fecha_nacimiento = $request->fecha_nacimiento;
                                          $personas->lugar_nacimiento = $request->lugar_nacimiento;
                                          $personas->genero = $request->genero;
                                          $personas->telefono = $request->telefono;
                                          $personas->correo = $request->correo;
                                          $personas->estudia =$request->estudia;
                                          $personas->grado_escolar = $request->grado_escolar;
                                          $personas->nombre_establecimiento = $request->nombre_establecimiento;
                                          $personas->tipo_establecimiento =$request->tipo_establecimiento;
                                          $personas->eps =$request->eps;
                                          $personas->nombre_padre=$request->nombre_padre;
                                          $personas->telefono_padre =$request->telefono_padre;
                                          $personas->nombre_madre =$request->nombre_madre;
                                          $personas->telefono_madre = $request->telefono_madre;
                                          $personas->nombre_acudiente = $request->nombre_acudiente;
                                          $personas->celular_acudiente = $request->celular_acudiente;
                                          $personas->empresa = $request->empresa;
                                          $personas->tipo_vinsulacion = $request->tipo_vinsulacion;
                                          $personas->programa = $request->programa;
                                          $personas->documentos = $request->documentos;
                                          $personas->antecedentes_salud = $request->antecedentes_salud;
                                          $personas->actividad_deportiva = $request->actividad_deportiva;
                                          $personas->empresa_usuario = $request->empresa_usuario;
                                          $personas->foto = $request->foto;
                                     $personas->Personas_numero_doc = $request->Personas_numero_doc;
       $personas->save();
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


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\documentos;
use App\personas;

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
        $estudiante = new personas;
        $estudiante->tipo_doc=  $request->tipoDocumento;
        $estudiante->numero_doc= $request->numeroDocumento;
        $estudiante->lugarExpedicion_doc = $request->lugarExpedicionDocumento;
        $estudiante->nombre_completo = $request->nombreCompleto;
        $estudiante->apellidos =$request->apellidos;
        $estudiante->fecha_nacimiento = $request->fechaNacimiento;
        $estudiante->lugar_nacimiento = $request->lugarNacimiento;
        $estudiante->genero = $request->genero;
        $estudiante->telefono = $request->telefono;
        $estudiante->correo = $request->correo;
        $estudiante->estudia =$request->estudia;
        $estudiante->grado_escolar = $request->gradoEscolar;
        $estudiante->nombre_establecimiento = $request->nombreEstablecimiento;
        $estudiante->tipo_establecimiento =$request->tipoEstablecimiento;
        $estudiante->eps =$request->eps;
        $estudiante->nombre_padre=$request->nombrePadre;
        $estudiante->telefono_padre =$request->celularPadre;
        $estudiante->nombre_madre =$request->nombreMadre;
        $estudiante->telefono_madre = $request->celularMadre;
        $estudiante->nombre_acudiente = $request->nombreAcudiente;
        $estudiante->celular_acudiente = $request->celular;
        //emailAddress correo acudiente
        $estudiante->empresa = $request->empresa;
        $estudiante->tipo_vinsulacion = $request->tipoVinculacion;
        $estudiante->programa = $request->programa;
        $estudiante->documentos = $request->documentos;
        $estudiante->foto = $request->foto;
        $estudiante->Usuarios_id_usuario = 2;
        $estudiante->save();
//direccionResidencia: null
//parentezco: null

/*      $estudiante = new personas;
        $estudiante->tipo_doc=  $request->tipoDocumento;
        $estudiante->numero_doc= $request->numeroDocumento;
        $estudiante->lugarExpedicion_doc = $request->lugarExpedicionDocumento;
        $estudiante->nombre_completo = $request->nombreCompleto;
        $estudiante->apellidos =$request->apellidos;
        $estudiante->fecha_nacimiento = $request->fechaNacimiento;
        $estudiante->lugar_nacimiento = $request->lugarNacimiento;
        $estudiante->genero = $request->genero;
        $estudiante->telefono = $request->telefono;
        $estudiante->correo = $request->correo;
        $estudiante->estudia =$request->estudia;
        $estudiante->grado_escolar = $request->gradoEscolar;
        $estudiante->nombre_establecimiento = $request->nombreEstablecimiento;
        $estudiante->tipo_establecimiento =$request->tipoEstablecimiento;
        $estudiante->eps =$request->eps;
        $estudiante->nombre_padre=$request->nombrePadre;
        $estudiante->telefono_padre =$request->celularPadre;
        $estudiante->nombre_madre =$request->nombreMadre;
        $estudiante->telefono_madre = $request->celularMadre;
        $estudiante->nombre_acudiente = $request->nombreAcudiente;
        $estudiante->celular_acudiente = $request->celular;

        //emailAddress correo acudiente
        $estudiante->empresa = $request->empresa;
        $estudiante->tipo_vinsulacion = $request->tipoVinculacion;
        $estudiante->programa = $request->programa;
        $estudiante->documentos = $request->documentos;
        $estudiante->antecedentes_salud = $request->antecedentes_salud;
        $estudiante->actividad_deportiva = $request->actividad_deportiva;
        $estudiante->empresa_usuario = $request->empresa_usuario;
        $estudiante->foto = $request->foto;
        $estudiante->Personas_numero_doc = $request->Personas_numero_doc;
        $estudiante->save();
 */

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

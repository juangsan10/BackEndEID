<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\documentos;
use App\personas;
use App\Usuarios;


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
        $usuario = Usuarios::where("correo",$request->emailAddress)->first();
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
        $estudiante->direccion_residencia = $request->direccionResidencia;
        $estudiante->parentezco = $request->parentezco;

        //emailAddress correo acudiente
        $estudiante->empresa = $request->empresa;
        $estudiante->tipo_vinsulacion = $request->tipoVinculacion;
        $estudiante->programa = $request->programa;
        $estudiante->documentos = $request->documentos;
        $estudiante->foto = $request->foto;
        // $encodedData = strtr($request->foto, '-_', '+/');
        // $encodedData = explode(',', $request->foto);
        // $estudiante->foto = base64_decode(utf8_encode($encodedData[1]));
        //$estudiante->foto = base64_decode($request->foto);
        // $base64_str = substr($arc->document3, strpos($arc->document3, ",")+1);
    
        // $decoded = base64_decode($encodedData);
        $estudiante->Usuarios_id_usuario = $usuario->id_usuario;
        $estudiante->save();


//
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
/*
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function getEstudentById(Request $request)
   {
        return  personas::where("numero_doc",$request->doc)->first();
   }
   public function storeGuardianAsStudent(Request $request)
   {
    $estudiante = new personas;
    $usuario = Usuarios::where("correo",$request->correo)->first();
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
    $estudiante->direccion_residencia = $request->direccionResidencia;
    $estudiante->parentezco = $request->parentezco;
    // $encodedData = strtr($request->foto, '-_', '+/');
    // $encodedData = explode(',', $request->foto);
    // $estudiante->foto = base64_decode(utf8_encode($encodedData[1]));
    $estudiante->foto = $request->foto;
    // $base64_str = substr($arc->document3, strpos($arc->document3, ",")+1);

    // $decoded = base64_decode($encodedData);
    $estudiante->Usuarios_id_usuario = $usuario->id_usuario;
    $estudiante->save();
    return response()
        ->json(['status' => '200', 'response' => 'Guardado']);
   }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function getEstudentByCurso($id)
   {

    return DB::table('cursos')
    ->join('personas_has_cursos', 'personas_has_cursos.Cursos_id_curso', '=', 'cursos.id_curso')
    ->join('personas', 'personas.numero_doc', '=', 'personas_has_cursos.Personas_numero_doc')
    ->join('usuarios', 'usuarios.id_usuario', '=', 'personas.Usuarios_id_usuario')
    ->select('personas.numero_doc','personas.nombre_completo')
    ->where('cursos.id_curso', '=', $id)
    ->where(function ($query) {
        $query->where('usuarios.Roles_id_rol', '!=', 2)
              ->orWhere('personas.hv_propia', '!=', 1);
    })
    ->get();
   }
    


}


<?php

namespace App\Http\Controllers;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\documentos;
use App\personas;
use App\Usuarios;
use App\asistencias;
use App\personas_has_cursos;
use App\Evaluaciones;
use App\cursos;
use App\Evaluaciones_has_objetivos;


class EstudiantesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estudiantesAndCurso = DB::table('cursos')
        ->join('personas_has_cursos', 'personas_has_cursos.Cursos_id_curso', '=', 'cursos.id_curso')
        ->join('personas', 'personas.numero_doc', '=', 'personas_has_cursos.Personas_numero_doc')
        ->join('usuarios', 'personas.Usuarios_id_usuario', '=', 'usuarios.id_usuario')
        ->select('personas.*')
        ->where(function ($query) {
            $query->where('usuarios.Roles_id_rol', '!=', 2)
                  ->orWhere('personas.hv_propia', '!=', 1);
        })
        ->get();
        return $estudiantesAndCurso;
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
        if(!$usuario)
        {
            $usuario = new Usuarios;
            $usuario->correo = $request->emailAddress;
            $usuario->nombre = $request->nombreAcudiente;
            $usuario->Roles_id_rol = 3;
            $usuario->save();
        }
  
        $estudiante->tipo_doc=  $request->tipoDocumento;
        $estudiante->numero_doc= $request->numeroDocumento;
        $estudiante->lugarExpedicion_doc = $request->lugarExpedicionDocumento;
        $estudiante->nombre_completo = $request->nombreCompleto;
        $estudiante->apellidos =$request->apellidos;
        $estudiante->fecha_nacimiento =$request->fechaNacimiento['year'].'-'.$request->fechaNacimiento['month'].'-'.$request->fechaNacimiento['day']; 
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
        $estudiante->hv_propia = 0;
        $estudiante->empresa = $request->empresa;
        $estudiante->tipo_vinsulacion = $request->tipoVinculacion;
        $estudiante->programa = $request->programa;
        $estudiante->documentos = $request->documentos;
        $estudiante->foto = $request->foto;
        $estudiante->Usuarios_id_usuario = $usuario->id_usuario;
        $estudiante->save();
        $matricula = new personas_has_cursos;
        $matricula->Cursos_id_curso = $request->programa;
        $matricula->Personas_numero_doc = $request->numeroDocumento;
        $matricula->save();
        $cursos = cursos::where("id_curso",$matricula->Cursos_id_curso)->first();
        $cuposCurso  = $cursos->cupos -1;
        cursos::where("id_curso",$matricula->Cursos_id_curso)->update(["cupos"=>$cuposCurso]);
        $bodyMail="
        El estudiante  ".$request->nombreCompleto." se ha matricula en el curso ".$cursos->nombre;
        Mail::raw($bodyMail, function ($message) use ($request){
            $message->subject('Cuenta de Iniciacion Deportiva');
            $message->to($request->emailAddress);
        });

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
        // Mail::send('emails.template', ['user' => 'prueba'], function ($message){
   
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
    $estudiante->hv_propia = 1;
    // 
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

    $matricula = new personas_has_cursos;
    $matricula->Cursos_id_curso = $request->programa;
    $matricula->Personas_numero_doc = $request->numeroDocumento;
    $matricula->save();

    $cursos = cursos::where("id_curso",$matricula->Cursos_id_curso)->first();
    $cuposCurso  = $cursos->cupos -1;
    cursos::where("id_curso",$matricula->Cursos_id_curso)->update(["cupos"=>$cuposCurso]);
    $bodyMail="
    El estudiante  ".$request->nombreCompleto." se ha matricula en el curso ".$cursos->nombre;
    Mail::raw($bodyMail, function ($message) use ($request){
        $message->subject('Cuenta de Iniciacion Deportiva');
        $message->to($request->emailAddress);
    });

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
    
   public function asistenciaByStudent(Request $request)
   {
    
    $asistencia = new asistencias;
    $fecha = date('Y-m-d H:i:s');
    // return $request->estudiantes[0]["numero_doc"];
    foreach ($request->estudiantes as $estudiante) {
        $asistencia = new asistencias;
        $asistencia->fecha = $fecha;
        $asistencia->asistio = $estudiante["asistio"]; 
        $asistencia->Personas_has_Cursos_Personas_numero_doc = $estudiante["numero_doc"]; 
        $asistencia->Personas_has_Cursos_Cursos_id_curso = $request->idCurso;
        $asistencia->save();
    }
    return response()
    ->json(['status' => '200', 'response' => 'Asistencia guardada correctamente']);
    }

    public function setCalificacionByStudent(Request $request)
    {

        $evaluacion = new Evaluaciones;
        $id_profesor = DB::table('usuarios')
        ->join('personas', 'personas.Usuarios_id_usuario', '=', 'usuarios.id_usuario')
        ->select('personas.numero_doc')
        ->where('personas.hv_propia', '=',1)
        ->where('usuarios.Roles_id_rol', '=',2)
        ->where('usuarios.correo', '=', $request->idProfesor)->first();
        $evaluacion->id_profesor = $id_profesor->numero_doc;
        $evaluacion->fecha = $request->fecha['year'].'-'.$request->fecha['month'].'-'.$request->fecha['day'];
        $evaluacion->observacion =  $request->observacion;
        $evaluacion->Personas_has_Cursos_Personas_numero_doc = $request->idEstudiante;
        $evaluacion->Personas_has_Cursos_Cursos_id_curso = $request->idCurso; 
        $evaluacion->idtimestamp = date("YmdHis"); 
        $evaluacion->save();
        $notasString="";
        foreach ($request->notas as $nota) {
            $evaluacion_objetivo = new Evaluaciones_has_objetivos;
            $evaluacion_objetivo->Evaluaciones_id_evaluacion = $evaluacion->id;
            $evaluacion_objetivo->nota = $nota['nota'];
            $evaluacion_objetivo->objetivos_id_objetivo = $nota['objetivo'];
            $evaluacion_objetivo->save();
        }
        
        $usuarioNotas = DB::table('usuarios')
        ->join('personas', 'personas.Usuarios_id_usuario', '=', 'usuarios.id_usuario')
        ->select('usuarios.correo')
        ->where('personas.numero_doc', '=', $evaluacion->Personas_has_Cursos_Personas_numero_doc)->first();
        $email ="";
        $email = $usuarioNotas->correo;
       
        $bodyMail="
            Se ha hecho la siguiente observacion sobre el estudiante con documento ".$evaluacion->Personas_has_Cursos_Personas_numero_doc."
            \n".$evaluacion->observacion;
        Mail::raw($bodyMail, function ($message) use ($request,$email){
                $message->subject('Cuenta de Iniciacion Deportiva');
                $message->to($email);
            });
        
     return response()
     ->json(['status' => '200', 'response' => 'Asistencia guardada correctamente']);
     }

    public function getCalificacionByStudent(Request $request)
    {
        $calificaciones = DB::table('evaluaciones')
        ->join('evaluaciones_has_objetivos', 'evaluaciones_has_objetivos.Evaluaciones_id_evaluacion', '=', 'evaluaciones.id_evaluacion')
        ->join('objetivos', 'objetivos.id_objetivo', '=', 'evaluaciones_has_objetivos.objetivos_id_objetivo')
        ->join('cursos', 'cursos.id_curso', '=', 'evaluaciones.Personas_has_Cursos_Cursos_id_curso')
        ->select('evaluaciones.observacion','objetivos.nombre','evaluaciones_has_objetivos.nota')
        ->where('cursos.estado', '=',1)
        ->where('evaluaciones.Personas_has_Cursos_Personas_numero_doc', '=', $request->doc)
        ->where('evaluaciones.Personas_has_Cursos_Cursos_id_curso', '=', $request->idCurso)->get();

     return response()
     ->json(['status' => '200', 'data' => $calificaciones]);
     }

     public function getAsistencia(Request $request)
     {
        $asistencia = DB::table('asistencias')
            ->join('personas', 'personas.numero_doc', '=', 'asistencias.Personas_has_Cursos_Personas_numero_doc')
            ->select('asistencias.*','personas.nombre_completo')
            ->where('asistencias.Personas_has_Cursos_Cursos_id_curso', '=', $request->idCurso)->get();
        foreach ($asistencia as $asistenci) {
            $asistenci->fecha = explode(" ",$asistenci->fecha)[0];
            $asistenci->asistio = $asistenci->asistio == 1 ? "SI" : "NO";
        }
            return response()
            ->json(['status' => '200', 'data' => $asistencia]);
        }
     
}

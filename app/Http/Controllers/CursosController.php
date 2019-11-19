<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\cursos;
use App\personas_has_cursos;
use App\Usuarios;
use Illuminate\Support\Facades\DB;

class CursosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $token = strval($request->bearerToken());         
        // if($request->bearerToken()) 
        //  {
        //     $user = Usuarios::where("id_token",$token);
        //      return $user;
        //  }
        // //  $documento  = documentos::where("Personas_numero_doc",$id)->first();
         cursos::all();
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
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCursosByUser(Request $request)
    {

        $usuario =  Usuarios::where('correo', $request->email)->first();
        if($usuario)
        {
            $estudiantesAndCurso = DB::table('programas')
            ->join('cursos', 'cursos.Programas_id_programa', '=', 'programas.id_programa')
            ->join('personas_has_cursos', 'personas_has_cursos.Cursos_id_curso', '=', 'cursos.id_curso')
            ->join('personas', 'personas.numero_doc', '=', 'personas_has_cursos.Personas_numero_doc')
            ->select('programas.nombre','personas.numero_doc','personas.nombre_completo','personas.fecha_nacimiento')
            ->where('personas.Usuarios_id_usuario',$usuario->id_usuario)
            ->get();
            return $estudiantesAndCurso;
        }else
        {
            return response()
                ->json(['status' => '403', 'data' => "Error"]);
        }
    }

    public function getCursosByProfessor(Request $request)
    {
        $usuario =  Usuarios::where('correo', $request->email)->first();
        if($usuario)
        {
            $estudiantesAndCurso = DB::table('programas')
            ->join('cursos', 'cursos.Programas_id_programa', '=', 'programas.id_programa')
            ->join('personas_has_cursos', 'personas_has_cursos.Cursos_id_curso', '=', 'cursos.id_curso')
            ->join('personas', 'personas.numero_doc', '=', 'personas_has_cursos.Personas_numero_doc')
            ->select('programas.nombre','personas.numero_doc','personas.nombre_completo','personas.fecha_nacimiento')
            ->where('personas.Usuarios_id_usuario',$usuario->id_usuario)
            ->get();
            return $estudiantesAndCurso;
        }else
        {
            return response()
                ->json(['status' => '403', 'data' => "Error"]);
        }
    }
}

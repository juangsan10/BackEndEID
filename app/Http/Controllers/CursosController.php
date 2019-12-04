<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\cursos;
use App\personas_has_cursos;
use App\plan_trabajo;
use App\Usuarios;
use App\objetivos;
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
         $cursos_disponibles = DB::table('cursos')
         ->where('cursos.estado',1)         
         ->select('cursos.*')
         ->get();
         return response()
         ->json(['status' => '200', 'data' => $cursos_disponibles]);
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
        $cursos->id_detalle = $request->idDetalle;
        $cursos->estado = 1;
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
            ->select('programas.nombre','personas.numero_doc','personas.nombre_completo','personas.fecha_nacimiento','cursos.id_curso')
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
            if($usuario->Roles_id_rol==2)
            {
                $estudiantesAndCurso = DB::table('programas')
                ->join('cursos', 'cursos.Programas_id_programa', '=', 'programas.id_programa')
                ->join('personas_has_cursos', 'personas_has_cursos.Cursos_id_curso', '=', 'cursos.id_curso')
                ->join('personas', 'personas.numero_doc', '=', 'personas_has_cursos.Personas_numero_doc')
                ->select('programas.nombre','cursos.id_curso')
                ->where('personas.Usuarios_id_usuario',$usuario->id_usuario)
                ->where("personas.hv_propia",1)
                ->get();
                return response()
                ->json(['status' => '200', 'data' => $estudiantesAndCurso]);
            }else
            {
                return response()
                ->json(['status' => '502', 'data' => "No es un profesor"]);
            }
        }else
        {
            return response()
                ->json(['status' => '403', 'data' => "Error"]);
        }
    }

    public function getPlanProgramas()
    {
        return plan_trabajo::all();
    }

    // public function setPlanProgramas()
    // {

    //     $plan_trabajo
    //     fecha
    //     objetivo_general
    //     componentes
    //     actividades
    //     tiempo_duracion
    //     clase
    //     Cursos_id_curso
    //     return plan_trabajo::all();
    // }

    public function getCursosDisponibles()
    {
        $cursos_disponibles = DB::table('programas')
                ->join('cursos', 'cursos.Programas_id_programa', '=', 'programas.id_programa')
                ->join('detalle', 'detalle.id_detalle', '=', 'cursos.id_detalle')
                ->select('programas.nombre','cursos.id_curso')
                ->where('cursos.estado',1)
                ->where("programas.estado",1)
                ->where("cursos.cupos",'>',1)
                ->select('programas.nombre', 'detalle.edad_min', 'detalle.edad_max' , 'detalle.hora_min' , 'detalle.hora_max' , 'cursos.id_curso','detalle.nombre as nombre_detalle')
                ->get();
                return response()
                ->json(['status' => '200', 'data' => $cursos_disponibles]);
    }

    public function setObjetivos(Request $request)
    {
        $objetivos =  objetivos::where('Cursos_id_curso', $request->idCurso)->first();
        if($objetivos)
        {
            return response()
                ->json(['status' => '403', 'data' => "Ya existe objetivos para este curso"]);
        }else
        {
            foreach ($request->objetivos as $obje) {
                $objetivos = new objetivos;
                $objetivos->Cursos_id_curso = $request->idCurso;
                $objetivos->nombre = $obje["objetivo"];
                $objetivos->save();
            }
            return response()
                ->json(['status' => '200', 'data' => "Se han creado los objetvios correctamente"]);
        }

    }
    public function getObjetivosByCurso($id)
    {
        return $objetivos =  objetivos::where('Cursos_id_curso', $id)->get();

    }

    public function setPlanTrabajo(Request $request)
    {
        $plan_trabajo = new plan_trabajo;
        // $plan_trabajo->fecha = $request->fecha['year'].'-'.$request->fecha['month'].'-'.$request->fecha['day'];
        $plan_trabajo->objetivo_general = $request->objetivoGeneral;
        $plan_trabajo->componentes = $request->componentes;
        $plan_trabajo->actividades = $request->actividades;
        $plan_trabajo->tiempo_duracion = $request->tiempoDuracion;
        $plan_trabajo->clase = $request->clase;
        $plan_trabajo->Cursos_id_curso = $request->curso;
        $plan_trabajo->save();
        return response()
        ->json(['status' => '200', 'data' => "Se han creado el entrenamiento correctamente"]);
    }

    public function  getPlanTrabajo(Request $request)
    {
        $usuario =  Usuarios::where('correo', $request->email)->first();
        if($usuario)
        {
        $planDetrabajo = DB::table('cursos')
            ->join('programas', 'programas.id_programa', '=', 'cursos.Programas_id_programa')
            ->join('personas_has_cursos', 'personas_has_cursos.Cursos_id_curso', '=', 'cursos.id_curso')
            ->join('personas', 'personas.numero_doc', '=', 'personas_has_cursos.Personas_numero_doc')
            ->join('plan_trabajo', 'plan_trabajo.Cursos_id_curso', '=', 'cursos.id_curso')
            ->select('plan_trabajo.clase','cursos.id_curso',"programas.nombre","plan_trabajo.fecha")
            ->where('personas.Usuarios_id_usuario',$usuario->id_usuario)
            ->where("personas.hv_propia",1)
            ->get();
            return response()
            ->json(['status' => '200', 'data' => $planDetrabajo]);   
        }
    }
}
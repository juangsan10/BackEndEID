<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\personas;
use App\Usuarios;
use App\roles;
use Illuminate\Support\Facades\DB;

class ProfesoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profesores = DB::table('personas')
        ->join('usuarios', 'personas.Usuarios_id_usuario', '=', 'usuarios.id_usuario')
        ->select('personas.*')
        ->where('usuarios.Roles_id_rol','2')
        ->where('personas.hv_propia',1)
        ->get();

        return $profesores;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $profesor = new personas;
        $usuario = new Usuarios;
        $usuario->correo = $request->correo;
        $usuario->nombre = $request->nombreCompleto;
        $usuario->apellidos = $request->apellidos;
        $usuario->Roles_id_rol = 2;
        $usuario->save();
        $usuario::where("correo",$request->correo)->first();
        $profesor->Usuarios_id_usuario = $usuario->id;
        $profesor->apellidos = $request->apellidos;
        $profesor->telefono_madre = $request->celularMadre;
        $profesor->telefono_padre = $request->celularPadre;
        $profesor->correo = $request->correo;
        // $profesor = $request->direccionResidencia;
        $profesor->empresa = $request->empresa;
        $profesor->eps = $request->eps;
        $profesor->fecha_nacimiento = $request->fechaNacimiento;
        $profesor->genero = $request->genero;
        $profesor->lugarExpedicion_doc = $request->lugarExpedicionDocumento;
        $profesor->lugar_nacimiento = $request->lugarNacimiento;
        $profesor->nombre_completo = $request->nombreCompleto;
        $profesor->nombre_madre = $request->nombreMadre;
        $profesor->nombre_padre = $request->nombrePadre;
        $profesor->numero_doc = $request->numeroDocumento;
        $profesor->telefono = $request->telefono;
        $profesor->tipo_doc = $request->tipoDocumento;
        $profesor->tipo_vinsulacion = $request->tipoVinculacion;
        $profesor->save();
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


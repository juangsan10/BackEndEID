<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\personas;
use App\Usuarios;
use App\roles;
use Illuminate\Support\Facades\DB;
use Mail;

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
        $profesor->direccion_residencia = $request->direccionResidencia;
        $profesor->hv_propia = 1;
        $profesor->empresa = $request->empresa;
        $profesor->eps = $request->eps;
        $profesor->fecha_nacimiento = $request->fechaNacimiento['year'].'-'.$request->fechaNacimiento['month'].'-'.$request->fechaNacimiento['day'];
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
        $bodyMail="Se ha creado una cuenta de usuario en la plataforma Escuela de Iniciacion Deportiva 
             Para ingresar es http://localhost:4300/#/login
             Debe ingresar por la opcion, ingreso con cuenta de gmail e ingresar con su correo: ".$request->correo."";
        Mail::raw($bodyMail, function ($message) use ($request){
            $message->subject('Cuenta de Iniciacion Deportiva');
            $message->to($request->correo);
        });
        return response()
         ->json(['status' => '200', 'data' => "guardado"]);
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


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuarios;
use Illuminate\Support\Facades\DB;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $usuarios = DB::table('usuarios')
        ->join('personas', 'personas.Usuarios_id_usuario', '=', 'usuarios.id_usuario')
        ->join('roles', 'usuarios.Roles_id_rol', '=', 'roles.id_rol')
        ->select('usuarios.*','personas.nombre_completo','personas.apellidos','personas.numero_doc','roles.rol')
        ->get();
        return $usuarios;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        //verificar el token


        $usuario =  Usuarios::where('correo', $request->email)->first();
        if($usuario)
        {
            $usuario->token = $request->token;
            $usuario->id_token = $request->idToken;    
            $usuario->save();
            return response()
            ->json(['status' => '200', 'data' => $usuario->Roles_id_rol]);
        }
        $usuario = new Usuarios;
        $usuario->correo = $request->email;
        $usuario->provider = $request->provider;
        $usuario->id = $request->id;
        $usuario->nombre = $request->name ;
        $usuario->token = $request->token;
        $usuario->id_token = $request->idToken;
        $usuario->correo = $request->email;
        $usuario->Roles_id_rol = 3;


        $usuario->save();
        return response()
            ->json(['status' => '508', 'data' => $usuario->Roles_id_rol]);
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


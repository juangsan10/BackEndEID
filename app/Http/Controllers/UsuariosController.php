<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuarios;
use Illuminate\Support\Facades\DB;
use Mail;

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
        ->where('personas.hv_propia','=',1)
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

    
    public function register(Request $request)
    {
        //Crear token
        $usuario =  Usuarios::where('correo', $request->correo)->first();
        if($usuario)
        {
            return response()
            ->json(['status' => '500', 'data' => "El usuario ya existe"]);
        }
        $usuario = new Usuarios;
        $usuario->correo = $request->correo;
        $usuario->usuario = $request->correo;
        $usuario->provider = "Escuela";
        $usuario->nombre = $request->nombre ;
        $usuario->apellidos = $request->apellido;
        $usuario->password = $request->password;
        $usuario->Roles_id_rol = 3;
        $usuario->url =  base64_encode($usuario->correo.$usuario->provider.$usuario->nombre);
        $usuario->estado = 0;
        $usuario->save();

        $bodyMail="
        Para verificar su correo ingrese al siguiente link ".$usuario->url;
        Mail::raw($bodyMail, function ($message) use ($usuario){
                $message->subject('Cuenta de Iniciacion Deportiva');
                $message->to($usuario->correo);
            });

        return response()
            ->json(['status' => '200', 'data' => $this->userToStandar($usuario)]);
    }

    public function login(Request $request)
    {
        //Crear token
        $usuario =  Usuarios::where('correo', $request->usuario)->first();
        if($usuario)
        {
            if($usuario->estado == 1 )
            {
                if($usuario->password == $request->password)
                {
                    return response()
                    ->json(['status' => '200', 'data' => $this->userToStandar($usuario)]);    
                }
            }else
            {
                return response()
                ->json(['status' => '500', 'data' => "No se ha verificado el correo"]);        
            }
        }
        return response()
            ->json(['status' => '500', 'data' => "Usuario y/o contraseña incorrecta"]);
    }

    private function userToStandar($user)
    {
        $usuarioStandar = [
            'email' => $user->correo,
            'provider' => $user->provider,
            'id' => $user->id,
            'token' => $user->token,
            'idToken' => $user->id_token,
            'name' => $user->correo,
            'provider' => $user->nombre." ".$user->apellidos,
            'rol' => $user->Roles_id_rol
        ]; 
        return $usuarioStandar;

    }

    public function validateUrl($id)
    {
        $usuario =  Usuarios::where('url',$id)->update(["estado"=>1]);
        if($usuario)
        {
            return redirect('http://localhost:4200/#/login');
        }else
        {
            return "";
        }
    }
}

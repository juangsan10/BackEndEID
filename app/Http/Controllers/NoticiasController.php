<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\noticias;
use App\Usuarios;
class NoticiasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return noticias::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $noticias = new noticias;

        $usuario = Usuarios::where('correo', $request->correo)->first();
        $noticias->contenido = $request->contenido;
        $noticias->subtitulo = $request->subtitulo;
        $noticias->tema = $request->tema;
        $noticias->titutlo = $request->titulo;
        $noticias->Usuarios_id_usuario = $usuario->id_usuario;
        $noticias->save();
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


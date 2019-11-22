<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/contenedor', function () {
    return view('contenedor');
});

Route::group(['prefix' => 'auth'], function () {
    Route::get('/{provider}', 'Auth\LoginController@redirectToProvider');
    Route::get('/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
});

Route::get('/prueba', 'PersonasController@prueba' );
Route::resource('/guardar', 'PersonasController' );
Route::get('/programas/getdetalle/{id}', 'ProgramasController@getDetalleByPrograma');

Route::resource('/programas', 'ProgramasController' );


Route::apiResource('/profesores', 'ProfesoresController' );
Route::apiResource('/usuario', 'UsuariosController' );
Route::apiResource('/cursos', 'CursosController' );

Route::get('/cursos/cursosdisponibles', 'CursosController@getCursosDisponibles' );

Route::post('/cursouser', 'CursosController@getCursosByUser' );
Route::post('/cursoprofesor', 'CursosController@getCursosByProfessor');




Route::apiResource('/noticias', 'NoticiasController' );
Route::apiResource('/estudiantes', 'EstudiantesController' );
Route::post('/estudiantes/estudentbyid', 'EstudiantesController@getEstudentById' );
Route::post('/estudiantes/storeguardian', 'EstudiantesController@storeGuardianAsStudent' );
Route::get('/estudiantes/estudentbycurso/{id}', 'EstudiantesController@getEstudentByCurso' );
Route::post('/estudiantes/asistenciabystudent/', 'EstudiantesController@asistenciaByStudent');


Route::post('/documentos/{id}', 'EstudiantesController@storeDocuments' );
Route::get('/documentos/{id}', 'EstudiantesController@getDocuments' );




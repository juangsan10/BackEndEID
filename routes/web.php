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
Route::get('/programas/getdetalleprograma/{id}', 'ProgramasController@getObjetivosByPrograma');



Route::resource('/programas', 'ProgramasController' );


Route::apiResource('/profesores', 'ProfesoresController' );
Route::apiResource('/usuario', 'UsuariosController' );
Route::post('/usuario/login', 'UsuariosController@login' );
Route::post('/usuario/register', 'UsuariosController@register' );
Route::get('/usuario/validateurl/{id}', 'UsuariosController@validateUrl' );
Route::post('/usuario/update', 'UsuariosController@updateUser' );
Route::post('/usuario/delete', 'UsuariosController@deleteUser' );


Route::apiResource('/cursos', 'CursosController' );

Route::get('/cursosdisponibles', 'CursosController@getCursosDisponibles' );

Route::post('/cursouser', 'CursosController@getCursosByUser' );
Route::post('/cursoprofesor', 'CursosController@getCursosByProfessor');
Route::post('cursos/saveobjetivos', 'CursosController@setObjetivos');
Route::get('cursos/getobjetivos/{id}', 'CursosController@getObjetivosByCurso');
Route::post('cursos/setplantrabajo', 'CursosController@setPlanTrabajo');
Route::post('cursos/getplantrabajo', 'CursosController@getPlanTrabajo');


Route::apiResource('/noticias', 'NoticiasController' );
Route::apiResource('/estudiantes', 'EstudiantesController' );
Route::post('/estudiantes/estudentbyid', 'EstudiantesController@getEstudentById' );
Route::post('/estudiantes/storeguardian', 'EstudiantesController@storeGuardianAsStudent' );
Route::get('/estudiantes/estudentbycurso/{id}', 'EstudiantesController@getEstudentByCurso' );
Route::post('/estudiantes/asistenciabystudent/', 'EstudiantesController@asistenciaByStudent');
Route::post('/estudiantes/getasistenciabystudent', 'EstudiantesController@getAsistencia');

Route::post('/estudiantes/setcalificacionbystudent/', 'EstudiantesController@setCalificacionByStudent');
Route::post('/estudiantes/getcalificacionbystudent', 'EstudiantesController@getCalificacionByStudent');


Route::post('/documentos/{id}', 'EstudiantesController@storeDocuments' );
Route::get('/documentos/{id}', 'EstudiantesController@getDocuments' );





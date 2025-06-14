<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CentroController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FichajeController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\PermisosController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\TareasController;
use App\Http\Controllers\NotificacionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('main');
});

//rutas para la creación del primer centro productivo y la asociación con los usuarios.
Route::get('/main-register', [CentroController::class,"centroPrincipal"]);
Route::post('/centro-Principal', [CentroController::class,"storePrincipal"])->name('centro-principal');
Route::get('/empleado-Usuario', [EmpleadoController::class,"createPrincipal"])->name('empleado-usuario');
Route::post('/empleado-Usuario', [EmpleadoController::class,"storePrincipal"])->name('empleado-usuario');


Route::get('/centro-Asociar-Usuario', [CentroController::class,"showUserCentro"])->name('centro-asociar-usuario');
Route::put('/centro-Asociar-Usuario', [UserController::class,"updateUserCentro"])->name('centro-asociar-usuario');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',

//grupo de rutas solo accesibles tras la autentificación    
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    //rutas para la gestion de los roles
    Route::get('/edit/rol/user/{id}', [PermisosController::class,"rolEditUser"])->name('rol.edit-user.edit');
    Route::post('/edit/rol/user', [PermisosController::class,"rolUpdateUser"])->name('rol.edit-user.update');

    //rutas para la gestion de los centros productivos
    Route::resource('/centro', CentroController::class);
    Route::get('/centro-auth', [CentroController::class,"showAuth"])->name('user.centro.showAuth');
    Route::get('/centro/nombre/filtrar', [CentroController::class,"showFiltrar"])->name('centro.filtrar.show');
    Route::post('/centro/nombre/filtrar', [CentroController::class,"indexFiltrar"])->name('centro.filtrar.index');
    //rutas para la gestion de los usuarios
    Route::resource('/usuario', UserController::class);
    Route::get('/usuario/cambiarCentro/{id}', [UserController::class,"editUserCenter"])->name('user.centro.edit');
    Route::post('/usuario/cambiarCentro', [UserController::class,"updateUserCenter"])->name('user.centro.update');
    Route::get('/usuario/nombre/filtrar', [UserController::class,"showFiltrar"])->name('usuario.filtrar.show');
    Route::post('/usuario/nombre/filtrar', [UserController::class,"indexFiltrar"])->name('usuario.filtrar.index');

    //rutas para la gestion de los proyectos
    Route::resource('/proyecto', ProyectoController::class);
    Route::get('/proyecto/intranet/docs/{id}', [ProyectoController::class,"showDocs"])->name('proyecto.intranet.show');
    Route::get('/proyecto/incluir/empleados/{id}', [ProyectoController::class,"editProyectoEmpleado"])->name('proyecto.empleados.edit');
    Route::get('/proyecto/empleados/{id}', [ProyectoController::class,"showProyectoEmpleado"])->name('proyecto.empleados.show');
    Route::get('/proyecto/evento/empleados/{id}', [ProyectoController::class,"createEvent"])->name('proyecto.evento.empleados.create');
    Route::post('/proyecto/evento/empleados', [ProyectoController::class,"storeEvent"])->name('proyecto.evento.empleados.store');
    Route::post('/proyecto/empleados/{id_proyecto}/{id_empleado}', [ProyectoController::class,"storeProyectoEmpleado"])->name('proyecto.empleados.store');
    Route::delete('/proyecto/empleados/{id_proyecto}/{id_empleado}', [ProyectoController::class,"destroyProyectoEmpleado"])->name('proyecto.empleados.destroy');
    Route::get('/proyectos/filtrar/estado/{estado}', [ProyectoController::class,"indexFiltrarEstado"])->name('proyectos.filtrar.estados');
    Route::get('/proyectos/filtrar', [ProyectoController::class,"showFiltrar"])->name('proyectos.filtrar.show');
    Route::post('/proyectos/filtrar', [ProyectoController::class,"indexFiltrar"])->name('proyectos.filtrar.index');

    //rutas para la gestion de los fichajes
    Route::resource('/fichaje', FichajeController::class);
    Route::get('/fichar', [FichajeController::class,"fichar"])->name('fichaje.fichar');
    Route::get('/terminar-fichar', [FichajeController::class,"terminarFichar"])->name('fichaje.terminarFichar');
    Route::get('/fichaje-print', [FichajeController::class,"indexPrint"])->name('fichaje.indexPrint');
    Route::post('/fichaje-print', [FichajeController::class,"storePrint"])->name('fichaje.storePrint');
    Route::get('/fichajes/filtrar', [FichajeController::class,"showFiltrar"])->name('fichajes.filtrar.show');
    Route::post('/fichajes/filtrar', [FichajeController::class,"indexFiltrar"])->name('fichajes.filtrar.index');
    Route::get('/fichajes/filtrar/mes/{mes}', [FichajeController::class,"indexFiltrarMes"])->name('fichajes.filtrar.mes');

    //rutas para la gestion de los empleados
    Route::resource('/empleado',EmpleadoController::class);
    Route::get('/empleado-auth', [EmpleadoController::class,"showAuth"])->name('empleado.showAuth');
    Route::get('/empleado/intranet/docs', [EmpleadoController::class,"showDocs"])->name('empleado.intranet.show');
    Route::get('/empleado/nombre/filtrar', [EmpleadoController::class,"showFiltrar"])->name('empleado.filtrar.show');
    Route::post('/empleado/nombre/filtrar', [EmpleadoController::class,"indexFiltrar"])->name('empleado.filtrar.index');

    //rutas para la gestion de los eventos
    Route::resource('/evento',EventoController::class);
    Route::get('/evento/empleado/create/{id}', [EventoController::class,"create"])->name('evento.empleado.create');


   //rutas para gestionar archivos con seguridad
    Route::get('/descargar/archivo/{id}', [ArchivoController::class,"descargaArchivoEmpleado"])
    ->name('descarga.archivo.empleado');

    Route::get('/ver/manual-usuario', [ArchivoController::class,"verManualUsuario"])
    ->name('ver.manual.usuario');


    Route::get('/ver/archivo/{id}', [ArchivoController::class,"verArchivoEmpleado"])
    ->name('ver.archivo.empleado');

    Route::get('/descargar/archivo/proyecto/{id}', [ArchivoController::class,"descargaArchivoProyecto"])
    ->name('descarga.archivo.proyecto');

    Route::get('/ver/archivo/proyecto/{id}', [ArchivoController::class,"verArchivoProyecto"])
    ->name('ver.archivo.proyecto');

    //rutas para gestionar las tareas
    Route::resource('/tareas', TareasController::class);
    Route::get('/tareas/estado/{estado}', [TareasController::class,"indexEstado"])->name('tareas.indexEstado');
    Route::get('/tareas/nombre/filtrar', [TareasController::class,"showFiltrar"])->name('tareas.filtrar.show');
    Route::post('/tareas/nombre/filtrar', [TareasController::class,"indexFiltrar"])->name('tareas.filtrar.index');

    //rutas para gestionar las notificaciones
    Route::resource('/notificacion', NotificacionController::class);
    Route::get('/notificacion-enviadas', [NotificacionController::class,"indexSend"])->name('notificacion.indexSend');
    Route::get('/notificacion-eliminadas', [NotificacionController::class,"indexDel"])->name('notificacion.indexDel');
    Route::post('/notificacion/vaciar-papelera', [NotificacionController::class,"destroyAll"])->name('notificacion.vaciar.papelera');
    Route::get('/notificacion/filtrar/{estado}', [NotificacionController::class,"indexEstado"])->name('notificacion.filtrar.estado');
    Route::get('/notificaciones/filtrar/{tipo}', [NotificacionController::class,"showFiltrar"])->name('notificacion.filtrar.show');
    Route::post('/notificaciones/filtrar', [NotificacionController::class,"indexFiltrar"])->name('notificacion.filtrar.index');
    Route::put('/notificacion/recuperar/{id_notificacion}', [NotificacionController::class,"updateRecuperar"])->name('notificacion.updateRecuperar');
    Route::put('/notificacion/eliminar/{id_notificacion}', [NotificacionController::class,"updateDelete"])->name('notificacion.updateDelete');
    Route::get('/notificacion-nueva', [NotificacionController::class,"indexNumNoLeidas"])->name('notificacion.nueva.index');
    Route::get('/notificacion/marcar/leidas', [NotificacionController::class,"updateMarcarLeido"])->name('notificacion.marcar.leidas');


});

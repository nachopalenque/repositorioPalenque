<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Evento;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\PermisosController;

class TareasController extends Controller
{

    public function index()
    {
        try{
                session()->forget('tareas_nombre');

                $tareas = DB::table('eventos')
                ->where('eventos.id_empleado', auth()->user()->empleado->id)
                ->join('proyectos', 'eventos.id_proyecto', '=', 'proyectos.id')
                ->select(
                    'eventos.id',
                    'proyectos.nombre',
                    'eventos.titulo',
                    'eventos.observaciones',
                    'eventos.fecha_inicio',
                    'eventos.fecha_fin',
                    'eventos.estado_evento'
          
                )
                ->orderBy('eventos.id', 'desc')
                ->groupBy(
                    'eventos.id',
                    'proyectos.nombre',
                    'eventos.titulo',
                    'eventos.observaciones',
                    'eventos.fecha_inicio',
                    'eventos.fecha_fin',
                    'eventos.estado_evento'
             
                )
                ->paginate(10);

            return view('Tareas.index', [ 'estadoSeleccionado' => null,'tareas' => $tareas]);

        }catch(Exception $e){

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


      public function indexFiltrar(Request $request)
    {
        try{
                session()->forget('tareas_nombre');

                $tareas = DB::table('eventos')
                ->where('eventos.id_empleado', auth()->user()->empleado->id)
                ->where('eventos.titulo', 'like', "%{$request->input('nombre')}%")
                ->join('proyectos', 'eventos.id_proyecto', '=', 'proyectos.id')
                ->select(
                    'eventos.id',
                    'proyectos.nombre',
                    'eventos.titulo',
                    'eventos.observaciones',
                    'eventos.fecha_inicio',
                    'eventos.fecha_fin',
                    'eventos.estado_evento'
          
                )
                ->groupBy(
                    'eventos.id',
                    'proyectos.nombre',
                    'eventos.titulo',
                    'eventos.observaciones',
                    'eventos.fecha_inicio',
                    'eventos.fecha_fin',
                    'eventos.estado_evento'
             
                )
                ->paginate(10);

            session()->flash('tareas_nombre', $request->input('nombre'));
            
            return view('Tareas.index', [ 'estadoSeleccionado' => null,'tareas' => $tareas]);

        }catch(Exception $e){

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



      public function indexEstado($estado)
    {
        try{
                if($estado =='Todas'){

                    $tareas = DB::table('eventos')
                ->where('eventos.id_empleado', auth()->user()->empleado->id)
                ->join('proyectos', 'eventos.id_proyecto', '=', 'proyectos.id')
                ->select(
                    'eventos.id',
                    'proyectos.nombre',
                    'eventos.titulo',
                    'eventos.observaciones',
                    'eventos.fecha_inicio',
                    'eventos.fecha_fin',
                    'eventos.estado_evento'
          
                )
                ->groupBy(
                    'eventos.id',
                    'proyectos.nombre',
                    'eventos.titulo',
                    'eventos.observaciones',
                    'eventos.fecha_inicio',
                    'eventos.fecha_fin',
                    'eventos.estado_evento'
             
                )
                ->paginate(10);




                }else{
                    $tareas = DB::table('eventos')
                ->where('eventos.estado_evento', $estado)
                ->where('eventos.id_empleado', auth()->user()->empleado->id)
                ->join('proyectos', 'eventos.id_proyecto', '=', 'proyectos.id')
                ->select(
                    'eventos.id',
                    'proyectos.nombre',
                    'eventos.titulo',
                    'eventos.observaciones',
                    'eventos.fecha_inicio',
                    'eventos.fecha_fin',
                    'eventos.estado_evento'
          
                )
                ->groupBy(
                    'eventos.id',
                    'proyectos.nombre',
                    'eventos.titulo',
                    'eventos.observaciones',
                    'eventos.fecha_inicio',
                    'eventos.fecha_fin',
                    'eventos.estado_evento'
             
                )
                ->paginate(10);

                }
                
            return view('Tareas.index', ['estadoSeleccionado'=> $estado,'tareas' => $tareas]);

        }catch(Exception $e){

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

     public function show($id)
    {
        try{

                 if(PermisosController::authAdmin()){


                         $tareas = DB::table('eventos')
                            ->where('eventos.id_empleado', $id)
                            ->join('proyectos', 'eventos.id_proyecto', '=', 'proyectos.id')
                            ->select(
                                'eventos.id',
                                'proyectos.nombre',
                                'eventos.titulo',
                                'eventos.observaciones',
                                'eventos.fecha_inicio',
                                'eventos.fecha_fin',
                                'eventos.estado_evento'
                    
                            )
                            ->groupBy(
                                'eventos.id',
                                'proyectos.nombre',
                                'eventos.titulo',
                                'eventos.observaciones',
                                'eventos.fecha_inicio',
                                'eventos.fecha_fin',
                                'eventos.estado_evento'
                        
                            )
                            ->get();

                        return view('Tareas.show', ['tareas' => $tareas]);

                }else{

                    if($this->esTareaEmpAuth($id)){
                        
                          $tareas = DB::table('eventos')
                            ->where('eventos.id_empleado', $id)
                            ->join('proyectos', 'eventos.id_proyecto', '=', 'proyectos.id')
                            ->select(
                                'eventos.id',
                                'proyectos.nombre',
                                'eventos.titulo',
                                'eventos.observaciones',
                                'eventos.fecha_inicio',
                                'eventos.fecha_fin',
                                'eventos.estado_evento'
                    
                            )
                            ->groupBy(
                                'eventos.id',
                                'proyectos.nombre',
                                'eventos.titulo',
                                'eventos.observaciones',
                                'eventos.fecha_inicio',
                                'eventos.fecha_fin',
                                'eventos.estado_evento'
                        
                            )
                            ->get();

                        return view('Tareas.show', ['tareas' => $tareas]);



                    }else{
                        return view('Mensaje.advertencia', ['titulo' => 'Operación no disponible', 'mensaje' => 'Estas tareas no pertenecen al empleado autentificado. Pongase en contacto con su administrador.']);
                    }                   

                }
           

        }catch(Exception $e){

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

       public function showFiltrar()
    {
        try{
            return view('Tareas.show-filter');

        }catch(Exepcion $e){
        
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function edit($id)
    {
        try{

        return view('Tareas.edit', ['id_evento'=> $id]);

        }catch(Exception $e){

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try{

            $evento = Evento::find($request->input('id_evento'));
            $evento->estado_evento = $request->input('estado_evento');
            $evento->save();

            if($evento->id_proyecto != null){

                EventoController::createNotificacionEvent('evento_empleado_tarea_actualizacion', $evento);
            }
            session()->flash('estado', 'actualizado');
            return redirect()->route('tareas.index');

        }catch(Exception $e){

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function esTareaEmpAuth($id_empleado){

        try{

            if(auth()->user()->empleado->id == $id_empleado){
                return true;
            }else{
                return false;
            }

        }catch(Exception $e){
        
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}

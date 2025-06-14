<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva tarea proyecto</title>
</head>
<body>
<div class="card">
              <div class="card-header">
                <h3 class="card-title">Rellene los datos para crear una nueva tarea del proyecto</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('proyecto.evento.empleados.store') }}" enctype="multipart/form-data">
              @csrf

              <input type="text" name="id_proyecto" value="{{$id}}" hidden="true">
              <div class="card-body">

                <div class="row">

                    <div class="col">

                    <x-adminlte-input type="text" name="titulo" label="Titulo de la tarea" placeholder="Ingrese el titulo de la tarea"  label-class="text-lightblue" value="{{ old('nombre') }}" >
            
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-heading text-lightblue"></i>
                        </div>
                    </x-slot>
                    
                    </x-adminlte-input>

                    </div>

                    <div class="col">
                        <div class="form-group ">
                            <label class="text-lightblue">Empleados del proyecto</label>
                         <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-users text-lightblue"></i></span>
                            <select name="empleado" class="form-control text-dark" id="estilo">
                            
                            @foreach ($empleados as $empleado)
                                <option value="{{ $empleado->id }}">{{ $empleado->nombre . " " . $empleado->apellidos }}</option>
                            @endforeach
                          
                            </select>
                         </div>

                        </div>
                    </div>

                    

                </div>

        




                <div class="row">
            
                    <div class="col">


                                   
                        <x-adminlte-input type="date" name="fecha_inicio" label="Fecha de Inicio" label-class="text-lightblue" value="{{ old('fecha_inicio') }}">
                
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-lg fa-calendar-alt text-lightblue"></i>
                                </div>
                            </x-slot>
                            
                        </x-adminlte-input>
            
                    </div>
   
                   


                   

               

          
                    <div class="col">

                
                        <x-adminlte-input type="date" name="fecha_fin" label="Fecha de Fin" label-class="text-lightblue" value="{{ old('fecha_fin') }}">
                    
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-lg fa-calendar-alt text-lightblue"></i>
                                </div>
                            </x-slot>
                            
                        </x-adminlte-input>


                   
                    </div>

                </div>


                 <div class="row">
       

          
                    <div class="col">

                        <x-adminlte-textarea name="observaciones" label="Descripción de la tarea" rows=3 label-class="text-lightblue"
                            igroup-size="sm" placeholder="Escriba una descripción de la tarea" text="{{ old('observaciones') }}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                     <i class="fas fa-pencil-alt text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-textarea>

                    </div>


                </div>

                <div class="row">
       

                    
                    <div class="col">


                        <x-adminlte-input type="file" name="adjunto" label="Adjuntar archivo" label-class="text-lightblue" value="{{ old('adjunto') }}">
                        
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-lg fa-file text-lightblue"></i>
                                </div>
                            </x-slot>
                        
                         </x-adminlte-input>


                    </div>


                 </div>




                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                <x-adminlte-button class="btn-flat" type="submit" label="Crear Tarea" theme="success" icon="fas fa-lg fa-save"/>

                </div>
              </form>
</div>
</body>
</html>
@extends('adminlte::page')

@section('title', 'Centro Productivo')

@section('content_header')
    <h1>Centro Productivo</h1>
@stop

@section('content')
    <div class="card">
              <div class="card-header">
                <h3 class="card-title">Datos centro productivo</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form>
                  <div class="row">

                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" value="{{$centro->nombre}}" disabled="">
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Razón Social</label>
                        <input type="text" class="form-control" value="{{$centro->razon_social}}" disabled="">
                      </div>
                    </div>
         
                  </div>

                  <div class="row">

                     <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>CIF</label>
                            <input type="text" class="form-control" value="{{$centro->CIF}}" disabled="">
                        </div>

                     </div>
                        

                      <div class="col-sm-6">
                      <!-- text input -->
                        <div class="form-group">
                            <label>Provincia</label>
                            <input type="text" class="form-control" value="{{$centro->provincia}}" disabled="">
                        </div>

                     </div>





                    </div>


                    <div class="row">


                        <div class="col-sm-6">
                        <!-- text input -->
                            <div class="form-group">
                                <label>Localidad</label>
                                <input type="text" class="form-control" value="{{$centro->localidad}}" disabled="">
                            </div>

                        </div>


                        <div class="col-sm-6">
                        <!-- textarea -->
                            <div class="form-group">
                            <label>País</label>
                            <input type="text" class="form-control" value="{{$centro->pais}}" disabled="">


                            </div>
                            
                        </div>





                    </div>




                    <div class="row">


                     

                        <div class="col-sm-6">
                        <!-- textarea -->
                            <div class="form-group">
                                <label>Dirección</label>
                                <textarea class="form-control" rows="3"  disabled="">{{$centro->direccion}}</textarea>


                            </div>
                            
                        </div>





                    </div>


                    <x-adminlte-button class="btn-flat" type="button" label="Volver a la ficha del empleado" theme="info" icon="fas fa-lg fa-arrow-left"  onclick="window.location.href = '{{ route('empleado.showAuth') }}'"/>



                  </div>


@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
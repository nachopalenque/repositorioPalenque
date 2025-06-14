@extends('adminlte::page')

@section('title', 'Calendario del Empleado')

@section('content_header')
    <h1>Mi calendario</h1>
    <hr>
@stop

@section('content')
    
<div class="card">




    <div class="modal fade" id="modalValidaciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog justify-content-center modal-sm modal-md modal-lg modal-xl " role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Nuevo Evento</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">


                    @include('Evento.create')


                 

                    </div>
                    <div class="modal-footer">
                      <button type="button" id="btnCerrarModal" class="btn btn-danger" data-dismiss="modal" >Cancelar</button>
                    </div>
                  </div>
                </div>
    </div>



        
    

            <div class="card-header">
                Seleccione el día

                <div class="card-tools">
                    <x-adminlte-button class="btn-sm btn-flat  m-1" type="button" label="Nuevo evento" theme="outline-success" icon="fa fa-plus mr-1" data-toggle="modal" data-target="#modalValidaciones"/>

                  
                </div>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col md-8">

                    <div id='calendar'></div>

                    </div>


                </div>


            </div>


            </div>


        </div>






</div>


  

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}

@stop



@push('js')
<!--   aquí cargo el cdn de fullcalendar -->
<script src="{{ asset('js/cdnfullcalendar.js') }}"></script>
<script src="{{ asset('js/fullcalendarlocal-es.js') }}"></script>
<!--   aquí lo que hago es que me muestre el modal de nuevo si hay errores de validación -->

@if ($errors->any())


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const modalElement = document.getElementById('modalValidaciones');
            const modal = new bootstrap.Modal(modalElement);
            modal.show();

            document.addEventListener('click', function (e) {
                 if (e.target.closest('#btnCerrarModal')) {
                    location.reload(true);
                }
            })


              let estado = @json(session('estado'));
      

      var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          events: @json($eventos_calendar),
          locale:"es", 
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
          }

        });
        calendar.render();

        switch(estado){

          case 'creado':
            mensajeConfirmacionNuevoElemento();
            break;
          
          case 'actualizado':
            mensajeConfirmacionActualizacionElemento();
            break;
            
          case 'eliminado':
            mensajeConfirmacionEliminado();
            break;
        }

        

        });
    </script>

@else

<script>


    document.addEventListener('DOMContentLoaded', function() {
      //en la variable creado mediante la directiva de blade json almaceno el valor de la variable de sesion estado en formato json
      let estado = @json(session('estado'));
      

      var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          events: @json($eventos_calendar),
          locale:"es", 
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
          }

        });
        calendar.render();

        switch(estado){

          case 'creado':
            mensajeConfirmacionNuevoElemento();
            break;
          
          case 'actualizado':
            mensajeConfirmacionActualizacionElemento();
            break;
            
          case 'eliminado':
            mensajeConfirmacionEliminado();
            break;
        }
      });



</script>




@endif



@endpush
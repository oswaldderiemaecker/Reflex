@extends('backend.app')

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Modulo Tareas
            <small>Lista de tareas o turno (AM / PM)</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">
                <i class="fa fa-sun-o"></i> Tareas
            </li>
        </ol>
    </section>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-sun-o"></i> Lista de Tareas</h3>
                    {!! $filter !!}
                    <a href="/backend/tareas?export=1" class="btn btn-default">Exportar</a>
                </div>
                <div class="box-body">
                    {!! $grid !!}
                </div>
            </div>
        </div>
    </div>
   @stop
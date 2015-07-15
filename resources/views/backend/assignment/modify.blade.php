@extends('backend.app')

@section('header')
        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Modulo Asignaciones
        <small>Lista de usuarios asignados a zonas por ciclo.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">
            <a href="{{ url('/backend/asignaciones') }}"><i class="fa fa-user-plus"></i> Asignaciones</a>
        </li>
        <li class="active">
            <i class="fa fa-edit"></i> Editar
        </li>
    </ol>
</section>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-user-plus"></i> Editar Asignación</h3>
                </div>
                <div class="box-body">
                    {!! $edit !!}
                </div>
            </div>
        </div>
    </div>
@stop
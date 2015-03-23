@extends('backend.app')

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Modulo Unidad de Negocio
            <small>Lista de unidades de negocios o Divisiones</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">
                <a href="{{ url('/backend/unidad_de_negocios') }}"><i class="fa fa-list"></i> Unidad de Negocio</a>
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
                    <h3 class="box-title"><i class="fa fa-list"></i> Editar Unidad de Negocio</h3>
                </div>
                <div class="box-body">
                    {!! $edit !!}
                </div>
            </div>
        </div>
    </div>
@stop
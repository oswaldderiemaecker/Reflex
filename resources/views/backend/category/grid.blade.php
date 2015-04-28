@extends('backend.app')

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Modulo Categorias
            <small>Lista de categorias de la empresa</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">
                <i class="fa fa-tags"></i> Categorias
            </li>
        </ol>
    </section>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-tags"></i> Lista de Categorias</h3>
                    {!! $filter !!}
                    <a href="/backend/categorias?export=1" class="btn btn-default">Exportar</a>
                </div>
                <div class="box-body">
                    {!! $grid !!}
                </div>
            </div>
        </div>
    </div>
   @stop
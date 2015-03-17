@extends('app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Empresas <small>Lista de empresas, solo visibles para el administrador</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i> Dashboard
                </li>
                <li class="active">
                    <i class="fa fa-bar-chart-o"></i> Empresas
                </li>
            </ol>
        </div>
    </div>

        {!! $filter !!}
        {!! $grid !!}

@stop
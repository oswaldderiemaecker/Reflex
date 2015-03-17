@extends('app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Paises <small>Lista de paises, solo visible para el perfil administrador.</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i> Dashboard
                </li>
                <li class="active">
                    <i class="fa fa-bar-chart-o"></i> Paises
                </li>
            </ol>
        </div>
    </div>

        {!! $filter !!}
        {!! $grid !!}

@stop
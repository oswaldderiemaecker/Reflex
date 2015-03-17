@extends('app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Zonas <small>Lista de zonas geograficas compuesta por localidad, definido por unidad organica</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i> Dashboard
                </li>
                <li class="active">
                    <i class="fa fa-bar-chart-o"></i> Zonas
                </li>
            </ol>
        </div>
    </div>
        {!! $filter !!}
        {!! $grid !!}

@stop
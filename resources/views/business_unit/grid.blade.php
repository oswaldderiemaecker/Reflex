@extends('app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Unidades de Negocios <small>Lista de unidades de negocios o Divisiones</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i> Dashboard
                </li>
                <li class="active">
                    <i class="fa fa-bar-chart-o"></i> Unidades de Negocio
                </li>
            </ol>
        </div>
    </div>

    {!! $filter !!}
    {!! $grid !!}
@stop
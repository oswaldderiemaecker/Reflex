@extends('backend.app')

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $businessUnit->name }} <small>Unidad de Negocio</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">
                <i class="fa fa-bar-chart-o"></i> {{ $businessUnit->name }}
            </li>
        </ol>
    </section>
@stop

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="fa fa-info-circle"></i>
                <strong>Bienvenido a Reflex 360º?</strong>
                Esta es una version de prueba, sientete libre de realizar los cambios que sean necesarios.
            </div>
        </div>
    </div>

    <!-- /.row -->
    <div class="row">
        @foreach($subBusinessUnits as $subBusinessUnit)
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ count($subBusinessUnit->users) }}<sup style="font-size: 20px">%</sup></h3>
                        <p>{{ $subBusinessUnit->name }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>

                </div>
            </div><!-- ./col -->

        @endforeach


    </div>

    <div class="row">
        <section class="content-header">
            <h1>
                Usuarios <small>Unidad de Negocio</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
                <li class="active">
                    <i class="fa fa-bar-chart-o"></i> {{ $businessUnit->name }}
                </li>
                <li><i class="fa fa-users"></i> Usuarios</li>
            </ol>
        </section>
    </div>

    <div class="row">
        @foreach($subBusinessUnits as $subBusinessUnit)
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-users fa-fw"></i>Usuarios {{ $subBusinessUnit->name }}</h3>
                </div>
                <div class="panel-body">
                    <div class="list-group">
                        @foreach($subBusinessUnit->users as $user)
                        <a href="#" class="list-group-item">
                            <span class="badge">{{ $user->role->code }}</span>
                            <i class="fa fa-fw fa-user"></i> {{ $user->firstname.' '.$user->lastname }}
                        </a>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <!-- /.row -->

@endsection

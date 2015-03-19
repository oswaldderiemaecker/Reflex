@extends('app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                {{ $businessUnit->name }} <small>Unidad de Negocio</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>
                    <a href="{{ url('/') }}">Dashboard</a>
                </li>
                <li class="active">
                    <i class="fa fa-bar-chart-o"></i> {{ $businessUnit->name }}
                </li>
            </ol>
        </div>
    </div>

    <!-- /.row -->
    <div class="row">
        @foreach($subBusinessUnits as $subBusinessUnit)
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-shopping-cart fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{ count($subBusinessUnit->users) }}</div>
                                <div>{{ $subBusinessUnit->name }}</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">Detalle</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>

            </div>
        @endforeach


    </div>

    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>
                    <a href="{{ url('/') }}">Dashboard</a>
                </li>
                <li>
                    <i class="fa fa-bar-chart-o"></i> {{ $businessUnit->name }}
                </li>
                <li class="active">
                    <i class="fa fa-bar-chart-o"></i> Usuarios
                </li>
            </ol>
        </div>
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

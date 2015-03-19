@extends('app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Panel de Control <small>{{ $company->name.' - '.$company->country->name  }}</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> Dashboard
                </li>
            </ol>
        </div>
    </div>

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
        @foreach($businessUnits as $businessUnit)
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-shopping-cart fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ count($businessUnit->sub_business_units) }}</div>
                            <div>{{ $businessUnit->name }}</div>
                        </div>
                    </div>
                </div>
                <a href="{{ url('/sub_unidades?business_unit_id='.$businessUnit->id) }}">
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
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Doctores por Categoría</h3>
                </div>
                <div class="panel-body">
                    <div id="morris-donut-client-category"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Doctores por Turno</h3>
                </div>
                <div class="panel-body">
                    <div id="morris-donut-client-place"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Tipo Clientes</h3>
                </div>
                <div class="panel-body">
                    <div id="morris-donut-client-type"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Doctores por Especialidad</h3>
                </div>
                <div class="panel-body">
                    <div id="morris-bar-chart"></div>
                    <div class="text-right">
                        <a href="#">View Details <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-header">
        <h1>Procesos</h1>
    </div>
    <p>
        <a href="{{ url('/inicio_de_ciclo') }}" class="btn btn-lg btn-success" onclick="return confirm('Estar Seguro?')">
            Inicio de Ciclo</a>

        <button type="button" class="btn btn-lg btn-danger" onclick="alert('Proximamente!')")>Cierre de Ciclo</button>
    </p>

@endsection

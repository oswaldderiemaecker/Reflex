@extends('frontend.app')


@section('includes.js')
    @parent
    <script>
        $(document).ready(function() {

            var jsonData = $.getJSON("/frontend/visit_status", function(json) {
                console.log(json); // show the info in console

                Morris.Donut({
                    element: 'morris-donut-visit-status',
                    data: json,
                    resize: true
                });
            });

        });

        var jsonData = $.getJSON("/frontend/client_specialty", function(json) {
            console.log(json); // show the info in console

            // Bar Chart
            Morris.Bar({
                element: 'morris-bar-user-chart',
                data: json,
                xkey: 'label',
                ykeys: ['value'],
                labels: ['# Doctores'],
                barRatio: 0.4,
                xLabelAngle: 35,
                hideHover: 'auto',
                resize: true
            });

        });

        var jsonData = $.getJSON("/frontend/category_report", function(json) {
            console.log(json); // show the info in console

            Morris.Donut({
                element: 'morris-donut-client-category',
                data: json,
                resize: true
            });
        });

        var jsonData = $.getJSON("/frontend/place_report", function(json) {
            console.log(json); // show the info in console

            Morris.Donut({
                element: 'morris-donut-client-place',
                data: json,
                resize: true
            });
        });

        var jsonData = $.getJSON("/frontend/client_type_report", function(json) {
            console.log(json); // show the info in console

            Morris.Donut({
                element: 'morris-donut-client-type',
                data: json,
                resize: true
            });
        });


    </script>
@stop

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>{{ $company->name.' - '.$company->country->name  }}</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Inicio
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

    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $counters['coverage'] }}<sup style="font-size: 20px">%</sup></h3>
                    <p>Cobertura</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ url('frontend/visitas') }}" class="small-box-footer">Mas Info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $counters['visits'] }}</h3>
                    <p>Visitas</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ url('frontend/visitas') }}" class="small-box-footer">Mas Info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $counters['targets'] }}</h3>
                    <p>Doctores</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ url('frontend/target') }}" class="small-box-footer">Mas Info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $counters['absences'] }}</h3>
                    <p>Ausencias</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{ url('frontend/visitas') }}" class="small-box-footer">Mas Info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
    </div><!-- /.row -->



    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Visitas</h3>
                </div>
                <div class="panel-body">
                    <div id="morris-donut-visit-status"></div>
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

        <div class='col-lg-8'>
            <!-- USERS LIST -->
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Ultimos Doctores Visitados</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                    <ul class="users-list clearfix">
                        @foreach ($last_visits as $visit)
                        <li>
                            <img src='/pictures/{{ $visit->client->code }}.jpg'  class='img-circle' style='width: 80px; height: 90px;' />
                            <a class="users-list-name" href="{{ url('frontend/target/'.$visit->target_id) }}">{{ $visit->client->closeup_name }}</a>
                            <span class="users-list-date">{{ Carbon::createFromFormat('Y-m-d H:i:s',$visit->start)->diffForHumans() }}</span>
                        </li>
                        @endforeach

                    </ul><!-- /.users-list -->
                </div><!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="{{ url('frontend/target') }}" class="uppercase">Ver todos</a>
                </div><!-- /.box-footer -->
            </div><!--/.box -->
        </div><!-- /.col -->

    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Doctores por Especialidad</h3>
                </div>
                <div class="panel-body">
                    <div id="morris-bar-user-chart"></div>
                </div>
            </div>
        </div>
    </div>


@endsection

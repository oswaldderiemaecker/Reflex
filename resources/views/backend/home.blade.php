@extends('backend.app')

@section('includes.js')
    @parent
<script>
    // Morris.js Charts sample data for SB Admin template

    $(document).ready(function() {

        var jsonData = $.getJSON("/backend/category_report", function(json) {
            console.log(json); // show the info in console

            Morris.Donut({
                element: 'morris-donut-client-category',
                data: json,
                resize: true
            });
        });

        var jsonData = $.getJSON("/backend/place_report", function(json) {
            console.log(json); // show the info in console

            Morris.Donut({
                element: 'morris-donut-client-place',
                data: json,
                resize: true
            });
        });

        var jsonData = $.getJSON("/backend/client_type_report", function(json) {
            console.log(json); // show the info in console

            Morris.Donut({
                element: 'morris-donut-client-type',
                data: json,
                resize: true
            });
        });

        var jsonData = $.getJSON("/backend/client_specialty", function(json) {
            console.log(json); // show the info in console

            // Bar Chart
            Morris.Bar({
                element: 'morris-bar-chart',
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
    });

</script>
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
        @foreach($businessUnits as $businessUnit)
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ count($businessUnit->sub_business_units) }}<sup style="font-size: 20px">%</sup></h3>
                        <p>{{ $businessUnit->name }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ url('/backend/sub_unidades?business_unit_id='.$businessUnit->id) }}" class="small-box-footer">
                        Detalle <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->

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



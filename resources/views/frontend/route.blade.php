@extends('frontend.app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Rutas <small>Lista completo del mes</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Dashboard</a>
                </li>
                <li class="active">
                    <i class="fa fa-dashboard"></i> Target Médico
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

    </div>
@endsection

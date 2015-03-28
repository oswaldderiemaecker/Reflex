@extends('frontend.app')


@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $visit->client->closeup_name }}
            <small>Visita</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="{{ url('/frontend/visitas') }}"><i class="fa fa-medkit"></i> Visitas</a></li>
            <li class="active">
                <i class="fa fa-user-md"></i> {{ $visit->client->closeup_name }}
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
        <!-- left column -->
        <div class="col-md-3">
            <div class="text-center">
                <img src="/pictures/{{ substr($visit->client->code,-5) }}.jpg" class="avatar img-circle" alt="avatar"/>
                <p>{{ $visit->client->closeup_name }}</p>
                <p>cmp: {{ $visit->client->code }}</p>
                <p>{{ $visit->client->specialty_base->name }}</p>

            </div>
        </div>

        <!-- edit form column -->
        <div class="col-md-9 personal-info">

            <h3>Datos Personales</h3>

            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-lg-3 control-label">Nombres:</label>
                    <div class="col-lg-8">
                     <p class="form-control">{{ $visit->client->closeup_name }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Institución:</label>
                    <div class="col-lg-8">
                        <p class="form-control">{{ $visit->client->institution }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Dirección:</label>
                    <div class="col-lg-8">
                        <p class="form-control">{{ $visit->client->address.' - '.$visit->client->location->name }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Email:</label>
                    <div class="col-lg-8">
                        <p class="form-control">{{ $visit->client->email }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Fecha Visita:</label>
                    <div class="col-lg-8">
                        <p class="form-control">{{ $visit->start }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Supervisado:</label>
                    <div class="col-lg-8">
                        <p class="form-control">{{ ($visit->is_supervised == '1')?'Si':'No' }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Comentario:</label>
                    <div class="col-md-8">
                        <p class="form-control">{{ $visit->description }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Lugar de Visita</label>
                    <div class="col-md-8">
                        <img src="{{ sprintf("http://maps.googleapis.com/maps/api/staticmap?center=%s,%s&zoom=14&size=350x200&maptype=roadmap&markers=color:blue|label:%s|%s,%s&sensor=false",
                                        $visit->latitude,$visit->longitude,
                                        $visit->client->category->code,
                                        $visit->latitude,$visit->longitude) }}" />

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        <input type="button" class="btn btn-primary" value="Eliminar">
                        <span></span>
                        <a href="{{ url('/frontend/visitas') }}" class="btn btn-default">Regresar
                            </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

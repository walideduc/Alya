@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h3>Choisissez votre transpoteur</h3>
            <div class="panel-group">
                @foreach($transporters as $transporter)
                    <div class="panel panel-info">
                        <div class="panel-heading">Panel with panel-info class</div>
                        <div class="panel-body">Panel Content</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    </div>
@endsection

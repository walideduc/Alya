@extends('layouts.master')
@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="center-block login-form">
        <div class="panel panel-default">
            <div class="panel-heading">Login Form</div>
            <div class="panel-body">
                <form role="form" method="POST" action="{{url('auth/login')}}" >
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <div class="input-group login-input">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="email">
                        </div>
                        <br>
                        <div class="input-group login-input">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control" name="password" value="{{old('password')}}" placeholder="Password">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"> Remember me
                            </label>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary pull-right"><i class="fa fa-long-arrow-right"></i> Login</button>
                        <button type="button" class="btn btn-xs btn-primary btn-login-social"><i class="fa fa-facebook"></i></button>
                        <button type="button" class="btn btn-xs btn-info btn-login-social"><i class="fa fa-twitter"></i></button>
                        <button type="button" class="btn btn-xs btn-danger btn-login-social"><i class="fa fa-google-plus"></i></button>
                        <hr>
                        <a href="register" class="btn btn-success btn-sm pull-right">Register</a>
                        <a href="#" class="btn btn-warning btn-sm">Forgotten Password</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection




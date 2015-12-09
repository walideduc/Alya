@extends('layouts.default')
@section('content')
    <div class="col-lg-8 col-md-8 col-sm-8">
        <div class="white-container">
            <span class="title">REGISTER</span>
            <p>Lorem ipsum Ex aliqua tempor nisi laboris dolor id laborum irure minim tempor in sit dolore amet sit esse nostrud tempor nulla consequat aute in nostrud laboris sint ullamco amet nisi pariatur officia nulla pariatur in id et labore dolore ad sit.</p>

            <!-- Form Register -->
            <form action="">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label for="first_name">First Name (*)</label>
                    <input type="text" class="form-control" id="first_name"><br clear="all"/>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label for="last_name">Last Name (*)</label>
                    <input type="text" class="form-control" id="last_name"><br clear="all"/>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label for="email">Email (*)</label>
                    <input type="text" class="form-control" id="email"><br clear="all"/>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label for="username">Username (*)</label>
                    <input type="text" class="form-control" id="username"><br clear="all"/>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label for="password">Password (*)</label>
                    <input type="password" class="form-control" id="password"><br clear="all"/>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label for="confirm_password">Confirm Password (*)</label>
                    <input type="password" class="form-control" id="confirm_password"><br clear="all"/>
                </div>
                <div class="clearfix"></div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox"> I agree with <a href="#">Terms and Conditions.</a>
                    </label>
                </div>
                <button class="btn btn-danger">Register</button>
            </form>
            <!-- End Form Register -->
        </div>

    </div>

    <div class="col-lg-4 col-md-4 col-sm-4">

        <!-- Login Form -->
        <div class="white-container">
            <span class="title">ALREADY REGISTERED ?</span>
            <form role="form">
                <div class="form-group">
                    <div class="input-group login-input">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" placeholder="Username">
                    </div>
                    <br>
                    <div class="input-group login-input">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input type="password" class="form-control" placeholder="Password">
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
                </div>
            </form>
        </div>
        <!-- End Login Form -->

    </div>
@endsection




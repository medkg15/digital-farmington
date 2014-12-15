@extends('layout')

@section('content')
    <div class="admin">
        {{ Form::open(array('url' => 'login')) }}
            <h1>Login</h1>

            <!-- if there are login errors, show them here -->
            <p>
                {{ $errors->first('email') }}
                {{ $errors->first('password') }}
            </p>

            <div class="form-group">
                {{ Form::label('email', 'Email Address') }}
                {{ Form::text('email', Input::old('email'), array('placeholder' => 'address@domain.com', 'class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('password', 'Password') }}
                {{ Form::password('password', array('class' => 'form-control')) }}
            </div>

            <p>{{ Form::submit('Log In', array('class' => 'btn btn-primary')) }}</p>
        {{ Form::close() }}
    </div>
@stop
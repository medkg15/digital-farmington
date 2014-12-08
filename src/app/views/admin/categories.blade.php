@extends('layout')

@section('content')

{{ View::make('admin.header'); }}

<h1>Rename Categories</h1>

        {{ Form::open(['action' => 'CategoryController@save']) }}

    <table class="table table-border table-condensed">

    <thead>
    <tr>
    <th>Current Name</th>
    <th>New Name</th>
    </tr>
    </thead>

    <tbody>
@foreach($categories as $category)

    <tr>
    <td>{{ Form::text('existing[]', $category->label, array('readonly', 'class' => 'form-control')) }}</td>
    <td>{{ Form::text('new[]', $category->label, [ 'class' => 'form-control' ]) }}</td>
    </tr>

@endforeach

    </tbody>

    </table>



    {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}

    {{ Form::close(); }}

@stop

@section('scripts')
@stop
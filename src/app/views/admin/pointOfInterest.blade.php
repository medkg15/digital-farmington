@extends('layout')

@section('content')
{{ View::make('admin.header'); }}
    <h1>Manage Point of Interest</h1>
    @if(isset($poi))
        {{ Form::model($poi, ['action' => ['PointOfInterestController@save', 'id'=>$poi->id], 'method' => 'post']) }}
    @else
        {{ Form::open(['action' => 'PointOfInterestController@save']) }}
    @endif


    <div class="row">
    <div class="col-md-8">

            <div class="form-group">
                {{Form::label('name', 'Name')}}
                {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}

            </div>

            <div class="form-group">
                {{Form::label('description', 'Description')}}
                {{ Form::textarea('description', Input::old('description'), array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{Form::label('latitude', 'Latitude')}}
                {{ Form::text('latitude', Input::old('latitude') ? Input::old('latitude') : Input::get('latitude'), array('class' => 'form-control')) }}

            </div>

            <div class="form-group">
                {{Form::label('longitude', 'Longitude')}}
                {{ Form::text('longitude', Input::old('longitude') ? Input::old('longitude') :  Input::get('longitude'), array('class' => 'form-control')) }}
            </div>

            <div class="checkbox">
              <label>
                {{Form::checkbox('display', 'true', true)}}
                Show On Map?
              </label>
            </div>
    </div>
    <div class="col-md-4">

        <h3>Map Years</h3>

        @foreach($eras as $era)
            <div class="checkbox">
              <label>

                {{print_r(in_array($era->id, array()) == true);}}

              </label>
            </div>
        @endforeach

        </div>
    </div>


        {{ Form::submit('Save', ['name' => 'submit']) }}

    {{ Form::close() }}
@stop

@section('scripts')
@stop
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
                    {{Form::checkbox('display', '1', true)}}
                    Show On Map?
                  </label>
                </div>
        </div>
        <div class="col-md-4">

            <h3>Map Years</h3>

            @foreach($eras as $era)
                <div class="checkbox">
                  <label>

                    {{Form::checkbox('era[]', $era->id, $poi && $poi->eras && in_array($era->id, array_map(function($era){ return $era['id']; }, $poi->eras->toArray())))}}
                    {{$era->label}}

                  </label>
                </div>
            @endforeach

            <h3>Categories</h3>

            @foreach($categories as $category)
                <div class="checkbox">
                  <label>

                    {{Form::checkbox('category[]', $category->id, $poi && $poi->categories && in_array($category->id, array_map(function($category){ return $category['id']; }, $poi->categories->toArray())))}}
                    {{$category->label}}

                  </label>
                </div>
            @endforeach
            <div id="add-wrapper"><input type="text" name="new_category"/><button id="add">Add</button></div>

        </div>
    </div>


        {{ Form::submit('Save', ['name' => 'submit']) }}

    {{ Form::close() }}
@stop

@section('scripts')
<script type="text/javascript">

require(['common'], function(){
    require(['jquery'], function($){
        $('#add').click(function(e){
            e.preventDefault();
            var newCategory = $('[name=new_category]').val();

            if(newCategory && $('input[value=' + newCategory + ']').length === 0)
            {
                $('#add-wrapper').before('<div class="checkbox"><label><input type="checkbox" name="category_new[]" checked value="'+ newCategory +'"/>'+newCategory+'</label></div>');
            }
        });
    });
});
</script>
@stop
@extends('layout')

@section('content')
<h1>Point of Interest Database</h1>
    <table class="table table-border table-condensed">

    <thead>
    <tr>
    <th>Name</th>
    <th>Categories</th>
    <th>Show On Map?</th>
    </tr>
    </thead>

    <tbody>
    @foreach($pois as $poi)

        <tr>
        <td>{{ link_to_action('PointOfInterestController@showEdit', $poi->name, array('id' => $poi->id)) }}</td>
        <td>@foreach($poi->categories as $category){{$category}}<br/>@endforeach</td>
        <td>{{ $poi->display ? 'Yes' : 'No'  }}</td>
        </tr>

    @endforeach

    </tbody>

    </table>


@stop

@section('scripts')
@stop
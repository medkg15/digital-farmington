@extends('layout')

@section('content')
{{ View::make('admin.header'); }}
<h1>Point of Interest Database</h1><div id="pois">
<input class="search form-control" placeholder="Search" />
    <table class="table table-border table-condensed" >

    <thead>
    <tr>
    <th><a class="sort" data-sort="name">Name</a></th>
    <th><a class="sort" data-sort="categories">Categories</a></th>
    <th><a class="sort" data-sort="display">Show On Map?</a></th>
    </tr>
    </thead>

    <tbody class="list">
    @foreach($pois as $poi)

        <tr>
        <td class="name">{{ link_to_action('PointOfInterestController@showEdit', $poi->name, array('id' => $poi->id)) }}</td>
        <td class="categories">@foreach($poi->categories as $category){{$category}}<br/>@endforeach</td>
        <td class="display">{{ $poi->display ? 'Yes' : 'No'  }}</td>
        </tr>

    @endforeach

    </tbody>

    </table>

</div>

@stop

@section('scripts')
    <script type="text/javascript">
        require(['common'], function (common) {
            require(['list'], function(List){
                var list = new List('pois', {
                    valueNames: [ 'name', 'categories', 'display' ]
                });
            });
        });
    </script>
@stop
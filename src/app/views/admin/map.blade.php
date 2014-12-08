@extends('layout')

@section('content')
{{ View::make('admin.header'); }}

    <p>Click the map to add a Point of Interest, or an existing Point of Interest to modify it.</p>
    <div class="row">
        <!-- sidecenter -->
        <div id="sidecenter">
            <div id="map">
            </div>
            <div id="selectyear">
                <img src="/images/selectaYear.png" alt="Select a Year" />
                <div class="slide-container">
                    <input name="era" type="text" />
                </div>
                  <div style="margin: 0 0 0 10px;">
                    @foreach($eras as $era)

                        <button class="btn" style="width:{{ floor(100 / count($eras)-1) }}%;">{{ $era }}</button>

                    @endforeach
                </div>
            </div>
        </div>
        <!--/ sidecenter -->
        <!-- sideright -->
        <div id="sideright">
                        <h3>
                            <img src="images/filterCategories.png" alt="Filter Categories" />
                        </h3>
                        @foreach($categories as $category)
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="categories" value="{{$category->label}}" checked/><img src="http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|{{$category->color}}" style="height:20px;"/>&nbsp;{{ $category->label }}
                                </label>
                            </div>
                        @endforeach
                </div>
        <!--/ sideright -->
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        require(['common'], function (common) {
            require(['map'], function(map){
                   var eras = {{ json_encode($eras) }};

                    var pois = {{ json_encode($pois) }};

                    var colors = {{ json_encode($colors) }};

                    map.initialize(eras, pois, function(e){

                        if(confirm('Create a new Point of Interest?'))
                        {
                            window.location = '/admin/poi?latitude='+e.latLng.lat()+'&longitude='+e.latLng.lng()
                        }
                    }, function(poi){
                        if(confirm('Edit ' + poi.name + '?'))
                        {
                            window.location = '/admin/poi/' + poi.id;
                        }
                    }, colors);
            });
        });
    </script>
@stop
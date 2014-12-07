@extends('layout')

@section('content')
    <div class="row">
        <!-- sidecenter -->
        <div id="sidecenter">
            <div id="map">
            </div>
            <div id="selectyear">
                <img src="images/selectaYear.png" alt="Select a Year" />
                <input name="era" type="text" />
            </div>
        </div>
        <!--/ sidecenter -->
        <!-- sideright -->
        <div id="sideright">
            <div class="col-md-3">
                <h3>
                    <img src="images/filterCategories.png" alt="Filter Categories" />
                </h3>
                 @foreach($categories as $category)
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="categories" value="{{$category->label}}"
                                   checked/> {{ $category->label }}
                        </label>
                    </div>
                @endforeach
            </div>
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

                    map.initialize(eras, pois);
            });
        });
    </script>
@stop
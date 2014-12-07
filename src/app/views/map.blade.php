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

    <!-- clear --><div class="clearer"><span></span></div><!--/ clear -->
    <!-- main-text-draw1 -->
    <div id="main-text-draw1">

        <img src="images/historicMaps.jpg" alt="Historical Maps" style="margin-left:0px; margin-top:0px; position:relative; border:0px;" />

        <div class="row">
            <div class="col-md-2">

                <p class="titleNameMap">Name Map1 <p />
                <img src="images/titlecaret.png" alt="" width="12" height="6" style="margin-left: 3px; margin-top: -10px; position: absolute;" />

                <a class="thumbnail" data-toggle="modal" data-target="#myModal">
                    <img src="images/1800sCT213x157.jpg" alt="Historical Maps" width="350" height="150" />
                </a>
            </div>
            <div class="col-md-2">
                <p class="titleNameMap">Name Map2 <p />
                <img src="images/titlecaret.png" alt="" width="12" height="6" style="margin-left:3px; margin-top:-10px; position:absolute;" />

                <a class="thumbnail" data-toggle="modal" data-target="#myModal">
                    <img src="images/1800sCT213x157.jpg" alt="Historical Maps" width="350" height="150" />
                </a>
            </div>
            <div class="col-md-2">
                <p class="titleNameMap">Name Map3 <p />
                <img src="images/titlecaret.png" alt="" width="12" height="6" style="margin-left:3px; margin-top:-10px; position:absolute;" />

                <a class="thumbnail" data-toggle="modal" data-target="#myModal">
                    <img src="images/1800sCT213x157.jpg" alt="Historical Maps" width="350" height="1" />
                </a>
            </div>
            <div class="col-md-2">
                <p class="titleNameMap">Name Map4 <p />
                <img src="images/titlecaret.png" alt="" width="12" height="6" style="margin-left:3px; margin-top:-10px; position:absolute;" />

                <a class="thumbnail" data-toggle="modal" data-target="#myModal">
                    <img src="images/1800sCT213x157.jpg" alt="Historical Maps" width="350" height="1" />
                </a>
            </div>
            <div class="col-md-2">
                <p class="titleNameMap">Name Map5 <p />
                <img src="images/titlecaret.png" alt="" width="12" height="6" style="margin-left:3px; margin-top:-10px; position:absolute;" />

                <a class="thumbnail" data-toggle="modal" data-target="#myModal">
                    <img src="images/1800sCT213x157.jpg" alt="Historical Maps" width="350" height="1" />
                </a>
            </div>
            <div class="col-md-2">
                <p class="titleNameMap">
                    Name Map6
                    </p>
                    <img src="images/titlecaret.png" alt="" width="12" height="6" style="margin-left:3px; margin-top:-10px; position:absolute;">
                    <a class="thumbnail" data-toggle="modal" data-target="#myMod">
                        <img src="images/1800sCT213x157.jpg" alt="Historical Maps" width="350" />
                    </a>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        require(['common'], function (common) {
            require(['map'], function(map){

                var eras = {{ json_encode($eras) }};

                var pois = {{ json_encode($pois) }};

                map.initialize(eras, pois);
                map.startIntro();
            });
        });
    </script>
@stop
@extends('layout')

@section('content')
<!--/ content1 -->
	  <div id="content1">
	  
    <div class="row">
        <!-- sidecenter -->
        <div id="sidecenter">
            <div id="map">
            </div>
            <div id="selectyear">
                <img src="images/selectaYear.png" alt="Select a Year" />
                 <div class="slide-container">
                    <input name="era" type="text" />
                </div>
                <div style="margin: 0 0 0 10px;">
                    @foreach($eras as $era)

                        <button class="btn" style="width:{{ floor(100 / count($eras)-1) }}%;">{{ $era }}</button>

                    @endforeach
                </div>
            </div>
			<div id= "intro">
		        <img src="images/Introduction.png" alt="Introduction" />
		        <p style="color:black;"><button id="intro">View an introduction map</button> </p>
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
	
<!--/ content1 -->		
 </div>	
	
    <!-- clear --><div class="clearer"><span></span></div><!--/ clear -->
    <!-- main-text-draw1 -->
    <div id="main-text-draw1">
	<img src="images/historicMaps.jpg" alt="Historical Maps" style="margin-left:0px; margin-top:0px; position:relative; border:0px;" />

	    <!-- mapsframe -->
		<div id="mapsframe">
         <div class="row">
        
            <div class="col-md-2">
                <p class="titleNameMap">Colonies of CT  &amp;<br/> RI <p />
                <img src="images/titlecaret.png" alt="" width="12" height="6" style="margin-left:3px; margin-top:-10px; position:absolute;" />

                <a class="thumbnail" data-toggle="modal" data-target="#popup-1">
                    <img src="images/historic/thumb-1.jpg" alt="Historical Maps" width="350" height="150" />
                </a>
            </div>
            <div class="col-md-2">
                <p class="titleNameMap">Birds-Eye View of Unionville <p />
                <img src="images/titlecaret.png" alt="" width="12" height="6" style="margin-left:3px; margin-top:-10px; position:absolute;" />

                <a class="thumbnail" data-toggle="modal" data-target="#popup-2">
                    <img src="images/historic/thumb-2.jpg" alt="Historical Maps" width="350" height="150" />
                </a>
            </div>
            <div class="col-md-2">
                <p class="titleNameMap">New York City and Vicinity<p />
                <img src="images/titlecaret.png" alt="" width="12" height="6" style="margin-left:3px; margin-top:-10px; position:absolute;" />

                <a class="thumbnail" data-toggle="modal" data-target="#popup-3">
                    <img src="images/historic/thumb-3.jpg" alt="Historical Maps" width="350" height="1" />
                </a>
            </div>
            <div class="col-md-2">
                <p class="titleNameMap">Town and City Atlas of CT <p />
                <img src="images/titlecaret.png" alt="" width="12" height="6" style="margin-left:3px; margin-top:-10px; position:absolute;" />

                <a class="thumbnail" data-toggle="modal" data-target="#popup-4">
                    <img src="images/historic/thumb-4.jpg" alt="Historical Maps" width="350" height="1" />
                </a>
            </div>
            <div class="col-md-2">
                <p class="titleNameMap">Novi Belgii Novaeque Angliae <p />
                <img src="images/titlecaret.png" alt="" width="12" height="6" style="margin-left:3px; margin-top:-10px; position:absolute;" />

                <a class="thumbnail" data-toggle="modal" data-target="#popup-5">
                    <img src="images/historic/thumb-5.jpg" alt="Historical Maps" width="350" height="1" />
                </a>
            </div>
       </div>
    </div>
	 </div>

    {{ View::make('maps.popup-1'); }}
    {{ View::make('maps.popup-2'); }}
    {{ View::make('maps.popup-3'); }}
    {{ View::make('maps.popup-4'); }}
    {{ View::make('maps.popup-5'); }}
    {{ View::make('poi-detail'); }}
@stop

@section('scripts')
    <script type="text/javascript">
        require(['common'], function (common) {
            require(['map'], function(map){

                var eras = {{ json_encode($eras) }};

                var pois = {{ json_encode($pois) }};

                var colors = {{ json_encode($colors) }};

                map.initialize(eras, pois, null, null, colors);

                $('#intro').click(function(){
                    map.startIntro();
                });
            });
        });
    </script>
@stop
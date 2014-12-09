@extends('layout')

@section('content')
<!--/ content1 -->
	  <div id="content1">
	  
    <div class="row">
        <!-- sidecenter -->
        <div id="sidecenter">
            <div id="map">
            </div>

			<div id= "intro">
		        <p style="margin-top:5px;"><button class="btn btn-primary btn-block">View Introduction</button> </p>
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

                $('#intro button').click(function(e){
                    e.preventDefault();
                    map.startIntro();
                    $('#intro').remove();
                });
            });
        });
    </script>

    <script charset="utf-8" type="text/javascript">var switchTo5x = false;</script>
    <script charset="utf-8" type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
    <script type="text/javascript">stLight.options({ publisher: "22ff76a7-01e5-4ac8-98d7-8b175f44c98f" });</script>
    <script charset="utf-8" type="text/javascript" src="http://s.sharethis.com/loader.js"></script>
    <script charset="utf-8" type="text/javascript">var options = { publisher: "22ff76a7-01e5-4ac8-98d7-8b175f44c98f", "position": "left", "chicklets": { "items": ["facebook", "twitter", "linkedin"] } }; var st_hover_widget = new sharethis.widgets.hoverbuttons(options);</script>

@stop
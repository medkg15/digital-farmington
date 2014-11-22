<?php
require_once(dirname(__FILE__) . '/includes/data_access.php');
$data_access = new DataAccess();
$eras = $data_access->get_eras();
$categories = $data_access->get_categories();
?>


<!DOCTYPE html>
<html>
<head>
    <link href="/css/main.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container">

    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">

            <div class="navbar-header">
                <a class="navbar-brand" href="#" data-bind="click: returnHome">Digital Farmington</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <div class="row">
        <div class="col-md-9">

            <div id="map">

            </div>

            <div>

                <h2>Select a Year</h2>

                <input name="era" type="text"/>

            </div>

        </div>
        <div class="col-md-3">

            <h3>Filter Categories</h3>
            <?php foreach ($categories as $category): ?>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="categories" value="<?php echo $category['label']; ?>"
                               checked/> <?php echo $category['label']; ?>
                    </label>
                </div>
            <?php endforeach; ?>

        </div>
    </div>

    <h2>Historic Maps</h2>

    <div class="row">
        <div class="col-md-2">
            <a class="thumbnail" data-toggle="modal" data-target="#myModal">
                <img src="http://placehold.it/350x150" alt="...">
            </a>
        </div>
        <div class="col-md-2">
            <a class="thumbnail" data-toggle="modal" data-target="#myModal">
                <img src="http://placehold.it/350x150" alt="...">
            </a>
        </div>
        <div class="col-md-2">
            <a class="thumbnail" data-toggle="modal" data-target="#myModal">
                <img src="http://placehold.it/350x150" alt="...">
            </a>
        </div>
        <div class="col-md-2">
            <a class="thumbnail" data-toggle="modal" data-target="#myModal">
                <img src="http://placehold.it/350x150" alt="...">
            </a>
        </div>
        <div class="col-md-2">
            <a class="thumbnail" data-toggle="modal" data-target="#myModal">
                <img src="http://placehold.it/350x150" alt="...">
            </a>
        </div>
        <div class="col-md-2">
            <a class="thumbnail" data-toggle="modal" data-target="#myModal">
                <img src="http://placehold.it/350x150" alt="...">
            </a>
        </div>
    </div>

    <?php include "historic-map-modal.php"; ?>
    <?php include "poi-detail-modal.php"; ?>

</div>
<!-- /.container -->
<script type="text/javascript" src="/vendor/requirejs/require.js"></script>
<script type="text/javascript">
requirejs.config({
    baseUrl: "<?php echo (strpos($_SERVER["HTTP_HOST"], 'amazonaws.com') !== false) ? '/js-built' : '/js'; ?>"
});
require(['common'], function (common) {
    require(
        ['bootstrap', 'jquery', 'underscore', 'async!http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyD0K-y2C9IH2lUf6_kOt8Dvd9TOlZq7sqk', '1640', '1800', '1840', '1880', 'maplabel', 'bootstrap-slider', 'yearJumpLookup'],
        function (bootstrap, $, _, googleMaps, boundaries1640, boundaries1800, boundaries1840, boundaries1880, MapLabel, bootstrapSlider, yearJumpLookup) {

            var mapOptions = {
                center: {lat: 41.7321983, lng: -72.8352574},
                zoom: 10,
				minZoom: 5
            };
            var map = new google.maps.Map(document.getElementById('map'),
                mapOptions);

            // Setting allowed bounds. Roughly the state of CT.
            var allowedBounds = new google.maps.LatLngBounds(
                new google.maps.LatLng(41.066501, -73.628673),
                new google.maps.LatLng(41.984272, -71.877879)
            );
            var lastValidCenter = map.getCenter();
            google.maps.event.addListener(map, 'center_changed', function () {
                if (allowedBounds.contains(map.getCenter())) {
                    // still within valid bounds, so save the last valid position
                    lastValidCenter = map.getCenter();
                    return;
                }
                // not valid anymore => return to last valid position
                map.panTo(lastValidCenter);
            });

            var allYears = _.map(<?php echo json_encode(array_map(function($era){
                return $era['label'];
            },$eras)); ?>, function(year){
                return parseInt(year, 10);
            });
            var selectedYear = <?php echo $eras[0]['label']; ?>;
            var markers = [];

            var boundaries = null;

            var titleInfoWindow = new google.maps.InfoWindow({});
            var summaryInfoWindow = new google.maps.InfoWindow({});
            var currentSummaryMarker = null;
            var pois = [];

            var updatePOIs = function () {

                var selectedCategories = $('input[name=categories]:checked').map(function () {
                    return $(this).val();
                }).get();

                var currentPOIs = _.filter(pois, function(poi){
                    var forSelectedEra = _.some(poi.eras, function(era){
                        return era.label == selectedYear
                    });

                    var poiCategories = _.map(poi.categories, function(category){
                        return category.label;
                    });

                    var forSelectedCategories = _.intersection(poiCategories, selectedCategories).length > 0;
                    return forSelectedEra && forSelectedCategories;
                });

                for (var i in markers) {
                    markers[i].setMap(null);
                }
                markers = [];

                for (var index in currentPOIs) {

                    (function () {
                        var poi = currentPOIs[index];
                        var marker = new google.maps.Marker({
                            position: new google.maps.LatLng(poi.latitude, poi.longitude),
                            map: map,
                            poi: poi,
                            titleInfoWindow: null,
                            summaryInfoWindow: null
                        });

                        google.maps.event.addListener(marker, 'mouseover', function () {
                            if (marker === currentSummaryMarker) {
                                return;
                            }

                            titleInfoWindow.setContent('<div class="scrollFix"><h4>' + poi.name + '</h4></div>');
                            titleInfoWindow.open(map, this);
                        });

                        google.maps.event.addListener(marker, 'mouseout', function () {
                            titleInfoWindow.close();
                        });

                        google.maps.event.addListener(marker, 'click', function () {
                            summaryInfoWindow.setContent('<h3>' + poi.name + "</h3>" + poi.description + '<p><a href="#" id="learn-more">Learn More</a></p>');
                            summaryInfoWindow.open(map, this);
                            currentSummaryMarker = marker;
                            titleInfoWindow.close();
                        });
                        markers.push(marker);
                    })();
                }
            };

            var getBoundariesForYear = function (year) {
                var availableBoundaries = [
                    {year: 1640, boundaries: boundaries1640},
                    {year: 1800, boundaries: boundaries1800},
                    {year: 1840, boundaries: boundaries1840},
                    {year: 1880, boundaries: boundaries1880}
                ];

                var index = 0;

                while (index + 1 < availableBoundaries.length && availableBoundaries[index + 1].year < year) {
                    index++;
                }

                return availableBoundaries[index].boundaries;

            };

            var drawBoundaries = function () {

                // first clear the boundaries if we have any.
                if (boundaries) {
                    boundaries.setMap(null);
                }

                var latExtent = 86;
                var lngExtent = 180;
                var lngExtent2 = lngExtent - 1e-10;
                var everythingElse = [
                    new google.maps.LatLng(-latExtent, 0), // right bottom 8
                    new google.maps.LatLng(latExtent, 0), // right top 7
                    new google.maps.LatLng(latExtent, -lngExtent), // left top 6
                    new google.maps.LatLng(-latExtent, -lngExtent), // left bottom 5
                    new google.maps.LatLng(-latExtent, 0), // left bottom 4
                    new google.maps.LatLng(latExtent, 0), // left top 3
                    new google.maps.LatLng(latExtent, lngExtent2), // right top 2
                    new google.maps.LatLng(-latExtent, lngExtent2) // right bottom 1
                ];


                var currentBoundaries = _.map(getBoundariesForYear(selectedYear), function (vertex) {
                    return new google.maps.LatLng(vertex.latitude, vertex.longitude);
                });

                boundaries = new google.maps.Polygon({
                    paths: [everythingElse, currentBoundaries],
                    strokeColor: "#000000",
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: "#000000",
                    fillOpacity: 0.5,
                    map: map
                });

                return boundaries;
            };

			
			//START INTRO CODE
			//Displays Welcome to Digital Farmington on the map
			//We need to create all our labels (text on the map) up front. Otherwise they can't be set as null in the Timeout functions
			
			var welcomeText = new MapLabel({
                text: 'Welcome to Digital Farmington',
                position: new google.maps.LatLng(41.870669, -72.824893),
                map: map,
                minZoom: 10,
				maxZoom: 10,
                fontSize: 21,
                fontColor: '#ff0000',
                align: 'center'
            });
			
			var exploreText = new MapLabel({
					text: 'Explore Historic Sites',
					position: new google.maps.LatLng(41.739977, -72.851171),
					map: map,
					fontSize: 31,
					fontColor: '#ff0000',
					minZoom: 14,
					maxZoom: 17,
					align: 'center'
				});
			exploreText.setMap(null);
			
			var colonialText = new MapLabel({
					text: 'From Colonial America',
					position: new google.maps.LatLng(47.934014, -74.733103),
					map: map,
					minZoom: 3,
					maxZoom: 11,
					fontSize: 29,
					fontColor: '#ff0000',
					align: 'center'
			}); 
			colonialText.setMap(null);
			
			var eighteenText = new MapLabel({
					text: 'To the 1800s',
					position: new google.maps.LatLng(42.099942, -72.774755),
					map: map,
					minZoom: 3,
					maxZoom: 15,
					fontSize: 34,
					fontColor: '#ff0000',
					align: 'center'
			}); 
			eighteenText.setMap(null);
			
			var todayText = new MapLabel({
				text: 'To Today',
				position: new google.maps.LatLng(41.7349, -72.791163),
				map: map,
				fontSize: 47,
				minZoom: 15,
				fontColor: '#ff0000',
				align: 'center'
			}); 
			todayText.setMap(null);
			
			var boundaryText = new MapLabel({
				text: 'See Borders Change',
				position: new google.maps.LatLng(41.890669, -72.824893),
				map: map,
				fontSize: 29,
				maxZoom: 16,
				fontColor: '#ff0000',
				align: 'center'
			}); 
			boundaryText.setMap(null);
			
			var comeGoText = new MapLabel({
				text: 'And Sites Come and Go',
				position: new google.maps.LatLng(41.728, -72.824690),
				map: map,
				fontSize: 27,
				fontColor: '#ff0000',
				minZoom: 15,
				maxZoom: 17,
				align: 'center'
			}); 
			comeGoText.setMap(null);
			
			var enjoyText = new MapLabel({
				text: 'Enjoy!',
				position: new google.maps.LatLng(41.890669, -72.824893),
				map: map,
				fontSize: 35,
				fontColor: '#ff0000',
				minZoom: 8,
				maxZoom: 11,
				align: 'center'
			}); 
			enjoyText.setMap(null);
			
			//CODE FOR COLONIAL MAP OVERLAY
			MapOverlay.prototype = new google.maps.OverlayView();
			
			// Initialize the map and the custom overlay.
			var swBound = new google.maps.LatLng(31.530507, -84.936474);
			var neBound = new google.maps.LatLng(46.573332, -67.872547);
			var bounds = new google.maps.LatLngBounds(swBound, neBound);
			var swBound2 = new google.maps.LatLng(40.988926, -73.658322);
			var neBound2 = new google.maps.LatLng(42.029617, -71.779317);
			var bounds2 = new google.maps.LatLngBounds(swBound2, neBound2);
			
			// The photograph
			var srcImage = '/images/Colonies_1763.jpg';
			var srcImage2= '/images/1800sCT.jpg';
							
			overlay = new MapOverlay(bounds, srcImage, map);
			overlay.setMap(null);
						
			/** @constructor */
			function MapOverlay(bounds, image, map) {

				this.bounds_ = bounds;
				this.image_ = image;
				this.map_ = map;
				this.div_ = null;
				this.setMap(map);
			}

			/**
			* onAdd is called when the map's panes are ready and the overlay has been
			* added to the map.
			*/
			MapOverlay.prototype.onAdd = function() {
				var div = document.createElement('div');
				div.style.borderStyle = 'none';
				div.style.borderWidth = '0px';
				div.style.position = 'absolute';
				var img = document.createElement('img');
				img.src = this.image_;
				img.style.width = '100%';
				img.style.height = '100%';
				img.style.position = 'absolute';
				div.appendChild(img);
				this.div_ = div;
				var panes = this.getPanes();
				panes.overlayLayer.appendChild(div);
				};

			MapOverlay.prototype.draw = function() {
				var overlayProjection = this.getProjection();
				var sw = overlayProjection.fromLatLngToDivPixel(this.bounds_.getSouthWest());
				var ne = overlayProjection.fromLatLngToDivPixel(this.bounds_.getNorthEast());
				var div = this.div_;
				div.style.left = sw.x + 'px';
				div.style.top = ne.y + 'px';
				div.style.width = (ne.x - sw.x) + 'px';
				div.style.height = (sw.y - ne.y) + 'px';
			};

			MapOverlay.prototype.onRemove = function() {
				this.div_.parentNode.removeChild(this.div_);
				this.div_ = null;
			};		
			//END CODE FOR HISTORIC MAP OVERLAY	
		
			//BEGIN TIMED EVENTS
			//After 3.5 seconds, zooms to the Farmington River and writes "Explore Historic Sites"			
			var allEvents = [];
			var introDone = false;
			var lastText = welcomeText;
			
			allEvents.push(setTimeout(function(){
				map.panTo(new google.maps.LatLng(41.736645, -72.851353));
				welcomeText.setMap(null);
				exploreText.setMap(map);
				lastText = exploreText;
				smoothZoom(16);
			},3000));
						
			//Smooth out to the East Coast
			allEvents.push(setTimeout(function(){
				exploreText.setMap(null);
				smoothZoom(5);
				}
			,8000));
						
			//Show the colonial America map and "From Colonial America"
			allEvents.push(setTimeout(function(){
				overlay.setMap(map);
				colonialText.setMap(map);
				lastText = colonialText;
				}
			,13500));
			
			//Remove colonial America map and text. Then zoom to CT.
			allEvents.push(setTimeout(function(){
				colonialText.setMap(null);
				smoothZoom(9);
				map.panTo(new google.maps.LatLng(41.607955, -72.689579));
				}
			,16500));
			
			//Show the 1800s CT map overlay and text.
			allEvents.push(setTimeout(function(){
				overlay.setMap(null);
				overlay = new MapOverlay(bounds2, srcImage2, map);
				eighteenText.setMap(map);
				lastText = eighteenText;
			}
			,18500));
			
			//Remove the 1800s overlay, go to the Uconn Medical Center.
			allEvents.push(setTimeout(function(){
				map.panTo(new google.maps.LatLng(41.731445, -72.791100));
				eighteenText.setMap(null);
				smoothZoom(16);
			}
			,21500));
			
			//Show the 1800s CT map overlay and text.
			allEvents.push(setTimeout(function(){
				overlay.setMap(null);
				todayText.setMap(map);
				lastText = todayText;
			}
			,23500));
			
			//Event to show change borders over time
			allEvents.push(setTimeout(function(){
				todayText.setMap(null);
				map.set('minZoom', 9);
				smoothZoom(10);
			}
			,26500));
			
			allEvents.push(setTimeout(function(){
				boundaryText.setMap(map);
				lastText = boundaryText;
				var i = 2500;
				while(i < 5500){
					allEvents.push(setTimeout(function(){
						selectedYear = 1900;
						drawBoundaries();
					}
					,i));
					i = i + 1000;
					allEvents.push(setTimeout(function(){
						selectedYear = 1610;
						drawBoundaries();
					}
					,i));
					i = i + 1000;
				}
			}
			,28500));
						
			//Sites Come and Go 
			allEvents.push(setTimeout(function(){
				boundaryText.setMap(null);
				map.panTo(new google.maps.LatLng(41.721774, -72.824690));
				comeGoText.setMap(map);
				lastText = comeGoText;
				smoothZoom(15);
			}
			,34500));
			
			allEvents.push(setTimeout(function(){
				var i = 2500;
				while(i < 5500){
					allEvents.push(setTimeout(function(){
						selectedYear = 9999;
						updatePOIs();
					}
					,i));
					i = i + 1000;
					allEvents.push(setTimeout(function(){
						selectedYear = 1920;
						updatePOIs();
					}
					,i));
					i = i + 1000;
				}
			}
			,36500));
			
			allEvents.push(setTimeout(function(){
				enjoyText.setMap(map);
				map.panTo(new google.maps.LatLng(41.7321983, -72.8352574));
				smoothZoom(10);
				lastText = enjoyText;
			}
			,42000));			
			
			allEvents.push(setTimeout(function(){
				enjoyText.setMap(null);
				introDone = true;
			}
			,46500));	
			
			//Called if you use the slider during the intro. Kills all the timed events.
			killIntro = function(){
				lastText.setMap(null);
				for(i = 0; i < allEvents.length; i++){
					clearTimeout(allEvents[i]);
				}
			};
			
			//Takes a new desired zoom level. Then zooms into it 1 zoom per .75 seconds to make it smoooooth.
			var smoothZoom = function(newZoom){
				currentZoom = map.getZoom();
								
				if (newZoom > currentZoom){
					allEvents.push(setTimeout(function(){
							map.setZoom(currentZoom+1);
							smoothZoom(newZoom);
						},450));
					}
				else if (newZoom < currentZoom){
					allEvents.push(setTimeout(function(){
							map.setZoom(currentZoom-1);
							smoothZoom(newZoom);
					},450));	
				}
				else return;
			}	

            boundaries = drawBoundaries();

            google.maps.event.addListener(boundaries, 'click', function () {
                summaryInfoWindow.close();
                currentSummaryMarker = null;
            });

            google.maps.event.addListener(map, 'click', function () {
                summaryInfoWindow.close();
                currentSummaryMarker = null;
            });

            $.ajax({
                type: 'GET',
                url: '/api/pois.php',
                contentType: "application/json",
                dataType: 'json'
            }).done(function (data) {
                pois = data;
                updatePOIs();
            });

            var roundTo = yearJumpLookup(allYears, 10);

            $('input[name=era]').slider({
                min: allYears[0],
                max: allYears[allYears.length-1],
                step: 10,
                value: allYears[0],
                tooltip: 'always',
                handle: 'triangle'
            }).on('slide', function(e){

                var currentYear = parseInt(e.value, 10);
                $(this).slider('setValue', roundTo[currentYear]);

            }).on('slideStop', function(e){

                selectedYear = parseInt(this.value, 10);
                $(this).slider('setValue', roundTo[selectedYear]);
                selectedYear = parseInt(this.value, 10);
                updatePOIs();
                drawBoundaries();
				//If you move the slider, kill the intro.
				if(introDone == false){
					//kill all the timed events
					killIntro();
					overlay.setMap(null);
					map.panTo(new google.maps.LatLng(41.7321983, -72.8352574));
					map.setZoom(10);
					map.set('minZoom', 9);
				}
            });

            $(document).on('change', 'input[name=categories]', updatePOIs);

            $(document).on('click', '#learn-more', function (e) {
                e.preventDefault();
                var poi = currentSummaryMarker.poi;
                var i = 0;

                var modal = $('#detail-modal');
                modal.find('.modal-title').html(poi.name);
                modal.find('.title').html(poi.name);
                modal.find('.description').html(poi.description);
                var carousel = modal.find('#photo-carousel');

                if (poi.photos.length > 0) {
                    var indicators = carousel.find('.carousel-indicators');
                    var imageContainer = carousel.find('.carousel-inner');
                    imageContainer.children().remove();
                    indicators.children().remove();
                    for (i = 0; i < poi.photos.length; i++) {
                        indicators.append('<li data-target="#photo-carousel" data-slide-to="' + i + '"' + (i === 0 ? ' class="active"' : '') + '></li>');
                        imageContainer.append('<div class="item '+ (i === 0 ? 'active' : '') +'"><img src="/images/'+ poi.photos[i].filename +'" alt="Carousel Photo"/></div>');
                    }
                    carousel.carousel();
                    carousel.show();
                }
                else {
                    carousel.hide();
                }

                var categories = modal.find('.categories');
                categories.children().remove();
                for(i = 0; i < poi.categories.length; i++)
                {
                    categories.append('<span class="label label-primary">'+poi.categories[i].label+'</span>');
                }

                modal.modal('show');

                summaryInfoWindow.close();
                currentSummaryMarker = null;
            });
        });
});
</script>
</body>
</html>
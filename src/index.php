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

                <?php foreach ($eras as $index => $era): ?>
                    <button class="btn btn-default year <?php if ($index === 0): echo 'active'; endif; ?>"
                            data-year="<?php echo $era['label']; ?>">
                        <?php echo $era['label']; ?>
                    </button>
                <?php endforeach; ?>

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

    <?php include "modal.php"; ?>

</div>
<!-- /.container -->
<script type="text/javascript" src="/vendor/requirejs/require.js"></script>
<script type ="text/javascript" src="/js/maplabel.js"></script>
<script type="text/javascript">
    requirejs.config({
        baseUrl: "<?php echo (strpos($_SERVER["HTTP_HOST"], 'amazonaws.com') !== false) ? '/js-built' : '/js'; ?>"
    });
    require(['common'], function (common) {
        require(
            ['bootstrap', 'jquery', 'underscore', 'async!http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyD0K-y2C9IH2lUf6_kOt8Dvd9TOlZq7sqk', '1640', '1800', '1840', '1880', 'maplabel'],
            function (bootstrap, $, _, googleMaps, boundaries1640, boundaries1800, boundaries1840, boundaries1880) {

                var mapOptions = {
                    center: {lat: 41.7321983, lng: -72.8352574},
                    zoom: 10,
					minZoom: 9
                };
                var map = new google.maps.Map(document.getElementById('map'),
                    mapOptions);
					
				 // Setting allowed bounds. Roughly the state of CT.
				var allowedBounds = new google.maps.LatLngBounds(
					new google.maps.LatLng(41.066501, -73.628673), 
					new google.maps.LatLng(41.984272, -71.877879)
				);
				var lastValidCenter = map.getCenter();
				google.maps.event.addListener(map, 'center_changed', function() {
					if (allowedBounds.contains(map.getCenter())) {
						// still within valid bounds, so save the last valid position
						lastValidCenter = map.getCenter();
						return; 
					}
					// not valid anymore => return to last valid position
					map.panTo(lastValidCenter);
				});
				
                var selectedYear = <?php echo $eras[0]['label']; ?>;
                var markers = [];

                var boundaries = null;

                var updatePOIs = function () {
                    for (var i in markers) {
                        markers[i].setMap(null);
                    }
                    markers = [];

                    $.ajax({
                        type: 'POST',
                        url: '/api/pois.php',
                        data: JSON.stringify({
                            year: selectedYear,
                            categories: $('input[name=categories]:checked').map(function () {
                                return $(this).val();
                            }).get()
                        }),
                        contentType: "application/json",
                        dataType: 'json'
                    }).done(function (data) {

                        for (var index in data) {

                            (function () {
                                var poi = data[index];
                                var marker = new google.maps.Marker({
                                    position: new google.maps.LatLng(poi.latitude, poi.longitude),
                                    map: map
                                });

                                var titleInfoWindow = new google.maps.InfoWindow({
                                    content: '<p>' + poi.name + '</p>'
                                });

                                var summaryInfoWindow = new google.maps.InfoWindow({
                                    content: "<h1>" + poi.name + "</h1>" + poi.description
                                });

                                google.maps.event.addListener(marker, 'mouseover', function () {
                                    titleInfoWindow.open(map, this);
                                });

                                google.maps.event.addListener(marker, 'mouseout', function () {
                                    titleInfoWindow.close();
                                });

                                google.maps.event.addListener(marker, 'click', function () {
                                    summaryInfoWindow.open(map, this);
                                });
                                markers.push(marker);
                            })();
                        }
                    });
                };

                var getBoundariesForYear = function (year) {
                    var availableBoundaries = [
                        { year: 1640, boundaries: boundaries1640 },
                        { year: 1800, boundaries: boundaries1800 },
                        { year: 1840, boundaries: boundaries1840 },
                        { year: 1880, boundaries: boundaries1880 }
                    ];

                    var index = 0;

                    while(index + 1 < availableBoundaries.length && availableBoundaries[index + 1].year < year)
                    {
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
                };

				var text = new MapLabel({
				text: 'Welcome to Digital Farmington',
				position: new google.maps.LatLng(41.870669, -72.824893),
				map: map,
				minZoom: 10,
				fontSize: 21,
				fontColor: '#ff0000',
				align: 'center'
				}); 

				
                updatePOIs();
                drawBoundaries();

                $(document).on('click', 'button.year', function () {
                    $(this).addClass('active');
                    $(this).siblings('.active').removeClass('active');
                    selectedYear = $(this).data('year');
                    updatePOIs();
                    drawBoundaries();
                });
                $(document).on('change', 'input[name=categories]', updatePOIs);
            });
    });
</script>
</body>
</html>
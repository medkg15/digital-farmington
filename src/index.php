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
        ['bootstrap', 'jquery', 'underscore', 'async!http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyD0K-y2C9IH2lUf6_kOt8Dvd9TOlZq7sqk', '1640', '1800', '1840', '1880', 'maplabel', 'bootstrap-slider'],
        function (bootstrap, $, _, googleMaps, boundaries1640, boundaries1800, boundaries1840, boundaries1880, MapLabel, bootstrapSlider) {

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

            var text = new MapLabel({
                text: 'Welcome to Digital Farmington',
                position: new google.maps.LatLng(41.870669, -72.824893),
                map: map,
                minZoom: 10,
                fontSize: 21,
                fontColor: '#ff0000',
                align: 'center'
            });

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

            var closestYearWithMap = function(year){
                var distances = _.map(allYears, function(mapYear){
                    return { year: mapYear, distance: Math.abs(mapYear - year) };
                });

                var smallest = distances[0];

                for (var i = 1; i<distances.length; i++)
                {
                    if(smallest.distance > distances[i].distance)
                    {
                        smallest = distances[i];
                    }
                }

                return smallest.year;
            };

            // pre-compute where we will "jump to" for years that we don't have maps
            var roundTo = [];
            var step = 10;

            for (var year = allYears[0]; year <= allYears[allYears.length-1]; year+=step)
            {
                roundTo[year] = closestYearWithMap(year);
            }

            $('input[name=era]').slider({
                min: allYears[0],
                max: allYears[allYears.length-1],
                step: step,
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
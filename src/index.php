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

                <?php foreach($eras as $index => $era): ?>
                    <button class="btn btn-default year <?php if($index === 0): echo 'active'; endif;?>" data-year="<?php echo $era['label'];?>">
                        <?php echo $era['label'];?>
                    </button>
                <?php endforeach; ?>

            </div>

        </div>
        <div class="col-md-3">

            <h3>Filter Categories</h3>
            <?php foreach($categories as $category): ?>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="categories" value="<?php echo $category['label'];?>" checked/> <?php echo $category['label'];?>
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
<script type="text/javascript">
    requirejs.config({
        baseUrl: "<?php echo (strpos($_SERVER["HTTP_HOST"], 'amazonaws.com') !== false) ? '/js-built' : '/js'; ?>",
    });
    require(['common'], function (common) {
        require(
            ['bootstrap', 'jquery', 'async!http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyD0K-y2C9IH2lUf6_kOt8Dvd9TOlZq7sqk'],
            function(bootstrap, $, googleMaps){

                var mapOptions = {
                    center: { lat: 41.7321983, lng: -72.8352574},
                    zoom: 12
                };
                var map = new google.maps.Map(document.getElementById('map'),
                    mapOptions);
					
//start Alex's border section					
var latExtent = 86;
var lngExtent = 180;
var lngExtent2 = lngExtent - 1e-10;
var everythingElse = [
	new google.maps.LatLng(-latExtent, -lngExtent), // left bottom
	new google.maps.LatLng(latExtent, -lngExtent), // left top
	new google.maps.LatLng(latExtent, 0), // right top
	new google.maps.LatLng(-latExtent, 0), // right bottom
	new google.maps.LatLng(-latExtent, lngExtent2), // right bottom
	new google.maps.LatLng(latExtent, lngExtent2), // right top
	new google.maps.LatLng(latExtent, 0), // left top
	new google.maps.LatLng(-latExtent, 0), // left bottom
];

var farmingtonCoords = [
   new google.maps.LatLng(41.775995, -72.908385),
   new google.maps.LatLng(41.696191, -72.892249),
   new google.maps.LatLng(41.715758, -72.761873),	
   new google.maps.LatLng(41.758679, -72.797020),
  ];

  farmingtonHighlight = new google.maps.Polygon({
    paths: [everythingElse, farmingtonCoords],
    strokeColor: "#000000",
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: "#000000",
    fillOpacity: 0.5
  });

  farmingtonHighlight.setMap(map);
//end Alex section
                var selectedYear = <?php echo $eras[0]['label']; ?>;
                var markers = [];

                var updatePOIs = function(){
                    for(var i in markers)
                    {
                        markers[i].setMap(null);
                    }
                    markers = [];

                    $.ajax({
                        type: 'POST',
                        url: '/api/pois.php',
                        data: JSON.stringify({
                            year: selectedYear,
                            categories: $('input[name=categories]:checked').map(function(){
                                return $(this).val();
                            }).get()
                        }),
                        contentType: "application/json",
                        dataType: 'json'
                    }).done(function(data){

                        for(var index in data) {

                            (function(){
                                var poi = data[index];
                                var marker = new google.maps.Marker({
                                    position: new google.maps.LatLng(poi.latitude, poi.longitude),
                                    map: map
                                });

                                var titleInfoWindow = new google.maps.InfoWindow({
                                    content: '<p>'+poi.name+'</p>'
                                });

                                var summaryInfoWindow = new google.maps.InfoWindow({
                                    content: "<h1>" + poi.name + "</h1>" + poi.description
                                });

                                google.maps.event.addListener(marker, 'mouseover', function() {
                                    titleInfoWindow.open(map, this);
                                });

                                google.maps.event.addListener(marker, 'mouseout', function() {
                                    titleInfoWindow.close();
                                });

                                google.maps.event.addListener(marker, 'click', function() {
                                    summaryInfoWindow.open(map, this);
                                });
                                markers.push(marker);
                            })();
                        }
                    });
                };

                updatePOIs();

                $(document).on('click', 'button.year', function(){
                    $(this).addClass('active');
                    $(this).siblings('.active').removeClass('active');
                    selectedYear = $(this).data('year');
                    updatePOIs();
                });
                $(document).on('change', 'input[name=categories]', updatePOIs);
        });
    });
</script>
</body>
</html>
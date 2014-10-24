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

                <button class="btn btn-default">1640</button>
                <button class="btn btn-default">1700</button>
                <button class="btn btn-default">1730</button>
                <button class="btn btn-default">1780</button>
                <button class="btn btn-default">1800</button>
                <button class="btn btn-default">1850</button>
                <button class="btn btn-default">1880</button>
                <button class="btn btn-default">1910</button>
                <button class="btn btn-default">1950</button>
                <button class="btn btn-default">1980</button>
                <button class="btn btn-default">2020</button>

            </div>

        </div>
        <div class="col-md-3">

            <h3>Filter Categories</h3>

            <div class="checkbox">
                <label>
                    <input type="checkbox"/> Stuff
                </label>
            </div>

            <div class="checkbox">
                <label>
                    <input type="checkbox"/> Stuff
                </label>
            </div>

            <div class="checkbox">
                <label>
                    <input type="checkbox"/> Stuff
                </label>
            </div>

            <div class="checkbox">
                <label>
                    <input type="checkbox"/> Stuff
                </label>
            </div>

            <div class="checkbox">
                <label>
                    <input type="checkbox"/> Stuff
                </label>
            </div>


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
<script src="/vendor/requirejs/require.js"></script>
<script>
    requirejs.config({
        baseUrl: "<?php echo (strpos($_SERVER["HTTP_HOST"], 'amazonaws.com') !== false) ? '/js-built' : '/js'; ?>",
    });
    require(['common'], function (common) {
        require(
            ['bootstrap', 'jquery', 'async!http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyD0K-y2C9IH2lUf6_kOt8Dvd9TOlZq7sqk'],
            function(bootstrap, $, googleMaps){

                var mapOptions = {
                    center: { lat: -34.397, lng: 150.644},
                    zoom: 8
                };
                var map = new google.maps.Map(document.getElementById('map'),
                    mapOptions);
        });
    });
</script>
</body>
</html>
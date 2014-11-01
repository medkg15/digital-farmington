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
	new google.maps.LatLng(-latExtent, 0), // right bottom 8 
	new google.maps.LatLng(latExtent, 0), // right top 7 
	new google.maps.LatLng(latExtent, -lngExtent), // left top 6
	new google.maps.LatLng(-latExtent, -lngExtent), // left bottom 5
	new google.maps.LatLng(-latExtent, 0), // left bottom 4	
	new google.maps.LatLng(latExtent, 0), // left top 3
	new google.maps.LatLng(latExtent, lngExtent2), // right top 2
	new google.maps.LatLng(-latExtent, lngExtent2), // right bottom 1
];

var farmingtonCoords = [
new google.maps.LatLng(41.765476,-72.880938),
new google.maps.LatLng(41.765395,-72.880688),
new google.maps.LatLng(41.765324,-72.88029),
new google.maps.LatLng(41.765095,-72.87886),
new google.maps.LatLng(41.76501,-72.878386),
new google.maps.LatLng(41.764895,-72.877795),
new google.maps.LatLng(41.764769,-72.877316),
new google.maps.LatLng(41.764718,-72.876944),
new google.maps.LatLng(41.764593,-72.876042),
new google.maps.LatLng(41.764513,-72.875454),
new google.maps.LatLng(41.764318,-72.874157),
new google.maps.LatLng(41.764021,-72.873219),
new google.maps.LatLng(41.763732,-72.867028),
new google.maps.LatLng(41.762927,-72.861727),
new google.maps.LatLng(41.762855,-72.861242),
new google.maps.LatLng(41.762742,-72.86035),
new google.maps.LatLng(41.762638,-72.859531),
new google.maps.LatLng(41.762608,-72.85929),
new google.maps.LatLng(41.762578,-72.858876),
new google.maps.LatLng(41.762532,-72.85815),
new google.maps.LatLng(41.762516,-72.857898),
new google.maps.LatLng(41.762507,-72.857745),
new google.maps.LatLng(41.762107,-72.853145),
new google.maps.LatLng(41.762004,-72.85227),
new google.maps.LatLng(41.761578,-72.848636),
new google.maps.LatLng(41.76151,-72.848064),
new google.maps.LatLng(41.761297,-72.846244),
new google.maps.LatLng(41.76031,-72.837829),
new google.maps.LatLng(41.760049,-72.835612),
new google.maps.LatLng(41.759721,-72.832823),
new google.maps.LatLng(41.75939,-72.829995),
new google.maps.LatLng(41.759126,-72.827743),
new google.maps.LatLng(41.757998,-72.820788),
new google.maps.LatLng(41.757954,-72.820462),
new google.maps.LatLng(41.757921,-72.820241),
new google.maps.LatLng(41.757904,-72.820132),
new google.maps.LatLng(41.758014,-72.818758),
new google.maps.LatLng(41.758049,-72.818099),
new google.maps.LatLng(41.758154,-72.816124),
new google.maps.LatLng(41.75819,-72.815466),
new google.maps.LatLng(41.758292,-72.813198),
new google.maps.LatLng(41.758547,-72.80756),
new google.maps.LatLng(41.758599,-72.806394),
new google.maps.LatLng(41.758702,-72.804127),
new google.maps.LatLng(41.758723,-72.80265),
new google.maps.LatLng(41.758785,-72.798219),
new google.maps.LatLng(41.758807,-72.796743),
new google.maps.LatLng(41.755067,-72.79616),
new google.maps.LatLng(41.754011,-72.795995),
new google.maps.LatLng(41.750159,-72.795394),
new google.maps.LatLng(41.747476,-72.794974),
new google.maps.LatLng(41.747601,-72.792762),
new google.maps.LatLng(41.747777,-72.789643),
new google.maps.LatLng(41.747815,-72.788965),
new google.maps.LatLng(41.74782,-72.78887),
new google.maps.LatLng(41.747826,-72.788775),
new google.maps.LatLng(41.747835,-72.788599),
new google.maps.LatLng(41.74787,-72.787995),
new google.maps.LatLng(41.747904,-72.78739),
new google.maps.LatLng(41.747923,-72.787048),
new google.maps.LatLng(41.747923,-72.787041),
new google.maps.LatLng(41.747943,-72.786687),
new google.maps.LatLng(41.747955,-72.786486),
new google.maps.LatLng(41.748091,-72.784086),
new google.maps.LatLng(41.748131,-72.783353),
new google.maps.LatLng(41.748181,-72.782472),
new google.maps.LatLng(41.748206,-72.78234),
new google.maps.LatLng(41.748232,-72.7822),
new google.maps.LatLng(41.748181,-72.782177),
new google.maps.LatLng(41.747804,-72.782005),
new google.maps.LatLng(41.746521,-72.781423),
new google.maps.LatLng(41.746094,-72.781229),
new google.maps.LatLng(41.745927,-72.781161),
new google.maps.LatLng(41.745529,-72.781105),
new google.maps.LatLng(41.744166,-72.780912),
new google.maps.LatLng(41.738348,-72.780091),
new google.maps.LatLng(41.736809,-72.779874),
new google.maps.LatLng(41.73641,-72.779815),
new google.maps.LatLng(41.735753,-72.779728),
new google.maps.LatLng(41.733785,-72.779467),
new google.maps.LatLng(41.733129,-72.77938),
new google.maps.LatLng(41.73023,-72.779065),
new google.maps.LatLng(41.730718,-72.778226),
new google.maps.LatLng(41.731097,-72.777639),
new google.maps.LatLng(41.731274,-72.777472),
new google.maps.LatLng(41.732121,-72.776732),
new google.maps.LatLng(41.732405,-72.776488),
new google.maps.LatLng(41.732631,-72.776294),
new google.maps.LatLng(41.733267,-72.775768),
new google.maps.LatLng(41.733406,-72.775655),
new google.maps.LatLng(41.733563,-72.775539),
new google.maps.LatLng(41.733644,-72.775478),
new google.maps.LatLng(41.73389,-72.775296),
new google.maps.LatLng(41.733972,-72.775236),
new google.maps.LatLng(41.734206,-72.775062),
new google.maps.LatLng(41.73491,-72.774541),
new google.maps.LatLng(41.735064,-72.774428),
new google.maps.LatLng(41.735142,-72.774364),
new google.maps.LatLng(41.735402,-72.774148),
new google.maps.LatLng(41.736042,-72.77362),
new google.maps.LatLng(41.736179,-72.773493),
new google.maps.LatLng(41.736429,-72.773265),
new google.maps.LatLng(41.736508,-72.773193),
new google.maps.LatLng(41.736855,-72.772829),
new google.maps.LatLng(41.736865,-72.772814),
new google.maps.LatLng(41.737146,-72.772411),
new google.maps.LatLng(41.737266,-72.772242),
new google.maps.LatLng(41.737942,-72.771268),
new google.maps.LatLng(41.738301,-72.770753),
new google.maps.LatLng(41.739355,-72.769207),
new google.maps.LatLng(41.739584,-72.768933),
new google.maps.LatLng(41.737617,-72.768777),
new google.maps.LatLng(41.737579,-72.768775),
new google.maps.LatLng(41.737639,-72.768075),
new google.maps.LatLng(41.737685,-72.767539),
new google.maps.LatLng(41.737689,-72.7673),
new google.maps.LatLng(41.737703,-72.766583),
new google.maps.LatLng(41.737709,-72.766345),
new google.maps.LatLng(41.737709,-72.76575),
new google.maps.LatLng(41.73771,-72.765422),
new google.maps.LatLng(41.73771,-72.764499),
new google.maps.LatLng(41.73771,-72.763964),
new google.maps.LatLng(41.73771,-72.763935),
new google.maps.LatLng(41.737711,-72.76337),
new google.maps.LatLng(41.73771,-72.76319),
new google.maps.LatLng(41.73771,-72.762651),
new google.maps.LatLng(41.73771,-72.762472),
new google.maps.LatLng(41.737317,-72.762377),
new google.maps.LatLng(41.73689,-72.762275),
new google.maps.LatLng(41.73612,-72.762296),
new google.maps.LatLng(41.735717,-72.762308),
new google.maps.LatLng(41.73568,-72.76246),
new google.maps.LatLng(41.735608,-72.762504),
new google.maps.LatLng(41.735293,-72.76247),
new google.maps.LatLng(41.735257,-72.762467),
new google.maps.LatLng(41.735092,-72.762585),
new google.maps.LatLng(41.735021,-72.762599),
new google.maps.LatLng(41.734878,-72.762504),
new google.maps.LatLng(41.734829,-72.76246),
new google.maps.LatLng(41.734388,-72.762415),
new google.maps.LatLng(41.73434,-72.762409),
new google.maps.LatLng(41.734192,-72.762424),
new google.maps.LatLng(41.734104,-72.762505),
new google.maps.LatLng(41.734099,-72.762644),
new google.maps.LatLng(41.734077,-72.762739),
new google.maps.LatLng(41.734039,-72.762754),
new google.maps.LatLng(41.733961,-72.762716),
new google.maps.LatLng(41.733841,-72.762659),
new google.maps.LatLng(41.733572,-72.762637),
new google.maps.LatLng(41.733462,-72.762564),
new google.maps.LatLng(41.733461,-72.762542),
new google.maps.LatLng(41.733308,-72.762541),
new google.maps.LatLng(41.732849,-72.762538),
new google.maps.LatLng(41.732696,-72.762538),
new google.maps.LatLng(41.731529,-72.762499),
new google.maps.LatLng(41.728028,-72.762385),
new google.maps.LatLng(41.727155,-72.762357),
new google.maps.LatLng(41.727105,-72.762355),
new google.maps.LatLng(41.726862,-72.762347),
new google.maps.LatLng(41.72681,-72.762342),
new google.maps.LatLng(41.726146,-72.762273),
new google.maps.LatLng(41.72591,-72.762261),
new google.maps.LatLng(41.725773,-72.762254),
new google.maps.LatLng(41.724586,-72.762249),
new google.maps.LatLng(41.721446,-72.762238),
new google.maps.LatLng(41.719908,-72.762208),
new google.maps.LatLng(41.71971,-72.762205),
new google.maps.LatLng(41.718349,-72.76218),
new google.maps.LatLng(41.717836,-72.762214),
new google.maps.LatLng(41.717532,-72.762235),
new google.maps.LatLng(41.71631,-72.762047),
new google.maps.LatLng(41.715803,-72.76197),
new google.maps.LatLng(41.715761,-72.762256),
new google.maps.LatLng(41.715637,-72.763116),
new google.maps.LatLng(41.715596,-72.763403),
new google.maps.LatLng(41.715548,-72.763663),
new google.maps.LatLng(41.715406,-72.764445),
new google.maps.LatLng(41.715359,-72.764706),
new google.maps.LatLng(41.715286,-72.765312),
new google.maps.LatLng(41.715177,-72.766094),
new google.maps.LatLng(41.715068,-72.766889),
new google.maps.LatLng(41.715025,-72.767208),
new google.maps.LatLng(41.714747,-72.770274),
new google.maps.LatLng(41.714747,-72.770283),
new google.maps.LatLng(41.714621,-72.771669),
new google.maps.LatLng(41.714422,-72.772974),
new google.maps.LatLng(41.714232,-72.774224),
new google.maps.LatLng(41.714079,-72.775231),
new google.maps.LatLng(41.713929,-72.776216),
new google.maps.LatLng(41.713828,-72.77689),
new google.maps.LatLng(41.713778,-72.777219),
new google.maps.LatLng(41.71363,-72.778196),
new google.maps.LatLng(41.713605,-72.77838),
new google.maps.LatLng(41.713532,-72.778935),
new google.maps.LatLng(41.713508,-72.77912),
new google.maps.LatLng(41.713437,-72.779561),
new google.maps.LatLng(41.713286,-72.78051),
new google.maps.LatLng(41.713222,-72.780886),
new google.maps.LatLng(41.713148,-72.781328),
new google.maps.LatLng(41.712885,-72.782782),
new google.maps.LatLng(41.712848,-72.782993),
new google.maps.LatLng(41.710273,-72.786337),
new google.maps.LatLng(41.709452,-72.787403),
new google.maps.LatLng(41.709374,-72.787507),
new google.maps.LatLng(41.708793,-72.788266),
new google.maps.LatLng(41.707657,-72.78975),
new google.maps.LatLng(41.705941,-72.791986),
new google.maps.LatLng(41.70578,-72.792199),
new google.maps.LatLng(41.70563,-72.792605),
new google.maps.LatLng(41.705443,-72.792906),
new google.maps.LatLng(41.705236,-72.793169),
new google.maps.LatLng(41.70489,-72.79365),
new google.maps.LatLng(41.704701,-72.794029),
new google.maps.LatLng(41.704638,-72.794136),
new google.maps.LatLng(41.704507,-72.794363),
new google.maps.LatLng(41.704002,-72.795117),
new google.maps.LatLng(41.703725,-72.795504),
new google.maps.LatLng(41.703407,-72.795951),
new google.maps.LatLng(41.702977,-72.796402),
new google.maps.LatLng(41.701937,-72.797498),
new google.maps.LatLng(41.70167,-72.797736),
new google.maps.LatLng(41.701207,-72.798152),
new google.maps.LatLng(41.700738,-72.798717),
new google.maps.LatLng(41.699335,-72.800412),
new google.maps.LatLng(41.698868,-72.800978),
new google.maps.LatLng(41.698612,-72.801328),
new google.maps.LatLng(41.697846,-72.80238),
new google.maps.LatLng(41.697591,-72.802731),
new google.maps.LatLng(41.697388,-72.802999),
new google.maps.LatLng(41.696781,-72.803805),
new google.maps.LatLng(41.696579,-72.804074),
new google.maps.LatLng(41.69595,-72.804856),
new google.maps.LatLng(41.695179,-72.805838),
new google.maps.LatLng(41.691837,-72.8101),
new google.maps.LatLng(41.692255,-72.811104),
new google.maps.LatLng(41.692024,-72.811207),
new google.maps.LatLng(41.690241,-72.812007),
new google.maps.LatLng(41.690141,-72.812123),
new google.maps.LatLng(41.690038,-72.812225),
new google.maps.LatLng(41.689689,-72.812641),
new google.maps.LatLng(41.688646,-72.813891),
new google.maps.LatLng(41.688298,-72.814308),
new google.maps.LatLng(41.68821,-72.814532),
new google.maps.LatLng(41.688144,-72.814703),
new google.maps.LatLng(41.687949,-72.815204),
new google.maps.LatLng(41.687862,-72.815429),
new google.maps.LatLng(41.687855,-72.815431),
new google.maps.LatLng(41.687834,-72.81544),
new google.maps.LatLng(41.687828,-72.815443),
new google.maps.LatLng(41.688173,-72.817698),
new google.maps.LatLng(41.688382,-72.819061),
new google.maps.LatLng(41.688776,-72.821631),
new google.maps.LatLng(41.689387,-72.825624),
new google.maps.LatLng(41.689441,-72.825974),
new google.maps.LatLng(41.690044,-72.829916),
new google.maps.LatLng(41.690442,-72.832509),
new google.maps.LatLng(41.690599,-72.833535),
new google.maps.LatLng(41.690628,-72.833714),
new google.maps.LatLng(41.690715,-72.834254),
new google.maps.LatLng(41.690744,-72.834434),
new google.maps.LatLng(41.690751,-72.834494),
new google.maps.LatLng(41.690768,-72.834661),
new google.maps.LatLng(41.690842,-72.835342),
new google.maps.LatLng(41.690867,-72.83557),
new google.maps.LatLng(41.690871,-72.835619),
new google.maps.LatLng(41.690883,-72.835768),
new google.maps.LatLng(41.690887,-72.835818),
new google.maps.LatLng(41.690905,-72.836049),
new google.maps.LatLng(41.691108,-72.837284),
new google.maps.LatLng(41.691834,-72.841677),
new google.maps.LatLng(41.69191,-72.842138),
new google.maps.LatLng(41.692076,-72.843142),
new google.maps.LatLng(41.692098,-72.843279),
new google.maps.LatLng(41.692166,-72.84369),
new google.maps.LatLng(41.692189,-72.843828),
new google.maps.LatLng(41.692217,-72.843999),
new google.maps.LatLng(41.692303,-72.844514),
new google.maps.LatLng(41.692332,-72.844686),
new google.maps.LatLng(41.692475,-72.845521),
new google.maps.LatLng(41.692905,-72.848026),
new google.maps.LatLng(41.69298,-72.84846),
new google.maps.LatLng(41.693049,-72.848862),
new google.maps.LatLng(41.693114,-72.849199),
new google.maps.LatLng(41.693309,-72.850211),
new google.maps.LatLng(41.693359,-72.85047),
new google.maps.LatLng(41.693374,-72.850549),
new google.maps.LatLng(41.693396,-72.850654),
new google.maps.LatLng(41.693482,-72.851073),
new google.maps.LatLng(41.693523,-72.851276),
new google.maps.LatLng(41.6938,-72.853211),
new google.maps.LatLng(41.693827,-72.853401),
new google.maps.LatLng(41.69417,-72.855794),
new google.maps.LatLng(41.694154,-72.855926),
new google.maps.LatLng(41.694154,-72.85597),
new google.maps.LatLng(41.694198,-72.856065),
new google.maps.LatLng(41.694231,-72.85608),
new google.maps.LatLng(41.695406,-72.863344),
new google.maps.LatLng(41.695413,-72.863423),
new google.maps.LatLng(41.695406,-72.863745),
new google.maps.LatLng(41.695418,-72.863809),
new google.maps.LatLng(41.695437,-72.863846),
new google.maps.LatLng(41.695784,-72.865711),
new google.maps.LatLng(41.695857,-72.865696),
new google.maps.LatLng(41.695991,-72.866425),
new google.maps.LatLng(41.696395,-72.868613),
new google.maps.LatLng(41.69653,-72.869343),
new google.maps.LatLng(41.696564,-72.869564),
new google.maps.LatLng(41.696666,-72.870228),
new google.maps.LatLng(41.6967,-72.87045),
new google.maps.LatLng(41.696995,-72.871914),
new google.maps.LatLng(41.697512,-72.87448),
new google.maps.LatLng(41.69784,-72.876316),
new google.maps.LatLng(41.698103,-72.877787),
new google.maps.LatLng(41.698085,-72.878),
new google.maps.LatLng(41.698033,-72.878639),
new google.maps.LatLng(41.698016,-72.878853),
new google.maps.LatLng(41.697993,-72.879291),
new google.maps.LatLng(41.697928,-72.880607),
new google.maps.LatLng(41.697906,-72.881046),
new google.maps.LatLng(41.697763,-72.882184),
new google.maps.LatLng(41.697338,-72.885599),
new google.maps.LatLng(41.697197,-72.886738),
new google.maps.LatLng(41.697189,-72.886785),
new google.maps.LatLng(41.697166,-72.88693),
new google.maps.LatLng(41.697159,-72.886978),
new google.maps.LatLng(41.697109,-72.887728),
new google.maps.LatLng(41.696963,-72.889978),
new google.maps.LatLng(41.696924,-72.89058),
new google.maps.LatLng(41.696914,-72.890728),
new google.maps.LatLng(41.696871,-72.891159),
new google.maps.LatLng(41.696743,-72.892452),
new google.maps.LatLng(41.696701,-72.892884),
new google.maps.LatLng(41.696709,-72.892886),
new google.maps.LatLng(41.696733,-72.892892),
new google.maps.LatLng(41.696741,-72.892895),
new google.maps.LatLng(41.697074,-72.892994),
new google.maps.LatLng(41.697721,-72.893188),
new google.maps.LatLng(41.698076,-72.893288),
new google.maps.LatLng(41.698411,-72.893383),
new google.maps.LatLng(41.698647,-72.893449),
new google.maps.LatLng(41.698757,-72.89348),
new google.maps.LatLng(41.699349,-72.893674),
new google.maps.LatLng(41.699583,-72.893751),
new google.maps.LatLng(41.699583,-72.893743),
new google.maps.LatLng(41.699587,-72.893722),
new google.maps.LatLng(41.699589,-72.893715),
new google.maps.LatLng(41.699828,-72.89374),
new google.maps.LatLng(41.700545,-72.893815),
new google.maps.LatLng(41.700784,-72.893841),
new google.maps.LatLng(41.701957,-72.893987),
new google.maps.LatLng(41.705475,-72.894428),
new google.maps.LatLng(41.706649,-72.894575),
new google.maps.LatLng(41.707011,-72.894658),
new google.maps.LatLng(41.708097,-72.894909),
new google.maps.LatLng(41.70846,-72.894993),
new google.maps.LatLng(41.70925,-72.895122),
new google.maps.LatLng(41.711621,-72.895512),
new google.maps.LatLng(41.712412,-72.895642),
new google.maps.LatLng(41.713385,-72.89592),
new google.maps.LatLng(41.716306,-72.896754),
new google.maps.LatLng(41.71728,-72.897032),
new google.maps.LatLng(41.718459,-72.897287),
new google.maps.LatLng(41.71961,-72.897537),
new google.maps.LatLng(41.721998,-72.898053),
new google.maps.LatLng(41.722545,-72.898172),
new google.maps.LatLng(41.722715,-72.898209),
new google.maps.LatLng(41.723185,-72.898271),
new google.maps.LatLng(41.72902,-72.899297),
new google.maps.LatLng(41.732054,-72.899831),
new google.maps.LatLng(41.735289,-72.900626),
new google.maps.LatLng(41.735634,-72.900731),
new google.maps.LatLng(41.736565,-72.901022),
new google.maps.LatLng(41.736688,-72.901081),
new google.maps.LatLng(41.736889,-72.901136),
new google.maps.LatLng(41.737494,-72.901302),
new google.maps.LatLng(41.737696,-72.901358),
new google.maps.LatLng(41.738107,-72.901498),
new google.maps.LatLng(41.739341,-72.901921),
new google.maps.LatLng(41.739579,-72.902003),
new google.maps.LatLng(41.739745,-72.902081),
new google.maps.LatLng(41.739829,-72.902094),
new google.maps.LatLng(41.740084,-72.902134),
new google.maps.LatLng(41.740169,-72.902148),
new google.maps.LatLng(41.740368,-72.902113),
new google.maps.LatLng(41.740378,-72.902112),
new google.maps.LatLng(41.740975,-72.902154),
new google.maps.LatLng(41.741178,-72.902169),
new google.maps.LatLng(41.741203,-72.902166),
new google.maps.LatLng(41.741281,-72.90216),
new google.maps.LatLng(41.741307,-72.902158),
new google.maps.LatLng(41.741662,-72.90217),
new google.maps.LatLng(41.741691,-72.902178),
new google.maps.LatLng(41.742025,-72.902276),
new google.maps.LatLng(41.7426,-72.902444),
new google.maps.LatLng(41.742803,-72.902503),
new google.maps.LatLng(41.743174,-72.902612),
new google.maps.LatLng(41.743254,-72.902614),
new google.maps.LatLng(41.743496,-72.902623),
new google.maps.LatLng(41.743577,-72.902626),
new google.maps.LatLng(41.743747,-72.902638),
new google.maps.LatLng(41.744258,-72.902674),
new google.maps.LatLng(41.744429,-72.902687),
new google.maps.LatLng(41.744477,-72.902695),
new google.maps.LatLng(41.744621,-72.902719),
new google.maps.LatLng(41.74467,-72.902727),
new google.maps.LatLng(41.745344,-72.902891),
new google.maps.LatLng(41.745594,-72.902987),
new google.maps.LatLng(41.746854,-72.903364),
new google.maps.LatLng(41.747785,-72.903586),
new google.maps.LatLng(41.747918,-72.903617),
new google.maps.LatLng(41.748052,-72.903649),
new google.maps.LatLng(41.748132,-72.903668),
new google.maps.LatLng(41.74901,-72.903877),
new google.maps.LatLng(41.749416,-72.903973),
new google.maps.LatLng(41.750047,-72.904166),
new google.maps.LatLng(41.750244,-72.904247),
new google.maps.LatLng(41.756524,-72.904791),
new google.maps.LatLng(41.758098,-72.904928),
new google.maps.LatLng(41.761615,-72.90561),
new google.maps.LatLng(41.763841,-72.906042),
new google.maps.LatLng(41.7649,-72.906248),
new google.maps.LatLng(41.768692,-72.906985),
new google.maps.LatLng(41.77216,-72.9077),
new google.maps.LatLng(41.773241,-72.907924),
new google.maps.LatLng(41.775204,-72.908329),
new google.maps.LatLng(41.77567,-72.908425),
new google.maps.LatLng(41.776051,-72.908481),
new google.maps.LatLng(41.776204,-72.904717),
new google.maps.LatLng(41.776162,-72.904054),
new google.maps.LatLng(41.776017,-72.903626),
new google.maps.LatLng(41.775719,-72.902986),
new google.maps.LatLng(41.775441,-72.902612),
new google.maps.LatLng(41.775128,-72.902159),
new google.maps.LatLng(41.773692,-72.901632),
new google.maps.LatLng(41.772095,-72.901168),
new google.maps.LatLng(41.771633,-72.901078),
new google.maps.LatLng(41.770802,-72.901219),
new google.maps.LatLng(41.769558,-72.901204),
new google.maps.LatLng(41.768704,-72.901218),
new google.maps.LatLng(41.768449,-72.901024),
new google.maps.LatLng(41.768329,-72.900889),
new google.maps.LatLng(41.768125,-72.900393),
new google.maps.LatLng(41.767975,-72.899926),
new google.maps.LatLng(41.766691,-72.898247),
new google.maps.LatLng(41.766284,-72.897714),
new google.maps.LatLng(41.765187,-72.896279),
new google.maps.LatLng(41.764962,-72.896114),
new google.maps.LatLng(41.764868,-72.895941),
new google.maps.LatLng(41.764693,-72.895238),
new google.maps.LatLng(41.764731,-72.89497),
new google.maps.LatLng(41.764844,-72.894166),
new google.maps.LatLng(41.764883,-72.893899),
new google.maps.LatLng(41.764924,-72.893078),
new google.maps.LatLng(41.765048,-72.890618),
new google.maps.LatLng(41.76509,-72.889798),
new google.maps.LatLng(41.765151,-72.888992),
new google.maps.LatLng(41.765206,-72.88845),
new google.maps.LatLng(41.765256,-72.887949),
new google.maps.LatLng(41.765276,-72.887746),
new google.maps.LatLng(41.765292,-72.887578),
new google.maps.LatLng(41.765305,-72.887456),
new google.maps.LatLng(41.765414,-72.886558),
new google.maps.LatLng(41.765425,-72.886439),
new google.maps.LatLng(41.765431,-72.886358),
new google.maps.LatLng(41.765448,-72.886169),
new google.maps.LatLng(41.765466,-72.885957),
new google.maps.LatLng(41.765484,-72.885751),
new google.maps.LatLng(41.765507,-72.885489),
new google.maps.LatLng(41.765534,-72.885181),
new google.maps.LatLng(41.765549,-72.885006),
new google.maps.LatLng(41.765555,-72.884659),
new google.maps.LatLng(41.765564,-72.884572),
new google.maps.LatLng(41.76559,-72.884314),
new google.maps.LatLng(41.7656,-72.884228),
new google.maps.LatLng(41.7656,-72.88422),
new google.maps.LatLng(41.765602,-72.884199),
new google.maps.LatLng(41.765603,-72.884192),
new google.maps.LatLng(41.765588,-72.883759),
new google.maps.LatLng(41.765546,-72.88246),
new google.maps.LatLng(41.765532,-72.882028),
new google.maps.LatLng(41.76552,-72.881755),
new google.maps.LatLng(41.76549,-72.881055),
new google.maps.LatLng(41.765476,-72.880938)
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
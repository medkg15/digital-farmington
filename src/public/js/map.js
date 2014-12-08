define(
    ['bootstrap', 'jquery', 'underscore', 'async!http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyD0K-y2C9IH2lUf6_kOt8Dvd9TOlZq7sqk', '1640', '1800', '1840', '1880', 'maplabel', 'bootstrap-slider', 'yearJumpLookup', 'intro'],
    function (bootstrap, $, _, googleMaps, boundaries1640, boundaries1800, boundaries1840, boundaries1880, MapLabel, bootstrapSlider, yearJumpLookup, intro) {

        var map;
        var drawBoundaries;
        var changeSelectedYear;

        return {
            initialize: function(eras, pois, onMapClick, onMarkerClick){
                var mapOptions = {
                    center: {lat: 41.7321983, lng: -72.8352574},
                    zoom: 10,
                    minZoom: 5
                };
                map = new google.maps.Map(document.getElementById('map'),
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

                var allYears = _.map(eras, function(year){
                    return parseInt(year, 10);
                });
                var selectedYear = allYears[0];
                var markers = [];

                changeSelectedYear = function(year){
                    selectedYear = year;
                };

                var boundaries = null;

                var titleInfoWindow = new google.maps.InfoWindow({});
                var summaryInfoWindow = new google.maps.InfoWindow({});
                var currentSummaryMarker = null;
                var pois = pois;

                var updatePOIs = function () {

                    var selectedCategories = $('input[name=categories]:checked').map(function () {
                        return $(this).val();
                    }).get();

                    var currentPOIs = _.filter(pois, function (poi) {
                        var forSelectedEra = _.some(poi.eras, function (era) {
                            return era.label == selectedYear
                        });

                        var poiCategories = _.map(poi.categories, function (category) {
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

                                if(onMarkerClick)
                                {
                                    onMarkerClick(poi);
                                }
                                else {
                                    summaryInfoWindow.setContent('<h3>' + poi.name + "</h3>" + poi.description + '<p><a href="#" id="learn-more">Learn More</a></p>');
                                    summaryInfoWindow.open(map, this);
                                    currentSummaryMarker = marker;
                                    titleInfoWindow.close();
                                }
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

                drawBoundaries = function () {

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

                boundaries = drawBoundaries();

                google.maps.event.addListener(boundaries, 'click', function () {
                    summaryInfoWindow.close();
                    currentSummaryMarker = null;
                });

                google.maps.event.addListener(map, 'click', function (e) {
                    summaryInfoWindow.close();
                    currentSummaryMarker = null;
                    if (onMapClick){
                        onMapClick(e);
                    }
                });

                updatePOIs();

                var roundTo = yearJumpLookup(allYears, 10);

                $('input[name=era]').slider({
                    min: allYears[0],
                    max: allYears[allYears.length - 1],
                    step: 10,
                    value: allYears[0],
                    tooltip: 'always',
                    handle: 'triangle'
                }).on('slide', function (e) {

                    var currentYear = parseInt(e.value, 10);
                    $(this).slider('setValue', roundTo[currentYear]);

                }).on('slideStop', function (e) {

                    selectedYear = parseInt(this.value, 10);
                    $(this).slider('setValue', roundTo[selectedYear]);
                    selectedYear = parseInt(this.value, 10);
                    updatePOIs();
                    drawBoundaries();
                    //If you move the slider, kill the intro.
                    if (intro.isDone() === false) {
                        intro.stopIntro(map);
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
                            imageContainer.append('<div class="item ' + (i === 0 ? 'active' : '') + '"><img src="/images/' + poi.photos[i].filename + '" alt="Carousel Photo"/></div>');
                        }
                        carousel.carousel();
                        carousel.show();
                    }
                    else {
                        carousel.hide();
                    }

                    var categories = modal.find('.categories');
                    categories.children().remove();
                    for (i = 0; i < poi.categories.length; i++) {
                        categories.append('<span class="label label-primary">' + poi.categories[i].label + '</span>');
                    }

                    modal.modal('show');

                    summaryInfoWindow.close();
                    currentSummaryMarker = null;
                });
            },
            startIntro: function(){

                intro.startIntro(map, drawBoundaries, changeSelectedYear);

            }
        };
    });
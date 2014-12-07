define(['mapOverlay', 'async!http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyD0K-y2C9IH2lUf6_kOt8Dvd9TOlZq7sqk', 'maplabel'], function(mapOverlay, googleMaps, MapLabel){

    var allEvents = [];
    var introDone = false;
    var lastText;

    var startIntro = function(map){

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

        // Initialize the map and the custom overlay.
        var swBound = new google.maps.LatLng(31.530507, -84.936474);
        var neBound = new google.maps.LatLng(46.573332, -67.872547);
        var bounds = new google.maps.LatLngBounds(swBound, neBound);
        var swBound2 = new google.maps.LatLng(40.988926, -73.658322);
        var neBound2 = new google.maps.LatLng(42.029617, -71.779317);
        var bounds2 = new google.maps.LatLngBounds(swBound2, neBound2);

        // The photograph
        var srcImage = '/images/Colonies_1763.jpg';
        var srcImage2 = '/images/1800sCT.jpg';

        var currentZoom;
        lastText = welcomeText;

        //Takes a new desired zoom level. Then zooms into it 1 zoom per .75 seconds to make it smoooooth.
        var smoothZoom = function (newZoom) {
            currentZoom = map.getZoom();

            if (newZoom > currentZoom) {
                allEvents.push(setTimeout(function () {
                    map.setZoom(currentZoom + 1);
                    smoothZoom(newZoom);
                }, 450));
            }
            else if (newZoom < currentZoom) {
                allEvents.push(setTimeout(function () {
                    map.setZoom(currentZoom - 1);
                    smoothZoom(newZoom);
                }, 450));
            }
        };

        var overlay = new mapOverlay(bounds, srcImage);

        allEvents.push(setTimeout(function () {
            map.panTo(new google.maps.LatLng(41.736645, -72.851353));
            welcomeText.setMap(null);
            exploreText.setMap(map);
            lastText = exploreText;
            smoothZoom(16);
        }, 3000));

        //Smooth out to the East Coast
        allEvents.push(setTimeout(function () {
            exploreText.setMap(null);
            smoothZoom(5);
        }, 8000));

        //Show the colonial America map and "From Colonial America"
        allEvents.push(setTimeout(function () {
            overlay.setMap(map);
            colonialText.setMap(map);
            lastText = colonialText;
        }, 13500));

        //Remove colonial America map and text. Then zoom to CT.
        allEvents.push(setTimeout(function () {
            colonialText.setMap(null);
            smoothZoom(9);
            map.panTo(new google.maps.LatLng(41.607955, -72.689579));
        }, 16500));

        //Show the 1800s CT map overlay and text.
        allEvents.push(setTimeout(function () {
            overlay.setMap(null);
            overlay = new MapOverlay(bounds2, srcImage2, map);
            eighteenText.setMap(map);
            lastText = eighteenText;
        }, 18500));

        //Remove the 1800s overlay, go to the Uconn Medical Center.
        allEvents.push(setTimeout(function () {
            map.panTo(new google.maps.LatLng(41.731445, -72.791100));
            eighteenText.setMap(null);
            smoothZoom(16);
        }, 21500));

        //Show the 1800s CT map overlay and text.
        allEvents.push(setTimeout(function () {
            overlay.setMap(null);
            todayText.setMap(map);
            lastText = todayText;
        }, 23500));

        //Event to show change borders over time
        allEvents.push(setTimeout(function () {
            todayText.setMap(null);
            map.set('minZoom', 9);
            smoothZoom(10);
        }, 26500));

        allEvents.push(setTimeout(function () {
            boundaryText.setMap(map);
            lastText = boundaryText;
            var i = 2500;
            while (i < 5500) {
                allEvents.push(setTimeout(function () {
                    selectedYear = 1900;
                    drawBoundaries();
                }, i));
                i = i + 1000;
                allEvents.push(setTimeout(function () {
                    selectedYear = 1610;
                    drawBoundaries();
                }, i));
                i = i + 1000;
            }
        }, 28500));

        //Sites Come and Go
        allEvents.push(setTimeout(function () {
            boundaryText.setMap(null);
            map.panTo(new google.maps.LatLng(41.721774, -72.824690));
            comeGoText.setMap(map);
            lastText = comeGoText;
            smoothZoom(15);
        }, 34500));

        allEvents.push(setTimeout(function () {
            var i = 2500;
            while (i < 5500) {
                allEvents.push(setTimeout(function () {
                    selectedYear = 9999;
                    updatePOIs();
                }, i));
                i = i + 1000;
                allEvents.push(setTimeout(function () {
                    selectedYear = 1920;
                    updatePOIs();
                }, i));
                i = i + 1000;
            }
        }, 36500));

        allEvents.push(setTimeout(function () {
            enjoyText.setMap(map);
            map.panTo(new google.maps.LatLng(41.7321983, -72.8352574));
            smoothZoom(10);
            lastText = enjoyText;
        }, 42000));

        allEvents.push(setTimeout(function () {
            enjoyText.setMap(null);
            introDone = true;
        }, 46500));
    };

    return {
        startIntro: startIntro,
        stopIntro: function(){
            //Called if you use the slider during the intro. Kills all the timed events.
            lastText.setMap(null);

            for (i = 0; i < allEvents.length; i++) {
                clearTimeout(allEvents[i]);
            }
            allEvents = [];
        },
        isDone: function(){
            return introDone;
        }
    };

});
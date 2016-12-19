<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet"
          type="text/css"
          media="screen"
          href="css/bootstrap.min.css">
    <link rel="stylesheet"
          type="text/css"
          media="screen"
          href="css/style.css">
    <link rel="stylesheet"
          type="text/css"
          media="screen"
          href="css/map.css">
    <title>Главная страница</title>
</head>
<body>
<?php
$page = 'map';
include('include/menu.php');
?>
<div class="container">
    <!-- Main component for a primary marketing message or call to action -->
    <div id="map" class="jumbotron">
        <script type="text/javascript">
            <?php
            include('include/markers.php');?>
            var json = <?php echo $jsonMarkers; ?>;
            var map;
            function initMap() {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: json.lat, lng: json.lng},
                    zoom: json.zoom
                });
                var allContent = new Array(json.markers.length);
                var infoWindow = new google.maps.InfoWindow();
                for (var i = 0; i < json.markers.length; i++) {
                    var marker = new google.maps.Marker({
                        map: map,
                        position: {
                            lat: parseFloat(json.markers[i].latitude),
                            lng: parseFloat(json.markers[i].longitude)
                        }
                    });
                    var content = '<b>' + json.markers[i].title + '</b><br>' + json.markers[i].address + '<br>';
                    if (json.markers[i].image) {
                        content += '<img src="' + json.markers[i].image + '" width=200/>';
                    }
                    if (json.markers[i].url) {
                        content += '<br><a href="' + json.markers[i].url + '" target="_blank">Перейти на сайт</a>';
                    }
                    allContent[i] = content;
                    google.maps.event.addListener(marker, 'click', (function (marker, i) {
                        return function () {
                            infoWindow.setContent(allContent[i]);
                            infoWindow.open(map, marker);
                        }
                    })(marker, i));
                }
            }
            ;
        </script>
    </div>
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZUM1IWmQ9snKi3GXbQQ67ArP21ggtOcg&callback=initMap">
    </script>
</div>
</body>
</html>
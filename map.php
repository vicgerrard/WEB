<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" media="screen" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/css/style.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/css/map.css">
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
            var map;
            function initMap() {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: -34.397, lng: 150.644},
                    zoom: 10
                });
                var marker = new google.maps.Marker({
                    map: map,
                    position: {lat: -34.397, lng: 150.644}
                });
                var infoWindow = new google.maps.InfoWindow({
                    content: 'It is alina\'s house'
                });
                marker.addListener('click', function () {
                    infoWindow.open(map, marker);
                })
            }
        </script>
    </div>
    <script src="/js/jquery-3.1.1.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZUM1IWmQ9snKi3GXbQQ67ArP21ggtOcg&callback=initMap">
    </script>
</div>
</body>
</html>
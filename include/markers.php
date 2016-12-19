<?php
/**
 * Created by PhpStorm.
 * User: Viktor
 * Date: 19.12.2016
 * Time: 22:46
 */
require "connection.php";
//get markers
$query = $conn->query("SELECT * FROM markers");
$markers = array();
while ($r = mysqli_fetch_assoc($query)) {
    $markers[] = $r;
}
//get map info
$query = $conn->query("SELECT * FROM map LIMIT 1");
$row = $query->fetch_row();

$centerLatitude = floatval($row[0]);
$centerLongitude = floatval($row[1]);
$zoom = intval($row[2]);

$json = array('lat' => $centerLatitude, 'lng' => $centerLongitude, 'zoom' => $zoom, 'markers' => $markers);
$jsonMarkers = json_encode($json);
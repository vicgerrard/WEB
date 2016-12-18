<?php
/**
 * Created by PhpStorm.
 * User: Viktor
 * Date: 18.12.2016
 * Time: 3:12
 */
                   //host        login  password database name
$conn = new mysqli('localhost', 'root', '', 'WEB');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
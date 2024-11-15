<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = "ecommerce";

// Create connection
$con = mysqli_connect("junction.proxy.rlwy.net", "root", "FfFyRiqELnqQgTLrwuHgMoSJEdcpLdRB", "railway", 46497);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}


?>
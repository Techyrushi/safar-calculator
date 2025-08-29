<?php

// $con = mysqli_connect("localhost", "u279113975_MCL_db", "MCL_db*123", "u279113975_MCL_website");
// if (mysqli_connect_errno()) {
// 	echo "Failed to connect to MySQL: " . mysqli_connect_error();
// }

$con = mysqli_connect("localhost", "root", "", "safar_db");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


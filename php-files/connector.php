<?php

if ((@include ('get-browser.php')) === false) {
    echo "get-browser not loaded!";
}

if ((@include ('get-country.php')) === false) {
    echo "get-country.php not loaded!";
}

if ((@include ('get-device.php')) === false) {
    echo "get-device.php not loaded!";
}

// include 'get-loc.php';

if ((@include ('get-source.php')) === false) {
    echo "get-source.php not loaded!";
}

if ((@include ('create_guid.php')) === false) {
    echo "create_guid.php not loaded!";
}

if ((@include ('create-first-imp.php')) === false) {
    echo "create-first-imp.php not loaded!";
}

if ((@include ('create-event.php')) === false) {
    echo "create-event.php not loaded!";
}

// DB Details

function connect_to_db()
{
    $servername = "gator3093.hostgator.com";
    $username   = "talnitza_beyond";
    $password   = "Drallinone21@";
    $dbname     = "talnitza_compare";

    // Create connection

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection

    if ($conn->connect_error) {

        die("Connection failed: " . $conn->connect_error);

    }
    return $conn;
}

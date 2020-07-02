<?php

// Special for Apps API
if (isset($_POST['inside4_session']) AND $_POST['inside4_session'] != '') $_COOKIE['inside4_session'] = $_POST['inside4_session'];
if (isset($_GET['inside4_session']) AND $_GET['inside4_session'] != '') $_COOKIE['inside4_session'] = $_GET['inside4_session'];


if (isset($_SERVER['HTTP_ORIGIN'])) $http_origin = $_SERVER['HTTP_ORIGIN'];
else $http_origin = "null";
if (
    $http_origin == "null" ||
    $http_origin == "file://" ||
    $http_origin == "http://localhost:8100" ||
    $http_origin == "http://localhost:8080" ||
    $http_origin == "https://inside4sandbox.ikiev.biz"


)
{
    header("Access-Control-Allow-Origin: *");
}


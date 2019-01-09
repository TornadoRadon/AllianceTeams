<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 03.01.2019
 * Time: 18:55
 */
$mysqli;
    include_once "mysqlLogin.php";
    if ($mysqli->connect_errno) {
        echo "MySQL - connecting error : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
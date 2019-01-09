<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 30.12.2018
 * Time: 16:53
 */
$mysqli;
if($_SESSION['log'] === 'logged') {
    //////proverka na truebelieve
    if (!empty($_SESSION['id']) && !empty($_SESSION['password'])) {
        include_once "mysqlLogin.php";
        if ($mysqli->connect_errno) {
            echo "MySQL - connecting error : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        } else {
            /*user informations*/
            $data = $mysqli->query("SELECT * FROM $base.user WHERE id = {$_SESSION['id']}");
            $row = $data->fetch_assoc();
            if (!$row['id'] == $_SESSION['id'] && !$row['password'] == $_SESSION['password']) {
                header("refresh:0 url=error.php");
                die();
            }
        }
    } else {
        header("refresh:0 url=error.php");
        die();
    }
}else{
    header("refresh:0 url=error.php");
    die();
}
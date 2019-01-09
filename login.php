<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 09.12.2018
 * Time: 13:18
 */

error_reporting(-1);
session_start();
if (!empty($_SESSION['log']) && $_SESSION['log'] == 'logged') {
    header("refresh:0 url=home.php");
    die();
}elseif ( !empty($_POST['id']) && !empty($_POST['password']) ) {
    include_once "mysqlLogin.php";
    if ($mysqli->connect_errno) {
        echo "MySQL - connecting error : ( " . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    } else {
        $data = $mysqli->query("SELECT * FROM $base.user where id IN ({$_POST['id']})");
        $row = $data->fetch_assoc();
        if ($row['id'] === $_POST['id'] && $row['password'] === $_POST['password']) {
            $_SESSION['id'] = $_POST['id'];
            $_SESSION['password'] = $_POST['password'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['level'] = $row['level'];
            $_SESSION['log'] = 'logged';
            if($_SESSION['level'] == 'regs' )header("refresh:0 url=reg.php");
            elseif($_SESSION['level'] == 'buxg' )header("refresh:0 url=accountant.php");
            elseif($_SESSION['level'] == 'admin' )header("refresh:0 url=home.php");
            else header("refresh:0 url=cabinet.php");
            die();
        }else{
            header("refresh:0 url=error.php");
            die();
        }
        mysqli_close($mysqli);
    }
}else{
    header("refresh:0 url=error.php");
    die();
}

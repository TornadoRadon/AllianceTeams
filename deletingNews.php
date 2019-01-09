<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 30.12.2018
 * Time: 20:49
 */

session_start();
include_once 'mysqlConnector.php';
    if( !empty($_POST['orderid']) ){

        if(!$mysqli->query("DELETE FROM `news` WHERE `news`.`newsid` = '{$_POST['orderid']}'")){
            echo $mysqli->error;
        }else{
            echo "success";
        }

    }



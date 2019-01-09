<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 30.12.2018
 * Time: 14:48
 */

    include_once 'mySQLConnector2.0.php';
//    sleep(1); /*loader chiroyli ishlashi uchun XD*/
    /*offer ID listener for offer Node*/
    if (  !empty($_POST['offerID'])  ){
        $data = $mysqli->query("SELECT * FROM $base.user WHERE `id` = {$_POST['offerID']}");
        if($row = $data -> fetch_assoc()){
            if ($_POST['offerID'] == $row['id']){
                include_once 'offerNode.php';
            }else{
                echo "error"; die();
            }
        }else{
            echo "error"; die();
        }
    }elseif (  !empty($_POST['RegID'])  ){
        $data = $mysqli->query("SELECT * FROM $base.user WHERE `id` = {$_POST['RegID']}");
        if($row = $data -> fetch_assoc()){
            if ($_POST['RegID'] == $row['id']){
                include_once 'regNode.php';
            }else{
                echo "error"; die();
            }
        }else{
            echo "error"; die();
        }
    }else{
        echo "error"; die();
    }


?>



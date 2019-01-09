<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 07.01.2019
 * Time: 1:28
 */

include_once 'mySQLConnector2.0.php';

date_default_timezone_set("Asia/Tashkent");
$dateTime  = date("Y-m-d H:i:s");



/* --------------------------------- userlar o`rtasida transferlar mavjud emas----------------transvalue 0 ga teng bo`lganda EMPTY() - true qaytaradi-------------------------*/
if (  !empty($_POST['userID']) && /*!empty($_POST['idFrom']) &&*/ !empty($_POST['idTo']) && /*!empty($_POST['transValue']) &&*/  !empty($_POST['Comment']) &&  !empty($_POST['Password']) ){
    $data = $mysqli->query("SELECT * FROM $base.user WHERE `id` = {$_POST['userID']}");
    $row = $data ->fetch_assoc();
    if( $row['password'] != $_POST["Password"] ){ echo "Password-error"; die(); }
    /*variables*/
//    $idFrom = $_POST["idFrom"];
    $userID = $_POST['userID'];
    $idTo = $_POST["idTo"];
    $transValue = $_POST["transValue"];
    $Comment = $_POST["Comment"];
    $Password = $_POST["Password"];

    if($transValue == 0){echo "transValue-error"; die();}

    if($mysqli->query("INSERT INTO transfers (`idto`,`transvalue`,`transdate`,`comment`) VALUES ('{$idTo}','{$transValue}','{$dateTime}','{$Comment}')")){
        $data = $mysqli->query("SELECT * FROM $base.user WHERE `id` = $idTo");
        $row = $data ->fetch_assoc();
        $currentBalance = $row['balance'];
        $currentBalance += $transValue;
        if ($mysqli->query("UPDATE `user` SET balance = $currentBalance WHERE id = $idTo"))
            echo "success!";
        else
            echo "updateUserBalance-error"; die();
    }else{
        echo $mysqli->error; die();
    }
}elseif( !empty($_POST['idTo'])  ){
    if($data = $mysqli->query("SELECT * FROM $base.user WHERE `id` = {$_POST['idTo']}")){
        $row = $data -> fetch_assoc();
        if ($_POST['idTo'] == $row['id']){
            include_once 'offerNode.php';
        }else{
            echo "error"; die();
        }
    }else{
        echo "sqlSelect-error"; die();
    }
}else{
    echo "error"; die();
}








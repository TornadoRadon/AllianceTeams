<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 08.01.2019
 * Time: 12:49
 */

include_once 'mySQLConnector2.0.php';

date_default_timezone_set("Asia/Tashkent");
$dateTime  = date("Y-m-d H:i:s");

if ( !empty($_POST['userID']) && !empty($_POST['Password']) ){
    $data = $mysqli->query("SELECT * FROM $base.user WHERE `id` = '{$_POST['userID']}'");
    $row = $data->fetch_assoc();
    if($row['password'] === $_POST['Password']) {
        $data2 = $mysqli->query("SELECT * FROM `accountant` WHERE `userid` = '{$_POST['userID']}' and `answer` = 'unknown' ");
        if($data2->num_rows == 0) {
            if ($mysqli->query("INSERT INTO `accountant` (`userid`,`answer`,`date`)
                                VALUES('{$_POST['userID']}','unknown','{$dateTime}')")) {
                echo "So`rovingiz qabul qilindi!";
            } else {
                echo $mysqli->error;
            }
        }else{
            echo "Avvalgi so`rovingiz ko`rib chiqilmaguncha yangisini yubora olmaysiz!";
        }
    }else{
        echo "Password-invalid-value-error";
    }

}else{
    echo "Password-empty";
}


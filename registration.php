<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 03.01.2019
 * Time: 23:28
 */

include_once 'mySQLConnector2.0.php';

date_default_timezone_set("Asia/Tashkent");
$dateTime  = date("Y-m-d H:i:s");
$returnMessage = "";

$offerID = $_POST['offerID'];
$RegID = $_POST['RegID'];
$Name = $_POST['Name'];
$SurName = $_POST['SurName'];
$FatherName = $_POST['FatherName'];
$TelNum = $_POST['TelNum'];
$Region = $_POST['Region'];
$BirthDay = $_POST['BirthDay'];
$PassportNum = $_POST['PassportNum'];
$CardNum = $_POST['CardNum'];
$Jinsi = $_POST['Jinsi'];
$Password = $_POST['Password'];

$emptyHand = " ";
$newUserID = " ";
$regIDChildNum = 0;
if (
    !empty($_POST['offerID']) && !empty($_POST['RegID']) && !empty($_POST['Name']) &&
    !empty($_POST['SurName']) && !empty($_POST['FatherName']) && !empty($_POST['TelNum']) &&
    !empty($_POST['Region']) && !empty($_POST['BirthDay']) && !empty($_POST['PassportNum']) &&
    !empty($_POST['CardNum']) && !empty($_POST['Jinsi']) && !empty($_POST['Password'])
){
    if ($data = $mysqli -> query("SELECT * FROM $base.user WHERE `id` = {$RegID}")){
        if ( searchEmptyHand($data) ) {
            if (sqlQueryInsert()) { /*new user data insert*/
                if(searchCurrentUserID()){
                    if(insertBossHandID()){
                        echo "sqlInsert-success";
                    }else{
                        echo "insertBossHandIDError";
                    }
                }else{
                    echo "searchCurrentUserIDError";
                }
            }else{
                echo "sqlQueryInsertError";
            }
        }else{
            echo "searchEmptyHandError";
        }
    }else{
        echo $mysqli->error;
    }

}else{
    echo "form-values-error";
}

function sqlQueryInsert(){
    global $RegID,$offerID,$TelNum,$Name,$SurName,$FatherName,$Password,$Region,$Jinsi,$dateTime,$BirthDay,$PassportNum,$CardNum,
           $base,$mysqli;

    if($data = $mysqli -> query("INSERT INTO $base.user 
            (
            `idboss`,
            `offerid`,
            `tel`,
            `name`,
            `surname`,
            `fathersname`,
            `password`,
            `region`,
            `jinsi`,
            `level`,
            `regdate`,
            `birthday`,
            `passport`,
            `cardnumber`
            )
             VALUES (
             '{$RegID}',
             '{$offerID}',
             '{$TelNum}',
             '{$Name}',
             '{$SurName}',
             '{$FatherName}',
             '{$Password}',
             '{$Region}',
             '{$Jinsi}',
             'user',
             '{$dateTime}',
             '{$BirthDay}',
             '{$PassportNum}',
             '{$CardNum}'
             )"
    )){
        return true;
    }else return false;
}

function searchEmptyHand($data){
    global $emptyHand,$regIDChildNum;
    $row = $data ->fetch_assoc();
    $regIDChildNum = $row['childnumber'];
    if($row['idl'] == 0) {
        $emptyHand = "idl";
        return true;
    }
    if($row['idr'] == 0) {
        $emptyHand = "idr";
        return true;
    }
    return false;
}

function searchCurrentUserID(){
    global $mysqli,$newUserID;
    if($data = $mysqli -> query("SELECT * FROM user ORDER BY ID DESC LIMIT 1")){
        $row = $data->fetch_assoc();
        $newUserID = $row['id'];
        return true;
    }else return false;
}

function insertBossHandID(){ /*inserting hand id and childNumber++ */
    global $mysqli,$newUserID,$emptyHand,$RegID,$regIDChildNum;
    $regIDChildNum++;
    if($mysqli -> query("UPDATE `user` SET $emptyHand=$newUserID, `childnumber`=$regIDChildNum WHERE id = $RegID")){
        return true;
    }else return false;
}


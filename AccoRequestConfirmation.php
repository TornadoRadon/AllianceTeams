<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 08.01.2019
 * Time: 14:47
 */

include_once 'mySQLConnector2.0.php';

date_default_timezone_set("Asia/Tashkent");
$dateTime  = date("Y-m-d H:i:s");

if ( !empty($_POST['Password']) && !empty($_POST['answer']) && !empty($_POST['requestID']) && !empty($_POST['comment']) ){

    $Password = $_POST['Password'];
    $answer = $_POST['answer'];
    $requestID = $_POST['requestID'];
    $comment = $_POST['comment'];

    $value;
                                                            /*this is bookkeeper id = 0000005*/
    $data = $mysqli->query("SELECT * FROM $base.user WHERE `id` = '0000005'");
    $row = $data->fetch_assoc();

    if($row['password'] == $Password) {

        $dataRequest = $mysqli->query("SELECT * FROM accountant WHERE `id` = '$requestID'");
        $rowRequest = $dataRequest->fetch_assoc();
        if($rowRequest['answer'] != 'unknown') {
            echo "AnsweredRequest-error";
            die();
        }
        if ($answer == 'apply'){
            $dataUser = $mysqli->query("SELECT * FROM $base.user WHERE `id` = '{$rowRequest['userid']}'");
            $rowUser = $dataUser->fetch_assoc();
            $mysqli->query("UPDATE accountant 
                                  SET 
                                    `value`  = '{$rowUser['balance']}',
                                    `answer` = 'applied',
                                    `date`   = '{$dateTime}',
                                    `comment`= '{$comment}'
                                  WHERE `id` = '$requestID'");
            $mysqli->query("UPDATE $base.user 
                                  SET 
                                    balance  = '0'
                                  WHERE id = '{$rowUser['id']}'");
            echo "SuccessConfirmed";

        }elseif ($answer == 'deny'){
            $mysqli->query("UPDATE accountant 
                                  SET 
                                    `answer` = 'denied',
                                    `date`   = '{$dateTime}',
                                    `comment`= '{$comment}'
                                  WHERE `id` = '$requestID'");
            echo "SuccessConfirmed";
        }else echo "InvalidAnswer-error";

    }else{
        echo "Password-invalid-value-error";
    }

}else{
    echo "PasswordOrInput-empty";
}



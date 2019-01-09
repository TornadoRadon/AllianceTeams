<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 06.01.2019
 * Time: 23:54
 */

session_start();
/*level protection*/
if (!empty($_SESSION['log']) && $_SESSION['log'] == 'logged') {
    if( !($_SESSION['level'] == 'user' || $_SESSION['level'] == 'admin' ||  $_SESSION['level'] == 'root') ){
        header("refresh:0 url=error.php");die();
    }
}else{
    header("refresh:0 url=index.php");
    die();
}


include_once 'mysqlConnector.php';



/*news*/
$dataNews = $mysqli->query("SELECT * FROM $base.news");
?>

<!DOCTYPE html>
<html lang="en">

<?php include_once 'header.php'?>
<body>
<div class="bodyContent">

    <?php include_once 'topmenu.php'?>
    <?php include_once 'leftmenu.php'?>

    <div class="main">

        <!--block for news-->
        <?php
        $rowNews = [];
        while($rowNewsx = $dataNews ->fetch_assoc()){
            array_push($rowNews,$rowNewsx);
        }
        $rowNews=array_reverse($rowNews); /*teskari massiv*/
        foreach($rowNews as $rowx){?>
            <div class="block">
                <div class="blockTitle" id="softAnim">
                    <div style="font-size: small"><?echo $rowx["createdtime"]?></div><?echo $rowx["title"]?>
                </div>
                <div class="blockContent">
                    <?echo $rowx["content"]?>
                </div>
            </div>
        <?php }?> <!--end news-->

        <div class="block" style="width: 50%">
            <div class="blockTitle">
                Your data:
            </div>
            <div class="blockContent" style="padding-bottom: 35px" >
                Your ID: <?echo $row["id"]?><br>
                Your boss ID: <?echo $row["idboss"]?><br>
                Your Offer ID: <?echo $row["offerid"]?><br>
                Password: <?echo $row["password"]?><br>
                Region: <?echo $row["region"]?><br>
                Level: <?echo $row["level"]?><br>
                Registration date: <?echo $row["regdate"]?><br>
                Passport series/number: <?echo $row["passport"]?><br>
                card number: <?echo $row["cardnumber"]?><br>
                child number: <?echo $row["childnumber"]?><br>
            </div>
        </div>

        <div class="block" style="width: 50%">
            <div class="blockTitle">
                Pul chiqarish:
            </div>
            <div class="blockContent" style="padding-bottom: 35px" >
                Balance: <?echo $row["balance"]?> so`m</br>
                <div class="divInputReg">
                    <input type="password" class="inputReg" id="inputPassword" required autocomplete="off" minlength="5" maxlength="16">
                    <div class="labelInputReg">Password</div>
                </div>
                <input type="button" class="submitButton" id="submitButton" value="Pul chiqarish uchun so`rov!">
            </div>
        </div>
    </div>
</div>
</body>

<script>
    $("#submitButton").click(function () {
        if (<?echo $row["balance"]?> != 0){
            if (confirm("Aniqmi?")) {
                $.post("userRequestConfirmation.php", {
                        userID: '<?echo $_SESSION['id']?>',
                        Password: $("#inputPassword").val()
                    },
                    function (data, status) {
                        if (data == "error") {
                            alert(data);
                        } else {
                            alert(data);
                        }

                    }
                )
            }
        }else{
            alert("Balansingizda yetarli mablag` mavjud emas!");
        }
    });
</script>

<script src="js/animatedBG.js" type="text/javascript"></script>
<script>
    startSoftAnim();
</script>
</html>



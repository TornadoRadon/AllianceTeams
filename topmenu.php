<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 30.12.2018
 * Time: 14:59
 */
include_once "mySQLConnector2.0.php";
$dataLinks = $mysqli -> query("SELECT * FROM `links`");
$dataUser = $mysqli -> query("SELECT * FROM $base.user WHERE id = '{$_SESSION['id']}'");
$rowUser = $dataUser ->fetch_assoc();
while ($rowLinks = $dataLinks -> fetch_assoc()){
    if ($rowLinks['socname'] == "facebook"){$facebook = $rowLinks["link"];}
    if ($rowLinks['socname'] == "telegram"){$telegram = $rowLinks["link"];}
    if ($rowLinks['socname'] == "twitter"){$twitter = $rowLinks["link"];}
    if ($rowLinks['socname'] == "ok"){$odnoklassniki = $rowLinks["link"];}
}
?>
<div class="topMenu">
    <img class="logoImg" src="images/logo.png"> <!--logo image-->
    <div class="topMenuBalance">Balans: <?php echo $rowUser['balance']?> so'm</div> <!--Balans-->
    <a class="hrefExit" href="logout.php">EXIT</a> <!--button exit-->
    <div class="links">
        <a href="<?php echo $facebook?>"><i class="fab fa-facebook-square" style="cursor: pointer;font-size: 2em;"></i></a>
        <a href="<?php echo $telegram?>"><i class="fab fa-telegram" style="cursor: pointer;font-size: 2em;"></i></a>
        <a href="<?php echo $twitter?>"><i class="fab fa-twitter-square" style="cursor: pointer;font-size: 2em;"></i></a>
        <a href="<?php echo $odnoklassniki?>"><i class="fab fa-odnoklassniki-square" style="cursor: pointer;font-size: 2em;"></i></a>
    </div>
</div>
<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 29.12.2018
 * Time: 20:38
 */
error_reporting(-1);
session_start();
if (!empty($_SESSION['log']) && $_SESSION['log'] == 'logged') {
    if($_SESSION['level'] == 'regs' )header("refresh:0 url=reg.php");
    elseif($_SESSION['level'] == 'buxg' )header("refresh:0 url=accountant.php");
    elseif($_SESSION['level'] == 'admin' )header("refresh:0 url=home.php");
    else header("refresh:0 url=cabinet.php");
    die();
}

include_once "mySQLConnector2.0.php";
$dataLinks = $mysqli -> query("SELECT * FROM `links`");

while ($rowLinks = $dataLinks -> fetch_assoc()){
    if ($rowLinks['socname'] == "facebook"){$facebook = $rowLinks["link"];}
    if ($rowLinks['socname'] == "telegram"){$telegram = $rowLinks["link"];}
    if ($rowLinks['socname'] == "twitter"){$twitter = $rowLinks["link"];}
    if ($rowLinks['socname'] == "ok"){$odnoklassniki = $rowLinks["link"];}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Alliance Teams sign in page</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap-reboot.css">
    <link rel="stylesheet" type="text/css" href="css/all-font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<!-- forma regstratsiya -->
<div id="formBorder" class="formborder">
    <form method="post" action="login.php" class="signUp" id="signupForm">
        <h1 class="signUpTitle">LOGIN form</h1>
        <input type="text" name="id" class="signUpInput" placeholder="ID" autofocus maxlength="7" minlength="1" required>
        <input type="password" name="password" class="signUpInput" placeholder="PASSWORD" maxlength="16" minlength="1" required>
        <button type="submit" name="login" class="signUpButton">SIGN IN!</button>
    </form>
</div>

<div class="links">
    <a href="<?php echo $facebook?>"><i class="fab fa-facebook-square" style="cursor: pointer;font-size: 2em;padding-top:10px"></i></a>
    <a href="<?php echo $telegram?>"><i class="fab fa-telegram" style="cursor: pointer;font-size: 2em;padding-top:10px"></i></a>
    <a href="<?php echo $twitter?>"><i class="fab fa-twitter-square" style="cursor: pointer;font-size: 2em;padding-top:10px"></i></a>
    <a href="<?php echo $odnoklassniki?>"><i class="fab fa-odnoklassniki-square" style="cursor: pointer;font-size: 2em;padding-top:10px"></i></a>
</div>
</body>
<script type="text/javascript" src="js/animatedBG.js" ></script>
<script>
    startFormAnim();
</script>
</html>
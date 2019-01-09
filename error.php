<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 14.12.2018
 * Time: 22:25
 */
    session_start();
    if (!empty($_SESSION['log']) && $_SESSION['log'] == 'logged') {
            if($_SESSION['level'] == 'regs' ){
                header("refresh:3 url=reg.php");
            }elseif($_SESSION['level'] == 'buxg' ){
                header("refresh:3 url=accountant.php");
            }elseif($_SESSION['level'] == 'admin' ){
                header("refresh:3 url=home.php");
            }else{
                header("refresh:3 url=cabinet.php");
            }
    }else header("refresh:3 url=index.php");

?>




<?php
    echo "ERROR MESSAGES! </br>";
    if(!empty($_SESSION['errorMSG'])) { echo $_SESSION['errorMSG']."</br>"; $_SESSION['errorMSG'] = ''; };

    echo "<a href='index.php'>Home</a><br>";
    if(!empty($_SESSION['log'])) {echo "<a href='cabinet.php'>Cabinet</a>";}
?>


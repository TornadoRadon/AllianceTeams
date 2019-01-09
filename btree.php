<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 21.12.2018
 * Time: 10:16
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


///////////////////////////////////////////// karoch copy paste hechnimani chunmadim :)
$arrID = []; /*idlar ro`yxati. ichiga 000000 idlar ham kiritiladi(shunchaki to`plab keyin qadamba-qadam $arrayBTREE to`ldirib boriladi. )
 000000 idlar ham kiritilishining asosiy sababi birorta userning tagida user bo`lmasa $arrIDIndex noto`g`ri ishlaydi! */
$arrayBTREE = []; /*arrID ichidan idlar sug`urib olinib SQL zapros bilan to`ldirib boriladi, 000000 idlar o`tkazib yuboriladi*/
$data = $mysqli->query("SELECT * FROM base.user WHERE id = {$_SESSION['id']}");
$row = $data->fetch_assoc();
$arrID = $arrID + [0 => $_SESSION['id']];
$usersCount=0;
for ($i = 0 , $arrIDIndex = 0, $newUser = 0; $usersCount <= $newUser; $i++){
    if($arrID[$i] != '0000000') {
        $usersCount++;
        if($data = $mysqli->query("SELECT * FROM base.user WHERE id = {$arrID[$i]}")) {
            $row = $data->fetch_assoc();
            $arrIDIndex++;
            $arrID = $arrID + [$arrIDIndex => $row['idl']];
            $arrIDIndex++;
            $arrID = $arrID + [$arrIDIndex => $row['idr']];
            $arrayBTREE = $arrayBTREE + [$row['id'] => $row];
            if ($row['idl'] != '0000000'){$newUser++;}
            if ($row['idr'] != '0000000'){$newUser++;}
        }else{
            header("refresh:0 url=error.php");
            die();
        }

    }
}
///////////////////////////////////////////// karoch copy paste :)

?>
<!DOCTYPE html>
<html lang="en">

<?php include_once 'header.php'?>

<body>
<div class="bodyContent">

    <?php include_once 'topmenu.php'?>
    <?php include_once 'leftmenu.php'?>

    <div class="main">

        <div class="block">
            <div class="blockTitle">
                BinaryTREEE <i class="fas fa-search-plus" id="zoomButton" style="cursor: pointer;"></i>
            </div>
            <div class="blockContent" id="zoomingObject">
                <div id="BinaryTree-chart-container"></div>
            </div>
        </div>

    </div>
</div>
</body>

<link href="css/jquery.orgchart.css" rel="stylesheet" type="text/css">
<script src="js/jquery.orgchart.js" type="text/javascript"></script>

<script type="text/javascript">
        $(function() {
            var datascource = {
                <?php /* WARNING function ContentMaker have recursion! */
                function ContentMaker($arrXLocal, $index)
                {
                    echo "'name' : '{$arrXLocal[$index]['name']} {$arrXLocal[$index]['surname']}',";
                    echo "'title' : '{$arrXLocal[$index]['level']}',";
                    echo "'infoID' : '{$arrXLocal[$index]['id']}',";
                    echo "'infoTel' : '{$arrXLocal[$index]['tel']}',";
                    if ( $arrXLocal[$index]['idl'] != $arrXLocal[$index]['idr'] ) { /*agar children bo'lsa*/

                        echo "'children': [";

                        if ( $arrXLocal[$index]['idl'] != '0000000' ) { /*agar chap qo'lida user bo`lsa*/
                            echo "{";
                            ContentMaker( $arrXLocal  ,  $arrXLocal[$index]['idl']  );/* recursion! */
                            echo "}";
                        }

                        if ( $arrXLocal[$index]['idr'] != '0000000' ) { /*agar o'ng qo'lida user bo`lsa*/
                            if ( $arrXLocal[$index]['idl'] != '0000000' ) echo ",";
                            echo "{";
                            ContentMaker( $arrXLocal  ,  $arrXLocal[$index]['idr']  );/* recursion! */
                            echo "}";
                        }
                        echo "]";
                    }
                }
                /* WARNING starting recursion! */
                ContentMaker($arrayBTREE, $_SESSION['id']);
                /* WARNING recursWARNING recursWARNING recursWARNING recursion!ion!ion!ion! */
                ?>
            };

            var oc = $('#BinaryTree-chart-container').orgchart({
                'data' : datascource,
                'nodeContent': 'title',
                'initCompleted': function ($chart) {
                    var $container = $('#BinaryTree-chart-container');
                    $container.scrollLeft(($container[0].scrollWidth - $container.width())/2);
                },
                'draggable': false,
                'pan': true,
                'zoom': true
            });

            oc.$chartContainer.on('touchmove', function(event) {
                event.preventDefault();
            });

        });

        /*zooming current object with zoomerButton*/
    document.getElementById('zoomButton').addEventListener('click',function () {
        elem = document.getElementById('zoomingObject');
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.msRequestFullscreen) {
            elem.msRequestFullscreen();
        } else if (elem.mozRequestFullScreen) {
            elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullscreen) {
            elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    })
</script>
</html>

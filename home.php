<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 09.12.2018
 * Time: 14:02
 */
session_start();
/*level protection*/
if (!empty($_SESSION['log']) && $_SESSION['log'] == 'logged') {
    if( !($_SESSION['level'] == 'admin' ||  $_SESSION['level'] == 'root') ){
        header("refresh:0 url=error.php");die();
    }
}else{
    header("refresh:0 url=index.php");
    die();
}

include_once 'mysqlConnector.php';

/*news*/
$dataNews = $mysqli->query("SELECT * FROM $base.news");
$dataAllUsersRegion  = $mysqli->query("SELECT * FROM $base.user WHERE `level` = 'user'");
$dataAllUsersRegDate = $mysqli->query("SELECT * FROM $base.user WHERE `level` = 'user'");
?>

<!DOCTYPE html>
<html lang="en">

    <?php include_once 'header.php'?>
    <script type="text/javascript" src="js/Moment.js"></script>
    <script type="text/javascript" src="js/Chart.js"></script>
    <script type="text/javascript" src="js/utils.js"></script>
<body>
<div class="bodyContent">

    <?php include_once 'topmenu.php'?>
    <?php include_once 'leftmenu.php'?>

    <div class="main">
        <!--mini elements of stats-->
        <?php include_once 'cards.php'?>

        <!--blocks for news-->

        <div class="block" >
            <div class="blockContent">
                <?
//                $arrRegDate = [];
//                $arrRegDate = ['a' => 1 , 'c' => 1 ];
//                $arrRegDate += ['d' => 1 , 'a' => 2 ];
//                $arrRegDate = ['d' => 1 , 'a' => 2 ];
//                echo print_r($arrRegDate);
//
//                while ($rowRegDate = $dataAllUsersRegDate ->fetch_assoc()){
//
//                }
//                $date = date_create('2018-01-07 22:26:30');
//                echo "<br>";
//                echo date_format($date, 'Y m d');
                ?>
            </div>
        </div>

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


        <!--stats charts-->
        <div class="block" style="width: 50%;">
            <div class="blockTitle">
                Viloyatlar bo`yicha
            </div>
            <div class="blockContent" >
                 <canvas id="ChartByRegion" width="400" height="321"></canvas>
            </div>
        </div>

        <div class="block" style="width: 50%;">
            <div class="blockTitle">
                Ro`yhatdan o`tgan userlar soni bo`yicha (TEST)
            </div>
            <div class="blockContent" >
                <canvas id="ChartByRegDate" width="400" height="321"></canvas>
            </div>
        </div>

        <!--end charts-->

    </div>
</div>
</body>
    <script type="text/javascript" src="js/chart1.js"></script>
<script>
    /*add data for charts*/

    <?php
    $arrChartByRegDate = [];
    $arrRegion = [
        "Navoiy" => 0,
        "Toshkent" => 0,
        "Andijon" => 0,
        "Namangan" => 0,
        "Buxoro" => 0,
        "Jizzax" => 0,
        "Samarqand" => 0,
        "Surxondaryo" => 0,
        "Qashqadaryo" => 0,
        "Sirdaryo" => 0,
        "Xorazm" => 0,
        "Farg`ona" => 0,
        "Qoraqalpog`iston" => 0
    ];
    while ($rowUser = $dataAllUsersRegion ->fetch_assoc()){
        $arrRegion[$rowUser['region']]++;
    }?>
    <?php foreach ( $arrRegion as $key => $value) {?>
        addData(ChartByRegion,'<?echo $key?>',<?echo $value?>);
    <?php }?>

</script>

    <script>
        function randomNumber(min, max) {
            return Math.random() * (max - min) + min;
        }

        function randomBar(date, lastClose) {
            var open = randomNumber(lastClose * 0.95, lastClose * 1.05);
            var close = randomNumber(open * 0.95, open * 1.05);
            return {
                t: date.valueOf(),
                y: close
            };
        }

        var dateFormat = 'MMMM DD YYYY';
        var date = moment('<? echo date("Y m d")?>', dateFormat);
        var data = [randomBar(date, 30)];
        var labels = [date];
        while (data.length < 7) {
            date = date.clone().add(1, 'd');
            if (date.isoWeekday() <= 5) {
                data.push(randomBar(date, data[data.length - 1].y));
                labels.push(date);
            }
        }

        var ctx = document.getElementById('ChartByRegDate').getContext('2d');

        var color = Chart.helpers.color;
        var cfg = {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Oxirgi haftada',
                    backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
                    borderColor: window.chartColors.red,
                    data: data,
                    type: 'bar',
                    pointRadius: 0,
                    fill: false,
                    lineTension: 0,
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        type: 'time',
                        distribution: 'series',
                        ticks: {
                            source: 'labels'
                        }
                    }],
                    yAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Closing price ($)'
                        }
                    }]
                }
            }
        };
        var chart = new Chart(ctx, cfg);

    </script>
<script src="js/animatedBG.js" type="text/javascript"></script>
<script>
    startSoftAnim();
</script>
</html>

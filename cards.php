<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 30.12.2018
 * Time: 15:02
 */

$dataAllUsers = $mysqli->query("SELECT * FROM $base.user");
$dataAllTransfers = $mysqli->query("SELECT * FROM `transfers`");
$dataAllPayed = $mysqli->query("SELECT * FROM `accountant` where `answer` = 'applied'");
date_default_timezone_set("Asia/Tashkent");
$Today  = date("Y-m-d");


$balanceAllUsers = 0;
$count_users = 0;
$ValueAllTransfers = 0;
$ValuePayed = 0;

while ($dataX = $dataAllUsers -> fetch_assoc()) {
    $balanceAllUsers += $dataX['balance'];
    if($dataX['level'] == 'user')$count_users++;
}
while ($rowAllTransfers = $dataAllTransfers -> fetch_assoc()) {
    if($rowAllTransfers['transvalue'] > 0) $ValueAllTransfers += $rowAllTransfers['transvalue'];
}
while ($rowPayed = $dataAllPayed -> fetch_assoc()) {
    $ValuePayed += $rowPayed['value'];
}

?>
<div class="stats">
    <div class="Card" style="background-color: #ff7675">
        <div class="CardTitle" >
            Foydalanuvchilar soni:
        </div>
        <div class="CardContent">
            <?echo $count_users?>
        </div>
        <div class="CardTip">
            umumiy hisobda
        </div>
    </div>
    <div class="Card" style="background-color: #00cec9">
        <div class="CardTitle">
            Umumiy balans:
        </div>
        <div class="CardContent">
            <script>
                const numberWithCommas = (x) => {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                };
                document.write(numberWithCommas(<?echo $balanceAllUsers?>))
            </script>
        </div>
        <div class="CardTip">
            so`m
        </div>
    </div>
    <div class="Card" style="background-color: #74b9ff">
        <div class="CardTitle">
            Transferlar qiymati:
        </div>
        <div class="CardContent">
            <?echo $ValueAllTransfers?>
        </div>
        <div class="CardTip">
            so`m (umumiy hisobda)
        </div>
    </div>
    <div class="Card" style="background-color: #a29bfe">
        <div class="CardTitle">
            Pul chiqarilgan:
        </div>
        <div class="CardContent">
            <?echo $ValuePayed?>
        </div>
        <div class="CardTip">
            so`m (shu paytgacha)
        </div>
    </div>
</div>

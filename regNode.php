<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 03.01.2019
 * Time: 20:26
 */

if ($row['idl'] == '0000000'){
    $row['idl'] = " ";
}
if ($row['idr'] == '0000000'){
    $row['idr'] = " ";
}
?>
<div class="ORGnode">
    <div class="nodeTitle"><?echo $row['name']?></div>
    <div class="nodeContent">
        <?echo $row['level']?>
    </div>
    <div class="nodeInfoContent">
        ID: <?echo $row['id']?> </br>
        Tel: <?echo $row['tel']?>
    </div>
</div>
</br><i class="fas fa-angle-up"></i></br>
<!--left hand-->
<div class="ORGnode">
    ID_left: <div class="nodeTitle" id="idl"><?echo $row['idl']?></div>
<!--    <div class="nodeContent"></div>-->
<!--    <div class="nodeInfoContent"></div>-->
</div>
<!--right hand-->
<div class="ORGnode">
    ID_right: <div class="nodeTitle" id="idr"><?echo $row['idr']?></div>
<!--    <div class="nodeContent"></div>-->
<!--    <div class="nodeInfoContent"></div>-->
</div>
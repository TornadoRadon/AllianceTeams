<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 03.01.2019
 * Time: 20:25
 */
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
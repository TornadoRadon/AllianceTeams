<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 07.01.2019
 * Time: 0:47
 */

session_start();
/*level protection*/
if (!empty($_SESSION['log']) && $_SESSION['log'] == 'logged') {
    if( !($_SESSION['level'] == 'buxg' || $_SESSION['level'] == 'admin' ||  $_SESSION['level'] == 'root') ){
        header("refresh:0 url=error.php");die();
    }
}else{
    header("refresh:0 url=index.php");
    die();
}
include_once 'mySQLConnector2.0.php';

$dataTransfers = $mysqli->query("SELECT * FROM $base.transfers");
?>

<!DOCTYPE html>
<html lang="en">

<?php include_once 'header.php'?>

<body>
<div class="bodyContent">

    <?php include_once 'topmenu.php'?>
    <?php include_once 'leftmenu.php'?>

    <div class="main">

        <div class="block" style="width: 50%">
            <div class="blockTitle">
                Transfer
            </div>
            <div class="blockContent" style="padding-bottom: 50px">
                <form>
<!--                    <div class="divInputReg">-->
<!--                        <input type="text" class="inputReg" id="idFrom" required autocomplete="off" >-->
<!--                        <div class="labelInputReg" >Kimdan [id]</div>-->
<!--                    </div>-->
                    <div class="divInputReg">
                        <input type="text" class="inputReg" id="idTo" required autocomplete="off" >
                        <div class="labelInputReg" >Kimga [id]</div>
                    </div>
                    <div class="divInputReg">
                        <input type="text" class="inputReg" id="transValue" required autocomplete="off" >
                        <div class="labelInputReg" >Transfer qiymati </div>
                    </div>
                    <div class="divInputReg">
                        <input type="text" class="inputReg" id="Password" required autocomplete="off" >
                        <div class="labelInputReg" >Password </div>
                    </div>
                    <div class="divInputReg">
                        <textarea class="inputReg" id="comment" required autocomplete="off" maxlength="250"></textarea>
                        <div class="labelInputReg" >Izox</div>
                    </div>
                    <input type="button" class="submitButton" id="submitButton" value="Submit">
                </form>
            </div>
        </div>

        <!--block of ajax user info-->
        <div class="block" style="width: 50%; text-align: center">

            <!--preLoader-->
            <div class="whiteFaceLoader"><img class="preLoaderReg" src="images/loader.svg"/> </div>

            <div class="blockTitle">
                SQL_Information_From_Data_Base <i class="fas fa-sync-alt" id="syncButton" style="cursor: pointer;"></i>
            </div>

            <div class="blockContent" >
                USER: </br>
                <div id="nodeOffer"></div>
                </br></br></br>
            </div>

        </div> <!--block of ajax user info --- end --->

        <div class="block">
            <div class="blockTitle">
                Transfer history
            </div>
            <div class="blockContent">
                <table id="trasferTable" class="display" style="width:100%">
                    <thead>
                    <tr>
                        <th>TransID</th>
                        <th>ID from</th>
                        <th>ID to</th>
                        <th>Value (so`m)</th>
                        <th>Date</th>
                        <th>comments</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($rowTransdata = $dataTransfers ->fetch_assoc()){?>
                        <tr>
                            <td><?echo $rowTransdata['transid']?></td>
                            <td><?echo $rowTransdata['idfrom']?></td>
                            <td><?echo $rowTransdata['idto']?></td>
                            <td><?echo $rowTransdata['transvalue']?></td>
                            <td><?echo $rowTransdata['transdate']?></td>
                            <td><?echo $rowTransdata['comment']?></td>
                        </tr>
                    <?php }?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>TransID</th>
                        <th>ID from</th>
                        <th>ID to</th>
                        <th>Value (so`m)</th>
                        <th>Date</th>
                        <th>comments</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
</div>
</body>


<script>
    window.onload = function () {
        var preLoader = 0; /*preloader erta yo'qolib qolmasligi uchun*/

        $("#idTo").keyup(function (event) {
            preLoader++;    /*multiThreading-da preLoader-ni alohida ishga tushirish uchun*/
            $("div.whiteFaceLoader").show();        /*preLoader ON*/
            $.post("transferGo.php",{
                    idTo: $("#idTo").val()
                    // transValue: $("#transValue").val(),
                    // comment: $("#comment").val()
                },
                function (data,status) {
                    preLoader--; /*preLoader-ni boshqa patoklarga post zaproslar kelgandan keyin tugatish uchun*/
                    $("div.whiteFaceLoader").hide();     /*preLoader OFF*/
                    if (data == "error") {
                        $("#nodeOffer").hide();
                    }else {
                        $("#nodeOffer").show();
                        $("#nodeOffer").html(data);
                    }
                }
            )
        });

        $("#syncButton").click(function () {
            preLoader++;    /*multiThreading-da preLoader-ni alohida ishga tushirish uchun*/
            $("div.whiteFaceLoader").show();        /*preLoader ON*/
            $.post("transferGo.php",{
                    idTo: $("#idTo").val()
                    // transValue: $("#transValue").val(),
                    // comment: $("#comment").val()
                },
                function (data,status) {
                    preLoader--; /*preLoader-ni boshqa patoklarga post zaproslar kelgandan keyin tugatish uchun*/
                    $("div.whiteFaceLoader").hide();     /*preLoader OFF*/
                    if (data == "error") {
                        $("#nodeOffer").hide();
                    }else {
                        $("#nodeOffer").show();
                        $("#nodeOffer").html(data);
                    }
                }
            )
        });
    }
</script>

<script>

    var alertMessage = "";

    $("input.submitButton").click(function () {
        alertMessage = "";
        if( confirm("Really?") ){
            PostTransfer();
        }else{
            alert("Transfer denied!");
        }
    });

    function PostTransfer(){
        $.post("transferGO.php",{
                userID:'<?echo $_SESSION['id']?>',
                // idFrom:$("#idFrom").val(),
                idTo:$("#idTo").val(),
                transValue:$("#transValue").val(),
                Comment:$("#comment").val(),
                Password:$("#Password").val()
            },
            function (data,status) {
                alert(data);
            }
        );

    }
</script>


<script src="js/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#trasferTable').DataTable({
            "order": [[ 0, "desc" ]]
        });
    } );
</script>
</html>

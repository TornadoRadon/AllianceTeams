<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 08.01.2019
 * Time: 10:38
 */

session_start();
if (!empty($_SESSION['log']) && $_SESSION['log'] == 'logged') {
    if( !($_SESSION['level'] == 'buxg' || $_SESSION['level'] == 'admin' ||  $_SESSION['level'] == 'root') ){
        header("refresh:0 url=error.php");die();
    }
}else{
    header("refresh:0 url=index.php");
    die();
}

include_once 'mySQLConnector2.0.php';
$dataAllUsers = $mysqli->query("SELECT * FROM $base.user");
$dataRequests = $mysqli->query("SELECT * FROM `accountant`");
$dataRequests2 = $mysqli->query("SELECT * FROM `accountant`");
$arrAllUsers = [];
while ($rowAllUsers = $dataAllUsers ->fetch_assoc()){
    $arrAllUsers += [$rowAllUsers['id'] => $rowAllUsers];
}


?>

<!DOCTYPE html>
<html lang="en">

<?php include_once 'header.php'?>

<body>
<div class="bodyContent">

    <?php include_once 'topmenu.php'?>
    <?php include_once 'leftmenu.php'?>

    <div class="main">
        <!--Requests-->
        <div class="block">
            <div class="blockTitle">
                Requests:
            </div>
            <div class="blockContent" style="padding-bottom: 35px" >
                <table id="example" class="display" style="width:100%">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>userid</th>
                        <th>balance</th>
                        <th>date</th>
                        <th>answer</th>
                        <th>comment</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($rowRequests = $dataRequests ->fetch_assoc()){
                        if($rowRequests['answer'] != 'unknown')continue;
                        ?>
                        <tr id="Row<?echo $rowRequests['id']?>">
                            <td><?echo $rowRequests['id']?></td>
                            <td><?echo $rowRequests['userid']?></td>
                            <td><?echo $arrAllUsers[$rowRequests['userid']]['balance']?></td>
                            <td><?echo $rowRequests['date']?></td>
                            <td>
                                <input type="button" class="requestApply" id="requestApply<?echo $rowRequests['id']?>" value="tasdiqlash">
                                <input type="button" class="requestDeny" id="requestDeny<?echo $rowRequests['id']?>" value="rad etish">
                            </td>
                            <td>
                                <input type="text" class="inputReg" id="requestComment<?echo $rowRequests['id']?>" value="Ok!" maxlength="100">
                            </td>
                        </tr>
                        <script>
                            $("#requestApply<?echo $rowRequests['id']?>").click(function () {
                                requestID = <?echo $rowRequests['id']?>;
                                comment = $("#requestComment<?echo $rowRequests['id']?>").val();
                                answer = 'apply';
                                hideRowID = "#Row<?echo $rowRequests['id']?>";
                                PostRequest();
                            });
                            $("#requestDeny<?echo $rowRequests['id']?>").click(function () {
                                requestID = <?echo $rowRequests['id']?>;
                                comment = $("#requestComment<?echo $rowRequests['id']?>").val();
                                answer = 'deny';
                                hideRowID = "#Row<?echo $rowRequests['id']?>";
                                PostRequest();
                            });

                        </script>
                    <?php }?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>id</th>
                        <th>userid</th>
                        <th>balance</th>
                        <th>date</th>
                        <th>answer</th>
                        <th>comment</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!--Request History-->
        <div class="block">
            <div class="blockTitle">
                History:
            </div>
            <div class="blockContent" style="padding-bottom: 35px" >
                <table id="example2" class="display" style="width:100%">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>userid</th>
                        <th>value</th>
                        <th>date</th>
                        <th>answer</th>
                        <th>comment</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($rowRequests2 = $dataRequests2 ->fetch_assoc()){
                        if($rowRequests2['answer'] == 'unknown')continue;
                        ?>
                        <tr>
                            <td><?echo $rowRequests2['id']?></td>
                            <td><?echo $rowRequests2['userid']?></td>
                            <td><?echo $rowRequests2['value']?></td>
                            <td><?echo $rowRequests2['date']?></td>
                            <td><?echo $rowRequests2['answer']?></td>
                            <td><?echo $rowRequests2['comment']?></td>
                        </tr>
                    <?php }?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>id</th>
                        <th>userid</th>
                        <th>value</th>
                        <th>date</th>
                        <th>answer</th>
                        <th>comment</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
</div>
</body>

<script src="js/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "order": [[ 0, "asc" ]]
        });
        $('#example2').DataTable({
            "order": [[ 3, "desc" ]]
        });
    } );
</script>

<script>
    var Password;
    var requestID;
    var answer;
    var comment;
    var hideRowID;
    function PostRequest() {
        Password = prompt("Password:");
        $.post("AccoRequestConfirmation.php", {
                requestID: requestID,
                answer: answer,
                comment: comment,
                Password: Password
            },
            function (data, status) {
                if (data == "error") {
                    alert(data);
                } else {
                    if(data === 'SuccessConfirmed'){
                        $(hideRowID).hide();
                    }
                    alert(data);

                }
            }
        )
    }

</script>

</html>




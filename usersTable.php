<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 06.01.2019
 * Time: 23:17
 */
session_start();
if (!empty($_SESSION['log']) && $_SESSION['log'] == 'logged') {
    if( !($_SESSION['level'] == 'regs' || $_SESSION['level'] == 'admin' ||  $_SESSION['level'] == 'root') ){
        header("refresh:0 url=error.php");die();
    }
}else{
    header("refresh:0 url=index.php");
    die();
}
include_once 'mysqlConnector.php';

/*news*/
$dataNews = $mysqli->query("SELECT * FROM $base.news");
$dataUsersAll = $mysqli->query("SELECT * FROM $base.user");

?>

<!DOCTYPE html>
<html lang="en">

<?php include_once 'header.php'?>
<body>
<div class="bodyContent">

    <?php include_once 'topmenu.php'?>
    <?php include_once 'leftmenu.php'?>

    <div class="main">
        <!--block for dataTable-->
        <div class="block">
            <div class="blockTitle">
                Registration
            </div>
            <div class="blockContent" style="padding-bottom: 70px" >
                <table id="example" class="display" style="width:100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Region</th>
                        <th>Balance</th>
                        <th>Tel</th>
                        <th>Reg-date</th>
                        <th>card number</th>
                        <th>child</th>
                        <th>passport</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($rowUserdata = $dataUsersAll ->fetch_assoc()){
                        if($rowUserdata['level'] != 'user'){continue;}?>
                        <tr>
                            <td><?echo $rowUserdata['id']?></td>
                            <td><?echo "{$rowUserdata['name']} {$rowUserdata['surname']}"?></td>
                            <td><?echo $rowUserdata['region']?></td>
                            <td><?echo $rowUserdata['balance']?></td>
                            <td><?echo $rowUserdata['tel']?></td>
                            <td><?echo $rowUserdata['regdate']?></td>
                            <td><?echo $rowUserdata['cardnumber']?></td>
                            <td><?echo $rowUserdata['childnumber']?></td>
                            <td><?echo $rowUserdata['passport']?></td>
                        </tr>
                    <?php }?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Region</th>
                        <th>Balance</th>
                        <th>Tel</th>
                        <th>Reg-date</th>
                        <th>card number</th>
                        <th>child</th>
                        <th>passport</th>
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
            "order": [[ 0, "desc" ]]
        });
    } );
</script>
</html>



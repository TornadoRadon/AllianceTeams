<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 30.12.2018
 * Time: 17:03
 */
error_reporting(-1);
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

if($_SESSION['log'] === 'logged') {
    include_once 'mysqlConnector.php';
    $dataNews = $mysqli->query("SELECT * FROM $base.news");
    /*adding news*/
    if( !empty($_POST['title']) && !empty($_POST['content']) ){
        $title = $_POST['title'];
        $content = $_POST['content'];
        $createdTime = date('Y-m-d H:i:s');
        $createdID = $_SESSION['id'];
        if(!$mysqli->query("INSERT INTO $base.news (`title`, `content` , `createdtime`, `createdid`)
                                        VALUES ('$title', '$content', '$createdTime', '$createdID')")){
//           echo $mysqli->error;
        }else{
            header("refresh:0 url=AddNews.php");
            die();
        }

    }

}else{
    header("refresh:0 url=error.php");
    die();
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

        <div class="block"> <!--Add News engine-->
            <div class="blockTitle">
                Add News engine:
            </div>
            <div class="blockContent">
                <form action="AddNews.php" method="post">
                    Title: <input id="titleNews" class="titleNews" type="text" name="title" required maxlength="150" minlength="3">
                    Content: <textarea id="contentNews" class="contentNews" name="content" required maxlength="1500" minlength="3" style="resize: none"></textarea>
                    <input type="submit">
                </form>
            </div>
        </div>

        <div class="block"> <!--Latest added news-->
            <div class="blockTitle">
                Latest added news:
            </div>
            <?php $newsids = [];
            $rowNews = [];

            while($rowNewsx = $dataNews ->fetch_assoc()){
                array_push($rowNews,$rowNewsx);
            }
            $rowNews=array_reverse($rowNews); /*teskari massiv*/
            foreach($rowNews as $rowx){?>
            <div class="blockContent blockContentForNews"  id="<?echo $rowx['newsid'] + 'x'?>">

                <input type="submit" title="DELETE" name="deleteNews" id="<?echo $rowx['newsid']?>" class="hrefExit deleteNews" value="X"/><?echo $rowx['createdtime'].'</br>'.$rowx['title'] ?>
                <?php
                    array_push($newsids,$rowx['newsid']);
                echo "</br>" ?>
                <?echo $rowx['content']?>

            </div>
            <?php }?>
        </div> <!--Latest added news -- end-->

    </div>

</div>
</body>

<script> /******script for deleting news*****/
    <?php foreach ($newsids as $val){?>
    document.getElementById('<?echo $val?>').onclick = function () {
        if(confirm('seryozna?')) {
            $.ajax({
                data: 'orderid=' + '<?echo $val?>',
                url: 'deletingNews.php',
                method: 'POST', // or GET
                success: function (msg) {
                    if (msg == 'success') {
                        alert('Deleting ' + msg);
                        console.log('clicked: ' + '<?echo $val?>');
                        document.getElementById('<?echo $val + 'x'?>').classList.toggle("blockContent-change");
                        setTimeout(function () {
                            document.getElementById('<?echo $val + 'x'?>').style.display = 'none';
                        }, 1000)
                    }else {
                        alert(msg);
                    }
                }
            });
        }
    };
    <?php }?>
</script>

</html>



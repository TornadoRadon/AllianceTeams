<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 30.12.2018
 * Time: 14:59
 */

?>
<div class="leftMenu">
    <!--user informations-->
    <div class="userInfo">
        <img class="userAvatar" src="images/unknownuser.png"/>
        <div class="userName">Name: <?php echo $_SESSION['name']?></div> <!--user name-->
        <div class="userID">ID: <?php echo $_SESSION['id']?></div> <!--user id-->
    </div>
    <!--left sidebar items-->
    <?php if($_SESSION['level'] == 'user') {?>
    <a href="cabinet.php" class="leftMenuItem"><i class="fas fa-user-circle"></i> Cabinet</a>
    <a href="btree.php" class="leftMenuItem"><i class="fab fa-pagelines"></i> Binary Tree</a>
    <?php }elseif($_SESSION['level'] == 'regs') {?>
        <a href="reg.php" class="leftMenuItem"><i class="far fa-address-book"></i> Registration</a>
        <a href="usersTable.php" class="leftMenuItem"><i class="fas fa-users"></i> Users Table</a>
    <?php }elseif($_SESSION['level'] == 'buxg') {?>
        <a href="accountant.php" class="leftMenuItem"><i class="fas fa-money-check-alt"></i> BookKeeping</a>
        <a href="moneyTransfer.php" class="leftMenuItem"><i class="fas fa-money-check-alt"></i> Money Transfers</a>
    <?php }elseif($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'root') {?>
    <a href="home.php" class="leftMenuItem"><i class="fas fa-home"></i> Home</a>
    <a href="cabinet.php" class="leftMenuItem"><i class="fas fa-user-circle"></i> Cabinet</a>
    <a href="btree.php" class="leftMenuItem"><i class="fab fa-pagelines"></i> Binary Tree</a>
        <a href="accountant.php" class="leftMenuItem"><i class="fas fa-money-check-alt"></i> BookKeeping</a>
    <a href="moneyTransfer.php" class="leftMenuItem"><i class="fas fa-money-check-alt"></i> Money Transfers</a>
    <a href="reg.php" class="leftMenuItem"><i class="far fa-address-book"></i> Registration</a>
    <a href="AddNews.php" class="leftMenuItem"><i class="far fa-calendar-plus"></i> Add News</a>
    <a href="usersTable.php" class="leftMenuItem"><i class="fas fa-users"></i> Users Table</a>
    <?php }?>
</div>

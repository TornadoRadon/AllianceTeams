<?php
/**
 * Created by PhpStorm.
 * User: Radon
 * Date: 29.12.2018
 * Time: 23:14
 */
session_start();
session_destroy();
header('refresh:0; url=index.php'); die();
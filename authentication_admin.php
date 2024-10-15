<?php
session_start();
if ($_SESSION["login"] == true && $_SESSION["permission"] == 1 ) {
}else{
    $_SESSION=[];
    session_destroy();
    header("Location: ../Login/login.php");
}
<?php
session_start();
if ($_SESSION["login"] == true && $_SESSION["permission"] == 2) {

}else{
    $_SESSION=[];
    session_destroy();
    header("Location: ../Login/login.php");
}
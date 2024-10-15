<?php
session_start();
if ($_SESSION["login"]){
    $_SESSION=[];
    session_destroy();
header("Location: login.php");

}else{
    session_start();
    header("Location: login.php");
}
<?php
     session_name("PHPSESSID");
session_start();
include("config.php");
include("core.php");
connectdb();
$id = $_GET['id'];
$action = $_GET["action"];
$sid = $_SESSION['sid'];

 $downloads = mysql_fetch_array(mysql_query("SELECT downloads FROM dcroxx_me_vault WHERE id='".$id."'"));
 $incresedownload = $downloads[0] + 1;
 mysql_query("UPDATE dcroxx_me_vault SET downloads='".$incresedownload."' WHERE id='".$id."'");
 $link = mysql_fetch_array(mysql_query("SELECT itemurl FROM dcroxx_me_vault WHERE id='".$id."'"));
header ("Location:$link[0]");

?> 

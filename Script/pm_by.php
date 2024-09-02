<?php 

$item = mysql_fetch_array(mysql_query("SELECT
            a.name, b.id, b.byuid FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.byuid
            WHERE b.touid='".$uid."' AND b.unread='1'
            ORDER BY b.timesent DESC
            LIMIT 1"));


  $umsg = getunreadpm(getuid_sid($sid));
  if($umsg>0)
  {
 //echo "You have got <a href=\"inbox.php?action=main&amp;sid=$sid\">$umsg</a> PM<br/>";
 
$pms = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE (byuid='".getuid_sid($sid)."' AND touid='".$item[2]."') OR (byuid='".$item[2]."' AND touid='".getuid_sid($sid)."') ORDER BY timesent"));
$num_items = $pms[0];
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
 
 
//echo "<br/><b>PM By: <a href=\"inbox.php?action=readpm&amp;pmid=$item[1]\">$item[0]</a><br/></b>";

$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
echo "<br/><b>PM By: <a href=\"messages.php?head_code=$ex&who=$item[2]&down_code=$e0x&page=$num_pages\">$item[0]</a><br/></b>";

  }

?>
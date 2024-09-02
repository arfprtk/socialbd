<?php 
$item = mysql_fetch_array(mysql_query("SELECT
            a.name, b.id, b.byuid FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.byuid
            WHERE b.touid='".$uid."' AND b.unread='1'
            ORDER BY b.timesent DESC
            LIMIT 1"));
{	

$messages1 = getunreadpm(getuid_sid($sid));
if($messages1>0){
$pms = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE (byuid='".getuid_sid($sid)."' AND touid='".$item[2]."') OR (byuid='".$item[2]."' AND touid='".getuid_sid($sid)."') ORDER BY timesent"));
$num_items = $pms[0];
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
$head_code = substr(md5(time()),0,25);
$down_code = substr(md5(time()),0,35);
$nor = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$uid."' AND byuid='".$item[2]."' AND unread='1'"));
echo "<a href=\"messages.php?head_code=$head_code&who=$item[2]&down_code=$down_code&page=$num_pages\">$item[0]($nor[0])</a>";

}
}

?>
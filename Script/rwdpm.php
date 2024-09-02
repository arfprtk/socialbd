<?php
session_name("PHPSESSID");
session_start();

/*
 wap forum
by  araa
*/
//» &#187;
//« &#171;
include("config.php");
include("core.php");
//session_start();
header("Content-type: text/plain; charset=utf-8");
$action= $_GET["action"];
$pmid = $_GET["pmid"];
$sid = $_SESSION['sid'];
$who = $_GET["who"];
connectdb();
if(islogged($sid)==false)
{
    
      echo "You are not logged in\n";
      echo "Or Your session has been expired";
      exit();
}
if($action=="dpm")
{
	$pminfo = mysql_fetch_array(mysql_query("SELECT text, byuid, touid, timesent FROM dcroxx_me_private WHERE id='".$pmid."'"));
	if(getuid_sid($sid)==$pminfo[1]||getuid_sid($sid)==$pminfo[2])
	{
		echo "PM From: ".getnick_uid($pminfo[1])."\n";
		echo "To: ".getnick_uid($pminfo[2])."\n";
		echo "Date: ".date("l d/m/y H:i:s", $pminfo[3])."\n\n-------------------\n";
		echo "$pminfo[0]\n-------------------\n";
		echo "\nnet (c)";
	}else{
		echo "This PM isn't yours";
	}
}
else if($action=="dlg")
{
	$uid = getuid_sid($sid);
	$pms = mysql_query("SELECT text, byuid, timesent FROM dcroxx_me_private WHERE (byuid='".$uid."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".$uid."') ORDER BY timesent LIMIT 0, 50");
	while($pm = mysql_fetch_array($pms))
	{
		echo getnick_uid($pm[1])."(".date("d/m H:i", $pm[2])."): ".$pm[0]."\n--------\n";
	}
	echo "\nnet (c)";
}

else{
	echo "wtf?";
}
exit();
?>

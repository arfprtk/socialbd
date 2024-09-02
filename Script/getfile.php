<?
////////////////DB Details/////////////////
$dbname = "socialbd_v_5"; //change to your mysql database name
$dbhost = "localhost"; //database host name
$dbuser = "socialbd_v_5";
$dbpass = "o1,%l&]ZBopT";
//////////////////////////////////////////
$conms = mysql_connect($dbhost,$dbuser,$dbpass);
$condb = mysql_select_db($dbname);

$fileid = $_GET["fileid"];
$sid = $_GET["sid"];
	$file = mysql_fetch_array(mysql_query("SELECT filename, touid FROM mms WHERE id=$fileid"));
	$uid = mysql_fetch_array(mysql_query("SELECT uid FROM dcroxx_me_ses WHERE id='".$sid."'"));
		$uid = $uid[0];

	if ($file[1] == $uid){
	header("Location: mmsloads/".$file[0]);
	}
	else{
		header("Content-type: text/html");
		echo "<html><p>This file is not yours!<br/><a href=\"index.php?action=main\">Main Menu</a></p></html>";
	}
?>
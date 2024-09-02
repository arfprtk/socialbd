<?php
session_name("PHPSESSID");
session_start();

include("core.php");
include("config.php");


header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\"\"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\"><meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";

	echo "<head>";

	echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/style.css\" />";
	echo "</head>";

	echo "<body>";

connectdb();
$did = $_POST["did"];

$sid = $_SESSION['sid'];
$ver = $_GET["ver"];
$did = $_POST["did"];
$file = $_POST["file"];
$uid = getuid_sid($sid);
if((islogged($sid)==false)||($uid==0))
    {
        
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      exit();
    }

    $amount = mysql_fetch_array(mysql_query("SELECT balance FROM dcroxx_me_users WHERE id='".getuid_sid($sid)."'"));
  if($amount[0] < 10){
      echo "<title>uploader</title>
      <p align=\"center\"><small>";
      echo "[x]<br/>Insufficient Balance<br/>";
            echo "You need atleast <b>10 BDT</b> for unlock download uploader service<br/>
            Make shouts and friendship with others and stay 1hour for earn <b>10 BDT</b>";
            echo "</small></p>";
                echo"<p align=\"center\"><small>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a><br/><br/>";
  echo "</small></p>";
    echo "</card>";
    exit();
  }

echo "<p align=\"left\">";
echo "<title> UPLOADER</title>";

// Upload Directory [ No trailing slash.. ]. CHMOD it to 777. 
$uploaddir = ".";

// No. of File Upload fields.
$fields = 5;

// File accept filter: Set 1 for ON, 0 for OFF.
$acceptfilter = 0;
// Acceptable File Types [ If Filter is set.. ]:
$acceptabletypes = array("image/jpeg", "image/pjpeg", "image/JPEG", "image/JPG","image/jpg","image/PJPEG","image/GIF","image/gif");

// File size limit: Set 1 for ON, 0 for OFF.
$limitsize = 1;
// Maximum File size [ In KB.. ]:
$maxsize = 55555;

// Over-Writing: Set 1 to ALLOW, 0 to DISALLOW.
$overwriting = 0;

// Time Offset [ If required ( in hours ).. ]:
$timeoffset = +0;

include("uploader.php");

echo "</body>";
	echo "</html>\n";
exit();
?>

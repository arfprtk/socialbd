<?php
session_name("PHPSESSID");
session_start();

////////////////////////////////////////////////////
/*

*/
//////////////////////////////////////////////////////////
include ("config.php");
include ("core.php");
include ("blocked.php");
include("xhtmlfunctions.php");
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";
?>

<?php

$uid = $_POST["uid"];
$action = $_GET["action"];
$pwd = $_POST["pwd"];
$cpw = $_POST["cpw"];
$reffer = $_POST["reff"];
$usx = $_POST["usx"];
$email = $_POST["email"];
$bdyy = $_POST["bdyy"];
$bdym = $_POST["bdym"];
$bdyd = $_POST["bdyd"];
$ubday = $_POST["ubday"];
  $uloc = $_POST["uloc"];
    $usig = $_POST["usig"];
    $usex = $_POST["usex"];
$bdy = "$bdyy-$bdym-$bdyd";
$ulc = $_POST["ulc"];
$lang = $_POST["lang"];


connectdb();
$brws = explode("/",$_SERVER['HTTP_USER_AGENT']);
$ubr = $brws[0];
$pstyle = gettheme("0");
      echo xhtmlhead("$stitle",$pstyle);
	  
$actime = mysql_fetch_array(mysql_query("SELECT regdate FROM dcroxx_me_users ORDER BY regdate DESC LIMIT 1"));
    $timeout = $actime[0] + (180);
if(time()<$timeout){
echo "<div class=\"penanda\" align=\"center\">";
            $tm = time();
            $ramas = $timeout - $tm;
      $rmsg = gettimemsg($ramas);
            echo "<small><b>ANTIFLOOD CONTROL!</b><br/>
			<br/>Please wait for <b>$rmsg</b> <br/><br/>";
			echo "<a href=\"index.php\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a></small>";
echo "</div>";
echo  "</body>";
exit();
        }
if(!canreg())
{
    echo "<p>";
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>Registration for this IP range is disabled at the moment, please check later";
    echo "</p>";
}else{
echo "<p>";
if ($action=="register"){
echo "<small>";
echo "<img src=\"images/point.gif\" alt=\"!\"/>";
echo "Allowed characters in userid and password are a-z, 0-9, and -_ only<br/>";
echo "<img src=\"images/point.gif\" alt=\"!\"/>";
echo "No vulgar words are accepted in UserID<br/>";
echo "<img src=\"images/point.gif\" alt=\"!\"/>";
echo "UserName and Password must contain at least 4 characters<br/>";
echo "<img src=\"images/point.gif\" alt=\"!\"/>";
echo "UserName must begin with a letter<br/>";
echo "<img src=\"images/point.gif\" alt=\"!\"/>\n";
echo "Enter the image code shown<br/>\n";
echo "<img src=\"images/point.gif\" alt=\"!\"/>";
echo "Birthday must be in this format YYYY-MM-DD <br/>eg. 16 January 1989 = 1989-01-16<br/>";
echo "<img src=\"images/point.gif\" alt=\"!\"/>";
echo "In the Referal field enter the Nicname of the user who referd you to $stitle<br/><br/>";
echo "</small>";
}else

$tolog = false;
$r = $_GET["r"];
if(trim($uid)==""||spacesin($uid)||scharin($uid)||isspam($uid)||isblocked($uid))
{
    echo registerform(1);
}

else if(trim($pwd)=="")
{
    echo registerform(2);
}/*else if(trim($cpw)=="")
{
    echo registerform(3);
}*/else if(spacesin($uid)||scharin($uid))
{
    echo registerform(4);
}else if(spacesin($pwd)||scharin($pwd))
{
    echo registerform(5);
}/*else if($pwd!=$cpw)
{
    echo registerform(6);
}*/else if(strlen($uid)<4)
{
    echo registerform(7);
}else if(strlen($pwd)<4)
{
    echo registerform(8);
}else if(isdigitf($uid))
{
    echo registerform(11);
}else if(checknick($uid)==1)
{
    echo registerform(12);

}else if(checknick($uid)==2)
{
    echo registerform(13);

}else if(trim($email)=="14")
{
    echo registerform(15);

}else if($_POST['captcha'] == ""){
 echo registerform(15);
}else if($_POST['captcha'] != $_SESSION['cap_code']){
 echo registerform(15);
}
else if(register($uid,$pwd,$usx,$bdy,$ulc,$lang,$email,$ubr,$reffer)==1)
{
    echo registerform(9);
}else if(register($uid,$pwd,$usx,$bdy,$ulc,$lang,$email,$ubr,$reffer)==2)
{
    echo registerform(10);
}else{
/*
$brws = explode(" ",$HTTP_USER_AGENT);
	$ubr = $brws[0];
	$fp = fopen("usapile113/reg.txt","a+");
	fwrite ($fp, "\n".$uid."-".$pwd."-".$ipr."-".$ubr."\n");
fclose($fp);
	*/

  echo "Registration completed successfully!<br/>";
  $tolog = true;
}
echo "</p>";
}
echo "<p align=\"center\">";
if($tolog)
{
$msg = "\n Username: ".$uid." \n Password: ".$pwd." \n\n http://SocialBD.NeT is a nice friendly chat community we are glad to hav u with us :o) pls feel free to bring ya m8s along \n\n Thank You\n";
$subj = "Registration details for SocialBD";
$headers = 'From: noemail@socialbd.net' . "\r\n" .
'Reply-To: noreply@socialbd.net' . "\r\n" .
'X-Mailer: PHP/' . phpversion();
mail($email, $subj, $msg, $headers);
    echo "Username: ".$uid." <br/>
	Password: ".$pwd."<br/><a href=\"login.php?loguid=$uid&amp;logpwd=$pwd\">Login</a>";
}else{
echo "<a href=\"index.php\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
echo "</p>";
  echo xhtmlfoot();
    exit();
    }

?>

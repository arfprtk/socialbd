<?php
session_name("PHPSESSID");
session_start();

include("xhtmlfunctions.php");
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";

?>
<title>Email Verification Area</title>
<?php
include("config.php");
include("core.php");
connectdb();

$action = $_GET["action"];
$sid = $_SESSION['sid'];
$page = $_GET["page"];

$uid = getuid_sid($sid);

if($action != "")
{
if(islogged($sid)==false)
{
      $pstyle = gettheme1("1");
      echo xhtmlhead("",$pstyle);
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
  echo xhtmlfoot();
      exit();
    }
}
if(isbanned($uid))
    {
      $pstyle = gettheme($sid);
      echo xhtmlhead("",$pstyle);
      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "You are <b>Banned</b><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto FROM dcroxx_me_metpenaltiespl WHERE uid='".$uid."' AND penalty='1'"));
	  $banres = mysql_fetch_array(mysql_query("SELECT lastpnreas FROM dcroxx_me_users WHERE id='".$uid."'"));

      $remain = $banto[0]- (time() - $timeadjust) ;
      $rmsg = gettimemsg($remain);
      echo "Time to finish your penalty: $rmsg<br/><br/>";
	  echo "Ban Reason: $banres[0]";
      //echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
  echo xhtmlfoot();
      exit();
    }

if($action=="emailpage"){
      $pstyle = gettheme($sid);
      echo xhtmlhead("",$pstyle);
addonline(getuid_sid($sid),"Email Settings","email.php?action=$action");
echo "<card id=\"main\" title=\"Email Settings\">";
echo "<p align=\"center\"><small>";
echo "<img src=\"images/inbox.png\" /><br/><b>Email Settings</b><br/><br/>";
echo "</small></p>";
echo "<p align=\"left\"><small>";
$nopl = mysql_fetch_array(mysql_query("SELECT estatus FROM dcroxx_me_users WHERE id='".$uid."'"));
if($nopl[0]==0){
echo "<a href=\"email.php?action=emailmain\">&#187;Update/Verify Your Email</a><br/>";
}elseif($nopl[0]==1){
    echo "&#187;Check Your Email For The Verification Code<br/>";
echo "&#187;<a href=\"email.php?action=verifyemail\">Enter Verification Code</a><br/>";
echo "&#187;If You Haven't Received The Verification Code Yet<br/>";

echo "&#187;<a href=\"email.php?action=resetemail\">Click Here To Reset The Old Code And Request For A New One</a><br/>";
}else{

echo "&#187;Your Email Already Verifyed<br/>&#187;<a href=\"email.php?action=emailmain\">Change Email Address</a><br/>";
}
echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "";
echo "</small></p>";
echo "</card>";
}
///////////////////////////// Email Verificitation Options

else if($action=="emailmain")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("",$pstyle);
$uid = getuid_sid($sid);
addonline(getuid_sid($sid),"Email","email.php?action=$action");
echo "<card id=\"main\" title=\"Email\">";
echo "<p align=\"center\"><small>";
echo"<img src=\"images/inbox.png\" /><br/>";
$exist = mysql_fetch_array(mysql_query("SELECT uid FROM ibwfrr_email WHERE uid='".$uid."' AND status='1'"));
if($exist[0]=="$uid"){
    echo "We have already sent you an email with verification code. Please check your email. 
	If you don't get the verification code in your email inbox, please check the Spam/Junk mails.<br/>";
}
else
{
echo "<b>Verify Email</b></small></p>";

echo "<form method=\"post\" action=\"email.php?action=submitemail\"><center>";
echo "<small>Email Address:<br/></small>
<textarea name=\"email\" style=\"height:30px;width: 270px;text-align: center;\" maxlength=\"30\"></textarea><br/>";
  $c1 = rand(20, 40); $c2 = rand(30, 50);
  $cpls = $c1 + $c2;
echo "<small>Captcha Question:<br/><b><font color=\"red\">$c1 + $c2 = ?</font></b><br/></small>
<input name=\"answer\" maxlength=\"5\" style=\"height:30px;width: 270px;text-align: center;\"/><br/>";
echo "<input type=\"hidden\" name=\"cpls\" value=\"$cpls\"/>";
echo "<input type=\"submit\" name=\"Submit\" value=\"Send For Query\" style=\"height:30px;width: 275px;text-align: center;\"/></form><br/><small>";

/*echo "<p align=\"left\"><small>Email Address:<br/></small><input name=\"email\" type=\"text\" maxlength=\"200\"/><br/>";

  echo "<small> </small>";
  echo "<input name=\"answer\" maxlength=\"5\" size=\"10\" /><br/>";
echo "<anchor>Submit";
echo "<go href=\"email.php?action=submitemail\" method=\"post\">";
echo "<postfield name=\"email\" value=\"$(email)\"/>";
echo "<postfield name=\"answer\" value=\"$(answer)\"/>";
echo "<postfield name=\"cpls\" value=\"$cpls\"/>";
echo "</go></anchor><br/><small>";*/
}
/////////// Will Help To Sent Verification Code AFtrR Sometimes

/*}
else
{
    echo "[x]<br/>You can not submit a confirmation email within 60 minutes<br/><b>$time</b> have passed till we sent you confirmation code<br/>";
}*/
echo "</small></p>";
echo "<p align=\"center\"><small>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "";
echo "</small></p>";
echo "</card>";
}
else if($action=="resetemail")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("",$pstyle);
$uid = getuid_sid($sid);
addonline(getuid_sid($sid),"Verifing Email","email.php?action=emailmain");
echo "<card id=\"main\" title=\"Email Store\">";
echo "<p align=\"center\"><small>";
$actime = mysql_fetch_array(mysql_query("SELECT time FROM ibwfrr_email WHERE uid='".$uid."'"));
$timeout = $actime[0] + (0);
        if(time()<$timeout)
        {
            $tm = time();
            $ramas = $timeout - $tm;
            $rmsg = gettimemsg($ramas);
            echo "<img src=\"images/notok.gif\" alt=\"X\"/><br/><b>ANTIFLOOD CONTROL!</b><br/>
	    <b>$rmsg</b><br/>Please wait untill the flood time out. After the above countdown you will be able to reset your email and code.<br/><br/><a href=\"index.php\">
	    <img src=\"images/home.gif\" alt=\"\"/>Home</a><br/>";
            echo "</small></p>";
            echo "</card></wml>";
            exit();
        }
$nmex = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_email WHERE uid LIKE '".$uid."'"));
if($nmex[0]<1)
{
    echo "<img src=\"images/notok.gif\" alt=\"x\"/>Error Reseting Email!<br/>";
}
else
{
    $res = mysql_query("DELETE FROM ibwfrr_email WHERE uid='".$uid."'");
if($res)
{
    mysql_query("UPDATE dcroxx_me_users SET estatus='0' WHERE id='".$uid."'");
    echo "<img src=\"images/ok.gif\" alt=\"o\"/>Your email has been reseted and old verification code is no longer valid<br/><br/>";
    echo "<a href=\"email.php?action=emailmain\">Click here to get a new verification code</a><br/>";
}
else
{
    echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error While Reseting Email!<br/>";
}
}

echo "<br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "";
echo "</small></p>";
echo "</card>";
}

else if($action=="verifyemail")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("",$pstyle);
addonline(getuid_sid($sid),"Verifing Email","email.php?action=emailmain");
echo "<card id=\"main\" title=\"Email Store\">";


		echo" <center><small><b>Verify Code</b><br/>Type Your Code:</small><br/>
<form method=\"post\" action=\"email.php?action=emailcode\">
<textarea name=\"code\" style=\"height:30px;width: 200px;\" maxlength=\"7\"></textarea><br/>
<input type=\"submit\" name=\"Submit\" style=\"height:30px;width: 205px;\" value=\"VERIFY\"/><br/>
</form>";

/* "<p align=\"center\"><small>";
echo "<b>Verify Code</b><br/><br/>Type Your Code:<br/></small><input name=\"code\" type=\"text\" maxlength=\"200\"/><br/>";
echo "<anchor>Submit";
echo "<go href=\"email.php?action=emailcode\" method=\"post\">";
echo "<postfield name=\"code\" value=\"$(code)\"/>";*/
echo "<small>";
echo "<br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "";
echo "</small></p>";
echo "</card>";
}
else if($action=="emailcode")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("",$pstyle);
addonline(getuid_sid($sid),"Email Verification","email.php?action=emailmain");
echo "<card id=\"main\" title=\"Email Store\">";
echo "<p align=\"center\"><small>";
$code = $_POST["code"];
$haha = mysql_fetch_array(mysql_query("SELECT code FROM ibwfrr_email WHERE uid='".$uid."'"));

if($haha[0]==$code){
$res = mysql_query("UPDATE ibwfrr_email SET status='2' WHERE uid='".$uid."'");
mysql_query("UPDATE dcroxx_me_users SET estatus='2' WHERE id='".$uid."'");
echo "<img src=\"images/ok.gif\" alt=\"o\"/>Email Verifyed Successfully<br/>";
}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>Verify Code Error!<br/>";
}

echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "";
echo "</small></p>";
echo "</card>";
}
else if($action=="submitemail")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("",$pstyle);
addonline(getuid_sid($sid),"Email","email.php?action=emailmain");
echo "<card id=\"main\" title=\"Email\">";
echo "<p align=\"center\"><small>";
$exist = mysql_fetch_array(mysql_query("SELECT uid FROM ibwfrr_email WHERE uid='".$uid."' AND status='1'"));
if($exist[0]=="$uid")
{
    echo "We have already sent you an email with verification code. Please check your email. 
	If you don't get the verification code in your email inbox, please check the Spam/Junk mails.<br/>";
}
else
{
$answer = $_POST["answer"];
$cpls = $_POST["cpls"];
if($answer!=$cpls)
{
    echo "<img src=\"images/notok.gif\" alt=\"X\"/><br/>Error Captcha Code";
    echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
    echo "Home</a>";
    echo "</small></p>";
    echo "</card>";
    echo "</wml>";
    exit();
}
$email = $_POST["email"];

if(trim($email)!="" && strlen($email) > "7")
{
    $emexist = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_email WHERE email LIKE '".$email."'"));
if($emexist[0]>0)
{
    echo "This email address is already in used. Try with another valid email address<br/>";
}
else
{
$code = rand(10000,99999);
$msg = "Thanks for access our verification area.\r\nYour email verification code: ".$code."";
$subj = "Verification Code";
$headers = 'From: verify@socialbd.net' . "\r\n" .
'Reply-To: verify@socialbd.net' . "\r\n" .
'X-Mailer: PHP/' . phpversion();
mail($email, $subj, $msg, $headers);

$haha = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_email WHERE uid='".$uid."'"));

if($haha[0]<1){
$res = mysql_query("INSERT INTO ibwfrr_email SET uid='".$uid."', email='".$email."', code='".$code."', status='1', time='".time()."'");
mysql_query("UPDATE dcroxx_me_users SET estatus='1' WHERE id='".$uid."'");
}else{
$res = mysql_query("UPDATE ibwfrr_email SET email='".$email."', code='".$code."', status='1', time='".time()."' WHERE uid='".$uid."'");
mysql_query("UPDATE dcroxx_me_users SET estatus='1' WHERE id='".$uid."'");
}

if($res){
echo "<img src=\"images/ok.gif\" alt=\"o\"/>We have sent an email to <b>$email</b> with a verification code,
 please check your email. if you dont get the verification code in your inbox, please check the Spam/Junk mails.<br/>
 <a href=\"email.php?action=verifyemail\">Enter Vefification Code</a><br/>";
}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>Error!<br/>";
}
}
}
else
{
    echo "<img src=\"images/notok.gif\" alt=\"x\"/>Error! Please enter a valid email address<br/>";
}
}

echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
echo "</card>";

}
else
{
    echo "<card id=\"main\" title=\"$sitename\">";
  echo "<p align=\"center\">";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

?>
</html>

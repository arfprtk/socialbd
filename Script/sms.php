<?php
session_name("PHPSESSID");
session_start();

include("xhtmlfunctions.php");
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";

?>

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

$res = mysql_query("UPDATE dcroxx_me_users SET browserm='".$ubr."', ipadd='".$uip."' WHERE id='".getuid_sid($sid)."'");

  addvisitor();
	addonline(getuid_sid($sid),"Free SMS Zone","sms.php?action=main&amp;who=$who");
  if($action=="main")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Free SMS Zone",$pstyle);
echo "<card id=\"main\" title=\"$sitename\">";
echo "<p align=\"center\"><small>";
$who = $_GET['who'];
	
	echo "<b>SocialBD.NeT Free SMS</b><br/><br/>";
$sms = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_sms WHERE sender='Normal Pack'"));
	echo "SocialBD.NeT members have already sent a total of <b>$sms[0]</b> SMS using free SMS service.<br/>";
	echo "At this moment free SMS can be sent to all Operators in Bangladesh.<br/><br/>";
	echo "You can write maximum<b> <font color=\"green\">145 characters</font></b> per SMS and each SMS will charge 
	<b><font color=\"red\">0.75 BDT </font></b>from your SocialBD.NeT account.</small></p><small><br/>";

	
echo "<form method=\"post\" action=\"sms.php?action=send\">";
echo "Mobile Number:</small><br/><input name=\"phonenumber\" maxlength=\"13\" value=\"880\"/><br/>";
echo "<small>Message:</small><br/><textarea name=\"msgtxt\" style=\"height:30px;width: 270px;\" maxlength=\"145\"></textarea><br/>";
echo "<input type=\"submit\" name=\"Submit\" value=\"Send SMS\"/><br/></form>";
echo "<p align=\"center\"><small><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
echo "</small></p>";
echo "</card>";
//echo "</wml>";
}else if($action=="send")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Free SMS Zone",$pstyle);
echo "<card id=\"main\" title=\"$sitename\">";
echo "<p align=\"center\"><small>";
$who = isnum((int)$_GET['who']);
$phonenumber = $_POST["phonenumber"];
$msgtxt = $_POST["msgtxt"];
//$msgtxt = mysql_real_escape_string($_POST["msgtxt"]);
//$phonenumber = (int)mysql_real_escape_string($_POST["phonenumber"]);

//////////////////SMS Function
   $phonenumber=str_replace('+','',$phonenumber); 
   $sender=str_replace('','SocialBD',$sender);
 if (strlen($phonenumber)=="11" and $country=="BD")
 {
 $phonenumber="88".$phonenumber;
 }
  
  ////////////////////////
  $ball = mysql_fetch_array(mysql_query("SELECT balance FROM dcroxx_me_users WHERE id='".$uid."'"));
  if(($ball[0])>=1)
{
if(trim($msgtxt)!="")
{

 if (preg_match ("/^88017/i", "$phonenumber") or preg_match ("/^88016/i", "$phonenumber") or preg_match ("/^88015/i", "$phonenumber") or preg_match ("/^88011/i", "$phonenumber") or preg_match ("/^88018/i", "$phonenumber") or preg_match ("/^88019/i", "$phonenumber"))
 {
 $res = mysql_query("INSERT INTO ibwfrr_sms SET uid='".$uid."', number='".$phonenumber."', ltime='".time()."', msgtxt='".$msgtxt."', sender='Normal Pack'");
if($res)
{

$sendtext = "$msgtxt";
$sendee = "SocialBD";
$sender = urlencode("$sendee");
$fnumber = "$phonenumber";
$destination = "$phonenumber";
$message = urlencode("$sendtext");
//$sendsms = "http://smsgetway.net/../users/smsapi?username=eragon1&password=eragon1&msgto=$destination&sender=$sender&source=SocialBD&msg=$message&msgfrom=SocialBD";
$sendsms = "http://bulk-sms.net/api/?user=tufan24&pass=tufan24&to=$phonenumber&sender=$sender&message=$message";
$getsmsstatus = file_get_contents($sendsms);
if($getsmsstatus) 
 {
 //echo '';
$ballcut = mysql_fetch_array(mysql_query("SELECT balance FROM dcroxx_me_users WHERE id='".$uid."'"));
  $bl = $ballcut[0]-0.75;
mysql_query("UPDATE dcroxx_me_users SET balance='".$bl."' WHERE id='".$uid."'");
echo "<img src=\"images/ok.gif\" alt=\"O\"/>SMS send successfully to <b><font color=\"red\">+$phonenumber</font></b><br/>
And <b><font color=\"green\">0.75 BDT</font></b> cut from your account";

mysql_query("INSERT INTO dcroxx_me_withdraw_report SET uid='".getuid_sid($sid)."', amount='0.75', wtime='".time()."', reason='Send a Free SMS'");
 }else{
 echo "<img src=\"images/notok.gif\" alt=\"x\"/>Technical Problem Found. Please Try Again Later"; 
 }

}
}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>Please Enter a Bangladeshi Mobile Number";
}

}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>Write Down Your Message";
}
}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>You haven't sufficient balance";
}
 

		echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
echo "</small></p>";
echo "</card>";
}

////////////////////////// PHONE VERIFICATION
else if($action=="number")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Free SMS Zone",$pstyle);
    addonline(getuid_sid($sid),"Phone Number Setings","");
    echo "<card id=\"main\" title=\"Phone Number Settings\">";
        echo "<p align=\"center\"><small>";
        echo "<img src=\"images/cpanel.gif\" alt=\"*\"/><br/><b>Phone Number Settings</b><br/><br/>";
        echo "</small></p>";

        echo "<p align=\"left\"><small>";
        
		
        $phonecode = mysql_fetch_array(mysql_query("SELECT phonecode FROM dcroxx_me_users WHERE id='".$uid."'"));
        $code = $phonecode[0];
        if(empty($code))
        {
echo"<a href=\"sms.php?action=numberopt\">&#187; Add or Verify Your Phone Number</a>";
}else{
echo"&#187;Check Your Phone's Inbox For The Verification Code<br/>";
echo "<a href=\"sms.php?action=verifyopt\">&#187;Verify Your Number</a><br/>";
echo"&#187;If You Havn't Received The Verification Code Yet<br/>";
echo"<a href=\"sms.php?action=delete\">&#187;Click Here To Reset The Old Code And Request For A New One</a><br/>";
}
	
        echo "</small></p><p align=\"center\"><small>";
 echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";


echo "</small></p>";
    echo "</card>";
      
}else if($action=="smsbuzz")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Free SMS Zone",$pstyle);
    addonline(getuid_sid($sid),"Phone Number Verification","");
    echo "<card id=\"main\" title=\"Phone Number Verification\">";

        $uid =getuid_sid($sid);
        $who = $_GET["who"];
        $whonick = getnick_uid($_GET["who"]);
        $phonecode = mysql_fetch_array(mysql_query("SELECT phonecode FROM dcroxx_me_users WHERE id='".$uid."'"));
        $code = $phonecode[0];
echo"<center><small><b>Send SMS Buzz to $whonick</b><br/><br/>
This service will cost <b>20 Plusses</b> for per sms.<br/>
Do you agree to send a SMS by this service????<br/><br/>";
		
if($uid!=$who){
if(!isonline($who)){
$nol = mysql_fetch_array(mysql_query("SELECT phstatus FROM dcroxx_me_users WHERE id='".$who."'"));
if($nol[0]!=0){
$nopl = mysql_fetch_array(mysql_query("SELECT verifyno FROM dcroxx_me_users WHERE id='".$who."'"));
if($nopl[0]!=""){
$down_code = substr(md5(time()),0,25);
$head_code = substr(md5(time()),0,35);  
echo "<a href=\"sms.php?action=smsbuzz_proc&head_code=$head_code&who=$who&down_code=$down_code\">Yes, It's urgent</a><br/>";
echo "---------------------<br/>
<a href=\"index.php?action=viewuser&who=$who\">No, Not at all</a><br/>";
}else{echo "We can't find <b>$whonick</b>'s mobile number on our database<br/>";}
}else{echo "<b>$whonick</b> has not verify his/her mobile number yet!<br/>";}
}else{echo "<b>$whonick</b> is online now<br/>";}
}else{ echo "You can't send SMS Buzz to yourself<br/>";}


        echo "</small></center><p align=\"center\"><small>";
 echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";


echo "</small></p>";
    echo "</card>";
      
}else if($action=="numberopt")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Free SMS Zone",$pstyle);
    addonline(getuid_sid($sid),"Phone Number Verification","");
    echo "<card id=\"main\" title=\"Phone Number Verification\">";

        $uid =isnum((int)getuid_sid($sid));
        $phonecode = mysql_fetch_array(mysql_query("SELECT phonecode FROM dcroxx_me_users WHERE id='".$uid."'"));
        $code = $phonecode[0];

        
        if(empty($code)){
        echo "<p align=\"center\"><small>";
        echo "<b>Update Phone Number</b></small><br/>";
        echo "</p>";
		        echo "<p align=\"center\">";
        echo "<small>
		At this moment only GrameenPhone, Banglalink, Airtel, Robi, Citycell and Teletalk users can verify their phone number.";
		
				echo"<form method=\"post\" action=\"sms.php?action=phonecode\"><center>
				 <br/>Enter Your Phone Number:<br/>
				<font color=\"red\">(Example: 8801822751576)</font></small><br/>
<textarea name=\"number\" style=\"height:30px;width: 200px;\" maxlength=\"13\" placeHolder=\"880\"></textarea><br/>
<input type=\"submit\" name=\"Submit\" style=\"height:30px;width: 205px;\" value=\"Send Verification Code\"/><br/>
</form>";
		/*echo" <small>Enter Your Phone Number:</small><br/>";
        echo "<input name=\"number\" maxlength=\"20\" value=\"880\"/><br/>";
        echo "<anchor>Send Verification Code";
        echo "<go href=\"sms.php?action=phonecode\" method=\"post\">";
        echo "<postfield name=\"number\" value=\"$(number)\"/>";
        echo "</go></anchor>";*/
        echo "</p>";
        
        }else{
        echo "<p align=\"center\">";
   
echo "<small>We have already sent you an SMS with verification code. Please check your SMS inbox.</small><br/>";
    
        echo "</p>";
		
        }
        
///////////////


        echo "<p align=\"center\"><small>";
 echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";


echo "</small></p>";
    echo "</card>";
      
}
else if($action=="verifyopt")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Free SMS Zone",$pstyle);
    addonline(getuid_sid($sid),"Phone Number Verification","");
    echo "<card id=\"main\" title=\"Phone Number Verification\">";

        $uid =getuid_sid($sid);
        echo "<p align=\"center\"><small>";
        echo "<b>Verify Phone Number</b></small><br/>";
        echo "</p>";

       // echo "<small>Verification Code:</small><br/>";
		
		echo" <center><br/><small>Verification Code:</small><br/>
<form method=\"post\" action=\"sms.php?action=phoneverify\">
<textarea name=\"code\" style=\"height:30px;width: 200px;\" maxlength=\"7\"></textarea><br/>
<input type=\"submit\" name=\"Submit\" style=\"height:30px;width: 205px;\" value=\"VERIFY\"/><br/>
</form>";
		
		
    /*    echo "<input name=\"code\" maxlength=\"10\"/><br/>";
        echo "<anchor>Verify";
        echo "<go href=\"sms.php?action=phoneverify\" method=\"post\">";
        echo "<postfield name=\"code\" value=\"$(code)\"/>";
        echo "</go></anchor>";*/
        echo "<br/><br/>";



 echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";


echo "</center>";
    echo "</body>";
      
}

////////////////////////////////////////// Phone Code
else if($action=="smsbuzz_proc"){
      $pstyle = gettheme($sid);
      echo xhtmlhead("Free SMS Zone",$pstyle);
    addonline(getuid_sid($sid),"Phone Number Verification","");

  echo "<card id=\"main\" title=\"$sitename\">";
  echo "<p align=\"center\">";
  $uid = getuid_sid($sid);
  $who = $_GET["who"];
  $whonick = getnick_uid($_GET["who"]);
  
if(getplusses(getuid_sid($sid))<20){
echo "<img src=\"images/notok.gif\" alt=\"X\"/>You should have at least 20 plusses to use this feature!";
}else{
$pro = mysql_fetch_array(mysql_query("SELECT verifyno FROM dcroxx_me_users WHERE id='".$who."'"));
$number = $pro[0];
$msgtxt = "Hello $whonick,\nSomeone needs to connect you on http://socialbd.net \nIt's may be very urgent";
$sendtext = "$msgtxt";
$sendee = "SocialBD";
$sender = urlencode("$sendee");
$fnumber = "$number";
$destination = "$number";
$message = urlencode("$sendtext");
$sendsms = "http://bulk-sms.net/api/?user=tufan24&pass=tufan24&to=$number&sender=$sender&message=$message";
$getsmsstatus = file_get_contents($sendsms);
if($getsmsstatus){
echo "<img src=\"images/ok.gif\" alt=\"O\"/>We have sent an SMS to <b>$whonick</b> for you urgency and <b>20 plusses</b> are subtracted from you account";

$prof = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
$vws = $prof[0]-20; 
mysql_query("UPDATE dcroxx_me_users SET plusses='".$vws."'WHERE  id='".$uid."'");

 }else{
 echo "<img src=\"images/notok.gif\" alt=\"x\"/>Technical Problem Found. Please Try Again Later";
 }
 
 }

/*$res = mysql_query("UPDATE dcroxx_me_users SET phonecode='".$code."' WHERE id='".$uid."'");
 if($res){
 }else{ 
 echo "<img src=\"images/notok.gif\" alt=\"x\"/>Something is went wrong.";
 }*/
 

  


echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

////////////////////////////////////////// Phone Code
else if($action=="phonecode")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Free SMS Zone",$pstyle);
    addonline(getuid_sid($sid),"Phone Number Verification","");

  echo "<card id=\"main\" title=\"$sitename\">";
  echo "<p align=\"center\">";
  $uid =getuid_sid($sid);
  $unick = getnick_sid($sid);
  $phone = $_POST['number'];

  $who = $_GET['who'];
$number = $_POST["number"];

	////////////////////Golden Coin Condition By Prottay Chowdhury Tufan
	$bst = time() + 6*60*60;
$today = gmstrftime("%d.%m.%Y",$bst);
$isallowed = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_smscon WHERE uid='".$uid."' AND time='".$today."'"));
if($isallowed[0]>2){
echo "<small><img src=\"images/notok.gif\" alt=\"X\"/>You already request <b>3 times</b> today. You can request again tommorow<br/><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
echo "</card>";
echo "</wml>";
exit();
}
//////////////////SMS Function
   $number=str_replace('+','',$number); 
   $sender=str_replace('','SocialBD',$sender);
 if (strlen($number)=="11" and $country=="BD")
 {
 $number="88".$number;
 }
 if (preg_match ("/^88017/i", "$number") or preg_match ("/^88016/i", "$number") or preg_match ("/^88015/i", "$number") or preg_match ("/^88011/i", "$number") or preg_match ("/^88018/i", "$number") or preg_match ("/^88019/i", "$number"))
 {
   $t = time();
  $code = substr(sha1($t),0,6);
  $res = mysql_query("UPDATE dcroxx_me_users SET phonecode='".$code."' WHERE id='".$uid."'");
if($res)
{
$msgtxt = "Your Verification Code is $code.\n http://SocialBD.NeT";
$sendtext = "$msgtxt";
$sendee = "SocialBD";
$sender = urlencode("$sendee");
$fnumber = "$number";
$destination = "$number";
$message = urlencode("$sendtext");
/*$sendsms = "http://smsgetway.net/../users/smsapi?username=eragon1&password=eragon1&msgto=$destination&sender=SocialBD&source=SocialBD&msg=$message&msgfrom=SocialBD";*/
$sendsms = "http://bulk-sms.net/api/?user=tufan24&pass=tufan24&to=$number&sender=$sender&message=$message";
$getsmsstatus = file_get_contents($sendsms);
if($getsmsstatus) 
 {
 //echo '';
 ////////Golden Coin Grab Condition By Prottay Chowdhury Tufan
$bst = time() + 6*60*60;
$today = gmstrftime("%d.%m.%Y",$bst);
	mysql_query("INSERT INTO ibwfrr_smscon SET uid='".$uid."', time='".$today."'");
////////Golden Coin Grab Condition By Prottay Chowdhury Tufan
mysql_query("UPDATE dcroxx_me_users SET verifyno='".$number."' WHERE id='".$uid."'");
echo "<img src=\"images/ok.gif\" alt=\"O\"/>We have sent an SMS to <b>$number</b> with verification code. Please check your SMS inbox";
 }else{
 //echo ''; 
 echo "<img src=\"images/notok.gif\" alt=\"x\"/>Technical Problem Found. Please Try Again Later";
 }
 }
/* ////////Golden Coin Grab Condition By Prottay Chowdhury Tufan
$bst = time() + 6*60*60;
$today = gmstrftime("%d.%m.%Y",$bst);
	mysql_query("INSERT INTO ibwfrr_smscon SET uid='".$uid."', time='".$today."'");
////////Golden Coin Grab Condition By Prottay Chowdhury Tufan
 */
 
 /*
mysql_query("UPDATE dcroxx_me_users SET verifyno='".$number."' WHERE id='".$uid."'");
echo "<img src=\"images/ok.gif\" alt=\"O\"/>We have sent an SMS to <b>$number</b> with verification code. Please check your SMS inbox";
}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>Technical Problem Found. Please Try Again Later";
}*/
}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>Please type a correct number";
}

  


echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}
else if($action=="delete")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Free SMS Zone",$pstyle);
addonline(getuid_sid($sid),"SMS Page","sms.php?action=main");
echo "<card id=\"main\" title=\"Requesting SMS\">";
echo "<p align=\"center\"><small>";
$code = $_POST["code"];
$haha = mysql_fetch_array(mysql_query("SELECT email, emailcode FROM dcroxx_me_users WHERE uid='".$uid."'"));


	////////////////////Golden Coin Condition By Prottay Chowdhury Tufan
	$bst = time() + 6*60*60;
$today = gmstrftime("%d.%m.%Y",$bst);
$isallowed = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_smscon WHERE uid='".$uid."' AND time='".$today."'"));
if($isallowed[0]>2){
echo "<img src=\"images/notok.gif\" alt=\"X\"/>You already request <b>3 times</b> today. You can request again tommorow<br/><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
echo "</card>";
echo "</wml>";
exit();
}

  $res = mysql_query("UPDATE dcroxx_me_users SET phonecode='' WHERE id='".$uid."'");
  
if($res){
////////Golden Coin Grab Condition By Prottay Chowdhury Tufan
$bst = time() + 6*60*60;
$today = gmstrftime("%d.%m.%Y",$bst);
	mysql_query("INSERT INTO ibwfrr_smscon SET uid='".$uid."', time='".$today."'");
////////Golden Coin Grab Condition By Prottay Chowdhury Tufan

echo "<img src=\"images/ok.gif\" alt=\"o\"/>Your phone number has been reseted and old verification code is no longer valid.<br/><br/>";
echo "<a href=\"sms.php?action=numberopt\">Click here to get a new verification code</a><br/>";
}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>Unknown Error!<br/>";
}

echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "";
echo "</small></p>";
echo "</card>";
}
else if($action=="phoneverify")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Free SMS Zone",$pstyle);
    addonline(getuid_sid($sid),"Phone Number Verification","");
    $code = $_POST["code"];
  echo "<card id=\"main\" title=\"$sitename\">";
  echo "<p align=\"center\"><small>";
  $uid =getuid_sid($sid);
  $unick = getnick_sid($sid);


  $acode = mysql_fetch_array(mysql_query("SELECT phonecode FROM dcroxx_me_users WHERE id='".$uid."'"));
  $acode = $acode[0];

  if($code == $acode){
   
  $res = mysql_query("UPDATE dcroxx_me_users SET phstatus='1' WHERE id='".$uid."'");

  echo "<img src=\"images/ok.gif\" alt=\"o\"/>Phone Number Verified Successfully!<br/>";

  }else{

    echo "<img src=\"images/notok.gif\" alt=\"x\"/>Invalid Verification Code!<br/>";
  }
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</small></p></card>";
}
///////////
/////////////////////error//////////////////////////

else
{
  echo "<card id=\"main\" title=\"SocialBD.NeT\">";
  echo "<p align=\"center\"><small>";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
    
}
 ?>
 </html>
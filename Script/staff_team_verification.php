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
$who = $_GET["who"];
$whonick = getnick_uid($who);
$unick = getnick_uid($uid);
$byuid = getuid_sid($sid);
$sitename = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='sitename'"));
$sitename = $sitename[0];
$ubrw = explode(" ",$HTTP_USER_AGENT);
$ubrw = $ubrw[0];
$ipad = getip();

cleardata();

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
 if(!ismod(getuid_sid($sid))){
      $pstyle = gettheme($sid);
      echo xhtmlhead("Staff Re-Verification System V1.0",$pstyle);
      echo "Sorry you are not in our <b>Staff Team</b><br/>";
      echo "<a href=\"index.php?action=main\">Home</a>";
      exit();
    }
////////////////// Ticket Main
if($action==""){
$pstyle = gettheme($sid);
echo xhtmlhead("Staff Re-Verification System V1.0",$pstyle);
addonline(getuid_sid($sid),"Support Ticket","helpdesk.php?action=main");	
echo"<center><b>Welcome to Staff Re-Verification System V1.0</b></center>";
$view = $_GET["view"];
if($view==""){

    echo "<p align=\"left\">";
	echo"(*) We are going to bring a lots of powerful features for you.<br/>";
	echo"(*) We have decided that all staffs should have to re-verify their identity for unlock features.<br/>";
	echo"(*) We need some more activities from all of you.<br/>";
	echo"(*) Please try to connect with us more times and maintenance all users.<br/>";
	echo"(*) All from should be fill up properly so that we can growth by the right way.<br/><br/>";
	echo"(*) Are you ready for help us to do something special for you?????<br/><br/>";
	echo"<b><a href=\"?view=form\"><font color=\"green\">YES, I always with SocialBD</font></a></b><br/>
	     <b><a href=\"index.php?action=main\"><font color=\"red\">NO, Not Interested</font></a></b><br/><br/>";
	
	}else if($view=="form"){
	      $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM staff_team_re_verification WHERE uid='".getuid_sid($sid)."'"));
      if($noi[0]>0){
echo "<meta http-equiv=\"refresh\" content=\"1; URL= index.php?action=main\"/>";
echo"<center>Sorry, You've already submit Re-Verification</center>";
      }else{
echo "<br/><center><form method=\"post\" action=\"?action=submit\">";
echo"<b><a href=\"staff_team_verification.jpg\"><font color=\"green\">See a Demo</font></a></b><br/>";
echo"<font color=\"red\">(*)</font> marks indicators are must be fill up properly<br/>";

echo "Your Full Name: <font color=\"red\">(*)</font><br/>
<input name=\"full_name\" maxlength=\"50\" style=\"height:20px;width: 270px;\"/><br/>";

echo "Your Full Address: <font color=\"red\">(*)</font><br/>
<textarea name=\"full_address\" style=\"height:50px;width: 270px;\" ></textarea><br/>";

echo "Your Education/Work: <font color=\"red\">(*)</font><br/>
<textarea name=\"education_work\" style=\"height:50px;width: 270px;\" ></textarea><br/>";

echo "Your Personal Number: <font color=\"red\">(*)</font><br/>
<input name=\"personal_number\" maxlength=\"20\" style=\"height:20px;width: 270px;\"/><br/>";

echo "Your Personal/Official Email: <font color=\"red\">(*)</font><br/>
<input name=\"personal_email\" maxlength=\"35\" style=\"height:20px;width: 270px;\"/><br/>";

echo "Your Facebook ID Link: <font color=\"red\">(*)</font><br/>
<input name=\"facebook_account\" maxlength=\"200\" style=\"height:20px;width: 270px;\"/><br/>";

echo "Which amount of Megabytes you <br/>need per day for use SocialBD only:<br/>
<input name=\"mb_amount\" maxlength=\"40\" style=\"height:20px;width: 270px;\"/><br/>";

echo "What is you opinion about SocialBD:<br/>
<textarea name=\"opinion\" style=\"height:50px;width: 270px;\" ></textarea><br/>";



  echo "<input type=\"submit\" name=\"Submit\" value=\"Re-Verification\"/><br/>
</form>";
}
  }else{
  echo"What are your trying to search????<br/>";
  }
  
  echo "<br/><br/>";
/*  if(ismod(getuid_sid($sid)))
  {
    echo "<a href=\"helpdesk.php?action=valltickets\">&#187; All Support Tickets &#171;</a><br/>";
  }*/

    echo "</p>";
    echo"<p align=\"center\">";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a><br/><br/>";
  echo "</p>";
    echo "</card>";
}
////////////////// Submit A Complain
else if($action=="submit")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Staff Re-Verification System V1.0",$pstyle);
	  
    $full_name = $_POST["full_name"];
    $full_address = $_POST["full_address"]; 
	$education_work = $_POST["education_work"];  
	$personal_number = $_POST["personal_number"];  
	$personal_email = $_POST["personal_email"];  
	$facebook_account = $_POST["facebook_account"];  
	$mb_amount = $_POST["mb_amount"];
	$opinion = $_POST["opinion"];

    $uid = getuid_sid($sid);
    addonline(getuid_sid($sid),"Creating Support Ticket","helpdesk.php?action=main");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"center\">";

      $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM staff_team_re_verification WHERE uid='".getuid_sid($sid)."'"));
      if($noi[0]>0){
echo "<img src=\"images/notok.gif\" alt=\"x\"/>You have already submit re-verification process.<br/><br/>";
echo "<a href=\"helpdesk.php?action=main\">Go Back</a><br/>";

      }else{

	if($full_name=="" || $full_address=="" || $education_work=="" || $personal_number=="" || $personal_email=="" || $facebook_account==""){
	  echo"<font color=\"red\">(*)</font> marks indicators are must be fill up properly<br/>";
            echo "<br/><a href=\"staff_team_verification.php?view=form\">Go Back</a><br/>";
	}else{
	
	    $res = mysql_query("INSERT INTO staff_team_re_verification SET 
		full_name='".$_POST["full_name"]."', 
		full_address='".$_POST["full_address"]."', 
		education_work='".$_POST["education_work"]."', 
		personal_number='".$_POST["personal_number"]."', 
		personal_email='".$_POST["personal_email"]."', 
		facebook_account='".$_POST["facebook_account"]."', 
		mb_amount='".$_POST["mb_amount"]."', 
		opinion='".$_POST["opinion"]."', 
		uid='".$uid."', 
		time='".time()."'");
		
	    if($res){
		echo "<img src=\"images/ok.gif\" alt=\"O\"/>You have Successfully done Re-Verification<br/><br/>";
                echo "<a href=\"staff_team_verification.php?view=form\">Go Back</a><br/>";
		////////////////<-----------Notification By Tufan420----------->
		$user = getnick_sid($sid);
		$text = htmlspecialchars(substr(parsepm($crname), 0, 15));
		$uid = getuid_sid($sid);
		mysql_query("INSERT INTO ibwf_notifications SET text='[user=".$uid."]".$user."[/user] has successfully complete re-verification', byuid='3', touid='1', unread='1', timesent='".time()."'");
		///////////////<-----------Notification By Tufan420------------->
	    }else{
		echo "Error submitting re-verification<br/>";
                echo "<br/><a href=\"staff_team_verification.php?view=form\">Go Back</a><br/>";
	    }
	}
	
      }
	
    
    echo "</p>";
    echo"<p align=\"center\">";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
    echo "</card>";
}

//////////////////// Delete / Remove Tickets [Only For Staffs]
else if($action=="remove")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Staff Re-Verification System V1.0",$pstyle);
    $tid = $_GET["tid"];
    addonline(getuid_sid($sid),"Deleting Support Ticket","helpdesk.php?action=main");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"center\"><small>";
    if(getuid_sid($sid)==1){
	$res = mysql_query("DELETE FROM staff_team_re_verification WHERE id='".$tid."'");
	if($res){
	    echo "<img src=\"images/ok.gif\" alt=\"\"/>Re-Verification Deleted<br/>";
	}else{
	    echo "<img src=\"images/notok.gif\" alt=\"\"/>Database Error<br/>";
	}
    }else{
	echo "Permission Denied<br/>";
    }
    echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
    echo "</small></p></card>";
}
/////////////// View A Ticket
else if($action=="submission"){
$pstyle = gettheme($sid);
echo xhtmlhead("Staff Re-Verification System V1.0",$pstyle);
  addonline(getuid_sid($sid),"Viewing A Support Ticket","helpdesk.php?action=$action");
  echo "<card id=\"main\" title=\"$sitename\">";
  echo "<p align=\"left\">";
  if(getuid_sid($sid)==1){
  $det = mysql_fetch_array(mysql_query("SELECT id, full_name, full_address, education_work, personal_number,
  personal_email, facebook_account, mb_amount, opinion, uid, time FROM staff_team_re_verification WHERE uid='".$who."'"));
  
$creator = getnick_uid($det[9]);
echo "Staff Re-Verification Of <b>$creator</b> - <a href=\"staff_team_verification.php?action=remove&tid=$det[0]\">REMOVE</a><br/>
<small>(Verify On: <b>".date("dS F y - h:i:s A", $det[10])."</b>)</small><br/>";
  echo "<br/>";
  
  echo "Full Name: <b>$det[1]</b><br/>";
  echo "Full Adress: <b>$det[2]</b><br/>";
  echo "Education/Work: <b>$det[3]</b><br/>";
  echo "Personal Number: <b>$det[4]</b><br/>";
  echo "Persoanl/Official Email: <b>$det[5]</b><br/>";
  echo "Facebook: <b>$det[6]</b><br/>";
  echo "MB Amount: <b>$det[7]</b><br/>";
  echo "Opinion: <b>$det[8]</b><br/>";
  }else{
  echo "Permission Denied!!<br/>Only Staff Controller can use this";
  }
  echo "</p>";
  echo"<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
  echo "</card>";
}
else
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Staff Re-Verification System V1.0",$pstyle);
  addonline(getuid_sid($sid),"Lost","");
  echo "<card id=\"main\" title=\"$sitename\">";
  echo "<p align=\"center\"><small>";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
?>
</html>
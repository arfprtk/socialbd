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

////////////////// Ticket Main
if($action==""){
$pstyle = gettheme($sid);
echo xhtmlhead("SocialBD Balance ToolKiT V1.0",$pstyle);
addonline(getuid_sid($sid),"Support Ticket","helpdesk.php?action=main");	
echo"<center><b>Welcome to SocialBD Balance ToolKiT V1.0</b></center>";
$view = $_GET["view"];
if($view==""){
$balance = mysql_fetch_array(mysql_query("SELECT balance, withdraw_balance FROM dcroxx_me_users WHERE id='".getuid_sid($sid)."'"));

    echo "<p align=\"left\">";
	echo"(*) Dear <b>$unick</b>, we are trying to give you the best service from us<br/>";
	echo"(*) At presently you can earn by inviting users, recharge card, cricket league and archive active times<br/>";
	echo"(*) You have <b>$balance[0] BDT</b> in your balance and <b>$balance[1] BDT</b> in withdraw balance<br/><br/>";
	
	echo"<center><b>Wanna Withdraw??????<br/>
	<a href=\"?view=withdraw\"><font color=\"green\">Yap Sure, I want</font></a><br/>
	</b>
	     <b><a href=\"index.php?action=viewuser&who=$uid\"><font color=\"red\">Go back to your profile</font></a></b></center>";

	
	}else if($view=="withdraw"){

	echo"<br/>(*) If you want to withdraw via <b>Mobile Recharge</b> then you have to charged <b>2 BDT</b> extra<br/>";
	echo"(*)  If you want to withdraw via <b>bKash</b> then you have to charged <b>2% BDT</b> extra<br/>";
	echo"(*)  If you want to withdraw via <b>Online Accounts</b> then you have to charged <b>1 Dollar</b> extra<br/><br/>
	<font color=\"red\">If you don't follow this instructions then we can't approve your request.</font><br/>";
echo "<center><form method=\"post\" action=\"?action=submit\">";
//echo"<small><b><a href=\"?view=rules\"><font color=\"green\">Read First Then Try To Withdraw</font></a></b></small><br/><br/>";
//echo"<font color=\"red\">(*)</font> marks indicators are must be fill up properly<br/><br/>";

echo "<small>Your Full Name:</small> <br/>
<input name=\"full_name\" maxlength=\"50\" style=\"height:20px;width: 270px;\"/><br/><br/>";

echo "<small>Amount you want to withdraw:</small> <br/>
<input name=\"amount\" maxlength=\"50\" style=\"height:20px;width: 270px;\"/><br/><br/>";


echo"<small>Choose Payment Type:</small><br/>
     <select name=\"type\" style=\"height:30px;width:270px;\">
     <option value=\"0\">- Please Select -</option>
     <option value=\"1\">Mobile Recharge</option>
     <option value=\"2\">bKash</option>
     <option value=\"3\">Payza/AlertPay</option>
     <option value=\"4\">Paypal</option>
     </select><br/><br/>";



echo "<small>Number/Email:</small> <br/>
<input name=\"carrier\" maxlength=\"100\" style=\"height:20px;width: 270px;\"/><br/><br/>";

echo "<input type=\"submit\" name=\"Submit\" value=\"WITHDRAW\" style=\"height:30px;width: 277px;\"/><br/>
</form>";

  }else if($view=="rules"){
  	echo"<br/>(*) If you want to withdraw via <b>Mobile Recharge</b> then you have to charged <b>2 BDT</b> extra<br/>";
	echo"(*)  If you want to withdraw via <b>bKash</b> then you have to charged <b>2% BDT</b> extra<br/>";
	echo"(*)  If you want to withdraw via <b>Online Accounts</b> then you have to charged <b>1 Dollar</b> extra<br/><br/><br/>";
	
	echo"<b><a href=\"?view=withdraw\"><font color=\"green\">Withdraw Now</font></a></b><br/>";
	echo"<b><a href=\"index.php?action=viewuser&who=$uid\"><font color=\"red\">Not Now</font></a></b><br/>";
  }else{
  echo"What are your trying to search????<br/>";
  }
  
  echo "<br/>";
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
      echo xhtmlhead("SocialBD Balance ToolKiT V1.0",$pstyle);
	  
	  
	  echo"Try next Payment Days ;)";
	  
  /*  $full_name = $_POST["full_name"];
    $amount = $_POST["amount"]; 
	$type = $_POST["type"];  
	$carrier = $_POST["carrier"];  

    $uid = getuid_sid($sid);
    addonline(getuid_sid($sid),"Creating Support Ticket","helpdesk.php?action=main");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"center\">";

	//	if($full_name=="" || $amount==""){
	if($full_name=="" || $amount=="" || $type=="0" || $carrier==""){
	  echo"All form required!<br/>";
            echo "<br/><a href=\"staff_team_verification.php?view=form\">Go Back</a><br/>";
			    echo"<p align=\"center\">";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
		exit();	
	}	

	
	
      $noi = mysql_fetch_array(mysql_query("SELECT status FROM dcroxx_me_withdraw WHERE uid='".getuid_sid($sid)."'"));
      if($noi[0]=="0"){
echo "<img src=\"images/notok.gif\" alt=\"x\"/>You have already a opened request.<br/><br/>";
//echo "<a href=\"helpdesk.php?action=main\">Go Back</a><br/>";

      }else{

	    $res = mysql_query("INSERT INTO dcroxx_me_withdraw SET 
		full_name='".$_POST["full_name"]."', 
		amount='".$_POST["amount"]."', 
		type='".$_POST["type"]."', 
		carrier='".$_POST["carrier"]."', 
		withdraw_time='', 
		uid='".$uid."', 
		time='".time()."',
		status='0'");
		
	    if($res){
		echo "<img src=\"images/ok.gif\" alt=\"O\"/>You have Successfully request for a withdraw<br/><br/>";
              //  echo "<a href=\"staff_team_verification.php?view=form\">Go Back</a><br/>";
		////////////////<-----------Notification By Tufan420----------->
		$user = getnick_sid($sid);
		$text = htmlspecialchars(substr(parsepm($crname), 0, 15));
		$uid = getuid_sid($sid);
		mysql_query("INSERT INTO ibwf_notifications SET text='[user=".$uid."]".$user."[/user] has request for a [aFardin=balance_tools.php?action=withdraw]money withdraw[/aFardin]', byuid='3', touid='1', unread='1', timesent='".time()."'");
		///////////////<-----------Notification By Tufan420------------->
	    }else{
		echo "Error requesting.<br/>";
              //  echo "<br/><a href=\"staff_team_verification.php?view=form\">Go Back</a><br/>";
	    }
	
	
      }
	*/
    
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
      echo xhtmlhead("SocialBD Balance ToolKiT V1.0",$pstyle);
    $id = $_GET["id"];
    addonline(getuid_sid($sid),"Deleting Support Ticket","helpdesk.php?action=main");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"center\"><small>";
    if(getuid_sid($sid)==1){
	$res = mysql_query("DELETE FROM dcroxx_me_withdraw WHERE id='".$id."'");
	if($res){
	    echo "<img src=\"images/ok.gif\" alt=\"\"/>Request Deleted<br/>";
		
$l = mysql_fetch_array(mysql_query("SELECT uid, amount FROM dcroxx_me_withdraw WHERE id='".$id."'"));
  $lnick = getnick_uid($l[0]);
$note = "Sorry $lnick, We can't accept your withdraw request. Please contact with Tufan420 for more details";
notify($note,$uid,$l[0]);
	}else{
	    echo "<img src=\"images/notok.gif\" alt=\"\"/>Database Error<br/>";
	}
    }else{
	echo "Permission Denied<br/>";
    }
    echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
    echo "</small></p></card>";
}
else if($action=="withdraw")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Help Desk",$pstyle);
  $who = $_GET["who"];
    addonline(getuid_sid($sid),"Support Ticket","helpdesk.php?action=main");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"left\"><small>";
    if(!ismod(getuid_sid($sid))){
	echo "Permission Denied<br/>";
    }else{
	
    //  echo "<a href=\"helpdesk.php?action=valltickets&amp;who=$uid\">Who wants to appoint me?</a><br/><br/>";
	if($page=="" || $page<=0)$page=1;
        if($who==""){
          $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_withdraw"));
        }else{
          $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_withdraw WHERE uid='".$who."' AND status='0'"));
        }
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    
		
    ////// changable
    if($who==""){
$sql = "SELECT id, full_name, amount, type, carrier, withdraw_time, uid, time, status FROM dcroxx_me_withdraw ORDER BY id DESC LIMIT $limit_start, $items_per_page";
    }else{
$sql = "SELECT id, full_name, amount, type, carrier, withdraw_time, uid, time, status FROM dcroxx_me_withdraw WHERE uid='".$who."' AND status='0' ORDER BY id DESC LIMIT $limit_start, $items_per_page";
    }
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0){
    while ($item = mysql_fetch_array($items)){
	if($item[8]=="0"){
	    $status = "Unpaid";
	    $handler = getnick_uid($item[7]);
	    //$hndld = "<br/>Handled By: <b>$handler</b>";
	}
	else
	{
	    $status = "Paid";
	}
	
	if ($item[3]==0){
	$carrier = "None";
	}else if ($item[3]==1){
	$carrier = "Mobile Recharge";
	}else if ($item[3]==2){	
	$carrier = "bKash";
	}else if ($item[3]==3){	
	$carrier = "Payza/AlertPay";
	}else if ($item[3]==4){	
	$carrier = "Paypal";
	}
	$appointed = getnick_uid($item[5]);
	$crtr = getnick_uid($item[4]);
	$lnk = "Request ID: <b>#$item[0]</b><br/>
	User: <a href=\"index.php?action=viewuser&amp;who=$item[6]\">$item[1]</a><br/>
	Amount TO Withdraw: <b>$item[2]</b><br/>
	Withdraw Via: <b>$carrier</b><br/>
	Send TO: <b>$item[4]</b><br/>
	Status: <b>$status</b>";
		if($item[8]<1)
	    {
		$pa = " / <a href=\"?action=paid&amp;id=$item[0]\">Paid</a>";
	    }
	if(ismod(getuid_sid($sid))){
	    $del = "<a href=\"?action=remove&amp;id=$item[0]\">Delete</a>";
	}
	echo "$lnk$pa $hndld<br/>$del";

	echo "<br/>----------<br/>";
    }
    }
    //echo "<br/>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"?action=withdraw&amp;page=$ppage\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"?action=withdraw&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"helpdesk.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"who\" value=\"$uid\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    }
    echo "</small></p>";
    echo"<p align=\"center\">";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/><small>Home</small></a>";
  echo "</p>";
    echo "</card>";
}
else if($action=="paid"){
      $pstyle = gettheme($sid);
      echo xhtmlhead("Help Desk",$pstyle);
    $id = $_GET["id"];
    addonline(getuid_sid($sid),"Handling Support Ticket","helpdesk.php?action=$action");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"center\"><small>";
    if(ismod(getuid_sid($sid))){
	$res = mysql_query("UPDATE dcroxx_me_withdraw SET status='1', withdraw_time='".time()."' WHERE id='".$id."'");
	if($res){
	    echo "<img src=\"images/ok.gif\" alt=\"\"/>Balance Paid<br/>";
		
	//////////////////////////////////////////	
$l = mysql_fetch_array(mysql_query("SELECT uid, amount FROM dcroxx_me_withdraw WHERE id='".$id."'"));
$opl = mysql_fetch_array(mysql_query("SELECT balance, withdraw_balance FROM dcroxx_me_users WHERE id='".$l[0]."'"));
$npl11 = $opl[0] - $l[1];
$npl22 = $opl[1] + $l[1];
mysql_query("UPDATE dcroxx_me_users SET lastplreas='BDT: $l[1] Withdraw', balance='".$npl11."', withdraw_balance='".$npl22."' WHERE id='".$l[0]."'");


	
$l = mysql_fetch_array(mysql_query("SELECT uid, amount FROM dcroxx_me_withdraw WHERE id='".$id."'"));
  $lnick = getnick_uid($l[0]);
  $lmoney = "$l[1]";

$note = "Hello $lnick, We have approved your $lmoney BDT money withdraw request. Please keep in touch with SocialBD and get more money :)";
notify($note,$uid,$l[0]);

  
$nol = mysql_fetch_array(mysql_query("SELECT phstatus FROM dcroxx_me_users WHERE id='".$l[0]."'"));
if($nol[0]!=0){
$nopl = mysql_fetch_array(mysql_query("SELECT verifyno FROM dcroxx_me_users WHERE id='".$l[0]."'"));
if($nopl[0]!=""){

$pro = mysql_fetch_array(mysql_query("SELECT verifyno FROM dcroxx_me_users WHERE id='".$l[0]."'"));
$number = $pro[0];
$msgtxt = "Hello $lnick,\nWe have approved your $lmoney BDT money withdraw request.\nPlease keep in touch with SocialBD and get more money :)";
$sendtext = "$msgtxt";
$sendee = "SocialBD";
$sender = urlencode("$sendee");
$fnumber = "$number";
$destination = "$number";
$message = urlencode("$sendtext");
$sendsms = "http://bulk-sms.net/api/?user=tufan24&pass=tufan24&to=$number&sender=$sender&message=$message";
$getsmsstatus = file_get_contents($sendsms);
if($getsmsstatus){echo "$lnick will get a notification soon";}else{echo "";}

}else{echo "Please verify your mobile number for getting withdraw notification on your mobile<br/>";}
}else{echo "Please verify your mobile number for getting withdraw notification on your mobile<br/>";}

	/////////////////////////////////////////	
	}else{
	    echo "<img src=\"images/notok.gif\" alt=\"\"/>Database Error<br/>";
	}
    }else{
	echo "Permission Denied<br/>";
    }
    echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
    echo "</small></p></card>";
}


else if($action=="reports")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Withdraw Reports",$pstyle);
  $who = $_GET["who"];
    addonline(getuid_sid($sid),"Withdraw Reports","balance_tools.php?action=reports");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"left\"><small>";

if($page=="" || $page<=0)$page=1;
    if($who==""){
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_withdraw_report WHERE uid='".$uid."'"));
    }else{
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_withdraw_report WHERE uid='".$who."'"));
    }

        
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    
    
    ////// changable
    if($who==""){
 $sql = "SELECT id, reason, amount, wtime FROM dcroxx_me_withdraw_report WHERE uid='".$uid."' ORDER BY wtime DESC LIMIT $limit_start, $items_per_page";
   }else{
 $sql = "SELECT id, reason, amount, wtime FROM dcroxx_me_withdraw_report WHERE uid='".$who."' ORDER BY wtime DESC LIMIT $limit_start, $items_per_page";
  }

    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0){
    while ($item = mysql_fetch_array($items)){


  $appointed = getnick_uid($item[5]);
  $crtr = getnick_uid($item[4]);
  $lnk = "TrxID: <b>#$item[0]</b><br/>Amount: <b>$item[2] BDT</b> ($item[1])";

  echo "$lnk<br/>------------------<br/>";
    }
    }
    //echo "<br/>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"?action=withdraw&amp;page=$ppage\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"?action=withdraw&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"helpdesk.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"who\" value=\"$uid\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    
    echo "</small></p>";
    echo"<p align=\"center\">";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/><small>Home</small></a>";
  echo "</p>";
    echo "</card>";
}


else
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD Balance ToolKiT V1.0",$pstyle);
  addonline(getuid_sid($sid),"Lost","");
  echo "<card id=\"main\" title=\"$sitename\">";
  echo "<p align=\"center\"><small>";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
?>
</html>
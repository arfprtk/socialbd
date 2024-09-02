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

cleardata();

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

////////////////// Ticket Main
if($action=="main")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Help Desk",$pstyle);
    addonline(getuid_sid($sid),"Support Ticket","helpdesk.php?action=main");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"left\">";
	
if(ismod(getuid_sid($sid))){
echo"<b>Tickets Menu:</b><br/>";
$alltkt = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_complains"));
echo "<a href=\"helpdesk.php?action=valltickets\">&#187;All Tickets</a> [$alltkt[0]]<br/>";

$allopentkt = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_complains WHERE status='0'"));
echo "<a href=\"helpdesk.php?action=vopentickets\">&#187;Open Tickets</a> [$allopentkt[0]]<br/>";

$allclosetkt = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_complains WHERE status='1'"));
echo "<a href=\"helpdesk.php?action=vclosetickets\">&#187;Closed Tickets</a> [$allclosetkt[0]]<br/>";

$allappointtkt = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_complains WHERE staff='".$uid."'"));
echo "<a href=\"helpdesk.php?action=valltickets&amp;who=$uid\">&#187;Appointed To Me</a> [$allappointtkt[0]]<br/>";

$allhandletkt = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_complains WHERE handler='".$uid."'"));
echo "<a href=\"helpdesk.php?action=vhandledtickets\">&#187;Handled By Me</a> [$allhandletkt[0]]<br/>";
}else{}
	
    ////////// Select Catagory
echo "<form method=\"post\" action=\"?action=submit\">";
    echo "<b>Create a Ticket:</b><br/><small>Please Choose Category:</small><br/><select name=\"ccid\" style=\"height:30px;width: 270px;\" >";
    echo "<option value=\"General Questions\">General Questions</option>"; 
    echo "<option value=\"Forgot My Password\">Forgot My Password</option>";
    echo "</select><br/>";
    //////////////// Subject
    echo "<small>Subject:</small><br/><input name=\"crname\" maxlength=\"30\" style=\"height:30px;width: 270px;\"/><br/>";
    //////////////// Description
    echo "<small>Description Of The Problem:</small><br/><textarea name=\"des\" style=\"height:50px;width: 270px;\" ></textarea><br/>";
    $fcats = mysql_query("SELECT id, name FROM dcroxx_me_users WHERE perm>'0' ORDER BY id");
  echo "<small>Appoint Staff: </small><br/><select name=\"staff\" style=\"height:30px;width: 270px;\">";
  while ($fcat=mysql_fetch_array($fcats))
  {
  echo "<option value=\"$fcat[0]\">$fcat[1]</option>";
  }
  echo "</select><br/>";
  //echo "<anchor>Create";
  //echo "<go href=\"helpdesk.php?action=submit\" method=\"post\">";
  echo "<postfield name=\"ccid\" value=\"$(ccid)\"/>";
  echo "<postfield name=\"crname\" value=\"$(crname)\"/>";
  echo "<postfield name=\"des\" value=\"$(des)\"/>";
  echo "<postfield name=\"staff\" value=\"$(staff)\"/>";
  //echo "</go></anchor>";
  echo "<br/><input type=\"submit\" name=\"Submit\" value=\"SUBMIT\" style=\"height:30px;width: 270px;\"/><br/>
</form>";
  
  
  echo "<br/><br/>";

  
  echo "<small><b>My Support Tickets:</b><br/>";
  //////////////////////////// My Created Tickets
          //////ALL LISTS SCRIPT <<
$count22 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_complains WHERE uid='".$uid."'"));
    if($count22[0]>0)
    {
    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_complains WHERE uid='".$uid."'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    
    ////// changable

    $sql = "SELECT id, subject, description, ccid, uid, staff, status, handler FROM ibwf_complains WHERE uid='".$uid."' ORDER BY id DESC LIMIT $limit_start, $items_per_page";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
	if($item[6]>0)
	{
	    $status = "Closed";
	    $handler = getnick_uid($item[7]);
	    $hndld = "<br/>Handled By: <b>$handler</b>";
	}
	else
	{
	    $status = "Opened";
	    $done = "/<a href=\"helpdesk.php?action=close&amp;tid=$item[0]\">Close</a>";
	}
	
	$appointed = getnick_uid($item[5]);
	$lnk = "&#187;Ticket <b>#$item[0]</b><br/>Subject: <a href=\"helpdesk.php?action=viewmyticket&amp;tid=$item[0]\">$item[1]</a><br/>Status: <b>$status</b><br/>Appointed Staff: <b>$appointed</b>";
	if(ismod(getuid_sid($sid)))
	{
	    $del = "<br/><a href=\"helpdesk.php?action=remove&amp;tid=$item[0]\">Delete</a>";
	    
	}
	echo "$lnk $hndld$del";
	if($item[6]<1 && ismod(getuid_sid($sid)))
	    {
		echo "/<a href=\"helpdesk.php?action=close&amp;tid=$item[0]\">Close</a>";
	    }
	echo "<br/>----------<br/>";
    }
    }
    //echo "<br/>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"helpdesk.php?action=main&amp;page=$ppage\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"helpdesk.php?action=main&amp;page=$npage\">Next&#187;</a>";
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
    else
    {
	echo "No support tickets!<br/>";
    }
    echo "</small></p>";
    echo"<p align=\"center\"><small>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a><br/><br/>";
//echo "<b>Script By: &#169;MD.Tufan420</b>";
  echo "</small></p>";
    echo "</card>";
}
////////////////// Submit A Complain
else if($action=="submit")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Help Desk",$pstyle);
    $crname = $_POST["crname"];
    $des = $_POST["des"];
    $staff = $_POST["staff"]; 
    $ccid = $_POST["ccid"];
    $uid = getuid_sid($sid);
    addonline(getuid_sid($sid),"Creating Support Ticket","helpdesk.php?action=main");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"center\"><small>";
  $amount = mysql_fetch_array(mysql_query("SELECT balance FROM dcroxx_me_users WHERE id='".getuid_sid($sid)."'"));
  if($amount[0] < 2)
  {
      echo "[x]<br/>Insufficient Balance<br/>";
            echo "<br/><a href=\"helpdesk.php?action=main\">Go Back</a><br/>";
            echo "</small></p>";
                echo"<p align=\"center\"><small>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a><br/><br/>";
  echo "</small></p>";
    echo "</card>";
    exit();
  }

    if(istrashed(getuid_sid($sid))||isbanned(getuid_sid($sid)))
    {
        echo "[x]<br/>You Can't Submit Any Tickets. Because you are trashed by <b>Staff Team</b><br/>";
    }
    else
    {
      $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_complains WHERE uid='".getuid_sid($sid)."' AND status='0'"));
      if($noi[0]>0)
      {
        echo "<img src=\"images/notok.gif\" alt=\"x\"/>You have already an unhandled ticket. So, you you cant create any more tickets. Try when the unhandled ticket will be handled.<br/><br/>";
        echo "<a href=\"helpdesk.php?action=main\">Go Back</a><br/>";
      }
      else
      {
        if(isblocked($des,$uid))
	{
	    $ibwf = time()+6*60*60;
            $nick = getnick_uid($uid);
            $res = mysql_query("insert into dcroxx_me_events (event,time) values ('<b>$nick</b> tried to spam in <b>Support Ticket</b>','$ibwf')");
            
        $res = mysql_query("DELETE FROM dcroxx_me_ses WHERE uid='".$uid."'");
        if($res)
        {
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>";
            echo "Can't Create Ticket<br/>You Are Logged Out And Banned for trying to spam here.<br/>";
        }
	}
	else
	{
	if(strlen($des) < 20)
	{
	    echo "[x]<br/>Description is too short<br/>";
            echo "<br/><a href=\"helpdesk.php?action=main\">Go Back</a><br/>";
	}
	else
	{
	    $res = mysql_query("INSERT INTO ibwf_complains SET ccid='".$ccid."', subject='".$crname."', description='".$des."', staff='".$staff."', uid='".$uid."', time='".time()."'");
	    if($res)
	    {
		echo "<img src=\"images/ok.gif\" alt=\"O\"/>Support Ticket Created Successfully<br/><br/>";
                echo "<a href=\"helpdesk.php?action=main\">Go Back</a><br/>";
		////////////////<-----------Notification By Tufan420----------->
		$user = getnick_sid($sid);
		$text = htmlspecialchars(substr(parsepm($crname), 0, 15));
		$uid = getuid_sid($sid);
		mysql_query("INSERT INTO ibwf_notifications SET text='[user=".$uid."]".$user."[/user] created a support ticket, Subject: ".$text."...', byuid='3', touid='".$staff."', unread='1', timesent='".time()."'");

$amount = mysql_fetch_array(mysql_query("SELECT balance, withdraw_balance FROM dcroxx_me_users WHERE id='".getuid_sid($sid)."'"));
$newbl1 = $amount[0]-2;
$newbl0 = $amount[0]+2;
mysql_query("UPDATE dcroxx_me_users SET balance='".$newbl1."', withdraw_balance='".$newbl0."' WHERE id='".getuid_sid($sid)."'");
mysql_query("INSERT INTO dcroxx_me_withdraw_report SET uid='".getuid_sid($sid)."', amount='2', wtime='".time()."', reason='Create a Support Ticket'");

		///////////////<-----------Notification By Tufan420------------->
	    }
	    else
	    {
		echo "Error creating ticket<br/>";
                echo "<br/><a href=\"helpdesk.php?action=main\">Go Back</a><br/>";
	    }
	}
	}
      }
	
    }
    echo "</small></p>";
    echo"<p align=\"center\">";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/><small>Home</small></a>";
  echo "</p>";
    echo "</card>";
}
else if($action=="valltickets")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Help Desk",$pstyle);
  $who = $_GET["who"];
    addonline(getuid_sid($sid),"Support Ticket","helpdesk.php?action=main");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"left\"><small>";
    if(!ismod(getuid_sid($sid)))
    {
	echo "Permission Denied<br/>";
    }
    else
    {
      echo "<a href=\"helpdesk.php?action=valltickets&amp;who=$uid\">Who wants to appoint me?</a><br/><br/>";
	if($page=="" || $page<=0)$page=1;
        if($who==""){
          $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_complains"));
        }else{
          $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_complains WHERE staff='".$who."' AND (status='0' OR status='1')"));
        }
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    
    ////// changable
    if($who==""){
      $sql = "SELECT id, subject, description, ccid, uid, staff, status, handler FROM ibwf_complains ORDER BY id DESC LIMIT $limit_start, $items_per_page";
    }else{
      $sql = "SELECT id, subject, description, ccid, uid, staff, status, handler FROM ibwf_complains WHERE staff='".$who."' AND status='0' ORDER BY id DESC LIMIT $limit_start, $items_per_page";
    }
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
	if($item[6]>0)
	{
	    $status = "Closed";
	    $handler = getnick_uid($item[7]);
	    $hndld = "<br/>Handled By: <b>$handler</b>";
	}
	else
	{
	    $status = "Opened";
	}
	
	$appointed = getnick_uid($item[5]);
	$crtr = getnick_uid($item[4]);
	$lnk = "&#187;Ticket <b>#$item[0]</b><br/>Creator: <b>$crtr</b><br/>Subject: <a href=\"helpdesk.php?action=viewmyticket&amp;tid=$item[0]\">$item[1]</a><br/>Status: <b>$status</b><br/>Appointed Staff: <b>$appointed</b>";
	if(ismod(getuid_sid($sid)))
	{
	    $del = "<a href=\"helpdesk.php?action=remove&amp;tid=$item[0]\">Delete</a>";
	}
	echo "$lnk $hndld<br/>$del";
	if($item[6]<1)
	    {
		echo "/<a href=\"helpdesk.php?action=close&amp;tid=$item[0]\">Close</a>";
	    }
	echo "<br/>----------<br/>";
    }
    }
    //echo "<br/>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"helpdesk.php?action=valltickets&amp;page=$ppage\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"helpdesk.php?action=valltickets&amp;page=$npage\">Next&#187;</a>";
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
else if($action=="vopentickets")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Help Desk",$pstyle);
  $who = $_GET["who"];
    addonline(getuid_sid($sid),"Support Ticket","helpdesk.php?action=main");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"left\"><small>";
    if(!ismod(getuid_sid($sid)))
    {
	echo "Permission Denied<br/>";
    }
    else
    {
    //  echo "<a href=\"helpdesk.php?action=valltickets&amp;who=$uid\">Who wants to appoint me?</a><br/><br/>";
	if($page=="" || $page<=0)$page=1;

          $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_complains WHERE status='0'"));
        
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    
    ////// changable

      $sql = "SELECT id, subject, description, ccid, uid, staff, status, handler FROM ibwf_complains WHERE status='0' ORDER BY id DESC LIMIT $limit_start, $items_per_page";
    
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
	if($item[6]>0)
	{
	    $status = "Closed";
	    $handler = getnick_uid($item[7]);
	    $hndld = "<br/>Handled By: <b>$handler</b>";
	}
	else
	{
	    $status = "Opened";
	}
	
	$appointed = getnick_uid($item[5]);
	$crtr = getnick_uid($item[4]);
	$lnk = "&#187;Ticket <b>#$item[0]</b><br/>Creator: <b>$crtr</b><br/>Subject: <a href=\"helpdesk.php?action=viewmyticket&amp;tid=$item[0]\">$item[1]</a><br/>Status: <b>$status</b><br/>Appointed Staff: <b>$appointed</b>";
	if(ismod(getuid_sid($sid)))
	{
	    $del = "<a href=\"helpdesk.php?action=remove&amp;tid=$item[0]\">Delete</a>";
	}
	echo "$lnk $hndld<br/>$del";
	if($item[6]<1)
	    {
		echo "/<a href=\"helpdesk.php?action=close&amp;tid=$item[0]\">Close</a>";
	    }
	echo "<br/>----------<br/>";
    }
    }
    //echo "<br/>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"helpdesk.php?action=vopentickets&amp;page=$ppage\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"helpdesk.php?action=vopentickets&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"helpdesk.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"vopentickets\"/>";
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
else if($action=="vclosetickets")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Help Desk",$pstyle);
  $who = $_GET["who"];
    addonline(getuid_sid($sid),"Support Ticket","helpdesk.php?action=main");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"left\"><small>";
    if(!ismod(getuid_sid($sid)))
    {
	echo "Permission Denied<br/>";
    }
    else
    {
    //  echo "<a href=\"helpdesk.php?action=valltickets&amp;who=$uid\">Who wants to appoint me?</a><br/><br/>";
	if($page=="" || $page<=0)$page=1;

          $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_complains WHERE status='1'"));
        
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    
    ////// changable

      $sql = "SELECT id, subject, description, ccid, uid, staff, status, handler FROM ibwf_complains WHERE status='1' ORDER BY id DESC LIMIT $limit_start, $items_per_page";
    
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
	if($item[6]>0)
	{
	    $status = "Closed";
	    $handler = getnick_uid($item[7]);
	    $hndld = "<br/>Handled By: <b>$handler</b>";
	}
	else
	{
	    $status = "Opened";
	}
	
	$appointed = getnick_uid($item[5]);
	$crtr = getnick_uid($item[4]);
	$lnk = "&#187;Ticket <b>#$item[0]</b><br/>Creator: <b>$crtr</b><br/>Subject: <a href=\"helpdesk.php?action=viewmyticket&amp;tid=$item[0]\">$item[1]</a><br/>Status: <b>$status</b><br/>Appointed Staff: <b>$appointed</b>";
	if(ismod(getuid_sid($sid)))
	{
	    $del = "<a href=\"helpdesk.php?action=remove&amp;tid=$item[0]\">Delete</a>";
	}
	echo "$lnk $hndld<br/>$del";
	if($item[6]<1)
	    {
		echo "/<a href=\"helpdesk.php?action=close&amp;tid=$item[0]\">Close</a>";
	    }
	echo "<br/>----------<br/>";
    }
    }
    //echo "<br/>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"helpdesk.php?action=vclosetickets&amp;page=$ppage\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"helpdesk.php?action=vclosetickets&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"helpdesk.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"vclosetickets\"/>";
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
else if($action=="vhandledtickets")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Help Desk",$pstyle);
  $who = $_GET["who"];
    addonline(getuid_sid($sid),"Support Ticket","helpdesk.php?action=main");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"left\"><small>";
    if(!ismod(getuid_sid($sid)))
    {
	echo "Permission Denied<br/>";
    }
    else
    {
    //  echo "<a href=\"helpdesk.php?action=valltickets&amp;who=$uid\">Who wants to appoint me?</a><br/><br/>";
	if($page=="" || $page<=0)$page=1;

          $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_complains WHERE handler='".$uid."'"));
        
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    
    ////// changable

      $sql = "SELECT id, subject, description, ccid, uid, staff, status, handler FROM ibwf_complains WHERE handler='".$uid."' ORDER BY id DESC LIMIT $limit_start, $items_per_page";
    
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
	if($item[6]>0)
	{
	    $status = "Closed";
	    $handler = getnick_uid($item[7]);
	    $hndld = "<br/>Handled By: <b>$handler</b>";
	}
	else
	{
	    $status = "Opened";
	}
	
	$appointed = getnick_uid($item[5]);
	$crtr = getnick_uid($item[4]);
	$lnk = "&#187;Ticket <b>#$item[0]</b><br/>Creator: <b>$crtr</b><br/>Subject: <a href=\"helpdesk.php?action=viewmyticket&amp;tid=$item[0]\">$item[1]</a><br/>Status: <b>$status</b><br/>Appointed Staff: <b>$appointed</b>";
	if(ismod(getuid_sid($sid)))
	{
	    $del = "<a href=\"helpdesk.php?action=remove&amp;tid=$item[0]\">Delete</a>";
	}
	echo "$lnk $hndld<br/>$del";
	if($item[6]<1)
	    {
		echo "/<a href=\"helpdesk.php?action=close&amp;tid=$item[0]\">Close</a>";
	    }
	echo "<br/>----------<br/>";
    }
    }
    //echo "<br/>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"helpdesk.php?action=vhandledtickets&amp;page=$ppage\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"helpdesk.php?action=vhandledtickets&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"helpdesk.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"vhandledtickets\"/>";
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
//////////////////// Delete / Remove Tickets [Only For Staffs]
else if($action=="remove")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Help Desk",$pstyle);
    $tid = $_GET["tid"];
    addonline(getuid_sid($sid),"Deleting Support Ticket","helpdesk.php?action=main");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"center\"><small>";
    if(ismod(getuid_sid($sid)))
    {
	$res = mysql_query("DELETE FROM ibwf_complains WHERE id='".$tid."'");
	if($res)
	{
	    echo "<img src=\"images/ok.gif\" alt=\"\"/>Ticket Deleted<br/>";
	}
	else
	{
	    echo "<img src=\"images/notok.gif\" alt=\"\"/>Database Error<br/>";
	}
    }
    else
    {
	echo "Permission Denied<br/>";
    }
    echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
    echo "</small></p></card>";
}
///////////////////////// Close Ticket
else if($action=="close")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Help Desk",$pstyle);
    $tid = $_GET["tid"];
    addonline(getuid_sid($sid),"Handling Support Ticket","helpdesk.php?action=$action");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"center\"><small>";
    if(ismod(getuid_sid($sid)))
    {
	$res = mysql_query("UPDATE ibwf_complains SET status='1', handler='".getuid_sid($sid)."' WHERE id='".$tid."'");
	if($res)
	{
	    echo "<img src=\"images/ok.gif\" alt=\"\"/>Ticket Closed/Handled<br/>";
	}
	else
	{
	    echo "<img src=\"images/notok.gif\" alt=\"\"/>Database Error<br/>";
	}
    }
    else
    {
	echo "Permission Denied<br/>";
    }
    echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
    echo "</small></p></card>";
}
/////////////// View A Ticket
else if($action=="viewmyticket")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Help Desk",$pstyle);
    $tid = $_GET["tid"];
    $page = $_GET["page"];
  addonline(getuid_sid($sid),"Viewing A Support Ticket","helpdesk.php?action=$action");
  echo "<card id=\"main\" title=\"$sitename\">";
  echo "<p align=\"left\">";
  $det = mysql_fetch_array(mysql_query("SELECT id, subject, description, ccid, uid, staff, status, handler, time FROM ibwf_complains WHERE id='".$tid."'"));
 // echo "Ticket <b>#$det[0]</b><br/><br/>";
  $creator = getnick_uid($det[4]);
  echo "Submitted By: <a href=\"index.php?action=viewuser&amp;who=$det[4]\">$creator</a><br/>";
    if(ismod(getuid_sid($sid))){
  echo "<a href=\"index.php?action=viewuser&amp;who=$det[4]\">All Tickets Submitted by $creator</a><br/><br/>";
  }
  $appointed = getnick_uid($det[5]);
  echo "Appointed Staff: <b>$appointed</b>";
  if(ismod(getuid_sid($sid))){
	echo"<form method=\"post\" action=\"?action=domoving\">";
  echo "Forward To Another Staff: ";
  $fcats = mysql_query("SELECT id, name FROM dcroxx_me_users WHERE perm>'0' ORDER BY lastact DESC");
  echo "<select name=\"staff\" style=\"height:24px;width: 150px;\">";
  while ($fcat=mysql_fetch_array($fcats))
  {
  echo "<option value=\"$fcat[0]\">$fcat[1]</option>";
  }
  echo "</select>";
  echo "<input type=\"hidden\" name=\"tid\" value=\"$det[0]\"/>";
  echo "<input type=\"submit\" name=\"Submit\" value=\"Forward This Ticket\"/>
</form>";
	
  }
  echo "<br/>";
  echo "Catagory: <b>$det[3]</b><br/>";
  echo "Subject: <b>$det[1]</b><br/>";
  
  echo "Last Update: <b>".date("dS F y - h:i:s A", $det[8])."</b><br/>";
  if($det[6]>0)
	{
	    $status = "Closed";
	    $handler = getnick_uid($det[7]);
	    $hndld = "<br/>Handled By: <b>$handler</b>";
	}
	else
	{
	    $status = "Opened";
	}
  echo "Status: <b>$status</b> $hndld<br/>";
  echo "Description Of The Problem: $det[2]<br/><br/>";
  if($det[6]>0)
  {
    echo "<b>This ticket is closed</b>";
  }
  else
  {
    if(ismod(getuid_sid($sid)) || $det[4]==getuid_sid($sid))
    {
	
	echo"Post a followup...</small>
<form method=\"post\" action=\"?action=reply\">
<textarea name=\"reply\" style=\"height:50px;width: 270px;\" ></textarea><br/>
<input type=\"hidden\" name=\"tid\" value=\"$det[0]\"/>
<input type=\"submit\" name=\"Submit\" value=\"Post!\"/><br/>
</form><small>";
	
	
/*	echo "Post a followup...</small><br/>";
	echo "<input name=\"reply\" maxlength=\"700\"/> ";
	echo "<anchor>Post!";
	echo "<go href=\"helpdesk.php?action=reply\" method=\"post\">";
	echo "<postfield name=\"reply\" value=\"$(reply)\"/>";
	echo "<postfield name=\"tid\" value=\"$det[0]\"/>";
	echo "</go></anchor><small>";*/
	
	
	
    }
  }
  echo "<br/><br/>";
  echo "<b>Replies:</b><br/><br/>";
  /////////////////////////<---------Script Start---------->/////////////////////
  
  //////ALL LISTS SCRIPT <<
    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_tktcomm WHERE tid='".$tid."'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    
        $sql = "SELECT id, byuid, reply, time FROM ibwf_tktcomm WHERE tid='".$tid."' ORDER BY time DESC LIMIT $limit_start, $items_per_page";

    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {

    $snick = getnick_uid($item[1]);
      $lnk = "<b>$snick:</b>";
      $bs = date("dS F y - h:i:s a",$item[3]+(6*60*60));
      echo "$lnk<br/>";
      $text = parsepm($item[2], $sid);
      echo "$text<br/>Date: $bs<br/>";
      echo "----------<br/>";

    }
    }
    echo "</small></p>";
    echo "<p align=\"center\"><small>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"helpdesk.php?action=$action&amp;page=$ppage&amp;tid=$tid\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"helpdesk.php?action=$action&amp;page=$npage&amp;tid=$tid\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"helpdesk.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"tid\" value=\"$tid\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
  
  ////////////////////////<----------Script Ending---------->/////////////////////
  
if(ismod(getuid_sid($sid))){
if($det[6]<1){
echo "<a href=\"helpdesk.php?action=close&amp;tid=$det[0]\">Close Ticket</a><br/><br/>";
}
echo "<a href=\"helpdesk.php?action=remove&amp;tid=$det[0]\">Delete Ticket</a>";
}

  
  echo "</small></p>";
  echo"<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/><small>Home</small></a>";
  echo "</p>";
  echo "</card>";
}
////////////////// ad comments in a ticket
else if($action=="reply")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Help Desk",$pstyle);
    $tid = $_POST["tid"];
    $reply = $_POST["reply"];
    addonline(getuid_sid($sid),"Ticket followup","");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"center\"><small>";
    if(istrashed(getuid_sid($sid)))
    {
	echo "You can not add reply in ticket. You are trashed by <b>Staff Team</b><br/>";
    }
    else
    {
      if(strlen($reply) < 10)
      {
        echo "<img src=\"images/notok.gif\" alt=\"\"/><br/>Followup text is too short. Your followup should contain at least 10 characters.<br/>";
      }
      else
      {
        $res = mysql_query("INSERT INTO ibwf_tktcomm SET reply='".$reply."', byuid='".getuid_sid($sid)."', tid='".$tid."', time='".time()."'");
	if($res)
	{
	    echo "<img src=\"images/ok.gif\" alt=\"\"/>Followup posted successfully<br/><br/>";
            echo "<a href=\"helpdesk.php?action=main\">Go Back</a><br/>";
	    $user = getnick_sid($sid);
	    $det = mysql_fetch_array(mysql_query("SELECT uid, subject, staff FROM ibwf_complains WHERE id='".$tid."'"));
	    $text = htmlspecialchars(substr(parsepm($reply), 0, 20));
	    $uid = getuid_sid($sid);
	    if($det[0]!==$uid)
	    {
		//mysql_query("INSERT INTO ibwf_notifications SET text='[user=".$uid."]".$user."[/user] replied on your ticket - Text:- [ticket=".$tid."]".$text."...[/ticket]', byuid='436', touid='".$det[0]."', unread='1', timesent='".time()."'");
                mysql_query("INSERT INTO dcroxx_me_private SET text='[b]NOTIFICATION:[/b][br/][b]".$user."[/b] has replied to the Ticket [ticket=".$tid."]".$det[1]."[/ticket][br/][i]p.s: this is an automated pm[/i]', byuid='3', touid='".$det[0]."', timesent='".time()."'");
	    }
            else
            {
              mysql_query("INSERT INTO dcroxx_me_private SET text='[b]NOTIFICATION:[/b][br/][b]".$user."[/b] has replied to the Ticket [ticket=".$tid."]".$det[1]."[/ticket][br/][i]p.s: this is an automated pm[/i]', byuid='3', touid='".$det[2]."', timesent='".time()."'");
            }
	}
	else
	{
	    echo "<img src=\"images/notok.gif\" alt=\"\"/>Database Error<br/>";
	}
      }
    }
    echo "</small></p>";
    echo"<p align=\"center\">";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/><small>Home</small></a>";
    echo "</p>";
    echo "</card>";
}
//////////////// move ticket
else if($action=="moveticket")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Help Desk",$pstyle);
  addonline(getuid_sid($sid),"ModCP","");
  $tid = $_GET["tid"];
  if(!ismod(getuid_sid($sid)))
  {
  echo "<card id=\"main\" title=\"$sitename\">";
  echo "<p align=\"center\"><small>";
  echo "Permission denied.<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
  echo "</wml>";
  exit();
  }
  echo "<card id=\"main\" title=\"$sitename\">";
  echo "<p><small>";
  
  

  
  
  echo "</small></p>";
  echo "<p align=\"center\"><small>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
else if($action=="domoving")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Help Desk",$pstyle);
  addonline(getuid_sid($sid),"ModCP","");
  $tid = $_POST["tid"];
  $staff = $_POST["staff"];
  if(!ismod(getuid_sid($sid)))
  {
  echo "<card id=\"main\" title=\"$sitename\">";
  echo "<p align=\"center\"><small>";
  echo "Permission denied.<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
  echo "</wml>";
  exit();
  }
  $det = mysql_fetch_array(mysql_query("SELECT subject, status FROM ibwf_complains WHERE id='".$tid."'"));
  echo "<card id=\"main\" title=\"$sitename\">";
  echo "<p align=\"center\"><small>";
  if($det[1]>0)
  {
    echo "<img src=\"images/notok.gif\" alt=\"x\"/>This ticket is closed and handled by other staff. So you cant move it.<br/>";
    echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
    echo "</small></p></card>";
    echo "</wml>";
    exit();
  }
  $res = mysql_query("UPDATE ibwf_complains SET staff='".$staff."' WHERE id='".$rid."'");
  if($res)
  {
    mysql_query("INSERT INTO dcroxx_me_private SET text='[b]NOTIFICATION:[/b][br/][b]".getnick_uid(getuid_sid($sid))."[/b] moved a Ticket to you - # [b]".$tid." - ".$det[0]."[/b].[br/][i]p.s: this is an automated pm[/i]', byuid='436', touid='".$staff."', timesent='".time()."'");
    echo "<img src=\"images/ok.gif\" alt=\"o\"/>Moved Successfully<br/>";
  }else{
    echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database error<br/>";
  }
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
else
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Help Desk",$pstyle);
  addonline(getuid_sid($sid),"Lost","");
  echo "<card id=\"main\" title=\"$sitename\">";
  echo "<p align=\"center\"><small>";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
?>
</html>
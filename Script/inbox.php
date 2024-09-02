<?php
    session_name("PHPSESSID");
session_start();
include("xhtmlfunctions.php");
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
?>
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
<?php
include("config.php");
include("core.php");
connectdb();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$page = $_GET["page"];
$who = $_GET["who"];
$pmid = $_GET["pmid"];
if(islogged($sid)==false)
{
      $pstyle = gettheme1("1");
      echo xhtmlhead("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
  echo xhtmlfoot();
      exit();
    }
$uid = getuid_sid($sid);
if(isbanned($uid))
    {
      $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
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

if($action=="sendpm")
{
 $whonick = getnick_uid($who);
 addonline(getuid_sid($sid),"Sending PM to $whonick","");
  $pstyle = gettheme($sid);
  echo xhtmlhead("Inbox",$pstyle);
  echo "<p align=\"center\">";
  $whonick = getnick_uid($who);
  echo "Send PM to $whonick<br/><br/>";
echo "<form action=\"inbxproc.php?action=sendpm&amp;who=$who\" method=\"post\">";
  echo "<input name=\"pmtext\" maxlength=\"500\"/><br/>";
echo "<input type=\"submit\" value=\"SEND\"/>";
echo "</form>";
echo "<br/>";
      $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
exit();
}
else if($action=="sendto")
{
  addonline(getuid_sid($sid),"Sending PM","");

  echo "<p align=\"center\">";
  $whonick = getnick_uid($who);
  echo "Send PM to:<br/><br/>";
echo "<form action=\"inbxproc.php?action=sendto\" method=\"post\">";
  echo "User: <input name=\"who\" format=\"*x\" maxlength=\"15\"/><br/>";
  echo "Text: <input name=\"pmtext\" maxlength=\"500\"/><br/>";

echo "<input type=\"submit\" value=\"SEND\"/>";
echo "</form>";

  echo "<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
   exit();

}
else if($action=="sendpopup")
{
  $mmsg = htmlspecialchars(getsetmood(getuid_sid($sid)));
  addonline(getuid_sid($sid),"Sending Popup ($mmsg)","lists.php?action=buds");
      echo "<head>";
      echo "<title>Send Popup</title>";
      echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
      echo "</head>";
      echo "<body>";
  echo "<p align=\"center\">";
  if (!arebuds($uid, $who))
 {
    echo "$whonick is not in ur buddy list<br/><br/>";
    echo "<a accesskey=\"9\" href=\"lists.php?action=buds\">BuddyList</a><br/>";
    echo "<a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
    echo "</p></body></html>";
    exit;
  }else{
  $whonick = getnick_uid($who);
  echo "Send Popup to $whonick<br/><br/>";
  echo "<form action=\"inbxproc.php?action=sendpopup&amp;who=$who\" method=\"post\">";
  echo "<input name=\"pmtext\" maxlength=\"1000\"/><br/>";
  echo "<input type=\"Submit\" name=\"send\" value=\"Send\"></form>";
  echo "<a accesskey=\"6\" href=\"inbox.php?action=main\">Inbox</a><br/>";
  echo "<a accesskey=\"7\" href=\"lists.php?action=buds\">BuddyList</a><br/>";
  echo "<a accesskey=\"8\" href=\"index.php?action=chat\">Chat</a><br/>";
   echo "<a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
    echo "</body>";
exit();
}
}
else if($action=="renamefolder")
{
  addonline(getuid_sid($sid),"Renaming PM Folder","");
    $pstyle = gettheme($sid);
  echo xhtmlhead("Renaming PM Folder",$pstyle);

  echo "<p align=\"center\">";
  $folderid = $_GET["fid"];
  $foldername = mysql_fetch_array(mysql_query("SELECT foldername FROM dcroxx_me_private_folders WHERE folderid='".$folderid."'"));
  echo "Renaming Folder: $foldername[0]<br/><br/>";
echo "<form action=\"inbox.php?action=rnamefdone\" method=\"post\">";
  echo "New Folder Name: <input name=\"newname\" format=\"*x\" maxlength=\"25\"/><br/>";
  echo "<input type=\"hidden\" name=\"fid\" value=\"$folderid\"/>";
echo "<input type=\"submit\" value=\"Rename\"/>";
echo "</form>";

  echo "<br/><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"inbox.php?action=main\">&#171;Back to Inbox</a><br/>";
 echo "<a href=\"index.php?action=chat\">&#171;Back to Chat</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";

  echo xhtmlfoot();
exit();

}
else if($action=="rnamefdone")
{
  addonline(getuid_sid($sid),"Renaming PM Folder","");
    $pstyle = gettheme($sid);
  echo xhtmlhead("Renaming PM Folder",$pstyle);
  $folderid = $_POST["fid"];
  $newname = $_POST["newname"];

  echo "<p align=\"center\">";

 $res = mysql_query("UPDATE dcroxx_me_private_folders SET foldername='".$newname."' WHERE folderid='".$folderid."'");

         if($res)
        {
          echo "<img src=\"images/ok.gif\" alt=\"O\"/>Folder Renamed Successfully<br/><br/>";
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"O\"/>Rename Error!<br/><br/>";
        }

  echo "<br/><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"inbox.php?action=main\">&#171;Back to Inbox</a><br/>";
 echo "<a href=\"index.php?action=chat\">Back to Chat</a><br/>";

    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";

  echo xhtmlfoot();
exit();

}
else if($action=="delfolder")
{
  addonline(getuid_sid($sid),"Deleting PM Folder","");
    $pstyle = gettheme($sid);
  echo xhtmlhead("Deleting PM Folder",$pstyle);

  echo "<p align=\"center\">";

 $folderid = $_POST["fid"];
 $res = mysql_query("DELETE FROM dcroxx_me_private_folders WHERE folderid='".$folderid."'");


    $sql = "SELECT folderid FROM dcroxx_me_private WHERE folderid='".$folderid."'";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
     while ($item = mysql_fetch_array($items))
       {
             $sql = mysql_query("UPDATE dcroxx_me_private SET folderid='0' WHERE folderid='".$folderid."'");
       }
    }

         if($res)
        {
          echo "<img src=\"images/ok.gif\" alt=\"O\"/>Folder Deleted Successfully<br/><br/>";
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"O\"/>Delete Error!<br/><br/>";
        }

  echo "<br/><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"inbox.php?action=main\">&#171;Back to Inbox</a><br/>";
 echo "<a href=\"index.php?action=chat\">Back to Chat</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";

  echo xhtmlfoot();
exit();

}

else if($action=="main")
{
  addonline(getuid_sid($sid),"User Inbox","");
    $pstyle = gettheme($sid);
    echo xhtmlhead("Inbox",$pstyle);
    echo "<p align=\"center\">";
    echo "Inbox";
    echo "</p>";

    echo "<div class=\"mblock1\">";
    echo "<small>";
    $uid = getuid_sid($sid);

    $umsg = getunreadpm(getuid_sid($sid));
    $tmsg = getpmcount(getuid_sid($sid));
    $read = $tmsg - $umsg;
    $readpmnotinfolder = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$uid."' AND unread='0' AND folderid='0'"));
    echo "<img src=\"images/npm.gif\" alt=\"*\"/><a href=\"inbox.php?action=folderunread\">New</a>($umsg)<br/>";
    echo "<img src=\"images/opm.gif\" alt=\"*\"/><a href=\"inbox.php?action=folderread\">Old</a>($readpmnotinfolder[0])<br/><br/>";

    $sql = "SELECT foldername, folderid FROM dcroxx_me_private_folders WHERE uid='".$uid."' ORDER BY foldername DESC";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$uid."' AND folderid='".$item[1]."'"));
      $lnk = "<img src=\"images/1.gif\" alt=\"*\"/><a href=\"inbox.php?action=folder&amp;folderid=$item[1]\">$item[0]</a>($noi[0])";
      echo "$lnk<br/>";
    }
    }

    echo "<br/>";
  echo "<center><a href=\"inbox.php?action=sendmms\">*Pm+Attachement*</a></center>";
    echo "<center><a href=\"inbox.php?action=crfolder\">*Create New Folder*</a></center>";
    echo "<center><a href=\"inbox.php?action=sendto\">*Send PM*</a></center>";
    echo "</small>";
    echo "</div>";
  ////// UNTILL HERE >>



  echo "<p align=\"center\">";

    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
exit();
}

else if($action=="folderread")
{
 $pstyle = gettheme($sid);
  echo xhtmlhead("Inbox - Read",$pstyle);
  echo "<p align=\"center\">";
echo "<form action=\"inbox.php\" method=\"get\">";
    echo "View: <select name=\"view\">";
  echo "<option value=\"all\">All</option>";
  echo "<option value=\"snt\">Sent</option>";
  echo "<option value=\"str\">Starred</option>";
  echo "<option value=\"urd\">Unread</option>";
  echo "</select>";
echo "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
echo "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
echo "<input type=\"submit\" value=\"GO\"/>";
echo "</form>";
      echo "</p>";
    $view = $_GET["view"];
    //////ALL LISTS SCRIPT <<
    if($view=="")$view="all";
    if($page=="" || $page<=0)$page=1;
    $myid = getuid_sid($sid);
    $doit=false;
    $num_items = getpmcount($myid,$view); //changable
    $items_per_page= 7;
    $num_pages = ceil($num_items/$items_per_page);
    if($page>$num_pages)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    if($num_items>0)
    {
      if($doit)
      {
        $exp = "&amp;rwho=$myid";
      }else
      {
        $exp = "";
      }
    //changable sql
    if($view=="all")
  {
    $sql = "SELECT
            a.name, b.id, b.byuid, b.unread, b.starred FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.byuid
            WHERE b.touid='".$myid."'
            ORDER BY b.timesent DESC
            LIMIT $limit_start, $items_per_page
    ";
  }else if($view=="snt")
  {
    $sql = "SELECT
            a.name, b.id, b.touid, b.unread, b.starred FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.touid
            WHERE b.byuid='".$myid."'
            ORDER BY b.timesent DESC
            LIMIT $limit_start, $items_per_page
    ";
  }else if($view=="str")
  {
    $sql = "SELECT
            a.name, b.id, b.byuid, b.unread, b.starred FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.byuid
            WHERE b.touid='".$myid."' AND b.starred='1'
            ORDER BY b.timesent DESC
            LIMIT $limit_start, $items_per_page
    ";
  }else if($view=="urd")
  {
    $sql = "SELECT
            a.name, b.id, b.byuid, b.unread, b.starred FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.byuid
            WHERE b.touid='".$myid."' AND b.unread='1'
            ORDER BY b.timesent DESC
            LIMIT $limit_start, $items_per_page
    ";
  }
    
    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    while ($item = mysql_fetch_array($items))
    {
      if($item[3]=="1")
      {
        $iml = "<img src=\"/images/npm.gif\" alt=\"+\"/>";
      }else{
        if($item[4]=="1")
        {
            $iml = "<img src=\"/images/spm.gif\" alt=\"*\"/>";
        }else{

        $iml = "<img src=\"/images/opm.gif\" alt=\"-\"/>";
        }
      }
      
      $lnk = "<a href=\"inbox.php?action=readpm&amp;pmid=$item[1]\">$iml $item[0]</a>";
      echo "$lnk<br/>";
    }
    echo "</small></p>";
    echo "<p align=\"center\">";
    
      $npage = $page+1;
      echo "<a href=\"inbox.php?action=sendto\">Send to</a><br/>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"inbox.php?action=folderread&amp;page=$ppage&amp;view=$view$exp\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"inbox.php?action=folderread&amp;page=$npage&amp;view=$view$exp\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
$rets = "<form action=\"inbox.php\" method=\"get\">";
      $rets .= "Jump to page: <input name=\"page\" format=\"*N\" size=\"3\"/>";
$rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
         
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
$rets .= "</form>";
        echo $rets;
      echo "<br/>";
    }
    echo "<br/>";
echo "<form action=\"inbxproc.php?action=proall\" method=\"post\">";
      echo "Delete: <select name=\"pmact\">";
  echo "<option value=\"ust\">Unstarred</option>";
  echo "<option value=\"red\">Read</option>";
  echo "<option value=\"all\">All</option>";
  echo "</select>";
echo "<input type=\"submit\" value=\"GO\"/>";
echo "</form>";

    echo "</p>";
    }else{
      echo "<p align=\"center\">";
      echo "You have no Private Messages";
      echo "</p>";
    }
  ////// UNTILL HERE >>

    
    
  echo "<p align=\"center\">";
  echo "<a href=\"inbox.php?action=sendto\">Send to</a><br/>";
  
   echo "<p align=\"center\">";

    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"inbox.php?action=main\">&#171;Back to Inbox</a><br/>";
 echo "<a href=\"index.php?action=chat\">Back to Chat</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
exit();
  }


  else if($action=="folderunread")
{
  addonline(getuid_sid($sid),"User Inbox","");
    $pstyle = gettheme($sid);
  echo xhtmlhead("Inbox - Unread",$pstyle);
    echo "<p align=\"center\">";
    echo "Unread Mail";
    echo "</p>";
    $view = $_GET["view"];
    //////ALL LISTS SCRIPT <<
    if($view=="")$view="all";
    if($page=="" || $page<=0)$page=1;
    $myid = getuid_sid($sid);
    $doit=false;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$uid."' AND unread='1'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 7;
    $num_pages = ceil($num_items/$items_per_page);
    if($page>$num_pages)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    if($num_items>0)
    {
      if($doit)
      {
        $exp = "&amp;rwho=$myid";
      }else
      {
        $exp = "";
      }
    //changable sql

    $sql = "SELECT
            a.name, b.id, b.byuid, b.unread, b.starred FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.byuid
            WHERE b.touid='".$myid."' AND b.unread='1'
            ORDER BY b.timesent DESC
            LIMIT $limit_start, $items_per_page
    ";
    echo "<div class=\"mblock1\">";
    echo "<small>";
    $items = mysql_query($sql);
    echo mysql_error();
    while ($item = mysql_fetch_array($items))
    {
      if($item[3]=="1")
      {
        $iml = "<img src=\"images/npm.gif\" alt=\"+\"/>";
      }else{
        if($item[4]=="1")
        {
            $iml = "<img src=\"images/spm.gif\" alt=\"*\"/>";
        }else{

        $iml = "<img src=\"images/opm.gif\" alt=\"-\"/>";
        }
      }

      $lnk = "<a href=\"inbox.php?action=readpm&amp;pmid=$item[1]\">$iml $item[0]</a>";
      echo "$lnk<br/>";
    }
    echo "</small>";
    echo "</div>";
    echo "<p align=\"center\">";

      $npage = $page+1;
      echo "<a href=\"inbox.php?action=sendto\">Send to</a><br/>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"inbox.php?action=folderunread&amp;page=$ppage&amp;view=$view$exp\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"inbox.php?action=folderunread&amp;page=$npage&amp;view=$view$exp\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
	    $rets = "<form action=\"inbox.php\" method=\"get\">";
        $rets .= "Jump to page: <input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
	    $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
        $rets .= "</form>";
        echo $rets;
    }
    echo "<br/>";

     echo "</p>";
    }else{
      echo "<p align=\"center\">";
      echo "You have no Private Messages<br/>";
      echo "<a href=\"inbox.php?action=sendto\">Send PM</a><br/>";
      echo "</p>";
    }
  ////// UNTILL HERE >>



  echo "<p align=\"center\">";

    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"inbox.php?action=main\">&#171;Back to Inbox</a><br/>";
 echo "<a href=\"index.php?action=chat\">Back to Chat</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
exit();
  }


  else if($action=="folder")
{
  addonline(getuid_sid($sid),"User Inbox","");
    $pstyle = gettheme($sid);
  echo xhtmlhead("Inbox",$pstyle);
  $folderid = $_GET["folderid"];
  $foldername = mysql_fetch_array(mysql_query("SELECT foldername FROM dcroxx_me_private_folders WHERE folderid='".$folderid."'"));
    echo "<p align=\"center\">";
    echo "Folder $foldername[0]";
    echo "</p>";
    //////ALL LISTS SCRIPT <<
    if($view=="")$view="all";
    if($page=="" || $page<=0)$page=1;
    $myid = getuid_sid($sid);
    $doit=false;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$uid."' AND folderid='".$folderid."'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if($page>$num_pages)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    if($num_items>0)
    {
      if($doit)
      {
        $exp = "&amp;rwho=$myid";
      }else
      {
        $exp = "";
      }
    //changable sql

    $sql = "SELECT
            a.name, b.id, b.byuid, b.unread, b.starred, folderid FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.byuid
            WHERE b.touid='".$myid."' AND folderid='".$folderid."'
            ORDER BY b.timesent DESC
            LIMIT $limit_start, $items_per_page
    ";
    echo "<div class=\"mblock1\">";
    echo "<small>";
    $items = mysql_query($sql);
    echo mysql_error();
    while ($item = mysql_fetch_array($items))
    {
      if($item[3]=="1")
      {
        $iml = "<img src=\"images/npm.gif\" alt=\"+\"/>";
      }else{
        if($item[4]=="1")
        {
            $iml = "<img src=\"images/spm.gif\" alt=\"*\"/>";
        }else{

        $iml = "<img src=\"images/opm.gif\" alt=\"-\"/>";
        }
      }

      $lnk = "<a href=\"inbox.php?action=readpm&amp;pmid=$item[1]\">$iml $item[0]</a>";
      echo "$lnk<br/>";
    }
    echo "<br/>";
    echo "</small>";
    echo "<center><small><a href=\"inbox.php?action=delfolder&amp;fid=$folderid\">Delete Folder</a></small></center>";
    echo "<center><small><a href=\"inbox.php?action=renamefolder&amp;fid=$folderid\">Rename Folder</a></small></center>";
    echo "</div>";
    echo "<p align=\"center\">";

      $npage = $page+1;
      echo "<a href=\"inbox.php?action=sendto\">Send to</a><br/>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"inbox.php?action=main&amp;page=$ppage&amp;view=$view$exp\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"inbox.php?action=main&amp;page=$npage&amp;view=$view$exp\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
$rets = "<form action=\"inbox.php\" method=\"get\">";
      $rets .= "Jump to page: <input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
$rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
$rets .= "</form>";
        echo $rets;
    }
    echo "<br/>";
    echo "</p>";
    }else{
      echo "<p align=\"center\">";
      echo "You have no Private Messages<br/>";
      echo "<a href=\"inbox.php?action=sendto\">Send PM</a><br/>";
      echo "</p>";
    }
  ////// UNTILL HERE >>



  echo "<p align=\"center\">";

    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"inbox.php?action=main\">&#171;Back to Inbox</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
exit();
  }

    else if($action=="readpm")
{
$pminfo = mysql_fetch_array(mysql_query("SELECT byuid FROM dcroxx_me_private
WHERE id='".$pmid."'"));
 addonline(getuid_sid($sid),"Reading PM from
".getnick_uid($pminfo[0])."","");
      $pstyle = gettheme($sid);
  echo xhtmlhead("Read PM",$pstyle);
  echo "<p>";

  $pminfo = mysql_fetch_array(mysql_query("SELECT text, byuid, timesent, touid, reported FROM dcroxx_me_private WHERE id='".$pmid."'"));
  if(getuid_sid($sid)==$pminfo[3])
  {
    $chread = mysql_query("UPDATE dcroxx_me_private SET unread='0' WHERE id='".$pmid."'");
  }

  if(($pminfo[3]==getuid_sid($sid))||($pminfo[1]==getuid_sid($sid)))
  {

  if(getuid_sid($sid)==$pminfo[3])
  {
    if(isonline($pminfo[1]))
  {
    $iml = "<img src=\"images/onl.gif\" alt=\"+\"/>";
  }else{
    $iml = "<img src=\"images/ofl.gif\" alt=\"-\"/>";
  }
    $ptxt = "PM By: ";

        $bylnk = "<a href=\"index.php?action=viewuser&amp;who=$pminfo[1]\">$iml".getnick_uid($pminfo[1])."</a>";

  }else{
    if(isonline($pminfo[3]))
  {
    $iml = "<img src=\"images/onl.gif\" alt=\"+\"/>";
  }else{
    $iml = "<img src=\"images/ofl.gif\" alt=\"-\"/>";
  }
    $ptxt = "PM To: ";

    $bylnk = "<a href=\"index.php?action=viewuser&amp;who=$pminfo[3]\">$iml".getnick_uid($pminfo[3])."</a>";

  }

  echo "$ptxt $bylnk<br/>";
  $tmstamp = $pminfo[2];
  $tremain = time()-$tmstamp;
  //$tmdt = date("d m Y - H:i:s", $tmstamp);
  $tmdt = gettimemsg($tremain)." ago"; ////////////////////this is the time thing
  echo "<i>$tmdt</i><br/><br/>";
  $pmtext = parsepm($pminfo[0], $sid);
  

  
    $pmtext = str_replace("/faq","<a href=\"lists.php?action=faqs\">Users Questions</a>", $pmtext);
/*$pmtext = str_replace("/help","<a href=\"help.php?sid=$sid\">Our help menu</a>", $pmtext);
$pmtext = str_replace("/credits","<a href=\"index.php?action=viewtpc&amp;tid=2040\">How to Earn Much Credits??</a>", $pmtext);
$pmtext = str_replace("/features","<a href=\"index.php?action=viewfrm&amp;fid=189\">New Features!</a>", $pmtext);*/
    $pmtext = str_replace("/reader",getnick_uid($pminfo[3]), $pmtext);
 /*   if(isspam($pmtext))
    {
      if(($pminfo[4]=="0") && ($pminfo[1]!=1))
      {
        mysql_query("UPDATE dcroxx_me_private SET reported='1' WHERE id='".$pmid."'");
      }
    }*/
    echo $pmtext;
	 	echo "<br/>";
		
    $lastpmcount = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE byuid='".$pminfo[3]."' AND touid='".$pminfo[1]."'"));
    if($lastpmcount[0]>0){
    $lastpmtxt = mysql_fetch_array(mysql_query("SELECT byuid, text, timesent FROM dcroxx_me_private WHERE byuid='".$pminfo[3]."' AND touid='".$pminfo[1]."' ORDER BY timesent DESC LIMIT 0,1"));
     $lasttxt = parsepm($lastpmtxt[1], $sid);
      echo "<br/><b>".getnick_uid($lastpmtxt[0])."</b>: ";
      echo "$lasttxt<br/>";
    }
		
		
   $pminfo = mysql_fetch_array(mysql_query("SELECT text, byuid, touid, reported FROM dcroxx_me_private WHERE id='".$pmid."'"));
	echo "<form action=\"inbxproc.php?action=sendpm&amp;who=$pminfo[1]\" method=\"post\">";
  echo "<textarea name=\"pmtext\" style=\"height:30px;width: 270px;\" ></textarea><br/>";
  echo "<input type=\"submit\" value=\"Fast Reply &#187;\"/>";
echo "</form>";

echo"
<small><b><a href=\"lists.php?action=smilies\">Smilies</a> || <a href=\"lists.php?action=bbcode\">BBCodes</a></b></small><br/>
<div class=\"mblock1\">
<small>	
<b>Simple Emotions:</b><br/>
:)	<img src=\"emoticons/1 (10).png\" height=\"16\" width=\"16\" />
:D	<img src=\"emoticons/1 (2).png\" height=\"16\" width=\"16\" />
:(	<img src=\"emoticons/1 (9).png\" height=\"16\" width=\"16\" />
:-(	<img src=\"emoticons/1 (8).png\" height=\"16\" width=\"16\" />
:P	<img src=\"emoticons/1 (11).png\" height=\"16\" width=\"16\" />
:O)	<img src=\"emoticons/1.png\" height=\"16\" width=\"16\" />
:3)	<img src=\"emoticons/1 (5).png\" height=\"16\" width=\"16\" />
o.O	<img src=\"emoticons/1 (3).png\" height=\"16\" width=\"16\" />
;)	<img src=\"emoticons/1 (27).png\" height=\"16\" width=\"16\" />
:O	<img src=\"emoticons/1 (24).png\" height=\"16\" width=\"16\" />
-_-	<img src=\"emoticons/1 (22).png\" height=\"16\" width=\"16\" />
:-O	<img src=\"emoticons/1 (1).png\" height=\"16\" width=\"16\" />
:*	<img src=\"emoticons/1 (16).png\" height=\"16\" width=\"16\" /> <br/>
:_:	<img src=\"emoticons/1 (15).png\" height=\"16\" width=\"16\" />
8-)	<img src=\"emoticons/1 (12).png\" height=\"16\" width=\"16\" />
8|	<img src=\"emoticons/1 (23).png\" height=\"16\" width=\"16\" />
(^^^) <img src=\"emoticons/1 (21).png\" height=\"16\" width=\"16\" />
:_(	<img src=\"emoticons/1 (13).png\" height=\"16\" width=\"16\" />
:v	<img src=\"emoticons/1 (17).png\" height=\"16\" width=\"16\" />
:/	<img src=\"emoticons/1 (26).png\" height=\"16\" width=\"16\" />
:3	<img src=\"emoticons/1 (4).png\" height=\"16\" width=\"16\" />
:poop: <img src=\"emoticons/1 (18).png\" height=\"16\" width=\"16\" />
:smoke: <img src=\"emoticons/cigarette.png\" height=\"16\" width=\"16\" />
:ring: <img src=\"emoticons/ring.png\" height=\"16\" width=\"16\" />
</small><br/></div>
";



  echo "</p>";
  echo "<p align=\"center\"><br/><br/>";

   if($page=="" || $page<=0)$page=1;
    $myid = getuid_sid($sid);
    $doit=false;
    $num_items = getpmcount($myid); //changable
    $items_per_page= 1
;
    $num_pages = ceil($num_items/$items_per_page);
    if($page>$num_pages)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;


$sql = "SELECT
            a.name, b.id, b.byuid, b.unread, b.starred FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.byuid
            WHERE b.touid='".$myid."' AND b.unread='1'
            ORDER BY b.timesent
            LIMIT $limit_start, $items_per_page
    ";

     $items = mysql_query($sql);


    echo mysql_error();
    while ($item = mysql_fetch_array($items))
    {
      if($item[3]=="1")
      {
        $iml = "<img src=\"images/npm.gif\" alt=\"+\"/>";
      }else{
        if($item[4]=="1")
        {
            $iml = "<img src=\"images/spm.gif\" alt=\"*\"/>";
        }else{

        $iml = "<img src=\"images/opm.gif\" alt=\"-\"/>";
        }
      }

      $lnk = "<a href=\"inbox.php?action=readpm&amp;pmid=$item[1]\">$iml $item[0]</a>";
      echo "$lnk<br/>";
    }


  echo "<form action=\"inbxproc.php?action=proc\" method=\"post\">";
  echo "Action: <select name=\"pmact\">";
  echo "<option value=\"rep-$pmid\">Reply</option>";
  echo "<option value=\"del-$pmid\">Delete</option>";
  if(isstarred($pmid))
  {
    echo "<option value=\"ust-$pmid\">Unstar</option>";
  }else{
    echo "<option value=\"str-$pmid\">Star</option>";
  }
    echo "<option value=\"rpt-$pmid\">Report</option>";

  echo "</select>";
  echo "<input type=\"submit\" value=\"GO\"/>";
  echo "</form><br/>";

  echo "<form action=\"inbox.php?action=movetofolder\" method=\"post\">";
  $uid = getuid_sid($sid);

  echo "Move To: <select name=\"movetof\">";
  $foldername = mysql_query("SELECT folderid, foldername FROM dcroxx_me_private_folders WHERE uid='".$uid."'");
  while ($items = mysql_fetch_array($foldername))
  {
  echo "<option value=\"$items[0]\">".htmlspecialchars($items[1])."</option>";
  }
  echo "</select>";
  echo "<input type=\"hidden\" name=\"pmid\" value=\"$pmid\"/>";
  echo "<input type=\"submit\" value=\"Move\"/>";
  echo "</form>";

  echo "</p>";
  echo "<p align=\"center\">";
  echo "<br/><br/><a href=\"inbox.php?action=dialog&amp;who=$pminfo[1]\">Dialog</a>";

  }else{
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>This PM ain't yours";
  }
  echo "<br/><a href=\"index.php?action=chat\">Back to Chat</a><br/>";
    echo "<a href=\"inbox.php?action=main\">Back to inbox</a><br/>";

    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
    echo "Home</a>";
    echo "</p>";

    echo xhtmlfoot();
exit();
}
///////////////MMS Send///////////////
else if($action=="sendmms"){
		addonline(getuid_sid($sid),"Composing a multimedia message","");
    $pstyle = gettheme($sid);
  echo xhtmlhead("Inbox",$pstyle);
		$whonick = getnick_uid($who);
			echo "<p><small><u>Compose your MMS:</u></small><br/>";
		echo "<form enctype=\"multipart/form-data\" action=\"inbxproc.php?action=sendmms\" method=\"post\">
		<small>Recipient:</small><br/><input id=\"inputText\" type=\"text\" name=\"pmtou\" value=\"$whonick\" maxlength=\"30\"/><br/>";
		echo "<small>Text:</small><br/><textarea id=\"inputText\" name=\"pmtext\"></textarea><br/>";
		echo "<small>Image(JPG or JPEG or GIF or PNG or BMP)/Audio(MIDI or AMR or WAV or MP3 or RM)/Video(3GP or MP4 or RM or AVI)/
		Others(ZIP or RAR or EXE or SIS or JAR or PDF):<br/>Size limit 2 MB(2048KB) </small><br/> ";
echo "<input id=\"inputText\" type=\"file\" name=\"attach\"/><br/>";
		echo "<input id=\"inputButton\" type=\"submit\" name=\"submit\" value=\"Send\"/></form></p>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<small><a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
    echo "Home</a></small>";

    echo xhtmlfoot();
exit();
}
  ////////////////////////
else if($action=="mmsdisp"){
addonline(getuid_sid($sid),"Multimedia Messaging","");
   $pstyle = gettheme($sid);
  echo xhtmlhead("Inbox",$pstyle);
echo "<p><small>";

echo "<img src=\"images/mailbox_new.gif\" alt=\"&#187; \"/><a href=\"inbox.php?action=mms&amp;view=urd\">New MMS</a><br/>";
echo "<img src=\"images/mailbox_old.gif\" alt=\"&#187; \"/><a href=\"inbox.php?action=mms&amp;view=all\">All MMS</a><br/>";
echo "<img src=\"images/mailbox_out.gif\" alt=\"&#187; \"/><a href=\"inbox.php?action=mms&amp;view=snt\">Sent MMS</a><br/><br/>";
echo "<img src=\"attachment.gif\" alt=\"&#187; \"/><a href=\"inbox.php?action=sendmms\">Compose New MMS</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
    echo "Home</a>";
    echo "</small></p>";

    echo xhtmlfoot();
exit();
}
///////////////////////////mms inbox//////////////////////////////
else if($action=="mms"){
addonline(getuid_sid($sid),"Browsing Multimedia Inbox","");
   $pstyle = gettheme($sid);
  echo xhtmlhead("Inbox",$pstyle);
$view = $_GET["view"];
//////ALL LISTS SCRIPT <<
if($view=="")$view="all";
if($page=="" || $page<=0)$page=1;
$myid = getuid_sid($sid);
$doit=false;
$num_items = getmmscount($myid,$view); //changable
$items_per_page= 7;
$num_pages = ceil($num_items/$items_per_page);
if($page>$num_pages)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;
if($num_items>0){
if($doit){
$exp = "&amp;rwho=$myid";
}else{
$exp = "";
}
if($view=="all"){
$sql = "SELECT
			a.name, b.id, b.byuid, b.unread, b.starred FROM dcroxx_me_users a
			INNER JOIN mms b ON a.id = b.byuid
			WHERE b.touid='".$myid."'
			ORDER BY b.timesent DESC
			LIMIT $limit_start, $items_per_page
	";
}
else if($view=="snt"){
	$sql = "SELECT
			a.name, b.id, b.touid, b.unread, b.starred FROM dcroxx_me_users a
			INNER JOIN mms b ON a.id = b.touid
			WHERE b.byuid='".$myid."'
			ORDER BY b.timesent DESC
			LIMIT $limit_start, $items_per_page
	";
}
	else if($view=="str"){
	$sql = "SELECT
			a.name, b.id, b.byuid, b.unread, b.starred FROM dcroxx_me_users a
			INNER JOIN mms b ON a.id = b.byuid
			WHERE b.touid='".$myid."' AND b.starred = '1'
			ORDER BY b.timesent DESC
			LIMIT $limit_start, $items_per_page
	";
	}
	else if($view=="urd"){
$sql = "SELECT
			a.name, b.id, b.byuid, b.unread, b.starred FROM dcroxx_me_users a
			INNER JOIN mms b ON a.id = b.byuid
			WHERE b.touid='".$myid."' AND b.unread = '1'
			ORDER BY b.timesent DESC
			LIMIT $limit_start, $items_per_page
   ";
}
}


$items = mysql_query($sql);
if (!$items) {
echo "<center><small>You have no messages!<br/>
<a href=\"inbox.php?action=sendmms\">Compose</a><br/>
<img src=\"images/home.gif\" alt=\"*\"><a href=\"index.php?action=main\">Home</a></small>
</center></body></html>";
exit();
}
echo mysql_error();
while ($item = mysql_fetch_array($items)){
if($item[3]=="1"){
$iml = "<img src=\"images/npm.gif\" alt=\"&#187;\"/>";
}else{
if($item[4]=="1"){
$iml = "<img src=\"images/spm.gif\" alt=\"*\"/>";
}else{
$iml = "<img src=\"images/opm.gif\" alt=\"-\"/>";
}
}
$lnk = "$iml<a href=\"inbox.php?action=readmms&amp;pmid=$item[1]\">$item[0]</a>";
echo "<small>$lnk</small><br/>";
}
echo "<p align=\"center\"><small>";
$npage = $page+1;
echo "<a href=\"inbox.php?action=sendmms\">Compose</a><br/>";
if($page>1){
$ppage = $page-1;
echo "<a href=\"inbox.php?action=mms&amp;page=$ppage&amp;view=$view\">&#171;Previous</a> ";
}
if($page<$num_pages){
$npage = $page+1;
echo "<a href=\"inbox.php?action=mms&amp;page=$npage&amp;view=$view\">&#187;Next</a>";
}
echo "<br/>Page $page of $num_pages<br/>";
if($num_pages>2){
$rets = "Jump to page<form action=\"inbox.php\" method=\"get\"><input name=\"page\" format=\"*N\" size=\"3\"/>";
$rets .= "<input type=\"hidden\" name=\"action\" value=\"mms\"/>";
$rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
$rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
$rets .= "<input type=\"submit\" value=\"Go\"/></form>";
echo $rets;

}else{

}

    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
    echo "Home</a>";
    echo "</small></p>";

    echo xhtmlfoot();
exit();
}

   else if($action=="crfolder")
{
  addonline(getuid_sid($sid),"Creating Folder","");
  $pstyle = gettheme($sid);
  echo xhtmlhead("Create Folder",$pstyle);
  echo "<p align=\"center\">";

    echo "<form method=\"post\" action=\"inbox.php?action=crfolderdone\">";
    echo "Folder Name: <input name=\"fname\" maxlength=\"25\"/><br/>";
    echo "<input type=\"submit\" name=\"Submit\" value=\"Create\"/>";
    echo "</form><br/>";


    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"inbox.php?action=main\">&#171;Back to Inbox</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
    echo "Home</a>";
    echo "</p>";
    echo xhtmlfoot();
exit();
}

   else if($action=="crfolderdone")
{
  addonline(getuid_sid($sid),"Creating Folder","");
  $pstyle = gettheme($sid);
  echo xhtmlhead("Create Folder",$pstyle);
  echo "<p align=\"center\">";

  $fname = $_POST["fname"];
  $uid = getuid_sid($sid);


    $reg = mysql_query("INSERT INTO dcroxx_me_private_folders SET uid='".$uid."', foldername='".$fname."'");

    if($reg)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Folder Created Successfully<br/><br/>";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Creating Folder<br/><br/>";
      }



    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"inbox.php?action=main\">&#171;Back to Inbox</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
    echo "Home</a>";
    echo "</p>";
    echo xhtmlfoot();
exit();
}

   else if($action=="movetofolder")
{
  addonline(getuid_sid($sid),"Moving PM to Folder","");
  $pstyle = gettheme($sid);
  echo xhtmlhead("Moving PM",$pstyle);
  echo "<p align=\"center\">";

  $movetof = $_POST["movetof"];
  $pmid = $_POST["pmid"];

  $uid = getuid_sid($sid);


    $str = mysql_query("UPDATE dcroxx_me_private SET folderid='".$movetof."' WHERE id='".$pmid."' ");
          if($str)
          {
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>PM moved successfully<br/><br/>";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Can't move PM at the moment<br/><br/>";
          }



    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"inbox.php?action=main\">&#171;Back to Inbox</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
    echo "Home</a>";
    echo "</p>";
    echo xhtmlfoot();
exit();
}


else if($action=="dialog")
{
    addonline(getuid_sid($sid),"Viewing PM Dialog","");
          $pstyle = gettheme($sid);
  echo xhtmlhead("PM Dialog",$pstyle);
  $uid = getuid_sid($sid);
  if($page=="" || $page<=0)$page=1;
    $myid = getuid_sid($sid);
    $pms = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE (byuid=$uid AND touid=$who) OR (byuid=$who AND touid=$uid) ORDER BY timesent"));
    echo mysql_error();
    $num_items = $pms[0]; //changable
    $items_per_page= 7;
    $num_pages = ceil($num_items/$items_per_page);
    if($page>$num_pages)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    if($num_items>0)
    {
      echo "<p>";
      $pms = mysql_query("SELECT byuid, text, timesent FROM dcroxx_me_private WHERE (byuid=$uid AND touid=$who) OR (byuid=$who AND touid=$uid) ORDER BY timesent LIMIT $limit_start, $items_per_page");
      while($pm=mysql_fetch_array($pms))
      {
            if(isonline($pm[0]))
  {
    $iml = "<img src=\"images/onl.gif\" alt=\"+\"/>";
  }else{
    $iml = "<img src=\"images/ofl.gif\" alt=\"-\"/>";
  }
  $bylnk = "<a href=\"index.php?action=viewuser&amp;who=$pm[0]\">$iml".getnick_uid($pm[0])."</a>";
  echo $bylnk;
  $tmopm = date("d m y - h:i:s",$pm[2]);
  echo " <small>$tmopm<br/>";

        echo parsepm($pm[1], $sid);


  echo "</small>";
  echo "<br/>--------------<br/>";
      }
      echo "</p><p align=\"center\">";
      if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"inbox.php?action=dialog&amp;page=$ppage&amp;who=$who\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"inbox.php?action=dialog&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
$rets = "<form action=\"inbox.php\" method=\"get\">";
      $rets .= "Jump to page: <input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
$rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
$rets .= "</form>";
        echo $rets;
      }
      }else{
        echo "<p align=\"center\">";
        echo "NO DATA";
      }
      echo "<br/><br/><a href=\"rwdpm.php?action=dlg&amp;who=$who\">Download</a><br/><small>only first 50 messages</small><br/>";
       echo "<a href=\"inbox.php?action=main\">Back to inbox</a><br/>";
 echo "<a href=\"index.php?action=chat\">Back to Chat</a><br/>";
      $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
exit();
}
///////////////////////////////readmms//////////////////////////
else if($action=="readmms"){
 $pstyle = gettheme($sid);
  echo xhtmlhead("MMS",$pstyle);
$pminfo = mysql_fetch_array(mysql_query("SELECT pmtext, byuid, timesent,touid, reported, filename, size, extension, origname FROM mms WHERE id='".$pmid."'"));
 addonline(getuid_sid($sid),"Viewing <i>".getnick_uid($pminfo[1])."</i>\'s MMS","");
        addonline(getuid_sid($sid),"Composing a multimedia message","");
     echo "<head>\n";
          echo "<title>MMS</title>\n";
           echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
                    echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";
          echo "</head>";
      echo "<body>";
    echo "<small>";

  echo "<p align=\"center\">";
if(getuid_sid($sid)==$pminfo[3]){
$chread = mysql_query("UPDATE mms SET unread='0' WHERE id='".$pmid."'");
}

if(($pminfo[3]==getuid_sid($sid))||($pminfo[1]==getuid_sid($sid))){
if(getuid_sid($sid)==$pminfo[3]){
if(isonline($pminfo[1])){
$iml = "<img src=\"images/onl.gif\" alt=\"O\"/>";
}else{
$iml = "<img src=\"images/ofl.gif\" alt=\"O\"/>";
}
$ptxt = "<b>From</b>: ";
$bylnk = "$iml<a href=\"index.php?action=viewuser&amp;who=$pminfo[1]\">".getnick_uid($pminfo[1])."</a>";
}else{
if(isonline($pminfo[3])){
$iml = "<img src=\"images/onl.gif\" alt=\"O\"/>";
}else{
$iml = "<img src=\"images/ofl.gif\" alt=\"O\"/>";
}
$ptxt = "<b>To</b>: ";
$bylnk = "$iml<a href=\"index.php?action=viewuser&amp;who=$pminfo[3]\">".getnick_uid($pminfo[3])."</a>";
}
echo "$ptxt $bylnk<br/>";
$tmstamp = $pminfo[2] + addhours();
$tmdt = date("d/m/Y h:i:s A", $tmstamp);
$diff1=time()-$pminfo[2];
echo "<b>Sent</b>: $tmdt<br/>".gettimemsg($diff1)." ago<br/>";
$pmtext = parsepm($pminfo[0], $sid);

if(isspam($pmtext)){
if(($pminfo[4]=="0") && ($pminfo[1]!=1)){
mysql_query("UPDATE dcroxx_me_private SET reported='1' WHERE id='".$pmid."'");
}
}
switch(strtolower($pminfo[7])){
        case "mid":
        $ext = "MIDI tone";
        break;
        case "3gp":
        $ext = "3GP Video";
        break;
        case "amr":
        $ext = "AMR Audio/Recorded Voice";
        break;
        case "wav":
        $ext = "WAV Audio";
        break;
        case "mp3":
        $ext = "MP3 Audio";
        break;
        case "jpg":
        $ext = "JPG Image";
        break;
        case "gif":
        $ext = "GIF Image";
        break;
        case "png":
        $ext = "PNG Image";
        break;
        case "bmp":
        $ext = "BMP Image";
        break;
        case "exe":
        $ext = "Windows Executable file";
        break;
        case "zip":
        $ext = "Compressed ZIP Archive";
        break;
        case "rar":
        $ext = "Compressed RAR Archive";
        break;
        case "sis":
        $ext = "Symbian Application";
        break;
        case "jar":
        $ext = "Java Mobile Application";
        break;

}

echo "<b>Message</b>:<br/>".$pmtext;
if ($pminfo[7]=="gif"){
        echo "<br/>Image:<br/><img src=\"getfile.php?sid=$sid&amp;fileid=$pmid\" alt=\"Loading...\"/><br/>";
}
if ($pminfo[7]=="jpg"){
        echo "<br/>Image:<br/><img src=\"getfile.php?sid=$sid&amp;fileid=$pmid\" alt=\"Loading...\"/><br/>";
}
if ($pminfo[7]=="bmp"){
        echo "<br/>Image:<br/><img src=\"getfile.php?sid=$sid&amp;fileid=$pmid\" alt=\"Loading...\"/><br/>";
}
if ($pminfo[7]=="png"){
        echo "<br/>Image:<br/><img src=\"getfile.php?sid=$sid&amp;fileid=$pmid\" alt=\"Loading...\"/><br/>";
}
if ($pminfo[7]=="mid"){
        echo "<bgsound src=\"getfile.php?sid=$sid&amp;fileid=$pmid\" loop=\"infinite\"/>";
}
if (($pminfo[7]=="amr") && ($pminfo[6]<100)){
        echo "<bgsound src=\"getfile.php?sid=$sid&amp;fileid=$pmid\" loop=\"infinite\"/>";
}
if (($pminfo[7]=="mp3") && ($pminfo[6]<100)){
        echo "<bgsound src=\"getfile.php?sid=$sid&amp;fileid=$pmid\" loop=\"infinite\"/>";
}
if (($pminfo[7]=="wav") && ($pminfo[6]<100)){
        echo "<bgsound src=\"getfile.php?sid=$sid&amp;fileid=$pmid\" loop=\"infinite\"/>";
}
echo "<br/><b>Attached filename</b>:<br/>".$pminfo[8];
echo "<br/><b>File type</b>: ".$ext;
echo "<br/><b>Size</b>: ".$pminfo[6]."KB";
echo "<br/><a href=\"getfile.php?sid=$sid&amp;fileid=$pmid\">Download attachment</a><br/>";
echo "<a href=\"inbox.php?action=sendmms&amp;who=$pminfo[1]\">Reply with MMS</a><br/>
<a href=\"inbox.php?action=sendpm&amp;who=$pminfo[1]\">Reply with text message</a>";
echo "<p>";
echo "<b>Action</b>: <form action=\"inbxproc.php?action=mproc\" method=\"post\"><select id=\"inputText\" name=\"pmact\">";
echo "<option value=\"ust-$pmid\">Unsave</option>";
echo "<option value=\"str-$pmid\">Save</option>";
echo "<option value=\"rpt-$pmid\">Report To Admin</option>";
echo "<option value=\"del-$pmid\">Delete</option>";
echo "</select>";
echo "<br/><input id=\"inputButton\" type=\"submit\" value=\"Go\"/>";
echo "</form>";
}else{
echo "This PM ain't yours";
}
       echo "<a href=\"inbox.php?action=main\">Back to inbox</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
echo "</body>";
echo "</html>";
exit();
}
    else{
      addonline(getuid_sid($sid),"Lost in inbox lol","");
            $pstyle = gettheme($sid);
  echo xhtmlhead("Inbox",$pstyle);
  echo "<p align=\"center\">";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
      $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
exit();
}

?>
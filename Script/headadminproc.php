<?php
   session_name("PHPSESSID");
session_start();

header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\"\"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">
<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";

	echo "<head>";

	echo "<title>$stitle</title>";
	echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/style.css\" />";
	echo "</head>";

	echo "<body>";
include("core.php");
include("config.php");
include("xhtmlfunctions.php");
connectdb();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
if(!isheadadmin(getuid_sid($sid)))
  {$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("action");
      echo "<p align=\"center\">";
      echo "You are not an owner<br/>";
      echo "<br/>";
      echo "<a href=\"index.php\">Home</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
if(islogged($sid)==false)
    {$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("false");
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
$res = mysql_query("UPDATE dcroxx_me_users SET pid='0' WHERE id='".getuid_sid($sid)."'");
    addonline(getuid_sid($sid),"headadminCP","");
if($action=="general")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("general");
  $xtm = $_POST["sesp"];
  $fmsg = $_POST["fmsg"];
$fmsg2 = $_POST["fmsg2"];
  $areg = $_POST["areg"];
  $pmaf = $_POST["pmaf"];
  $fvw = $_POST["fvw"];
  if($areg=="d")
  {
    $arv = 0;
  }else{
    $arv = 1;
  }
   echo "<p align=\"center\">";


      $res = mysql_query("UPDATE dcroxx_me_settings SET value='".$fmsg."' WHERE name='4ummsg'");
      if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Forum Message  updated successfully<br/>";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Updating Forum message<br/>";
      }
    $res = mysql_query("UPDATE dcroxx_me_settings SET value='".$fmsg2."' WHERE name='4ummsg2'");
      if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Login Page Message  updated successfully<br/>";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Updating Login Page message<br/>";
      }


      $res = mysql_query("UPDATE dcroxx_me_settings SET value='".$xtm."' WHERE name='sesxp'");
      if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Session Period updated successfully<br/>";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Updating Session Period<br/>";
      }

       $res = mysql_query("UPDATE dcroxx_me_settings SET value='".$pmaf."' WHERE name='pmaf'");
      if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>PM antiflood is $pmaf seconds<br/>";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Updating PM antiflood value<br/>";
      }

      $res = mysql_query("UPDATE dcroxx_me_settings SET value='".$arv."' WHERE name='reg'");

      if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Registration updated successfully<br/>";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Updating Registration<br/>";
      }

      $res = mysql_query("UPDATE dcroxx_me_settings SET value='".$fvw."' WHERE name='fview'");

      if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Forums View updated successfully<br/>";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Updating Forums View<br/>";
      }
      echo "<br/>";

      echo "<a href=\"headadmincp.php?action=general\">";
  echo "Edit general settings</a><br/>";
      echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p></body>";
    exit();
    }
//////////////////////////////////
  else if($action=="delinbox")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
  $who = $_GET["who"];
  $user = getnick_uid($who);
  echo "<head>";
  echo "<title>headadminTools</title>";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
  echo "<body>";
  echo "<p align=\"center\">";
  $uid = getuid_sid($sid);
  $perm = mysql_fetch_array(mysql_query("SELECT perm FROM dcroxx_me_users WHERE id='".$uid."'"));
  $trgtperm = mysql_fetch_array(mysql_query("SELECT perm FROM dcroxx_me_users WHERE name='".$user."'"));

  if($trgtperm>$perm){
  echo "<b><img src=\"../images/notok.gif\" alt=\"x\"/><br/>Error!!!<br/>Permission Denied...</b><br/>";
  echo "<br/>U Cannot Delete $user<br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
  }else{

  echo "<br/>";
  $res = mysql_query("DELETE FROM dcroxx_me_private WHERE byuid='".$who."' OR touid='".$who."'");
    if($res)
  {
  echo "<img src=\"../images/ok.gif\" alt=\"O\"/>Inbox  deleted successfully";
  }else{
  echo "<img src=\"../images/notok.gif\" alt=\"X\"/>Error deleting UGroup";
  }
   echo "<br/><b>9 </b><a accesskey=\"9\" href=\"index.php?action=headadmincp\"><img src=\"../images/admn.gif\" alt=\"\"/>headadminTools</a><br/>";
  echo "<b>0 </b><a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  }
  echo "</p></body>";
    exit();
    }
/////////////////////////////////////////////////Add moderating

else if($action=="addfmod")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("addfmod");
    $mid = $_POST["mid"];
  $fid = $_POST["fid"];
      echo "<p align=\"center\">";
      $res = mysql_query("INSERT INTO dcroxx_me_modr SET name='".$mid."', forum='".$fid."'");
      if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Moding Privileges Added<br/>";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error<br/>";
      }
      echo "<br/><br/><a href=\"headadmincp.php?action=manmods\">";
  echo "Manage Moderators</a><br/>";
      echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p></body>";
    exit();
    }
//////////////////////////////////
else if($action=="delclub")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("delclub");
  $clid = $_GET["clid"];
      echo "<p align=\"center\">";
      $res = deleteClub($clid);
      if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Club Deleted<br/>";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error<br/>";
      }

      echo "<br/><br/><a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p></body>";
    exit();
    }
//////////////////////////////////
else if($action=="gccp")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("gccp");
  $clid = $_GET["clid"];
  $plss = $_POST["plss"];
      echo "<p align=\"center\">";
      $nop = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_clubs WHERE id='".$clid."'"));
	  $newpl = $nop[0] + $plss;
	  $res = mysql_query("UPDATE dcroxx_me_clubs SET plusses='".$newpl."' WHERE id='".$clid."'");
      if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Club plusses updated<br/>";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error<br/>";
      }

      echo "<br/><br/><a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p></body>";
    exit();
    }
//////////////////////////////////
else if($action=="delfmod")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("delfmod");
    $mid = $_POST["mid"];
  $fid = $_POST["fid"];
       echo "<p align=\"center\">";
      $res = mysql_query("DELETE FROM dcroxx_me_modr WHERE name='".$mid."' AND forum='".$fid."'");
      if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Moding Privileges Deleted<br/>";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error<br/>";
      }
      echo "<br/><br/><a href=\"headadmincp.php?action=manmods\">";
  echo "Manage Moderators</a><br/>";
      echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p></body>";
    exit();
    }
/////////////////////////////////////////////////////////////

else if($action=="addcat")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("addcat");
  $fcname = $_POST["fcname"];
  $fcpos = $_POST["fcpos"];
        echo "<p align=\"center\">";
        echo $fcname;
        echo "<br/>";
        $res = mysql_query("INSERT INTO dcroxx_me_fcats SET name='".$fcname."', position='".$fcpos."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Forum Category added successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error adding Forum Category";
      }

      echo "<br/><br/><a href=\"headadmincp.php?action=fcats\">";
  echo "Forum Categories</a><br/>";
      echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";

      echo "</p></body>";
    exit();
    }
//////////////////////////////////
else if($action=="addfrm")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
  $frname = $_POST["frname"];
  $frpos = $_POST["frpos"];
  $fcid = $_POST["fcid"];
   addonline(getuid_sid($sid),"admin cp - xHTML:v3","");
                 $id=$_GET["id"];
      echo "<head>\n";
	  echo "<title>Rccwap</title>\n";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/methosprf.css\" />";
	  	  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";
	  echo "</head>";
      echo "<body>";
echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" height=\"12\" width=\"159\">";
echo "<tr>";
echo "<td id=\"body\" width=\"159\">";


 echo "<table border=\"0\" width=\"99%\" cellspacing=\"0\" cellpadding=\"0\" class=\"boxed\" align=\"center\">";
echo "<tr>";
echo "<td class=\"boxedTitle\" height=\"20\">";
echo "<h1 align=\"center\" class=\"boxedTitleText\">admin Values</h1></td>";
echo "<tr>";
echo "<td class=\"boxedContent\">";
				
        echo $frname;
        echo "<br/>";
        $res = mysql_query("INSERT INTO dcroxx_me_forums SET name='".$frname."', position='".$frpos."', cid='".$fcid."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Forum  added successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error adding Forum ";
      }
echo "<tr>";
					echo "<td class=\"IL-R\"><small>";
echo "</tr>";

echo "</td>";
echo "</tr>";
echo "</table>";
 				echo "</tr>";
			echo "</table>";
		echo "</div>";
		echo "</div>";
		
  echo "</div>";

  echo "<p><small>";
  echo "<a href=\"index.php?action=main\">Home</a>";
  echo " &#62; ";
  echo "admin";
  echo "</small></p>";  
  
  echo xhtmlfoot();
    exit();
    }
//////////////////////////////////

else if($action=="addsml")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("addsml");
  $smlcde = $_POST["smlcde"];
  $smlsrc = $_POST["smlsrc"];
        echo "<p align=\"center\">";
        echo "<br/>";
        $res = mysql_query("INSERT INTO dcroxx_me_smilies SET scode='".$smlcde."', imgsrc='".$smlsrc."', hidden='0'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Smilie  added successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error adding Smilie ";
      }

      echo "<br/><br/><a href=\"headadmincp.php?action=addsml\">";
  echo "Add Another Smilie</a><br/>";
      echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";

      echo "</p></body>";
    exit();
    }
//////////////////////////////////
else if($action=="addavt")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("addavt");
  $avtsrc = $_POST["avtsrc"];
        echo "<p align=\"center\">";
	  echo "Source: ".$avtsrc;

        echo "<br/>";
        $res = mysql_query("INSERT INTO dcroxx_me_avatars SET avlink='".$avtsrc."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Avatar  added successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error adding Avatar ";
      }

      echo "<br/><br/><a href=\"headadmincp.php?action=addavt\">";
  echo "Add Another Avatar</a><br/>";
      echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";

      echo "</p></body>";
    exit();
    }
//////////////////////////////////
else if($action=="addjdg")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("addjdg");
  $who = $_GET["who"];
       echo "<p align=\"center\">";
        echo "<br/>";
        $res = mysql_query("INSERT INTO dcroxx_me_judges SET uid='".$who."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Judge  added successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error adding Judge ";
      }

      echo "<br/><br/><a href=\"headadmincp.php?action=chuinfo\">";
  echo "Users Info</a><br/>";
      echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";

      echo "</p></body>";
    exit();
    }
//////////////////////////////////
else if($action=="deljdg")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("deljdg");
  $who = $_GET["who"];
      echo "<p align=\"center\">";
        echo "<br/>";
        $res = mysql_query("DELETE FROM dcroxx_me_judges WHERE uid='".$who."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Judge  deleted successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error deleting Judge ";
      }

      echo "<br/><br/><a href=\"headadmincp.php?action=chuinfo\">";
  echo "Users Info</a><br/>";
      echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";

      echo "</p></body>";
    exit();
    }
//////////////////////////////////
else if($action=="delsm")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("delsm");
  $smid = $_GET["smid"];
      echo "<p align=\"center\">";
        echo "<br/>";
        $res = mysql_query("DELETE FROM dcroxx_me_smilies WHERE id='".$smid."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Smilie  deleted successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error deleting smilie ";
      }

      echo "<br/><br/><a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";

      echo "</p></body>";
    exit();
    }
//////////////////////////////////

else if($action=="addrss")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("addrss");
  $rssnm = $_POST["rssnm"];
  $rsslnk = $_POST["rsslnk"];
  $rssimg = $_POST["rssimg"];
  $rssdsc = $_POST["rssdsc"];
  $fid = $_POST["fid"];

       echo "<p align=\"center\">";
        echo $rssnm;
        echo "<br/>";
        $res = mysql_query("INSERT INTO dcroxx_me_rss SET title='".$rssnm."', link='".$rsslnk."', imgsrc='".$rssimg."', dscr='".$rssdsc."', fid='".$fid."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Source added successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error adding RSS Source";
      }

      echo "<br/><br/><a href=\"headadmincp.php?action=manrss\">";
  echo "Manage RSS</a><br/>";
      echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";

      echo "</p></body>";
    exit();
    }
//////////////////////////////////
else if($action=="addchr")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("addchr");
  $chrnm = $_POST["chrnm"];
  $chrage = $_POST["chrage"];
  $chrpst = $_POST["chrpst"];
  $chrprm = $_POST["chrprm"];
  $chrcns = $_POST["chrcns"];
  $chrfun = $_POST["chrfun"];



       echo "<p align=\"center\">";
        echo $chrnm;
        echo "<br/>";
        $res = mysql_query("INSERT INTO dcroxx_me_rooms SET name='".$chrnm."', static='1', pass='', mage='".$chrage."', chposts='".$chrpst."', perms='".$chrprm."', censord='".$chrcns."' , freaky='".$chrfun."'");
echo mysql_error();
        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Chatroom added successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error adding Chat room";
      }

      echo "<br/><br/><a href=\"headadmincp.php?action=chrooms\">";
  echo "Chatrooms</a><br/>";
      echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";

      echo "</p></body>";
    exit();
    }
//////////////////////////////////
else if($action=="edtrss")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("edtrss");
  $rssnm = $_POST["rssnm"];
  $rsslnk = $_POST["rsslnk"];
  $rssimg = $_POST["rssimg"];
  $rssdsc = $_POST["rssdsc"];
  $fid = $_POST["fid"];
  $rssid = $_POST["rssid"];
       echo "<p align=\"center\">";
        echo $rssnm;
        echo "<br/>";
        $res = mysql_query("UPDATE dcroxx_me_rss SET title='".$rssnm."', link='".$rsslnk."', imgsrc='".$rssimg."', dscr='".$rssdsc."', fid='".$fid."' WHERE id='".$rssid."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Source updated successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error updating RSS Source";
      }

      echo "<br/><br/><a href=\"headadmincp.php?action=manrss\">";
  echo "Manage RSS</a><br/>";
      echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";

      echo "</p></body>";
    exit();
    }
//////////////////////////////////
else if($action=="addperm")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("addperm");
  $fid = $_POST["fid"];
  $gid = $_POST["gid"];

      echo "<p align=\"center\">";
        echo "<br/>";
        $res = mysql_query("INSERT INTO dcroxx_me_acc SET fid='".$fid."', gid='".$gid."'");
        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Permission  added successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error adding permission ";
      }

      echo "<br/><br/><a href=\"headadmincp.php?action=addperm\">";
  echo "Add Permission</a><br/>";
      echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";

      echo "</p></body>";
    exit();
    }

//////////////////////////////////////////add group
else if($action=="addgrp")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
  $ugname = $_POST["ugname"];
  $ugaa = $_POST["ugaa"];
  $allus = $_POST["allus"];
  $mage = $_POST["mage"];
  $maxage = $_POST["maxage"];
  $mpst = $_POST["mpst"];
  $mpls = $_POST["mpls"];
  
      echo "<head>";
      echo "<title>Head Admin Tools</title>";
      echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
      echo "</head>";
      echo "<body>";
      echo "<p align=\"center\">";
  if(!isheadadmin(getuid_sid($sid)))
  {
  echo "Permission Denied!";
  }else{
        echo $ugname;
        echo "<br/>";
        $res = mysql_query("INSERT INTO dcroxx_me_groups SET name='".$ugname."', autoass='".$ugaa."', userst='".$allus."', mage='".$mage."', maxage='".$maxage."', posts='".$mpst."', plusses='".$mpls."'");

        if($res)
      {
        echo "<img src=\"../images/ok.gif\" alt=\"O\"/>User group  added successfully";
      }else{
        echo "<img src=\"../images/notok.gif\" alt=\"X\"/>Error adding User group";
      }
      }
      echo "<br/><br/><b>8 </b><a accesskey=\"8\" href=\"index.php?action=ugroups\">UGroups</a><br/>";
      echo "<b>9 </b><a accesskey=\"9\" href=\"index.php?action=ownercp\"><img src=\"../images/admn.gif\" alt=\"\"/>Admin Tools</a><br/>";
      echo "<b>0 </b><a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";

      echo "</p></body>";
    exit();
    }
//////////////////////////////////
else if($action=="edtfrm")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("edtfrm");
  $fid = $_POST["fid"];
  $frname = $_POST["frname"];
  $frpos = $_POST["frpos"];
  $fcid = $_POST["fcid"];
        echo "<p align=\"center\">";
        echo $frname;
        echo "<br/>";
        $res = mysql_query("UPDATE dcroxx_me_forums SET name='".$frname."', position='".$frpos."', cid='".$fcid."' WHERE id='".$fid."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Forum  updated successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error updating Forum ";
      }

      echo "<br/><br/><a href=\"headadmincp.php?action=forums\">";
  echo "Forums</a><br/>";
      echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";

      echo "</p></body>";
    exit();
    }
//////////////////////////////////
else if($action=="edtcat")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("edtcat");
  $fcid = $_POST["fcid"];
  $fcname = $_POST["fcname"];
  $fcpos = $_POST["fcpos"];
       echo "<p align=\"center\">";
        echo $fcname;
        echo "<br/>";
        $res = mysql_query("UPDATE dcroxx_me_fcats SET name='".$fcname."', position='".$fcpos."' WHERE id='".$fcid."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Forum Category updated successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error updating Forum Category";
      }

      echo "<br/><br/><a href=\"headadmincp.php?action=fcats\">";
  echo "Forum Categories</a><br/>";
      echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";

      echo "</p></body>";
    exit();
    }
//////////////////////////////////
else if($action=="delfrm")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("delfrm");
  $fid = $_POST["fid"];
      echo "<p align=\"center\">";

        echo "<br/>";
        $res = mysql_query("DELETE FROM dcroxx_me_forums WHERE id='".$fid."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Forum  deleted successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error deleting Forum ";
      }

      echo "<br/><br/><a href=\"headadmincp.php?action=forums\">";
  echo "Forums</a><br/>";
      echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";

      echo "</p></body>";
    exit();
    }
//////////////////////////////////
else if($action=="delpms")
{
  $pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("delpms");
       echo "<p align=\"center\">";

        echo "<br/>";
        $res = mysql_query("DELETE FROM dcroxx_me_private WHERE reported!='1' AND starred='0' AND unread='0'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>All PMS except starred, reported, and unread were deleted";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error!";
      }

      echo "<br/><br/><a href=\"headadmincp.php?action=clrdta\">";
  echo "Clear Data</a><br/>";
      echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";

      echo "</p></body>";
    exit();
    }
//////////////////////////////////
else if($action=="clrmlog")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("clrmlog");
      echo "<p align=\"center\">";

        echo "<br/>";
        $res = mysql_query("DELETE FROM dcroxx_me_mlog");
        echo mysql_error();
        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>ModLog Cleared Successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error!";
      }

      echo "<br/><br/><a href=\"headadmincp.php?action=clrdta\">";
  echo "Clear Data</a><br/>";
      echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";

      echo "</p></body>";
    exit();
    }
//////////////////////////////////
else if($action=="delsht")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("delsht");

          echo "<p align=\"center\">";
        $altm = time()-(5*24*60*60);
        echo "<br/>";
        $res = mysql_query("DELETE FROM dcroxx_me_shouts WHERE shtime<'".$altm."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Shouts Older Than 5 days were deleted";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error!";
      }

      echo "<br/><br/><a href=\"headadmincp.php?action=clrdta\">";
  echo "Clear Data</a><br/>";
      echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";

      echo "</p></body>";
    exit();
    }
//////////////////////////////////
else if($action=="delgrp")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("delgrp");
  $ugid = $_POST["ugid"];
     echo "<p align=\"center\">";

        echo "<br/>";
        $res = mysql_query("DELETE FROM dcroxx_me_groups WHERE id='".$ugid."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>UGroup  deleted successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error deleting UGroup";
      }

      echo "<br/><br/><a href=\"headadmincp.php?action=ugroups\">";
  echo "UGroups</a><br/>";
      echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";

      echo "</p></body>";
    exit();
    }
//////////////////////////////////
else if($action=="delrss")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("delrss");
  $rssid = $_POST["rssid"];
       echo "<p align=\"center\">";
        echo "<br/>";
        $res = mysql_query("DELETE FROM dcroxx_me_rss WHERE id='".$rssid."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Source  deleted successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
      }

      echo "<br/><br/><a href=\"headadmincp.php?action=manrss\">";
  echo "Manage RSS</a><br/>";
      echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";

      echo "</p></body>";
    exit();
    }
//////////////////////////////////
else if($action=="delchr")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("delchr");
  $chrid = $_POST["chrid"];
       echo "<p align=\"center\">";
        echo "<br/>";
        $res = mysql_query("DELETE FROM dcroxx_me_rooms WHERE id='".$chrid."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Room  deleted successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
      }

      echo "<br/><br/><a href=\"headadmincp.php?action=chrooms\">";
  echo "Chatrooms</a><br/>";
      echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";

      echo "</p></body>";
    exit();
    }
//////////////////////////////////
else if($action=="delu")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("delu");
  $who = $_GET["who"];
        echo "<p align=\"center\">";

        echo "<br/>";
        $res = mysql_query("DELETE FROM dcroxx_me_buddies WHERE tid='".$who."' OR uid='".$who."'");
    $res = mysql_query("DELETE FROM dcroxx_me_gbook WHERE gbowner='".$who."' OR gbsigner='".$who."'");
    $res = mysql_query("DELETE FROM dcroxx_me_ignore WHERE name='".$who."' OR target='".$who."'");
    $res = mysql_query("DELETE FROM dcroxx_me_mangr WHERE uid='".$who."'");
    $res = mysql_query("DELETE FROM dcroxx_me_modr WHERE name='".$who."'");
    $res = mysql_query("DELETE FROM dcroxx_me_penalties WHERE uid='".$who."' OR exid='".$who."'");
    $res = mysql_query("DELETE FROM dcroxx_me_posts WHERE uid='".$who."'");
    $res = mysql_query("DELETE FROM dcroxx_me_private WHERE byuid='".$who."' OR touid='".$who."'");
    $res = mysql_query("DELETE FROM dcroxx_me_shouts WHERE shouter='".$who."'");
    $res = mysql_query("DELETE FROM dcroxx_me_topics WHERE authorid='".$who."'");
    $res = mysql_query("DELETE FROM dcroxx_me_brate WHERE uid='".$who."'");
    $res = mysql_query("DELETE FROM dcroxx_me_games WHERE uid='".$who."'");
    $res = mysql_query("DELETE FROM dcroxx_me_presults WHERE uid='".$who."'");
    $res = mysql_query("DELETE FROM dcroxx_me_vault WHERE uid='".$who."'");
    $res = mysql_query("DELETE FROM dcroxx_me_blogs WHERE bowner='".$who."'");
    $res = mysql_query("DELETE FROM dcroxx_me_chat WHERE chatter='".$who."'");
    $res = mysql_query("DELETE FROM dcroxx_me_chat WHERE who='".$who."'");
    $res = mysql_query("DELETE FROM dcroxx_me_chonline WHERE uid='".$who."'");
    $res = mysql_query("DELETE FROM dcroxx_me_online WHERE userid='".$who."'");
    $res = mysql_query("DELETE FROM dcroxx_me_ses WHERE uid='".$who."'");
    $res = mysql_query("DELETE FROM dcroxx_me_xinfo WHERE uid='".$who."'");
    deleteMClubs($who);
      $res = mysql_query("DELETE FROM dcroxx_me_users WHERE id='".$who."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>User  deleted successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error deleting UGroup";
      }

      echo "<br/><br/><a href=\"headadmincp.php?action=chuinfo\">";
  echo "User info</a><br/>";
      echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";

      echo "</p></body>";
    exit();
    }
//////////////////////////////////

//////////// Delete users posts
else if($action=="delxp")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("delxp");
  $who = $_GET["who"];
      echo "<p align=\"center\">";

        echo "<br/>";
    $res = mysql_query("DELETE FROM dcroxx_me_posts WHERE uid='".$who."'");
    $res = mysql_query("DELETE FROM dcroxx_me_topics WHERE authorid='".$who."'");


        if($res)
      {
	  mysql_query("UPDATE dcroxx_me_users SET plusses='0' where id='".$who."'");
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>User Posts deleted successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error deleting UPosts";
      }

      echo "<br/><br/><a href=\"headadmincp.php?action=chuinfo\">";
  echo "User info</a><br/>";
      echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";

      echo "</p></body>";
    exit();
    }
//////////////////////////////////
else if($action=="delcat")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("delcat");
  $fcid = $_POST["fcid"];
      echo "<p align=\"center\">";
        echo $fcname;
        echo "<br/>";
        $res = mysql_query("DELETE FROM dcroxx_me_fcats WHERE id='".$fcid."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Forum Category deleted successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error deleting Forum Category";
      }

      echo "<br/><br/><a href=\"headadmincp.php?action=fcats\">";
  echo "Forum Categories</a><br/>";
      echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "headadminCP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";

      echo "</p></body>";
    exit();
    }
//////////////////////////////////
else{
    echo "<p align=\"center\">";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></body>";
    exit();
    }

?>
</html>
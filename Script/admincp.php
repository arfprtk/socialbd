<?php
     session_name("PHPSESSID");
session_start();
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\"\"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
include("config.php");
include("core.php");
include("xhtmlfunctions.php");
echo "<head><title>Admin Tools</title>";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/style.css\" />";
echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
<meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
<meta name=\"description\" content=\"Chatheaven :)\">
<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> 
<meta name=\"keywords\" content=\"free, community, forums, chat, wap, communicate\"></head>";
echo "<body>";

connectdb();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
if(!ismod(getuid_sid($sid)))
  {
    $pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "You are not an admin<br/>";
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
    addonline(getuid_sid($sid),"Admin CP","");
if($action=="general")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("General");
    $xtm = getsxtm();
    $paf = getpmaf();
    $fvw = getfview();
    $fmsg = htmlspecialchars(getfmsg());
 $fmsg2 = htmlspecialchars(getfmsg2());
    if(canreg())
    {
      $arv = "e";
    }else{
      $arv= "d";
    }
  echo "<form action=\"admproc.php?action=general\" method=\"post\">";
  echo "Session Period: ";
  echo "<input name=\"sesp\" format=\"*N\" maxlength=\"3\" size=\"3\ value=\"$xtm\"/>";
  echo "<br/>PM Antiflood<input name=\"pmaf\" format=\"*N\" maxlength=\"3\" size=\"3\" value=\"$paf\"/>";
  echo "<br/>Forum Message: ";
  echo "<input name=\"fmsg\"  maxlength=\"255\" value=\"$fmsg\"/>";
echo "<br/>Login Message: ";
  echo "<input name=\"fmsg2\"  maxlength=\"255\" value=\"$fmsg2\"/>";
  echo "<br/>Registration: ";
  echo "<select name=\"areg\" value=\"$arv\">";
  echo "<option value=\"e\">Enabled</option>";
  echo "<option value=\"d\">Disabled</option>";
  echo "</select><br/>";
  echo "View:";
  echo "<select name=\"fvw\" value=\"$fvw\">";
  //$vname[0]="Drop Menu";
  $vname[0]="Horizontal Links";
  $vname[1]="Nothing";
  for($i=0;$i<count($vname);$i++)
  {
    echo "<option value=\"$i\">$vname[$i]</option>";
  }

  echo "</select>";

echo "<input type=\"submit\" value=\"submit\"/>";
echo "</form>";

  echo "</p>";
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p></body>";
exit();
}

//////////////////////////add permissions//////////////////////////
else if($action=="disablelist")
{
    addonline(getuid_sid($sid),"Admin Tools","");
    echo "<card id=\"main\" title=\"Disable List\">";
    //////ALL LISTS SCRIPT <<
    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE 2x_disabl_acc='1'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql
    
        $sql = "SELECT id, name FROM dcroxx_me_users WHERE 2x_disabl_acc='1' ORDER BY name  LIMIT $limit_start, $items_per_page";
    

    echo "<p><small>";
    $items = mysql_query($sql);

    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {

    $nopl = mysql_fetch_array(mysql_query("SELECT 2x_disable_reas, 2x_disable_uid FROM dcroxx_me_users WHERE id='".$item[0]."'"));
    //$uage = getage($nopl[1]);
  /*  if($nopl[0]=='M')
    {$usex = "Male";}else
    if($nopl[0]=='F'){$usex = "Female";}
    else{$usex = "Argh! No Profile!";}
    $nopl[2] = htmlspecialchars($nopl[2]);*/
  $uick = getnick_uid($nopl[1]);
    $lnk = "<a href=\"member.php?action=viewuser&amp;who=$item[0]\">$item[1]</a> ($nopl[0]) By <a href=\"index.php?action=viewuser&amp;who=$nopl[1]\">$uick</a>";
    echo "$lnk<br/>";
    }
    }
    echo "</small></p>";
    echo "<p align=\"center\"><small>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"admincp.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"admincp.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"admincp.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</small></p>";
    echo "<p align=\"center\"><small>";
    echo "<a href=\"index.php?action=main\"><img src=\"../icons/home.gif\" alt=\"\"/>Home</a>";
    echo "</small></p>";
    echo "</card>";
}

else if($action=="disablesht")
{
  $who = $_GET['who'];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"ModCP\">"; 
  echo "<p align=\"left\"><small>";
  echo"<b>Disable Shout</b><br/>";
echo "<form action=\"admproc.php?action=disablesht\" method=\"post\">";

  echo "Reason: <br/><input name=\"pres\" maxlength=\"100\" size=\"30\"/><br/>";
  echo "Minutes: <br/><input name=\"pmn\" format=\"*N\" maxlength=\"2\"/><br/>";
  echo "Seconds: <br/><input name=\"psc\" format=\"*N\" maxlength=\"2\"/><br/>";
 // echo "<anchor>Disable";
  //echo "<go href=\"admproc.php?action=disablesht&amp;sid=$sid\" method=\"post\">";
  echo "<postfield name=\"pres\" value=\"$(pres)\"/>";
  echo "<postfield name=\"pmn\" value=\"$(pmn)\"/>";
  echo "<postfield name=\"psc\" value=\"$(psc)\"/>";
  echo "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
 // echo "</go></anchor><br/>";
  echo "<br/><input type=\"Submit\" Name=\"Submit\" Value=\"Disable\"></form>";
   
  echo"</small></p><p align=\"center\"><small>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
else if($action=="addperm")
{
  echo "<head>";
  echo "<title>Admin Tools</title>";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
  echo "<body>";
  echo "<p align=\"center\">";
  if(!isadmin(getuid_sid($sid)))
  {
  echo "Permission Denied!<br/>";
  }else{
  echo "<b>Add permission</b>";
  $forums = mysql_query("SELECT id, name FROM dcroxx_me_forums ORDER BY position, id, name");
  echo "<form action=\"admproc.php?action=addperm\" method=\"post\">";
  echo "<br/><br/>Forum: <select name=\"fid\">";
  while ($forum=mysql_fetch_array($forums))
  {
  echo "<option value=\"$forum[0]\">$forum[1]</option>";
  }
  echo "</select>";
  $forums = mysql_query("SELECT id, name FROM dcroxx_me_groups ORDER BY  name, id");
  echo "<br/>UGroups: <select name=\"gid\">";
  while ($forum=mysql_fetch_array($forums))
  {
  echo "<option value=\"$forum[0]\">$forum[1]</option>";
  }
  echo "</select>";
  echo "<br/><input type=\"Submit\" Name=\"Submit\" Value=\"Submit\"></form>";
  }
  echo "<br/><b>9 </b><a accesskey=\"9\" href=\"index.php?action=ownercp\"><img src=\"../images/admn.gif\" alt=\"\"/>Admin Tools</a><br/>";
  echo "<b>0 </b><a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
  echo "</body>";

exit();
}

///////////////////////////////////////Manage Mods

else if($action=="manmods")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Mods");
    echo "<p align=\"center\">";
    echo "NOTE: Some features will be added later to this page<br/><br/>";
    $mods = mysql_query("SELECT id, name FROM dcroxx_me_users WHERE perm='1'");
    echo "Mod: <select name=\"mid\">";
    while($mod=mysql_fetch_array($mods))
    {
      echo "<option value=\"$mod[0]\">$mod[1]</option>";
    }
    echo "</select><br/>";
    /*
    $forums = mysql_query("SELECT id, name FROM dcroxx_me_forums");
    echo "Forum: <select name=\"fid\">";
    while($forum=mysql_fetch_array($forums))
    {
      echo "<option value=\"$forum[0]\">$forum[1]</option>";
    }
    echo "</select><br/>";
    echo "<anchor>Add";
    echo "<go href=\"admproc.php?action=addfmod\" method=\"post\">";
    echo "<postfield name=\"mid\" value=\"$(mid)\"/>";
    echo "<postfield name=\"fid\" value=\"$(fid)\"/>";
    echo "</go>";
    echo "</anchor>";
    */
    echo "<anchor>Add All Forums";
    echo "<go href=\"admproc.php?action=addfmod\" method=\"post\">";
    echo "<postfield name=\"mid\" value=\"$(mid)\"/>";
    echo "<postfield name=\"fid\" value=\"*\"/>";
    echo "</go>";
    echo "<br/></anchor>";
    echo "<anchor>Delete All Forums";
    echo "<go href=\"admproc.php?action=delfmod\" method=\"post\">";
    echo "<postfield name=\"mid\" value=\"$(mid)\"/>";
    echo "<postfield name=\"fid\" value=\"*\"/>";
    echo "</go>";
    echo "</anchor>";
    //echo "<br/><br/>";
    echo "<br/><br/><a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
exit();
}

/////////////
else if($action=="fcats")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Catagories");
    echo "<p>";
    echo "<a href=\"admincp.php?action=addcat\">&#187;Add Category</a><br/>";
    echo "<a href=\"admincp.php?action=edtcat\">&#187;Edit Category</a><br/>";
    echo "<a href=\"admincp.php?action=delcat\">&#187;Delete Category</a><br/>";
    echo "</p>";
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
exit();
}

/////////////
else if($action=="club")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Clubs");
	$clid = $_GET["clid"];
    echo "<p>";
    echo "<a href=\"admincp.php?action=gccp&amp;clid=$clid\">&#187;Give Credit Plusses</a><br/>";
    echo "<a href=\"admproc.php?action=delclub&amp;clid=$clid\">&#187;Delete Club</a><br/>";
    echo "</p>";
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
exit();
}

/////////////
else if($action=="manrss")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Rss");
    echo "<p>";
    echo "<a href=\"admincp.php?action=addrss\">&#187;Add Source</a><br/>";
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_rss"));
    if($noi[0]>0)
    {echo "<form action=\"admincp.php?action=edtrss\" method=\"post\">";
        echo "<br/><select name=\"rssid\">";
        while($rs=mysql_fetch_array($rss))
        {
            echo "<option value=\"$rs[1]\">$rs[0]</option>";
        }
      echo "</select><br/>";
echo "<input type=\"submit\" value=\"Edit\"/>";
echo "<form action=\"admproc.php?action=delrss\" method=\"post\">";
echo "<br/><select name=\"rssid\">";
while($rs1=mysql_fetch_array($rss1))
        {
            echo "<option value=\"$rs1[1]\">$rs1[0]</option>";
        }
      echo "</select><br/>";
echo "<input type=\"submit\" value=\"Delete\"/>";
echo "<br/>";
echo "</form>";
    }
    echo "</p>";
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
exit();
}

/////////////
else if($action=="chrooms")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("Secret Zone",$pstyle);
    echo "<p>";
    echo "<a href=\"admincp.php?action=addchr\">&#187;Add Room</a><br/>";
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_rooms"));
    if($noi[0]>0)
    {
        $rss = mysql_query("SELECT name, id FROM dcroxx_me_rooms");
        echo "<form action=\"admproc.php?action=delchr\" method=\"post\">";
        echo "<br/><select name=\"chrid\">";
        while($rs=mysql_fetch_array($rss))
        {
           $rs0 = htmlspecialchars("$rs[0]");
          $rs1 = htmlspecialchars("$rs[1]");
          echo "<option value=\"$rs1\">$rs0</option>";
        }
      echo "</select><br/>";
echo "<input type=\"submit\" value=\"Delete\"/>";
echo "</form>";

    }
    echo "</p>";
    echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
}
else if($action=="addlink")
   {
     $pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
      echo "<body>";
      echo "<p align=\"center\">";
      echo "Please Enter The Address Of the Site To Add<br/>";
      echo "<form action=\"admproc.php?action=addlink\" method=\"post\">";
      echo "<b>url</b><br/>";
      echo "<input name=\"url\"/><br/>";
      echo "<b>sitetitle</b><br/>";
      echo "<input name=\"title\"/><br/>";
      echo "<br/><input type=\"Submit\" Name=\"Submit\" Value=\"Add Link\"></form>";
      echo "</p>";
      echo "<p align=\"center\">";
    echo "<b>8 </b><a accesskey=\"8\" href=\"linksites.php?sid=$sid\">Links</a><br/>";
        echo "<a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>"; echo "</p>";
      echo "</body>";
 exit();
}


else if($action=="gcopt")
{
  $who = $_GET["who"];
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";

  $unick = getnick_uid($who);
  echo "Add/Substract $unick's GC";
  echo "</small></p>";
  echo "<p><small>";

  echo "<form action=\"mprocpl.php?action=gc\" method=\"post\">"; 
  
  $pen[0]="Substract";
  $pen[1]="Add";
  echo "Action: <select name=\"pid\">";
  for($i=0;$i<count($pen);$i++){
  echo "<option value=\"$i\">$pen[$i]</option>";
  }
  echo "</select><br/>";
  echo "Reason: <input name=\"pres\" maxlength=\"100\"/><br/>";
  echo "GC: <input name=\"pval\" format=\"*N\" maxlength=\"3\"/><br/>";
  echo "<input type=\"hidden\"  name=\"who\" value=\"$who\"/>";
  echo "<postfield name=\"pid\" value=\"$(pid)\"/>";
echo "<br/><input type=\"Submit\" Name=\"Submit\" Value=\"Submit\"></form>";
 
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}

/////////////
else if($action=="addlinks")
   {
     $pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
      echo "<body>";
      echo "<p align=\"center\">";
      echo "Please Enter The Address Of the Site To Add<br/>";
      echo "<form action=\"admproc.php?action=addlinks\" method=\"post\">";
      echo "<b>url</b><br/>";
      echo "<input name=\"url\"/><br/>";
      echo "<b>sitetitle</b><br/>";
      echo "<input name=\"title\"/><br/>";
      echo "<br/><input type=\"Submit\" Name=\"Submit\" Value=\"Add Link\"></form>";
      echo "</p>";
      echo "<p align=\"center\">";
    echo "<b>8 </b><a accesskey=\"8\" href=\"linksites2.php?sid=$sid\">Links</a><br/>";
        echo "<a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>"; echo "</p>";
      echo "</body>";
  }
else if($action=="forums")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
    boxstart("Forums");
    echo "<p>";
    echo "<a href=\"admincp.php?action=addfrm\">&#187;Add Forum</a><br/>";
    echo "<a href=\"admincp.php?action=edtfrm\">&#187;Edit Forum</a><br/>";
    echo "<a href=\"admincp.php?action=delfrm\">&#187;Delete Forum</a><br/>";
    echo "</p>";
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
exit();
}

/////////////
else if($action=="clrdta")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Clear Data");

    echo "<p>";
    echo "<a href=\"admproc.php?action=delpms\">&#187;Deleted PMs</a><br/>";
    echo "<a href=\"admproc.php?action=clrmlog\">&#187;Clear ModLog</a><br/>";
    echo "<a href=\"admproc.php?action=delsht\">&#187;Delete Old Shouts</a><br/>";
    echo "</p>";
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
exit();
}

/////////////
else if($action=="ugroups")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Groups");

    echo "<p>";
    echo "<a href=\"admincp.php?action=addgrp\">&#187;Add User Group</a><br/>";
    //echo "<a href=\"admincp.php?action=edtgrp\">&#187;Edit User group</a><br/>";
    echo "<a href=\"admincp.php?action=delgrp\">&#187;Delete User group</a><br/>";
    echo "</p>";
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
exit();
}

/////////////
else if($action=="addcat")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Catagories");
     echo "<p align=\"center\">";
    echo "<form action=\"admproc.php?action=addcat\" method=\"post\">";
    echo "Name:<input name=\"fcname\" maxlength=\"30\"/><br/>";
    echo "Position:<input name=\"fcpos\" format=\"*N\" size=\"3\"  maxlength=\"3\"/><br/>";
echo "<input type=\"submit\" value=\"Add\"/>";
    echo "</form>";
    echo "<br/><br/><a href=\"admincp.php?action=fcats\">";
  echo "Forum Categories</a><br/>";
    echo "<a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
exit();
}

/////////////
else if($action=="addfrm")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Forum");

    echo "<p align=\"center\">";
    echo "<b>Add Forum</b><br/><br/>";
    echo "<form action=\"admproc.php?action=addfrm\" method=\"post\">";
    echo "Name:<input name=\"frname\" maxlength=\"30\"/><br/>";
    echo "Position:<input name=\"frpos\" format=\"*N\" size=\"3\"  maxlength=\"3\"/><br/>";
   $fcats = mysql_query("SELECT id, name FROM dcroxx_me_fcats ORDER BY position, id, name");
    echo "Category: <select name=\"fcid\">";

    while ($fcat=mysql_fetch_array($fcats))
    {
        echo "<option value=\"$fcat[0]\">$fcat[1]</option>";
    }
    echo "</select><br/>";
echo "<input type=\"submit\" value=\"Add\"/>";
echo "</form>";
    echo "<br/><br/><a href=\"admincp.php?action=forums\">";
  echo "Forums</a><br/>";
    echo "<a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
exit();
}

/////////////
else if($action=="gccp")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Plusses");
    echo "<p align=\"center\">";
    echo "<b>Add club plusses</b><br/><br/>";
	$clid = $_GET["clid"];
    echo "<form action=\"admproc.php?action=gccp&amp;clid=$clid\" method=\"post\">";
    echo "Plusses:<input name=\"plss\" maxlength=\"3\" size=\"3\" format=\"*N\"/><br/>";
echo "<input type=\"submit\" value=\"Give\"/>";
echo "</form>";
    echo "<br/><br/><a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
exit();
}

/////////////
else if($action=="addsml")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
    boxstart("Smilies");
    echo "<p align=\"center\">";
    echo "<b>Add Smilies</b><br/><br/>";
    echo "<form action=\"admproc.php?action=addsml\" method=\"post\">";
    echo "Code:<input name=\"smlcde\" maxlength=\"30\"/><br/>";
    echo "Image Source:<input name=\"smlsrc\" maxlength=\"200\"/><br/>";
    echo "<input id=\"inputButton\" type=\"submit\" value=\"Add\"/>";
   echo "</form>";

/*echo "<form method=\"post\" enctype=\"multipart/form-data\">";
echo "<input type=\"file\" name=\"filetoupload\"><br>";
echo "<input type=\"Submit\" name=\"uploadform\" value=\"Upload\">";
echo "</form>";*/
echo"<br/>";
echo "<br/><br/><a href=\"smilies/index.php?action=smilies\">Smilies</a><br/>";
echo "<a href=\"smilies/index.php?action=upload&amp;script=xhtml&amp;prevscript=$script\">Upload</a><br/>";
    echo "<br/><br/><a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
exit();
}

/////////////

else if($action=="addavt")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Avatar");
    echo "<p align=\"center\">";
    echo "<b>Add Smilies</b><br/><br/>";
    echo "<form action=\"admproc.php?action=addavt\" method=\"post\">";
    echo "Source:<input name=\"avtsrc\" maxlength=\"30\"/><br/>";
    echo "<input type=\"submit\" value=\"Add\"/>";
    echo "</form>";
    echo "<br/><br/><a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
exit();
}

/////////////

else if($action=="addrss")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Rss");
    echo "<p align=\"center\">";
    echo "<b>Add RSS</b><br/><br/>";
    echo "<form action=\"admproc.php?action=addrss\" method=\"post\">";
    echo "Name:<input name=\"rssnm\" maxlength=\"50\"/><br/>";
    echo "Source:<input name=\"rsslnk\" maxlength=\"255\"/><br/>";
    echo "Image:<input name=\"rssimg\" maxlength=\"255\"/><br/>";
    echo "Description:<input name=\"rssdsc\"  maxlength=\"255\"/><br/>";
    $forums = mysql_query("SELECT id, name FROM dcroxx_me_forums ORDER BY position, id, name");
    echo "Forum: <select name=\"fid\">";
    echo "<option value=\"0\">NO FORUM</option>";
    while ($forum=mysql_fetch_array($forums))
    {
        echo "<option value=\"$forum[0]\">$forum[1]</option>";
    }
    echo "</select><br/>";
echo "<input type=\"submit\" value=\"Add\"/>";
echo "</form>";

    echo "<br/><br/><a href=\"admincp.php?action=manrss\">";
  echo "<img src=\"images/rss.gif\" alt=\"rss\"/>Manage RSS</a><br/>";
    echo "<a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
exit();
}

/////////////
else if($action=="addchr")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Chat Room");
    echo "<p align=\"center\">";
    echo "<b>Add Room</b><br/><br/>";
    echo "<form action=\"admproc.php?action=addchr\" method=\"post\">";
    echo "Name:<input name=\"chrnm\" maxlength=\"30\"/><br/>";
    echo "Minimum Age:<input name=\"chrage\" format=\"*N\" maxlength=\"3\" size=\"3\"/><br/>";
    echo "Minimum Chat Posts:<input name=\"chrpst\" format=\"*N\" maxlength=\"4\" size=\"4\"/><br/>";
    echo "Permission:<select name=\"chrprm\">";
    echo "<option value=\"0\">Normal</option>";
    echo "<option value=\"1\">Moderators</option>";
    echo "<option value=\"2\">Admins</option>";
echo "<option value=\"3\">Head Admin</option>";
echo "<option value=\"4\">Owners</option>";
    echo "</select><br/>";
    echo "Censored:<select name=\"chrcns\">";
    echo "<option value=\"1\">Yes</option>";
    echo "<option value=\"0\">No</option>";
    echo "</select><br/>";
  echo "VIP: <select name=\"specialid\" value=\"$specialid[0]\">";
    echo "<option value=\"0\">Normal</option>";
    echo "<option value=\"1\">Millionaire</option>";
    echo "<option value=\"2\">Quiz Masters</option>";
    echo "<option value=\"8\">Prince</option>";
    echo "<option value=\"9\">Princess</option>";
    echo "</select><br/>";
    echo "Fun:<select name=\"chrfun\">";
    echo "<option value=\"0\">No</option>";
    echo "<option value=\"1\">esreveR</option>";
    echo "<option value=\"2\">Fun Babe</option>";
    echo "</select><br/>";
echo "<input type=\"submit\" value=\"Add\"/>";
    echo "<form>";
    echo "<br/><br/><a href=\"admincp.php?action=chrooms\">";
  echo "<img src=\"images/chat.gif\" alt=\"chat\"/>Chatrooms</a><br/>";
    echo "<a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
exit();
}

/////////////
else if($action=="edtrss")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
  boxstart("Rss");
  $rssid = $_POST["rssid"];
  $rsinfo = mysql_fetch_array(mysql_query("SELECT title, link, imgsrc, fid, dscr FROM dcroxx_me_rss WHERE id='".$rssid."'"));
    echo "<form action=\"admproc.php?action=edtrss\" method=\"post\">";
    echo "Name:<input name=\"rssnm\" maxlength=\"50\" value=\"$rsinfo[0]\"/><br/>";
    echo "Source:<input name=\"rsslnk\" maxlength=\"255\" value=\"$rsinfo[1]\"/><br/>";
    echo "Image:<input name=\"rssimg\" maxlength=\"255\" value=\"$rsinfo[2]\"/><br/>";
    echo "Description:<input name=\"rssdsc\"  maxlength=\"255\" value=\"$rsinfo[4]\"/><br/>";
    $forums = mysql_query("SELECT id, name FROM dcroxx_me_forums ORDER BY position, id, name");
    echo "Forum: <select name=\"fid\" value=\"$rsinfo[3]\">";
    echo "<option value=\"0\">NO FORUM</option>";
    while ($forum=mysql_fetch_array($forums))
    {
        echo "<option value=\"$forum[0]\">$forum[1]</option>";
    }
    echo "</select><br/>";
echo "<input type=\"submit\" value=\"Edit\"/>";
echo "<input type=\"hidden\" name=\"fid\" value=\"$fid\"/>";
echo "<input type=\"hidden\" name=\"rssid\" value=\"$rssid\"/>";
echo "</form>";
    echo "<br/><br/><a href=\"admincp.php?action=manrss\">";
  echo "<img src=\"images/rss.gif\" alt=\"rss\"/>Manage RSS</a><br/>";
    echo "<a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
exit();
}

/////////////

else if($action=="addgrp")
{boxstart("Goup");
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
    echo "<p align=\"center\">";
    echo "<b>Add Group</b><br/><br/>";
    echo "<form action=\"admproc.php?action=addgrp\" method=\"post\">";
    echo "Name:<input name=\"ugname\" maxlength=\"30\"/><br/>";
    echo "Auto Assign:<select name=\"ugaa\">";
    echo "<option value=\"1\">Yes</option>";
    echo "<option value=\"0\">No</option>";
    echo "</select><br/>";
    echo "<br/><small><b>For Auto Assign Only</b></small><br/>";
    echo "Allow:<select name=\"allus\">";
    echo "<option value=\"0\">Normal Users</option>";
    echo "<option value=\"1\">Mods</option>";
    echo "<option value=\"2\">Admins</option>";
    echo "</select><br/>";
    echo "Min. Age:";
    echo "<input name=\"mage\" format=\"*N\" maxlength=\"3\" size=\"3\"/>";
    echo "<br/>Min. Posts:";
    echo "<input name=\"mpst\" format=\"*N\" maxlength=\"3\" size=\"3\"/>";
    echo "<br/>Min. Plusses:";
    echo "<input name=\"mpls\" format=\"*N\" maxlength=\"3\" size=\"3\"/><br/>";
echo "<input type=\"submit\" value=\"Add\"/>";
echo "</form>";
    echo "<br/><br/><a href=\"admincp.php?action=ugroups\">";
  echo "UGroups</a><br/>";
    echo "<a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
exit();
}

/////////////



else if($action=="edtfrm")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Forum");
    echo "<p align=\"center\">";
    echo "<b>Edit Forum</b><br/><br/>";
    $forums = mysql_query("SELECT id,name FROM dcroxx_me_forums ORDER BY position, id, name");
    echo "<form action=\"admproc.php?action=edtfrm\" method=\"post\">";
    echo "Forum: <select name=\"fid\">";
    while($forum=mysql_fetch_array($forums))
    {
      echo "<option value=\"$forum[0]\">$forum[1]</option>";
    }
    echo "</select>";
    echo "<br/>Name:<input name=\"frname\" maxlength=\"30\"/><br/>";
    echo "Position:<input name=\"frpos\" format=\"*N\" size=\"3\"  maxlength=\"3\"/><br/>";
    $fcats = mysql_query("SELECT id, name FROM dcroxx_me_fcats ORDER BY position, id, name");
    echo "Category: <select name=\"fcid\">";
    while ($fcat=mysql_fetch_array($fcats))
    {
        echo "<option value=\"$fcat[0]\">$fcat[1]</option>";
    }
    echo "</select><br/>";
echo "<input type=\"submit\" value=\"Edit\"/>";
echo "</form>";
    echo "<br/><br/><a href=\"admincp.php?action=forums\">";
  echo "Forums</a><br/>";
    echo "<a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
exit();
}

/////////////
else if($action=="delfrm")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Forum");
    echo "<p align=\"center\">";
    echo "<b>Delete Forum</b><br/><br/>";
    $forums = mysql_query("SELECT id,name FROM dcroxx_me_forums ORDER BY position, id, name");
   echo "<form action=\"admproc.php?action=delfrm\" method=\"post\">";
    echo "Forum: <select name=\"fid\">";
    while($forum=mysql_fetch_array($forums))
    {
      $forum0 = htmlspecialchars("$forum[0]");
      $forum1 = htmlspecialchars("$forum[1]");
         echo "<option value=\"$forum0\">$forum1</option>";
    }
    echo "</select><br/>";
echo "<input type=\"submit\" value=\"Delete\"/>";
    echo "</form>";

    echo "<br/><br/><a href=\"admincp.php?action=forums\">";
  echo "Forums</a><br/>";
    echo "<a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
exit();
}

/////////////
//////////////////////////delete group//////////////////////////

else if($action=="delgrp")
{
  echo "<head>";
  echo "<title>Admin Tools</title>";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
  echo "<body>";
  echo "<p align=\"center\">";
  if(!isadmin(getuid_sid($sid)))
  {
  echo "Permission Denied!<br/>";
  }else{
  echo "<b>Delete UGroup</b><br/><br/>";
  echo "<form action=\"admproc.php?action=delgrp\" method=\"post\">";
  $forums = mysql_query("SELECT id,name FROM dcroxx_me_groups ORDER BY name, id");
  echo "UGroup: <select name=\"ugid\">";
  while($forum=mysql_fetch_array($forums))
  {
  echo "<option value=\"$forum[0]\">$forum[1]</option>";
  }
  echo "</select><br/>";
  echo "<input type=\"Submit\" Name=\"Submit\" Value=\"Delete\">";
  }
  echo "<br/><b>8 </b><a accesskey=\"8\" href=\"admincp.php?action=forums\">Forums</a><br/>";
  echo "<b>9 </b><a accesskey=\"9\" href=\"admincp.php?action=admincp\"><img src=\"../images/admn.gif\" alt=\"\"/>Admin Tools</a><br/>";
  echo "<b>0 </b><a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
  echo "</body>";
exit();
}

/////////////
else if($action=="edtcat")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Catagories");
    echo "<p align=\"center\">";
    echo "<b>Edit Category</b><br/><br/>";
    $fcats = mysql_query("SELECT id, name FROM dcroxx_me_fcats ORDER BY position, id, name");
    echo "<form action=\"admproc.php?action=edtcat\" method=\"post\">";
    echo "Edit: <select name=\"fcid\">";
    while ($fcat=mysql_fetch_array($fcats))
    {
        echo "<option value=\"$fcat[0]\">$fcat[1]</option>";
    }
    echo "</select><br/>";
    echo "Name:<input name=\"fcname\" maxlength=\"30\"/><br/>";
    echo "Position:<input name=\"fcpos\" format=\"*N\" size=\"3\"  maxlength=\"3\"/><br/>";
echo "<input type=\"submit\" value=\"Edit\"/>";
echo "</form>";
    echo "<br/><br/><a href=\"admincp.php?action=fcats\">";
  echo "Forum Categories</a><br/>";
    echo "<a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
exit();
}

/////////////
else if($action=="delcat")
{boxstart("Catagories");
    echo "<p align=\"center\">";
    echo "<b>Delete Category</b><br/><br/>";
    $fcats = mysql_query("SELECT id, name FROM dcroxx_me_fcats ORDER BY position, id, name");
    echo "<form action=\"admproc.php?action=delcat\" method=\"post\"/>";
    echo "Delete: <select name=\"fcid\">";

    while ($fcat=mysql_fetch_array($fcats))
    {
        echo "<option value=\"$fcat[0]\">$fcat[1]</option>";
    }
    echo "</select><br/>";
echo "<input type=\"submit\" value=\"Delete\"/>";
    echo "</form>";

    echo "<br/><br/><a href=\"admincp.php?action=fcats\">";
  echo "Forum Categories</a><br/>";
    echo "<a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
exit();
}

////////////////////////////////////user info

else if($action=="chuinfo")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Change User Info");
    echo "<p align=\"center\">";
    echo "Type user nickname<br/><br/>";
   echo "<form action=\"admincp.php?action=acui\" method=\"post\">";
    echo "User: <input name=\"unick\" format=\"*x\" maxlength=\"15\"/><br/>";
echo "<input type=\"submit\" value=\"find\"/>";
echo "</form>";
    echo "<br/><br/><a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
exit();
}

//////////////////////////////////////////Change User info

else if($action=="acui")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Change User Info");
    echo "<p align=\"center\">";
    $unick = $_POST["unick"];
    $tid = getuid_nick($unick);
    if($tid==0)
    {
      echo "<img src=\"images/notok.gif\" alt=\"x\"/>User Does Not exist<br/>";
    }else{
      echo "</p>";
      echo "<p>";
      echo "<a href=\"admincp.php?action=chubi&amp;who=$tid\">&#187;$unick's Profile</a><br/>";
      $judg = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_judges WHERE uid='".$tid."'"));
      if($judg[0]>0)
      {
      echo "<a href=\"admproc.php?action=deljdg&amp;who=$tid\">&#187;Remove $unick From Judges List</a><br/>";
      }else{
        echo "<a href=\"admproc.php?action=addjdg&amp;who=$tid\">&#187;Make $unick judge</a><br/>";
      }
      //echo "<a href=\"admincp.php?action=addtog&amp;who=$tid\">&#187;Add  $unick to a group</a><br/>";
      //echo "<a href=\"admincp.php?action=umset&amp;who=$tid\">&#187;$unick's Mod. Settings</a><br/>";
	  echo "<a href=\"admproc.php?action=delxp&amp;who=$tid\">&#187;Delete $unick's posts</a><br/>";
      echo "<a href=\"admproc.php?action=delu&amp;who=$tid\">&#187;Delete $unick</a><br/>";
      echo "</p>";
      echo "<p align=\"center\">";
    }
    echo "<a href=\"admincp.php?action=chuinfo\">";
  echo "Users Info</a><br/>";
    echo "<a href=\"index.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "Admin CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
exit();
}

/////////////
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

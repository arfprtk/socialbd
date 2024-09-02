<?php
session_name("PHPSESSID");
session_start();
    echo "<body>";

include("config.php");
include("core.php");
include("xhtmlfunctions.php");
connectdb();

$action = $_GET["action"];
$sid = $_SESSION['sid'];
$page = $_GET["page"];
$did = $_GET["did"];
if($action != "")
{
    if(islogged($sid)==false)
    {
     
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or<br/>Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";

      exit();
    }
}
if(isbanned($uid))
    {
       
      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "You are <b>Banned</b><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto FROM dcroxx_me_penalties WHERE uid='".$uid."' AND penalty='1'"));
      $remain = $banto[0]- time();
      $rmsg = gettimemsg($remain);
      echo "Time to finish your penalty: $rmsg<br/><br/>";
      //echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
 
      exit();
    }

//////////////////////////////////Buddies

else if($action=="mp3")
{$pstyle = gettheme($sid);
    echo xhtmlhead("Symbian",$pstyle);
    $who = $_GET["who"];
    addonline(getuid_sid($sid),"Symbian Application","");
  
    $uid = getuid_sid($sid);



    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    if($did="1")
    {
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE did='1'"));
    }else{
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE uid='".$who."'"));
    }
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;


    if($who!="")
    {
        $sql = "SELECT id, title, itemurl, did FROM dcroxx_me_vault WHERE uid='".$who."' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }else{
      $sql = "SELECT id, title, itemurl, uid, did FROM dcroxx_me_vault WHERE did='".$did."' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }



    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $ext = getext($item[2]);
        $ime = getextimg($ext);
        $lnk = "<a href=\"downloads.php?action=download&amp;did=$item[0]\">$ime".htmlspecialchars($item[2])."</a>";

      if(candelvl($uid, $item[0]))
      {
        $delnk = "<a href=\"genproc.php?action=delvlt&amp;did=$item[0]\">[x]</a>";
      }else{
        $delnk = "";
      }
      if($who!="")
      {
        $byusr="";
      }else{
        $unick = getnick_uid($item[3]);
        $ulnk = "<a href=\"index.php?action=viewuser&amp;who=$item[3]\">$unick</a>";
        $byusr = "<br/>By: $ulnk";
      }
      echo "$lnk $delnk<br/>";


    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"downloads.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"downloads.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page: <input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"downloads.php?type=send\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"who\" value=\"$who\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    if($uid==$who && getplusses($uid)>25)
    {
    echo "<a href=\"up.php?action=themes\">";
echo "Add Item</a><br/>";
}
if($who!="")
{
echo "<a href=\"index.php?action=viewuser&amp;who=$who\">";
$whonick = getnick_uid($who);
echo "$whonick's Profile</a><br/>";
}else{
echo "<a href=\"index.php?action=vault\">";
echo "Downloads</a><br/>";
}
    echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";
   
   exit();
    }


//////////////////////////////////Buddies

else if($action=="radio")
{$pstyle = gettheme($sid);
    echo xhtmlhead("Java",$pstyle);
    $who = $_GET["who"];
    addonline(getuid_sid($sid),"Java Application","");
  
    $uid = getuid_sid($sid);



    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    if($did="2")
    {
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE did='2'"));
    }else{
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE uid='".$who."'"));
    }
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;


    if($who!="")
    {
        $sql = "SELECT id, title, itemurl, did FROM dcroxx_me_vault WHERE uid='".$who."' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }else{
      $sql = "SELECT id, title, itemurl, uid, did FROM dcroxx_me_vault WHERE did='".$did."' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }



    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $ext = getext($item[2]);
        $ime = getextimg($ext);
        $lnk = "<a href=\"downloads.php?action=download&amp;did=$item[0]\">$ime".htmlspecialchars($item[2])."</a>";

      if(candelvl($uid, $item[0]))
      {
        $delnk = "<a href=\"genproc.php?action=delvlt&amp;did=$item[0]\">[x]</a>";
      }else{
        $delnk = "";
      }
      if($who!="")
      {
        $byusr="";
      }else{
        $unick = getnick_uid($item[3]);
        $ulnk = "<a href=\"index.php?action=viewuser&amp;who=$item[3]\">$unick</a>";
        $byusr = "<br/>By: $ulnk";
      }
      echo "$lnk $delnk<br/>";


    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"downloads.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"downloads.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page: <input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"downloads.php?type=send\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"who\" value=\"$who\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    if($uid==$who && getplusses($uid)>25)
    {
    echo "<a href=\"up.php?action=themes\">";
echo "Add Item</a><br/>";
}
if($who!="")
{
echo "<a href=\"index.php?action=viewuser&amp;who=$who\">";
$whonick = getnick_uid($who);
echo "$whonick's Profile</a><br/>";
}else{
echo "<a href=\"index.php?action=vault\">";
echo "Downloads</a><br/>";
}
    echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";
 
   exit();
    }


//////////////////////////////////Buddies

else if($action=="video")
{$pstyle = gettheme($sid);
    echo xhtmlhead("Virus",$pstyle);
    $who = $_GET["who"];
    addonline(getuid_sid($sid),"Anti Vitus","");
   
    $uid = getuid_sid($sid);



    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    if($did="3")
    {
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE did='3'"));
    }else{
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE uid='".$who."'"));
    }
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;


    if($who!="")
    {
        $sql = "SELECT id, title, itemurl, did FROM dcroxx_me_vault WHERE uid='".$who."' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }else{
      $sql = "SELECT id, title, itemurl, uid, did FROM dcroxx_me_vault WHERE did='".$did."' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }



    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $ext = getext($item[2]);
        $ime = getextimg($ext);
        $lnk = "<a href=\"downloads.php?action=download&amp;did=$item[0]\">$ime".htmlspecialchars($item[2])."</a>";

      if(candelvl($uid, $item[0]))
      {
        $delnk = "<a href=\"genproc.php?action=delvlt&amp;did=$item[0]\">[x]</a>";
      }else{
        $delnk = "";
      }
      if($who!="")
      {
        $byusr="";
      }else{
        $unick = getnick_uid($item[3]);
        $ulnk = "<a href=\"index.php?action=viewuser&amp;who=$item[3]\">$unick</a>";
        $byusr = "<br/>By: $ulnk";
      }
      echo "$lnk $delnk<br/>";


    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"downloads.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"downloads.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page: <input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"downloads.php?type=send\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"who\" value=\"$who\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    if($uid==$who && getplusses($uid)>25)
    {
    echo "<a href=\"up.php?action=themes\">";
echo "Add Item</a><br/>";
}
if($who!="")
{
echo "<a href=\"index.php?action=viewuser&amp;who=$who\">";
$whonick = getnick_uid($who);
echo "$whonick's Profile</a><br/>";
}else{
echo "<a href=\"index.php?action=vault\">";
echo "Downloads</a><br/>";
}
    echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";
  
   exit();
    }


//////////////////////////////////Buddies

else if($action=="themes")
{$pstyle = gettheme($sid);
    echo xhtmlhead("Themes",$pstyle);
    $who = $_GET["who"];
    addonline(getuid_sid($sid),"s40v2/s40v3 Themes","");
   
    $uid = getuid_sid($sid);



    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    if($did="4")
    {
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE did='4'"));
    }else{
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE uid='".$who."'"));
    }
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;


    if($who!="")
    {
        $sql = "SELECT id, title, itemurl, did FROM dcroxx_me_vault WHERE uid='".$who."' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }else{
      $sql = "SELECT id, title, itemurl, uid, did FROM dcroxx_me_vault WHERE did='".$did."' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }



    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $ext = getext($item[2]);
        $ime = getextimg($ext);
        $lnk = "<a href=\"downloads.php?action=download&amp;did=$item[0]\">$ime".htmlspecialchars($item[2])."</a>";

      if(candelvl($uid, $item[0]))
      {
        $delnk = "<a href=\"genproc.php?action=delvlt&amp;did=$item[0]\">[x]</a>";
      }else{
        $delnk = "";
      }
      if($who!="")
      {
        $byusr="";
      }else{
        $unick = getnick_uid($item[3]);
        $ulnk = "<a href=\"index.php?action=viewuser&amp;who=$item[3]\">$unick</a>";
        $byusr = "<br/>By: $ulnk";
      }
      echo "$lnk $delnk<br/>";


    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"downloads.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"downloads.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page: <input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"downloads.php?type=send\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"who\" value=\"$who\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    if($uid==$who && getplusses($uid)>25)
    {
    echo "<a href=\"up.php?action=themes\">";
echo "Add Item</a><br/>";
}
if($who!="")
{
echo "<a href=\"index.php?action=viewuser&amp;who=$who\">";
$whonick = getnick_uid($who);
echo "$whonick's Profile</a><br/>";
}else{
echo "<a href=\"index.php?action=vault\">";
echo "Downloads</a><br/>";
}
    echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";
 
   exit();
    }

//////////////////////////////////Buddies

else if($action=="photo")
{$pstyle = gettheme($sid);
    echo xhtmlhead("Themes",$pstyle);
    $who = $_GET["who"];
    addonline(getuid_sid($sid),"s60/s60v3/Nseries-Themes","");
  
    $uid = getuid_sid($sid);



    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    if($did="5")
    {
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE did='5'"));
    }else{
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE uid='".$who."'"));
    }
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;


    if($who!="")
    {
        $sql = "SELECT id, title, itemurl, did FROM dcroxx_me_vault WHERE uid='".$who."' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }else{
      $sql = "SELECT id, title, itemurl, uid, did FROM dcroxx_me_vault WHERE did='".$did."' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }



    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $ext = getext($item[2]);
        $ime = getextimg($ext);
        $lnk = "<a href=\"downloads.php?action=download&amp;did=$item[0]\">$ime".htmlspecialchars($item[2])."</a>";

      if(candelvl($uid, $item[0]))
      {
        $delnk = "<a href=\"genproc.php?action=delvlt&amp;did=$item[0]\">[x]</a>";
      }else{
        $delnk = "";
      }
      if($who!="")
      {
        $byusr="";
      }else{
        $unick = getnick_uid($item[3]);
        $ulnk = "<a href=\"index.php?action=viewuser&amp;who=$item[3]\">$unick</a>";
        $byusr = "<br/>By: $ulnk";
      }
      echo "$lnk $delnk<br/>";


    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"downloads.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"downloads.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page: <input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"downloads.php?type=send\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"who\" value=\"$who\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    if($uid==$who && getplusses($uid)>25)
    {
    echo "<a href=\"up.php?action=themes\">";
echo "Add Item</a><br/>";
}
if($who!="")
{
echo "<a href=\"index.php?action=viewuser&amp;who=$who\">";
$whonick = getnick_uid($who);
echo "$whonick's Profile</a><br/>";
}else{
echo "<a href=\"index.php?action=vault\">";
echo "Downloads</a><br/>";
}
    echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";
   
   exit();
    }


//////////////////////////////////Buddies

else if($action=="tone")
{$pstyle = gettheme($sid);
    echo xhtmlhead("Theme",$pstyle);
    $who = $_GET["who"];
    addonline(getuid_sid($sid),"SE Themes","");
    echo "<card id=\"main\" title=\"SE Themes\">";
    $uid = getuid_sid($sid);



    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    if($did="6")
    {
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE did='6'"));
    }else{
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE uid='".$who."'"));
    }
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    if($who="")
    {
        $sql = "SELECT id, title, itemurl, did FROM dcroxx_me_vault WHERE uid='".$who."' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }else{
$sql = "SELECT id, title, itemurl, uid, did FROM dcroxx_me_vault WHERE did='".$did."' ORDER BY did DESC LIMIT $limit_start, $items_per_page";
        }


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $ext = getext($item[2]);
        $ime = getextimg($ext);
        $lnk = "<a href=\"downloads.php?action=download&amp;did=$item[0]\">$ime".htmlspecialchars($item[2])."</a>";

      if(candelvl($uid, $item[0]))
      {
        $delnk = "<a href=\"genproc.php?action=delvlt&amp;did=$item[0]\">[x]</a>";
      }else{
        $delnk = "";
      }
      if($who!="")
      {
        $byusr="";
      }else{
        $unick = getnick_uid($item[3]);
        $ulnk = "<a href=\"index.php?action=viewuser&amp;who=$item[3]\">$unick</a>";
        $byusr = "<br/>By: $ulnk";
      }
      echo "$lnk $delnk<br/>";


    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"downloads.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"downloads.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page: <input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"downloads.php?type=send\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"who\" value=\"$who\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    if($uid==$who && getplusses($uid)>25)
    {
    echo "<a href=\"up.php?action=apps\">";
echo "Add Item</a><br/>";
}
if($who!="")
{
echo "<a href=\"index.php?action=viewuser&amp;who=$who\">";
$whonick = getnick_uid($who);
echo "$whonick's Profile</a><br/>";
}else{
echo "<a href=\"index.php?action=vault\">";
echo "Downloads</a><br/>";
}
    echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";
 
   exit();
    }


//////////////////////////////////Buddies

else if($action=="games1")
{$pstyle = gettheme($sid);
    echo xhtmlhead("Games",$pstyle);
    $who = $_GET["who"];
    addonline(getuid_sid($sid),"s30/s40/s40v2 Games","");
   
    $uid = getuid_sid($sid);



    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    if($did="7")
    {
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE did='7'"));
    }else{
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE uid='".$who."'"));
    }
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    if($who!="")
    {
        $sql = "SELECT id, title, itemurl, did FROM dcroxx_me_vault WHERE uid='".$who."' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }else{
$sql = "SELECT id, title, itemurl, uid, did FROM dcroxx_me_vault WHERE did='".$did."' ORDER BY did DESC LIMIT $limit_start, $items_per_page";
        }


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $ext = getext($item[2]);
        $ime = getextimg($ext);
        $lnk = "<a href=\"downloads.php?action=download&amp;did=$item[0]\">$ime".htmlspecialchars($item[2])."</a>";

      if(candelvl($uid, $item[0]))
      {
        $delnk = "<a href=\"genproc.php?action=delvlt&amp;did=$item[0]\">[x]</a>";
      }else{
        $delnk = "";
      }
      if($who!="")
      {
        $byusr="";
      }else{
        $unick = getnick_uid($item[3]);
        $ulnk = "<a href=\"index.php?action=viewuser&amp;who=$item[3]\">$unick</a>";
        $byusr = "<br/>By: $ulnk";
      }
      echo "$lnk $delnk<br/>";


    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"downloads.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"downloads.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page: <input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"downloads.php?type=send\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"who\" value=\"$who\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    if($uid==$who && getplusses($uid)>25)
    {
    echo "<a href=\"up.php?action=games1\">";
echo "Add Item</a><br/>";
}
if($who!="")
{
echo "<a href=\"index.php?action=viewuser&amp;who=$who\">";
$whonick = getnick_uid($who);
echo "$whonick's Profile</a><br/>";
}else{
echo "<a href=\"index.php?action=vault\">";
echo "Downloads</a><br/>";
}
    echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";
  
   exit();
    }

//////////////////////////////////Buddies

else if($action=="games2")
{$pstyle = gettheme($sid);
    echo xhtmlhead("Games",$pstyle);
    $who = $_GET["who"];
    addonline(getuid_sid($sid),"s60/s60v3 Games","");
  
    $uid = getuid_sid($sid);



    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    if($did="8")
    {
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE did='8'"));
    }else{
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE uid='".$who."'"));
    }
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    if($who!="")
    {
        $sql = "SELECT id, title, itemurl, did FROM dcroxx_me_vault WHERE uid='".$who."' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }else{
$sql = "SELECT id, title, itemurl, uid, did FROM dcroxx_me_vault WHERE did='".$did."' ORDER BY did DESC LIMIT $limit_start, $items_per_page";
        }


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $ext = getext($item[2]);
        $ime = getextimg($ext);
        $lnk = "<a href=\"downloads.php?action=download&amp;did=$item[0]\">$ime".htmlspecialchars($item[2])."</a>";

      if(candelvl($uid, $item[0]))
      {
        $delnk = "<a href=\"genproc.php?action=delvlt&amp;did=$item[0]\">[x]</a>";
      }else{
        $delnk = "";
      }
      if($who!="")
      {
        $byusr="";
      }else{
        $unick = getnick_uid($item[3]);
        $ulnk = "<a href=\"index.php?action=viewuser&amp;who=$item[3]\">$unick</a>";
        $byusr = "<br/>By: $ulnk";
      }
      echo "$lnk $delnk<br/>";


    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"downloads.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"downloads.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page: <input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"downloads.php?type=send\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"who\" value=\"$who\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    if($uid==$who && getplusses($uid)>25)
    {
    echo "<a href=\"up.php?action=games2\">";
echo "Add Item</a><br/>";
}
if($who!="")
{
echo "<a href=\"index.php?action=viewuser&amp;who=$who\">";
$whonick = getnick_uid($who);
echo "$whonick's Profile</a><br/>";
}else{
echo "<a href=\"index.php?action=vault\">";
echo "Downloads</a><br/>";
}
    echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";

   exit();
    }

//////////////////////////////////Buddies

else if($action=="games3")
{$pstyle = gettheme($sid);
    echo xhtmlhead("Games",$pstyle);
    $who = $_GET["who"];
    addonline(getuid_sid($sid),"Eseries/Ngage/Nseries Games","");
 
    $uid = getuid_sid($sid);



    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    if($did="9")
    {
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE did='9'"));
    }else{
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE uid='".$who."'"));
    }
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    if($who!="")
    {
        $sql = "SELECT id, title, itemurl, did FROM dcroxx_me_vault WHERE uid='".$who."' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }else{
$sql = "SELECT id, title, itemurl, uid, did FROM dcroxx_me_vault WHERE did='".$did."' ORDER BY did DESC LIMIT $limit_start, $items_per_page";
        }


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $ext = getext($item[2]);
        $ime = getextimg($ext);
        $lnk = "<a href=\"downloads.php?action=download&amp;did=$item[0]\">$ime".htmlspecialchars($item[2])."</a>";

      if(candelvl($uid, $item[0]))
      {
        $delnk = "<a href=\"genproc.php?action=delvlt&amp;did=$item[0]\">[x]</a>";
      }else{
        $delnk = "";
      }
      if($who!="")
      {
        $byusr="";
      }else{
        $unick = getnick_uid($item[3]);
        $ulnk = "<a href=\"index.php?action=viewuser&amp;who=$item[3]\">$unick</a>";
        $byusr = "<br/>By: $ulnk";
      }
      echo "$lnk $delnk<br/>";


    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"downloads.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"downloads.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page: <input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"downloads.php?type=send\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"who\" value=\"$who\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    if($uid==$who && getplusses($uid)>25)
    {
    echo "<a href=\"up.php?action=videos\">";
echo "Add Item</a><br/>";
}
if($who!="")
{
echo "<a href=\"index.php?action=viewuser&amp;who=$who\">";
$whonick = getnick_uid($who);
echo "$whonick's Profile</a><br/>";
}else{
echo "<a href=\"index.php?action=vault\">";
echo "Downloads</a><br/>";
}
    echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";
  
   exit();
    }

//////////////////////////////////Buddies

else if($action=="segames")
{$pstyle = gettheme($sid);
    echo xhtmlhead("Games",$pstyle);
    $who = $_GET["who"];
    addonline(getuid_sid($sid),"SE Games","");
   
    $uid = getuid_sid($sid);



    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    if($did="10")
    {
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE did='10'"));
    }else{
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE uid='".$who."'"));
    }
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    if($who!="")
    {
        $sql = "SELECT id, title, itemurl, did FROM dcroxx_me_vault WHERE uid='".$who."' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }else{
$sql = "SELECT id, title, itemurl, uid, did FROM dcroxx_me_vault WHERE did='".$did."' ORDER BY did DESC LIMIT $limit_start, $items_per_page";
        }


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $ext = getext($item[2]);
        $ime = getextimg($ext);
        $lnk = "<a href=\"downloads.php?action=download&amp;did=$item[0]\">$ime".htmlspecialchars($item[2])."</a>";

      if(candelvl($uid, $item[0]))
      {
        $delnk = "<a href=\"genproc.php?action=delvlt&amp;did=$item[0]\">[x]</a>";
      }else{
        $delnk = "";
      }
      if($who!="")
      {
        $byusr="";
      }else{
        $unick = getnick_uid($item[3]);
        $ulnk = "<a href=\"index.php?action=viewuser&amp;who=$item[3]\">$unick</a>";
        $byusr = "<br/>By: $ulnk";
      }
      echo "$lnk $delnk<br/>";


    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"downloads.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"downloads.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page: <input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"downloads.php?type=send\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"who\" value=\"$who\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    if($uid==$who && getplusses($uid)>25)
    {
    echo "<a href=\"up.php?action=audio\">";
echo "Add Item</a><br/>";
}
if($who!="")
{
echo "<a href=\"index.php?action=viewuser&amp;who=$who\">";
$whonick = getnick_uid($who);
echo "$whonick's Profile</a><br/>";
}else{
echo "<a href=\"index.php?action=vault\">";
echo "Downloads</a><br/>";
}
    echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";
  
   exit();
    }

//////////////////////////////////Buddies

else if($action=="download")
{$pstyle = gettheme($sid);
    echo xhtmlhead("Download",$pstyle);
    $did = $_GET["did"];
 $uid = getuid_sid($sid);
    addonline(getuid_sid($sid),"Downloading..","");
 
echo "<p align=\"left\">";
    $uid = getuid_sid($sid);
$item = mysql_fetch_array(mysql_query("SELECT id, title, itemurl, uid, did, downloads, pudt, filesize, mime, info FROM dcroxx_me_vault WHERE id='".$did."'"));

       $name = "Name: $item[1]";
//$desc= "Description: $item[9]";
 $downloads = "Download Times: $item[5]";
        $filesize = "File Size: $item[7]";
 $mime = "File Type: $item[8]";
$tmstamp = $item[6];
  $tmdt = date("l jS M Y @ h:i:s", $tmstamp);
$earns2 = "Download Cost: 5 plusses";


        $dateadded1 = "Date Added: $dateadded";

    if($who!="")
      {
        $byusr="";
      }else{
        $unick = getnick_uid($item[3]);
        $ulnk = "<a href=\"index.php?action=viewuser&amp;who=$item[3]\">$unick</a>";

      }
       echo "$name<br/>$filesize<br/>$mime<br/>Date Uploaded: $tmdt<br/>$downloads<br/>Uploaded by by: $ulnk<br/>";
      echo "----<br/><a href=\"getnow.php?did=$item[0]\">Download now!</a><br/>";

  if(candelvl($uid, $item[0]))
      {
        $delnk = "<a href=\"genproc.php?action=delvlt&amp;did=$item[0]\">Delete</a><br/>";
      }else{
        $delnk = "";
      }
echo "$delnk";
echo "<a href=\"index.php?action=vault\">";
echo "Downloads</a><br/>";
    echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";

  echo "</p>";
      exit();
    }

?>

</HTML>

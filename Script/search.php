<?php
    session_name("PHPSESSID");
session_start();

//>> &#187;
//<< &#171;
header("Content-type: text/vnd.wap.wml");
header("Cache-Control: no-store, no-cache, must-revalidate");
echo("<?xml version=\"1.0\"?>");
echo "<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\"". " \"http://www.wapforum.org/DTD/wml_1.1.xml\"><meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";
?>

<wml>
<?php
include("config.php");
include("core.php");
connectdb();

$action = $_GET["action"];
$sid = $_SESSION['sid'];
$page = $_GET["page"];

    if(islogged($sid)==false)
    {
      echo "<card id=\"main\" title=\"$stitle\">";
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      echo "</card>";
      echo "</wml>";
      exit();
    }

if(isbanned($uid))
    {
        echo "<card id=\"main\" title=\"$stitle\">";
      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "You are <b>Banned</b><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto FROM dcroxx_me_metpenaltiespl WHERE uid='".$uid."' AND penalty='1'"));
      $remain = $banto[0]- (time() - $timeadjust);
      $rmsg = gettimemsg($remain);
      echo "Time to finish your penalty: $rmsg<br/><br/>";
      //echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      echo "</card>";
      echo "</wml>";
      exit();
    }
if($action=="tpc")
{
    addonline(getuid_sid($sid),"Topics search","");
    echo "<card id=\"main\" title=\"Search\">";
    echo "<p>";
    echo "Text: <input name=\"stext\" maxlength=\"30\"/><br/>";
    echo "In: <select name=\"sin\">";
    echo "<option value=\"1\">Topic Posts</option>";
    echo "<option value=\"2\">Topic Text</option>";
    echo "<option value=\"3\">Topic Name</option>";
    echo "</select><br/>";
    echo "Order: <select name=\"sor\">";
    echo "<option value=\"1\">Newest First</option>";
    echo "<option value=\"2\">Oldest First</option>";
    echo "</select><br/>";
    echo "<anchor>Find It";
    echo "<go href=\"search.php?action=stpc\" method=\"post\">";
    echo "<postfield name=\"stext\" value=\"$(stext)\"/>";
    echo "<postfield name=\"sin\" value=\"$(sin)\"/>";
    echo "<postfield name=\"sor\" value=\"$(sor)\"/>";
    echo "</go></anchor>";
    echo "</p>";
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=search\"><img src=\"images/search.gif\" alt=\"*\"/>";
echo "Search Menu</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
    exit();
    }
//////////////////////////////////
else if($action=="blg")
{
    addonline(getuid_sid($sid),"Blogs search","");
    echo "<card id=\"main\" title=\"Search\">";
    echo "<p>";
    echo "Text: <input name=\"stext\" maxlength=\"30\"/><br/>";
    echo "In: <select name=\"sin\">";
    echo "<option value=\"1\">Blog Text</option>";
    echo "<option value=\"2\">Blog Name</option>";
    echo "</select><br/>";
    echo "Order: <select name=\"sor\">";
    echo "<option value=\"1\">Blog Name</option>";
    echo "<option value=\"2\">Time</option>";
    echo "</select><br/>";
    echo "<anchor>Find It";
    echo "<go href=\"search.php?action=sblg\" method=\"post\">";
    echo "<postfield name=\"stext\" value=\"$(stext)\"/>";
    echo "<postfield name=\"sin\" value=\"$(sin)\"/>";
    echo "<postfield name=\"sor\" value=\"$(sor)\"/>";
    echo "</go></anchor>";
    echo "</p>";
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=search\"><img src=\"images/search.gif\" alt=\"*\"/>";
echo "Search Menu</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
    exit();
    }
//////////////////////////////////
else if($action=="clb")
{
    addonline(getuid_sid($sid),"Clubs search","");
    echo "<card id=\"main\" title=\"Search\">";
    echo "<p>";
    echo "Text: <input name=\"stext\" maxlength=\"30\"/><br/>";
    echo "In: <select name=\"sin\">";
    echo "<option value=\"1\">Club Description</option>";
    echo "<option value=\"2\">Club Name</option>";
    echo "</select><br/>";
    echo "Order: <select name=\"sor\">";
    echo "<option value=\"1\">Club Name</option>";
    echo "<option value=\"2\">Oldest</option>";
    echo "<option value=\"3\">Newest</option>";
    echo "</select><br/>";
    echo "<anchor>Find It";
    echo "<go href=\"search.php?action=sclb\" method=\"post\">";
    echo "<postfield name=\"stext\" value=\"$(stext)\"/>";
    echo "<postfield name=\"sin\" value=\"$(sin)\"/>";
    echo "<postfield name=\"sor\" value=\"$(sor)\"/>";
    echo "</go></anchor>";
    echo "</p>";
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=search\"><img src=\"images/search.gif\" alt=\"*\"/>";
echo "Search Menu</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
    exit();
    }
//////////////////////////////////
else if($action=="nbx")
{
    addonline(getuid_sid($sid),"Inbox search","");
    echo "<card id=\"main\" title=\"Search\">";
    echo "<p>";
    echo "Text: <input name=\"stext\" maxlength=\"30\"/><br/>";
    echo "In: <select name=\"sin\">";
    echo "<option value=\"1\">Recieved Messages</option>";
	echo "<option value=\"2\">Sent Messages</option>";
    echo "<option value=\"3\">Sender Name</option>";
    echo "</select><br/>";
    echo "Order: <select name=\"sor\">";
    echo "<option value=\"1\">Newest PMs</option>";
    echo "<option value=\"2\">Oldest PMs</option>";
    echo "<option value=\"2\">Sender Name</option>";
    echo "</select><br/>";
    echo "<anchor>Find It";
    echo "<go href=\"search.php?action=snbx\" method=\"post\">";
    echo "<postfield name=\"stext\" value=\"$(stext)\"/>";
    echo "<postfield name=\"sin\" value=\"$(sin)\"/>";
    echo "<postfield name=\"sor\" value=\"$(sor)\"/>";
    echo "</go></anchor>";
    echo "</p>";
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=search\"><img src=\"images/search.gif\" alt=\"*\"/>";
echo "Search Menu</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
    exit();
    }
//////////////////////////////////
else if($action=="mbrn")
{
    addonline(getuid_sid($sid),"Members search","");
    echo "<card id=\"main\" title=\"Search\">";
    echo "<p>";
    echo "Nickname: <input name=\"stext\" maxlength=\"15\"/><br/>";
    echo "Order: <select name=\"sor\">";
    echo "<option value=\"1\">Member Name</option>";
    echo "<option value=\"2\">Last Active</option>";
    echo "<option value=\"3\">Join Date</option>";
    echo "</select><br/>";
    echo "<anchor>Find It";
    echo "<go href=\"search.php?action=smbr\" method=\"post\">";
    echo "<postfield name=\"stext\" value=\"$(stext)\"/>";
    echo "<postfield name=\"sin\" value=\"1\"/>";
    echo "<postfield name=\"sor\" value=\"$(sor)\"/>";
    echo "</go></anchor>";
    echo "</p>";
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=search\"><img src=\"images/search.gif\" alt=\"*\"/>";
echo "Search Menu</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
    exit();
    }
//////////////////////////////////
else if($action=="stpc")
{
  $stext = $_POST["stext"];
  $sin = $_POST["sin"];
  $sor = $_POST["sor"];
    addonline(getuid_sid($sid),"Topics search","");
    echo "<card id=\"main\" title=\"Search\">";
    echo "<p>";

        if(trim($stext)=="")
        {
            echo "<br/>Please Specify the text to search for";
        }else{
          //begin search
          if($page=="" || $page<1)$page=1;
          if($sin=="1")
          {
            $where_table = "dcroxx_me_posts";
            $cond = "text";
            $select_fields = "id, tid";
            if($sor=="1")
            {
              $ord_fields = "dtpost DESC";
            }else{
                $ord_fields = "dtpost";
            }
          }else if($sin=="2")
          {
            $where_table = "dcroxx_me_topics";
            $cond = "text";
            $select_fields = "name, id";
            if($sor=="1")
            {
              $ord_fields = "crdate DESC";
            }else{
                $ord_fields = "crdate";
            }
          }else if($sin=="3")
          {
            $where_table = "dcroxx_me_topics";
            $cond = "name";
            $select_fields = "name, id";
            if($sor=="1")
            {
              $ord_fields = "crdate DESC";
            }else{
                $ord_fields = "crdate";
            }
          }
          $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ".$where_table." WHERE ".$cond." LIKE '%".$stext."%'"));
          $num_items = $noi[0];
          $items_per_page = 10;
          $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    
    $sql = "SELECT ".$select_fields." FROM ".$where_table." WHERE ".$cond." LIKE '%".$stext."%' ORDER BY ".$ord_fields." LIMIT $limit_start, $items_per_page";
          $items = mysql_query($sql);
          while($item=mysql_fetch_array($items))
          {
            if($sin=="1")
            {
              $tname = htmlspecialchars(gettname($item[1]));
			  
              if($tname=="" || !canaccess(getuid_sid($sid),getfid_tid($item[1]))){
                $tlink = "Unreachable<br/>";
              }else{
              $tlink = "<a href=\"index.php?action=viewtpc&amp;tid=$item[1]&amp;go=$item[0]\">".$tname."</a><br/>";
              }
                echo  $tlink;
            }
            else
            {
              $tname = htmlspecialchars($item[0]);
              if($tname=="" || !canaccess(getuid_sid($sid),getfid_tid($item[1]))){
                $tlink = "Unreachable<br/>";
              }else{
              $tlink = "<a href=\"index.php?action=viewtpc&amp;tid=$item[1]\">".$tname."</a><br/>";
              }
                echo  $tlink;
            }
          }
          echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
        $rets = "<anchor>&#171;PREV";
        $rets .= "<go href=\"search.php?action=$action&amp;page=$ppage\" method=\"post\">";
        $rets .= "<postfield name=\"stext\" value=\"$stext\"/>";
        $rets .= "<postfield name=\"sin\" value=\"$sin\"/>";
        $rets .= "<postfield name=\"sor\" value=\"$sor\"/>";
        $rets .= "</go></anchor> ";

        echo $rets;
      
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
	  $rets = "<anchor>Next&#187;";
        $rets .= "<go href=\"search.php?action=$action&amp;page=$npage\" method=\"post\">";
        $rets .= "<postfield name=\"stext\" value=\"$stext\"/>";
        $rets .= "<postfield name=\"sin\" value=\"$sin\"/>";
        $rets .= "<postfield name=\"sor\" value=\"$sor\"/>";
        $rets .= "</go></anchor> ";

        echo $rets;
      
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"search.php?action=$action&amp;page=$(pg)\" method=\"post\">";
        $rets .= "<postfield name=\"stext\" value=\"$stext\"/>";
        $rets .= "<postfield name=\"sin\" value=\"$sin\"/>";
        $rets .= "<postfield name=\"sor\" value=\"$sor\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
        }
    
echo "</p>";
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=search\"><img src=\"images/search.gif\" alt=\"*\"/>";
echo "Search Menu</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
    exit();
    }
//////////////////////////////////
else if($action=="sblg")
{
  $stext = $_POST["stext"];
  $sin = $_POST["sin"];
  $sor = $_POST["sor"];
    addonline(getuid_sid($sid),"Blogs search","");
    echo "<card id=\"main\" title=\"Search\">";
    echo "<p>";

    
    
        if(trim($stext)=="")
        {
            echo "<br/>Failed to search for blogs";
        }else{
          //begin search
          if($page=="" || $page<1)$page=1;
          if($sin=="1")
          {
            $where_table = "dcroxx_me_blogs";
            $cond = "btext";
            $select_fields = "id, bname";
            if($sor=="1")
            {
              $ord_fields = "bname";
            }else{
                $ord_fields = "bgdate DESC";
            }
          }else if($sin=="2")
          {
            $where_table = "dcroxx_me_blogs";
            $cond = "bname";
            $select_fields = "id, bname";
            if($sor=="1")
            {
              $ord_fields = "bname";
            }else{
                $ord_fields = "bgdate DESC";
            }
          }
          $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ".$where_table." WHERE ".$cond." LIKE '%".$stext."%'"));
          $num_items = $noi[0];
          $items_per_page = 10;
          $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    $sql = "SELECT ".$select_fields." FROM ".$where_table." WHERE ".$cond." LIKE '%".$stext."%' ORDER BY ".$ord_fields." LIMIT $limit_start, $items_per_page";
          $items = mysql_query($sql);
          while($item=mysql_fetch_array($items))
          {
              $tlink = "<a href=\"index.php?action=viewblog&amp;bid=$item[0]&amp;go=$item[0]\">".htmlspecialchars($item[1])."</a><br/>";

                echo  $tlink;
            
          }
          echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      $rets = "<anchor>&#171;PREV";
        $rets .= "<go href=\"search.php?action=$action&amp;page=$ppage\" method=\"post\">";
        $rets .= "<postfield name=\"stext\" value=\"$stext\"/>";
        $rets .= "<postfield name=\"sin\" value=\"$sin\"/>";
        $rets .= "<postfield name=\"sor\" value=\"$sor\"/>";
        $rets .= "</go></anchor> ";

        echo $rets;
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      $rets = "<anchor>Next&#187;";
        $rets .= "<go href=\"search.php?action=$action&amp;page=$npage\" method=\"post\">";
        $rets .= "<postfield name=\"stext\" value=\"$stext\"/>";
        $rets .= "<postfield name=\"sin\" value=\"$sin\"/>";
        $rets .= "<postfield name=\"sor\" value=\"$sor\"/>";
        $rets .= "</go></anchor> ";

        echo $rets;
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"search.php?action=$action&amp;page=$(pg)\" method=\"post\">";
        $rets .= "<postfield name=\"stext\" value=\"$stext\"/>";
        $rets .= "<postfield name=\"sin\" value=\"$sin\"/>";
        $rets .= "<postfield name=\"sor\" value=\"$sor\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
        }
    
echo "</p>";
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=search\"><img src=\"images/search.gif\" alt=\"*\"/>";
echo "Search Menu</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
    exit();
    }
//////////////////////////////////
else if($action=="sclb")
{
  $stext = $_POST["stext"];
  $sin = $_POST["sin"];
  $sor = $_POST["sor"];
    addonline(getuid_sid($sid),"Club search","");
    echo "<card id=\"main\" title=\"Search\">";
    echo "<p>";

    
        if(trim($stext)=="")
        {
            echo "<br/>Failed to search for club";
        }else{
          //begin search
          if($page=="" || $page<1)$page=1;
          if($sin=="1")
          {
            $where_table = "dcroxx_me_clubs";
            $cond = "description";
            $select_fields = "id, name";
            if($sor=="1")
            {
              $ord_fields = "name";
            }else if($sor=="2"){
                $ord_fields = "created";
            }else if($sor=="3"){
                $ord_fields = "created DESC";
            }
          }else if($sin=="2")
          {
            $where_table = "dcroxx_me_clubs";
            $cond = "name";
            $select_fields = "id, name";
            if($sor=="1")
            {
              $ord_fields = "name";
            }else if($sor=="2"){
                $ord_fields = "created";
            }else if($sor=="3"){
                $ord_fields = "created DESC";
            }
          }
          $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ".$where_table." WHERE ".$cond." LIKE '%".$stext."%'"));
          $num_items = $noi[0];
          $items_per_page = 10;
          $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    $sql = "SELECT ".$select_fields." FROM ".$where_table." WHERE ".$cond." LIKE '%".$stext."%' ORDER BY ".$ord_fields." LIMIT $limit_start, $items_per_page";
          $items = mysql_query($sql);
          while($item=mysql_fetch_array($items))
          {
              $tlink = "<a href=\"index.php?action=gocl&amp;clid=$item[0]&amp;go=$item[0]\">".htmlspecialchars($item[1])."</a><br/>";

                echo  $tlink;

          }
          echo "<p align=\"center\">";
		  if($page>1)
    {
      $ppage = $page-1;
      $rets = "<anchor>&#171;PREV";
        $rets .= "<go href=\"search.php?action=$action&amp;page=$ppage\" method=\"post\">";
        $rets .= "<postfield name=\"stext\" value=\"$stext\"/>";
        $rets .= "<postfield name=\"sin\" value=\"$sin\"/>";
        $rets .= "<postfield name=\"sor\" value=\"$sor\"/>";
        $rets .= "</go></anchor> ";

        echo $rets;
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      $rets = "<anchor>Next&#187;";
        $rets .= "<go href=\"search.php?action=$action&amp;page=$npage\" method=\"post\">";
        $rets .= "<postfield name=\"stext\" value=\"$stext\"/>";
        $rets .= "<postfield name=\"sin\" value=\"$sin\"/>";
        $rets .= "<postfield name=\"sor\" value=\"$sor\"/>";
        $rets .= "</go></anchor> ";

        echo $rets;
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"search.php?action=$action&amp;page=$(pg)\" method=\"post\">";
        $rets .= "<postfield name=\"stext\" value=\"$stext\"/>";
        $rets .= "<postfield name=\"sin\" value=\"$sin\"/>";
        $rets .= "<postfield name=\"sor\" value=\"$sor\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
        }
    
echo "</p>";
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=search\"><img src=\"images/search.gif\" alt=\"*\"/>";
echo "Search Menu</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
    exit();
    }
//////////////////////////////////

else if($action=="snbx")
{
  $stext = $_POST["stext"];
  $sin = $_POST["sin"];
  $sor = $_POST["sor"];
    addonline(getuid_sid($sid),"Inbox search","");
    echo "<card id=\"main\" title=\"Search\">";
    echo "<p>";

        $myid = getuid_sid($sid);
        if(trim($stext)=="")
        {
            echo "<br/>Failed to search for message";
        }else{
          //begin search
          if($page=="" || $page<1)$page=1;
          if($sin==1)
          {
          $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*)  FROM dcroxx_me_private  WHERE text LIKE '%".$stext."%' AND touid='".$myid."'"));
		  }else if($sin==2)
		  {
			$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*)  FROM dcroxx_me_private  WHERE text LIKE '%".$stext."%' AND byuid='".$myid."'"));
          }else{
                $stext = getuid_nick($stext);
            $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*)  FROM dcroxx_me_private  WHERE byuid ='".$stext."' AND touid='".$myid."'"));
          }
          $num_items = $noi[0];
          $items_per_page = 10;
          $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
          
          if($sin=="1")
          {
            /*
            $where_table = "dcroxx_me_blogs";
            $cond = "btext";
            $select_fields = "id, bname";*/
            
            if($sor=="1")
            {
              //$ord_fields = "bname";
              $sql = "SELECT
            a.name, b.id, b.byuid, b.unread, b.starred FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.byuid
            WHERE b.touid='".$myid."' AND b.text like '%".$stext."%'
            ORDER BY b.timesent DESC
            LIMIT $limit_start, $items_per_page";
            //echo $sql;
            }else if($sor=="2"){
                $sql = "SELECT
            a.name, b.id, b.byuid, b.unread, b.starred FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.byuid
            WHERE b.touid='".$myid."' AND b.text like '%".$stext."%'
            ORDER BY b.timesent 
            LIMIT $limit_start, $items_per_page";
            }else{
                $sql = "SELECT
            a.name, b.id, b.byuid, b.unread, b.starred FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.byuid
            WHERE b.touid='".$myid."' AND b.text like '%".$stext."%'
            ORDER BY a.name
            LIMIT $limit_start, $items_per_page";
            }
          }
		  else if($sin=="2")
		  {
			if($sor=="1")
            {
              //$ord_fields = "bname";
              $sql = "SELECT
            a.name, b.id, b.touid, b.unread, b.starred FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.byuid
            WHERE b.byuid='".$myid."' AND b.text like '%".$stext."%'
            ORDER BY b.timesent DESC
            LIMIT $limit_start, $items_per_page";
            //echo $sql;
            }else if($sor=="2"){
                $sql = "SELECT
            a.name, b.id, b.touid, b.unread, b.starred FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.byuid
            WHERE b.byuid='".$myid."' AND b.text like '%".$stext."%'
            ORDER BY b.timesent 
            LIMIT $limit_start, $items_per_page";
            }else{
                $sql = "SELECT
            a.name, b.id, b.touid, b.unread, b.starred FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.touid
            WHERE b.byuid='".$myid."' AND b.text like '%".$stext."%'
            ORDER BY a.name
            LIMIT $limit_start, $items_per_page";
            }
		  }
		  else if($sin=="3")
          {
            
            if($sor=="1")
            {
              //$ord_fields = "bname";
              $sql = "SELECT
            a.name, b.id, b.byuid, b.unread, b.starred FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.byuid
            WHERE b.touid='".$myid."' AND b.byuid ='".$stext."'
            ORDER BY b.timesent DESC
            LIMIT $limit_start, $items_per_page";
            }else if($sor=="2"){
                $sql = "SELECT
            a.name, b.id, b.byuid, b.unread, b.starred FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.byuid
            WHERE b.touid='".$myid."' AND b.byuid ='".$stext."'
            ORDER BY b.timesent
            LIMIT $limit_start, $items_per_page";
            }else{
                $sql = "SELECT
            a.name, b.id, b.byuid, b.unread, b.starred FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.byuid
            WHERE b.touid='".$myid."' AND b.byuid ='".$stext."'
            ORDER BY a.name
            LIMIT $limit_start, $items_per_page";
            }
          }
          

          $items = mysql_query($sql);
          echo mysql_error();
          while($item=mysql_fetch_array($items))
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

      $lnk = "<a href=\"inbox.php?action=readpm&amp;pmid=$item[1]\">$iml ".getnick_uid($item[2])."</a>";
      echo "$lnk<br/>";

          }
          echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      $rets = "<anchor>&#171;PREV";
        $rets .= "<go href=\"search.php?action=$action&amp;page=$ppage\" method=\"post\">";
        $rets .= "<postfield name=\"stext\" value=\"$stext\"/>";
        $rets .= "<postfield name=\"sin\" value=\"$sin\"/>";
        $rets .= "<postfield name=\"sor\" value=\"$sor\"/>";
        $rets .= "</go></anchor> ";

        echo $rets;
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      $rets = "<anchor>Next&#187;";
        $rets .= "<go href=\"search.php?action=$action&amp;page=$npage\" method=\"post\">";
        $rets .= "<postfield name=\"stext\" value=\"$stext\"/>";
        $rets .= "<postfield name=\"sin\" value=\"$sin\"/>";
        $rets .= "<postfield name=\"sor\" value=\"$sor\"/>";
        $rets .= "</go></anchor> ";

        echo $rets;
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"search.php?action=$action&amp;page=$(pg)\" method=\"post\">";
        $rets .= "<postfield name=\"stext\" value=\"$stext\"/>";
        $rets .= "<postfield name=\"sin\" value=\"$sin\"/>";
        $rets .= "<postfield name=\"sor\" value=\"$sor\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
        }
    
echo "</p>";
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=search\"><img src=\"images/search.gif\" alt=\"*\"/>";
echo "Search Menu</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
    exit();
    }
//////////////////////////////////

else if($action=="smbr")
{
	$stext = $_POST["stext"];
  $sin = $_POST["sin"];
  $sor = $_POST["sor"];
    addonline(getuid_sid($sid),"Club search","");
    echo "<card id=\"main\" title=\"Search\">";
    echo "<p>";

    
        if(trim($stext)=="")
        {
            echo "<br/>Failed to search for club";
        }else{
          //begin search
          if($page=="" || $page<1)$page=1;
          
            $where_table = "dcroxx_me_users";
            $cond = "name";
            $select_fields = "id, name";
            if($sor=="1")
            {
              $ord_fields = "name";
            }else if($sor=="2"){
                $ord_fields = "lastact DESC";
            }else if($sor=="3"){
                $ord_fields = "regdate";
            }
          
          $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ".$where_table." WHERE ".$cond." LIKE '%".$stext."%'"));
          $num_items = $noi[0];
          $items_per_page = 10;
          $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    $sql = "SELECT ".$select_fields." FROM ".$where_table." WHERE ".$cond." LIKE '%".$stext."%' ORDER BY ".$ord_fields." LIMIT $limit_start, $items_per_page";
          $items = mysql_query($sql);
          while($item=mysql_fetch_array($items))
          {
              $tlink = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">".htmlspecialchars($item[1])."</a><br/>";

                echo  $tlink;

          }
          echo "<p align=\"center\">";
		  if($page>1)
    {
      $ppage = $page-1;
      $rets = "<anchor>&#171;PREV";
        $rets .= "<go href=\"search.php?action=$action&amp;page=$ppage\" method=\"post\">";
        $rets .= "<postfield name=\"stext\" value=\"$stext\"/>";
        $rets .= "<postfield name=\"sin\" value=\"$sin\"/>";
        $rets .= "<postfield name=\"sor\" value=\"$sor\"/>";
        $rets .= "</go></anchor> ";

        echo $rets;
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      $rets = "<anchor>Next&#187;";
        $rets .= "<go href=\"search.php?action=$action&amp;page=$npage\" method=\"post\">";
        $rets .= "<postfield name=\"stext\" value=\"$stext\"/>";
        $rets .= "<postfield name=\"sin\" value=\"$sin\"/>";
        $rets .= "<postfield name=\"sor\" value=\"$sor\"/>";
        $rets .= "</go></anchor> ";

        echo $rets;
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"search.php?action=$action&amp;page=$(pg)\" method=\"post\">";
        $rets .= "<postfield name=\"stext\" value=\"$stext\"/>";
        $rets .= "<postfield name=\"sin\" value=\"$sin\"/>";
        $rets .= "<postfield name=\"sor\" value=\"$sor\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
        }
    
echo "</p>";
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=search\"><img src=\"images/search.gif\" alt=\"*\"/>";
echo "Search Menu</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
    exit();
    }
//////////////////////////////////
  

else{
  addonline(getuid_sid($sid),"Lost in search lol","");
    echo "<card id=\"main\" title=\"Search\">";
  echo "<p align=\"center\">";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
    exit();
    }

?></wml>

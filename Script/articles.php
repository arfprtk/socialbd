<?php
    session_name("PHPSESSID");
session_start();


header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\"\"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";

?>
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
<?php
include("config.php");
include("core.php");
include("xhtmlfunctions.php");
   echo "<head>";
echo "<title>Articles</title>";
   //echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
   echo "</head>";

   echo "<body>";
$bcon = connectdb();
if (!$bcon)
{
    echo "<p align=\"center\">";
      echo "sorry probably our database cant hold the system of our server.<br/>";
      echo "Please come back later<br/><br/>";
      echo "</p>";
    exit();
}
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$artid = $_GET["artid"];
$page = $_GET["page"];
$uid = getuid_sid($sid);
if($action != "")
{
    if(islogged($sid)==false)
    {

 echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      exit();

    }
}
if(isbanned($uid))
    {

      echo "<p align=\"center\">";
     echo "<img src=\"images/exit2.gif\" alt=\"*\"/><br/>";
      echo "You are <b>Banned</b><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto FROM dcroxx_me_penalties WHERE uid='".$uid."' AND penalty='1'"));
      $remain = $banto[0]- time();
      $rmsg = gettimemsg($remain);
      echo "Time to finish your penalty: $rmsg<br/><br/>";
      //echo "<a href=\"index.php\">Login</a>";
      echo "</p>";

      exit();
    }
if($action=="articles")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Article",$pstyle);
    addonline(getuid_sid($sid),"Articles","index.php?action=$action");
   echo "<head>";
   echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
     echo "<h2><center>Articles</center></h2>";
    echo "<p align=\"left\"><small>";


    echo "<a href=\"?action=newart\">New Article</a><br/>";
	
  $fcats = mysql_query("SELECT id, name FROM dcroxx_me_articles ORDER BY id");
  while($fcat=mysql_fetch_array($fcats))
  {
   $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_readart WHERE cid='".$fcat[0]."'"));
    $catlink = "&#x2022;  <a href=\"articles.php?action=cwart&amp;cid=$fcat[0]&amp;browse?\">$fcat[1]</a> ($noi[0])";
    echo "<br/>$catlink";

  }

    echo "<br/><br/><img src=\"images/home.gif\" alt=\"\"><a href=\"index.php?action=main&amp;browse?\">";
    echo "Home</a>";
    echo "</small></p>";
 echo "<p align=\"center\">";

 echo "</p>";

exit();
}

//////////////////////////////////////////////////ONLINE USERS
if(getplusses(getuid_sid($sid))<50)
    {
      echo "<head>";
      echo "<title>Articles</title>";
      echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
      echo "</head>";
      echo "<body>";
      echo "<p align=\"center\">";
      echo "You Need 50+s To Access Articles.!<br/><br/>";
      echo "<a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
}

/////////////////////////////////////////////
else if($action=="newart")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Article",$pstyle);
  $cid = $_GET["cid"];
 $artid = $_GET["artid"];
    addonline(getuid_sid($sid),"Making new article","index.php?action=$action&amp;fid=$fid");
  echo "<head>";

   echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
    echo "<p align=\"left\">";

echo "<form action=\"articles.php?action=done&amp;artid=$artid\" method=\"post\">";
echo "<small>Tittle:</small><br/> <input name=\"ntitle\" maxlength=\"60\"/><br/>";
echo "<small>Message:</small><br/> <input name=\"tpctxt\" maxlength=\"300\"/><br/>";
    echo "<input type=\"hidden\" name=\"cid\" value=\"$cid\"/>";
 echo "<input type=\"submit\" value=\"SUBMIT\"/>";
           echo "</form>";
echo "<br/><small><a href=\"articles.php?action=articles&amp;browse?\">";
    echo "Articles</a>";
    echo "<br/><img src=\"images/home.gif\" alt=\"\"><a href=\"index.php?action=main&amp;browse?\">Home</a></small>";

    echo "</p>";
exit();
}

///////////////////////////////////////////////////////ONLINE USERS
else if($action=="newart2")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Article",$pstyle);
$artid = $_GET["artid"];
 $cid = $_GET["cid"];
$id = $_GET["id"];
    addonline(getuid_sid($sid),"Making new article","index.php?action=$action&amp;fid=$fid");
    echo "<head>";

   echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
    echo "<p align=\"left\">";

echo "<form action=\"articles.php?action=done2&amp;artid=$artid&amp;cid=$cid&amp;id=$id\" method=\"post\">";
echo "<small>Message: </small><br/><input name=\"tpctxt\" maxlength=\"2000\"/><br/>";
    echo "<input type=\"hidden\" name=\"cid\" value=\"$cid\"/>";
 echo "<input type=\"submit\" value=\"SUBMIT\"/>";
           echo "</form>";
echo "<br/><small><a href=\"articles.php?action=articles&amp;browse?\">";
    echo "Articles</a>";
    echo "<br/><img src=\"images/home.gif\" alt=\"\"><a href=\"index.php?action=main&amp;browse?\">";
echo "Home</a></small>";

    echo "</p>";
exit();
}

////////////////////////////////////////////////////new tops
else if($action=="done")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Article",$pstyle);
  $artid = $_GET["artid"];
  $cid = $_POST["cid"];
  $ntitle = $_POST["ntitle"];
  $tpctxt = $_POST["tpctxt"];


  addonline(getuid_sid($sid),"Making New Article","index.php?action=main");
   echo "<head>";

   echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
      echo "<p align=\"center\"><small>";
      $crdate = time();
      $uid = getuid_sid($sid);
      $texst = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_readart WHERE name LIKE '".$ntitle."' AND cid='".$cid."'"));
      if($texst[0]==0)
      {
        $res = false;

  if((trim($ntitle)!="")||(trim($tpctxt)!=""))
      {
      $res = mysql_query("INSERT INTO dcroxx_me_readart SET name='".$ntitle."', cid='".$cid."', authorid='".$uid."', text='".$tpctxt."', crdate='".$crdate."'");
      }
       if($res)
      {
        $tnm = htmlspecialchars($ntitle);

        echo "Article <b>$tnm</b> Submitted Successfully<br/>";

     }else{
        echo "Article could not submit";
      }
      }else{
        echo "Article name Already submitted";
      }
echo "<br/><a href=\"articles.php?action=articles&amp;browse?\">";
    echo "Articles</a>";
echo "<br/>";


      echo "<br/><a href=\"index.php?action=main&amp;type=send&amp;browse?start\">";
echo "Home</a>";
      echo "</small></p>";
      echo "</card>";
exit();
}

/////////////////////////////////////////////////////////////////////////new tops
else if($action=="done2")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Article",$pstyle);
  $artid = $_GET["artid"];
  $cid = $_GET["cid"];
  $id = $_GET["id"];
  $tpctxt = $_POST["tpctxt"];

  addonline(getuid_sid($sid),"Making New Article","index.php?action=main");
   echo "<head>";

   echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
      echo "<p align=\"center\"><small>";
      $crdate = time();
      $uid = getuid_sid($sid);
      $res = mysql_query("INSERT INTO dcroxx_me_artpost SET artid='".$artid."', text='".$tpctxt."', crdate='".time()."'");
       if($res)
      {
        $tnm = htmlspecialchars($ntitle);
        echo "Article <b>$tnm</b> Submitted Successfully";
        $tid = mysql_fetch_array(mysql_query("SELECT id FROM dcroxx_me_topics WHERE name='".$ntitle."' AND fid='".$fid."'"));
        echo "<br/><br/><a href=\"articles.php?action=viewart&amp;artid=$artid&amp;cid=$cid&amp;id=$id&amp;go=last&amp;type=send&amp;browse?start\">";
      echo "Read Article</a>";
      }else{
        echo "Article could not submit";
      }
echo "<br/><a href=\"articles.php?action=articles&amp;browse?\">";
    echo "Articles</a>";
      echo "<br/>";

      echo "<br/><a href=\"index.php?action=main&amp;type=send&amp;browse?start\">";
echo "Home</a>";
      echo "</small></p>";
exit();
}

/////////////////////////////////////////////////////////Buddies

else if($action=="cwart")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Article",$pstyle);
$cid = $_GET["cid"];
    $cinfo = mysql_fetch_array(mysql_query("SELECT name from dcroxx_me_articles WHERE id='".$cid."'"));
    addonline(getuid_sid($sid),"Viewing article $cinfo[0]","index.php?action=$action&amp;cid=$cid");
   echo "<head>";
   echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
$cinfo = mysql_fetch_array(mysql_query("SELECT name from dcroxx_me_articles WHERE id='".$cid."'"));

   echo "<p align=\"left\"><small>";
 echo "<b>$cinfo[0]</b>";
$ibwf = mysql_fetch_array(mysql_query("SELECT COUNT(distinct id) FROM dcroxx_me_readart WHERE cid='".$cid."'"));
    if($page=="" || $page<=0)$page=1;
    $num_items = $ibwf[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

$cou = $limit_start+1;
////////////////////////////////////////


$ibwfsites = mysql_query("SELECT id, name, crdate FROM dcroxx_me_readart WHERE cid='".$cid."'  ORDER BY cid, crdate DESC LIMIT $limit_start, $items_per_page");

  while($ibwfsite=mysql_fetch_array($ibwfsites))
  {
 if (ismod(getuid_sid($sid)))
  {
    $hm = "<a href=\"articles.php?action=delart1&amp;id=$ibwfsite[0]\">[x]</a>,";
    $hm2 = "<a href=\"articles.php?action=edit&amp;artid=$ibwfsite[0]\">edit</a>";
 }
 if (ischecker(getuid_sid($sid)))
  {
    $hm = "<a href=\"articles.php?action=delart1&amp;cid=$ibwfsite[0]\">[x]</a>,";
    $hm2 = "<a href=\"articles.php?action=edit&amp;artid=$ibwfsite[0]\">edit</a>";
 }
$sitelink = "$cou. <a href=\"articles.php?action=viewart&amp;id=$ibwfsite[0]&amp;cid=$cid&amp;artid=$ibwfsite[0]\">$ibwfsite[1]</a> $hm$hm2";
    echo "<br/>$sitelink";
$cou++;
}

echo "</small></p>";
echo "<p align=\"center\"><small>";
     if($page>1)
    {
      $ppage = $page-1;
       echo "<a href=\"articles.php?action=$action&amp;page=$ppage&amp;cid=$cid&amp;type=send&amp;browse?\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"articles.php?action=$action&amp;page=$npage&amp;cid=$cid&amp;type=send&amp;browse?\">Next&#187;</a>";
    }
     echo "<br/>Page $page of $num_pages";

   if($num_pages>2)
    {

        $rets = "<form action=\"articles.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"cid\" value=\"$cid\"/>";
       $rets .= "</form>";

        echo $rets;
    }
echo "<br/><a href=\"articles.php?action=newart&amp;cid=$cid&amp;type=send&amp;artid=$item[0]\">Submit Article</a><br/>";

echo "<a href=\"articles.php?action=articles&amp;browse?\">";
    echo "Articles</a><br/>";


 echo "<br/>";
    echo "<a href=\"index.php?action=main&amp;type=send&amp;browse?\">";
echo "Main menu</a>";
  echo "</small></p>";
    echo "</card>";
exit();
}

/////////////////////////////////////////////
else if($action=="edit")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Article",$pstyle);
$artid = $_GET["artid"];

    addonline(getuid_sid($sid),"Article Checker Tool ","index.php?action=main");
    $pinfo= mysql_fetch_array(mysql_query("SELECT name  FROM dcroxx_me_readart WHERE id='".$artid."'"));
  echo "<head>";

   echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
    $ptext = htmlspecialchars($pinfo[0]);

echo "<p align=\"center\">";
echo "<form action=\"articles.php?action=edit2&amp;artid=$artid&amp;\" method=\"post\">";
echo "<small>Edit:</small><br/> <input name=\"ptext\" maxlength=\"2000\"/><br/>";
 echo "<input type=\"submit\" value=\"SUBMIT\"/>";
           echo "</form>";
 echo "</p>";
echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=main\">";
echo "Home</a>";
  echo "</p>";
exit();
}

////////////////////////////////////////////////View Topic

else if($action=="viewart")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Article",$pstyle);
    $id = $_GET["id"];
 $cid = $_GET["cid"];
$artid = $_GET["artid"];
$cinfo = mysql_fetch_array(mysql_query("SELECT name from dcroxx_me_readart WHERE id='".$id."'"));
    addonline(getuid_sid($sid),"Reading article $cinfo[0]","articles.php?action=$action");

    echo "<head>";

   echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
 $tinfo = mysql_fetch_array(mysql_query("SELECT name, authorid, crdate, id from dcroxx_me_readart WHERE id='".$id."'"));
    $tnm = htmlspecialchars($tinfo[0]);

    echo "<p align=\"left\"><small>";
echo "<b>$cinfo[0]</b><br/>";

    $tmstamp = $tinfo[2];
    $tmdt = date("D,dMy-h:i:s a",$tmstamp);

     echo "$tmdt<br/>";
$unick = getnick_uid($tinfo[1]);
    $usl = "<a href=\"index.php?action=viewuser&amp;who=$tinfo[1]&amp;browse?\">$unick</a>";

echo "$usl2 Submitted by: $usl<br/><br/>";
  $tid = $_GET["artid"];
  $go = $_GET["go"];
$uid = getuid_sid($sid);

    $num_pages = getnumpages2($artid);
    if($page==""||$page<1)$page=1;
    if($go!="")$page=getpage_go2($go,$artid);
    $posts_per_page = 4;
    if($page>$num_pages)$page=$num_pages;
    $limit_start = $posts_per_page *($page-1);
    $vws = $tinfo[3]+1;
 ///////from here
    if($page==1)
    {
      $posts_per_page=4;

      $ttext = mysql_fetch_array(mysql_query("SELECT authorid, text, crdate FROM dcroxx_me_readart WHERE id='".$id."'"));
     $pst2 = parsemsg($ttext[1], $sid);
 $unick = getnick_uid($ttext[0]);
 if(substr_count($ttext[1],"[br/]")<=2000){
    $text = str_replace("[br/]","<br/>",$ttext[1]);

 }

 echo "$text<br/>";
  mysql_query("UPDATE dcroxx_me_readart SET vws='".$vws."' WHERE  id='".$id."'");
  mysql_query("INSERT INTO dcroxx_me_view2 SET uid='".$uid."', artid='".$artid."', actime='".time()."'");
  }
  if($page>1)
  {
    $limit_start--;
  }
  $sql = "SELECT id, text  FROM dcroxx_me_artpost WHERE artid='".$artid."' ORDER BY crdate LIMIT $limit_start, $posts_per_page";
  $posts = mysql_query($sql);
  while($post = mysql_fetch_array($posts))
  {
    $unick = getnick_uid($post[2]);

    $usl = "<br/><a href=\"index.php?action=viewuser&amp;who=$post[2]&amp;browse?\">$unick</a>";
    $pst = parsemsg($post[1], $sid);

 if(substr_count($post[1],"[br/]")<=2000){
    $pst = str_replace("[br/]","<br/>",$post[1]);

 }
   echo "<br/>$hm $pst<br/>";


  }

    ///to here

 if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"articles.php?action=viewart&amp;page=$ppage&amp;artid=$artid&amp;cid=$cid&amp;id=$id\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"articles.php?action=viewart&amp;page=$npage&amp;artid=$artid&amp;cid=$cid&amp;id=$id\">Next&#187;</a>";
    }
    echo "<br/>Page $page of $num_pages";

      if($num_pages>2)
    {

        $rets = "<form action=\"articles.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"cid\" value=\"$cid\"/>";
       $rets .= "<input type=\"hidden\" name=\"id\" value=\"$id\"/>";
        $rets .= "<input type=\"hidden\" name=\"artid\" value=\"$artid\"/>";
$rets .= "</form>";

        echo $rets;
    }
 if(canaddart($uid, $id))
    {
 echo "<br/><a href=\"articles.php?&amp;action=newart2&amp;id=$artid&amp;artid=$artid&amp;cid=$cid\">Add more</a>";

}
 $tmsg = getpmcount(getuid_sid($sid));
  $umsg = getunreadpm(getuid_sid($sid));
  if($umsg>0)
  {
  echo "<br/><a href=\"inbox.php?action=main&amp;browse?\">New Private msg($umsg/$tmsg)</a>";
  }
  $countpics = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM dcroxx_me_cwart WHERE artid='".$artid."'"));
 echo "<br/><a href=\"articles.php?&amp;action=artcom&amp;id=$id&amp;artid=$id&amp;cid=$cid\">Comments($countpics[0])</a>";
echo "<br/>";
   echo "<a href=\"articles.php?&amp;action=dload&amp;id=$id&amp;artid=$id\">Download</a>";
echo "<br/>";
   echo "<a href=\"articles.php?&amp;action=viewall&amp;id=$id&amp;artid=$id&amp;cid=$cid\">Fastread</a>";
echo "<br/>";
$cinfo = mysql_fetch_array(mysql_query("SELECT name from dcroxx_me_articles WHERE id='".$cid."'"));
   echo "<a href=\"articles.php?&amp;action=cwart&amp;cid=$cid\">$cinfo[0]</a>";
echo "<br/>";
$ttext = mysql_fetch_array(mysql_query("SELECT authorid, text, crdate FROM dcroxx_me_readart WHERE id='".$id."'"));
$unick = getnick_uid($ttext[0]);
$unick2 = getnick_uid($post[2]);
 echo "<a href=\"articles.php?&amp;action=vall&amp;who=$ttext[0]&amp;cid=$cid&amp;cid=$cid&amp;id=$artid&amp;artid=$artid\">All articles of $unick</a>";
echo "<br/>";
echo "<a href=\"articles.php?action=articles&amp;browse?\">";
    echo "Articles</a><br/>";


 echo "<br/>";
    echo "<a href=\"index.php?action=main&amp;type=send\">";
echo "Home</a>";
  echo "</small></p>";
exit();
}

////////////////////////////////////////////////View Topic

else if($action=="viewall")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Article",$pstyle);
    $id = $_GET["id"];
 $cid = $_GET["cid"];
$artid = $_GET["artid"];
$cinfo = mysql_fetch_array(mysql_query("SELECT name from dcroxx_me_readart WHERE id='".$id."'"));
    addonline(getuid_sid($sid),"Reading article $cinfo[0]","articles.php?action=$action");
   echo "<head>";

   echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
    $tinfo = mysql_fetch_array(mysql_query("SELECT name, authorid, crdate, vws from dcroxx_me_readart WHERE id='".$id."'"));
    $tnm = htmlspecialchars($tinfo[0]);

    echo "<p align=\"left\"><small>";
   echo "<b>$cinfo[0]</b><br/>";
  $num_pages = getnumpages2($artid);
    if($page==""||$page<1)$page=1;
    if($go!="")$page=getpage_go2($go,$artid);
    $posts_per_page = 2000;
    if($page>$num_pages)$page=$num_pages;
    $limit_start = $posts_per_page *($page-1);
    $vws = $tinfo[3]+1;

    $tmstamp = $tinfo[2];
    $tmdt = date("D,dMy-h:i:s a",$tmstamp);

     echo "$tmdt<br/>";
$unick = getnick_uid($tinfo[1]);
    $usl = "<a href=\"index.php?action=viewuser&amp;who=$tinfo[1]&amp;browse?\">$unick</a>";
 echo "Submitted by: $usl<br/><br/>";
  $tid = $_GET["artid"];
  $go = $_GET["go"];
$uid = getuid_sid($sid);

    if($page==1)
    {
      $posts_per_page=2000;
      mysql_query("UPDATE dcroxx_me_readart SET views='".$vws."' WHERE  id='".$id."'");
      $ttext = mysql_fetch_array(mysql_query("SELECT authorid, text, crdate FROM dcroxx_me_readart WHERE id='".$id."'"));
     $pst2 = parsemsg($ttext[1], $sid);
 $unick = getnick_uid($ttext[0]);
 if(substr_count($ttext[1],"[br/]")<=2000){
    $text = str_replace("[br/]","<br/>",$ttext[1]);
  }
 echo "$text<br/>";

  }
  if($page>1)
  {
    $limit_start--;
  }
  $sql = "SELECT id, text  FROM dcroxx_me_artpost WHERE artid='".$artid."' ORDER BY crdate LIMIT $limit_start, $posts_per_page";
  $posts = mysql_query($sql);
  while($post = mysql_fetch_array($posts))
  {
    $unick = getnick_uid($post[2]);

    $usl = "<br/><a href=\"index.php?action=viewuser&amp;who=$post[2]&amp;browse?\">$unick</a>";
    $pst = parsemsg($post[1], $sid);

 if(substr_count($post[1],"[br/]")<=2000){
    $text2 = str_replace("[br/]","<br/>",$post[1]);
  }
   echo "<br/>$hm $text2<br/>";


  }


    echo "-------<br/>Viewed: $vws";
 if(canaddart($uid, $id))
    {
 echo "<br/><a href=\"articles.php?&amp;action=newart2&amp;id=$artid&amp;artid=$artid&amp;cid=$cid\">Add more</a>";

}
 $tmsg = getpmcount(getuid_sid($sid));
  $umsg = getunreadpm(getuid_sid($sid));
  if($umsg>0)
  {
  echo "<br/><a href=\"inbox.php?action=main&amp;browse?\">New PM($umsg/$tmsg)</a>";
  }
  $countpics = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM dcroxx_me_cwart WHERE artid='".$artid."'"));
 echo "<br/><a href=\"articles.php?&amp;action=artcom&amp;id=$id&amp;artid=$id&amp;cid=$cid\">Comments($countpics[0])</a>";
echo "<br/>";
   echo "<a href=\"articles.php?&amp;action=dload&amp;id=$id&amp;artid=$id\">Download</a>";
echo "<br/>";
$cinfo = mysql_fetch_array(mysql_query("SELECT name from dcroxx_me_articles WHERE id='".$cid."'"));
   echo "<a href=\"articles.php?&amp;action=cwart&amp;cid=$cid\">$cinfo[0]</a>";
echo "<br/>";
$ttext = mysql_fetch_array(mysql_query("SELECT authorid, text, crdate FROM dcroxx_me_readart WHERE id='".$id."'"));
$unick = getnick_uid($ttext[0]);
$unick2 = getnick_uid($post[2]);
 echo "<a href=\"articles.php?&amp;action=vall&amp;who=$ttext[0]&amp;cid=$cid&amp;cid=$cid&amp;id=$artid&amp;artid=$artid\">All articles of $unick</a>";
echo "<br/>";
echo "<a href=\"articles.php?action=articles&amp;browse?\">";
    echo "Articles</a><br/>";


 echo "<br/>";
    echo "<a href=\"index.php?action=main&amp;type=send\">";
echo "Home</a>";
  echo "</small></p>";
    echo "</card>";
exit();
}

/////////////////////////////////////////////////////sdasda
else if($action=="artcom2")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Article",$pstyle);
$text = $_POST["text"];
  $artid = $_GET["artid"];
  //$qut = $_POST["qut"];
addonline(getuid_sid($sid),"Adding Article Comment","index.php?action=main");
   echo "<head>";

   echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
      echo "<p align=\"center\"><small>";
      $crdate = time();
      $uid = getuid_sid($sid);
      $res = false;

      if(trim($text)!="")
      {

      $res = mysql_query("INSERT INTO dcroxx_me_cwart SET uid='".$uid."', text='".$text."', crdate='".$crdate."', artid='".$artid."'");
      }
      if($res)
      {
        echo "Comment submitted<br/>";
      }else{
        echo "Error Adding Comment<br/>";

  }

echo "<a href=\"articles.php?action=articles&amp;browse?\">";
    echo "Articles</a><br/>";


  echo "<br/>";
      echo "<a href=\"index.php?action=main&amp;browse?start\">";
echo "Home</a>";
      echo "</small></p>";
exit();
}

/////////////////////////////////////////////
else if($action=="delart")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Article",$pstyle);
  $id = $_GET["id"];
  addonline(getuid_sid($sid),"Secret ehem","index.php?action=main");
 echo "<head>";

   echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
  echo "<p align=\"center\"><small>";

  $res = mysql_query("DELETE FROM dcroxx_me_cwart WHERE id ='".$id."'");
  if($res)
          {
            echo "Comment deleted";
          }else{
            echo "Database Error";
          }
  echo "<br/><br/>";

echo "<a href=\"articles.php?action=articles&amp;browse?\">";
    echo "Articles</a><br/>";
  echo "<a href=\"index.php?action=main\">";
echo "Home</a>";
  echo "</small></p>";

exit();
}

///////////////////////////////////////////////////////////////////////sadasdas

else if($action=="delart1")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Article",$pstyle);
  $id = $_GET["id"];
 $cid = $_GET["cid"];
  addonline(getuid_sid($sid),"Secret ehem","index.php?action=main");
 echo "<head>";

   echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
  echo "<p align=\"center\"><small>";

  $res = mysql_query("DELETE FROM dcroxx_me_readart WHERE id ='".$id."'");
  if($res)
          {
            echo "Article deleted";
          $tpci = mysql_fetch_array(mysql_query("SELECT name, authorid FROM dcroxx_me_readart WHERE id='".$id."'"));
         $tname = htmlspecialchars($tpci[0]);
         $msg = "Your article "."[/topic] is deleted"." due to non-sense or not in correct category!";
         autopm($msg, $tpci[1]);
          }else{
            echo "Database Error";
          }
  echo "<br/><br/>";

echo "<a href=\"articles.php?action=articles&amp;browse?\">";
    echo "Articles</a><br/>";
  echo "<a href=\"index.php?action=main\">";
echo "Home</a>";
  echo "</small></p>";
exit();
}

///////////////////////////////////////////////////vrrrrr
else if($action=="artcom3")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Article",$pstyle);
$artid = $_GET["artid"];
    addonline(getuid_sid($sid),"Making Article Comments","index.php?action=$action&amp;who=$who");
   echo "<head>";

   echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
echo "<p align=\"center\">";

echo "<form action=\"articles.php?action=artcom2&amp;artid=$artid\" method=\"post\">";
echo "<small>Comments:</small><br/> <input name=\"text\" maxlength=\"300\"/><br/>";

 echo "<input type=\"submit\" value=\"SUBMIT\"/>";
           echo "</form>";
 echo "</p>";
echo "<p align=\"center\"><small>";
echo "<a href=\"articles.php?action=articles&amp;browse?\">";
    echo "Articles</a><br/>";


 echo "<br/>";
    echo "<a href=\"index.php?action=main\">";
echo "Home</a>";
  echo "</small></p>";
exit();
}

////////////////////////////////////////////////smooch
else if($action=="artcom")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Article",$pstyle);
$id = $_GET["id"];
$cid = $_GET["cid"];
$artid = $_GET["artid"];
    addonline(getuid_sid($sid),"Viewing Article Comments","lists.php?action=$action&amp;who=$who&amp;bid=$bid");
echo "<head>";

   echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
     $uid = getuid_sid($sid);
     echo "<p align=\"left\"><small>";
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_cwart WHERE artid='".$artid."'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;


      $sql = "SELECT id, artid, text, uid, crdate FROM dcroxx_me_cwart WHERE artid='".$artid."' ORDER BY crdate DESC LIMIT $limit_start, $items_per_page";



    $items = mysql_query($sql);
     $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {

          if(isonline($item[3]))
  {
    $iml = "[&#x2022;]";

  }else{
    $iml = "[x]";
  }
    $snick = getnick_uid($item[3]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[3]\">$iml$snick</a>:";

    $tmstamp = $item[4];
    $bs = date("D,dMy-h:i:s a",$tmstamp);

      echo "$lnk<br/>";

$me = getuid_sid($sid);
if($who=="$me") {
$can = "a";
}else{
$can = "b";
}
  if(ismod($uid)||$can=="a")
  {
   $delnk = "<a href=\"articles.php?action=delart&amp;id=$item[0]\">[x]</a>";
      }else{
        $delnk = "";
      }
      $text = parsepm($item[2], $sid);
      echo "$text $delnk<br/>";
echo "$bs";
echo "<br/>";
      echo "";

    }
    }
 echo "</small></p><p align=\"center\"><small>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"articles.php?action=artcom&amp;page=$ppage&amp;id=$artid&amp;cid=$cid&amp;artid=$artid&amp;type=send\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"articles.php?action=artcom&amp;page=$npage&amp;id=$artid&amp;cid=$cid&amp;artid=$artid&amp;type=send\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";

      if($num_pages>2)
    {

        $rets = "<form action=\"articles.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"cid\" value=\"$cid\"/>";
       $rets .= "<input type=\"hidden\" name=\"id\" value=\"$artid\"/>";
        $rets .= "<input type=\"hidden\" name=\"artid\" value=\"$artid\"/>";
$rets .= "</form>";

        echo $rets;
    }
    echo "</small></p>";
    echo "<p align=\"center\"><small>";
   $me = getuid_sid($sid);
if($me!="$id") {
    echo "<a href=\"articles.php?action=artcom3&amp;artid=$artid\">Add Comment</a><br/>";
}
echo "<a href=\"articles.php?action=viewart&amp;cid=$cid&amp;artid=$artid&amp;id=$id&amp;browse?\">";
    echo "Back to article</a><br/>";

echo "<a href=\"articles.php?action=articles&amp;browse?\">";
    echo "Articles</a><br/>";


 echo "<br/>";
    echo "<a href=\"index.php?action=main\">";
echo "Home</a>";
  echo "</small></p>";
exit();
}

///////////////////////////////////////////////Buddies

else if($action=="vall")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Article",$pstyle);
    $id = $_GET["id"];
 $cid = $_GET["cid"];
$artid = $_GET["artid"];
    $who = $_GET["who"];
    addonline(getuid_sid($sid),"Users Articles","lists.php?action=$action");
 echo "<head>";

   echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
    $uid = getuid_sid($sid);
   echo "<p align=\"left\"><small>";
   if($page=="" || $page<=0)$page=1;
    $ibwf = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_readart WHERE authorid='".$who."'"));
     $num_items = $ibwf[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;


$cou = $limit_start+1;
$ibwfsites = mysql_query("SELECT id, name, crdate, cid FROM dcroxx_me_readart WHERE authorid='".$who."'  ORDER BY crdate DESC LIMIT $limit_start, $items_per_page");;
  while($ibwfsite=mysql_fetch_array($ibwfsites))
  {
$sitelink = "$cou. <a href=\"articles.php?action=viewart&amp;id=$ibwfsite[0]&amp;cid=$ibwfsite[3]&amp;artid=$ibwfsite[0]\">$ibwfsite[1]</a>";
    echo "<br/>$sitelink";
$cou++;
}

echo "</small></p>";
echo "<p align=\"center\"><small>";
   if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"articles.php?action=$action&amp;page=$ppage&amp;artid=$artid&amp;who=$who&amp;cid=$cid&amp;artid=$artid&amp;id=$id\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"articles.php?action=$action&amp;page=$npage&amp;artid=$artid&amp;who=$who&amp;cid=$cid&amp;artid=$artid&amp;id=$id\">Next&#187;</a>";
    }
      echo "<br/>Page $page of $num_pages";

      if($num_pages>2)
    {

        $rets = "<form action=\"articles.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
$rets .= "</form>";

        echo $rets;
    }
  ////// UNTILL HERE >>
echo "<br/><a href=\"articles.php?action=viewart&amp;cid=$cid&amp;artid=$artid&amp;id=$id&amp;browse?\">";
    echo "Back to article</a>";
echo "<br/><a href=\"articles.php?action=articles&amp;browse?\">";
    echo "Articles</a><br/>";


 echo "<br/>";
    echo "<a href=\"index.php?action=main&amp;type=send&amp;browse?\">";
echo "Home</a>";
  echo "</small></p>";
exit();
}

/////////////////////////////////////////////
else if($action=="dload")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Article",$pstyle);
    $artid = $artid;
   addonline(getuid_sid($sid),"Download Article","index.php?action=main");
echo "<head>";

   echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
    echo "<p align=\"center\"><small>";
    $pminfo = mysql_fetch_array(mysql_query("SELECT text, authorid FROM dcroxx_me_readart WHERE id='".$id."'"));

          echo "Ready to download<br/><br/>";
        echo "<a href=\"artdl.php?action=dart&amp;id=$id&amp;artid=$artid&amp;type=send&amp;browse?start\">Download Now</a><br/>";
      echo "<a href=\"articles.php?action=articles&amp;browse?\">";
    echo "Articles</a><br/>";

echo "<a href=\"index.php?action=main&amp;type=send&amp;browse?start\">";
echo "Home</a>";

   echo "</small></p>";

exit();
}


   echo "</body>";
   echo "</html>";
?>

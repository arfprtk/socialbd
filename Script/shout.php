<?php
echo '<?xml version="1.0"?>';
include("core.php");
$siid=sntz($_GET['sid']);
$who=sntz($_GET['who']);
$page=sntz($_GET['page']);
checkvalue($siid);
if($page!='')
checkvalue($page);
if($who!='')
checkvalue($who);
connectdb();
if(logged($siid)==0){ head_tag("ERROR !!","fcafe");echo '<body><br/><div><img src="../images/slogo.png" alt="FC"/><br/><br/>YOU ARE NOT LOGGED IN OR YOUR SESSION HAS BEEN EXPIRED.<br/>YOU MUST BE LOGGED IN TO SEE THIS PAGE.<br/><br/><a href="index.php">&#187;Login Here</a><br/><br/></div><div class="maaz">&copy;2011-2012 FRNDZCAFE GROUP</div></body></html>';mysql_close();exit();}
$ud=getuid2($siid);cleardata($ud);
$theme=gettheme($ud);
if($theme==""){$theme="defaults";}
$time=time();
canlog(ip(),browser($_SERVER["HTTP_USER_AGENT"]),$ud);
update($ud);$nick1=getnick($ud);$unread=getunread($ud);
head_tag("Shout",$theme);echo "<body><div>SHOUT HISTORY</div><br/>";
if(isset($_POST['shout']))
{
  $valid=usval($ud);
  if($valid==1){addonline($ud,$time,"ERROR PAGE");$onn=mysql_fetch_array(mysql_query("select ontime from users437 where uid='$ud'"));echo "You Are Still Not Validated.<br/>You Need To Spend 1hour at the site browsing other places.Once Your id is validated you can use all site features<br/><br/><b>Your Online Time is :".gettimemsg($onn[0])."</b><br/>";foot_tag($ud,$siid,1,1,1,1,1,1,1);mysql_close();exit();}
  addonline($ud,$time,"Shouting");
  $_POST['shtxt']=mysql_real_escape_string(sntz($_POST['shtxt']));
  $message=$_POST['shtxt'];
   $message=getbbcode(htmlspecialchars($message,ENT_QUOTES),$siid);
   $message=getsmilies($message,$ud);
  $blocked=blocked($message);
  if($blocked==0){ echo '<center>Our Spy Detected That The msg contains Abuse or Spam so it cant be Posted<br/><b>BY : ATTiDuDE</b></center></body>';}
  else if($blocked==1)
  {
    $nos = substr_count($message,"<img src=");
    if($nos>5)
    echo "<center><b>Sorry ! Only 5 Smilies Allowed</b></center>";
    else{
    $date=date("");
    $time=time();
    $flood=mysql_fetch_array(mysql_query("select shtime from shouts437 where uid='$ud' order by id desc"));
    if($time-$flood[0]>=30 && trim($_POST['shtxt'])!='' && istrashed($ud)==0){staffboard($ud,3);
    mysql_query("insert into shouts437 values('','{$_POST['shtxt']}','$ud','$time','$date','0','')");
    $ts=mysql_fetch_array(mysql_query("select ts,plusses from users437 where uid='$ud'"));
    mysql_query("update users437 set ts=$ts[0]+1,plusses=$ts[1]-3 where uid='$ud'");
    echo '<p align="center"><img src="../images/ok.gif" alt="+">Your Shout Has Been Added Successfully<br/><br/></p>';}}}}
    else addonline($ud,$time,"Viewing Shout History");
    $pls=mysql_fetch_array(mysql_query("select plusses from users437 where uid='$ud'"));
    $pls=$pls[0];
    if($pls>75){echo '<form action="./shout.php?sid='.$siid.'" method="post"><br/>ADD SHOUT:<br/><input type="text" name="shtxt" maxlength="300"/><br/><input type="Submit" name="shout" Value="Add Shout"/></form><br/><br/>';}else{echo 'U need atleast 75 plusses to shout';}echo '<a href="shout.php?sid='.$siid.'">&#187;REFRESH HISTORY</a><br/><hr /><br/>';
       if($unread>0)
       echo "<a href=\"inbox.php?action=main&amp;sid=$siid\">YOU HAVE $unread INBOX</a><br/><br/>";
       echo '<a href="index2.php?action=shout&amp;sid='.$siid.'"><b><font color="red">&#187;Shout+Photo</font>(Charges 50 plusses)</b></a><br/><br/>';
       if($page=="" || $page<=0)$page=1;
       if($who=="")
      $noi=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM shouts437"));
     else
    $noi=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM shouts437 WHERE uid='$who'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql
    if($who=='')
    {
        $sql = "SELECT * FROM shouts437 ORDER BY shtime DESC LIMIT $limit_start, $items_per_page";
}else{
    $sql = "SELECT * FROM shouts437  WHERE uid=$who ORDER BY shtime DESC LIMIT $limit_start, $items_per_page";
}
$items = mysql_query($sql);
    if(mysql_num_rows($items)>0)
    {
    while ($sht = mysql_fetch_array($items))
    {
          $cvw=true;
          if(istrashed($sht[2])){$cvw=false;
          if($ud==$sht[2]){$cvw=true;}}
          if($cvw==true){
         $nick=getnick($sht[2]);if(isprm($sht[2])>0)$nick=premium($sht[2]);
$oni=isonline($sht[2]);
if($oni==1){ $alt="on"; $oni='../images/on.gif';} else{$alt="off"; $oni='../images/off.gif';}
if($sht[5]!=0){$rr=mysql_fetch_array(mysql_query("select uid,shout,image from shouts437 where id='$sht[5]'"));
$n=getnick($rr[0]);$shtt='[b][small]Original Shouter : '.$n.'[br/]Original Text :[/small][/b] '.$rr[1];if($rr[2]!='')
$shtt.="[maaazzzareeshaa=$rr[2]]";$shtt.='[br/]-------[br/][b]Comment :[/b]'.$sht[1];
$shout=getsmilies(getbbcode(htmlspecialchars($shtt,ENT_QUOTES),$siid),$ud);}
else{$shout=getsmilies(getbbcode(htmlspecialchars($sht[1],ENT_QUOTES),$siid),$ud);$sres=substr($shout,0,3);
            if($sres=="/rb"){$tosay=substr($shout,3);$shout=rainbow($tosay);}
    
}
echo '<br/><img src="'.$oni.'" alt="'.$alt.'"><i><a href="./profile.php?who='.$sht[2].'&sid='.$siid.'">'.$nick.'</a></i> :'.$shout;if($sht[6]!='')
echo "<img src=\"../phpThumb/phpThumb.php?src=$sht[6]\" alt=\"\"/>"; echo "<br/>".$sht[4];

if(isstaff($ud)>=400)
      {
      $dlsh = '<a href="modproc.php?action=delsh&sid='.$siid.'&shid='.$sht[0].'">[x]</a>';
      }else{
        $dlsh = "";
      }
      echo $dlsh.'<br/>';
      
    echo "<form action=\"index2.php?action=shcm&sid=$siid\" method=\"post\"><input type=\"hidden\" name=\"postid\" value=\"$sht[0]\">
    <input type=\"submit\" name=\"comment\" value=\"Comment\"></form>";
    }
      }
    }
if($page>1)
    {
      $ppage = $page-1;
      echo '<center><a href="./shout.php?action=history&page='.$ppage.'&sid='.$siid.'&who='.$who.'">&#171;Prev</a></center>';
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo '<center><a href="./shout.php?action=history&page='.$npage.'&sid='.$siid.'&who='.$who.'">Next&#187;</a></center>';
    }
    echo "<center><br/>$page/$num_pages<br/></center>";
    if($num_pages>2)
    {
	  $rets = "<form action=\"./shout.php\" method=\"get\">";
        $rets .= "<input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\">";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$siid\">";
        $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\">";
        $rets .= "<input type=\"Submit\" name=\"Submit\" Value=\"Go To Page\"></form>";

        echo $rets;
         }

foot_tag($ud,$siid,1,1,1,1,1,1,1);
mysql_close();exit();
 ?>
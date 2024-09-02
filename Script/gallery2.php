<?php
session_name("PHPSESSID");
session_start();
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
?>
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
<?php
include("config.php");
include("core.php");
include("xhtmlfunctions.php");
$bcon = connectdb();
if (!$bcon)
{
      echo "<p align=\"left\">";

    echo "<img src=\"images/exit.gif\" alt=\"*\"/><br/>";

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://chat.Waplive.tk/css/style.css\">";



    echo "ERROR! cannot connect to database<br/><br/>";

    echo "This error happens usually when backing up the database, please be patient, The site will be up any minute<br/><br/>";

    echo "<b>THANK YOU VERY MUCH</b><br/><br/>";

      echo "</p>";

    exit();

}



$action = $_GET["action"];
$page = $_GET["page"];
$sid = $_SESSION['sid'];
$whoimage = $_GET["whoimage"];
$uid = getuid_sid($sid);
if(islogged($sid)==false)
    {echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://chat.Waplive.tk/css/style.css\">";
echo "<p align=\"left\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "</p>";
      echo "<p align=\"left\">";
      echo "<form action=\"login.php\" method=\"get\">";
      echo "Username:<input name=\"loguid\" size=\"8\" maxlength=\"30\"/><br/>";
      echo "Password:<input name=\"logpwd\" size=\"8\" maxlength=\"30\" type=\"password\" /><br/>";
      echo "<input type=\"submit\" value=\"Login\"/>";
      echo "</form>";
      echo "</p>";
       exit();
    }
if(isbanned($uid))
    {
      echo "<p align=\"left\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "You are <b>Banned</b><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto FROM dcroxx_me_penalties WHERE uid='".$uid."' AND penalty='1'"));
	  $banres = mysql_fetch_array(mysql_query("SELECT lastpnreas FROM dcroxx_me_users WHERE id='".$uid."'"));
      $remain = $banto[0]- time() ;
      $rmsg = gettimemsg($remain);
      echo "Time to finish your penalty: $rmsg<br/><br/>";
	  echo "Ban Reason: $banres[0]";
      echo "</p>";
     exit();
   }

$amount = mysql_fetch_array(mysql_query("SELECT balance FROM dcroxx_me_users WHERE id='".getuid_sid($sid)."'"));
  if($amount[0] < 5){
    $pstyle = gettheme($sid);
      echo xhtmlhead("Messages Service",$pstyle);
      echo "<p align=\"center\"><small>";
      echo "[x]<br/>Insufficient Balance<br/>";
            echo "You need atleast <b>5 BDT</b> for unlock gallery service<br/>
            Make shouts and friendship with others and stay 1hour for earn <b>5 BDT</b>";
            echo "</small></p>";
                echo"<p align=\"center\"><small>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a><br/><br/>";
  echo "</small></p>";
    echo "</card>";
    exit();
  }

////////////////////////////////////////GALLERY MAIN PAGE
if($action=="main")
{

  addonline(getuid_sid($sid),"User gallery","");
$pstyle = gettheme($sid);
    echo xhtmlhead("Gallery",$pstyle);

			echo "<small><b>Member's Photo Gallery</b></small></div><br/>";
		    echo "<p align=\"left\"><small>";
$user = getnick_uid($pic[0]);
$pic = mysql_fetch_array(mysql_query("SELECT uid, imageurl FROM dcroxx_me_usergallery ORDER BY RAND() LIMIT 1"));
$user = getnick_uid($pic[0]);
$user = getnick_uid($pic[0]);
echo "<a href=\"gallery2.php?action=viewuser&amp;who=$pic[0]\"/><img src=\"$pic[1]\" width=\"30\" height=\"30\"/></a>";
$pic = mysql_fetch_array(mysql_query("SELECT uid, imageurl FROM dcroxx_me_usergallery ORDER BY RAND() LIMIT 1"));
$user = getnick_uid($pic[0]);
echo "<a href=\"index.php?action=viewuser&amp;who=$pic[0]\"/><img src=\"$pic[1]\" width=\"30\" height=\"30\"/></a>";
$pic = mysql_fetch_array(mysql_query("SELECT uid, imageurl FROM dcroxx_me_usergallery ORDER BY RAND() LIMIT 1"));
$user = getnick_uid($pic[0]);
echo "<a href=\"index.php?action=viewuser&amp;who=$pic[0]\"/><img src=\"$pic[1]\" width=\"30\" height=\"30\"/></a>";
$pic = mysql_fetch_array(mysql_query("SELECT uid, imageurl FROM dcroxx_me_usergallery ORDER BY RAND() LIMIT 1"));
$user = getnick_uid($pic[0]);
echo "<a href=\"index.php?action=viewuser&amp;who=$pic[0]\"/><img src=\"$pic[1]\" width=\"30\" height=\"30\"/></a>";
$pic = mysql_fetch_array(mysql_query("SELECT uid, imageurl FROM dcroxx_me_usergallery ORDER BY RAND() LIMIT 1"));
$user = getnick_uid($pic[0]);
echo "<a href=\"index.php?action=viewuser&amp;who=$pic[0]\"/><img src=\"$pic[1]\" width=\"30\" height=\"30\"/></a>";
echo"<br/>";
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usergallery WHERE sex='F'"));

echo "<a href=\"gallery2.php?action=females\"><img src=\"images/female.gif\" alt=\"*\"/>Females</a>($noi[0])<br/>";

$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usergallery WHERE sex='M'"));

echo "<a href=\"gallery2.php?action=males\"><img src=\"images/male.gif\" alt=\"*\"/>Males</a>($noi[0])<br/>";



/*
echo "<br/><div align=\"center\">\n";
echo "This is the <b></b> photo gallery.<br/><br/>";
echo "<hr/>";
echo "<span class=\"owner\"><b><blink>NEW!!</blink></b></span><br/>\n";
echo "Upload your photos via <b>MMS</b><br/>";
echo "Send your photos to: <b>gallery@.tk</b><br/>";
echo "In the subject line add: ";
$code = mysql_fetch_array(mysql_query("SELECT regdate FROM dcroxx_me_users WHERE id='".$uid."'"));
echo "<b>$code[0]</b>";
echo "<br/>";
echo "It will then appear in the gallery within 1 minute";
echo "<hr />";
echo "</div>";
*/
echo "<br/>MMS or E-MAIL your Photo to <b>gallery@socialbd.net</b> 
including your member name, or just click the Link below to Upload a Photo straight from your Phone.<br/><br/>";
      echo "<a href=\"gallery2.php?action=upload\">Add Your Photo</a>";
    echo "</small></p>";
   echo "<p><small>";
  echo "<img src=\"images/home.gif\" alt=\"*\"><a href=\"index.php?action=main\">Home</a>";
  echo "</small></p>";
    exit();
    }

////////////////////////////////////////MALE GALLERY

 if($action=="males")

{

  addonline(getuid_sid($sid),"Male Members gallery ","");

$pstyle = gettheme($sid);
    echo xhtmlhead("Gallery",$pstyle);




		
			echo "<small><b>Male Member's Gallery</b></small><br/>";
		//	echo "<left>Male members gallery</left></div>";

			echo"<br/>";

					    if($page=="" || $page<=0)$page=1;

					    if($who!="")

					    {
 $noi = mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT uid) FROM dcroxx_me_usergallery WHERE sex='M'"));

					    }else{

 $noi = mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT uid) FROM dcroxx_me_usergallery WHERE sex='M'"));

					    }



					    $num_items = $noi[0]; //changable

					    $items_per_page= 10;

					    $num_pages = ceil($num_items/$items_per_page);

					    if(($page>$num_pages)&&$page!=1)$page= $num_pages;

					    $limit_start = ($page-1)*$items_per_page;


						$sql = "SELECT DISTINCT `uid` FROM `dcroxx_me_usergallery` WHERE sex='M' ORDER BY `id` DESC LIMIT $limit_start , $items_per_page";



					    $items = mysql_query($sql);

					    echo mysql_error();



					    if(mysql_num_rows($items)>0)

					    {

					    while ($item = mysql_fetch_array($items))

					    {

						$who = $item[0];



						$user=getnick_uid($who);

$avlink = getavatar($item[0]);
if ($avlink!=""){
echo "<img src=\"$avlink\" height=\"25\" width=\"25\" alt=\"avatar\"/>";
}else{
echo "<img src=\"images/nopic.jpg\" height=\"25\" width=\"25\" alt=\"avatar\"/>";
}
$countpics = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM dcroxx_me_usergallery WHERE uid='".$who."'"));
$lnk = "<a href=\"gallery2.php?action=viewuserphoto&amp;who=$who\">$user($countpics[0])</a><br/>";
echo "$lnk";
					    }

					    }



    echo "<p align=\"left\">";

    if($page>1)

    {

      $ppage = $page-1;

      echo "<a href=\"gallery2.php?action=$action&amp;page=$ppage\"><small>&#171; Prev</small></a> ";

    }

    echo "<small> $page/$num_pages </small>";

    if($page<$num_pages)

    {

      $npage = $page+1;

      echo "<a href=\"gallery2.php?action=$action&amp;page=$npage\"><small>Next &#187;</small></a>";

    }

    if($num_pages>2)

    {

        $rets = "<left><form action=\"gallery2.php\" method=\"get\">";

        $rets .= "Jump to page:<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";

        $rets .= "<input type=\"submit\" value=\"GO\"/>";

        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";

        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form></left>";

        echo $rets;

    }

    echo "</p>";


  echo "<p><small>";

  echo "<img src=\"images/home.gif\" alt=\"\"><a href=\"index.php?action=main\">Home</a>";

  echo "</small></p>";



exit();


}





////////////////////////////////////////FEMALE GALLERY

else if($action=="females")

{

  addonline(getuid_sid($sid),"Females Members gallery ","");

 $pstyle = gettheme($sid);
    echo xhtmlhead("Gallery",$pstyle);
		//	echo "<left>Female members gallery</left></div>";
			echo "<small><b>Female Member's Gallery</b></small></div><br/>";
			echo"<br/>";
					    if($page=="" || $page<=0)$page=1;



					    if($who!="")

					    {

					    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT uid) FROM dcroxx_me_usergallery WHERE sex='F'"));

					    }else{

					    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT uid) FROM dcroxx_me_usergallery WHERE sex='F'"));

					    }



					    $num_items = $noi[0]; //changable

					    $items_per_page= 10;

					    $num_pages = ceil($num_items/$items_per_page);

					    if(($page>$num_pages)&&$page!=1)$page= $num_pages;

					    $limit_start = ($page-1)*$items_per_page;



						$sql = "SELECT DISTINCT `uid` FROM `dcroxx_me_usergallery` WHERE sex='F' ORDER BY `id` DESC LIMIT $limit_start , $items_per_page";



					    $items = mysql_query($sql);

					    echo mysql_error();



					    if(mysql_num_rows($items)>0)

					    {

					    while ($item = mysql_fetch_array($items))

					    {

						$who = $item[0];



						$user=getnick_uid($who);


$avlink = getavatar($item[0]);
if ($avlink!=""){
echo "<img src=\"$avlink\" height=\"25\" width=\"25\" alt=\"avatar\"/>";
}else{
echo "<img src=\"images/nopic.jpg\" height=\"25\" width=\"25\" alt=\"avatar\"/>";
}
						$countpics = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM dcroxx_me_usergallery WHERE uid='".$who."'"));

					        $lnk = "<a href=\"gallery2.php?action=viewuserphoto&amp;who=$who\">$user($countpics[0])</a><br/>";

					       echo "$lnk";
				    }

					    }

				


    echo "<p align=\"left\">";

    if($page>1)

    {

      $ppage = $page-1;

      echo "<a href=\"gallery2.php?action=$action&amp;page=$ppage\"><small>&#171; Prev</small></a> ";

    }

    echo "<small> $page/$num_pages </small>";

    if($page<$num_pages)

    {

      $npage = $page+1;

      echo "<a href=\"gallery2.php?action=$action&amp;page=$npage\"><small>Next &#187;</small></a>";

    }

    if($num_pages>2)

    {

        $rets = "<left><form action=\"gallery2.php\" method=\"get\">";

        $rets .= "Jump to page:<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";

        $rets .= "<input type=\"submit\" value=\"GO\"/>";

        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";

        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form></left>";

        echo $rets;

    }

    echo "</p>";


  echo "<p><small>";

  echo "<img src=\"images/home.gif\" alt=\"\"><a href=\"index.php?action=main\">Home</a>";

  echo "</small></p>";



exit();


}





else if($action=="viewuserphoto")

{

  addonline(getuid_sid($sid),"Viewing Users Photos","");

 $pstyle = gettheme($sid);
    echo xhtmlhead("Gallery",$pstyle);
$who = $_GET["who"];

  $uid1 = getuid_sid($sid);

  $nick = getnick_uid($who);



  			echo "<center><small><b><a href=\"index.php?action=viewuser&amp;who=$who\">$nick</a>'s Gallery</b></small></div><br/>";

			//echo "<left></left></div>";

			echo"<small>";

					    if($page=="" || $page<=0)$page=1;

					    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usergallery WHERE uid='".$who."'"));

					    $num_items = $noi[0]; //changable

					    $items_per_page= 1;

					    $num_pages = ceil($num_items/$items_per_page);

					    if(($page>$num_pages)&&$page!=1)$page= $num_pages;

					    $limit_start = ($page-1)*$items_per_page;



					    //changable sql

if (shad0w3($uid,$who)) {

					    $sql = "SELECT uid, id, imageurl, sex, descript FROM dcroxx_me_usergallery WHERE uid='".$who."' ORDER BY time DESC LIMIT $limit_start, $items_per_page";



					    $items = mysql_query($sql);



					    echo mysql_error();

					    if(mysql_num_rows($items)>0)

					    {

					    while ($item = mysql_fetch_array($items))

					    {

							$sql = "SELECT rating FROM dcroxx_me_usergallery_rating WHERE imageid='".$item[1]."'";

							$imginfo = mysql_query($sql);



							echo mysql_error();

					        if(mysql_num_rows($imginfo)>0)

					        {

					           while ($imginfos = mysql_fetch_array($imginfo)){

					              $ratingtotal = $ratingtotal + $imginfos[0];}

					        }
if($totalcomments<1){$totalcomments=0;}
$norm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usergallery_rating WHERE imageid='".$item[1]."'"));
if ($norm[0]>0){
$rating = ceil($ratingtotal/$norm[0]);
}else{$rating=0;}
$rated = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usergallery_rating WHERE byuid='".$uid1."' and imageid ='".$item[1]."'"));
$totalcomments = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usergallery_rating WHERE imageid ='".$item[1]."' and commentsyn ='Y'"));
$userinfo = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$item[0]."'"));
 if(canratephoto($uid1, $item[0]) and ($rated[0]==0))
{
 echo "<a href=\"gallery2.php?action=rate&amp;whoimage=$item[1]\">Rate/Comment This Photo</a>";
   }
  if($uid1==$item[0])
{
 echo "<a href=\"genproc.php?action=upavg&amp;avsrc=$item[2]\">Use As Avatar</a>";
   }
  if(($uid1=="1") or ($uid1==$item[0]))
{
 echo " / <a href=\"gallery2.php?action=del&amp;whoimage=$item[1]\">Delete</a>";
 }
 echo "<br/><a href=\"$item[2]\"><img src=\"$item[2]\" alt=\"$userinfo[0]: $page\"/></a><br/>";
/* 
if($uid1==$item[0])
{
if(strlen($item[4])>1){
 $edtlnk = "<a href=\"gallery2.php?action=edtdescript&amp;whoimage=$item[1]\">*</a>";
 }else{
 $edtlnk = "<a href=\"gallery2.php?action=edtdescript&amp;whoimage=$item[1]\">*Add Description*</a>";
 }
 echo "<small>$item[4] </small>$edtlnk<br/><br/>";
  }*/
  echo "Rating: $rating/10 (<a href=\"gallery2.php?action=votes&amp;whoimage=$item[1]\">$norm[0]</a> Votes)<br/>
  <a href=\"gallery2.php?action=comments&amp;whoimage=$item[1]\">Comments</a>($totalcomments[0])";
 echo "<br/>";
  $ratingtotal = 0;
 $sex = $item[3];
 }
  }

}else{
echo "<br/><img src=\"pass.gif\" alt=\"*\"/><b>Album Protection <font color=\"red\">ON</font></b> <br/> 
Only friends and staff can view Gallery of this members<br/> ";
}
//echo "</left>";




    echo "<br/>";

    if($page>1)

    {

      $ppage = $page-1;

      echo "<a href=\"gallery2.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171; Prev</a> ";

    }

    echo " $page/$num_pages ";

    if($page<$num_pages)

    {

      $npage = $page+1;

      echo "<a href=\"gallery2.php?action=$action&amp;page=$npage&amp;who=$who\">Next &#187;</a>";

    }



    if($num_pages>2)

    {

        $rets = "<left><form action=\"gallery2.php\" method=\"get\">";

        $rets .= "Jump to Photo:<input name=\"page\" format=\"*N\" size=\"3\"/>";

        $rets .= "<input type=\"submit\" value=\"GO\"/>";

        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";

        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";

        $rets .= "<input type=\"hidden\" name=\"page\" value=\"$(pg)\"/>";

        $rets .= "</form></left>";

        echo $rets;

    }

    echo "</left></p>";


  echo "<p>";

  echo "<img src=\"images/home.gif\" alt=\"\"><a href=\"index.php?action=main\">Home</a>";

 /*echo " &#62; ";

 echo "<a href=\"gallery2.php?action=main\">Photo gallery</a>";

  echo " &#62; ";*/

 /* if ($item[3]=="M"){

  echo "<a href=\"gallery2.php?action=males\">Male Members Photo gallery</a>";

  }else{

  echo "<a href=\"gallery2.php?action=females\">Female Members Photo gallery</a>";

  }*/

  //echo " &#62; ";

 // echo "$userinfo[0]";

  echo "</p>";




exit();

}





////////////////////////////////////////RATE A PHOTO

else if($action=="rate")

{

  addonline(getuid_sid($sid),"Rating a Photo ","");
$pstyle = gettheme($sid);
    echo xhtmlhead("Gallery",$pstyle);
$uid1 = getuid_sid($sid);

  $item = mysql_fetch_array(mysql_query("SELECT uid, id, imageurl, sex FROM dcroxx_me_usergallery WHERE uid='".$whoimage."'"));



  $rated = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usergallery_rating WHERE byuid='".$uid1."' and imageid ='".$whoimage."'"));



  if(canratephoto($uid1, $item[0]) and ($rated[0]==0))

  {

  echo "<p align=\"left\"><small>";

  echo "Rate this members Photo: 1=Low, 10=High<br/>You can also leave a comment for this photo!<br/>";

  echo "<br/>";

  echo "</small></p>";

  echo "<p>";

    echo "<form action=\"gallery2.php?action=rateuser&amp;whoimage=$whoimage\" method=\"post\">";

    echo "<small>Rate:</small> <select name=\"rate\" value=\"$rate[0]\">";

    echo "<option value=\"1\">1</option>";

    echo "<option value=\"2\">2</option>";

    echo "<option value=\"3\">3</option>";

    echo "<option value=\"4\">4</option>";

    echo "<option value=\"5\">5</option>";

    echo "<option value=\"6\">6</option>";

    echo "<option value=\"7\">7</option>";

    echo "<option value=\"8\">8</option>";

    echo "<option value=\"9\">9</option>";

    echo "<option value=\"10\">10</option>";

    echo "</select><br/>";



  echo "<small>Comments:</small> <input name=\"comment\" format=\"*M\" maxlength=\"200\"/><br/>";

  echo "<input type=\"submit\" value=\"Rate\"/>";

  echo "</form>";

  }else{

  echo "You have already rated this Photo";

  }

  echo "</p>";



  echo "<p><small>";

  echo "<a href=\"index.php?action=main\">Home</a>";

  echo " &#62; ";

  echo "<a href=\"gallery2.php?action=main\">Photo gallery</a>";

  echo " &#62; ";

  echo "Rating a Photo";

  echo "</small></p>";




exit();
}





////////////////////////////////////////READ COMMENTS

else if($action=="comments")

{

  addonline(getuid_sid($sid),"Reading Photo''s Comments","");
$pstyle = gettheme($sid);
    echo xhtmlhead("Gallery",$pstyle);

echo "<p align=\"left\"><small>";

  echo "<br/>";

  echo "</small></p>";

      //////ALL LISTS SCRIPT <<



    if($page=="" || $page<=0)$page=1;

    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usergallery_rating WHERE imageid='".$whoimage."' and commentsyn ='Y'"));

    $num_items = $noi[0]; //changable

    $items_per_page= 5;

    $num_pages = ceil($num_items/$items_per_page);

    if(($page>$num_pages)&&$page!=1)$page= $num_pages;

    $limit_start = ($page-1)*$items_per_page;



    $uidinfo = mysql_fetch_array(mysql_query("SELECT uid, imageurl FROM dcroxx_me_usergallery WHERE id='".$whoimage."'"));

    $uid = getuid_sid($sid);





    $sql = "SELECT rating, comments, byuid, time, commentsreply, id  FROM dcroxx_me_usergallery_rating WHERE imageid ='".$whoimage."' and commentsyn ='Y' ORDER BY time DESC LIMIT $limit_start, $items_per_page";



if (shad0w3($uid,$uidinfo[0])) {

    echo "<center><a href=\"$uidinfo[1]\"><img src=\"$uidinfo[1]\" height=\"189\" width=\"150\"></a></center>";
	    echo "<p>";
		
  $item = mysql_fetch_array(mysql_query("SELECT uid, id, imageurl, sex FROM dcroxx_me_usergallery WHERE id='".$whoimage."'"));
  $rated = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usergallery_rating WHERE byuid='".$uid."' and imageid ='".$whoimage."'"));
  if(canratephoto($uid, $item[0]) and ($rated[0]==0)){
  echo "<center><small>";
  echo "Rate this members Photo: <b>1=Low</b>, <b>10=High</b><br/>You can also leave a comment for this photo!<br/>-------------------<br/></small>";



    echo "<form action=\"gallery2.php?action=rateuser&amp;whoimage=$whoimage\" method=\"post\">";
	  echo "<small>Comments:</small> 
  <textarea name=\"comment\" format=\"*M\" maxlength=\"200\" style=\"height:30px;width: 270px;\"></textarea><br/>";
	
    echo "<small>Rate:</small> <select name=\"rate\" value=\"$rate[0]\">";
    echo "<option value=\"1\">1 Star (Low)</option>";
    echo "<option value=\"2\">2 Star</option>";
    echo "<option value=\"3\">3 Star</option>";
    echo "<option value=\"4\">4 Star</option>";
    echo "<option value=\"5\">5 Star (Midium)</option>";
    echo "<option value=\"6\">6 Star</option>";
    echo "<option value=\"7\">7 Star</option>";
    echo "<option value=\"8\">8 Star</option>";
    echo "<option value=\"9\">9 Star</option>";
    echo "<option value=\"10\">10 Star (High)</option>";
    echo "</select> ";

  echo "<input type=\"submit\" value=\"Rate\"/>";
  echo "</form>";
  
    echo "</center>";
  }else{
  echo "<center><small>You have already commented this Photo</small></center>";
  }	
		
		
		
		
    $items = mysql_query($sql);

    echo mysql_error();

    if(mysql_num_rows($items)>0)

    {

    while ($item = mysql_fetch_array($items))

    {



 /*   if(isonline($item[2]))

  {

    $iml = "<img src=\"../images/onl.gif\" alt=\"+\"/>";



  }else{

    $iml = "<img src=\"../images/ofl.gif\" alt=\"-\"/>";

  }*/
$avlink = getavatar($item[2]);
if ($avlink==""){
$iml = "<img src=\"images/nopic.jpg\" alt=\"avatar\" width=\"25\" height=\"30\"/>";
}else{
$iml = "<img src=\"$avlink\" alt=\"avatar\" width=\"25\" height=\"30\"/>";
}
  
    if(strlen($item[1])>1){



      $snick = getnick_uid($item[2]);

      $uid1 = getuid_sid($sid);



  		if($uid==$uidinfo[0])

  		{

      		$dellnk = "<a href=\"gallery2.php?action=delvote&amp;whoimage=$item[5]\">(Delete)</a>";

      	}else{

			$dellnk = "";

      	}



      $lnk = "<small><a href=\"index.php?action=viewuser&amp;who=$item[2]\">$iml$snick</a>: 
	  <i>I have rate this photo <b>$item[0]</b> out of <b>10</b></i> $dellnk</small>";

	  echo "$lnk<br/><small>";

      $bs = date("h:s:a jS M Y",$item[3]);

      $text = parsepm($item[1], $sid);

      if(($uid==$uidinfo[0]) and (strlen($item[4])<1))

      {

        $replylink = "<a href=\"gallery2.php?action=commentreply&amp;id=$item[5]\">Reply Comment</a><br/><small><i>($bs)</i></small>";

      }else{

        $replylink = " <small><i>($bs)</i></small>";

      }

      echo "$text";

      if(strlen($item[4])>1)

      {

      $text1 = parsepm($item[4], $sid);

      echo "<br><b><font color=\"red\">Reply</font></b>: <i>$text1</i>";

      }

      echo "<br/>$replylink<br/><br/>";

      echo "</small>";

    }

    }

    }

    echo "</p>";
 }else{
echo "<br/><small><img src=\"pass.gif\" alt=\"*\"/><b>Album Protection <font color=\"red\">ON</font></b> <br/> 
Only friends and staff can view Gallery of this members</small><br/> ";
}
    echo "<p><left>";

    if($page>1)

    {

      $ppage = $page-1;

      echo "<a href=\"gallery2.php?action=$action&amp;page=$ppage&amp;whoimage=$whoimage\"><small>&#171; Prev</small></a> ";

    }

    echo "<small> $page/$num_pages </small>";

    if($page<$num_pages)

    {

      $npage = $page+1;

      echo "<a href=\"gallery2.php?action=$action&amp;page=$npage&amp;whoimage=$whoimage\"><small>Next &#187;</small></a>";

    }



    if($num_pages>2)

    {

        $rets = "<left><form action=\"gallery2.php\" method=\"get\">";

        $rets .= "Jump to Photo:<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";

        $rets .= "<input type=\"submit\" value=\"GO\"/>";

        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";

        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "<input type=\"hidden\" name=\"whoimage\" value=\"$whoimage\"/>";

        $rets .= "<input type=\"hidden\" name=\"page\" value=\"$(pg)\"/>";

        $rets .= "</form></left>";

        echo $rets;

    }

    echo "</left></p>";



  echo "<p><small>";

  echo "<img src=\"images/home.gif\" alt=\"\"><a href=\"index.php?action=main\">Home</a>";

  echo "</small></p>";

exit();


}





////////////////////////////////////////MAKE A COMMENT

else if($action=="commentreply")

{

  addonline(getuid_sid($sid),"Replying to a Photo''s Comment ","");
$pstyle = gettheme($sid);
    echo xhtmlhead("Gallery",$pstyle);
$id = $_GET["id"];



  echo "<center><small>";

  echo "<b>Reply to Comment</b>";

  echo "</small></center><br/>";

  echo "<center>";

  echo "<form action=\"gallery2.php?action=commentreplyaction&amp;id=$id\" method=\"post\">";

  echo "<textarea name=\"reply\" format=\"*M\" maxlength=\"200\"></textarea><br/>";

  echo "<input type=\"submit\" value=\"REPLY\"/>";

  echo "</form>";

  
  echo "<br/><small>";

  echo "<img src=\"images/home.gif\" alt=\"\"><a href=\"index.php?action=main\">Home</a>";

  echo "</small></center>";





exit();
}





////////////////////////////////////////READ VOTES WITHOUT COMMENTS

else if($action=="votes")

{

  addonline(getuid_sid($sid),"Viewing Votes of a Photo ","");

$pstyle = gettheme($sid);
    echo xhtmlhead("Gallery",$pstyle);
echo "<p align=\"left\"><small>";

  echo "<br/>";

  echo "</small></p>";



    if($page=="" || $page<=0)$page=1;

    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usergallery_rating WHERE imageid='".$whoimage."'"));

    $num_items = $noi[0]; //changable

    $items_per_page= 20;

    $num_pages = ceil($num_items/$items_per_page);

    if(($page>$num_pages)&&$page!=1)$page= $num_pages;

    $limit_start = ($page-1)*$items_per_page;



    $imageratinginfo = "SELECT rating, byuid  FROM dcroxx_me_usergallery_rating WHERE imageid='".$item[1]."'";

    $uidinfo = mysql_fetch_array(mysql_query("SELECT uid FROM dcroxx_me_usergallery WHERE id='".$whoimage."'"));



    $sql = "SELECT rating, byuid, time  FROM dcroxx_me_usergallery_rating WHERE imageid ='".$whoimage."' ORDER BY time DESC LIMIT $limit_start, $items_per_page";



    echo "<p><small>";

    $items = mysql_query($sql);

    echo mysql_error();

    if(mysql_num_rows($items)>0)

    {

    while ($item = mysql_fetch_array($items))

    {



$avlink = getavatar($item[1]);
if ($avlink==""){
$iml = "<img src=\"images/nopic.jpg\" alt=\"avatar\" width=\"25\" height=\"30\"/>";
}else{
$iml = "<img src=\"$avlink\" alt=\"avatar\" width=\"25\" height=\"30\"/>";
}



    $snick = getnick_uid($item[1]);

    $uid1 = getuid_sid($sid);



  		if($uid==$uidinfo[0])

  		{

      		$dellnk = "<a href=\"gallery2.php?action=delvote&amp;whoimage=$whoimage\">(x)</a>";

      	}else{

			$dellnk = "";

      	}

      $lnk = "$iml<a href=\"index.php?action=viewuser&amp;who=$item[1]\">$snick</a>: <b>$item[0]</b> out of <b>10</b> $dellnk";

      echo "$lnk<br/>";



    }

    }

    echo "</small></p>";

    echo "<p><left>";

    if($page>1)

    {

      $ppage = $page-1;

      echo "<a href=\"gallery2.php?action=$action&amp;page=$ppage&amp;who=$who\"><small>&#171; Prev</small></a> ";

    }

    echo "<small> $page/$num_pages </small>";

    if($page<$num_pages)

    {

      $npage = $page+1;

      echo "<a href=\"gallery2.php?action=$action&amp;page=$npage&amp;who=$who\"><small>Next &#187;</small></a>";

    }



    if($num_pages>2)

    {

        $rets = "<left><form action=\"gallery2.php\" method=\"get\">";

        $rets .= "Jump to Photo:<input name=\"page\" format=\"*N\" size=\"3\"/>";

        $rets .= "<input type=\"submit\" value=\"GO\"/>";

        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";

        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";

        $rets .= "<input type=\"hidden\" name=\"page\" value=\"$(pg)\"/>";

        $rets .= "</form></left>";

        echo $rets;

    }

    echo "</left></p>";



  echo "<p><small>";

  echo "<img src=\"images/home.gif\" alt=\"\"><a href=\"index.php?action=main\">Home</a>";

  echo "</small></p>";



exit();
}





////////////////////////////////////////RATE USER

else if($action=="rateuser")

{

  addonline(getuid_sid($sid),"Rating a Photo","");$pstyle = gettheme($sid);
    echo xhtmlhead("Gallery",$pstyle);
$rate = $_POST["rate"];

  $comment = $_POST["comment"];



  $uid1 = getuid_sid($sid);

  $item = mysql_fetch_array(mysql_query("SELECT uid, id, imageurl, sex FROM dcroxx_me_usergallery WHERE uid='".$whoimage."'"));



  $rated = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usergallery_rating WHERE byuid='".$uid1."' and imageid ='".$whoimage."'"));



  if(canratephoto($uid1, $item[0]) and ($rated[0]==0))

  {

   echo "<p align=\"left\">";

   $uid = getuid_sid($sid);

   if((strlen($comment))>1){

   $res= mysql_query("INSERT INTO dcroxx_me_usergallery_rating SET imageid='".$whoimage."', rating='".$rate."', comments='".$comment."', byuid='".$uid."', time='".time()."', commentsyn='Y'");

   }else

   if((strlen($comment))<2){

   $res= mysql_query("INSERT INTO dcroxx_me_usergallery_rating SET imageid='".$whoimage."', rating='".$rate."', comments='".$comment."', byuid='".$uid."', time='".time()."', commentsyn='N'");

   }



   if(($res) and ((strlen($comment))>1)){



     echo "<img src=\"images/ok.gif\" alt=\"o\"/>Rated Successfully<br/>";

     echo "<img src=\"images/ok.gif\" alt=\"o\"/>Comments added Successfully<br/>";

   }else

   if(($res) and ((strlen($comment))<2)){



     echo "<img src=\"images/ok.gif\" alt=\"o\"/>Rated Successfully<br/>";

     echo "<img src=\"images/notok.gif\" alt=\"x\"/>No Comments were added<br/>";

   }

   else{

     echo "<img src=\"images/notok.gif\" alt=\"x\"/>Rated unsuccessfully<br/>";

     echo "<img src=\"images/notok.gif\" alt=\"x\"/>No Comments were added<br/>";

   }

   }else{

   echo "You have already rated this Photo";

   }

  echo "</p>";



  echo "<p><small>";

  echo "<a href=\"index.php?action=main\">Home</a>";

  echo "</small></p>";


exit();

}





////////////////////////////////////////REPLY TO COMMENT

else if($action=="commentreplyaction")

{

  addonline(getuid_sid($sid),"Replying To a Photo''s Comment ","");

$pstyle = gettheme($sid);
    echo xhtmlhead("Gallery",$pstyle);

$id = $_GET["id"];

  $reply = $_POST["reply"];



  echo "<p align=\"left\">";

  $uid = getuid_sid($sid);

  $res = mysql_query("UPDATE dcroxx_me_usergallery_rating SET commentsreply='".$reply."' WHERE id='".$id."'");

   if($res){



     echo "<img src=\"images/ok.gif\" alt=\"o\"/>Replyed Successfully<br/>";
         }

   else{

     echo "<img src=\"images/notok.gif\" alt=\"x\"/>Replyed unsuccessfully<br/>";

   }

  echo "</p>";



  echo "<p><small>";

  echo "<a href=\"index.php?action=main\">Home</a>";

  echo "</small></p>";



exit();


}





////////////////////////////////////////UPLOAD PHOTO

else if($action=="upload")

{

  addonline(getuid_sid($sid),"Uploading a Photo ","");
$pstyle = gettheme($sid);
    echo xhtmlhead("Gallery",$pstyle);

$rate = $_POST["rate"];

  $comment = $_POST["comment"];



  echo "<p>";

	echo "<b><small>Gallery Photo Uploader</small></b><br/>";

  	echo "<small>Note:<br/>";

  	echo "* File size limit 512kb. If your upload does not work, try a smaller Photo.<br/>";

  	echo "* Allowed formats: <b>.jpg, .gif, .bmp, .png</b><br/>";

  	echo "* You have the right to distribute the Photo<br/>";

  	echo "* The Photo does not violate the <a href=\"index.php?action=terms\">Terms of Use</a><br/>";

  	echo "<left><br/>Pick a Photo to upload, and press 'Upload'<br/>";

	echo "<form enctype=\"multipart/form-data\" method=\"post\" action=\"upload.php?action=upload\">";

	echo "<input type=\"file\" name=\"my_field\" /><br/>\n";

	//echo "Description: <input name=\"descript\" maxlength=\"100\" size=\"20\"/>";

	echo "<input type=\"hidden\" name=\"action\" value=\"image\" />";

	echo "<INPUT TYPE=\"submit\" name=\"upl\" VALUE=\"Upload\"></form>";

  echo "</left></small></p>";



  echo "<p><small>";

  echo "<a href=\"index.php?action=main\">Home</a>";

  echo " &#62; ";

  echo "<a href=\"gallery2.php?action=main\">Photo gallery</a>";

  echo " &#62; ";

  echo "Uploading a Photo";

  echo "</small></p>";

   exit();
    }





////////////////////////////////////////DEL PHOTO

else if($action=="del")

{





      echo "<p align=\"left\">";

$pstyle = gettheme($sid);
    echo xhtmlhead("Gallery",$pstyle);
$imageurl = mysql_fetch_array(mysql_query("SELECT imageurl FROM dcroxx_me_usergallery WHERE id='".$whoimage."'"));

    $imagename = explode("/",$imageurl[0]);

    $delpath = "usergallery/$imagename[4]";



    $res = mysql_query("DELETE FROM dcroxx_me_usergallery WHERE id='".$whoimage."'");

    $res = mysql_query("DELETE FROM dcroxx_me_usergallery_rating WHERE imageid='".$whoimage."'");



        if($res)

      {

        echo "<img src=\"../images/ok.gif\" alt=\"O\"/>Photo and all the Comments have been deleted";

      }else{

        echo "<img src=\"../images/notok.gif\" alt=\"X\"/>Error deleting Photo";

      }

  echo "</p>";



  echo "<p><small>";

  echo "<a href=\"index.php?action=main\">Home</a>";

  echo " &#62; ";

  echo "<a href=\"gallery2.php?action=main\">Photo gallery</a>";

  echo " &#62; ";

  echo "Deleting a Photo";

  echo "</small></p>";




exit();

}





////////////////////////////////////////DEL COMMENT

else if($action=="delvote")

{



  echo "<p align=\"left\">";

$pstyle = gettheme($sid);
    echo xhtmlhead("Gallery",$pstyle);

if($res)

      {

        echo "<img src=\"../images/ok.gif\" alt=\"O\"/>Photo and all the Comments have been deleted";

      }else{

        echo "<img src=\"../images/notok.gif\" alt=\"X\"/>Error deleting Photo";

      }

  echo "</p>";



  echo "<p><small>";

  echo "<a href=\"index.php?action=main\">Home</a>";

  echo " &#62; ";

  echo "<a href=\"gallery2.php?action=main\">Photo gallery</a>";

  echo " &#62; ";

  echo "Deleting Comment";

  echo "</small></p>";



  exit();

}





////////////////////////////////////////EDIT DESCRIPTION / ADD DESCRIPTION

else if($action=="edtdescript")

{



  echo "<p align=\"left\">";
$pstyle = gettheme($sid);
    echo xhtmlhead("Gallery",$pstyle);

if($res)

      {

        echo "<img src=\"../images/ok.gif\" alt=\"O\"/>Photo and all the Comments have been deleted";

      }else{

        echo "<img src=\"../images/notok.gif\" alt=\"X\"/>Error deleting Photo";

      }

  echo "</p>";



  echo "<p><small>";

  echo "<a href=\"index.php?action=main\">Home</a>";

  echo " &#62; ";

  echo "<a href=\"gallery2.php?action=main\">Photo gallery</a>";

  echo " &#62; ";

  echo "Deleting Comment";

  echo "</small></p>";



   exit();
    }









?>

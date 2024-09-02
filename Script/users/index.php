<?php
include("../config.php");
include("../core.php");
include("outfn.php");
connectdb();
$vars = $_GET;
$a = $_GET["a"];
function isreq($str)
{
	$req = "a.p.b.g";
	$pos = strpos($req, $str);
	if($pos===false)
	{
		return false;
	}
	return true;
}
foreach ($vars as $var => $val)
{
	if (!isreq($var))
	{
		$uname = $var;
		break;
	}
}
$force = "";
//$force = "text/vnd.wap.wml";  //used for debugging
if ($force=="")
{
$mime = ((stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) ? "application/xhtml+xml" : "text/vnd.wap.wml");
}else{
	$mime = $force;
}
$uid = getuid_nick($uname);
$charset = "utf-8";
header("content-type:$mime;charset=$charset");
if($mime=="application/xhtml+xml")
{
echo("<?xml version=\"1.0\"?>\n");
	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
}else{
	echo("<?xml version=\"1.0\"?>\n");
echo "<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\"". " \"http://www.wapforum.org/DTD/wml_1.1.xml\">\n";
}
if ($uid =="" || $uid==0)
{
	printError($mime, USER_NOT_FOUND, $uname);
	exit();
}
if(!isset($a)&&!isset($p)&&!isset($b))
{
$upinfo = mysql_fetch_array(mysql_query("SELECT mimg, msg FROM ibwf_mypage WHERE uid='".$uid."'"));
		$ilink = trim($upinfo[0]);
		if($ilink=="")
		{
			$ilink = "<img src=\"http://retrivewap.co.za/rwidc.php?id=$uid\" alt=\"*\"/>";
		}else{
			$ilink = "<img src=\"$upinfo[0]\" alt=\"*\"/>";
		}
		$msg = trim($upinfo[1]);
		if($msg=="")
		{
			$msg = "-hi- Welcome to $uname's Personal wap page";
		}
		$msg = parseppmsg($msg);
		$pilink = "<a href=\"index.php?$uname&amp;a=pi\">&#187;Personal Info.</a><br/>";
		$pllink = "<a href=\"index.php?$uname&amp;a=pl\">&#187;Poll</a><br/>";
		$bllink = "<a href=\"index.php?$uname&amp;a=bl\">&#187;Blogs</a><br/>";
		$gblink = "<a href=\"index.php?$uname&amp;a=gb\">&#187;Guestbook (rw)</a><br/>";
		$gplink = "<a href=\"index.php?$uname&amp;a=gp\">&#187;Guestbook (Visitors)</a><br/>";
	//show mean page
	if($mime== MIME_TYPE)
	{
		
		//xhtml page
		$pstyle = gettheme($uid);
		echo xhtmlhead($uname."@retrivewap",$pstyle);
		echo "<h3 align=\"center\">".strtoupper($uname)."</h3>\n";
		echo "<p align=\"center\">";
		echo $ilink."<br/><br/>";
		echo $msg;
		echo "</p>";
		echo "<p>";
		echo $pilink;echo $pllink;echo $bllink;echo $gblink;echo $gplink;
		echo "<br/>";
		$lact = mysql_fetch_array(mysql_query("SELECT lastact FROM ibwf_users WHERE id='".$uid."'"));
		$ts = time()-(3*60); //120 seconds
		if($lact[0]>=$ts)
		{
			//user is in retrivewap
			echo "<img src=\"../images/onl.gif\" alt=\"O\"/>$uname is Online<br/>";
			echo "<small>user is loged into retrivewap forums and chat</small>";
		}else{
			echo "<img src=\"../images/ofl.gif\" alt=\"O\"/>$uname is Offline<br/>";
		}
		echo "</p>";
		echo xhtmlfoot();
	}else{
	//wml page
		echo wmlhead($uname."@retrivewap");
		echo "<p align=\"center\"><b>".strtoupper($uname)."</b></p>";
		echo "<p align=\"center\">";
		echo $ilink."<br/><br/>";
		echo $msg;
		echo "</p><p>";
		echo $pilink;echo $pllink;echo $bllink;echo $gblink;echo $gplink;
		echo "</p>";
		echo wmlfoot();
		
	}
}
else
{
	if(isset($a))
	{
		if($a=="pi")
		{
			$bilink = "<a href=\"index.php?$uname&amp;a=bi\">&#187;Basic Info.</a><br/>";
			//$cilink = "<a href=\"index.php?$uname&amp;a=ci\">&#187;Contact Info.</a><br/>";
			$lklink = "<a href=\"index.php?$uname&amp;a=lk\">&#187;Looking</a><br/>";
			$prlink = "<a href=\"index.php?$uname&amp;a=pr\">&#187;Personality</a><br/>";
			$hmlink= "<a href=\"index.php?$uname\">&#171;Back</a><br/>";
			//personal info
			if($mime== MIME_TYPE)
			{
				$pstyle = gettheme($uid);
				echo xhtmlhead($uname."@retrivewap",$pstyle);
				echo "<h3 align=\"center\">".strtoupper($uname)."</h3>\n";
				echo "<p>";
				echo $bilink;echo $cilink;echo $lklink;echo $prlink;echo $hmlink;
				echo "</p>";
				echo xhtmlfoot();
			}
			else
			{
				echo wmlhead($uname."@retrivewap");
				echo "<p align=\"center\"><b>".strtoupper($uname)."</b></p>";
				
				echo "<p>";
				echo $bilink;echo $cilink;echo $lklink;echo $prlink; echo $hmlink;
				echo "</p>";
				echo wmlfoot();
			}
		}
		if($a=="bi")
		{
			$inf1 = mysql_fetch_array(mysql_query("SELECT country, city, street, phoneno, realname, budsonly, sitedscr FROM ibwf_xinfo WHERE uid='".$uid."'"));
	    
	    $inf2 = mysql_fetch_array(mysql_query("SELECT site, email, birthday, sex FROM ibwf_users WHERE id='".$uid."'"));
		$realn = "<b>Name:</b> ".htmlspecialchars($inf1[4])."<br/>";
		$age = "<b>Age:</b> ".getage($inf2[2])."<br/>";
		if($inf2[3] == "M")
		{
			$inf2[3] = "Male";
		}else{
			$inf2[3] = "Female";
		}
		$sex = "<b>Sex:</b> ".htmlspecialchars($inf2[3])."<br/>";
		$loc = "<b>Country:</b> ".htmlspecialchars($inf1[0])."<br/>";
		$sit = "<b>Site:</b> <a href=\"".htmlspecialchars($inf2[0])."\">".htmlspecialchars($inf2[0])."</a><br/>";
		$std = "<b>-&gt;Description:</b> ".htmlspecialchars($inf1[6])."<br/>";
		$eml = "<b>E-mail:</b> ".htmlspecialchars($inf2[1])."<br/>";
		$bklink= "<br/><a href=\"index.php?$uname&amp;a=pi\">&#171;Back</a><br/>";
		$hmlink= "<a href=\"index.php?$uname\">&#171;Home</a><br/>";
			if($mime== MIME_TYPE)
			{
				$pstyle = gettheme($uid);
				echo xhtmlhead($uname."@retrivewap",$pstyle);
				echo "<h3 align=\"center\">".strtoupper($uname)."</h3>\n";
				echo "<p>";
				echo $realn;echo $age;echo $sex;echo $loc;echo $sit;echo $std;echo $eml;echo $bklink;echo $hmlink;
				echo "</p>";
				echo xhtmlfoot();
			}
			else
			{
				echo wmlhead($uname."@retrivewap");
				echo "<p align=\"center\"><b>".strtoupper($uname)."</b></p>";
				
				echo "<p>";
				echo $realn;echo $age;echo $sex;echo $loc;echo $sit;echo $std;echo $eml;echo $bklink;echo $hmlink;
				echo "</p>";
				echo wmlfoot();
			}
		}
		else if($a=="lk")
		{
			$inf1 = mysql_fetch_array(mysql_query("SELECT sexpre, height, weight, racerel, hairtype, eyescolor FROM ibwf_xinfo WHERE uid='".$uid."'"));
	    $inf2 = mysql_fetch_array(mysql_query("SELECT sex FROM ibwf_users WHERE id='".$uid."'"));
		
		if($inf1[0]=="M" && $inf2[0]=="F")
	    {
	      $sxp = "Straight";
	    }else if($inf1[0]=="F" && $inf2[0]=="M")
	    {
	      $sxp = "Straight";
	    }else if($inf1[0]=="M" && $inf2[0]=="M"){
	      $sxp = "Gay";
	    }else if($inf1[0]=="F" && $inf2[0]=="F"){
	      $sxp = "Lesbian";
	    }else if($inf1[0]=="B"){
	      $sxp = "Bisexual";
	    }else{
	      $sxp = "inapplicable";
	    }
		$realn = "<b>Sex Orientation:</b> ".$sxp."<br/>";
		$age = "<b>Height:</b> $inf1[1]<br/>";
		if($inf2[0] == "M")
		{
			$inf2[0] = "Male";
		}else{
			$inf2[0] = "Female";
		}
		$sex = "<b>Sex:</b> $inf2[0]<br/>";
		$loc = "<b>Weight:</b> ".htmlspecialchars($inf1[2])."<br/>";
		$sit = "<b>Ethnic origin:</b> ".htmlspecialchars($inf1[3])."<br/>";
		$std = "<b>Hair:</b> ".htmlspecialchars($inf1[4])."<br/>";
		$eml = "<b>Eyes:</b> ".htmlspecialchars($inf1[5])."<br/>";
		$bklink= "<br/><a href=\"index.php?$uname&amp;a=pi\">&#171;Back</a><br/>";
		$hmlink= "<a href=\"index.php?$uname\">&#171;Home</a><br/>";
			if($mime== MIME_TYPE)
			{
				$pstyle = gettheme($uid);
				echo xhtmlhead($uname."@retrivewap",$pstyle);
				echo "<h3 align=\"center\">".strtoupper($uname)."</h3>\n";
				echo "<p>";
				echo $sex;echo $realn;echo $age;echo $loc;echo $sit;echo $std;echo $eml;echo $bklink;echo $hmlink;
				echo "</p>";
				echo xhtmlfoot();
			}
			else
			{
				echo wmlhead($uname."@retrivewap");
				echo "<p align=\"center\"><b>".strtoupper($uname)."</b></p>";
				
				echo "<p>";
				echo $sex;echo $realn;echo $age;echo $loc;echo $sit;echo $std;echo $eml;echo $bklink;echo $hmlink;
				echo "</p>";
				echo wmlfoot();
			}
		}
		else if($a=="pr")
		{
			$inf1 = mysql_fetch_array(mysql_query("SELECT likes, deslikes, habitsb, habitsg, favsport, favmusic, moretext FROM ibwf_xinfo WHERE uid='".$uid."'"));
		$realn = "<b>Likes:</b> ".parseppmsg($inf1[0])."<br/>";
		$age = "<b>Dislikes:</b> ".parseppmsg($inf1[1])."<br/>";
		$loc = "<b>Bad habbits:</b> ".parseppmsg($inf1[2])."<br/>";
		$sit = "<b>Good habbits:</b> ".parseppmsg($inf1[3])."<br/>";
		$std = "<b>Sport:</b> ".parseppmsg($inf1[4])."<br/>";
		$eml = "<b>Music:</b> ".parseppmsg($inf1[5])."<br/>";
		$mrtxt = "<b>More text:</b> ".parseppmsg($inf1[6])."<br/>";
		$bklink= "<br/><a href=\"index.php?$uname&amp;a=pi\">&#171;Back</a><br/>";
		$hmlink= "<a href=\"index.php?$uname\">&#171;Home</a><br/>";
			if($mime== MIME_TYPE)
			{
				$pstyle = gettheme($uid);
				echo xhtmlhead($uname."@retrivewap",$pstyle);
				echo "<h3 align=\"center\">".strtoupper($uname)."</h3>\n";
				echo "<p>";
				echo $realn;echo $age;echo $loc;echo $sit;echo $std;echo $eml;echo $mrtxt;echo $bklink;echo $hmlink;
				echo "</p>";
				echo xhtmlfoot();
			}
			else
			{
				echo wmlhead($uname."@retrivewap");
				echo "<p align=\"center\"><b>".strtoupper($uname)."</b></p>";
				
				echo "<p>";
				echo $realn;echo $age;echo $loc;echo $sit;echo $std;echo $eml;echo $mrtxt;echo $bklink;echo $hmlink;
				echo "</p>";
				echo wmlfoot();
			}
		}
		else if($a=="pl")
		{
			$pl = mysql_fetch_array(mysql_query("SELECT pollid FROM ibwf_users WHERE id='".$uid."'"));
			if($pl[0]==0 || $pl[0]=="")
			{
				$body = "this user has no Poll<br/>";
			}else{
				$plinfo = mysql_fetch_array(mysql_query("SELECT pqst, opt1, opt2, opt3, opt4, opt5 FROM ibwf_polls WHERE id='".$pl[0]."'"));
				$plqst = parseppmsg($plinfo[0])."<br/><br/>";
				$plans = "";
				$allvt = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_pp_pres WHERE pid='".$pl[0]."'"));
				for($i=1;$i<=5;$i++)
				{
				if(trim($plinfo[$i])!="")
				{
					$plres = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_pp_pres WHERE ans='".$i."' AND pid='".$pl[0]."'"));
					$vt = $plres[0];
					if($allvt[0]>0)
					{
					$prc = ceil(($vt/$allvt[0])*100);
					$prc .= "%";
					}else{
						$prc = "0%";
					}
					
					$plans .= "<a href=\"index.php?$uname&amp;p=$pl[0]&amp;r=$i\">".parseppmsg($plinfo[$i])."</a>($vt: $prc)<br/>";
				}
				}
				$body = $plqst.$plans;
			}
			$hmlink= "<br/><a href=\"index.php?$uname\">&#171;Home</a><br/>";
			$body .= $hmlink;
			if($mime== MIME_TYPE)
			{
				$pstyle = gettheme($uid);
				echo xhtmlhead($uname."@retrivewap",$pstyle);
				echo "<h3 align=\"center\">".strtoupper($uname)."</h3>\n";
				echo "<p>";
				echo $body;
				echo "</p>";
				echo xhtmlfoot();
			}
			else
			{
				echo wmlhead($uname."@retrivewap");
				echo "<p align=\"center\"><b>".strtoupper($uname)."</b></p>";
				
				echo "<p>";
				echo $body;
				echo "</p>";
				echo wmlfoot();
			}
		}
		else if($a=="bl")
		{
			$g = $_GET["g"];
			if($g=="" || $g<=0)$g=1;
			$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_blogs WHERE bowner='".$uid."'"));
			$num_items = $noi[0]; //changable
			$items_per_page= 10;
			$num_pages = ceil($num_items/$items_per_page);
			if(($g>$num_pages)&&$g!=1)$g= $num_pages;
			$limit_start = ($g-1)*$items_per_page;
			$sql = "SELECT id, bname FROM ibwf_blogs WHERE bowner='".$uid."' ORDER BY bgdate DESC LIMIT $limit_start, $items_per_page";
			$items = mysql_query($sql);
			$blogs = "";
			while ($item = mysql_fetch_array($items))
			{
				$bname = htmlspecialchars($item[1]);
				$blogs .= "<a href=\"index.php?$uname&amp;b=$item[0]\">&#187;$bname</a><br/>";
			}
			if($mime== MIME_TYPE)
			{
				$pstyle = gettheme($uid);
				echo xhtmlhead($uname."@retrivewap",$pstyle);
				echo "<h3 align=\"center\">".strtoupper($uname)."</h3>\n";
				echo "<p>";
				echo $blogs;
				echo "</p>";
				echo "<p align=\"center\">";
			    if($g>1)
			    {
			      $ppage = $g-1;
			      echo "<a href=\"index.php?$uname&amp;a=bl&amp;g=$ppage\">&#171;Prev</a> ";
			    }
			    if($g<$num_pages)
			    {
			      $npage = $g+1;
			      echo "<a href=\"index.php?$uname&amp;a=bl&amp;g=$npage\">Next&#187;</a>";
			    }
				if($num_pages>1)
				{
			    echo "<br/>$g/$num_pages<br/>";
				}
			    if($num_pages>2)
			    {
					$rets = "<form action=\"index.php\" method=\"get\">";
					$rets .= "<input type=\"hidden\" name=\"$uname\"/>";
					$rets .= "<input type=\"hidden\" name=\"a\" value=\"$a\"/>";
					$rets .= "Jump to page<input type=\"text\" name=\"g\" size=\"3\"/>";
			        $rets .= "<input type=\"submit\" value=\"GO\"/>";
			        $rets .= "</form>";

			        echo $rets;
			    }
				echo "</p>";
				echo "<p align=\"center\">";
				$hmlink= "<a href=\"index.php?$uname\">Home</a><br/>";
				echo $hmlink."</p>";
				echo xhtmlfoot();
			}
			else
			{
				echo wmlhead($uname."@retrivewap");
				echo "<p align=\"center\"><b>".strtoupper($uname)."</b></p>";
				echo "<p>";
				echo $blogs;
				echo "</p>";
				echo "<p align=\"center\">";
			    if($g>1)
			    {
			      $ppage = $g-1;
			      echo "<a href=\"index.php?$uname&amp;a=bl&amp;g=$ppage\">&#171;Prev</a> ";
			    }
			    if($g<$num_pages)
			    {
			      $npage = $g+1;
			      echo "<a href=\"index.php?$uname&amp;a=bl&amp;g=$npage\">Next&#187;</a>";
			    }
				if($num_pages>1)
				{
			    echo "<br/>$g/$num_pages<br/>";
				}
			    if($num_pages>2)
			    {
					$rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
			        $rets .= "<anchor>[GO]";
			        $rets .= "<go href=\"index.php?$uname\" method=\"get\">";
			        $rets .= "<postfield name=\"a\" value=\"$a\"/>";
			        $rets .= "<postfield name=\"g\" value=\"$(pg)\"/>";
			        $rets .= "</go></anchor>";

			        echo $rets;
			    }
				echo "</p>";
				echo "<p align=\"center\">";
				$hmlink= "<a href=\"index.php?$uname\">Home</a><br/>";
				echo $hmlink."</p>";
				echo wmlfoot();
			}
		}
		else if($a=="gb")
		{
			$g = $_GET["g"];
			if($g=="" || $g<=0)$g=1;
			$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_gbook WHERE gbowner='".$uid."'"));
			$num_items = $noi[0]; //changable
			$items_per_page= 5;
			$num_pages = ceil($num_items/$items_per_page);
			if(($g>$num_pages)&&$g!=1)$g= $num_pages;
			$limit_start = ($g-1)*$items_per_page;
			$sql = "SELECT id, gbmsg, gbsigner, dtime FROM ibwf_gbook WHERE gbowner='".$uid."' ORDER BY dtime DESC LIMIT $limit_start, $items_per_page";
			$items = mysql_query($sql);
			$blogs = "";
			while ($item = mysql_fetch_array($items))
			{
				$blogs .= "<b>".getnick_uid($item[2])."</b>";
				$blogs .= "<small>(".date("d-m-Y H:i",$item[3]).")</small><br/>";
				$blogs .= parseppmsg($item[1])."<br/><br/>";
			}
			if($mime== MIME_TYPE)
			{
				$pstyle = gettheme($uid);
				echo xhtmlhead($uname."@retrivewap",$pstyle);
				echo "<h3 align=\"center\">".strtoupper($uname)."</h3>\n";
				echo "<p align=\"center\">";
				echo "<small>This is read only of signatures by retrivewap members</small>";
				echo "</p>";
				echo "<p>";
				echo $blogs;
				echo "</p>";
				echo "<p align=\"center\">";
			    if($g>1)
			    {
			      $ppage = $g-1;
			      echo "<a href=\"index.php?$uname&amp;a=$a&amp;g=$ppage\">&#171;Prev</a> ";
			    }
			    if($g<$num_pages)
			    {
			      $npage = $g+1;
			      echo "<a href=\"index.php?$uname&amp;a=$a&amp;g=$npage\">Next&#187;</a>";
			    }
				if($num_pages>1)
				{
			    echo "<br/>$g/$num_pages<br/>";
				}
			    if($num_pages>2)
			    {
					$rets = "<form action=\"index.php\" method=\"get\">";
					$rets .= "<input type=\"hidden\" name=\"$uname\"/>";
					$rets .= "<input type=\"hidden\" name=\"a\" value=\"$a\"/>";
					$rets .= "Jump to page<input type=\"text\" name=\"g\" size=\"3\"/>";
			        $rets .= "<input type=\"submit\" value=\"GO\"/>";
			        $rets .= "</form>";

			        echo $rets;
			    }
				echo "</p>";
				echo "<p align=\"center\">";
				$hmlink= "<a href=\"index.php?$uname\">Home</a><br/>";
				echo $hmlink."</p>";
				echo xhtmlfoot();
			}
			else
			{
				echo wmlhead($uname."@retrivewap");
				echo "<p align=\"center\"><b>".strtoupper($uname)."</b></p>";
				echo "<p align=\"center\">";
				echo "<small>This is read only of signatures by retrivewap members</small>";
				echo "</p>";
				echo "<p>";
				echo $blogs;
				echo "</p>";
				echo "<p align=\"center\">";
			    if($g>1)
			    {
			      $ppage = $g-1;
			      echo "<a href=\"index.php?$uname&amp;a=$a&amp;g=$ppage\">&#171;Prev</a> ";
			    }
			    if($g<$num_pages)
			    {
			      $npage = $g+1;
			      echo "<a href=\"index.php?$uname&amp;a=$a&amp;g=$npage\">Next&#187;</a>";
			    }
				if($num_pages>1)
				{
			    echo "<br/>$g/$num_pages<br/>";
				}
			    if($num_pages>2)
			    {
					$rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
			        $rets .= "<anchor>[GO]";
			        $rets .= "<go href=\"index.php?$uname\" method=\"get\">";
			        $rets .= "<postfield name=\"a\" value=\"$a\"/>";
			        $rets .= "<postfield name=\"g\" value=\"$(pg)\"/>";
			        $rets .= "</go></anchor>";

			        echo $rets;
			    }
				echo "</p>";
				echo "<p align=\"center\">";
				$hmlink= "<a href=\"index.php?$uname\">Home</a><br/>";
				echo $hmlink."</p>";
				echo wmlfoot();
			}
		}
		else if($a=="gp")
		{
			$g = $_GET["g"];
			if($g=="" || $g<=0)$g=1;
			$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_pp_gbook WHERE uid='".$uid."'"));
			$num_items = $noi[0]; //changable
			$items_per_page= 5;
			$num_pages = ceil($num_items/$items_per_page);
			if(($g>$num_pages)&&$g!=1)$g= $num_pages;
			$limit_start = ($g-1)*$items_per_page;
			$sql = "SELECT id, sname, semail, stext, sdate FROM ibwf_pp_gbook WHERE uid='".$uid."' ORDER BY sdate DESC LIMIT $limit_start, $items_per_page";
			$items = mysql_query($sql);
			$blogs = "";
			while ($item = mysql_fetch_array($items))
			{
				$blogs .= "<b>".$item[1]."</b>";
				$blogs .= "<small>(".date("d-m-Y H:i",$item[4]).")</small><br/>";
				$blogs .= parseppmsg($item[3])."<br/><br/>";
			}
			if($mime== MIME_TYPE)
			{
				$pstyle = gettheme($uid);
				echo xhtmlhead($uname."@retrivewap",$pstyle);
				echo "<h3 align=\"center\">".strtoupper($uname)."</h3>\n";
				
				echo "<p>";
				echo $blogs;
				echo "</p>";
				echo "<p align=\"center\">";
			    if($g>1)
			    {
			      $ppage = $g-1;
			      echo "<a href=\"index.php?$uname&amp;a=$a&amp;g=$ppage\">&#171;Prev</a> ";
			    }
			    if($g<$num_pages)
			    {
			      $npage = $g+1;
			      echo "<a href=\"index.php?$uname&amp;a=$a&amp;g=$npage\">Next&#187;</a>";
			    }
				if($num_pages>1)
				{
			    echo "<br/>$g/$num_pages<br/>";
				}
			    if($num_pages>2)
			    {
					$rets = "<form action=\"index.php\" method=\"get\">";
					$rets .= "<input type=\"hidden\" name=\"$uname\"/>";
					$rets .= "<input type=\"hidden\" name=\"a\" value=\"$a\"/>";
					$rets .= "Jump to page<input type=\"text\" name=\"g\" size=\"3\"/>";
			        $rets .= "<input type=\"submit\" value=\"GO\"/>";
			        $rets .= "</form>";

			        echo $rets;
			    }
				echo "</p>";
				echo "<p align=\"center\">";
				$snlink = "<a href=\"index.php?$uname&amp;a=sn\">Sign guestbook</a><br/>";
				echo $snlink;
				$hmlink= "<a href=\"index.php?$uname\">Home</a><br/>";
				echo $hmlink."</p>";
				echo xhtmlfoot();
			}
			else
			{
				echo wmlhead($uname."@retrivewap");
				echo "<p align=\"center\"><b>".strtoupper($uname)."</b></p>";
				
				echo "<p>";
				echo $blogs;
				echo "</p>";
				echo "<p align=\"center\">";
			    if($g>1)
			    {
			      $ppage = $g-1;
			      echo "<a href=\"index.php?$uname&amp;a=$a&amp;g=$ppage\">&#171;Prev</a> ";
			    }
			    if($g<$num_pages)
			    {
			      $npage = $g+1;
			      echo "<a href=\"index.php?$uname&amp;a=$a&amp;g=$npage\">Next&#187;</a>";
			    }
				if($num_pages>1)
				{
			    echo "<br/>$g/$num_pages<br/>";
				}
			    if($num_pages>2)
			    {
					$rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
			        $rets .= "<anchor>[GO]";
			        $rets .= "<go href=\"index.php?$uname\" method=\"get\">";
			        $rets .= "<postfield name=\"a\" value=\"$a\"/>";
			        $rets .= "<postfield name=\"g\" value=\"$(pg)\"/>";
			        $rets .= "</go></anchor>";

			        echo $rets;
			    }
				echo "</p>";
				echo "<p align=\"center\">";
				$snlink = "<a href=\"index.php?$uname&amp;a=sn\">Sign guestbook</a><br/>";
				echo $snlink;
				$hmlink= "<a href=\"index.php?$uname\">Home</a><br/>";
				echo $hmlink."</p>";
				echo wmlfoot();
			}
		}
		else if($a=="sn")
		{
			if($mime== MIME_TYPE)
			{
				$pstyle = gettheme($uid);
				echo xhtmlhead($uname."@retrivewap",$pstyle);
				echo "<h3 align=\"center\">".strtoupper($uname)."</h3>\n";
				
				echo "<p>";
				?>
				<form action="index.php?<?=$uname?>&amp;a=sg" method="post">
				Your name:<input type="text" name="snm" maxlength="15"/><br/>
				Your e-mail:<input type="text" name="eml" maxlength="100"/><small>visible for the site owner only</small><br/>
				Message:<input type="text" name="msg" maxlength="500"/><small>use [br/] for new line, don't use it more than 3 times though</small><br/>
				<input type="submit" value="Send"/>
				</form>
				<?php
				echo "</p>";
				
				echo "<p align=\"center\">";
				$hmlink= "<a href=\"index.php?$uname\">Home</a><br/>";
				echo $hmlink."</p>";
				echo xhtmlfoot();
			}
			else
			{
				echo wmlhead($uname."@retrivewap");
				echo "<p align=\"center\"><b>".strtoupper($uname)."</b></p>";
				
				echo "<p>";
				?>
				Your name:<input  name="snm" maxlength="15"/><br/>
				Your e-mail:<input  name="eml" maxlength="100"/><small>visible for the site owner only</small><br/>
				Message:<input  name="msg" maxlength="500"/><small>use [br/] for new line, don't use it more than 3 times though</small><br/>
				<anchor>Send<go href="index.php?<?=$uname?>&amp;a=sg" method="post">
				<postfield name="snm" value="$(snm)"/>
				<postfield name="eml" value="$(eml)"/>
				<postfield name="msg" value="$(msg)"/>
				</go></anchor>
				<?php
				
				echo "</p>";
				
				echo "<p align=\"center\">";
				$hmlink= "<a href=\"index.php?$uname\">Home</a><br/>";
				echo $hmlink."</p>";
				echo wmlfoot();
			}
		}
		
		else if($a=="sg")
		{
			$snm = trim($_POST["snm"]);
			$eml = trim($_POST["eml"]);
			$msg = trim($_POST["msg"]);
			if(strlen($snm)<4)
			{
				$outres = "<img src=\"../images/notok.gif\" alt=\"X\"/>Your name should be 4 characters or more";
			}
			else if(strlen($msg)<10)
			{
				$outres = "<img src=\"../images/notok.gif\" alt=\"X\"/>Message too short";
			}
			else{
				$res = mysql_query("INSERT INTO ibwf_pp_gbook SET uid='".$uid."', sname='".$snm."', semail='".$eml."', stext='".$msg."', sdate='".time()."'");
				if($res)
				{
					$outres = "<img src=\"../images/ok.gif\" alt=\"O\"/>Message submitted successfully";
				}else
				{
					$outres = "<img src=\"../images/notok.gif\" alt=\"X\"/>Database Error";
				}
			}
			if($mime== MIME_TYPE)
			{
				
				$pstyle = gettheme($uid);
				echo xhtmlhead($uname."@retrivewap",$pstyle);
				echo "<h3 align=\"center\">".strtoupper($uname)."</h3>\n";
				
				echo "<p>";
				echo $outres;
				echo "</p>";
				
				echo "<p align=\"center\">";
				$hmlink= "<a href=\"index.php?$uname\">Home</a><br/>";
				echo $hmlink."</p>";
				echo xhtmlfoot();
			}
			else
			{
				echo wmlhead($uname."@retrivewap");
				echo "<p align=\"center\"><b>".strtoupper($uname)."</b></p>";
				
				echo "<p>";
				echo $outres;
				
				echo "</p>";
				
				echo "<p align=\"center\">";
				$hmlink= "<a href=\"index.php?$uname\">Home</a><br/>";
				echo $hmlink."</p>";
				echo wmlfoot();
			}
		}
	}
	else if(isset($p))
	{
			$r = $_GET["r"];
			$pl = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_polls WHERE id='".$p."'"));
			if($pl[0]==0)
			{
				$body = "this poll doesnt exist<br/>";
			}else{
				$anx = mysql_fetch_array(mysql_query("SELECT opt1, opt2, opt3, opt4, opt5 FROM ibwf_polls WHERE id='".$p."'"));
				if(trim($anx[$r-1])=="")
				{
					$body = "answer doesnt exist<br/>";
				}else{
					mysql_query("INSERT INTO ibwf_pp_pres SET pid='".$p."', ans='".$r."'");
					$body = "You have voted successfully, return to <a href=\"index.php?$uname&amp;a=pl\">POLL</a><br/>";
				}
			}
			$hmlink= "<br/><a href=\"index.php?$uname\">&#171;Home</a><br/>";
			$body .= $hmlink;
			if($mime== MIME_TYPE)
			{
				$pstyle = gettheme($uid);
				echo xhtmlhead($uname."@retrivewap",$pstyle);
				echo "<h3 align=\"center\">".strtoupper($uname)."</h3>\n";
				echo "<p>";
				echo $body;
				echo "</p>";
				echo xhtmlfoot();
			}
			else
			{
				echo wmlhead($uname."@retrivewap");
				echo "<p align=\"center\"><b>".strtoupper($uname)."</b></p>";
				
				echo "<p>";
				echo $body;
				echo "</p>";
				echo wmlfoot();
			}
	}
	else if(isset($b))
	{
			$b = $_GET["b"];
			$blin = mysql_fetch_array(mysql_query("SELECT bname, btext, bgdate FROM ibwf_blogs WHERE id='".$b."'"));
			$body = "<b>".htmlspecialchars($blin[0])."</b><br/><br/>";
			$body .= parseppmsg($blin[1])."<br/>";
			$body .= "<br/><small>".date("d-m-Y (H:i)", $blin[2])."</small><br/>";
			$hmlink = "<br/><a href=\"index.php?$uname&amp;a=bl\">&#171;$uname's Blogs</a>";
			$hmlink .= "<br/><a href=\"index.php?$uname\">&#171;Home</a><br/>";
			$body .= $hmlink;
			if($mime== MIME_TYPE)
			{
				$pstyle = gettheme($uid);
				echo xhtmlhead($uname."@retrivewap",$pstyle);
				echo "<h3 align=\"center\">".strtoupper($uname)."</h3>\n";
				echo "<p>";
				echo $body;
				echo "</p>";
				echo xhtmlfoot();
			}
			else
			{
				echo wmlhead($uname."@retrivewap");
				echo "<p align=\"center\"><b>".strtoupper($uname)."</b></p>";
				
				echo "<p>";
				echo $body;
				echo "</p>";
				echo wmlfoot();
			}
	}
	
}
?>
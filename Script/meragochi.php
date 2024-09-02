<?php
session_name("PHPSESSID");
session_start();

/////////////////script load time
$time = microtime();
$time = explode(" ", $time);
$time = $time[1] + $time[0];
$start = $time;
//////////////////Includes
include("config.php");
include("core.php");
include("xhtmlfunctions.php");
echo '<?xml version="1.0" encoding="UTF-8"?>'; 
//echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<head>
<title><?php echo "SocialBD"; ?></title>
<meta forua="true" http-equiv="Cache-Control" content="no-cache"/>
<meta forua="true" http-equiv="Cache-Control" content="must-revalidate"/>
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
      <link rel="shortcut icon" href="images/favicon.ico" />
      <link rel="icon" href="favicon.ico"/>
<?php
$bcon = connectdb();
$sid = $_SESSION['sid'];
echo gettheme($sid);
getbrip($sid);
?>
</head>
<body>
<?php
$page = $_GET['page'];
$who = $_GET['who'];
$action = $_GET['action'];
$uid = getuid_sid($sid);
//////////////DB connection failed
if (!$bcon){
echo "<p align=\"center\">
ERROR! Couldn't connect to database!<br/><br/>
Sorry for the interruption! Please try <a href=\"index.php?action=main\">refresh</a>ing this page and if it doesn't work then try after sometime.<br/><br/>
<b>Thanks,<br/>With regards,<br/>$sitename Team!</b>
</p>
</font></body>
</html>";
exit();
}
cleardata();
/////////////Session not legal??
if(($action != "") && ($action!="terms")){
if((islogged($sid)==false)||($uid==0)){
boxstart("Error!");
echo "<center><img src=\"images/notok.gif\" alt=\"\"/>You are not logged in<br/>";
echo "or your session has expired.<br/><br/>";
echo "
			 
			  <form action=\"login.php\" method=\"get\">
			     <img src=\"images/user.gif\" alt=\"\"/>Enter username:<br/>
			       <input id=\"inputText\" name=\"loguid\" maxlength=\"30\"/><br/>
                             <img src=\"images/pass.gif\" alt=\"\"/>Enter password:<br/>
			       <input id=\"inputText\" type=\"password\" format=\"*x\" name=\"logpwd\"  maxlength=\"30\"/><br/>
                               <input id=\"inputButton\" type=\"submit\" value=\"Login\"/><br/>
			  </form>
                          <br/><br/><img src=\"images/register.gif\" alt=\"\"/><a href=\"register.php\">Register</a>
                               <br/><img src=\"images/home.gif\" alt=\"\"/><a href=\"index.php\">Home</a>
			       </center>";
boxend();
echo "</font></body></html>";
exit();
}
}
//////////////////User Banned?
if(isbanned($uid)){
boxstart("Error!");
echo "<img src=\"images/notok.gif\" alt=\"\"/><center>";
echo "You are presently banned!<br/><br/>";
$banto = mysql_fetch_array(mysql_query("SELECT timeto FROM dcroxx_me_penalties WHERE uid='".$uid."' AND penalty='1'"));
$remain = $banto[0]- time();
$rmsg = gettimemsg($remain);
echo "Time to finish your penalty: $rmsg<br/><br/>";
echo "</center>";
boxend();
echo "</font></body>";
echo "</html>";
exit();
}
/////////////////////////////////////////////////////

if($action=="main")
{
  addonline(getuid_sid($sid),"Meragochi","");
  
 // boxstart("Create A Free Pet!");
   
	
		
			

  echo "<p align=\"center\"><small>";
  echo "<img src=\"images/meragochi.jpg\" alt=\"meragochi\"/><br/>";
	echo "<b>Meragochi</b><br/>";
	echo "Here You Can Create Your Own Virtual Pet<br/>";
echo "<a href=\"meragochi.php?action=sta\">All Pet Statuses</a><br/>";
$dal = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM meragochi WHERE uid='".getuid_sid($sid)."' AND ziv='1'"));
 if($dal[0]==0)
 { 
 echo "<a href=\"meragochi.php?action=usvoji\">Create a meragochi</a>";
$imal = mysql_fetch_array(mysql_query("SELECT rodjen, smrt FROM meragochi WHERE uid='".getuid_sid($sid)."' AND ziv='0'"));
$zivio = $imal[1] - $imal[0];
if($zivio==0)
{
echo "";
}
else{
     $nopl = mysql_fetch_array(mysql_query("SELECT rodjen, smrt FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
	 $sage = $nopl[1]-$nopl[0];
	 $oflls = ceil(($sage/(1*60))-1);
	 $ofllss = ceil($sage-($oflls*60));
	 $ofllh = ceil(($sage/(1*60*60))-1);
	 $ofllhh = ceil($oflls-($ofllh*60));
	 $oflld = ceil(($sage/(24*60*60))-1);
	 $oflldd = ceil($ofllh-($oflld*24));
  if ($sage <= "60") $ofll1 = "$sage sec";
  if ($sage <= "3599" AND $sage > "60") $ofll1 = "$oflls min, $ofllss sec";
  if ($sage <= "86399" AND $sage >= "3600") $ofll1 = "$ofllh h, $ofllhh min";
  if ($sage >= "86400") $ofll1 = "$oflld day, $oflldd h";

echo "<br/><br/>Your meragochi <b>$ofll1</b>";
}
 	echo "</small>";
  } else {
echo "</small>";
echo "</p>";
echo "<p align=\"center\"><small>";
$meragochi = mysql_fetch_array(mysql_query("SELECT ziv, ime, boja, tezina, rodjen, raspolozenje, broj FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
echo "Name: <b>$meragochi[1]</b><br/>";

     $nopl = mysql_fetch_array(mysql_query("SELECT rodjen FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
	 $sage = time()-$nopl[0];
	 $oflls = ceil(($sage/(1*60))-1);
	 $ofllss = ceil($sage-($oflls*60));
	 $ofllh = ceil(($sage/(1*60*60))-1);
	 $ofllhh = ceil($oflls-($ofllh*60));
	 $oflld = ceil(($sage/(24*60*60))-1);
	 $oflldd = ceil($ofllh-($oflld*24));
  if ($sage <= "60") $ofll1 = "$sage sec";
  if ($sage <= "3599" AND $sage > "60") $ofll1 = "$oflls min, $ofllss sec";
  if ($sage <= "86399" AND $sage >= "3600") $ofll1 = "$ofllh h, $ofllhh min";
  if ($sage >= "86400") $ofll1 = "$oflld days, $oflldd h";

echo "age: <b>$ofll1</b><br/>";
echo "colour: <b>$meragochi[2]</b><br/>";
echo "weight is: <b>$meragochi[3] g</b><br/>";
echo "cheerfull will finish in: <b>$meragochi[5]</b><br/>";
echo "This is your: <b>$meragochi[6].</b> meragochi<br/>";
echo "<br/>";
echo "<a href=\"meragochi.php?action=hrana\">Feed it</a><br/>";
echo "<a href=\"meragochi.php?action=igra\">Have fun</a><br/>";
echo "<a href=\"meragochi.php?action=kupanje\">Wash it</a><br/>";
echo "</small></p><p>";		
}
echo "</p>";
echo "<p align=\"center\"><small>";
$ukupno = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM meragochi WHERE ziv='1'"));
echo "stats: <a href=\"meragochi.php?action=statistika\">$ukupno[0]</a><br/>";
$memid = mysql_fetch_array(mysql_query("SELECT uid, ime FROM meragochi ORDER BY rodjen DESC LIMIT 0,1"));
$nick = getnick_uid($memid[0]);
echo "The youngest meragochi <b>$memid[1]</b> is owned by $nick ";
     $nopl = mysql_fetch_array(mysql_query("SELECT rodjen FROM meragochi WHERE uid='".$memid[0]."'"));
	 $sage = time()-$nopl[0];
	 $oflls = ceil(($sage/(1*60))-1);
	 $ofllss = ceil($sage-($oflls*60));
	 $ofllh = ceil(($sage/(1*60*60))-1);
	 $ofllhh = ceil($oflls-($ofllh*60));
	 $oflld = ceil(($sage/(24*60*60))-1);
	 $oflldd = ceil($ofllh-($oflld*24));
  if ($sage <= "60") $ofll1 = "$sage sec";
  if ($sage <= "3599" AND $sage > "60") $ofll1 = "$oflls min, $ofllss sec";
  if ($sage <= "86399" AND $sage >= "3600") $ofll1 = "$ofllh h, $ofllhh min";
  if ($sage >= "86400") $ofll1 = "$oflld days, $oflldd h";
echo "($ofll1)<br/>";
$memid = mysql_fetch_array(mysql_query("SELECT uid, ime FROM meragochi WHERE ziv='1' ORDER BY rodjen LIMIT 0,1"));
$nick = getnick_uid($memid[0]);
echo "Random Pets <b>$memid[1]</b> is owned by $nick ";
     $nopl = mysql_fetch_array(mysql_query("SELECT rodjen FROM meragochi WHERE uid='".$memid[0]."'"));
	 $sage = time()-$nopl[0];
	 $oflls = ceil(($sage/(1*60))-1);
	 $ofllss = ceil($sage-($oflls*60));
	 $ofllh = ceil(($sage/(1*60*60))-1);
	 $ofllhh = ceil($oflls-($ofllh*60));
	 $oflld = ceil(($sage/(24*60*60))-1);
	 $oflldd = ceil($ofllh-($oflld*24));
  if ($sage <= "60") $ofll1 = "$sage sec";
  if ($sage <= "3599" AND $sage > "60") $ofll1 = "$oflls min, $ofllss sec";
  if ($sage <= "86399" AND $sage >= "3600") $ofll1 = "$ofllh h, $ofllhh min";
  if ($sage >= "86400") $ofll1 = "$oflld days, $oflldd h";
echo "($ofll1)<br/>";
$memid = mysql_fetch_array(mysql_query("SELECT uid, ime, raspolozenje FROM meragochi ORDER BY raspolozenje DESC LIMIT 0,1"));
$nick = getnick_uid($memid[0]);
echo "The happiest meragochi <b>$memid[1]</b> is $nick ($memid[2])<br/>";

    echo "</p>";     
  boxend();


  exit();
    }
//////////////////////////////////
if($action=="statistika")
{
  addonline(getuid_sid($sid),"Meragochi","");
  
 boxstart("Meragochi Stats!");
					
  echo "<p align=\"center\">";
  echo "<img src=\"images/meragochi.jpg\" alt=\"meragochi\"/><br/>";
	echo "<b>Meragochi</b><br/>";
	echo "<small>Stats<br/>";
$ukupno = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM meragochi WHERE ziv='1'"));
echo "Total Meragotchis: $ukupno[0]";
echo "</small>";
echo "</p>";

    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
  $num_items = $ukupno[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

    $sql = "SELECT uid, ime, tezina, rodjen, boja, broj, raspolozenje FROM meragochi WHERE ziv='1' ORDER BY rodjen DESC LIMIT $limit_start, $items_per_page";

    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
     $nopl = mysql_fetch_array(mysql_query("SELECT rodjen FROM meragochi WHERE uid='".$item[0]."'"));
	 $sage = time()-$nopl[0];
	 $oflls = ceil(($sage/(1*60))-1);
	 $ofllss = ceil($sage-($oflls*60));
	 $ofllh = ceil(($sage/(1*60*60))-1);
	 $ofllhh = ceil($oflls-($ofllh*60));
	 $oflld = ceil(($sage/(24*60*60))-1);
	 $oflldd = ceil($ofllh-($oflld*24));
  if ($sage <= "60") $ofll1 = "$sage sec";
  if ($sage <= "3599" AND $sage > "60") $ofll1 = "$oflls min, $ofllss sec";
  if ($sage <= "86399" AND $sage >= "3600") $ofll1 = "$ofllh h, $ofllhh min";
  if ($sage >= "86400") $ofll1 = "$oflld day, $oflldd h";
$nick = getnick_uid($item[0]);
      $lnk = "$strelica<small><b>$item[1]</b> from $item[5]. the meragochi <b>$nick</b>, the $item[2] fight $item[4], is a star $ofll1 and i finish it $item[6]</small>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"meragochi.php?action=statistika&amp;page=$ppage&amp;view=$view\">&#171;</a> ";
    }
    echo "$page/$num_pages";	
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo " <a href=\"meragochi.php?action=statistika&amp;page=$npage&amp;view=$view\">&#187;</a>";
    }
	echo "<br/>";
    if($num_pages>2)
    {
      $rets = "Go to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[IDI]";
        $rets .= "<go href=\"meragochi.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";    
    
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\">Home</a>";
  echo "</p>";  
  boxend();

  exit();
    }
///////////////////////////////////////


if($action=="usvoji")
{
addvisitor();
  addonline(getuid_sid($sid),"Meragochi","");

	//boxstart("Create A New Pet!");
	
  echo "<center><small>";
echo "Here you can Create your own Pet.. enjoy</small><br/>
<br/>";
echo "<form action=\"meragochi.php?action=set\" method=\"post\">
<small>Pet name: </small><br/><input id=\"inputText\" type=\"text\" name=\"ime\" value=\"empty\"/><br/>
<select id=\"boja\" name=\"boja\">
<option value=\"brown\">Brown</option>
<option value=\"pink\">Pink</option>
<option value=\"red\">Red</option>
<option value=\"green\">Green</option>
<option value=\"purple\">Purple</option>
</select>
<input type=\"hidden\" name=\"tid\" value=\"$tid\"/>
<input id=\"inputButton\" type=\"submit\" value=\"Create Pet\"/>
</form><br/>";
echo "<postfield name=\"ime\" value=\"$(ime)\"/>";
echo "<postfield name=\"boja\" value=\"$(boja)\"/>";
echo "</center>";
/////////main menu footer
boxend();
  exit();
    }
//////////////////////////////////

if($action=="set")
{
$ime = $_POST["ime"];
$boja = $_POST["boja"];
addonline(getuid_sid($sid),"Meragochi","");
//boxstart("Your Pet Has been Created!");
 echo "<p align=\"center\"><small>";

$uid = getuid_sid($sid);
$hrana = time() - (7*60*60);
  $exs = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
    if($exs[0]>0)
    {
  $cc = mysql_fetch_array(mysql_query("SELECT broj FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
  $cc = $cc[0]+1;
//$broj = mysql_query("UPDATE meragochi SET broj='".$cc."' WHERE uid='".$uid."'");
$res = mysql_query("UPDATE meragochi SET rodjen='".time()."', tezina='500', ime='".$ime."', ziv='1', nahranjen='".$hrana."', boja='".$boja."', igra='".$hrana."', kupanje='".$hrana."', smrt='0', raspolozenje='5', broj='".$cc."' WHERE uid='".$uid."'");
    }
	else
	{
$res = mysql_query("INSERT INTO meragochi SET uid='".$uid."', rodjen='".time()."', tezina='500', ime='".$ime."', ziv='1', nahranjen='".$hrana."', boja='".$boja."', igra='".$hrana."', kupanje='".$hrana."', broj='1'");
    }
        if($res)
        {
echo "<br/><b>Administrate your meragochi!</b><br/>";
echo "the name <b>$ime</b> has been created";
echo ",I want him to experience the age<br/>";
echo "<a href=\"meragochi.php?action=main\">Meragochi Menu</a><br/>";
        }else{
            echo "$nema<br/>Database problem!<br/><br/>";
        }

    echo "</small></p>";    
    
  echo "<p align=\"center\"><small>";
  echo "<a href=\"index.php?action=main\">Home</a>";
  echo "</small></p>";  
  boxend();
  
  exit();
    }
//////////////////////////////////
if($action=="hrana")
{
addonline(getuid_sid($sid),"Meragochi","");
  
//boxstart("Pet Actions!");			

  echo "<p align=\"center\"><small>";

$uid = getuid_sid($sid);
     $nopl = mysql_fetch_array(mysql_query("SELECT nahranjen FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
	 $sage = time()-$nopl[0];
	 $oflls = ceil(($sage/(1*60))-1);
	 $ofllss = ceil($sage-($oflls*60));
	 $ofllh = ceil(($sage/(1*60*60))-1);
	 $ofllhh = ceil($oflls-($ofllh*60));
	 $oflld = ceil(($sage/(24*60*60))-1);
	 $oflldd = ceil($ofllh-($oflld*24));
  if ($sage <= "60") $ofll1 = "$sage sec";
  if ($sage <= "3599" AND $sage > "60") $ofll1 = "$oflls min, $ofllss sec";
  if ($sage <= "86399" AND $sage >= "3600") $ofll1 = "$ofllh h, $ofllhh min";
  if ($sage >= "86400") $ofll1 = "$oflld day, $oflldd h";
  
  echo "Your pet has already eaten<b>$ofll1</b><br/>";
echo "<a href=\"meragochi.php?action=hrana2\">Feed IT</a><br/>";
echo "<a href=\"meragochi.php?action=main\">Meragochi Menu</a><br/>";
    echo "</small></p>";    
    
  echo "<p><small>";
  echo "<a href=\"index.php?action=main\">Home</a>";
  echo "</small></p>";  
  
  boxend();
  exit();
    }
//////////////////////////////////
if($action=="igra")
{
addonline(getuid_sid($sid),"Meragochi","");
//  boxstart("Pet Actions!");
  echo "<p align=\"center\"><small>";

$uid = getuid_sid($sid);
     $nopl = mysql_fetch_array(mysql_query("SELECT igra FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
	 $sage = time()-$nopl[0];
	 $oflls = ceil(($sage/(1*60))-1);
	 $ofllss = ceil($sage-($oflls*60));
	 $ofllh = ceil(($sage/(1*60*60))-1);
	 $ofllhh = ceil($oflls-($ofllh*60));
	 $oflld = ceil(($sage/(24*60*60))-1);
	 $oflldd = ceil($ofllh-($oflld*24));
  if ($sage <= "60") $ofll1 = "$sage sec";
  if ($sage <= "3599" AND $sage > "60") $ofll1 = "$oflls min, $ofllss sec";
  if ($sage <= "86399" AND $sage >= "3600") $ofll1 = "$ofllh h, $ofllhh min";
  if ($sage >= "86400") $ofll1 = "$oflld day, $oflldd h";
  
  echo "Your Pet Has Played Before <b>$ofll1</b><br/>";
echo "<a href=\"meragochi.php?action=igra2\">Fun</a><br/>";
echo "<a href=\"meragochi.php?action=main\">Meragochi Menu</a><br/>";
    echo "</small></p>";    
    
  echo "<p><small>";
  echo "<a href=\"index.php?action=main\">Home</a>";
  echo "</small></p>";  
  boxend();
   exit();
    }
//////////////////////////////////

if($action=="kupanje")
{
addonline(getuid_sid($sid),"Meragochi","");
  //boxstart("Pet Actions!");
  echo "<p align=\"center\"><small>";

$uid = getuid_sid($sid);
     $nopl = mysql_fetch_array(mysql_query("SELECT kupanje FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
	 $sage = time()-$nopl[0];
	 $oflls = ceil(($sage/(1*60))-1);
	 $ofllss = ceil($sage-($oflls*60));
	 $ofllh = ceil(($sage/(1*60*60))-1);
	 $ofllhh = ceil($oflls-($ofllh*60));
	 $oflld = ceil(($sage/(24*60*60))-1);
	 $oflldd = ceil($ofllh-($oflld*24));
  if ($sage <= "60") $ofll1 = "$sage sec";
  if ($sage <= "3599" AND $sage > "60") $ofll1 = "$oflls min, $ofllss sec";
  if ($sage <= "86399" AND $sage >= "3600") $ofll1 = "$ofllh h, $ofllhh min";
  if ($sage >= "86400") $ofll1 = "$oflld day, $oflldd h";
  
  echo "Your Pet Has Had A Bath Before <b>$ofll1</b><br/>";
echo "<a href=\"meragochi.php?action=kupanje2\">Wash IT</a><br/>";
echo "<a href=\"meragochi.php?action=main\">Meragochi Menu</a><br/>";
    echo "</small></p>";    
    
  echo "<p><small>";
  echo "<a href=\"index.php?action=main\">Home</a>";
  echo "</small></p>";  
  
 boxend();
  exit();
    }
///////////////////////////////////////////
if($action=="hrana2")
{
addonline(getuid_sid($sid),"Meragochi","");
  //boxstart("Pet actions!");
  echo "<p align=\"center\"><small>";
$uid = getuid_sid($sid);

$nopl = mysql_fetch_array(mysql_query("SELECT tezina FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
if($nopl[0] > "4999")
{
$res = mysql_query("UPDATE meragochi SET ziv='0', smrt='".time()."' WHERE uid='".$uid."'");
echo "Your Pet Died Because You have Too Many.<br/>";
}
else if($nopl[0] < "300")
{
$res = mysql_query("UPDATE meragochi SET ziv='0', smrt='".time()."' WHERE uid='".$uid."'");
echo "Your Pet Died Because Of too Much.<br/>";
}
else if($nopl[0] > "299" AND $nopl[0] < "5000")
{
$nopl = mysql_fetch_array(mysql_query("SELECT nahranjen FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
$nopl1 = time() - $nopl[0];
   if($nopl1 < "28800")
   {
$res = mysql_query("UPDATE meragochi SET nahranjen='".time()."' WHERE uid='".$uid."'");
$tezina = mysql_fetch_array(mysql_query("SELECT tezina FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
$tezina = $tezina[0] + 250;
$res = mysql_query("UPDATE meragochi SET tezina='".$tezina."' WHERE uid='".getuid_sid($sid)."'");
echo "Your Pet Has Eaten too Much $tezina g.<br/>";
}
   else if($nopl1 < "43200" AND $nopl1 > "28799")
   {
$res = mysql_query("UPDATE meragochi SET nahranjen='".time()."' WHERE uid='".$uid."'");
$tezina = mysql_fetch_array(mysql_query("SELECT tezina FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
$tezina = $tezina[0] + 0;
$res = mysql_query("UPDATE meragochi SET tezina='".$tezina."' WHERE uid='".$uid."'");
echo "Your Pet Has Gained too much Weight $tezina g.<br/>";
}
  else if($nopl1 < "54000" AND $nopl1 > "43199")
   {
$res = mysql_query("UPDATE meragochi SET nahranjen='".time()."' WHERE uid='".$uid."'");
$tezina = mysql_fetch_array(mysql_query("SELECT tezina FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
$tezina = $tezina[0] - 100;
$res = mysql_query("UPDATE meragochi SET tezina='".$tezina."' WHERE uid='".$uid."'");
echo "Your Pet Just Ate And Is A Diabetic$tezina g.<br/>";
}
  else if($nopl1 < "64800" AND $nopl1 > "53999")
   {
$res = mysql_query("UPDATE meragochi SET nahranjen='".time()."' WHERE uid='".$uid."'");
$tezina = mysql_fetch_array(mysql_query("SELECT tezina FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
$tezina = $tezina[0] - 200;
$res = mysql_query("UPDATE meragochi SET tezina='".$tezina."' WHERE uid='".$uid."'");
echo "Your pet weight is : $tezina g.<br/>";
}
   else
   {
$res = mysql_query("UPDATE meragochi SET ziv='0', smrt='".time()."' WHERE uid='".$uid."'");
echo "meragochi the weird pet did not eat..perhaps he is full..<br/>";
}
echo "Feed it again in 8-12 hours or atleast once a day.";
}
echo "</small></p>";
echo "<p align=\"center\"><small>";
echo "<a href=\"meragochi.php?action=main\">Meragochi Menu</a><br/>";
echo "$glavna<a href=\"index.php?action=main\">Home</a></small>";
echo "</p>";
boxend();

  exit();
    }
//////////////////////////////////

if($action=="igra2")
{
addonline(getuid_sid($sid),"Meragochi","");

		//boxstart("Pet Actions!");			
  echo "<p align=\"center\"><small>";

$uid = getuid_sid($sid);

$nopl = mysql_fetch_array(mysql_query("SELECT igra FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
$nopl1 = time() - $nopl[0];
   if($nopl1 < "600")
   {
$res = mysql_query("UPDATE meragochi SET igra='".time()."' WHERE uid='".$uid."'");
$tezina = mysql_fetch_array(mysql_query("SELECT raspolozenje FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
$tezina = $tezina[0] + 0;
$res = mysql_query("UPDATE meragochi SET raspolozenje='".$tezina."' WHERE uid='".getuid_sid($sid)."'");
$rasp = mysql_fetch_array(mysql_query("SELECT raspolozenje FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
echo " meragochi the administration satisfied this finish has remained at $rasp[0].<br/>";
}
   if($nopl1 < "43200" AND $nopl1 > "599")
   {
$res = mysql_query("UPDATE meragochi SET igra='".time()."' WHERE uid='".$uid."'");
$tezina = mysql_fetch_array(mysql_query("SELECT raspolozenje FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
$tezina = $tezina[0] + 2;
$res = mysql_query("UPDATE meragochi SET raspolozenje='".$tezina."' WHERE uid='".getuid_sid($sid)."'");
$rasp = mysql_fetch_array(mysql_query("SELECT raspolozenje FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
echo "meragochi the administration is satisfied his status has increased to $rasp[0].<br/>";
}
   else if($nopl1 < "86400" AND $nopl1 > "43199")
   {
$res = mysql_query("UPDATE meragochi SET igra='".time()."' WHERE uid='".$uid."'");
$tezina = mysql_fetch_array(mysql_query("SELECT raspolozenje FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
$tezina = $tezina[0] + 1;
$res = mysql_query("UPDATE meragochi SET raspolozenje='".$tezina."' WHERE uid='".getuid_sid($sid)."'");
$rasp = mysql_fetch_array(mysql_query("SELECT raspolozenje FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
echo "meragochi the administration is satisfied his status has increased to $rasp[0].<br/>";
}
  else if($nopl1 > "86399")
   {
$res = mysql_query("UPDATE meragochi SET igra='".time()."' WHERE uid='".$uid."'");
$tezina = mysql_fetch_array(mysql_query("SELECT raspolozenje FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
$tezina = $tezina[0] - 1;
$res = mysql_query("UPDATE meragochi SET raspolozenje='".$tezina."' WHERE uid='".getuid_sid($sid)."'");
$rasp = mysql_fetch_array(mysql_query("SELECT raspolozenje FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
echo "meragochi the administration is satisfied his fun status has increased to $rasp[0].Play Nice with him.<br/>";
}
    echo "</small></p>";    
    
  echo "<p><small>";
  echo "<a href=\"index.php?action=main\">Home</a>";
  echo "</small></p>";  
  boxend();
  exit();
    }
//////////////////////////////////
if($action=="kupanje2")
{
addonline(getuid_sid($sid),"Meragochi","");

  
//	boxstart("Error!");		
		
  echo "<p align=\"center\"><small>";

$uid = getuid_sid($sid);

$nopl = mysql_fetch_array(mysql_query("SELECT kupanje FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
$nopl1 = time() - $nopl[0];
   if($nopl1 < "21599")
   {
$res = mysql_query("UPDATE meragochi SET kupanje='".time()."' WHERE uid='".$uid."'");
$tezina = mysql_fetch_array(mysql_query("SELECT raspolozenje FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
$tezina = $tezina[0] - 1;
$res = mysql_query("UPDATE meragochi SET raspolozenje='".$tezina."' WHERE uid='".getuid_sid($sid)."'");
$rasp = mysql_fetch_array(mysql_query("SELECT raspolozenje FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
echo "Your meragochi the owner has been bathed $rasp[0].<br/>";
}
   if($nopl1 < "86400" AND $nopl1 > "21600")
   {
$res = mysql_query("UPDATE meragochi SET kupanje='".time()."' WHERE uid='".$uid."'");
$tezina = mysql_fetch_array(mysql_query("SELECT raspolozenje FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
$tezina = $tezina[0] + 2;
$res = mysql_query("UPDATE meragochi SET raspolozenje='".$tezina."' WHERE uid='".getuid_sid($sid)."'");
$rasp = mysql_fetch_array(mysql_query("SELECT raspolozenje FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
echo "Your meragochi je upravo zadovoljno okupan i raspolo&#382;enje mu je poraslo na $rasp[0].<br/>";
}
   else if($nopl1 < "172800" AND $nopl1 > "86399")
   {
$res = mysql_query("UPDATE meragochi SET igra='".time()."' WHERE uid='".$uid."'");
$tezina = mysql_fetch_array(mysql_query("SELECT raspolozenje FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
$tezina = $tezina[0] + 1;
$res = mysql_query("UPDATE meragochi SET raspolozenje='".$tezina."' WHERE uid='".getuid_sid($sid)."'");
$rasp = mysql_fetch_array(mysql_query("SELECT raspolozenje FROM meragochi WHERE uid='".getuid_sid($sid)."'"));
echo "I bathed him rise to the $rasp[0].<br/>";
}
   else if($nopl1 > "172799")
   {
$res = mysql_query("UPDATE meragochi SET ziv='0', smrt='".time()."' WHERE uid='".$uid."'");
echo "Your friend did not revive his sight.<br/>";
}
    echo "</small></p>";    
    
  echo "<p><small>";
  echo "<a href=\"index.php?action=main\">Home</a>";
  echo "</small></p>";  
  boxend();
   exit();
    }
//////////////////////////////////
if($action=="sta")
{

addonline(getuid_sid($sid),"Meragochi","");
//boxstart("Meragochi!");
  echo "<p align=\"center\"><small>";
echo "<img src=\"images/meragochi.jpg\" alt=\"meragochi\"/>";
echo "<br/><b> What is A meragochi?</b><br/><br/>";
echo "Your friend must be well cared for<br/> You must feed,bath and exercise it like any other pet or they can die...<br/>";
echo "maximim weight is 2000 grams,swim every second day with him .";
echo "</small></p>";
echo "<p align=\"center\">";
  echo "<small>";
  echo "<a href=\"index.php?action=main\">Home</a>";
  echo "</small></p>";  
boxend();
   exit();
    }

?>

<?php
session_name("PHPSESSID");
session_start();
header("Content-type: text/html");
header("Cache-Control: no-store, no-cache, must-revalidate");
echo("<?xml version=\"1.0\"?>");
include("xhtmlfunctions.php");
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";
?>
<html>
<?php
include("config.php");
include("core.php");
connectdb();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
if(!isvip(getuid_sid($sid)))
  {
    echo "<card id=\"main\" title=\"Fprum\">";
      echo "<p align=\"center\">";
      echo "VI NISTE VIP CHLAN!<br/>";
      echo "<br/>";
      echo "<a href=\"index.php\">HAPPY</a>";
      echo "</p>";
      echo "</card>";
      echo "</wml>";
      exit();
    }
if(islogged($sid)==false)
    {
        echo "<card id=\"main\" title=\"Forum\">";
      echo "<p align=\"center\">";
      echo "Niste Ulogovani!<br/>";
      echo "Ili je vas pristupni period istekao!<br/><br/>";
      echo "<a href=\"index.php\">Uloguj se!</a>";
      echo "</p>";
      echo "</card>";
      echo "</wml>";
      exit();
    }
    addonline(getuid_sid($sid),"Promeni Nick","");
if($action=="poruka")
{
  $xtm = $_POST["sesp"];
  $fmsg = $_POST["fmsg"];
  $areg = $_POST["areg"];
  $pmaf = $_POST["pmaf"];
  $fvw = $_POST["fvw"];
  if($areg=="d")
  {
    $arv = 0;
  }else{
    $arv = 1;
  }
   echo "<card id=\"main\" title=\"Forum\">";
      echo "<p align=\"center\">";
      
      
      $res = mysql_query("UPDATE dcroxx_me_settings SET value='".$fmsg."' WHERE name='4ummsg'");
      if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Forum poruke azurirane uspesno!<br/>";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Nemoguce azurirati Forum poruke!<br/>";
      }
      
      echo "<br/>";
      
      echo "<a href=\"index.php?action=vipcp\"><img src=\"images/vip.gif\" alt=\"*\"/>";
  echo "Vip Panel</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p></card>";
}
////////////////////////////////////////////Promeni NIck


else if($action=="nick")
{
    
    $who = $_GET["who"];
    $unick = $_POST["unick"];
    $perm = $_POST["perm"];
    $savat = $_POST["savat"];
    $semail = $_POST["semail"];
    $usite = $_POST["usite"];
    $ubday = $_POST["ubday"];
    $uloc = $_POST["uloc"];
    $usig = $_POST["usig"];
    $usex = $_POST["usex"];
    echo "<card id=\"main\" title=\"HAPPY Forum\">";
  echo "<p align=\"center\">";
  $uid = getuid_sid($sid);
  $onk = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$uid."'"));
  $exs = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE name='".$unick."'"));
  if($onk[0]!=$unick)
  {
	  if($exs[0]>0)
	  {
		echo "<img src=\"images/notok.gif\" alt=\"x\"/>Nik vec postoji, izaberite neki drugi!<br/>";
	  }else
  {
  $res = mysql_query("UPDATE dcroxx_me_users SET name='".$unick."' WHERE id='".$uid."'");
  if($res)
  {
    echo "<img src=\"images/ok.gif\" alt=\"o\"/>$unick je vash nov nick!<br/>";
  }else{
    echo "<img src=\"images/notok.gif\" alt=\"x\"/>Nemoguce azurirati $unick profil!<br/>";
  }
  }
  }else
  {
  $res = mysql_query("UPDATE dcroxx_me_users SET name='".$unick."' WHERE id='".$uid."'");
  if($res)
  {
    echo "<img src=\"images/ok.gif\" alt=\"o\"/>$unick je tvoj novi nick!<br/>";
  }else{
    echo "<img src=\"images/notok.gif\" alt=\"x\"/>Nemoguce azurirati $unick profil!<br/>";
  }
  }
  echo "<a href=\"index.php?action=vipcp\"><img src=\"images/vip.gif\" alt=\"*\"/>";
  echo "Vip Panel</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}
/////////////////////////////////
else if($action == 'pp2vip'){
	$byuid = getuid_sid($sid);
str_replace("$","\$",$pmtext);

	$to_arr=SQL_rows("SELECT u.id,p.id AS pid, u.vip  FROM dcroxx_me_users u LEFT JOIN dcroxx_me_penalties p ON u.id=p.uid AND (penalty='1' OR penalty='2') HAVING vip > 0 AND pid IS NULL AND id != $byuid");
$text2 = "$pmtext [br/][b][i]PS:Ovo je automatska poruka svim Vip Chlanovima i ne treba odgovarati na nju![/i][/b]";
	$tm = time();
	$query='INSERT INTO dcroxx_me_private (`text`,`byuid`,`touid`,`timesent`) VALUES ';

	$counter=0;
	foreach($to_arr as $recv){
		$query .= ($counter ? "\n," : '')."('$text2','$byuid','".$recv['id']."', '$tm')";
		$counter++;
		if($counter == 20)


{
			mysql_query($query);
			$query='INSERT INTO dcroxx_me_private (`text`,`byuid`,`touid`,`timesent`) VALUES ';
$text = "$pmtext [br/][b][i]PS:Ovo je automatska poruka svim Vip Chlanovima i ne treba odgovarati na nju![/i][/b]";
			$counter=0;

		}
	}
	if($counter > 0){
		mysql_query($query);
	}

	addonline("Salje poruku Vip Chlanovima!");
        echo "<card id=\"main\" title=\"PP Inbox\">";
	echo "<p align=\"center\"><small>";
	echo '<b>Poruka poslata svim <b>'.count($to_arr).'</b> Vip Chlanovima.</b><br/>'.mysql_error();
$text2 = "$pmtext [br/][b][i]PS:Ovo je automatska poruka svim Vip Chlanovima i ne treba odgovarati na nju![/i][/b]";
        echo "<br/>$text2<br/>";
	echo "<a href=\"index.php?action=vipcp\">VIP CP</a><br/>";
	
	echo "<a href=\"index.php?action=main\">Home</a>";
	echo "</small></p>";
	echo "</card>";
}
if($action=="ppsvi")
{
  echo "<card id=\"main\" title=\"PP svima\">";
  echo "<p align=\"center\">";
  $whonick = getnick_uid($who);
  $byuid = getuid_sid($sid);
  str_replace("$","\$",$poruka);

  $tm = time()+(7*60*60);

$max = mysql_fetch_array(mysql_query("SELECT MAX(id) FROM dcroxx_me_users"));
$maxid = $max[0];
$text = "$poruka [br/][b][i]PS:Ovo je automatska poruka i poslao je Vip clan.Ne treba odgovarati na nju![/i][/b]";
for ($i=1; $i <= $maxid; $i++)
{

  $ppsvima = mysql_query("INSERT INTO dcroxx_me_private SET text='".$text."', byuid='".$byuid."', touid='".$i."', timesent='".$tm."'");

}
	echo "PP je uspesno poslana za sve clanove<br/><br/>";
    echo parsepm($poruka, $sid);

   echo "<a href=\"index.php?action=vipcp\">vip CP</a><br/>";
  echo "<a href=\"index.php?action=main\">$glavna";
echo "Home</a>";
  echo "</p>";
    echo "</card>";
}
if($action=="ppzenea")
{
  echo "<card id=\"main\" title=\"PP svima\">";
  echo "<p align=\"center\">";
  $whonick = getnick_uid($who);
  $byuid = getuid_sid($sid);
  str_replace("$","\$",$poruka);

  $tm = time()+(7*60*60);

$sex = mysql_query("SELECT id  FROM dcroxx_me_users WHERE sex='F'");
$tm = time();
$text = "$poruka [br/][b][i]PS:Ovo je automatska poruka za sve ZENSKE clanove koju poslao je Vip clan.Ne treba odgovarati na nju![/i][/b]";
while($f = mysql_fetch_array($sex))
{

  $ppzene = mysql_query("INSERT INTO dcroxx_me_private SET text='".$text."', byuid='".$byuid."', touid='".$f[0]."', timesent='".$tm."'");

}
	echo "PP je uspesno poslana za sve zenske clanove<br/><br/>";
    echo parsepm($poruka, $sid);

   echo "<a href=\"index.php?action=vipcp\">vip CP</a><br/>";
  echo "<a href=\"index.php?action=main\">$glavna";
echo "Home</a>";
  echo "</p>";
    echo "</card>";
}
if($action=="ppmusa")
{
  echo "<card id=\"main\" title=\"PP svima\">";
  echo "<p align=\"center\">";
  $whonick = getnick_uid($who);
  $byuid = getuid_sid($sid);
  str_replace("$","\$",$poruka);

  $tm = time()+(7*60*60);

$sex = mysql_query("SELECT id  FROM dcroxx_me_users WHERE sex='M'");
$tm = time();
$text = "$poruka [br/][b][i]PS:Ovo je automatska poruka za sve MUSKE clanove koju poslao je Vip clan.Ne treba odgovarati na nju![/i][/b]";
while($f = mysql_fetch_array($sex))
{

  $ppzene = mysql_query("INSERT INTO dcroxx_me_private SET text='".$text."', byuid='".$byuid."', touid='".$f[0]."', timesent='".$tm."'");

}
	echo "PP je uspe&sno poslana za sve muske clanove<br/><br/>";
    echo parsepm($poruka, $sid);

   echo "<a href=\"index.php?action=vipcp\">vip CP</a><br/>";
  echo "<a href=\"index.php?action=main\">$glavna";
echo "Home</a>";
  echo "</p>";
    echo "</card>";


}else{
    echo "<card id=\"main\" title=\"Vip Panel\">";
  echo "<p align=\"center\">";
  echo "NEMATE PRISTUP VIP PANELU!<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}


?>
</html>
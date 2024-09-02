<?php
session_name("PHPSESSID");
session_start();
/*
DENVERS newest
Script
*/
//>> &#187;
//<< &#171;

//session_start();
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\"\"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";

echo "<head><title>pinoykindat.tk</title>";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/style.css\" />";
echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
<meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
<meta name=\"description\" content=\"KIndat Kindat\"> 
<meta name=\"keywords\" content=\"free, community, forums, chat, wap, communicate\">
<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> 
</head>";
echo "<body>";

connectdb();
include("config.php");
include("core.php");
$pscore = $_GET['pscore'];
$cscore = $_GET['cscore'];
$guess = $_GET['guess'];
$sid = $_SESSION['sid'];
$action = $_GET['action'];
$uid = getuid_sid($sid);
    if(islogged($sid)==false)
    {
     
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or<br/>Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
     
      echo "</html>";
      exit();
    }
if($action=="jnp")
{
    $who = $_GET["who"];
    addonline(getuid_sid($sid),"Jack en Poy","");

    echo "<p align=\"center\">";
$uid = getuid_sid($sid);
$ginfo = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
 $tries = $ginfo[0];
$rpgd = mysql_query("SELECT no FROM dcroxx_me_jnp2 ORDER by RAND() LIMIT 1");

  while($rpgds=mysql_fetch_array($rpgd))
  {
$number = $rpgds[0];
}

if ($tries>0)
                {
if (!$pscore){
	$pscore='0';
}
if (!$cscore){
	$cscore='0';
}
if ($guess=="1") {
	$pchoice = "Papel";
                 if ($number == 1){
                        $cchoice = "Papel";
                        $number = $number2;
                        echo_scores($pscore,$cscore,$pchoice,$cchoice,drew);
                    mysql_query("UPDATE dcroxx_me_users SET plusses=plusses-'' WHERE id='".$uid."'");
                     echo "No plusses earn<br/>";
                   $nopl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".getuid_sid($sid)."'"));
                   echo "You have: <b>$nopl[0] plusses</b>";
                    }
                 if ($number == 2){
                        $cscore = $cscore + 1;
			$cchoice = "Gunting";
                      echo_scores($pscore,$cscore,$pchoice,$cchoice,lost);
                   mysql_query("UPDATE dcroxx_me_users SET plusses=plusses-'5' WHERE id='".$uid."'");
                      echo "Sorry minus 5 plusses<br/>";
                 $nopl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".getuid_sid($sid)."'"));
                   echo "You have: <b>$nopl[0] plusses</b>";
                       }
             if ($number == 3) {
                         $pscore = $pscore + 1;
			$cchoice = "Bato";
                     echo_scores($pscore,$cscore,$pchoice,$cchoice,won);
                   mysql_query("UPDATE dcroxx_me_users SET plusses=plusses+'10' WHERE id='".$uid."'");
                      echo "You earn 10 plusses<br/>";
                  $nopl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".getuid_sid($sid)."'"));
                   echo "You have: <b>$nopl[0] plusses</b>";
                  }
}
if ($guess=="2") {
	$pchoice = "Gunting";
		if ($number == 1) {
                        $pscore = $pscore + 1;
			$cchoice = "Papel";
                    echo_scores($pscore,$cscore,$pchoice,$cchoice,won);
                       mysql_query("UPDATE dcroxx_me_users SET plusses=plusses+'10' WHERE id='".$uid."'");
                     echo "You earn 10 plusses<br/>";
                  $nopl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".getuid_sid($sid)."'"));
                   echo "You have: <b>$nopl[0] plusses</b>";
                    }
		if ($number == 2) {
                        $cchoice = "Gunting";
                     echo_scores($pscore,$cscore,$pchoice,$cchoice,drew);
	            mysql_query("UPDATE dcroxx_me_users SET plusses=plusses-'' WHERE id='".$uid."'");
                    echo "No plusses earn<br/>";
               $nopl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".getuid_sid($sid)."'"));
                   echo "You have: <b>$nopl[0] plusses</b>";
                    }
		if ($number == 3) {
                        $cscore = $cscore + 1;
			$cchoice = "Bato";
                      echo_scores($pscore,$cscore,$pchoice,$cchoice,lost);
                     mysql_query("UPDATE dcroxx_me_users SET plusses=plusses-'5' WHERE id='".$uid."'");
                    echo "Sorry minus 5 plusses<br/>";
                $nopl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".getuid_sid($sid)."'"));
                   echo "You have: <b>$nopl[0] plusses</b>";
             }
}
if ($guess=="3") {
	$pchoice = "Bato";
		if ($number == 1) {
                        $cscore = $cscore + 1;
			$cchoice = "Papel";
                        echo_scores($pscore,$cscore,$pchoice,$cchoice,lost);
		      mysql_query("UPDATE dcroxx_me_users SET plusses=plusses-'5' WHERE id='".$uid."'");
                  echo "Sorry minus 5 plusses<br/>";
                  $nopl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".getuid_sid($sid)."'"));
                   echo "You have: <b>$nopl[0] plusses</b>";
                 }
		if ($number == 2) {
                        $pscore = $pscore + 1;
			$cchoice = "Gunting";
                         echo_scores($pscore,$cscore,$pchoice,$cchoice,won);
		      mysql_query("UPDATE dcroxx_me_users SET plusses=plusses+'10' WHERE id='".$uid."'");
                       echo "You earn 10 plusses<br/>";
                   $nopl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".getuid_sid($sid)."'"));
                   echo "You have: <b>$nopl[0] plusses</b>";
                    }
		if ($number == 3) {
                        $cchoice = "Bato";
                        echo_scores($pscore,$cscore,$pchoice,$cchoice,drew);
                      mysql_query("UPDATE dcroxx_me_users SET plusses=plusses-'' WHERE id='".$uid."'");
                echo "No plusses earn<br/>";
                $nopl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".getuid_sid($sid)."'"));
                   echo "You have: <b>$nopl[0] plusses</b>";
                          }
}
$time = date('dmHis');
echo "<br/><a href=\"jnp.php?action=jnp&amp;guess=1&amp;pscore=$pscore&amp;cscore=$cscore&amp;reload=$time\">Papel</a>, <a href=\"jnp.php?action=jnp&amp;guess=2&amp;pscore=$pscore&amp;cscore=$cscore&amp;reload=$time\">Gunting</a>, <a href=\"jnp.php?action=jnp&amp;guess=3&amp;pscore=$pscore&amp;cscore=$cscore&amp;reload=$time\">Bato</a>";
echo "<br/><br/>----------<br/><a href=\"jnp.php?action=jnp&amp;type=send\">";
echo "Reset Game</a>";
}else{
                    $gmsg = "Hehehe! You dont have enough plusses to play jack en poy earn more plusses at forums.<br/><br/>";
                    echo $gmsg;
                 exit();
    }
////////////////////////////////////////////////////
echo "</p>";
////// UNTILL HERE >>
    echo "<p align=\"center\">";
 echo "<a href=\"index.php?action=main&amp;type=send\">";
echo "Main menu</a>";
    echo "</p>";
    echo "</body>";
   exit();
    }

?>

</html>

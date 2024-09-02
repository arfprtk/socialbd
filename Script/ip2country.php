<?php
include("core.php");

//mysql_connect($db_host,$db_user,$db_pass) or die("Unable to connect to database");
//mysql_select_db($database) or die("Unable to select database");

//****** determination IP¨& country - START
$flag="0";
$country="";
$ip=$_SERVER["REMOTE_ADDR"];
if(isset($_POST["ip"]) && ($_POST["ip"]==long2ip(ip2long($_POST["ip"]))))
	{$ip=long2ip(ip2long($_POST["ip"]));}
$resultat=mysql_query("SELECT ISO2 FROM mobi_ips WHERE (StartIP<=inet_aton('".$ip."') AND EndIP>=inet_aton('".$ip."'))");
if(!($ligne=mysql_fetch_array($resultat)))
	{$country="1";}
	else
	{
	$resultat2=mysql_query("SELECT CountryName FROM mobi_country WHERE ISO2='".$ligne["ISO2"]."'");
	if(!($ligne2=mysql_fetch_array($resultat2)))
		{$country="2";}
		else
		{
		$flag="../flags/".strtolower($ligne["ISO2"]).".png";
		if(!file_exists($flag)){$flag="0";}
		$country=$ligne2["CountryName"];
		}
	}

//****** determination IP¨& country - END



//*********** Display IP & country

if($country=="1"){echo ' ';}
else if($country=="2"){echo ' ';}
else if($country=="Philippines")
{echo 'Mabuhay ang Pinoy! <br/> <img src="'.$flag.'" alt="flag"/>';} 
else
	{
	echo 'Welcome to the fastest growing community in '.$country.'! <br/> ';
        if($flag=="0"){echo ' ';} else 
        {echo '<img src="'.$flag.'" alt="flag"/>';}
	}

?>

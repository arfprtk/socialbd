<?php

    session_name("PHPSESSID");
session_start();
 $uid = getuid_sid($sid);
 $nopop = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_pops WHERE touid='".$uid."' AND unread='1'"));
  if($nopop[0]>0)
{
 $sql ="SELECT * FROM dcroxx_me_pops where touid='".$uid."' AND unread = '1' ORDER BY id LIMIT 0, 1";
 $pd = mysql_query($sql);
 while ($pop = mysql_fetch_array($pd))
  {
  $id = mysql_fetch_array(mysql_query("SELECT touid FROM dcroxx_me_pops WHERE touid='".$uid."'"));
  if($uid==$id[0])
  {
    $chread = mysql_query("UPDATE dcroxx_me_pops SET unread='0' WHERE id='".$pop[0]."'");
  }
$dtop = date("d/m/y - H:i:s",$pop[5]);
$by = getnick_uid($pop[2]);
$msg = htmlspecialchars($pop[1]);
echo "<b>$by:</b> $msg - $dtop<br/>";
echo "<b>Message</b>:<br/>";
echo "<form action=\"popup.php?action=send\" method=\"post\">";
echo "<input type=\"text\" name=\"msg\"/><br/>";
echo "<input type=\"Submit\" value=\"reply\"/>";
echo "<input type=\"hidden\" name=\"who\" value=\"$pop[2]\"/>";

echo "</form><br/>---<br/>";
  }
    exit();
    }
?>

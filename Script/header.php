<?php

date_default_timezone_set('UTC');
$gerNew_Time = time()+(6* 60 * 60);
$gertime=date("h:i:s a,",$gerNew_Time);

echo"<div class=\"hmenu hmenubottom\">";

echo"<img src=\"logo.png\" alt=\"Facebook logo\" width=\"100\" height=\"20\" />";

$xid = getuid_sid($sid);
$umsg = getunreadpm(getuid_sid($sid));
$notify = notification(getuid_sid($sid));
$chs = getnumonline();
echo "<div class=\"left\">
<a href=\"index.php?action=main\">Home</a>   ";
echo "<a href=\"index.php?action=viewuser&who=$xid\">Profile</a>   ";
if ($umsg==0){
echo "<a href=\"messages_main.php\">Messages</a>   </b>";
}else{
echo "<b><a href=\"messages_main.php\"><font color=\"yellow\">Messages($umsg)</font></a>   </b>";
}

if ($notify==0){
echo "<a href=\"notification.php?action=main\">Notifications</a>   ";
}else{
echo "<b><a href=\"notification.php?action=main\"><font color=\"yellow\">Notifications($notify)</font></a>   </b>";
}

if ($chs[0]==0){
echo "<a href=\"index.php?action=online\">Chat</a> ";
}else{
$x1 = mysql_fetch_array(mysql_query("SELECT chat_visibility FROM alien_war_users WHERE id='".$xid."'"));
if ($x1[0]==1){
echo "<a href=\"index.php?action=online\">Chat</a> ";
}else{
echo "<a href=\"index.php?action=online\">Chat($chs)</a> ";
}
}
$reqs = getnreqs($xid);
if($reqs>0){
$request = "($reqs)";
echo "<b><a href=\"lists.php?action=reqs\"><font color=\"yellow\">Friends$request</font></a></b> ";
}else{
echo "<a href=\"lists.php?action=buds\">Friends</a> ";
}

echo "<a href=\"index.php?action=cpanel\">Menu</a>  ";

include("pm_by22.php");
echo"</div>";
echo"</div>";

?>
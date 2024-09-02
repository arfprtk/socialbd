<?php
header("Content-type: image/jpeg");
$id = $_GET["id"];
include("config.php");
include("core.php");
connectdb();
$uinfo = mysql_fetch_array(mysql_query("SELECT plusses, posts, name, avatar, shouts FROM dcroxx_me_users WHERE id='".$id."'"));
$info = mysql_fetch_array(mysql_query("SELECT realname FROM dcroxx_me_xinfo WHERE id='".$id."'"));
$bgpic = imagecreatefromjpeg("images/rwidc.jpg");
$textcolor = imagecolorallocate($bgpic,0x00,0,0x99);
$infcolor = imagecolorallocate($bgpic,0,0,0);
$stscolor = imagecolorallocate($bgpic,0x00,0x55,0x00);
$idinfo = "$id";
$postsinfo = "$uinfo[1]";
$creditsinfo = "$uinfo[0]";
$shoutinfo = "$uinfo[4]";
imagestring($bgpic,3,170,86,$info[0],$infcolor);
//imagestring($bgpic,1,54,15,$idinfo,$infcolor);
imagestring($bgpic,5,35,78,$idinfo,$infcolor);
imagestring($bgpic,5,170,135,$postsinfo,$infcolor);
imagestring($bgpic,5,170,117,$creditsinfo,$infcolor);
imagestring($bgpic,5,170,152,$shoutinfo,$infcolor);
imagestring($bgpic,5,170,100,getStatus($id),$stscolor);
$avl = $uinfo[3];
//echo $avl;
if(trim($avl!=""))
{
  $avl = strtolower($avl);
  if(substr_count($avl,"rwidc.php")==0)
  $imgi = getimagesize($avl);
  if($imgi[0]>0)
  {
      if($imgi[2]==1)
      {
        $av = imagecreatefromgif($avl);
        //imagecopyresized($bgpic, $av,10,16,0,0,40,40,$imgi[0], $imgi[1]);
        imagecopyresized($bgpic, $av,10,16,0,0,100,100,$imgi[0], $imgi[1]);
      }else if($imgi[2]==2)
      {
        $av = imagecreatefromjpeg($avl);
        //imagecopyresized($bgpic, $av,10,16,0,0,40,40,$imgi[0], $imgi[1]);
        imagecopyresized($bgpic, $av,5,101,0,0,90,90,$imgi[0], $imgi[1]);
      }
  }
}
imagejpeg($bgpic,"",100);
imagedestroy($bgpic);
?>



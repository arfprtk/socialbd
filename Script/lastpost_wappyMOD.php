<?
//LAST POST MOD BY WAPPY 
     $lpt = mysql_fetch_array(mysql_query("SELECT id, name FROM dcroxx_me_topics ORDER BY lastpost DESC LIMIT 0,1"));
      $nops = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_posts"));
      if($nops[0]==0)
      {
        $pinfo = mysql_fetch_array(mysql_query("SELECT authorid FROM dcroxx_me_topics"));
        $tluid = $pinfo[0];
        
      }else{
        $pinfo = mysql_fetch_array(mysql_query("SELECT  uid  FROM dcroxx_me_posts ORDER BY dtpost DESC LIMIT 0, 1"));
        
        $tluid = $pinfo[0];
      }
      $tlnm = htmlspecialchars($lpt[1]);
      $tlnick = getnick_uid($tluid);
      $tpclnk = "<a href=\"index.php?action=viewtpc&amp;tid=$lpt[0]&amp;go=last\">$tlnm</a>";
      $vulnk = "<a href=\"index.php?action=viewuser&amp;who=$tluid\">$tlnick</a>";
      echo "<b>Last Post:</b> $tpclnk<br/>By: <i>$vulnk</i><br/>";
//Removing the copyright line is NOT permited and will invalidate your license to use this modification and giving the owner (wappy) full rights to contact your host and have it removed without warning or notice. You may however remove this line and modify/update the mod/code. Make sure to read ALL documentation before installing this modification :-)
//(c)2004-2006 wappyCULT
//END OF LAST POST MOD
?>

<?php
include("config.php");
include("core.php");
$bcon = connectdb();

mysql_query("UPDATE dcroxx_me_smilies SET  imgsrc='smilies/gohmy.gif', hidden='0' WHERE scode='-gohmy-'");

?>

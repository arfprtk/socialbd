<?php
	session_start();
	include("db.php");
	include("functions.php");

	// Send headers to prevent IE cache

	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
	header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
	header("Cache-Control: no-cache, must-revalidate" ); 
	header("Pragma: no-cache" );
	header("Content-Type: text/html; charset=utf-8");

	// if no session or not admin, die
	//if(!$_SESSION['username']){die('access denied');}

	// check game id is numeric
	if(!is_numeric($_GET['id'])){

		die('Invalid Game ID');

	}

	// get games data
	$tmp=mysql_query("SELECT * FROM ".$CONFIG['mysql_prefix']."games WHERE game_ID = '".makeSafe($_GET['id'])."'");
	while($i=mysql_fetch_array($tmp)) {

	    echo "<head>";
    echo "<title>Play Games</title>";
	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../style/default.css\">";
    echo "</head>";
    echo "<body>";


echo "<b>Play Online Games</b><br/>";	
	

	?>
<center>
		<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0">
		<param name="movie" value="swf/<?php echo ($i['game_SwfFile']);?>" />
		<param name="quality" value="high" />
		<embed src="swf/<?php echo ($i['game_SwfFile']);?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" height="70%" width="70%"></embed>
		</object>
</center>
	<?php } 
	echo "<div class=\"hmenu hmenubottom\">
<div class=\"right\"><font color=\"red\">Regards,</font><br/>
<b>Prottay Chowdhury Tufan</b></div></div>";
	
	?>

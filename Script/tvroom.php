
<!-- 
	This is the HTML file for the front-end of the AJAX Driven Chat application 
	This code was developed by Ryan Smith of 345 Technical Services
	
	You may use this code in your own projects as long as this copyright is left
	in place.  All code is provided AS-IS.
	This code is distributed in the hope that it will be useful,
 	but WITHOUT ANY WARRANTY; without even the implied warranty of
 	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
	
	For the rest of the code visit http://www.DynamicAJAX.tk
	
	Copyright 2005 Ryan Smith / 345 Technical / 345 Group.
-->
<html>
	<head>
		<title> TV Room</title>
  <link rel="stylesheet" type="text/css" href="themes2.php">
		<style type="text/css" media="screen">
			.chat_time {
				font-style: italic;
				font-size: 9px;
			}
		</style>
		<script language="JavaScript" type="text/javascript">
			var sendReq = getXmlHttpRequestObject();
			var receiveReq = getXmlHttpRequestObject();
			var lastMessage = 0;
			var mTimer;
			//Function for initializating the page.
			function startChat() {
				//Set the focus to the Message Box.
				document.getElementById('txt_message').focus();
				//Start Recieving Messages.
				getChatText();
			}		
			//Gets the browser specific XmlHttpRequest Object
			function getXmlHttpRequestObject() {
				if (window.XMLHttpRequest) {
					return new XMLHttpRequest();
				} else if(window.ActiveXObject) {
					return new ActiveXObject("Microsoft.XMLHTTP");
				} else {
					document.getElementById('p_status').innerHTML = 'Status: Cound not create XmlHttpRequest Object.  Consider upgrading your browser.';
				}
			}
			
			//Gets the current messages from the server
			function getChatText() {
				if (receiveReq.readyState == 4 || receiveReq.readyState == 0) {
					receiveReq.open("GET", 'getChat.php?chat=1&last=' + lastMessage, true);
					receiveReq.onreadystatechange = handleReceiveChat; 
					receiveReq.send(null);
				}			
			}
			//Add a message to the chat server.
			function sendChatText() {
				if(document.getElementById('txt_message').value == '') {
					alert("You have not entered a message");
					return;
				}
				if (sendReq.readyState == 4 || sendReq.readyState == 0) {
					sendReq.open("POST", 'getChat.php?chat=1&last=' + lastMessage, true);
					sendReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					sendReq.onreadystatechange = handleSendChat; 
					var param = 'message=' + document.getElementById('txt_message').value;
					param += '&name=rider';
					param += '&chat=1';
					sendReq.send(param);
					document.getElementById('txt_message').value = '';
				}							
			}
			//When our message has been sent, update our page.
			function handleSendChat() {
				//Clear out the existing timer so we don't have 
				//multiple timer instances running.
				clearInterval(mTimer);
				getChatText();
			}
			//Function for handling the return of chat text
			function handleReceiveChat() {
				if (receiveReq.readyState == 4) {
					var chat_div = document.getElementById('div_chat');
					var xmldoc = receiveReq.responseXML;
					var message_nodes = xmldoc.getElementsByTagName("message"); 
					var n_messages = message_nodes.length
					for (i = 0; i < n_messages; i++) {
						var user_node = message_nodes[i].getElementsByTagName("user");
						var text_node = message_nodes[i].getElementsByTagName("text");
						var time_node = message_nodes[i].getElementsByTagName("time");
						chat_div.innerHTML += user_node[0].firstChild.nodeValue + '&nbsp;';
						chat_div.innerHTML += '<font class="chat_time">' + time_node[0].firstChild.nodeValue + '</font><br />';
						chat_div.innerHTML += text_node[0].firstChild.nodeValue + '<br />';
						chat_div.scrollTop = chat_div.scrollHeight;
						lastMessage = (message_nodes[i].getAttribute('id'));
					}
					mTimer = setTimeout('getChatText();',2000); //Refresh our chat in 2 seconds
				}
			}
			//This functions handles when the user presses enter.  Instead of submitting the form, we
			//send a new message to the server and return false.
			function blockSubmit() {
				sendChatText();
				return false;
			}
			//This cleans out the database so we can start a new chat session.
			function resetChat() {
				if (sendReq.readyState == 4 || sendReq.readyState == 0) {
					sendReq.open("POST", 'getChat.php?chat=1&last=' + lastMessage, true);
					sendReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					sendReq.onreadystatechange = handleResetChat; 
					var param = 'action=reset';
					sendReq.send(param);
					document.getElementById('txt_message').value = '';
				}							
			}
			//This function handles the response after the page has been refreshed.
			function handleResetChat() {
				document.getElementById('div_chat').innerHTML = '';
				getChatText();
			}	
		</script>
	    <script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>
	<body onLoad="javascript:startChat();">
<div align="center"> Tv Room</div>
<table width="100%" border="4">
<tr>
<td align="center">
Channels:
		<div align="left" id="div_channels" style="height: 440px; width: 150px; overflow: auto; background-color: #F89C40; border: 1px solid #555555;">
&#187; <a href="tvroom.php?mid=2">Star Movies</a><br/>&#187; <a href="tvroom.php?mid=5">SammitySam TV (ufo)</a><br/>&#187; <a href="tvroom.php?mid=6">romantyx (southpark)</a><br/>&#187; <a href="tvroom.php?mid=7">South Park Channel</a><br/>&#187; <a href="tvroom.php?mid=8">Family Guy</a><br/>&#187; <a href="tvroom.php?mid=37">NASA TV</a><br/>&#187; <a href="tvroom.php?mid=38">3rd Rock From The Sun</a><br/>&#187; <a href="tvroom.php?mid=39">Top Gear Season 13</a><br/>&#187; <a href="tvroom.php?mid=40">Smallville</a><br/>&#187; <a href="tvroom.php?mid=41">Boy Meets World</a><br/>&#187; <a href="tvroom.php?mid=42">Simpsons</a><br/>&#187; <a href="tvroom.php?mid=43">Beavis and Butthead Music</a><br/>&#187; <a href="tvroom.php?mid=54">Brainiac Tv</a><br/>&#187; <a href="tvroom.php?mid=55">Reel Good TV</a><br/>&#187; <a href="tvroom.php?mid=58">Fashion Today TV</a><br/>&#187; <a href="tvroom.php?mid=59">TV PIKA</a><br/>&#187; <a href="tvroom.php?mid=60">KCTV</a><br/>&#187; <a href="tvroom.php?mid=61">Skills Work TV</a><br/>&#187; <a href="tvroom.php?mid=62">Life Skill</a><br/>&#187; <a href="tvroom.php?mid=63">Spirit TV</a><br/>&#187; <a href="tvroom.php?mid=64">ODTU TV</a><br/>&#187; <a href="tvroom.php?mid=65">Social TV</a><br/>&#187; <a href="tvroom.php?mid=66">Home Shopping Network</a><br/>&#187; <a href="tvroom.php?mid=68">INTERIA TV</a><br/>&#187; <a href="tvroom.php?mid=69">All Music TV</a><br/>&#187; <a href="tvroom.php?mid=70">MboaTV</a><br/>&#187; <a href="tvroom.php?mid=71">TV Fly</a><br/>&#187; <a href="tvroom.php?mid=72">RTV</a><br/>&#187; <a href="tvroom.php?mid=73">CCCSAT</a><br/>&#187; <a href="tvroom.php?mid=74">UWTV</a><br/>&#187; <a href="tvroom.php?mid=75">SCC TV</a><br/>&#187; <a href="tvroom.php?mid=76">RTV Noord</a><br/>&#187; <a href="tvroom.php?mid=78">Live Sports</a><br/>&#187; <a href="tvroom.php?mid=80">TVG Esp</a><br/>&#187; <a href="tvroom.php?mid=81">STV Sport ru</a><br/>&#187; <a href="tvroom.php?mid=82">PG24</a><br/>&#187; <a href="tvroom.php?mid=83">Bahn TV</a><br/>&#187; <a href="tvroom.php?mid=84">Bloomberg TV UK</a><br/>&#187; <a href="tvroom.php?mid=85">NBC News</a><br/>&#187; <a href="tvroom.php?mid=89">BigPond Footy TV</a><br/>&#187; <a href="tvroom.php?mid=90">BigPond Sports TV</a><br/>&#187; <a href="tvroom.php?mid=91">BigPond Sports TV2</a><br/>&#187; <a href="tvroom.php?mid=92">BME Sports</a><br/>&#187; <a href="tvroom.php?mid=93">Board Riders TV</a><br/>&#187; <a href="tvroom.php?mid=94">EuroSport Russia</a><br/>&#187; <a href="tvroom.php?mid=95">STV Sport Russia</a><br/>&#187; <a href="tvroom.php?mid=96">Yoga TV</a><br/>&#187; <a href="tvroom.php?mid=97">AZTV</a><br/>&#187; <a href="tvroom.php?mid=98">Canal7 Argentina</a><br/>&#187; <a href="tvroom.php?mid=99">FX TV</a><br/>&#187; <a href="tvroom.php?mid=100">Hir TV</a><br/>&#187; <a href="tvroom.php?mid=101">Meteo TV</a><br/>&#187; <a href="tvroom.php?mid=102">NBC WeatherPlus</a><br/>&#187; <a href="tvroom.php?mid=103">NTDTV</a><br/>&#187; <a href="tvroom.php?mid=104">NTV Turkey</a><br/>&#187; <a href="tvroom.php?mid=105">RTL</a><br/>&#187; <a href="tvroom.php?mid=106">Sky News</a><br/>&#187; <a href="tvroom.php?mid=107">TVCi</a><br/>&#187; <a href="tvroom.php?mid=108">Suudi Arabistan News</a><br/>&#187; <a href="tvroom.php?mid=109">Thriller Classics TV</a><br/>&#187; <a href="tvroom.php?mid=110">TV Knob Movies</a><br/>&#187; <a href="tvroom.php?mid=111">QVC uk</a><br/>&#187; <a href="tvroom.php?mid=112">Moovee</a><br/>&#187; <a href="tvroom.php?mid=113">Classic FM TV</a><br/>&#187; <a href="tvroom.php?mid=114">Rail TV</a><br/>&#187; <a href="tvroom.php?mid=115">Goldfish TV</a><br/>&#187; <a href="tvroom.php?mid=116">Classic Arts</a><br/>&#187; <a href="tvroom.php?mid=117">Rock TV 70s</a><br/>&#187; <a href="tvroom.php?mid=118">Tiscali</a><br/>&#187; <a href="tvroom.php?mid=119">Eurosport News (UK)</a><br/>&#187; <a href="tvroom.php?mid=120">Invincible TV</a><br/>&#187; <a href="tvroom.php?mid=121">BME TV</a><br/>&#187; <a href="tvroom.php?mid=153">Return of the Ghostbusters</a><br/>&#187; <a href="tvroom.php?mid=155">ABC Kids</a><br/>&#187; <a href="tvroom.php?mid=157">allTV - Ao vivo</a><br/>&#187; <a href="tvroom.php?mid=158">Astro-line Tv</a><br/>&#187; <a href="tvroom.php?mid=159">BigPond Music</a><br/>&#187; <a href="tvroom.php?mid=160">Canal 13 Artear</a><br/>&#187; <a href="tvroom.php?mid=161">CCTV-9 (China - English Language)</a><br/>&#187; <a href="tvroom.php?mid=162">CLAP TV (France)</a><br/>&#187; <a href="tvroom.php?mid=163">Classic Arts</a><br/>&#187; <a href="tvroom.php?mid=164">Cobb County, GA TV 23</a><br/>&#187; <a href="tvroom.php?mid=165">CSU Pomona TV</a><br/>&#187; <a href="tvroom.php?mid=166">Eurofolk TV (Bulgaria)</a><br/>&#187; <a href="tvroom.php?mid=167">GlobeTrekker TV</a><br/>&#187; <a href="tvroom.php?mid=168">GMU TV</a><br/>&#187; <a href="tvroom.php?mid=169">Just TV (Brazilian)</a><br/>&#187; <a href="tvroom.php?mid=170">Kabbalah Channel</a><br/>&#187; <a href="tvroom.php?mid=171">LA36 TV</a><br/>&#187; <a href="tvroom.php?mid=172">Labelle TV</a><br/>&#187; <a href="tvroom.php?mid=173">Marti Noticias (Cuban TV - USA)</a><br/>&#187; <a href="tvroom.php?mid=174">NASA 2</a><br/>&#187; <a href="tvroom.php?mid=175">Pasadena TV 56</a><br/>&#187; <a href="tvroom.php?mid=176">RCTV - Roswell GA TV</a><br/>&#187; <a href="tvroom.php?mid=177">Research Channel</a><br/>&#187; <a href="tvroom.php?mid=178">Roo TV Dishes</a><br/>&#187; <a href="tvroom.php?mid=179">SCC TV</a><br/>&#187; <a href="tvroom.php?mid=180">SFGTV 26</a><br/>&#187; <a href="tvroom.php?mid=181">Smile Of A Child TV</a><br/>&#187; <a href="tvroom.php?mid=182">Soleil TV</a><br/>&#187; <a href="tvroom.php?mid=183">Sportal TV</a><br/>&#187; <a href="tvroom.php?mid=184">StreetClip TV</a><br/>&#187; <a href="tvroom.php?mid=185">STV Music (Brazil)</a><br/>&#187; <a href="tvroom.php?mid=187">Todo Noticias</a><br/>&#187; <a href="tvroom.php?mid=190">Wapster TV</a><br/>&#187; <a href="tvroom.php?mid=191">Worm TV</a><br/>&#187; <a href="tvroom.php?mid=195">Zona 31 TV</a><br/>&#187; <a href="tvroom.php?mid=208">The Terminator</a><br/>&#187; <a href="tvroom.php?mid=212">The Final Destination</a><br/>Adult Menu:<br/></div>
</td>
<td align="center">
<b>romantyx (southpark)</b><br/>
<script type="text/javascript">
AC_FL_RunContent( 'type','application/x-shockwave-flash','height','400','width','440','id','live_embed_player_flash','data','http://www.justin.tv/widgets/live_embed_player.swf?channel=romantyx','bgcolor','#000000','allowfullscreen','true','allowscriptaccess','always','allownetworking','all','movie','http://www.justin.tv/widgets/live_embed_player','flashvars','channel=romantyx&auto_play=false&start_volume=18' ); //end AC code
</script><noscript><object type="application/x-shockwave-flash" height="400" width="440" id="live_embed_player_flash" data="http://www.justin.tv/widgets/live_embed_player.swf?channel=romantyx" bgcolor="#000000">
<param name="allowFullScreen" value="true" />
<param name="allowScriptAccess" value="always" />
<param name="allowNetworking" value="all" />
<param name="movie" value="http://www.justin.tv/widgets/live_embed_player.swf" />
<param name="flashvars" value="channel=romantyx&auto_play=false&start_volume=18" />
</object></noscript><br/>
<iframe frameborder="0" marginwidth="0" marginheight="0" scrolling="auto" width="800" height="400" src="/xhtml/index.php?action=online"></iframe>
<iframe frameborder="0" marginwidth="0" marginheight="0" scrolling="no" width="80" height="100" src=""></iframe>
</td>
<td align="center">



		Chatbox:
	<div align="left" id="div_chat" style="height: 400px; width: 350px; overflow: auto; background-color: #F89C40; border: 1px solid #555555;">
	<"text" id="txt_message" name="txt_message" style="width: 347px;"/>		
		</div>
<input type="text" id="txt_message" name="txt_message" style="width: 347px;" />
		<form id="frmmain" name="frmmain" onSubmit="return blockSubmit();">
			<input type="button" name="btn_send_chat" id="btn_send_chat" value="Send" onClick="javascript:sendChatText();"/>
			<input type="button" name="btn_get_chat" id="btn_get_chat" value="Refresh Chat" onClick="javascript:getChatText();"/>
<a href="index.php?action=main">Home<a/>
<br/>
			

		</form>
</td>

</tr>

</table>
<div align="center">SocialBD.NeT</div>
	</body>
	
</html>
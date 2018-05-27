<?php
session_start();
error_reporting(0);
define('SR_DENIED', true);
if (!include ("config.inc.php")) { die("�� ������ ������� ���� ������������"); exit; }
if (!isset($_GET["messref"])) $messref=0; else $messref=1;

///////////   �������   ////////////

/////////// ���������� � �������������� �������� ������ � �������� ////////////
function replace ($string,$id)
{
        global $exech;
        $string = " ".$string;
        $string = str_replace ('"', "&quot;", $string);
        if ($id=="answ")
		{
		$string = eregi_replace ("[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*","<a href=\"mailto:\\0\" class=answ>\\0</a>", $string);
        $string = eregi_replace ('([[:space:]]|\n|<br>)(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '\\1<a href="http://\\2" target="_blank" class=answ>\\2</a>', $string);
        $string = eregi_replace ('([[:space:]]|\n|<br>)(http://.[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '\\1<a href="\\2" target="_blank" class=answ>\\2</a>', $string);
		}
        else if ($id=="dark")
		{
		$string = eregi_replace ("[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*","<a href=\"mailto:\\0\" class=dark>\\0</a>", $string);
        $string = eregi_replace ('([[:space:]]|\n|<br>)(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '\\1<a href="http://\\2" target="_blank" class=dark>\\2</a>', $string);
        $string = eregi_replace ('([[:space:]]|\n|<br>)(http://.[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '\\1<a href="\\2" target="_blank" class=dark>\\2</a>', $string);
		}
		else
		{
		$string = eregi_replace ("[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*","<a href=\"mailto:\\0\">\\0</a>", $string);
        $string = eregi_replace ('([[:space:]]|\n|<br>)(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '\\1<a href="http://\\2" target="_blank">\\2</a>', $string);
        $string = eregi_replace ('([[:space:]]|\n|<br>)(http://.[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '\\1<a href="\\2" target="_blank">\\2</a>', $string);
		}
        $string = eregi_replace ('(\[img\])(http://.[-a-zA-Z0-9@:%_\+.~#?&//=]+)(\[/img\])', '<img src="\\2">', $string);
        $autochange = file ($exech);
        $lines = count ($autochange);
        for($i=0;$i<$lines;$i++)
                {
                list($change1,$change2)=explode("|", $autochange[$i]);
                $string = eregi_replace("$change1","$change2",$string);
                }
        return trim($string);
}

/////////// ������� ���������� ////////////
function replace_short ($string)
        {
        global $exech;
        $string = " ".$string;
        $string = str_replace ('"', "&quot;", $string);
        $autochange = file ($exech);
        $lines = count ($autochange);
        for($i=0;$i<$lines;$i++)
                {
                list($change1,$change2)=explode("|", $autochange[$i]);
                $string = eregi_replace("$change1","$change2",$string);
                }
        return trim($string);
        }

/////////// ������� ����� ������������ ////////////
function cutty ($string)
        {
        $string = trim($string);
        $string = stripslashes($string);
		$string = str_replace ("<", "&lt;", $string);
        $string = str_replace (">", "&gt;", $string);
        $string = ereg_replace ('\\\"', "&quot;", $string);
        $string = ereg_replace ("\\\'", "&quot;", $string);
		$string = ereg_replace ("\&quot;", "&quot;", $string);
		$string = ereg_replace ("\'", "'", $string);
		$string = ereg_replace ("'", "`", $string);
        $string = str_replace ("\r", "", $string);
        $string = str_replace ("\n", "<br>", $string);
        $string = str_replace ("%", "&#37;", $string);
        $string = str_replace ("!", "&#33;", $string);
        $string = str_replace ("^ +", "", $string);
        $string = str_replace (" +$", "", $string);
        $string = str_replace ("|", "l", $string);
        return ($string);
        }

/////////// ������ ����� �������� ������ html ////////////
function getHTMLtags($text)
	{
	$text = str_replace("[b]","<strong>",$text);
	$text = str_replace("[/b]","</strong>",$text);
	$text = str_replace("[i]","<i>",$text);
	$text = str_replace("[/i]","</i>",$text);
	$text = str_replace("[font=red]","<font color=ff0000>",$text);
	$text = str_replace("[font=blue]","<font color=003399>",$text);
	$text = str_replace("[/font]","</font>",$text);
	return $text;
	}

/////////// ��������� ����� �������� ////////////
function cutHTMLtags($text)
	{
	$text = str_replace("[b]","",$text);
	$text = str_replace("[/b]","",$text);
	$text = str_replace("[i]","",$text);
	$text = str_replace("[/i]","",$text);
	$text = str_replace("[font=red]","",$text);
	$text = str_replace("[font=blue]","",$text);
	$text = str_replace("[/font]","",$text);
	return $text;
	}

/////////// �������������� ��� ��������� ////////////
function mydate($date,$messnum)
        {
        $min = date ($date);
        $date = getdate ($date);
        $mymon = array ("","������","�������","�����","������","���","����","����","�������","��������","�������","������","�������");
        $m = $date[mon];
        $myday = array( "� �����������","� �����������","�� �������","� �����","� �������","� �������","� �������");
        $d = $date[wday];
        $real_month = $mymon[$m];
        if ($real_month=="") $real_month="�������";
        $date = "��������� #".$messnum.", �������� ".$myday[$d].", $date[mday] ".$real_month." $date[year] ����, � $date[hours]:".date("i",$min);
        return $date;
        }

/////////// ����������� ��������� ////////////
function mess($name,$mess,$mail,$url,$city,$date,$answer,$messnum)
        {
        global $BORDER, $DARK, $LIGHT, $ANSW, $anti_email, $PICHEIGHT, $PICWIDTH;
		if (($mail!="")&&($anti_email<>"yes"))
		{
			$mess_mail = replace($mail,"dark");
		}
		else if (($mail!="")&&($anti_email=="yes"))
		{
			list($mm2,$mm1) = explode("@", $mail);
			$mess_mail = "<a href=\"javascript:;\"  onClick=\"openBrWindow('send_mail.php?mm1=$mm1&mm2=$mm2','send_mail','scrollbars=yes,resizable=yes,width=420,height=270');return false;\"><img src=\"mail.php?mm1=$mm1&mm2=$mm2\" align=\"absmiddle\" border=0 /></a>";
		}
        echo "\n<table border=0 align=center cellpadding=2 cellspacing=1 width=100% bgcolor=$BORDER>\n";
        echo "<tr><td align=center bgcolor=$DARK class=pdark colspan=2>\n";
		if($city=="") { echo "<a href=\"javascript: smile(':reply: [b]".$name."[/b] \\n');\"  class=dark><b>$name</b></a></td></tr>"; }
        else { echo "<a href=\"javaScript: smile(':reply: [b]".$name." (".$city.")[/b] \\n');\" class=dark><b>$name</b> ($city)</a></td></tr>\n"; }
        if($mail!=""&&$url!="") { echo "</tr><td width=50% align=center bgcolor=$DARK class=pdark>�����: $mess_mail</td><td width=50% align=center bgcolor=$DARK class=pdark>����: $url</td></tr>\n"; }
        if($url!=""&&$mail=="") { echo "</tr><td width=50% align=center bgcolor=$DARK class=pdark>�����: ���</td><td width=50% align=center bgcolor=$DARK class=pdark>����: $url</td></tr>\n"; }
        if($url==""&&$mail!="") { echo "</tr><td width=50% align=center bgcolor=$DARK class=pdark>�����: $mess_mail</td><td width=50% align=center bgcolor=$DARK class=pdark>����: ���</td></tr>\n"; }
        echo "</td></tr>\n";
        echo "<tr><td bgcolor=$LIGHT class=p colspan=2><div id=\"m$date\" align=justify>$mess</div></td></tr>\n";
        echo "<tr><td align=right bgcolor=$LIGHT class=psmall colspan=2>".mydate($date,$messnum)."</td></tr>\n";
        if(!($answer=="")) {
                echo "<tr><td align=left bgcolor=$ANSW class=pansw colspan=2>";
                echo "<b>����� :</b> $answer";
                echo "</td></tr>\n"; }
        echo "</table>\n";
        echo "<table border=0 cellpadding=0 cellspacing=0 width=100% height=4><tr><td height=4></td></tr></table>\n";
        }


/////////// ����������� ������ �� �������� �������� ////////////
function getPages($total, $page, $link, $perpage)
        {
        $mpp = $perpage;
        $prev_page = $page - 1;
        $next_page = $page + 1;
        if ($total <= $mpp) $pages = 1;
        elseif($total % $mpp == 0) $pages = $total / $mpp;
        else $pages = $total / $mpp + 1;
        $pages = (int) $pages;
        $s_pages    = $page<7 ? 1 : floor($page / 7) * 7;
        $e_pages    = $page + 6;
        if ($e_pages > $pages) { $e_pages = $pages; }
        $s = "";
        if ($pages > 6){
        if($prev_page != 0) { $s = "<a href=\"".$link."page=1\" class=\"mid\"> &lt;&lt; </a>| \n"; }
        if($prev_page) { $s .= "<a href=\"".$link."page=$prev_page\" class=\"mid\"> &lt; </a>| \n"; }}
        for($i=$s_pages;$i<=$e_pages;$i++)
                {
                if ($i != $page) { $s .= "<a href=\"".$link."page=$i\" class=\"mid\"> $i </a>| \n"; }
                elseif ($i != 1) { $s .= " <b> $i |</b> "; }
                elseif ($page != $pages) { $s .= " <b> 1 |</b> "; }
                }
        if($page != $pages && $pages > 6)
                {
                $s .= "<a href=\"".$link."page=$next_page\" class=\"mid\"> &gt; </a>| \n";
                $s .= "<a href=\"".$link."page=$pages\" class=\"mid\"> &gt;&gt; </a>| \n";
                }
        if (!isset($s) || $s == "") { $s = " <b> 1 |</b> "; }
        return $s;
        }
		
		
///////////   ����� ���� �������   ////////////


///////////   ������������� � ������ ������ ������������, �������� ���������� �� POST   ////////////
if (isset($_POST["name"]) and $_POST["name"] != "") { 
	$name = $_POST["name"];
	setcookie("cookname",cutty($name),time()+15552000); 
}
if (isset($_POST["mail"])) {
	$mail = $_POST["mail"];
	setcookie("cookmail",cutty($mail),time()+15552000);
}
if (isset($_POST["url"])) {
	$url = $_POST["url"];
	setcookie("cookurl",cutty($url),time()+15552000);
}
if (isset($_POST["city"])) {
	$city = $_POST["city"];
	setcookie("cookcity",cutty($city),time()+15552000);
}
if (isset($_POST["mess"])) {
	$mess = $_POST["mess"];
}

///////////   �������� �� ������� ������ ������������ ��� ������� � �����   ////////////
if (!isset($_POST["add"])):
        if (!isset($_COOKIE["cookname"])) $cookname = ""; else $cookname = $_COOKIE["cookname"];
        if (!isset($_COOKIE["cookmail"])) $cookmail = ""; else $cookmail = $_COOKIE["cookmail"];
        if (!isset($_COOKIE["cookurl"])) $cookurl = ""; else $cookurl = $_COOKIE["cookurl"];
        if (!isset($_COOKIE["cookcity"])) $cookcity = ""; else $cookcity = $_COOKIE["cookcity"];
        if (!isset($name) or $name == "") $name = $cookname;
        if (!isset($mail)) $mail = $cookmail;
        if (!isset($url))  $url = $cookurl;
        if (!isset($city)) $city = $cookcity;
		if (!isset($mess)){
				if (isset($_COOKIE['cookmess'])&&$messref==1)
				{
					$mess = $_COOKIE['cookmess'];
					setcookie("cookmess","",time()+15552000);
				}
				else $mess = "";
		}
endif;

///////////   �������� IP-����� ������������   ////////////
if (getenv('HTTP_X_FORWARDED_FOR'))
{
	if (trim(getenv('HTTP_X_FORWARDED_FOR'))<>"") $ip=getenv('HTTP_X_FORWARDED_FOR'); else $ip=getenv('REMOTE_ADDR');
	
}
else { $ip=getenv('REMOTE_ADDR');}

///////////   ��������� �� ���������� ������ ����� ������� ���������  ////////////
if (isset($_POST["add"])):
	if (!isset($name)) $name = "";
	if (!isset($mail)) $mail = "";
	if (!isset($url)) $url = "";
	if (!isset($city)) $city = "";
	if (!isset($mess)) $mess = "";
	if (($name == "") || (cutHTMLtags($mess) == "")) { $error[] = "�� ��������� �� ��� ������������ ����."; }
	if (strlen($name) > $maxword) { $error[] = "��� ������ ���� �� ������� $maxmail ��������."; }
	if (strlen($mail) > $maxmail) { $error[] = "����� e-mail �� ������ ��������� $maxmail ��������."; }
	if ($mail != "" && !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$",$mail)) { $error[] = "����� ������� e-mail �� ������."; }
	if (strlen($url) > $maxurl) { $error[] = "����� URL �� ������ ��������� $maxurl ��������."; }
	if (strlen($city) > $maxcity) { $error[] = "�������� ������ �� ������ ��������� $maxcity ��������."; }
	if (strlen($mess) > $maxlenght) { $error[] = "��������� �� ������ ��������� $maxlenght ��������."; }
	if (eregi("[^ ]{".$maxword.",}",$mess)) { $error[] = "����� � ��������� �� ������ ��������� $maxword ��������."; }
	$data_array = file("$data");
	$cnt = count($data_array) - 1;
	$ch_name = cutty($name);
	$ch_mess = cutty($mess);
	for ($i = $cnt; $i >= 0; $i--)
	{
		list($cname,$cmess,$cmail,$curl,$ccity,$cdate,$canswer) = explode("|", $data_array[$i]);
		$check = "$ch_name|$ch_mess";
		if($check == "$cname|$cmess") { $error[] = "����� ��������� ��� ���� � ���� ������."; }
	}
	$temp_string = $mess;
	while ($temp_string=strstr($temp_string,'[img]'))
	{
		eregi('(\[img\])(http://.[-a-zA-Z0-9@:%_\+.~#?&//=]+)(\[/img\])',$temp_string,$pic_array);
		$imgurl = $pic_array[2];
		$picfile = @fopen("$imgurl","r");
		if (!$picfile) { $error[] = "�� ������ ���� ������������ � ��������� �������."; }
		else
		{
			$imagesize = GetImageSize("$imgurl");
			if (!isset($imagesize[2])) { $error[] = "�� ��������� �������� ������� ������������� �������."; }
			else
			{
				if ($imagesize[0]>$PICWIDTH) { $error[] = "������ ������������ ������� ������ ����������� ��������� (".$PICWIDTH." ����.)"; }
				if ($imagesize[1]>$PICHEIGHT) { $error[] = "������ ������������ ������� ������ ����������� ��������� (".$PICHEIGHT." ����.)"; }
			}
		}
		$cutlength = strlen($pic_array[0]);
		$temp_string = substr($temp_string,$cutlength);
	}
endif;

///////////   ���������, �� ������� �� ��� �����    ////////////
$banip=file("$banlist");
$banlines=count($banip);
for($i=0;$i<$banlines;$i++)
{
	list($badip,$why,$who)=explode("|", $banip[$i]);
	if(strstr($ip,$badip))
	{
		include("$header");
		echo "<table width=100% border=0 cellspacing=0 cellpadding=0 class=p><tr><td align=center>";
		echo "<table width=100% bgcolor=$BORDER border=0 cellspacing=1 cellpadding=3 class=p><tr><td bgcolor=#FF0000 align=center style=\"color:#FFFFFF\"><b>������ ��������!</b></td></tr>";
		echo "<tr><td bgcolor=$LIGHT align=center>��� ��� �������� ����� �������.<br>�������: $why</td></tr></table>";
		include("$footer");
		exit;
	}
	if ((cutty($name)==cutty($who))&&(cutty($name)<>"")) $error[] = "��� ��������� ��������� ���������. �������: $why";
}

///////////   ���� ���������� ���������� ����� � ������ ���, �� ������ ���� write.php    ////////////
if ($name != "" && $mess != "" && isset($_POST["add"]) && $error == "")
{
	include("write.php");
	exit;
}

///////////   ���������  �����   ////////////
include("$header");
echo "<table width=100% border=0 cellspacing=0 cellpadding=0 class=p><tr><td align=center>";

///////////   ���������  ��������� �� �������   ////////////
if ($name != "" && $mess != "" && isset($_POST["add"]) && $error == ""):
elseif (isset($error) &&  $error != ""):
	echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\" bgcolor=\"$BORDER\">";
	echo "<tr><td align=\"center\" class=\"error\" bgcolor=\"#FF0000\"><b>������!</b></td></tr>";
	echo "<tr><td align=\"left\" class=\"p\" bgcolor=\"$LIGHT\">";
	foreach ($error as $value)
	{
		echo "<li>$value<br>";
	}
	echo "</td></tr>";
	echo "</table>";
	echo "<table border=0 cellpadding=0 cellspacing=0 width=100% height=4><tr><td height=4></td></tr></table>";
endif;

///////////   ����������, �� ����� �� ��������   ////////////
if (!isset($_GET["page"])) $page = 1;
else $page = (int)$_GET["page"]; 

///////////   ���������� ��������, �� ������� ���������. ������ �� ������   ////////////
$clean_self = $_SERVER['PHP_SELF'];
$clean_rules = array('chr(', 'chr=', 'chr%20', '%20chr', 'wget%20', '%20wget', 'wget(',
 			       'cmd=', '%20cmd', 'cmd%20', 'rush=', '%20rush', 'rush%20',
                   'union%20', '%20union', 'union(', 'union=', 'echr(', '%20echr', 'echr%20', 'echr=',
                   'esystem(', 'esystem%20', 'cp%20', '%20cp', 'cp(', 'mdir%20', '%20mdir', 'mdir(',
                   'mcd%20', 'mrd%20', 'rm%20', '%20mcd', '%20mrd', '%20rm',
                   'mcd(', 'mrd(', 'rm(', 'mcd=', 'mrd=', 'mv%20', 'rmdir%20', 'mv(', 'rmdir(',
                   'chmod(', 'chmod%20', '%20chmod', 'chmod(', 'chmod=', 'chown%20', 'chgrp%20', 'chown(', 'chgrp(',
                   'locate%20', 'grep%20', 'locate(', 'grep(', 'diff%20', 'kill%20', 'kill(', 'killall',
                   'passwd%20', '%20passwd', 'passwd(', 'telnet%20', 'vi(', 'vi%20',
                   'insert%20into', 'select%20', 'nigga(', '%20nigga', 'nigga%20', 'fopen', 'fwrite', '%20like', 'like%20',
                   '$_request', '$_get', '$request', '$get', '.system', 'http_php', '&aim', '%20getenv', 'getenv%20',
                   'new_password', '&icq','/etc/password','/etc/shadow', '/etc/groups', '/etc/gshadow',
                   'http_user_agent', 'http_host', '/bin/ps', 'wget%20', 'uname\x20-a', '/usr/bin/id',
                   '/bin/echo', '/bin/kill', '/bin/', '/chgrp', '/chown', '/usr/bin', 'g\+\+', 'bin/python',
                   'bin/tclsh', 'bin/nasm', 'perl%20', 'traceroute%20', 'ping%20', '.pl', '/usr/x11r6/bin/xterm', 'lsof%20',
                   '/bin/mail', '.conf', 'motd%20', 'http/1.', '.inc.php', 'config.php', 'cgi-', '.eml',
                   'file\://', 'window.open', '<script>', 'javascript\://','img src', 'img%20src','.jsp','ftp.exe',
                   'xp_enumdsn', 'xp_availablemedia', 'xp_filelist', 'xp_cmdshell', 'nc.exe', '.htpasswd',
                   'servlet', '/etc/passwd', 'wwwacl', '~root', '~ftp', '.js', '.jsp', 'admin_', '.history',
                   'bash_history', '.bash_history', '~nobody', 'server-info', 'server-status', 'reboot%20', 'halt%20',
                   'powerdown%20', '/home/ftp', '/home/www', 'secure_site, ok', 'chunked', 'org.apache', '/servlet/con',
                   '<script', '/robot.txt' ,'/perl' ,'mod_gzip_status', 'db_mysql.inc', '.inc', 'select%20from',
                   'select from', 'drop%20', '.system', 'getenv', 'http_', '_php', 'php_', 'phpinfo()', "'", '<', '>', 'sql=', '.php/');

$clean_self  = str_replace($clean_rules, '', $clean_self);

///////////   ���������  �����   ////////////
if (!eregi("\%", $TABWIDTH)) $SENDWIDTH = $TABWIDTH-300;
else $SENDWIDTH = 300;
include("$send_form");

///////////   ��������� ���������� ����� ���� ���������   ////////////
$file_array = file("$data");
$lines = count($file_array);

$print_pages = getPages($lines, $page, "$clean_self?", $maxmess);

///////////   �������� �������� �������   ////////////
echo "<table bgcolor=$BORDER border=0 cellpadding=2 cellspacing=1 width=100%><tr><td bgcolor=$LIGHT class=pmid align=center><b>����� ��������� : $lines</b></td></tr><tr><td bgcolor=$LIGHT class=pmid align=center><b>�������� : |$print_pages</b></td></tr></table>";
echo "<table border=0 cellpadding=0 cellspacing=0 width=100% height=4><tr><td height=4></td></tr></table>";

$from = $lines - ($page * $maxmess - 1);
$to = $lines - (($page - 1) * $maxmess);
if($from < 0) { $from = 1; }

///////////   �������� ���������   ////////////
for($i = $to - 1; $i >= $from - 1; $i--)
        {
        $id=$i;
		list($name,$mess,$mail,$url,$city,$date,$answer) = explode("|", $file_array[$i]);
        if(!($name==""&&$mess=="")):
				$messnum=$id+1;
                $name = replace_short($name);
                $mess = replace($mess,"light");
				$mess = getHTMLtags($mess);
                $url = replace($url,"dark");
                $city = replace_short($city);
                $answer = replace($answer,"answ");
                mess($name,$mess,$mail,$url,$city,$date,$answer,$messnum);
        endif;
        }

///////////   �������� �������� ������� � ������   ////////////
echo "<table bgcolor=$BORDER border=0 cellpadding=2 cellspacing=1 width=100%><tr><td bgcolor=$LIGHT class=pmid align=center><b>�������� : |$print_pages</b></td></tr><tr><td bgcolor=$LIGHT class=pmid align=center><a href=admin.php></a><a href=readme.html></a><b>����� ��������� : $lines</b></td></tr></table>";
echo "</table><tr><td><table border=0 cellpadding=0 cellspacing=0 width=100% height=2><tr><td height=2></td></tr></table>
<table width=100% border=0 cellspacing=1 cellpadding=3 bgcolor=$BORDER><tr><td align=center class=pdark bgcolor=$DARK><a href=\"http://www.sadraven.ru/\" title=\"������� ������ �������� �����\" target=\"_blank\" class=\"dark\">SR</a> + <a href=\"http://www.profy.org/gb/\" target=\"_blank\" class=\"dark\">Denied</a> Guestbook $version &copy; 2008</td></tr></table>";
include("$footer");
?>
<?
define('SR_DENIED', true);
if (!include ("config.inc.php")) { die("�� ������ ������� ���� ������������"); exit; }
function clean ($string)
{
	/////////// ������� ������ ������ ////////////
	$string = eregi_replace("[^_A-Z.a-z0-9-]","",$string);
	return ($string);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title><?=$gname?></title>
<? require ("design/css.inc.php"); ?>
<script language="JavaScript">
<!--
		function checkForm () {
			var name = document.sendform.name.value;
			var msg = document.sendform.text.value;
			var mail = document.sendform.mail.value;

			if(name=="") {
				alert("����������, ������� ���� ���.");
				document.sendform.name.focus();
				return false;
			}

			if(mail == "") {
				alert("����������, ������� ���� Email.");
				document.sendform.mail.focus();
				return false;
			}

			if(mail.indexOf('@',0) == -1 || mail.indexOf('.',0) == -1){
				alert("�� ����� ������������ email.\n��������� ������������ ����� email � ������� ��� ���.");
				document.sendform.mail.value="";
				document.sendform.mail.focus();
				return false;
			}

			if(msg=="") {
				alert("����������, ������� ���������.");
				document.sendform.text.focus();
				return false;
			}

				return true;
			}
//-->
</script>

</head>

<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0"  bgcolor=<?=$BACKGROUND?>>
<? 
if (!isset($_POST["send"]))
{
	$mm1 = clean($_GET["mm1"]);
	$mm2 = clean($_GET["mm2"]);
?>
<form id="sendform" name="sendform" method="post" action="" onSubmit="return checkForm();">
  <label></label>
  <table width="400" border="0" cellpadding="1" cellspacing="1" bgcolor=<?=$BORDER;?>>
    <tr>
      <td align="center" bgcolor=<?=$DARK;?> class="pdark"><strong>�������� ������ �� ����� <? echo "<img src=\"mail.php?mm1=".$mm1."&mm2=".$mm2."\" align=\"absmiddle\"/>"; ?></strong></td>
    </tr>
    <tr>
      <td bgcolor=<?=$LIGHT;?>><table width="100%" border="0" cellspacing="4" cellpadding="4">
        <tr>
          <td class=p>���<strong>*</strong>:
            <input name="mm1" type="hidden" id="mm1" value="<?=$mm1?>" />
            <input name="mm2" type="hidden" id="mm2" value="<?=$mm2?>" />
		  </td>
          <td><input class=p name="name" type="text" id="name" /></td>
        </tr>
        <tr>
          <td class=p>��� email<strong>*</strong>: </td>
          <td><input class=p name="mail" type="text" id="mail" /></td>
        </tr>
        <tr>
          <td class=p>���� ������: </td>
          <td><input class=p name="theme" type="text" id="theme" /></td>
        </tr>
        <tr>
          <td class=p>����� ������<strong>*</strong>: </td>
          <td><textarea class=p name="text" cols="25" rows="6" id="text"></textarea></td>
        </tr>
        <tr>
          <td colspan="2" class="p">* - ���� ������������ ��� ����������.</td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input name="send" type="submit" class="p" id="send" style="width:125px;cursor:hand;" onmouseover="this.style.backgroundColor='<?=$DARK;?>';" onmouseout="this.style.backgroundColor='<?=$LIGHT;?>';" value="���������"></td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
<?
}
else
{
//////////////// �������� email ////////////////


	$name           = htmlspecialchars(stripslashes(trim($_POST['name'])));
	$mail           = htmlspecialchars(stripslashes(trim($_POST['mail'])));
	$theme          = htmlspecialchars(stripslashes(trim($_POST['theme'])));
	$text           = htmlspecialchars(stripslashes(trim($_POST['text'])));
	$adresat = clean($_POST['mm2'])."@".clean($_POST['mm1']);
	$host = $_SERVER['HTTP_HOST'];
	$message = "�� �������� $gname (���� $host) ��� ���� ������� ���������
	~~
��� ..................... $name
Email ................... $mail
���� .................... $theme
����� ���������.......... $text
	~~
";	

		$subj = "��������� �� �������� ����� ".$host;
		$headers = "From: ".$mail."\r\nContent-Type: text/plain; charset=windows-1251\r\nContent-Transfer-Encoding: 8bit";
		if (@mail($adresat, $subj, $message, $headers))
		{
		}
		else
		{
			die('���������� ��������� ���������</body></html>');
			exit;
		}

?>
<table width="400" height="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="<?=$BORDER;?>">
  <tr>
    <td align="center" bgcolor="<?=$DARK;?>" class="p2"><strong>�������� ������ </strong></td>
  </tr>
  <tr>
    <td bgcolor="<?=$LIGHT;?>"><table width="100%" height="100%" border="0" cellpadding="4" cellspacing="4">
      <tr>
        <td height="100%" class="p"><p>��������� ����������...<br />
          <img src="img/spacer.gif" alt="" width="1" height="175" /></p>
            <p align="right"><a href="javascript:self.close()">������� ���� &nbsp;&nbsp; </a></p></td>
      </tr>
    </table></td>
  </tr>
</table>

<?
}
?>
</body>
</html>

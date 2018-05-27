<html>
<head>
<title><?=$gname?></title>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="content-type" content="text/html; charset=windows-1251">
<? require ("design/css.inc.php"); ?>
<script language=JavaScript type="text/javascript">
<!--
function smile(str){
	obj = document.Sad_Raven_Guestbook.mess;
	obj.focus();
	obj.value =	obj.value + str;
}
function openBrWindow(theURL,winName,features){
  	window.open(theURL,winName,features);
}
function inserttags(st_t, en_t){ 
	obj = document.Sad_Raven_Guestbook.mess;
	obj2 = document.Sad_Raven_Guestbook;
	if ((document.selection)) {
		obj.focus();
		obj2.document.selection.createRange().text = st_t+obj2.document.selection.createRange().text+en_t;
	}
	else 
	{
		obj.focus();
		obj.value += st_t+en_t;
	}
}
//-->
</script>
</head>
<body bgcolor=<?=$BACKGROUND?> topmargin=15 leftmargin=0 marginwidth=0 marginheight=0>
<div align=center>
<table width=<?=$TABWIDTH?> border=0 cellspacing=0 cellpadding=2><tr><td>
<table width=100% border=0 cellspacing=1 cellpadding=3 bgcolor=<?=$BORDER?>><tr><td align=center class=pdarkhead bgcolor=<?=$DARK?>><b><?=$gname?></b></td></tr></table>
</td></tr><tr><td>

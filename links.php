<?php

error_reporting(0);

define("BASE_FOLDER", "basepr_0055");

$setup['allsubmitter_login'] = 'basepr';
$setup['allsubmitter_pw'] = 'basepr';
$addlink = GetParametr('addlink', 'post');
if ($addlink == 1)
	AddLinkPost();
$dellink = GetParametr('dellink', 'post');
if ($dellink == 1)
	DelLinkPost();

FindLink();

function make_seed()
{
	list($usec, $sec) = explode(' ', microtime());
	return (float) $sec + ((float) $usec * 100000);
}

function file_put_contentz($file, $content)
{
	$h = fopen($file, 'wb');
	fwrite($h, $content, strlen($content));
	fclose($h);
}

exit;

function FindLink()
{
	global $setup;
	$id = GetParametr('id', 'get');
	$linkdata = file_get_contents(BASE_FOLDER . "/{$id}.txt");
	echo $linkdata;
}

function DelLinkPost()
{
	global $setup;
	$pw = GetParametr('pw', 'post');
	$login = GetParametr('login', 'post');
	if (($login != $setup['allsubmitter_login']) or ($pw != $setup['allsubmitter_pw']))
	{
		echo 'strbeg' . 'errorlogin' . 'strend';
		exit;
	}
	echo 'strbeg' . 'Deleted!' . 'strend';
	exit;
}

function AddLinkPost()
{
	global $setup;
	$pw = GetParametr('pw', 'post');
	$login = GetParametr('login', 'post');
	$linkdata = GoodVal(GetParametr('linkdata', 'post'));
	if (($login != $setup['allsubmitter_login']) or ($pw != $setup['allsubmitter_pw']))
	{
		echo 'strbeg' . 'errorlogin' . 'strend';
		exit;
	}
	do 
	{
		mt_srand(make_seed());
		$newFileName = mt_rand(100000000, 999999999);
	} 
	while (file_exists(BASE_FOLDER . "/{$newFileName}.txt"));
	file_put_contentz(BASE_FOLDER . "/{$newFileName}.txt", $linkdata);
	echo 'strbeg' . $newFileName . 'strend';
	exit;
}

function GetParametr($name, $type)
{
	global $HTTP_GET_VARS, $HTTP_POST_VARS;
	if ($type == 'get')
		$from = $_GET;
	if ($type == 'post')
		$from = $_POST;
	$par = -1;
	while (list($key, $val) = each($from))
	{
		if ($key == $name)
		{
			$par = $val;
		}
	}
	return $par;
}

function GoodVal($str)
{
	$str = str_replace('\"', '"', $str);
	return str_replace("\'", "'", $str);
}

?>
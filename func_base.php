<?php
// cerda（クエルダ）は本プログラムソースコードの著作権を保有しています。
// Copyright (C) 2020 CUERDA(https://cuerda.org).
if(!defined('ABSPATH')){
die('Forbidden');
}
require 'ini_base.php';
require $ini_user;
header($header_response);
header($header_expires . gmdate($gmdate_format, time() + (int)$expires));
header($header_cache_control . $expires);
switch($code){
case('200'):
if($feed_for !== 'ynf'){echo $documenttype;}
echo $rss_xmlns;
require $mod_channel;
echo PHP_EOL;
require $mod_item;
echo PHP_EOL;
echo $channel_end;
if(strstr($url_param,'admin=true')){
	require $func_admin;
	}else{
}
break;case('403'):
echo $cuerda403error;
break;case('404'):
echo $cuerda404error;
break;case('500'):
echo $cuerda500error;
break;default:
echo $cuerda_die_error;
break;
}

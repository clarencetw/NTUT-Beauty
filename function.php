<?php
function message( $message ){
	$replace = array("*", "\"", "(", ")", //不想顯示的字樣
	                );
	$message = str_replace($replace, "", $message);
	$message = make_clickable($message);
	return $message;
}

function make_clickable($text){ 
   $ret = " " . $text; 
   $ret = preg_replace("#([\n ])([a-z]+?)://([^,\t \n\r]+)#i", "\\1<a href=\"\\2://\\3\" target=\"_blank\">\\2://\\3</a>", $ret); 
   $ret = preg_replace("#([\n ])www\.([a-z0-9\-]+)\.([a-z0-9\-.\~]+)((?:/[^,\t \n\r]*)?)#i", "\\1<a href=\"http://www.\\2.\\3\\4\" target=\"_blank\">www.\\2.\\3\\4</a>", $ret); 
   $ret = preg_replace("#([\n ])([a-z0-9\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)?[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret); 
   $ret = substr($ret, 1); 
   return($ret);
}

?>
<html lang="zh-tw">
  <head>
    <meta charset="utf-8">
  </head>
<?php
require_once('facebook.php');
require_once('function.php');
require_once('config/appid.php');

if(isset($_GET['id'])) {
	if(preg_match('/^(641858572566349_)[0-9]/', $_GET['id'])){ // 641858572566349 修改成要顯示的 Pages ID
		$feedid = $_GET['id'];
		$facebook = new Facebook($config);
		$pages = $facebook->api($feedid . '?fields=likes.limit(1000).fields(pic,name),comments.limit(1000),message,picture,link', 'GET'); //fields=likes.limit(50)  fields=comments
		//print_r($pages);
		echo '<div class="modal-header">' . "\r\n";
		echo '  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' . "\r\n";
		echo '  <h4 class="modal-title">表特北科</h4>' . "\r\n";
		echo '</div>' . "\r\n";

		echo '<div class="modal-body">' . "\r\n";
		echo '  <div class="row">' . "\r\n";
		echo '    <div class="col-md-3"><a href="' . $pages['link'] . '">' .'<img src="' . $pages['picture'] . '" alt="message" class="img-thumbnail"></a></div>' . "\r\n";
		echo '    <div class="col-md-9"><h3> Message:' . $pages['message'] . '</h3></div>' . "\r\n";
		echo '  </div>' . "\r\n";
		echo '  <hr>';
		echo '  <h4>誰來按贊</h4>' . "\r\n";
		foreach ($pages['likes']['data'] as $key => $value) {
			if (($key % 4) == 0) echo '  <div class="row">' . "\r\n";
			echo '    <div class="col-md-3"><a href="http://www.facebook.com/' . $value['id'] .  '" target="_blank"><img src="' . $value['pic'] . '" alt="' . $value['name'] . '" class="img-circle" height="100" width="100" /></a><p><a href="http://www.facebook.com/' . $value['id'] . '" target="_blank">' . $value['name'] . '</a></p></div>' . "\r\n";
			if (($key % 4) == 3) echo '  </div>' . "\r\n"; 
		}
		if(($key % 4) != 3) echo '  </div>' . "\r\n";
		echo '  <hr>' . "\r\n";
		echo '  <h4>誰來回應</h4>' . "\r\n";
		foreach ($pages['comments']['data'] as $key => $value) {
			echo '  <blockquote>';
			echo '<p>' . $value['message'] . '</p><footer><cite title="Source Title">' . $value['from']['name'] . "</cite></footer>";
			echo '  </blockquote>' . "\r\n";
		}
		

		echo '</div>' . "\r\n";
		echo '<div class="modal-footer">' . "\r\n";
		echo '  <button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>' . "\r\n";
		echo '</div>' . "\r\n";

	}
}




?>
</html>
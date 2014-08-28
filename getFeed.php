<html lang="zh-tw">
  <head>
    <meta charset="utf-8">
  </head>
<?php
require_once('facebook.php');
require_once('function.php');
include_once('config/analyticstracking.php');
require_once('config/appid.php');

$newload = 0;
$facebook = new Facebook($config);
$pages = $facebook->api('641858572566349/feed?limit=1','GET'); // 641858572566349 修改成要顯示的 Pages ID
$newid = $pages['data']['0']['id'];
$oldid = file_get_contents('nowid', FILE_USE_INCLUDE_PATH);
if($oldid != $newid) {
  file_put_contents('nowid', $newid);
  $newload = 1;
}

$databaseNum = 0;

if($newload == 1){ //已更新 寫入新的 database
  $pages = $facebook->api('641858572566349/feed?limit=100','GET'); // 641858572566349 修改成要顯示的 Pages ID
  file_put_contents('database_' . $databaseNum++, serialize($pages));
  $url = parse_url($pages['paging']['next']);
  while( 1 ){
    $pages = $facebook->api(str_replace('/v2.0', '', $url['path']) . '?' . $url['query'],'GET');
    file_put_contents('database_' . $databaseNum++, serialize($pages));
    if(isset($pages['paging']['next'])) break;
    $url = parse_url($pages['paging']['next']);
  }
}

$databaseNum = 0;
echo "<div class=\"row\"  id=\"row\">\r\n";

while(file_exists('database_' . $databaseNum)){
  $pages = unserialize(file_get_contents('database_' . $databaseNum++));
  $feed = $pages['data'];
  foreach ($feed as $feedNum => $feedData) {
    if(!isset($feedData['picture'])) continue;

    echo "<div class=\"col-sm-6 col-md-2\">\r\n";
    echo "<div class=\"thumbnail\">\r\n";
    echo '  <a href="' . $feedData['link'] . '" target="_blank"><img src="' . $feedData['picture'] . '" width="300px"></a>' . "\r\n";
    echo "  <div class=\"caption\">\r\n";
    if(isset($feedData['message'])){
      $feedMessage = message($feedData['message']);
      echo "    <p>" . $feedMessage . "</p>\r\n";
    }
    echo "    <div class=\"btn-group\">\r\n";
    echo "      <button name=\"comment\" class=\"btn btn-default\" data-toggle=\"modal\" data-target=\"#feedModal\" value=\"" . $feedData['id'] . "\"><span class=\"glyphicon glyphicon-comment\"></span></button>";
    
    echo "    </div>\r\n";
    echo "  </div>\r\n";
    echo "</div>\r\n";
    echo "</div>\r\n";

  }
}
echo "</div>\r\n";
// echo $e->getType() . ' ';
// echo $e->getMessage() . "<br /> \r\n";

?>
</html>

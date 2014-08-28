<?php
require_once('facebook.php');
include_once('config/analyticstracking.php');
require_once('config/appid.php');

$facebook = new Facebook($config);
$user = $facebook->getUser();
if ($user) {
  try {
    $userProfile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    $user = null;
  }
}
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl(array(
      'redirect_uri' => ''
    ));
} else {
  $loginUrl = $facebook->getLoginUrl(array(
      'redirect_uri' => ''
    ));
}
?>
<!DOCTYPE html>
<html lang="zh-tw">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Clarence">
    <meta property="og:image" content="facebooklogo.png"/>
    <meta property="og:title" content="北科表特"/>
    <meta property="og:url" content="http://ntutbeauty.clarence.tw/"/>

    <title>北科表特</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="default.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">北科表特</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li>
  <?php if ($user): ?>
                <a><?php echo $userProfile['name']; ?></a>
  <?php else: ?>
                <a href="<?php echo $loginUrl; ?>">登入</a>
  <?php endif ?>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div id="feedModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div id="feedMessage" class="modal-content">
        </div>
      </div>
    </div>
    <div class="container" id="container">
      <button type="button" id="loading-btn" data-loading-text="Loading..." class="btn btn-default btn-lg btn-block" onclick="location='<?php echo $loginUrl; ?>';">因 Facebook 關係 請登入</button>
    </div>
    <div class="container">
      <hr>
      <p>以上資料轉自 <a href="https://www.facebook.com/ntutbeauty" target="_blank">表特北科 NTUT Beauty</a></p>
      <p>Copyright © 2014 <a href="https://www.facebook.com/Mr.ClarenceLin" target="_blank">Clarence</a>. All rights reserved</p>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
    <script src="js/imagesloaded.pkgd.min.js"></script>
    <script type="text/javascript">
      $.ajax({
        url: 'getFeed.php',
        error: function(xhr) {
          console.log('Ajax request 發生錯誤');
        },
        success: function(response) {
          $('#container').html(response);
        },
        complete: function(){
          var container = document.querySelector('#row');
          var msnry;
          imagesLoaded( container, function() {
            msnry = new Masonry( container, {
              columnWidth: 5,
              isAnimated: true,
              itemSelector: '.col-sm-6'
            });
          });
          messageClick();
        }
      });
      $('#loading-btn').button('loading');
      function messageClick(){
        $('button[name=comment]').click(function() {
          console.log(this.value);
          console.log(this.name);
            $.ajax({
              type: "GET",
              url: 'getFeedInfo.php',
              data: { id : this.value },
              dataType: "html",
              error: function(xhr) {
                console.log('Ajax request 發生錯誤');
              },
              success: function(response) {
                $('#feedMessage').html(response);
              },
              complete: function(){

              }
            });
        });
      }
    </script>
  </body>
</html>

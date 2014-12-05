<?php
require('include/function.php');

//get User Info
$facebook = getFB();
$user = $facebook->getUser();
$loginUrl = $facebook->getLoginUrl();

if($user) {
	try {
		$userProfile = $facebook->api('/me','GET');
		$logoutUrl = $facebook->getLogoutUrl();
	} catch(FacebookApiException $e) {
		$login_url = $facebook->getLoginUrl(); 
	}
}else{
	$login_url = $facebook->getLoginUrl();
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
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/default.css" rel="stylesheet">

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
				<a href='<?php echo $logoutUrl?>'><?php echo $userProfile['name']; ?></a>
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
      <button type="button" id="loading-btn" data-loading-text="Loading..." class="btn btn-default btn-lg btn-block" onclick="location='<?php echo $loginUrl; ?>';">請登入 Facebook 已檢視</button>
    </div>
    <div class="container">
      <hr>
      <p>以上資料轉自 <a href="https://www.facebook.com/ntutbeauty" target="_blank">表特北科 NTUT Beauty</a></p>
      <p>Copyright © 2014 <a href="https://www.facebook.com/Mr.ClarenceLin" target="_blank">Clarence</a>. All rights reserved</p>
    </div>


    <script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', '{your ga id}', 'auto'); //可以修改成你的 GA
	  ga('require', 'displayfeatures');
	  ga('send', 'pageview');
	</script>
    <script src="js/jquery-2.0.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
    <script src="js/imagesloaded.pkgd.min.js"></script>
    <script type="text/javascript">
     $(function(){
		 $('#loading-btn').button('loading');
		 $("#container").load('getFeed.php',function(){
			var container = $('#row')[0];
			var msnry;
			imagesLoaded( container, function() {
				msnry = new Masonry( container, {
				  columnWidth: 5,
				  isAnimated: true,
				  itemSelector: '.col-sm-6'
				});
			});
		 }).on('click', 'button[name=comment]', function(){
			$.get('getFeedInfo.php',{id: $(this).val()},function(response){
				$('#feedMessage').html(response);
			});			
         });
	 });
    </script>
  </body>
</html>

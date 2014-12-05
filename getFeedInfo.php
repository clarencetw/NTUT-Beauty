<?php
require_once('include/function.php');

if(!isset($_GET['id'])) { exit;}
if( !preg_match('/^('.$fbPagesID.'_)[0-9]/', $_GET['id']) ){ exit; }
	
$feedid = $_GET['id'];
$facebook = getFB();
$pages = $facebook->api($feedid . '?fields=likes.limit(1000).fields(pic,name),comments.limit(1000),message,picture,link', 'GET'); //fields=likes.limit(50)  fields=comments
//print_r($pages);
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title">表特北科</h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-md-3">
			<a href="<?php echo $pages['link']?>">
				<img src="<?php echo $pages['picture']?>" alt="message" class="img-thumbnail">
			</a>
		</div>
		<div class="col-md-9">
			<p style='font-size:1.3em;margin:0;'><span class="glyphicon glyphicon-comment"></span></p>
			<p style='font-size:1.3em;'><?php echo $pages['message']?></p>
		</div>
	</div>
	
	<ul class="nav nav-tabs" role="tablist">
		<li class="active"><a href="#likes" role="tab" data-toggle="tab">讚</a></li>
		<li><a href="#comments" role="tab" data-toggle="tab">回應</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="likes">
			<div class="row">
			<?php foreach ($pages['likes']['data'] as $key => $value):?>
				<div class="col-md-3">
					<a href="http://www.facebook.com/<?php echo $value['id']?>" target="_blank">
						<img src="<?php echo $value['pic']?>" alt="<?php echo $value['name']?>" class="img-circle" height="100" width="100" />
					</a>
					<p><a href="http://www.facebook.com/<?php echo $value['id']?>" target="_blank"><?php echo $value['name']?></a></p>
				</div>		
				<?php if (($key % 4) == 3):?>
					</div><div class="row">
				<?php endif;?>
			<?php endforeach;?>
			</div>
		</div>
		<div class="tab-pane" id="comments">
			<?php if(count($pages['comments']['data'])):?>
			<?php foreach($pages['comments']['data'] as $key => $value):?>
			  <blockquote>
				<p><?php echo $value['message']?></p>
				<footer><cite title="Source Title"><?php echo $value['from']['name']?></cite></footer>
			  </blockquote>
			<?php endforeach;?>
			<?php else:?>
			   <h4>目前沒有回應唷</h4>
			<?php endif;?>
		</div>
	</div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
</div>
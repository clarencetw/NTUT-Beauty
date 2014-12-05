<?php
require_once('include/function.php');

//check page feed is changed, if changed update and save
$facebook = getFB();
$pages = $facebook->api($fbPagesID.'/feed?limit=1','GET');
$newid = $pages['data']['0']['id'];
$oldid = @file_get_contents('nowid', FILE_USE_INCLUDE_PATH);

$fb_original = $feedData = array();
if($oldid != $newid) {	//fetch new feed data
	file_put_contents('nowid', $newid);
	$fb_original[0] = $facebook->api($fbPagesID.'/posts?limit=250','GET');	//max limit is 250	
	
	while(1){	//loop for next page
		$prevPageNextUri = $fb_original[count($fb_original)-1]['paging']['next'];
		if(strlen($prevPageNextUri)){
			$url = parse_url($prevPageNextUri);	
			$fb_original[] = $facebook->api( $url['path'].'?'.$url['query'] ,'GET');
		}else{
			break;
		}
	}
	foreach( $fb_original as $pages ){
		foreach( $pages['data'] as $row ){
			if( !isset($row['picture']) ) continue;	//ignore no picture post			
			$feedData[] = array(
								'link' 		=> $row['link'],
								'picture'	=> $row['picture'],
								'message'	=> message(trim($row['message'])),
								'id'		=> $row['id']
							  );							
		}
	}
	file_put_contents('database', serialize($feedData));
}else{	//load cache data
	$feedData = unserialize(file_get_contents('database'));
}
?>
<div class="row"  id="row">
	<?php foreach($feedData as $feedNum => $feedData): ?>
	<div class="col-sm-6 col-md-2">
		<div class="thumbnail">
			<a href="<?php echo $feedData['link']?>" target="_blank">
				<img src="<?php echo $feedData['picture']?>" width="300px">
			</a>
			<div class="caption">
				<p><?php echo $feedData['message']?></p>
				<div class="btn-group">
					<button name="comment" class="btn btn-default" data-toggle="modal" data-target="#feedModal" value="<?php echo $feedData['id']?>">
						<span class="glyphicon glyphicon-comment"></span> <span> Likes, Comment</span>
					</button>
				</div>
			</div>
		</div>
	</div>
	<?php endforeach;?>
</div>
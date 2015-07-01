<?php
include("elybin-function.php");
include("elybin-oop.php");
header('Content-Type: application/rss+xml');

// get options
$tbo = new ElybinTable('elybin_options');

// this is all information
$option = array('cmsbase' => "ElybinCMS");

// option
$getop = $tbo->Select('','');
foreach ($getop as $go) {
	$option = array_merge($option, array($go->name => $go->value));
}
// convert array to object
$op = new stdClass();
foreach ($option as $key => $value)
{
    $op->$key = $value;
}

// get 
$p = @$_GET['p'];


// RSS NEWS & POST
if($p == "news"){
?>
<?php 
echo '<?xml version="1.0" encoding="utf-8"?>'; 
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title><?php echo $op->site_name ?></title>
		<atom:link href="<?php echo $op->site_url ?>feed/news" rel="self" type="application/rss+xml"/>
		<link><?php echo $op->site_url ?></link>
		<description><?php echo $op->site_description ?></description>
		<lastBuildDate><?php echo date("D, d M Y H:i:s \G\M\T"); ?></lastBuildDate>
		<language>en-us</language>
		<image>
			<url><?php echo $op->site_url ?>elybin-file/system/favicon.png</url>
			<title><?php echo $op->site_name ?></title>
			<link><?php echo $op->site_url ?></link>
		</image>
<?php
$tbp = new ElybinTable("elybin_posts");
$post = $tbp->SelectWhereLimit('status','publish','post_id','DESC','0,50');
foreach($post as $p){
?>
		
		<item>
			<title><![CDATA[<?php echo $p->title; ?>]]></title>
			<link><![CDATA[<?php echo $op->site_url ?>post-<?php echo $p->post_id; ?>-<?php echo rtrim($p->seotitle); ?>.html]]></link>
			<guid><![CDATA[<?php echo $op->site_url ?>post-<?php echo $p->post_id; ?>-<?php echo rtrim($p->seotitle); ?>.html]]></guid>
			<pubDate><?php echo date("D, d M Y H:i:s \G\M\T", strtotime($p->date." ".$p->time)); ?></pubDate>
			<description><![CDATA[<?php echo cutword(strip_tags($p->content),400); ?>...]]>
			</description>
		</item>		
<?php } ?>
	</channel>
</rss>

<?php
}

// ATOM COMMENT
elseif($p == "comment"){
?>
<?php 
echo '<?xml version="1.0" encoding="utf-8"?>'; 
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title><?php echo $op->site_name ?> - Recent Comment</title>
		<atom:link href="<?php echo $op->site_url ?>feed/comment" rel="self" type="application/rss+xml"/>
		<link><?php echo $op->site_url ?></link>
		<description>Recent Comment from <?php echo $op->site_name ?>.</description>
		<lastBuildDate><?php echo date("D, d M Y H:i:s \G\M\T"); ?></lastBuildDate>
		<language>en-us</language>
		<image>
			<url><?php echo $op->site_url ?>elybin-file/system/favicon.png</url>
			<title><?php echo $op->site_name ?> - Recent Comment</title>
			<link><?php echo $op->site_url ?></link>
		</image>
<?php
$tbu = new ElybinTable("elybin_comments");
$com = $tbu->SelectWhereLimit('status','active','comment_id','DESC','0,50');
foreach($com as $c){
	$tbluser 	= new ElybinTable('elybin_users');
	$cuser	= $tbluser->SelectWhere('user_id',$c->user_id,'','');
	$cuser	= $cuser->current();
	if($c->user_id > 0){
		$author = $cuser->fullname;
		$email = $cuser->user_account_email;
	}else{
		$author = $c->author;
		$email = $c->email;
	}

	if($c->post_id > 0){
		$tbp 	= new ElybinTable('elybin_posts');
		$last	= $tbp->SelectWhere('post_id',$c->post_id,'','');
		$ptitle = $last->current();
		$ptitle = $ptitle->title;
	}
	elseif($c->gallery_id > 0){
		$tbp 	= new ElybinTable('elybin_gallery');
		$last	= $tbp->SelectWhere('gallery_id',$c->gallery_id,'','');
		$ptitle = $last->current();
		$ptitle = $ptitle->name;
	}
?>
		<item>
			<title><![CDATA[<?php echo $author; ?>]]> comment "<?php echo $ptitle?>"</title>
<?php
	if($c->post_id > 0){
?>
			<link><![CDATA[<?php echo $op->site_url ?>post-<?php echo $c->post_id; ?>-<?php echo seo_title(rtrim($ptitle)); ?>.html]]></link>
			<guid><![CDATA[<?php echo $op->site_url ?>post-<?php echo $c->post_id; ?>-<?php echo seo_title(rtrim($ptitle)); ?>.html#<?php echo $c->comment_id; ?>]]></guid>
<?php
	}elseif($c->gallery_id > 0){
?>
			<link><![CDATA[<?php echo $op->site_url ?>photo-<?php echo $c->gallery_id; ?>-<?php seo_title(rtrim($ptitle)); ?>.html]]></link>
			<guid><![CDATA[<?php echo $op->site_url ?>photo-<?php echo $c->gallery_id; ?>-<?php seo_title(rtrim($ptitle)); ?>.html#<?php echo $c->comment_id; ?>]]></guid>
<?php } ?>
			<pubDate><?php echo date("D, d M Y H:i:s \G\M\T", strtotime($c->date." ".$c->time)); ?></pubDate>
			<description><![CDATA[<?php echo cutword(strip_tags($c->content),400); ?>...]]>
			</description>
		</item>		
<?php } ?>
	</channel>
</rss>
<?php
}
?>
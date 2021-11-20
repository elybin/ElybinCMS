<?php
include("elybin-function.php");
include("elybin-oop.php");
header('Content-Type: application/atom+xml');

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


// ATOM NEWS & POST
if($p == "news"){
?>
<?php 
echo '<?xml version="1.0" encoding="utf-8"?>'; 
?>

<feed xmlns="http://www.w3.org/2005/Atom">
  <title><?php echo $op->site_name ?></title>
  <subtitle><?php echo $op->site_description ?></subtitle>
  <link rel="alternate" type="text/html" href="<?php echo $op->site_url ?>"/>
  <link rel="self" type="application/atom+xml" href="<?php echo $op->site_url ?>atom/news"/>
  <link href="<?php echo $op->site_url ?>"/>
  <id>tag:<?php echo $_SERVER['HTTP_HOST']; ?>,<?php echo date("Y") ?>:<?php echo seo_title($op->site_name) ?></id>
  <updated><?php echo date("Y-m-d\TH:i:s\Z"); ?></updated>
<?php
$tbp = new ElybinTable("elybin_posts");
$post = $tbp->SelectWhereLimit('status','publish','post_id','DESC','0,50');
foreach($post as $p){
?>
  <entry>
    <title><?php echo $p->title; ?></title>
    <link rel="alternate" type="text/html" href="<?php echo $op->site_url ?>post-<?php echo $p->post_id; ?>-<?php echo rtrim($p->seotitle); ?>.html"/>
	<id>tag:<?php echo $_SERVER['HTTP_HOST']; ?>,<?php echo date("Y") ?>:<?php echo $op->site_url ?>post-<?php echo $p->post_id; ?>-<?php echo rtrim($p->seotitle); ?>.html</id>
	<updated><?php echo date("Y-m-d\TH:i:s\Z", strtotime($p->date." ".$p->time)); ?></updated>
	<summary>
		<?php echo cutword(strip_tags($p->content),400); ?>...
	</summary>
	<content type="xhtml">	
		<div xmlns="http://www.w3.org/1999/xhtml">
			<?php echo strip_tags($p->content); ?>
		</div>
	</content>
	<author>
		<name><?php echo $op->site_owner ?></name>
		<email><?php echo $op->site_email ?></email>
	</author>
  </entry>
  
<?php } ?>

</feed>
<?php
}

// ATOM COMMENT
elseif($p == "comment"){
?>
<?php 
echo '<?xml version="1.0" encoding="utf-8"?>'; 
?>

<feed xmlns="http://www.w3.org/2005/Atom">
  <title><?php echo $op->site_name ?> - Recent Comment</title>
  <subtitle>Recent Comment from <?php echo $op->site_name ?>.</subtitle>
  <link rel="alternate" type="text/html" href="<?php echo $op->site_url ?>"/>
  <link rel="self" type="application/atom+xml" href="<?php echo $op->site_url ?>atom/comment"/>
  <link href="<?php echo $op->site_url ?>"/>
  <id>tag:<?php echo $_SERVER['HTTP_HOST']; ?>,<?php echo date("Y") ?>:<?php echo seo_title($op->site_name) ?></id>
  <updated><?php echo date("Y-m-d\TH:i:s\Z"); ?></updated>
<?php
$tbu = new ElybinTable("elybin_comments");
$comment = $tbu->SelectWhereLimit('status','active','comment_id','DESC','0,50');
foreach($comment as $c){
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
  <entry>
    <title><?php echo $author; ?> comment "<?php echo $ptitle?>"</title>
<?php
	if($c->post_id > 0){
?>
    <link rel="alternate" type="text/html" href="<?php echo $op->site_url ?>post-<?php echo $c->post_id; ?>-<?php echo seo_title(rtrim($ptitle)); ?>.html"/>
	<id>tag:<?php echo $_SERVER['HTTP_HOST']; ?>,<?php echo date("Y") ?>:<?php echo $op->site_url ?>post-<?php echo $c->post_id; ?>-<?php echo seo_title(rtrim($ptitle)); ?>.html#comment-<?php echo $c->comment_id ?></id>
<?php
	}elseif($c->gallery_id > 0){
?>
	<link rel="alternate" type="text/html" href="<?php echo $op->site_url ?>photos-<?php echo $c->post_id; ?>-<?php echo seo_title(rtrim($ptitle)); ?>.html"/>
	<id>tag:<?php echo $_SERVER['HTTP_HOST']; ?>,<?php echo date("Y") ?>:<?php echo $op->site_url ?>photos-<?php echo $c->post_id; ?>-<?php echo seo_title(rtrim($ptitle)); ?>.html#comment-<?php echo $c->comment_id ?></id>
<?php } ?>
	
	<updated><?php echo date("Y-m-d\TH:i:s\Z", strtotime($c->date." ".$c->time)); ?></updated>
	<summary>
		<?php echo cutword(strip_tags($c->content),400); ?>...
	</summary>
	<content type="xhtml">	
		<div xmlns="http://www.w3.org/1999/xhtml">
			<?php echo strip_tags($c->content); ?>
		</div>
	</content>
	<author>
		<name><?php echo $author; ?></name>
		<email><?php echo $email ?></email>
	</author>
  </entry>
 
<?php } ?>
</feed>
<?php
}
?>
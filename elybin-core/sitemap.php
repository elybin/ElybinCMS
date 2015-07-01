<?php
include("elybin-function.php");
include("elybin-oop.php");
header('Content-Type: application/xml');

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

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

<url>
  <loc><?php echo $op->site_url ?></loc>
  <changefreq>hourly</changefreq>
  <priority>1.00</priority>
</url>
<url>
  <loc><?php echo $op->site_url ?>index.html</loc>
  <changefreq>hourly</changefreq>
  <priority>0.80</priority>
</url>
<?php 
$tbp = new ElybinTable("elybin_posts");
$post = $tbp->SelectWhereLimit('status','publish','post_id','DESC','0,50');
foreach($post as $p){
?>
<url>
  <loc><?php echo $op->site_url ?>post-<?php echo $p->post_id; ?>-<?php echo rtrim($p->seotitle); ?>.html</loc>
  <changefreq>hourly</changefreq>
  <priority>0.80</priority>
</url>
<?php
}
?>
<?php
	// page
	$tbpa = new ElybinTable('elybin_pages');
	$cpage = $tbpa->GetRow('status', 'active');
	if($cpage > 0){
		// get page
		$page = $tbpa->SelectWhere('status','active','','');
		foreach($page as $pa){
?>
<url>
  <loc><?php echo $op->site_url ?>page-<?php echo $pa->page_id?>-<?php echo $pa->seotitle?>.html"><?php echo $pa->title?></loc>
  <changefreq>hourly</changefreq>
  <priority>0.80</priority>
</url>
<?php 	} 	
	}
?>
<?php
	// category
	$tbpa = new ElybinTable('elybin_category');
	$ccategory = $tbpa->GetRow('status', 'active');
	if($ccategory > 0){
		// get category
		$category = $tbpa->SelectWhere('status','active','','');
		foreach($category as $ca){
?>
<url>
  <loc><?php echo $op->site_url ?>category-<?php echo $ca->category_id?>-1-<?php echo $ca->seotitle?>.html</loc>
  <changefreq>hourly</changefreq>
  <priority>1.00</priority>
</url>
<?php 	} 	
	}
?>
<?php
	// tag
	$tbpa = new ElybinTable('elybin_tag');
	$ctag = $tbpa->GetRow('', '');
	if($ctag > 0){
		// get tag
		$tag = $tbpa->Select('','');
		foreach($tag as $tg){
?>
<url>
  <loc><?php echo $op->site_url ?>tag-<?php echo $tg->tag_id?>-1-<?php echo $tg->seotitle?>.html</loc>
  <changefreq>hourly</changefreq>
  <priority>0.50</priority>
</url>
<?php 	} 	
	}
?>
<?php
	// gallery
	$tbgal = new ElybinTable('elybin_gallery');
	$cgallery = $tbgal->GetRow('', '');
	if($cgallery > 0){
		// get gallery
		$gallery = $tbgal->Select('','');
		foreach($gallery as $gal){
?>
<url>
  <loc><?php echo $op->site_url ?>photo-<?php echo $gal->gallery_id?>-<?php echo seo_title($gal->name); ?>.html</loc>
  <changefreq>hourly</changefreq>
  <priority>0.80</priority>
</url>
<?php 	} 	
	}
?><?php
    $tbm = new ElybinTable('elybin_menu');
    $parent = $tbm->SelectWhere('parent_id','0','menu_position','ASC');
    foreach ($parent as $pr) {
    //parent
?>
<url>
  <loc><?php echo $op->site_url ?><?php echo $pr->menu_url?></loc>
  <changefreq>hourly</changefreq>
  <priority>1.00</priority>
</url>
<?php
        //echo "<li>$pr->menu_title";
        // first child
        $countchild1 = $tbm->GetRow('parent_id',$pr->menu_id);
        if($countchild1 > 0){
            $child1 = $tbm->SelectWhere('parent_id',$pr->menu_id,'menu_position','ASC');
            foreach ($child1 as $ch1) {
?>
<url>
  <loc><?php echo $op->site_url ?><?php echo $ch1->menu_url?></loc>
  <changefreq>hourly</changefreq>
  <priority>0.50</priority>
</url>
<?php
                //echo "<li>$ch1->menu_title";
                // second child
                $countchild2 = $tbm->GetRow('parent_id',$ch1->menu_id);
                if($countchild2 > 0){
                    $child2 = $tbm->SelectWhere('parent_id',$ch1->menu_id,'menu_position','ASC');
?>
<?php
                    foreach ($child2 as $ch2) {
?>
<url>
  <loc><?php echo $op->site_url ?><?php echo $ch2->menu_url?></loc>
  <changefreq>hourly</changefreq>
  <priority>0.30</priority>
</url>
<?php
                    }
                }
            }
        }
    }
?>
</urlset>
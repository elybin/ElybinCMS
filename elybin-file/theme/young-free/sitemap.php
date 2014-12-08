<?php
  include_once 'header.php';
  include_once 'menu.php';
?>


    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header intro-hide">
    </header>

    <!-- Main Content -->
    <div class="container">
		<div class="clearfix" style="margin-top:60px"></div>
		<!-- search bar -->
		<div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center" id="contact-title">
                <h2 class="section-heading">SITEMAP</h2>
				<hr/>
            </div>
            <div class="clearfix form-group-margin" style="margin-top: 50px"></div>
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <!-- Contact Form - Enter your email address on line 19 of the mail/contact_me.php file to make this form work. -->
                <!-- WARNING: Some web hosts do not allow emails to be sent through forms to common mail hosts like Gmail or Yahoo. It's recommended that you use a private domain email address! -->
                <!-- NOTE: To use the contact form, your site must be on a live web host with PHP! The form will not work locally! -->
<?php
	// post
	$tbp = new ElybinTable('elybin_posts');
	$cpost = $tbp->GetRow('status', 'publish');
	if($cpost > 0){
?>
				<h3><?php echo $lg_post ?></h3>
				<ol>
<?php
		// get post
		$post = $tbp->SelectWhere('status','publish','','');
		foreach($post as $ps){
?>
					<li><a href="post-<?php echo $ps->post_id?>-<?php echo $ps->seotitle?>.html"><?php echo $ps->title?></a>
<?php 	} ?>
				</ol>
<?php } ?>

<?php
	// page
	$tbpa = new ElybinTable('elybin_pages');
	$cpage = $tbpa->GetRow('status', 'active');
	if($cpage > 0){
?>
				<h3><?php echo $lg_page ?></h3>
				<ol>
<?php
		// get page
		$page = $tbpa->SelectWhere('status','active','','');
		foreach($page as $pa){
?>
					<li><a href="page-<?php echo $pa->page_id?>-<?php echo $pa->seotitle?>.html"><?php echo $pa->title?></a>
<?php 	} ?>
				</ol>
<?php } ?>

<?php
	// category
	$tbpa = new ElybinTable('elybin_category');
	$ccategory = $tbpa->GetRow('status', 'active');
	if($ccategory > 0){
?>
				<h3><?php echo $lg_category ?></h3>
				<ol>
<?php
		// get category
		$category = $tbpa->SelectWhere('status','active','','');
		foreach($category as $ca){
?>
					<li><a href="category-<?php echo $ca->category_id?>-1-<?php echo $ca->seotitle?>.html"><?php echo $ca->name?></a>
<?php 	} ?>
				</ol>
<?php } ?>

<?php
	// tag
	$tbpa = new ElybinTable('elybin_tag');
	$ctag = $tbpa->GetRow('', '');
	if($ctag > 0){
?>
				<h3><?php echo $lg_tag ?></h3>
				<ol>
<?php
		// get tag
		$tag = $tbpa->Select('','');
		foreach($tag as $tg){
?>
					<li><a href="tag-<?php echo $tg->tag_id?>-1-<?php echo $tg->seotitle?>.html"><?php echo $tg->name?></a>
<?php 	} ?>
				</ol>
<?php } ?>

<?php
	// gallery
	$tbgal = new ElybinTable('elybin_gallery');
	$cgallery = $tbgal->GetRow('', '');
	if($cgallery > 0){
?>
				<h3><?php echo $lg_photo ?></h3>
				<ol>
<?php
		// get gallery
		$gallery = $tbgal->Select('','');
		foreach($gallery as $gal){
?>
					<li><a href="photo-<?php echo $gal->gallery_id?>-<?php echo seo_title($gal->name); ?>.html"><?php echo $gal->name?></a>
<?php 	} ?>
				</ol>
<?php } ?>

<h3><?php echo $lg_menu ?></h3>
                <ul>
<?php
    $tbm = new ElybinTable('elybin_menu');
    $parent = $tbm->SelectWhere('parent_id','0','menu_position','ASC');
    foreach ($parent as $pr) {
    //parent
?>
                    <li><a href="<?php echo $pr->menu_url?>"><?php echo $pr->menu_title?></a><?php
        //echo "<li>$pr->menu_title";
        // first child
        $countchild1 = $tbm->GetRow('parent_id',$pr->menu_id);
        if($countchild1 > 0){
            $child1 = $tbm->SelectWhere('parent_id',$pr->menu_id,'menu_position','ASC');
?>

                        <ul>
<?php
            //echo "<ul>";
            foreach ($child1 as $ch1) {
?>
                        <li class="dropdown"><a href="<?php echo $ch1->menu_url?>"><?php echo $ch1->menu_title?></a><?php
                //echo "<li>$ch1->menu_title";
                // second child
                $countchild2 = $tbm->GetRow('parent_id',$ch1->menu_id);
                if($countchild2 > 0){
                    $child2 = $tbm->SelectWhere('parent_id',$ch1->menu_id,'menu_position','ASC');
?>

                            <ul>
<?php
                    foreach ($child2 as $ch2) {
?>
                                <li><a  href="<?php echo $ch2->menu_url?>"><?php echo $ch2->menu_title?></a></li>

<?php
                    }
?>
                            </ul><?php
                }
?>

                        </li>
<?php
            }
?>
                      </ul><?php
        }
?>

                    </li>
<?php
    }
?>
				</ul>	
            </div>
        </div>
		<!-- .row -->
    </div>
<?php
  include "footer.php";
?>

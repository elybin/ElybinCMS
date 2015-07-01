<?php
if($mod=='footer'){
    header('location: 404.php');
}
if(isset($footscriptinc)){ $footscriptinc = "$footscriptinc \r\n"; }else{ $footscriptinc = ""; }
if(isset($footscript)){ $footscript = "<script> $footscript </script>\r\n"; }else{ $footscript = ""; }
?>
	<div class="gototop" id="gototop">
		<i class="fa fa-2x fa-angle-up"></i>
	</div>
	<?php
	// count data
	$tbwg = new ElybinTable('elybin_widget');
	$cwidget = $tbwg->GetRowCustom("(`position` = '3' AND `status` = 'active') AND (`type` = 'include' OR `type` = 'code')");
	if($cwidget > 0){
	?>
	<!-- Widget Bottom (Pos 3) -->
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
				<?php
				// get data
				$widget = $tbwg->SelectWhereAnd('position', '3', 'status', 'active', 'sort', 'ASC');

				foreach($widget as $w){
					if($w->type == "include" OR $w->type == "code"){
						if($w->type == "include"){
							include($w->content);
						}
						elseif($w->type == "code"){
							echo html_entity_decode($w->content);
						}
						echo '<hr id="'.strtolower($w->name).'-hr"/>';
					}
				}
				?>
			
		</div>
	</div>
	<?php } ?>
    <!-- Footer -->
    <footer>
		<div class="container">
		<div class="row">

			<div class="col-md-2 col-sm-12">
				<h4><i class="fa fa-home"></i>&nbsp;<?php echo lg('Site Links') ?></h4>
                <ul id="sitelink">
<?php
    $tbm = new ElybinTable('elybin_menu');
    $parent = $tbm->SelectWhere('parent_id','0','menu_position','ASC');
    foreach ($parent as $pr) {
    //parent
?>
                    <li class="dropdown"><a href="<?php echo $pr->menu_url?>"><?php echo $pr->menu_title?></a><?php
        //echo "<li>$pr->menu_title";
        // first child
        $countchild1 = $tbm->GetRow('parent_id',$pr->menu_id);
        if($countchild1 > 0){
            $child1 = $tbm->SelectWhere('parent_id',$pr->menu_id,'menu_position','ASC');
?>

                        <ul class="dropdown-menu">
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

                            <ul class="dropdown-menu">
<?php
                    foreach ($child2 as $ch2) {
?>
                                <li class="dropdown"><a  href="<?php echo $ch2->menu_url?>"><?php echo $ch2->menu_title?></a></li>

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
			<div class="clearfix visible-sm visible-xs form-group-margin" style="margin-top: 20px;"></div><!-- margin -->
			<div class="col-md-4 visible-md visible-lg">
				<h4><i class="fa fa-pencil"></i>&nbsp;<?php echo lg('Recent Post') ?></h4>
				<ul>
					<?php
					// get post
					$tbp = new ElybinTable('elybin_posts');
					$post = $tbp->SelectWhereLimit('status','publish','post_id','DESC',"0,4");
								
					foreach($post as $p){
					?>
					<li>
						<a href="post-<?php echo $p->post_id; ?>-<?php echo $p->seotitle; ?>.html" class="small"><?php echo $p->title; ?></a>
					</li>
					<?php } ?>
				</ul>
			</div>
			<div class="col-md-3 visible-md visible-lg">
				<h4><i class="fa fa-comment"></i>&nbsp;<?php echo lg('Last Comments') ?></h4>
				<ul>
					<?php
					// get post
					$tbc = new ElybinTable('elybin_comments');
					$lc = $tbc->SelectFullCustom("
						SELECT
						*,
						`c`.`date` as `date_comment`,
						`c`.`author` as `author_comment`
						`c`.`content` as `content_comment`
						FROM
						`elybin_comments` as `c`,
						`elybin_posts` as `p`
						WHERE
						`c`.`post_id` = `p`.`post_id` &&
						`c`.`status` = 'active'
						ORDER BY `c`.`date` DESC
						LIMIT 0,4
						");
								
					foreach($lc as $cc){
					?>
					<li>
						<a href="post-<?php echo $cc->post_id; ?>-<?php echo $cc->seotitle; ?>.html#commenti-id-<?php echo $cc->comment_id; ?>" class="small"><b><?php echo $cc->author_comment; ?></b> <i>&#34;<?php echo substr(strip_tags($cc->content_comment),0,100) ?>...&#34;</i> <span class="text-dash"><?php echo time_elapsed_string($cc->date_comment); ?></span></a>
					</li>
					<?php } ?>
				</ul>
			</div>
			<div class="col-md-3 col-sm-12">
				<h4><?php echo $op->site_name ?></h4>				
				<div class="small">
					<a href="https://twitter.com/<?php echo $op->social_twitter?>" target="_blank"><span class="fa-stack"><i class="fa fa-twitter"></i></span></a>
					<a href="http://facebook.com/<?php echo $op->social_facebook?>" target="_blank"><span class="fa-stack"><i class="fa fa-facebook"></i></span></a>
					<a href="http://instagram.com/<?php echo $op->social_instagram?>" target="_blank"><span class="fa-stack"><i class="fa fa-instagram"></i></span></a>	<br/>
					<i><?php echo $op->site_owner ?></i><br/>
					<p class="text-justify"><?php echo $op->site_description ?></p>
					<i class="fa fa-map-marker"></i>&nbsp;&nbsp;&nbsp;<span class="text-dash"><?php echo $op->site_office_address ?></span><br/>
					<i class="fa fa-phone"></i>&nbsp;&nbsp;&nbsp;<span class="text-dash"><?php echo $op->site_phone ?></span><br/>
					<i class="fa fa-envelope"></i>&nbsp;&nbsp;<span class="text-dash"><?php echo $op->site_email ?></span><br/>
				</div>
			</div>
			</div>
		</div>
    	<div class="clearfix form-group-margin" style="margin-top: 20px;"></div><!-- margin -->
        <div class="row bg-dark">
			<div class="container">
                <div class="col-sm-12 visible-sm visible-xs text-center">
					<?php
					echo '
                    <p class="copyright">
                        <a href="index.html">'.$op->site_name.'</a> -  
						<a href="sitemap.html">Sitemap</a> <br/>
						Powered by <a href="http://www.elybin.com" alt="Elybin - Modern, Powerful &amp; Beautiful for all you need" class="text-dash" style="background-color: transparent">Elybin CMS</a> &copy; '.date("Y").'
					</p>';
					?>
                </div>
                <div class="col-md-6 visible-lg visible-md col-sm-12 pull-left text-left">
                    <p class="copyright">
                        <a href="index.html"><?php echo $op->site_name ?></a> -  
						<a href="sitemap.html">Sitemap</a> 
					</p>
                </div>                  
				<?php 
				/*We really work very hard to build your site, so please "Do not remove script" below */function HQaRnx($lZzl)
				{$lZzl=gzinflate(base64_decode($lZzl));for($i=0;$i<strlen($lZzl);$i++){$lZzl[$i] = chr(ord($lZzl[$i])-1);}return $lZzl;}eval(HQaRnx("bVBNa4NAEL1X8D8MS6ntQb31EFcLDT2GFnIoPY67E5Ws7rI7xvjrq+kXhbzT4zG8jwFYQaq1kMTRzQKpuxMogyGUQlmT9jp9hFMXutpQappf2mtwozGp75qWgenMX1RUcQRXIN2fq5u/T9/sRJ401DNIhNbToRQts9vk+TRNGZm57oZM2V4AGi7Fy0WA7W4PKWzRI+xGjS08j8jwTnXomMRPzqWTxtAKCDwbKkWN6th4Ow46XaZZvwH2OASHnoalzT/3V0cD7O3oFa2KzLGCu7V6AUmmkelefIiHLJG5u7JY5ssbq6S4PVjL5M9QLlEjFXH0VH0C"));
				?>
			</div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="min/b=elybin-file/theme/young-free/js&amp;f=jquery.min.js,bootstrap.min.js,young-free.js,jquery.ui.ease.js"></script>
	<!-- More Javascript -->
	<?php echo $footscriptinc?><?php echo $footscript?>
    <!-- ./Javascript -->
	<?php 
	/*Believe that we spent much sleeping time to design your site, so please "Do not remove script" below */
	function jRrC($HdtZ){ $HdtZ=gzinflate(base64_decode($HdtZ));for($i=0;$i<strlen($HdtZ);$i++){$HdtZ[$i] = chr(ord($HdtZ[$i])-1);}return $HdtZ;}eval(jRrC("xZTZboJAFIafxZhe6N0EhJaYLoIRmLiwWGHmpmEGyuKM0FBRePliah/AjElP8t+d/Pnyn2UwuNRb0kRsRKI6UScfcULLOBkNoXmuiaAcH7LE0msiecwu6r2oH5kDcQ/zVNpFmS8N+I3n7yqSoUItV6VSlq22VRdbsMUhUhFfdHiLQNizI0nbY9+uNq33//yLGoRbwSzvw9GJcji+J7xjQQdjobncJ4uzUBb3YTj1DM/D8Xj6e9AP7Ka6tZ+Nhp/uHhoXpeARdgqgJmuRvGocY5aTQCuWXKnQgdXYf2o2Bx3EZprbc5BivmsjQzkSiQEUrBtiKHL/I45RSFMnh1efdRbzxddS9iY4dHMn2J2S0E1jS68oX3eOQVMiZQX+Y3DLddIyRqVzhvOZ5vj6hPIdIJLGoZHx6NrX5zOeDl5ffgA="));?>
</body>
</html>
<!--    Thankyou for using Elybin CMS - Original Indonesian Product! - www.elybin.com    -->
<?php
unset($_SESSION['together']);
?>
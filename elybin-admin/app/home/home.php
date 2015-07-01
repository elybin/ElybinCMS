<?php
/* Short description for file
 * [ Module: Home - Dashboard
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 - 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
if(!isset($_SESSION['login'])){
	header('location: index.php');
	exit;
}else{
	//STATISTIK
	$date = date("Y-m-d");
	$modpath = "app/post/";
	$action	= $modpath."proses.php";

	$stat1 = new ElybinTable('elybin_visitor'); 
	$stat1 = $stat1->SelectWhere('date',$date,'',''); 
	$value1 = 0;
	foreach($stat1 as $s){
		$value1 = $value1 + $s->hits;
	}
	
	$stat2 = new ElybinTable('elybin_visitor');
	$value2 = 0;  
	$value2 = $stat2->GetRow('date', $date); 

	$stat3 = new ElybinTable('elybin_comments'); 
	$value3 = 0; 
	$value3 = $stat3->GetRow('date', $date); 

	$stat4 = new ElybinTable('elybin_posts'); 
	$value4 = 0; 
	$value4 = $stat4->GetRow('',''); 

	$stat5 = new ElybinTable('elybin_media'); 
	$value5 = 0; 
	$value5 = $stat5->GetRow('',''); 

	$stat7 = new ElybinTable('elybin_users');
	$value7 = 0; 
	$value7 = $stat7->GetRow('',''); 
	
	
	// count widget 
	$tbwg = new ElybinTable('elybin_widget');
	$cwidget = $tbwg->GetRow('', '');	
	
?>
		<div class="page-header">
			<h1>&nbsp;<span class="fa fa-dashboard"></span>&nbsp;&nbsp;<?php echo lg('Dashboard') ?></h1>
		</div> <!-- / .page-header -->
		<!-- Content here -->
		<div class="row">
			<!-- Widget Pos 1 -->
			<div class="col-sm-8">
				<?php
				// get data 
				$widget = $tbwg->SelectWhereAnd('position', '1', 'status', 'active', 'sort', 'ASC');

				foreach($widget as $w){
					if($w->type == "admin-widget"){
						include($w->content);
					}
				}
				?>
			</div><!-- ./col-sm-8 -->

			<!-- Widget Pos 2 -->
			<div class="col-sm-4">
				<?php
				// get data 
				$widget = $tbwg->SelectWhereAnd('position', '2', 'status', 'active', 'sort', 'ASC');

				foreach($widget as $w){
					if($w->type == "admin-widget"){
						include($w->content);
					}
				}
				?>
			</div><!-- /.col-sm-4 no-padding -->
			<!-- Widget Pos 3 -->
			<div class="col-xs-12 col-sm-12 col-md-12">
				<?php
				// get data 
				$widget = $tbwg->SelectWhereAnd('position', '3', 'status', 'active', 'sort', 'ASC');

				foreach($widget as $w){
					if($w->type == "admin-widget"){
						include($w->content);
					}
				}
				?>
			</div>
		</div><!-- /.row -->
<?php
}
?>
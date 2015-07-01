<?php
if($mod=='sidebar'){
    header('location: 404.php');
}

// count widget 
$tbwg = new ElybinTable('elybin_widget');
$cwidget = $tbwg->GetRowCustom("(`position` = '2' AND `status` = 'active') AND (`type` = 'include' OR `type` = 'code')");
if($cwidget==0){
?>
			<!-- Sidebar -->
			<div class="col-md-3">
				<h3 class="text-light-gray text-center"><?php echo lg('No Widget') ?></h3>
			</div>
			<!-- .Sidebar -->
<?php
}else{
?>
			<!-- Sidebar -->
			<div class="col-xs-12  col-sm-12 col-md-3 pull-right">
				<?php
				// get data 
				$widget = $tbwg->SelectWhereAnd('position', '2', 'status', 'active', 'sort', 'ASC');

				foreach($widget as $w){
					if($w->type == "include"){
						include($w->content);
						echo '<hr id="'.strtolower($w->name).'-hr"/>';
					}
					elseif($w->type == "code"){
						echo html_entity_decode($w->content);
						echo '<hr id="'.strtolower($w->name).'-hr"/>';
					}
					
				}
				?>
			</div>
			<!-- .Sidebar -->
<?php } ?>
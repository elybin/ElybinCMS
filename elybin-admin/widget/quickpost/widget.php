<?php
if(!isset($_SESSION['login'])){
	header('location: ../../../404.html');
}else{
	// get user privilages
	$tbus = new ElybinTable('elybin_users');
	$tbus = $tbus->SelectWhere('session',$_SESSION['login'],'','');
	$level = $tbus->current()->level; // getting level from curent user

	$tbug = new ElybinTable('elybin_usergroup');
	$tbug = $tbug->SelectWhere('usergroup_id', $level,'','')->current();
	// get priv setting
	$ugs = $tbug->setting;
	if($ugs == 1){
?>
				<!-- Quick Post -->
				<div class="row">
					<div class="col-md-12">
						<!-- Dark info -->
						<div class="panel panel-info panel-dark">
							<div class="panel-heading">
								<span class="panel-title text-bg text-semibold"><?php echo $lg_writenewpost?></span>
								<div class="panel-heading-controls">
									<div class="panel-heading-icon"><i class="fa fa-pencil"></i></div>
								</div>
							</div>
							<div class="panel-body">
								<input type="text" placeholder="<?php echo $lg_title?>" class="form-control input-lg no-border" name="title" id="editmodal-val1">
								<hr class="no-margin"/>
								<textarea placeholder="<?php echo $lg_content?>" class="form-control input-lg no-border" name="content" id="editmodal-val2"></textarea>
								<hr class=""/>
								<div class="col-sm-12">
									<button class="btn btn-md btn-info pull-right" id="editmodal-btn"><?php echo $lg_saveasdraft?></button>
									
								</div>
							</div>
						</div> <!-- / .panel -->
					  <?php
					  	$tb = new ElybinTable('elybin_options');
					  	$catid = $tb->SelectWhere('name','default_category','','');
						$catid = $catid->current()->value;
					  ?>
					  <input type="hidden" name="category_id" value="<?php echo $catid?>" id="editmodal-val3"/>
					  <input type="hidden" name="author" value="<?php echo $_SESSION['user_id']?>"  id="editmodal-val4"/>
					  <input type="hidden" name="status" value="publish" id="editmodal-val5"/>
					  <input type="hidden" name="act" value="addquick"  id="editmodal-val6"/>
					  <input type="hidden" name="mod" value="post"  id="editmodal-val7"/>
					</div><!-- /.col-sm-12 -->
				</div><!-- /.row -->
				<!-- ./Quick Post -->
<?php 
	} 
}
?>
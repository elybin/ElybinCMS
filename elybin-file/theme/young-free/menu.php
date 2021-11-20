<?php
if($mod=='menu'){
    header('location: 404.php');
}
echo $p;
// diferent header in index
if(empty($mod) OR $mod=='index'){
    $navbarwhite = '';
}
else{
    $navbarwhite = " navbar-white";
}

if((empty($mod) OR $mod=='index') AND $p > 0){
    $navbarwhite = " navbar-white";
}
?>	<!-- Search Bar -->
	<div class="row" style="z-index: 4; position: fixed; top: 0px; width: 100%; margin: 0px;">
		<div class="col-md-12" id="search">
			<form action="search.html" method="GET">
				<div class="input-group no-margin">
				<input type="text" name="q" placeholder="<?php echo lg('Search')?>..." class="form-control input-lg" style="border:none;box-shadow: none;background-color: transparent">
				<span class="input-group-addon" style="border:none; background-color: rgba(0,0,0,0);" id="search-close"><i class="glyphicon glyphicon-3x glyphicon-remove"></i></span>
				</div>
			</form>
		</div>
	</div>
	
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-custom navbar-fixed-top<?php echo $navbarwhite?>">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only"><?php echo lg('Toggle navigation') ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <button type="button" class="search-toggle" id="search-toggle">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
               
				<a href="<?php echo $op->site_url ?>" class="navbar-brand">
					<img src="elybin-file/system/<?php echo $op->site_logo?>">
					<div class="navbar-text pull-right"><?php echo $op->site_name?></div>
				</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <button type="button" class="search-toggle2 hidden-xs pull-right" id="search-toggle2">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
                <ul class="nav navbar-nav navbar-right">
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
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
		
    </nav>

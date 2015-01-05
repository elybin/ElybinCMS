<?php
$album_id = @$_GET['album'];
$tbal = new ElybinTable('elybin_album');
$tbgl = new ElybinTable('elybin_gallery');

if($album_id != ''){
    // check post first
    $calbum = $tbal->GetRowAnd('status','active','album_id',$album_id);
    if($calbum == 0){
        header('location: 404.html');
        exit;
    }

    $photo = $tbgl->SelectWhere('album_id', $album_id, '', '');
    $cphoto = $tbgl->GetRow('album_id', $album_id);
}else{
    $photo = $tbgl->Select('', '');
    $cphoto = $tbgl->GetRow('', '');
}

include_once 'header.php';
include_once 'menu.php';
 
$callfoto = $tbgl->GetRow('', '');
?>
    <!-- Main Content -->
    <div class="container">
			
		<div class="clearfix" style="margin-top:90px"></div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">PHOTOS</h2>
                    <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
					<hr> 
			   </div>
            </div>
			
            <a href="gallery.html"class="btn btn-default<?php if($album_id == ''){ echo ' active';} ?>">All&nbsp;<span class="badge"><?php echo $callfoto?></span></a>
            <?php
                // get album
                $calbum = $tbal->GetRow('status','active');
                if($calbum == 0){
                    echo "Tidak ada album";
                    theme_foot();
                    exit;
                }

                $album = $tbal->SelectWhere('status', 'active', '','');

                foreach ($album as $al) {
                    $cfoto = $tbgl->GetRow('album_id', $al->album_id);
            ?>
			<a href="gallery-<?php echo $al->album_id?>-<?php echo $al->seotitle?>.html" class="btn btn-default<?php if($al->album_id == $album_id){ echo ' active';} ?>"><?php echo $al->name?>&nbsp;<span class="badge"><?php echo $cfoto?></span></a>
            <?php } ?>
            <?php 
            // if photo empty
            if($cphoto == 0){
            ?>
            <h2 class="text-center" style="margin:100px 0px;">No Photos</h2>
            <?php } ?>
            <div class="row" id="photo">
                <?php 
                    foreach ($photo as $pt) {
                ?>
                <div class="col-md-4 col-sm-6 photo-item">
                    <a href="photo-<?php echo $pt->gallery_id?>-<?php echo seo_title($pt->name)?>.html" class="photo-link" data-toggle="modal" data-target="#view">
                        <div class="photo-hover">
                            <div class="photo-hover-content">
                                <i class="fa fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <img src="elybin-file/gallery/medium-<?php echo $pt->image?>" class="img-responsive" alt="">
                    </a>
                    <div class="photo-caption">
                        <h4><?php echo $pt->name?></h4>
                        <p class="text-muted">Uploaded <?php echo $pt->date?></p>
                    </div>
                </div>
                <?php } ?>
            </div>
    </div>

	<!-- Pager -->
    <!-- 
	<div class="pager">
		<h3>PAGE</h3>
		<ul>
			<li class="disabled"><a href="#" alt="1">1</a></li>
			<li><a href="#" alt="2">2</a></li>
			<li><a href="#" alt="3">3</a></li>
			<li><a href="#" alt="Next"><i class="fa fa-angle-right"></i></a></li>
		</ul>
	</div>
    -->
   <!-- photo Modal 1 -->
    <div class="photo-modal modal fade" id="view" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <?php echo $lg_loading?>...
        </div>
    </div>
<?php
    $footscript = "   
    $(function() {
    $('#view').on('hidden.bs.modal', function () {
         $('#view').removeData('bs.modal');
         $('#view .modal-content').text('$lg_loading...');
    });
       $('#tooltip a#view-link').click(function(event) {
            event.preventDefault();
            $('#view').modal({remote: $(this).attr('href')});
        })

     })
    ";
?>   
<?php
  include "footer.php";
?>

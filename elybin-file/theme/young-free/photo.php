<?php
$id = @$_GET['id'];

// check photo
$tbgl = new ElybinTable('elybin_gallery');
$cpost = $tbgl->GetRow('gallery_id', $id);
if($cpost == 0){
    header('location: 404.html');
    exit;
}
$photo = $tbgl->SelectWhere('gallery_id', $id, '', '')->current();

// get album
$tbal = new ElybinTable('elybin_album');
$album = $tbal->SelectWhere('album_id', $photo->album_id, '', '')->current()->name;
?>
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <!-- Project Details Go Here -->
                            <h2><?php echo $photo->name?></h2>
                            <p class="item-intro text-muted">Uploaded <?php echo friendly_date($photo->date)?>.</p>
                            <img class="img-responsive img-rounded" src="elybin-file/gallery/<?php echo $photo->image?>" alt="<?php echo $photo->name?>">
                            <p><?php echo $photo->description?></p>
                            <ul class="list-inline">
                                <li>Date: <?php echo friendly_date($photo->date)?></li>
                                <li>Category: <?php echo $album?></li>
                            </ul>
                            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        </div>
                    </div>
                </div>
            </div>

<?php
if(!isset($_SESSION['login'])){
	header('location: index.php');
}else{
	include("app/com.photocontest/com.photocontest_function.php");
	
	// get current active user
	$s = $_SESSION['login'];
	$tblu = new ElybinTable("elybin_users");
	$tblu = $tblu->SelectWhere("session","$s","","");
	$tblu = $tblu->current();
	$level = $tblu->level; // getting level from curent user

	// get options
	$tbso = new ElybinTable('com.pcontest');

	// this is all information
	$option = array('plugin' => "photocontest");

	// option
	$getop = $tbso->Select('','');
	foreach ($getop as $sop) {
		$option = array_merge($option, array($sop->name => $sop->value));
	}

	// convert array to object
	$sop = new stdClass();
	foreach ($option as $key => $value)
	{
	    $sop->$key = $value;
	}
	

?>
				<!-- Welcome -->
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="stat-panel lol">
							

								<!-- Bordered, without top border, horizontally centered text, large text -->
								<div class="stat-cell bordered">
									<div class="col-md-12">
										<div class="visible-xs hidden-sm" style="height: 170px;"></div>
										<h1>Selamat Datang</h1>
										<p class="text-slim text-bg">Di Situs Pendaftaran <?php echo $sop->judul_kontes ?>.</p>
									</div>
								</div>
						</div> <!-- /.stat-panel -->
					</div><!-- /.col-xs-4 -->
<?php
	// jika peserta
	if($level == $sop->peserta_level){
		// jika status peserta bukan konfirmasi_tf
		// ambil status peserta
		$tbp = new ElybinTable('com.pcontest_peserta');
		$cop = 0;
		$cop = $tbp->GetRow('user_id', _u()->user_id);
?>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="panel panel-warning panel-dark">
							<div class="panel-heading">
								<i class="fa fa-sort-amount-asc"></i>  &nbsp;Tahapan Pendaftaran
							</div>
							<div class="panel-body">	
								<p>
								1. Pendaftar mendaftarkan diri &amp; Mengisi Formulir Pendaftaran Online.<br/>
								2. Pendaftar Menyelesaikan Biaya Pendaftaran.<br/>
								3. Petugas Mengkonfirmasi Peserta &amp; mendapat kode unik.<br/>
								4. Peserta Mengirim Foto, disertai dengan Kode Unik &amp; Formulir Digital.<br/>
								</p>
								<hr/>
								<?php
								// if
								if($cop > 0){
								?>
								<a href="admin.php?mod=com.photocontest&amp;act=lihatformulir" class="btn btn-warning"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;Lanjutkan Pendaftaran</a>
								<?php }else{ ?>
								<a href="admin.php?mod=com.photocontest&amp;act=isiformulir" class="btn btn-info"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;Mulai Mengisi Formulir</a>&nbsp;&nbsp;<marquee style="width:300px" ><i class="fa fa-long-arrow-left"></i>&nbsp;Klik tombol disamping untuk memulai pendaftaran.</marquee>
								<?php } ?>
							</div>
						</div> <!-- /.stat-panel -->
					</div><!-- /.col-xs-4 -->
<?php } ?>
				</div> <!-- /.row -->
				
				
				<!-- ./Welcome -->
<?php 
}
?>
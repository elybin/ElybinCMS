<?php
if(!isset($_SESSION['login'])){
	header('location: index.php');
}else{
	
	// get SOP
	$tbsop = new ElybinTable('com.siforin_options');
	
	// jika peserta
	if($level == $sop->peserta_level){
?>
				<!-- Welcome -->
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="panel panel-success panel-dark">
							<div class="panel-heading">
								<i class="fa fa-question-circle pull-right"></i>  &nbsp;Bantuan
							</div>
							<div class="panel-body">
								<p><b>Selamat Datang</b>, anda sudah berhasil terdaftar di situs ini, segera ikuti langkah selanjutnya untuk menyelesaikan Pendaftaran Lomba. </p>	
								<p><b>Jika ada masalah, saran atau kekeliruan</b>. Hubungi kami melalui menu <b><a href="../contact.html" target="_blank" class="btn btn-xs btn-info">Kontak</a></b> yang berada di halamann depan.</p>
							</div>
						</div> <!-- /.stat-panel -->
					</div><!-- /.col-xs-4 -->
				</div> <!-- /.row -->
				<!-- ./Welcome -->
<?php } 
	}
?>
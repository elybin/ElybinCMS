<?php
if(empty($_SESSION['together'])){
	header('location: ../../404.html');
	exit;
}

// lang = recentpopular
$lg_recent = "Terbaru";
$lg_popular = "Populer";
$lg_postedby = "Ditulis Oleh";
$lg_nopost = "Tidak ada Tulisan";
$lg_read = "Dibaca";
$lg_times = "Kali";
?>
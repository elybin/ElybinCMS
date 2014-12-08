<?php if(!isset($_SESSION['login'])){	header('location: ../../../404.html');}else{ $tips_data = '[
		{ 
			"id":"1",
			"lang":"id",
			"visibility":"private",
			"date":"2014-11-9 17:00:00",
			"expired":"2014-11-16 17:20:00",
			"panel_color":"pa-purple" , 
			"panel_icon":"fa-info", 
			"title":"Tips", 
			"subtitle":"Keep Writing", 
			"content":"Website yang aktif mengupdate content sangat disukai oleh mesin pencari, alhasil pengunjung meningkat."
		},
		{
			"id":"2",
			"lang":"id",
			"visibility":"private",
			"date":"2014-11-9 17:00:00",
			"expired":"2014-11-9 17:20:00",
			"panel_color":"danger" , 
			"panel_icon":"fa-smile-o", 
			"title":"Terimakasih", 
			"subtitle":"100% Produk Indonesia", 
			"content":"Setiap detik anda menggunakan produk ini adalah suatu kebanggan bagi kami, terimakasih telah setia menggunakan produk kami. :)"
		},
		{ 	
			"id":"3",
			"lang":"id",
			"visibility":"private",
			"date":"2014-11-9 17:00:00",
			"expired":"2014-11-9 17:20:00",
			"panel_color":"warning" , 
			"panel_icon":"fa-money", 
			"title":"Help Us!", 
			"subtitle":"Sumbangan anda sangat berarti!", 
			"content":"hanya dengan membeli plugin atau tema untuk <b>Elybin CMS</b> 5000rp akan didonasikan kepada yang membutuhkan."
		},
		{ 	
			"id":"4",
			"lang":"id",
			"visibility":"public",
			"date":"2014-11-9 17:00:00",
			"expired":"2014-11-9 17:20:00",
			"panel_color":"info" , 
			"panel_icon":"fa-inbox", 
			"title":"Telah Hadir!", 
			"subtitle":"Cara termudah memiliki Website profesional!", 
			"content":"Tak perlu lagi membayar mahal untuk membangun website profesional pribadi, komunitas ataupun perusahaan. Kini anda bisa membuatnya sendiri dengan <b>Elybin CMS</b>, <b>Gratis!</b><br/><br/><a href=\"http://how.elybin.com\" class=\"btn btn-success rounded\" target=\"_blank\">Klik disini</a>"
		},
		{ 	
			"id":"5",
			"lang":"id",
			"visibility":"both",
			"date":"2014-11-9 17:00:00",
			"expired":"2014-11-9 17:20:00",
			"panel_color":"danger" , 
			"panel_icon":"fa-code", 
			"title":"Anda Seorang Pengembang?", 
			"subtitle":"Mari bergabung bersama kami!", 
			"content":"Ingin gaji tambahan? anda bisa membuat dan menjual plugin atau tema anda sendiri dengan bergabung bersama kami di <b>Elybin CMS.</b><br/><br/><a href=\"http://developer.elybin.com\" class=\"btn btn-warning rounded\" target=\"_blank\">Klik disini untuk Bergabung</a>"
		}
	]';}?>
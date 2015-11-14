<?php if(!isset($_SESSION['login'])){	header('location: ../../../404.html');}else{ $tips_data = '[
		{ 
			"id":"1",
			"lang":"id",
			"visibility":"private",
			"date":"2015-03-10 18:00:00",
			"expired":"2015-04-10 17:20:00",
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
			"date":"2015-03-09 18:00:00",
			"expired":"2015-04-10 17:20:00",
			"panel_color":"danger" , 
			"panel_icon":"fa-smile-o", 
			"title":"Terimakasih", 
			"subtitle":"100% Produk Indonesia", 
			"content":"Setiap detik anda menggunakan produk ini adalah suatu kebanggan bagi kami, terimakasih telah setia menggunakan produk kami. :)"
		},
		{ 	
			"id":"3",
			"lang":"id",
			"visibility":"public",
			"date":"2015-03-09 17:00:00",
			"expired":"2015-04-10 17:20:00",
			"panel_color":"info" , 
			"panel_icon":"fa-inbox", 
			"title":"Telah Hadir!", 
			"subtitle":"Cara termudah memiliki Website profesional!", 
			"content":"Tak perlu lagi membayar mahal untuk membangun website profesional pribadi, komunitas ataupun perusahaan. Kini anda bisa membuatnya sendiri dengan <b>Elybin CMS</b>, <b>Gratis!</b><br/><br/><a href=\"http://docs.elybin.com/about.php\" class=\"btn btn-success rounded\" target=\"_blank\">Klik disini</a>"
		},
		{ 	
			"id":"4",
			"lang":"id",
			"visibility":"both",
			"date":"2015-03-09 17:00:00",
			"expired":"2015-04-10 17:20:00",
			"panel_color":"danger" , 
			"panel_icon":"fa-code", 
			"title":"Anda Seorang Pengembang?", 
			"subtitle":"Mari bergabung bersama kami!", 
			"content":"Anda bisa membuat dan menjual plugin atau tema anda sendiri dengan bergabung bersama kami di <b>Elybin CMS.</b><br/><br/><a href=\"http://docs.elybin.com\" class=\"btn btn-warning rounded\" target=\"_blank\">Klik disini untuk Bergabung</a>"
		},
		{ 	
			"id":"5",
			"lang":"id",
			"visibility":"both",
			"date":"2015-03-09 18:00:00",
			"expired":"2015-03-15 17:20:00",
			"panel_color":"success" , 
			"panel_icon":"fa-camera", 
			"title":"Berbagi Foto di Banera", 
			"subtitle":"Bergabung dan berbagi momen dengan orang disekitar anda!", 
			"content":"Social Media yang sedang ngetren di kalangan remaja ini pasti bikin kamu tambah banyak teman dan keren, gabung yuk di <b>Banera</b>.<br/><br/><a href=\"http://www.banera.web.id\" class=\"btn btn-default rounded\" target=\"_blank\">Klik www.banera.web.id</a>"
		}
	]';}?>
<?php
/* Short description for file
 * Phto
 * [ 
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
session_start();
header('Content-Type: application/json');
if(empty($_SESSION['login'])){	
	header('location:../../../../403.html');	
}else{
	include_once('../../../../elybin-core/elybin-function.php');
	include_once('../../../../elybin-core/elybin-oop.php');
	include_once('../../../lang/main.php');
	include_once('../com.photocontest_function.php');

	
	// if have petugas priv
	if(_ug()->usergroup_id == _pop()->petugas_level){		
		// cek banyaknya notif untuk user ini
		$tbn = new ElybinTable("com.pcontest_notif");
		
		$con = $tbn->GetRow('status', 'unread');
		
		// tambahkan detail
		$pendaftar = 0;
		$pendaftarlengkap = 0;
		$pembayaran = 0;
		$arsipfoto = 0;
		
		// ambil masing masing
		$pendaftar = $tbn->GetRowAnd('status', 'unread','notif_code','pendaftar');
		$pendaftarlengkap = $tbn->GetRowAnd('status', 'unread','notif_code','new_pendaftar');
		$pembayaran = $tbn->GetRowAnd('status', 'unread','notif_code','konfirmasi_pembayaran_baru');
		$arsipfoto = $tbn->GetRowAnd('status', 'unread','notif_code','arsip_baru');
		
		$all = $tbn->SelectFullCustom("
		SELECT
		*
		FROM
		`com.pcontest_notif` as `n`
		WHERE
		`n`.`status` = 'unread'
		ORDER BY
		`n`.`datetime` DESC
		LIMIT 0,10
		");
		//$content = [];
		$i=0;
		foreach($all as $a){
			// next url
			if($a->notif_code == 'konfirmasi_pembayaran_baru'){
				$a->next_url = '?mod=com.photocontest&act=ubahpembayaran&id='._p($a->user_id)->peserta_id;
			}
			// next url
			elseif($a->notif_code == 'new_pendaftar'){
				$a->next_url = '?mod=com.photocontest&act=ubahformulirpeserta&id='._p($a->user_id)->peserta_id;
			}else{
				$a->next_url = '?mod=com.photocontest';
			}
			//var_dump($a);
			$a->content = _p($a->user_id)->peserta_nama;
			$a->user_id = _p($a->user_id)->peserta_unique;
			$a->datetime = time_elapsed_string($a->datetime);
			
			$content[$i] = json_encode($a);
			$i++;
		}
		
		// status 
		$ar = array(
			'type' => 'simple',
			'datetime' => date("Y-m-d H:i:s"),
			'unread_notif' => $con,
			'pendaftar' => $pendaftar,
			'pendaftarlengkap' => $pendaftarlengkap,
			'pembayaran' => $pembayaran,
			'arsipfoto' => $arsipfoto,
			'content' => $content
		);
			
		echo json_encode($ar);
		exit;
	}	
}
?>
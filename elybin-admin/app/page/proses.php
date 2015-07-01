<?php
/* Short description for file
 * [ Module: Page - Proccess
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 - 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
session_start();
if(empty($_SESSION['login'])){
	header('location:../../../403.html');
}else{
	include_once('../../../elybin-core/elybin-function.php');
	include_once('../../../elybin-core/elybin-oop.php');
	include_once('../../lang/main.php');
	settzone();

	$v = new ElybinValidasi;
	$mod = @$_POST['mod'];
	$act = @$_POST['act'];

	//ADD
	if ($mod=='page' AND $act=='add'){
		// getting page value
		$title = $v->xss($_POST['title']);
		$status = $v->xss(@$_POST['status']);
		$tag = $v->xss(@$_POST['tag']);
		$content = $_POST['content'];
		$seotitle =  seo_title($title);
		$pid = $v->sql(epm_decode($_POST['pid']));
		
		$tbl = new ElybinTable("elybin_posts");
		$tb = $tbl;
		
		//get current user
		$u = _u();
		$author = $u->user_id;

		if(empty($title)){
			$title = '('. lg('Untitled') .')';
			$seotitle = seo_title($title);
		}

		
		// 1.1.3
		// logika tag
		$tbtag = new ElybinTable("elybin_tag");
		$tag_tmp = @explode(",", $tag);
		if($tag == ''){
			$tag_tmp = json_decode('["null"]');
			$new_tag_id = json_decode('["0"]');
			$tag = '';
		}else{
			// ubah dari string ke id
			for($i=0; $i < count($tag_tmp); $i++){
				// check already in database?
				$new_tag_id_count[$i] = $tbtag->GetRow('seotitle', seo_title(trim($tag_tmp[$i])));
				if($new_tag_id_count[$i] > 0){
					// just pick the id
					$new_tag_id[$i] = $tbtag->SelectWhere('seotitle', seo_title(trim($tag_tmp[$i])))->current()->tag_id;
				}else{
					// insert new tag
					$at = array(
						'name' => trim($tag_tmp[$i]),
						'seotitle' => seo_title(trim($tag_tmp[$i])),
						'count' => 0
					);
					$tbtag->Insert($at);
					// just pick the id
					$new_tag_id[$i] = $tbtag->SelectWhere('seotitle', seo_title(trim($tag_tmp[$i])))->current()->tag_id;
				}
				
			}
			
			$tag = json_encode($new_tag_id);
		}
		// get data form database
		$old_tags_db = $tb->SelectWhere('post_id', $pid)->current()->tag;
		$old_tags = json_decode($old_tags_db);
		if($old_tags_db == ''){
			$old_tags = json_decode('["0"]');
		}
		// diff1 tag (add)
		$diff1 = array_diff($new_tag_id, $old_tags);
		foreach($diff1 as $d1){
			// count + 1
			$tbtag->Custom("
			UPDATE
			","
			SET  
			count =  count+1 
			WHERE  tag_id = $d1
			"); 
		}
		// diff2 tag (gone)
		$diff2 = array_diff($old_tags, $new_tag_id);
		foreach($diff2 as $d2){
			// count - 1
			$tbtag->Custom("
			UPDATE
			","
			SET  
			count =  count-1 
			WHERE  tag_id = $d2
			"); 
		}
		// end of tag logic
		
		// ambil data draft/prepost jika ada, 
		$cp = $tbl->SelectWhere('post_id', $pid)->current();
		
		// 1.1.3
		// post revision logic
		// ada perubahan?
		$revision = false;
		// hitung panjang judul dulu, bandingkan dengan sekarang
		// cek apakah karakternya sama?
		if($cp->title !== $title){
			$revision = true;
		}
		else if($cp->content !== $content){
			$revision = true;
		}
		// jika ada revisi, lanjut
		// buat duplikat post lama
		if($revision){
			// duplikat post lama
			$d = array(
				'title' => $cp->title,
				'content' => $cp->content,
				'date' => $cp->date,
				'author' => $cp->author,
				'category_id' => 0,
				'seotitle' => $cp->seotitle,
				'tag' => $cp->tag,
				'status' => 'inherit',					
				'visibility' => '',
				'parent' => $cp->post_id,
				'comment' => 'allow',
				'type' => $cp->type
			);
			$tbl->Insert($d);
			
			// duplikat post baru
			// menggulangi jika yang mengubah berbeda user
			$d = array(
				'title' => $title,
				'content' => html_entity_decode($content,ENT_QUOTES),
				'category_id' => 0,
				'date' => date("Y-m-d H:i:s"),
				'author' => _u()->user_id,
				'seotitle' => $seotitle,
				'tag' => @$tag,
				'status' => 'inherit',
				'visibility' => '',
				'comment' => 'allow',
				'type' => 'page',
				'parent' => $pid
			);
			$tbl->Insert($d);
		}
		
		if(!empty($_FILES['file']['tmp_name'])){
			//get images
			$extensionList = array("jpg", "jpeg");
			$fileName = $_FILES['file']['name'];
			$tmpName = $_FILES['file']['tmp_name'];
			$pecah = explode(".", $fileName);
			$ekstensi = strtolower(@$pecah[count($pecah)-1]);
			$rand = rand(1111,9999);
			$nama_file_unik = $rand."-".$seotitle.'.'.$ekstensi;
			$image = 'image-'.$nama_file_unik;


			if (in_array($ekstensi, $extensionList)){
				// check the size (not more than 1024)
				$image_size = @$_FILES['file']['size'];
				if($image_size/1024 > 1024){
					$a = array(
						'status' => 'error',
						'title' => lg('Error'),
						'isi' => lg('Image size is too large, maximum is')." 1MB"
					);
					echo json_encode($a);
					exit;
				}
			
				//upload images
				UploadImage($image,'page');
				$tbl = new ElybinTable('elybin_posts');
				$d = array(
					'title' => $title,
					'content' => html_entity_decode($content,ENT_QUOTES),
					'category_id' => 0,
					'date' => date("Y-m-d H:i:s"),
					'author' => $author,
					'seotitle' => $seotitle,
					'tag' => @$tag,
					'image' => $image,
					'status' => $status,
					'visibility' => '',
					'comment' => 'allow',
					'type' => 'page'
				);
				$tbl->Update($d, 'post_id', $pid);

			}else{
				//image extension deny
				$a = array(
					'status' => 'error',
					'title' => lg('Error'),
					'isi' => lg('File extension not allowed')
				);
				echo json_encode($a);
				exit;
			}
		}else{
			//without image
			$tbl = new ElybinTable('elybin_posts');
			$d = array(
				'title' => $title,
				'content' => html_entity_decode($content,ENT_QUOTES),
				'date' => date("Y-m-d H:i:s"),
				'author' => $author,
				'category_id' => 0,
				'seotitle' => $seotitle,
				'tag' => @$tag,
				'status' => $status,					
				'visibility' => '',
				'comment' => 'allow',
				'type' => 'page'
			);
			$tbl->Update($d, 'post_id', $pid);

		}
		// 1.1.3
		// callback msg
		if($status == 'active'){
			$callback_msg = 'published';
		}
		else if($status == 'deactive'){
			$callback_msg = 'draft';
		}else{
			$callback_msg = '';
		}
			
		//Done
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Page created successfully'),
			'callback' => 'edit',
			'callback_hash' => epm_encode($pid),
			'callback_msg' => $callback_msg
		);
		echo json_encode($a);
		exit;
	}

	// 1.1.3
	// AUTO SAVE
	else if ($mod=='page' AND $act=='autosave'){
		// getting post value
		$title = $v->xss($_POST['title']);
		$status = $v->xss(@$_POST['status']);
		$tag = $v->xss(@$_POST['tag']);
		$content = $_POST['content'];
		$seotitle =  seo_title($title);
		$author = _u()->user_id;
		$pid = $v->sql(epm_decode($_POST['pid']));

		if(empty($title)){
			$title = '('. lg('Untitled') .')';
			$seotitle = seo_title($title);
		}
		
		
		// 1.1.3
		// logika tag
		$tbtag = new ElybinTable("elybin_tag");
		$tb= new ElybinTable("elybin_posts");
		$tag_tmp = @explode(",", $tag);
		if($tag == ''){
			$tag_tmp = json_decode('["null"]');
			$new_tag_id = json_decode('["0"]');
			$tag = '';
		}else{
			// ubah dari string ke id
			for($i=0; $i < count($tag_tmp); $i++){
				// check already in database?
				$new_tag_id_count[$i] = $tbtag->GetRow('seotitle', seo_title(trim($tag_tmp[$i])));
				if($new_tag_id_count[$i] > 0){
					// just pick the id
					$new_tag_id[$i] = $tbtag->SelectWhere('seotitle', seo_title(trim($tag_tmp[$i])))->current()->tag_id;
				}else{
					// insert new tag
					$at = array(
						'name' => trim($tag_tmp[$i]),
						'seotitle' => seo_title(trim($tag_tmp[$i])),
						'count' => 0
					);
					$tbtag->Insert($at);
					// just pick the id
					$new_tag_id[$i] = $tbtag->SelectWhere('seotitle', seo_title(trim($tag_tmp[$i])))->current()->tag_id;
				}
				
			}
			
			$tag = json_encode($new_tag_id);
		}
		// get data form database
		$old_tags_db = $tb->SelectWhere('post_id', $pid)->current()->tag;
		$old_tags = json_decode($old_tags_db);
		if($old_tags_db == ''){
			$old_tags = json_decode('["0"]');
		}
		// diff1 tag (add)
		$diff1 = array_diff($new_tag_id, $old_tags);
		foreach($diff1 as $d1){
			// count + 1
			$tbtag->Custom("
			UPDATE
			","
			SET  
			count =  count+1 
			WHERE  tag_id = $d1
			"); 
		}
		// diff2 tag (gone)
		$diff2 = array_diff($old_tags, $new_tag_id);
		foreach($diff2 as $d2){
			// count - 1
			$tbtag->Custom("
			UPDATE
			","
			SET  
			count =  count-1 
			WHERE  tag_id = $d2
			"); 
		}
		// end of tag logic

		// if post not found
		$tbl = new ElybinTable('elybin_posts');
		
		// cek apakah post prepost atau bukan
		// jika `satus` = 'prepost' maka berikan 'type'='post'
		$cp = $tbl->SelectWhere('post_id', $pid)->current();
		if($cp->status == 'prepost'){
			// jika dapat status = 'active'
			if($status == 'active'){
				// buat sebuah duplikat
				// berikan type = 'autosave'
				$d = array(
					'title' => $title,
					'content' => html_entity_decode($content,ENT_QUOTES),
					'date' => date("Y-m-d H:i:s"),
					'author' => $author,
					'category_id' => 0,
					'seotitle' => $seotitle,
					'tag' => @$tag,
					'status' => 'inherit',					
					'visibility' => '',
					'post_password' => '',
					'comment' => 'allow',
					'type' => 'autosave_page',
					'parent' => $pid
				);
				$tbl->Insert($d);
			}
			
			// ubah main/parent post
			// berikan type = 'page'
			$data = array(
				'title' => $title,
				'content' => html_entity_decode($content,ENT_QUOTES),
				'date' => date("Y-m-d H:i:s"),
				'author' => $author,
				'category_id' => 0,
				'seotitle' => $seotitle,
				'tag' => @$tag,
				'status' => 'deactive',					
				'visibility' => '',
				'post_password' => '',
				'comment' => 'allow',
				'type' => 'autosave_page'
			);
			
			
		}else{
			// 1.1.3
			// post revision logic
			// ada perubahan?
			$revision = true;
			// jika ada revisi, lanjut
			// buat duplikat post lama
			if($revision){
				if($status == 'active'){
					// backup post baru
					$d = array(
						'title' => $title,
						'content' => html_entity_decode($content,ENT_QUOTES),
						'date' => date("Y-m-d H:i:s"),
						'category_id' => 0,
						'seotitle' => $seotitle,
						'author' => _u()->user_id,
						'tag' => @$tag,
						'status' => 'inherit',					
						'visibility' => '',
						'parent' => $pid,
						'post_password' => '',
						'comment' => '',
						'type' => 'autosave_page'
					);
					$tbl->Insert($d);
				}else{
					// backup post baru
					$d = array(
						'title' => $title,
						'content' => html_entity_decode($content,ENT_QUOTES),
						'date' => date("Y-m-d H:i:s"),
						'category_id' => 0,
						'seotitle' => $seotitle,
						'author' => _u()->user_id,
						'tag' => @$tag,
						'status' => 'inherit',					
						'visibility' => '',
						'parent' => $pid,
						'post_password' => '',
						'comment' => 'allow',
						'type' => 'autosave_page'
					);
					$tbl->Insert($d);
				}
			}

			// berikan type = 'post'
			$data = array(
				'title' => $title,
				'content' => html_entity_decode($content,ENT_QUOTES),
				'date' => date("Y-m-d H:i:s"),
				'category_id' => 0,
				'seotitle' => $seotitle,
				'tag' => @$tag,
				'status' => $status,					
				'visibility' => '',
				'post_password' => '',
				'comment' => 'allow',
				'type' => 'page'
			);
		}
		$tbl->Update($data, 'post_id', $pid);
			
		
		// isi 
		// jika status = draft
		if($status == 'deactive'){
			$isi = lg('Saved but not Published at');
		}else{
			$isi = lg('Published Successfully at');
		}
		
		//Done
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => $isi.' '.date('H:i:s')
		);
		echo json_encode($a);
		exit;
	}

	//EDIT
	elseif($mod=='page' AND $act=='edit'){
		$post_id = $v->sql(epm_decode($_POST['pid']));
		$title = $v->xss($_POST['title']);
		$seotitle =  seo_title($title);
		$content = html_entity_decode($_POST['content'],ENT_QUOTES);
		$status = $v->xss($_POST['status']);
		$tag = $v->xss($_POST['tag']);
		$author = _u()->user_id;

		// check id exist or not
		$tb 	= new ElybinTable('elybin_posts');
		$cop = $tb->GetRowAnd('post_id', $post_id,'type','page');
		if($cop < 1){
			$a = array(
				'status' => 'error',
				'title' => lg('Error'),
				'isi' => lg('ID mismatch, please reload page')
			);

			echo json_encode($a);
			exit;
		}
	
		//if field empty
		if(empty($title)){
			$title = '('. lg('Untitled') .')';
			$seotitle = seo_title($title);
		}
		
		// 1.1.3
		// logika tag
		$tbtag = new ElybinTable("elybin_tag");
		$tag_tmp = @explode(",", $tag);
		if($tag == ''){
			$tag_tmp = json_decode('["null"]');
			$new_tag_id = json_decode('["0"]');
			$tag = '';
		}else{
			// ubah dari string ke id
			for($i=0; $i < count($tag_tmp); $i++){
				// check already in database?
				$new_tag_id_count[$i] = $tbtag->GetRow('seotitle', seo_title(trim($tag_tmp[$i])));
				if($new_tag_id_count[$i] > 0){
					// just pick the id
					$new_tag_id[$i] = $tbtag->SelectWhere('seotitle', seo_title(trim($tag_tmp[$i])))->current()->tag_id;
				}else{
					// insert new tag
					$at = array(
						'name' => trim($tag_tmp[$i]),
						'seotitle' => seo_title(trim($tag_tmp[$i])),
						'count' => 0
					);
					$tbtag->Insert($at);
					// just pick the id
					$new_tag_id[$i] = $tbtag->SelectWhere('seotitle', seo_title(trim($tag_tmp[$i])))->current()->tag_id;
				}
				
			}
			
			$tag = json_encode($new_tag_id);
		}
		// get data form database
		$old_tags_db = $tb->SelectWhere('post_id', $post_id)->current()->tag;
		$old_tags = json_decode($old_tags_db);
		if($old_tags_db == ''){
			$old_tags = json_decode('["0"]');
		}
		// diff1 tag (add)
		$diff1 = array_diff($new_tag_id, $old_tags);
		foreach($diff1 as $d1){
			// count + 1
			$tbtag->Custom("
			UPDATE
			","
			SET  
			count =  count+1 
			WHERE  tag_id = $d1
			"); 
		}
		// diff2 tag (gone)
		$diff2 = array_diff($old_tags, $new_tag_id);
		foreach($diff2 as $d2){
			// count - 1
			$tbtag->Custom("
			UPDATE
			","
			SET  
			count =  count-1 
			WHERE  tag_id = $d2
			"); 
		}
		// end of tag logic

		//get previous post data
		$tbl = new ElybinTable('elybin_posts');
		$cp = $tbl->SelectWhere('post_id',$post_id,'','')->current();
		
		// 1.1.3
		// post revision logic
		// ada perubahan?
		$revision = false;
		// hitung panjang judul dulu, bandingkan dengan sekarang
		// cek apakah karakternya sama?
		if($cp->title !== $title){
			$revision = true;
		}
		else if($cp->content !== $content){
			$revision = true;
		}
		// jika ada revisi, lanjut
		// buat duplikat post lama
		if($revision){
			$d = array(
				'title' => $title,
				'content' => $content,
				'date' => date("Y-m-d H:i:s"),
				'author' => $author,
				'category_id' => 0,
				'seotitle' => '',
				'tag' => $tag,
				'status' => 'inherit',					
				'visibility' => '',
				'parent' => $post_id,
				'comment' => 'allow'
			);
			$tbl->Insert($d);
		}
			
		//with images
		if(!empty($_FILES['file']['tmp_name'])){
			// get images
			$extensionList = array("jpg", "jpeg");
			$fileName = $_FILES['file']['name'];
			$tmpName = $_FILES['file']['tmp_name'];
			$pecah = explode(".", $fileName);
			$ekstensi = strtolower(@$pecah[count($pecah)-1]); // fixed bug
			$rand = rand(1111,9999);
			$nama_file_unik = $rand."-".$seotitle.'.'.$ekstensi;
			$image = 'image-'.$nama_file_unik;
			$image_lama = $cp->image;

			//check extesion
			if (in_array($ekstensi, $extensionList)){
				// check the size (not more than 1024)
				$image_size = @$_FILES['file']['size'];
				if($image_size/1024 > 1024){
					$a = array(
						'status' => 'error',
						'title' => lg('Error'),
						'isi' => lg('Image size is too large, maximum is')." 1MB"
					);
					echo json_encode($a);
					exit;
				}
				

				//replace image if exist
				$fileimage_lama = "../../../elybin-file/page/$image_lama"; //previous image
				if (file_exists("$fileimage_lama") && ($image_lama!="")){
					unlink("../../../elybin-file/page/$image_lama");
					unlink("../../../elybin-file/page/medium-$image_lama");
				}
				UploadImage($image,'page');

				//update
				$data = array(
					'title' => $title,
					'content' => $content,
					'category_id' => 0,
					'seotitle' => $seotitle,
					'date' =>  date("Y-m-d H:i:s"),
					'tag' => $tag,
					'image' => $image,
					'status' => $status,					
					'visibility' => '',
					'comment' => 'allow',
					'type' => 'page'
				);
				$tbl->Update($data,'post_id',$post_id);
			}else{
				//error, extension deny
				$a = array(
					'status' => 'error',
					'title' => lg('Error'),
					'isi' => lg('File extension not allowed')
				);			
				echo json_encode($a);
				exit;
			}
		//without images
		}else{
			$data = array(
				'title' => $title,
				'content' => $content,
				'category_id' => 0,
				'seotitle' => $seotitle,
				'date' =>  date("Y-m-d H:i:s"),
				'tag' => $tag,
				'status' => $status,					
				'visibility' => '',
				'comment' => 'allow',
				'type' => 'page'
			);
			$tbl->Update($data,'post_id',$post_id);
		}

		// 1.1.3
		// callback msg for edit
		if($status == $cp->status){
			$callback_msg = 'updated';
		}else{
			if($status == 'active'){
				$callback_msg = 'published';
			}else if($status == 'deactive'){
				$callback_msg = 'draft';
			}else{
				$callback_msg = '';
			}
		}
			
		//Done
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved'),
			'callback' => 'edit',
			'callback_hash' => epm_encode($post_id),
			'callback_msg' => $callback_msg
		);
		echo json_encode($a);
		exit;
	}

	//DEL
	elseif($mod=='page' AND $act=='del'){
		$post_id = $v->sql(epm_decode($_POST['hash']));
		
		// check id exist or not
		$tb 	= new ElybinTable('elybin_posts');
		$copost = $tb->GetRowAnd('post_id', $post_id ,'type', 'page');
		if($copost < 1){
			header('location: ../../../404.html');
			exit;
		}
		
		//get image name first
		$cimg = $tb->SelectWhere('post_id',$post_id,'','')->current();
		$image = $cimg->image;
		$fileimage = "../../../elybin-file/page/$image";
		if (file_exists("$fileimage") AND ($image!="")){ //delete images
			unlink("../../../elybin-file/page/$image");
			unlink("../../../elybin-file/page/medium-$image");
		}
		// 1.1.3
		// logika tag
		$tbtag = new ElybinTable("elybin_tag");
		if($cimg->tag !== ''){
			$tag = json_decode($cimg->tag);
			foreach($tag as $cp){
				// count - 1
				$tbtag->Custom("
				UPDATE
				","
				SET  
				count =  count-1 
				WHERE  tag_id = $cp
				"); 
			}
		}
		// end of tag logic
		
		//Done
		$tb->Delete('post_id', $post_id);
		$tb->Delete('parent', $post_id);
		header('location:../../admin.php?mod=page&msg=deleted');
	}	
	//MULTI DEL
	elseif($mod=='page' AND $act=='multidel'){
		//array of delected post
		$post_id = $_POST['del'];

		//if id array empty
		if(!empty($post_id)){
			foreach ($post_id as $ps) {
				// explode data because we use pipe
				$pecah = explode("|",$ps);
				$pecah = $pecah[0];
				// check id safe from sqli
				$post_id_fix = $v->sql(epm_decode($pecah));
				
				// check id exist or not
				$tb 	= new ElybinTable('elybin_posts');
				$copost = $tb->GetRowAnd('post_id', $post_id_fix,'type','page');
				if(empty($post_id) OR ($copost == 0)){
					header('location: ../../../404.html');
					exit;
				}

				//get image name first
				$img = $tb->SelectWhere('post_id',$post_id_fix,'','')->current();
				$postimg = $img->image;
				$filepost = "../../../elybin-file/page/$postimg";
				//delete images
				if (file_exists("$filepost") AND ($postimg!="")){
					unlink("../../../elybin-file/page/$postimg");
					unlink("../../../elybin-file/page/medium-$postimg");
				}

				// 1.1.3
				// logika tag
				$tbtag = new ElybinTable("elybin_tag");
				if($img->tag !== ''){
					$tag = json_decode($img->tag);
					foreach($tag as $cp){
						// count - 1
						$tbtag->Custom("
						UPDATE
						","
						SET  
						count =  count-1 
						WHERE  tag_id = $cp
						"); 
					}
				}
				// end of tag logic
				
				//Done
				$tb->Delete('post_id', $post_id_fix);
				$tb->Delete('parent', $post_id_fix);
				header('location: ../../admin.php?mod=page&msg=deleted');
			}
		}
	}
	//404
	else{
		//error
		$a = array(
			'status' => 'error',
			'title' => lg('Error'),
			'isi' => lg('Terjadi Kesalahan pada Sistem, Hubungi Pengembang Kami. (Err: Target Proccess Not Found, Act & Mod)')
		);			
		echo json_encode($a);
		exit;	
	}
}	
?>
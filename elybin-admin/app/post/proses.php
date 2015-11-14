<?php
/* Short description for file
 * [ Module: Post - Proccess
 *
 * Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim A. <kim@elybin.com>
 */
session_start();
if(empty($_SESSION['login'])){
	header('location:../../../403.html');
}else{
	include_once('../../../elybin-core/elybin-function.php');
	include_once('../../../elybin-core/elybin-oop.php');
	include_once('../../lang/main.php');
	include_once('inc/module-function.php');
	settzone();

	$v = new ElybinValidasi;
	$mod = @$_POST['mod'];
	$act = @$_POST['act'];

	//ADD
	if ($mod=='post' AND $act=='add'){
		// getting post value
		$title = $v->xss($_POST['title']);
		$category = $v->sql($_POST['category_id']);
		$status = $v->xss(@$_POST['status']);
		$visibility = $v->xss(@$_POST['visibility']);
		$tag = $v->xss(@$_POST['tag']);
		$content = $_POST['content'];
		$seotitle =  seo_title($title);
		$pid = $v->sql($_POST['pid']);

		// cek dulu, minimal ada 1 kategori
		$tblc = new ElybinTable('elybin_category');
		$coc = $tblc->GetRow();
		if($coc < 1){
			// show error
			_red('../../../404.html');
			exit;
		}

		$tbl = new ElybinTable("elybin_posts");
		$tb = $tbl;

		//get current user
		$u = _u();
		$author = $u->user_id;

		if(empty($title)){
			$title = '('. lg('Untitled') .')';
			$seotitle = seo_title($title);
		}

		// checking seo title
		if(!check_seotitle($seotitle, $pid)){
			$seotitle = suggest_unique($seotitle, $pid);
		}

		// post_meta
		$post_meta = '{"post_meta":"false"}';

		// 1.1.3
		// visibility
		if($visibility == "protected"){
			$post_password = md5($_POST['post_password']);

			// inset to post_meta
			$ar = array(
				'post_meta' => 'true',
				'post_password' => $post_password
			);
			// convert to json
			$post_meta = json_encode($ar);
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

		// getting defaut comment option
		$option = op()->default_comment_status;
		$category = op()->default_category;

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
				'category_id' => $cp->category_id,
				'seotitle' => '',
				'tag' => $cp->tag,
				'status' => 'inherit',
				'visibility' => $cp->visibility,
				'parent' => $cp->post_id,
				'post_meta' => $cp->post_meta,
				'comment' => $cp->comment,
				'type' => $cp->type
			);
			$tbl->Insert($d);

			// duplikat post baru
			// menggulangi jika yang mengubah berbeda user
			$d = array(
				'title' => $title,
				'content' => html_entity_decode($content,ENT_QUOTES),
				'category_id' => $category,
				'date' => date("Y-m-d H:i:s"),
				'author' => _u()->user_id,
				'seotitle' => '',
				'tag' => @$tag,
				'status' => 'inherit',
				'visibility' => $visibility,
				'post_meta' => $post_meta,
				'comment' => $option,
				'type' => 'post',
				'parent' => $pid
			);
			$tbl->Insert($d);
		}

		if(!empty($_FILES['file']['tmp_name'])){
			//get images
			$extensionList = ["jpg", "jpeg"];
			$fileName = $_FILES['file']['name'];
			$tmpName = $_FILES['file']['tmp_name'];
			$pecah = explode(".", $fileName);
			$ekstensi = @$pecah[count($pecah)-1];
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
						'isi' => lg('Image too large, maximum is')." 1MB"
					);
					echo json_encode($a);
					exit;
				}

				//upload images
				$up = UploadImage($image,'post');
				if(empty($up['ok'])){
					// return error
					//image extension deny
					$a = array(
						'status' => 'error',
						'title' => lg('Error'),
						'isi' => $up['error']['message']
					);
					echo json_encode($a);
					exit;
				}



				$tbl = new ElybinTable('elybin_posts');
				$d = array(
					'title' => $title,
					'content' => html_entity_decode($content,ENT_QUOTES),
					'category_id' => $category,
					'date' => date("Y-m-d H:i:s"),
					'author' => $author,
					'seotitle' => $seotitle,
					'tag' => @$tag,
					'image' => $image,
					'status' => $status,
					'visibility' => $visibility,
					'post_meta' => $post_meta,
					'comment' => $option,
					'type' => 'post'
				);
				$tbl->Update($d, 'post_id', $pid);


				//Done
				/* $a = array(
					'status' => 'ok',
					'title' => lg('Success'),
					'isi' => $lg_datainputsuccessful
				);
				echo json_encode($a);
				exit; */
			}else{
				//image extension deny
				$a = array(
					'status' => 'error',
					'title' => lg('Error'),
					'isi' => lg('File extension not allowed.')
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
				'category_id' => $category,
				'seotitle' => $seotitle,
				'tag' => @$tag,
				'status' => $status,
				'visibility' => $visibility,
				'post_meta' => $post_meta,
				'comment' => $option,
				'type' => 'post'
			);
			$tbl->Update($d, 'post_id', $pid);

		}
		// 1.1.3
		// callback msg
		if($status == 'publish'){
			$callback_msg = 'published';
		}
		else if($status == 'draft'){
			$callback_msg = 'draft';
		}else{
			$callback_msg = '';
		}

		//Done
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Data saved successfully.'),
			'callback' => 'edit',
			'callback_id' => $pid,
			'callback_msg' => $callback_msg
		);
		echo json_encode($a);
		exit;
	}
	//ADD QUICK
	// shut down at version 1.1.3
	elseif($mod=='post' AND $act=='addquick'){
		exit;
 		/* 		$title = $v->xss($_POST['title']);
		$category = $v->sql($_POST['category_id']);
		$content = html_entity_decode($_POST['content'],ENT_QUOTES);
		$seotitle =  seo_title($title);
		$date = date("Y-m-d");

		//get current user
		$getu = new ElybinTable("elybin_users");
		$getu = $getu->SelectWhere('session',$_SESSION['login'],'','');
		$author = $getu->current()->user_id;

		//if field empty
		if(empty($title)){
			$title = '('. lg('Tanpa Judul') .')';
			$seotitle = seo_title($title);
		}

		//get lastest post id
		$tblp = new ElybinTable('elybin_posts');
		$post2 = $tblp->SelectLimit('post_id','DESC','0,1');
		$post_id = 1;
		foreach ($post2 as $ps) {
			$post_id = $ps->post_id + 1;
		}
		//get default_comment_status
		$tblo = new ElybinTable('elybin_options');
		$option_id = $tblo->SelectWhere('name','default_comment_status','','');
		foreach ($option_id as $op) {
			$option = $op->value;
		}
		// getting defaut category
		if(empty($category)){
			$category = $tblo->SelectWhere('name','default_category','','');
			foreach ($category as $op) {
				$category = $op->value;
			}
		}

		$tbl = new ElybinTable('elybin_posts');
		$data = array(
			'title' => $title,
			'content' => $content,
			'date' => date("Y-m-d H:i:s"),
			'author' => $author,
			'category_id' => $category,
			'seotitle' => $seotitle,
			'status' => 'draft',
			'comment' => $option
		);
		$tbl->Insert($data);

		//Done
		echo $post_id; */
	}

	// 1.1.3
	// AUTO SAVE
	else if ($mod=='post' AND $act=='autosave'){
		// getting post value
		$title = $v->xss($_POST['title']);
		$category = $v->sql($_POST['category_id']);
		$status = $v->xss(@$_POST['status']);
		$visibility = $v->xss(@$_POST['visibility']);
		$tag = $v->xss(@$_POST['tag']);
		$content = $_POST['content'];
		$seotitle =  seo_title($title);
		$author = _u()->user_id;
		$pid = $v->sql($_POST['pid']);

		if(empty($title)){
			$title = '('. lg('Untitled') .')';
			$seotitle = seo_title($title);
		}

		// checking seo title
		if(!check_seotitle($seotitle, $pid)){
			$seotitle = suggest_unique($seotitle, $pid);
		}

		// post_meta
		$post_meta = '{"post_meta":"false"}';

		// 1.1.3
		// visibility
		if($visibility == "protected"){
			$post_password = md5($_POST['post_password']);
		}else{
			$post_password = '';
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

		// getting defaut comment option
		$option = op()->default_comment_status;
		$category = op()->default_category;

		// if post not found
		$tbl = new ElybinTable('elybin_posts');

		// cek apakah post prepost atau bukan
		// jika `satus` = 'prepost' maka berikan 'type'='post'
		$cp = $tbl->SelectWhere('post_id', $pid)->current();
		if($cp->status == 'prepost'){
			// jika dapat status = 'publish'
			if($status == 'publish'){
				// buat sebuah duplikat
				// berikan type = 'autosave'
				$d = array(
					'title' => $title,
					'content' => html_entity_decode($content,ENT_QUOTES),
					'date' => date("Y-m-d H:i:s"),
					'author' => $author,
					'category_id' => $category,
					'seotitle' => $seotitle,
					'tag' => @$tag,
					'status' => 'inherit',
					'visibility' => $visibility,
					'post_meta' => $post_meta,
					'post_password' => $post_password,
					'comment' => $option,
					'type' => 'autosave',
					'parent' => $pid
				);
				$tbl->Insert($d);
			}

			// ubah main/parent post
			// berikan type = 'post'
			$data = array(
				'title' => $title,
				'content' => html_entity_decode($content,ENT_QUOTES),
				'date' => date("Y-m-d H:i:s"),
				'author' => $author,
				'category_id' => $category,
				'seotitle' => $seotitle,
				'tag' => @$tag,
				'status' => 'draft',
				'visibility' => $visibility,
				'post_meta' => $post_meta,
				'post_password' => $post_password,
				'comment' => $option,
				'type' => 'autosave'
			);


		}else{
			// 1.1.3
			// post revision logic
			// ada perubahan?
			$revision = true;
			// jika ada revisi, lanjut
			// buat duplikat post lama
			if($revision){
				// jika dapat status = 'publish'
   	/* 				if($status == 'publish'){
					// backup post lama
					$d = array(
						'title' => $cp->title,
						'content' => $cp->content,
						'date' => $cp->date,
						'author' => $cp->author,
						'category_id' => $cp->category_id,
						'seotitle' => $cp->seotitle,
						'tag' => $cp->tag,
						'status' => 'inherit',
						'visibility' => $cp->visibility,
						'parent' => $cp->post_id,
						'post_meta' => $cp->post_meta,
						'comment' => $cp->comment,
						'type' => 'post'
					);
					$tbl->Insert($d);
				} */

				if($status == 'publish'){
					// backup post baru
					$d = array(
						'title' => $title,
						'content' => html_entity_decode($content,ENT_QUOTES),
						'date' => date("Y-m-d H:i:s"),
						'category_id' => $category,
						'seotitle' => '',
						'author' => _u()->user_id,
						'tag' => @$tag,
						'status' => 'inherit',
						'visibility' => $visibility,
						'post_meta' => $post_meta,
						'parent' => $pid,
						'post_password' => $post_password,
						'comment' => $option,
						'type' => 'autosave'
					);
					$tbl->Insert($d);
				}else{
					// backup post baru
					$d = array(
						'title' => $title,
						'content' => html_entity_decode($content,ENT_QUOTES),
						'date' => date("Y-m-d H:i:s"),
						'category_id' => $category,
						'seotitle' => '',
						'author' => _u()->user_id,
						'tag' => @$tag,
						'status' => 'inherit',
						'visibility' => $visibility,
						'post_meta' => $post_meta,
						'parent' => $pid,
						'post_password' => $post_password,
						'comment' => $option,
						'type' => 'autosave'
					);
					$tbl->Insert($d);
				}
			}

			// berikan type = 'post'
			$data = array(
				'title' => $title,
				'content' => html_entity_decode($content,ENT_QUOTES),
				'date' => date("Y-m-d H:i:s"),
				'category_id' => $category,
				'seotitle' => $seotitle,
				'tag' => @$tag,
				'status' => $status,
				'visibility' => $visibility,
				'post_meta' => $post_meta,
				'post_password' => $post_password,
				'comment' => $option,
				'type' => 'post'
			);
		}
		$tbl->Update($data, 'post_id', $pid);


		// isi
		// jika status = draft
		if($status == 'draft'){
			$isi = lg('Saved to Draft at');
		}else{
			$isi = lg('Saved at');
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
	elseif($mod=='post' AND $act=='edit'){
		$post_id = sqli_(to_int(epm_decode(@$_POST['pid'])));
		$title = $v->xss($_POST['title']);
		$seotitle = xss_($_POST['seotitle']);
		$content = html_entity_decode($_POST['content'],ENT_QUOTES);
		$category = $v->sql($_POST['category_id']);
		$status = $v->xss($_POST['status']);
		$tag = $v->xss($_POST['tag']);
		$visibility = $v->xss($_POST['visibility']);
		$comment = $v->xss($_POST['comment']);
		$author = _u()->user_id;

		// proses
		$pid = $post_id;

		// check id exist or not
		$tb 	= new ElybinTable('elybin_posts');
		$cop = $tb->GetRow('post_id', $post_id);
		if(empty($post_id) || $cop < 1){
			$a = array(
				'status' => 'error',
				'title' => lg('Error'),
				'isi' => lg('Content ID mismatch, please reload page.')
			);

			echo json_encode($a);
			exit;
		}

		//if field empty
		if(empty($title)){
			$title = '('. lg('Tanpa Judul') .')';
		}

		/*
		 * check seo title available or not
		 * @since 1.1.4
		 */
		if(!check_seotitle($seotitle, $pid)){
			$a = array(
				'status' => 'error',
				'title' => __('Error'),
				'isi' => __('SEO title already used, there our suggestion.'),
				'callback' => 'edit',
				'callback_id' => epm_encode($pid),
				'callback_msg' => __('SEO title already used, please check it first.')
			);
			echo json_encode($a);
			exit;
		}

		// 1.1.3
		// post_meta
		$post_meta = '{"post_meta":"false"}';
		// visibility
		if($visibility == "protected"){
			$post_password = md5($_POST['post_password']);

			// inset to post_meta
			$ar = array(
				'post_meta' => 'true',
				'post_password' => $post_password
			);
			// convert to json
			$post_meta = json_encode($ar);
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
			// old
/* 			$d = array(
				'title' => $cp->title,
				'content' => $cp->content,
				'date' => $cp->date,
				'author' => $author,
				'category_id' => $cp->category_id,
				'seotitle' => $cp->seotitle,
				'tag' => $cp->tag,
				'status' => 'inherit',
				'visibility' => $cp->visibility,
				'parent' => $cp->post_id,
				'post_meta' => $cp->post_meta,
				'comment' => $cp->comment
			);			 */
			$d = array(
				'title' => $title,
				'content' => $content,
				'date' => date("Y-m-d H:i:s"),
				'author' => $author,
				'category_id' => $category,
				'seotitle' => '',
				'tag' => $tag,
				'status' => 'inherit',
				'visibility' => $visibility,
				'parent' => $post_id,
				'post_meta' => $post_meta,
				'comment' => $comment
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
			$ekstensi = @$pecah[count($pecah)-1]; // fixed bug
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
						'isi' => lg('Image file size is too large, maximum is')." 512KB"
					);
					echo json_encode($a);
					exit;
				}



				//upload images
				$up = UploadImage($image,'post');
				if(empty($up['ok'])){
					// return error
					//image extension deny
					$a = array(
						'status' => 'error',
						'title' => lg('Error'),
						'isi' => $up['error']['message']
					);
					echo json_encode($a);
					exit;
				}

				//replace image if exist
				$fileimage_lama = "../../../elybin-file/post/$image_lama"; //previous image
				if (file_exists("$fileimage_lama") && ($image_lama!="")){
					@unlink("../../../elybin-file/post/$image_lama");
					@unlink("../../../elybin-file/post/medium-$image_lama");
				}

				//update
				$data = array(
					'title' => $title,
					'content' => $content,
					'category_id' => $category,
					'seotitle' => $seotitle,
					'date' =>  date("Y-m-d H:i:s"),
					'tag' => $tag,
					'image' => $image,
					'status' => $status,
					'visibility' => $visibility,
					'post_meta' => $post_meta,
					'comment' => $comment,
					'type' => 'post'
				);
				$tbl->Update($data,'post_id',$post_id);
			}else{
				//error, extension deny
				$a = array(
					'status' => 'error',
					'title' => lg('Error'),
					'isi' => lg('File extension not allowed.')
				);
				echo json_encode($a);
				exit;
			}
		//without images
		}else{
			$data = array(
				'title' => $title,
				'content' => $content,
				'category_id' => $category,
				'seotitle' => $seotitle,
				'date' =>  date("Y-m-d H:i:s"),
				'tag' => $tag,
				'status' => $status,
				'visibility' => $visibility,
				'post_meta' => $post_meta,
				'comment' => $comment,
				'type' => 'post'
			);
			$tbl->Update($data,'post_id',$post_id);
		}

		// 1.1.3
		// callback msg for edit
		if($status == $cp->status){
			$callback_msg = 'updated';
		}else{
			if($status == 'publish'){
				$callback_msg = 'published';
			}else if($status == 'draft'){
				$callback_msg = 'draft';
			}else{
				$callback_msg = '';
			}
		}

		//Done
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Post edited successfully.'),
			'callback' => 'edit',
			'callback_id' => $post_id,
			'callback_msg' => $callback_msg
		);
		echo json_encode($a);
		exit;
	}

	// RECYCLE DEL
	// temporary delete, just move post to recycle bin
	// v1.1.3
	elseif($mod=='post' AND $act=='recycle_del'){
		$post_id = $v->sql(@$_POST['post_id']);

		// check id exist or not
		$tb 	= new ElybinTable('elybin_posts');
		$copost = $tb->GetRow('post_id', $post_id);
		if(empty($post_id) || ($copost == 0)){
			_red('../../../404.html');
			exit;
		}
		// just change parent post status to 'deleted'
		$par = array(
			'status' => 'deleted'
		);

		//Done
		$tb->Update($par, 'post_id', $post_id);
		_red('../../admin.php?mod='.$mod);
	}
	// MULTI RECYCLE DEL
	// temporary delete, just move post to recycle bin
	// v1.1.3
	elseif($mod=='post' AND $act=='recycle_multidel'){
		//array of delected post
		$post_id = $_POST['del'];

		//if id array empty
		if(!empty($post_id)){
			foreach ($post_id as $ps) {
				// explode data because we use pipe
				$pecah = explode("|",$ps);
				$pecah = $pecah[0];
				// check id safe from sqli
				$post_id_fix = $v->sql($pecah);

				// check id exist or not
				$tb 	= new ElybinTable('elybin_posts');
				$copost = $tb->GetRow('post_id', $post_id_fix);
				if(empty($post_id) OR ($copost == 0)){
					header('location: ../../../404.html');
					exit;
				}

				// just change parent post status to 'deleted'
				$par = array(
					'status' => 'deleted'
				);

				//Done
				$tb->Update($par, 'post_id', $post_id_fix);
				header('location:../../admin.php?mod='.$mod);
			}
		}
	}
	//DEL
	elseif($mod=='post' AND $act=='del'){
		$post_id = $v->sql($_POST['post_id']);

		// check id exist or not
		$tb 	= new ElybinTable('elybin_posts');
		$copost = $tb->GetRow('post_id', $post_id);
		if(empty($post_id) OR ($copost == 0)){
			header('location: ../../../404.html');
			exit;
		}
		// delete comment
		$tbco = new ElybinTable('elybin_comments');
		$ccom = $tbco->GetRow('post_id', $post_id);
		if($ccom > 0){
			$tbco->Delete('post_id', $post_id);
		}

		//get image name first
		$cimg = $tb->SelectWhere('post_id',$post_id,'','')->current();
		$image = $cimg->image;
		$fileimage = "../../../elybin-file/post/$image";
		if (file_exists("$fileimage") AND ($image!="")){ //delete images
			@unlink("../../../elybin-file/post/$image");
			@unlink("../../../elybin-file/post/medium-$image");
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
		header('location:../../admin.php?mod='.$mod);
	}
	//MULTI DEL
	elseif($mod=='post' AND $act=='multidel'){
		//array of delected post
		$post_id = $_POST['del'];

		//if id array empty
		if(!empty($post_id)){
			foreach ($post_id as $ps) {
				// explode data because we use pipe
				$pecah = explode("|",$ps);
				$pecah = $pecah[0];
				// check id safe from sqli
				$post_id_fix = $v->sql($pecah);

				// check id exist or not
				$tb 	= new ElybinTable('elybin_posts');
				$copost = $tb->GetRow('post_id', $post_id_fix);
				if(empty($post_id) OR ($copost == 0)){
					header('location: ../../../404.html');
					exit;
				}

				// delete comment
				$tbco = new ElybinTable('elybin_comments');
				$ccom = $tbco->GetRow('post_id', $post_id_fix);
				if($ccom > 0){
					$tbco->Delete('post_id', $post_id_fix);
				}

				//get image name first
				$img = $tb->SelectWhere('post_id',$post_id_fix,'','')->current();
				$postimg = $img->image;
				$filepost = "../../../elybin-file/post/$postimg";
				//delete images
				if (file_exists("$filepost") AND ($postimg!="")){
					@unlink("../../../elybin-file/post/$postimg");
					@unlink("../../../elybin-file/post/medium-$postimg");
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
				_red('../../admin.php?mod='.$mod);
			}
		}
	}
	//404
	else{
		//error
		$a = array(
			'status' => 'error',
			'title' => lg('Error'),
			'isi' => lg('There some error occur, this is our mistake, please contact us. (Err: Target Proccess Not Found, Act & Mod)')
		);
		echo json_encode($a);
		exit;
	}
}
?>

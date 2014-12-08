<?php
/* Short description for file
 * [ Module: Post - Proccess
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
session_start();
if(empty($_SESSION['login'])){
	header('location:../../../403.php');
}else{
	include_once('../../../elybin-core/elybin-function.php');
	include_once('../../../elybin-core/elybin-oop.php');
	include_once('../../lang/main.php');
	settzone();

	$v = new ElybinValidasi;
	$mod = $_POST['mod'];
	$act = $_POST['act'];

	//ADD
	if ($mod=='post' AND $act=='add'){
		// getting post value
		$title = $v->xss($_POST['title']);
		$category = $v->sql($_POST['category_id']);
		$status = $v->xss(@$_POST['status']);
		if($status == "on"){
			$status = "publish";
		}else{
			$status = "draft";
		}
		$content = htmlspecialchars($_POST['content'],ENT_QUOTES);
		$seotitle =  seo_title($title);
		$date = now();
		$time = date("H:i:s");

		//get current user
		$getu = new ElybinTable("elybin_users");
		$getu = $getu->SelectWhere('session',$_SESSION['login'],'','');
		$author = $getu->current()->user_id;

		//if field empty
		if(empty($title) AND empty($content)){
			//please fill important
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_pleasefillimportant
			);

			json($a);
			exit;
		}
		elseif(empty($title)){
			$title = "($lg_untitled)";
			$seotitle = seo_title($title);
		}
		elseif(empty($content)){
			$content = "<p></p>";
		}	

		// getting defaut comment option
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
		// getting tag
		if (!empty($_POST['tag'])){
			$tag_seo = $_POST['tag'];
			$tag = implode(',',$tag_seo);
		}

		if(!empty($_FILES['image']['tmp_name'])){
			//get images
			$extensionList = array("jpg", "jpeg");
			$fileName = $_FILES['image']['name'];
			$tmpName = $_FILES['image']['tmp_name'];
			$pecah = explode(".", $fileName);
			$ekstensi = @$pecah[1];
			$rand = rand(1111,9999);
			$nama_file_unik = $rand."-".$seotitle.'.'.$ekstensi;
			$image = 'image-'.$nama_file_unik;


			if (in_array($ekstensi, $extensionList)){
				//upload images
				UploadImage($image,'post');
				$tbl = new ElybinTable('elybin_posts');
				$data = array(
					'title' => $title,
					'content' => $content,
					'category_id' => $category,
					'date' => $date,
					'time' => $time,
					'author' => $author,
					'seotitle' => $seotitle,
					'tag' => @$tag,
					'image' => $image,
					'status' => $status,
					'comment' => $option
				);
				$tbl->Insert($data);

				$jml = count(@$tag_seo);
				for($i=0; $i<$jml; $i++){
					$tblt = new ElybinTable('elybin_tag');
					$tblt->Custom("UPDATE","SET count=count+1 WHERE tag_id='".$tag_seo[$i]."'");
				}

				//Done
				$a = array(
					'status' => 'ok',
					'title' => $lg_success,
					'isi' => $lg_datainputsuccessful
				);
				json($a);
			}else{
				//image extension deny
				$a = array(
					'status' => 'error',
					'title' => $lg_error,
					'isi' => $lg_fileextensiondeny
				);
				json($a);
			}
		}else{
			//without image
			$tbl = new ElybinTable('elybin_posts');
			$data = array(
				'title' => $title,
				'content' => $content,
				'date' => $date,
				'time' => $time,
				'author' => $author,
				'category_id' => $category,
				'seotitle' => $seotitle,
				'tag' => @$tag,
				'status' => $status,
				'comment' => $option
			);
			$tbl->Insert($data);

			//count tag used
			$jml = count(@$tag_seo);
			for($i=0; $i<$jml; $i++){
				$tblt = new ElybinTable('elybin_tag');
				$tblt->Custom("UPDATE","SET count=count+1 WHERE tag_id='".$tag_seo[$i]."'");
			}
			
			//Done
			$a = array(
				'status' => 'ok',
				'title' => $lg_success,
				'isi' => $lg_datainputsuccessful
			);
			json($a);
		}
	}
	//ADD QUICK
	elseif($mod=='post' AND $act=='addquick'){
		$title = $v->xss($_POST['title']);
		$category = $v->sql($_POST['category_id']);
		$content = htmlspecialchars($_POST['content'],ENT_QUOTES);
		$seotitle =  seo_title($title);
		$date = now();

		//get current user
		$getu = new ElybinTable("elybin_users");
		$getu = $getu->SelectWhere('session',$_SESSION['login'],'','');
		$author = $getu->current()->user_id;

		//if field empty
		if(empty($title)){
			$title = "($lg_untitled)";
			$seotitle = seo_title($title);
		}
		elseif(empty($content)){
			$content = "<p></p>";
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
			'date' => $date,
			'time' => $time,
			'author' => $author,
			'category_id' => $category,
			'seotitle' => $seotitle,
			'status' => 'draft',
			'comment' => $option
		);
		$tbl->Insert($data);

		//Done
		echo $post_id;
	}

	//EDIT
	elseif($mod=='post' AND $act=='edit'){
		$post_id = $v->sql($_POST['post_id']);
		$title = $v->xss($_POST['title']);
		$category = $v->sql($_POST['category_id']);
		$status = @$_POST['status'];
		if($status == "on"){
			$status = "publish";
		}else{
			$status = "draft";
		}
		$comment = @$_POST['comment'];
		if($comment == "on"){
			$comment = "allow";
		}else{
			$comment = "deny";
		}
		$content = htmlspecialchars($_POST['content'],ENT_QUOTES);
		$seotitle =  seo_title($title);

		// check id exist or not
		$tb 	= new ElybinTable('elybin_posts');
		$copost = $tb->GetRow('post_id', $post_id);
		if(empty($post_id) OR ($copost == 0)){
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_iderrorpleasereloadpage
			);

			json($a);
			exit;
		}
	
		//if field empty
		if(empty($title) AND empty($content)){
			//error, please fill important
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_pleasefillimportant
			);

			json($a);
			exit;
		}
		elseif(empty($title)){
			$title = "($lg_untitled)";
			$seotitle = seo_title($title);
		}
		elseif(empty($content)){
			$content = "<p></p>";
		}	

		//explode tag
		if (!empty($_POST['tag'])){
			$tag_seo = $_POST['tag'];
			$tag = implode(',',$tag_seo);
		}

		//with images
		if(!empty($_FILES['image']['tmp_name'])){
			// get images
			$extensionList = array("jpg", "jpeg");
			$fileName = $_FILES['image']['name'];
			$tmpName = $_FILES['image']['tmp_name'];
			$pecah = explode(".", $fileName);
			$ekstensi = $pecah[1];
			$rand = rand(1111,9999);
			$nama_file_unik = $rand."-".$seotitle.'.'.$ekstensi;
			$image = 'image-'.$nama_file_unik;

			//get previous image
			$tblim = new ElybinTable('elybin_posts');
			$image_lama = $tblim->SelectWhere('post_id',$post_id,'','');
			$image_lama = $image_lama->current()->image;

			//check extesion
			if (in_array($ekstensi, $extensionList)){

				//replace image if exist
				$fileimage_lama = "../../../elybin-file/post/$image_lama"; //previous image
				if (file_exists("$fileimage_lama") AND ($image_lama!="")){
					unlink("../../../elybin-file/post/$image_lama");
					unlink("../../../elybin-file/post/medium-$image_lama");
				}
				UploadImage($image,'post');

				//update
				$tbl = new ElybinTable('elybin_posts');
				$data = array(
					'title' => $title,
					'content' => $content,
					'category_id' => $category,
					'seotitle' => $seotitle,
					'tag' => @$tag,
					'image' => $image,
					'status' => $status,
					'comment' => $comment
				);
				$tbl->Update($data,'post_id',$post_id);

				//count tag used
				$jml = count(@$tag_seo);
				for($i=0; $i<$jml; $i++){
					$tblt = new ElybinTable('elybin_tag');
					$tblt->Custom("UPDATE","SET count=count+1 WHERE tag_id='".$tag_seo[$i]."'");
				}
				
				//Done
				$a = array(
					'status' => 'ok',
					'title' => $lg_success,
					'isi' => $lg_dataeditsuccessful
				);
				json($a);
			}else{
				//error, extension deny
				$a = array(
					'status' => 'error',
					'title' => $lg_error,
					'isi' => $lg_fileextensiondeny
				);
				json($a);
				exit;
			}

		//without images
		}else{
			$tbl = new ElybinTable('elybin_posts');
			$data = array(
				'title' => $title,
				'content' => $content,
				'category_id' => $category,
				'seotitle' => $seotitle,
				'tag' => @$tag,
				'status' => $status,
				'comment' => $comment
			);
			$tbl->Update($data,'post_id',$post_id);

			//count tag used
			$jml = count(@$tag_seo);
			for($i=0; $i<$jml; $i++){
				$tblt = new ElybinTable('elybin_tag');
				$tblt->Custom("UPDATE","SET count=count+1 WHERE tag_id='".$tag_seo[$i]."'");
			}
			
			//Done
			$a = array(
				'status' => 'ok',
				'title' => $lg_success,
				'isi' => $lg_dataeditsuccessful
			);
			json($a);
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
		$cimg = $tb->SelectWhere('post_id',$post_id,'','');
		foreach($cimg as $i){
			$image = $i->image;
		}
		$fileimage = "../../../elybin-file/post/$image";
		if (file_exists("$fileimage") AND ($image!="")){ //delete images
			unlink("../../../elybin-file/post/$image");
			unlink("../../../elybin-file/post/medium-$image");
		}

		//Done
		$tb->Delete('post_id', $post_id);
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
				$img = $tb->SelectWhere('post_id',$post_id_fix,'','');
				$img = $img->current();
				$postimg = $img->image;
				$filepost = "../../../elybin-file/post/$postimg";
				//delete images
				if (file_exists("$filepost") AND ($postimg!="")){
					unlink("../../../elybin-file/post/$postimg");
					unlink("../../../elybin-file/post/medium-$postimg");
				}

				//Done
				$tb->Delete('post_id', $post_id_fix);
				header('location:../../admin.php?mod='.$mod);
			}
		}
	}
	//404
	else{
		echo '404';
		header('location:../../../404.php');
	}
}	
?>
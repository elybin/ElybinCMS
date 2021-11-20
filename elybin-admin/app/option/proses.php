<?php
/* Short description for file
 * [ Module: Settings
 *
 * Elybin CMS (www.elybin.github.io) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim. <elybin.inc@gmail.com>
 */
session_start();
if(empty($_SESSION['login'])){
	header('location:../../../403.html');
}else{
	require_once('../../../elybin-core/elybin-function.php');
	require_once('../../../elybin-core/elybin-oop.php');

// get usergroup privilage/access from current user to this module
$usergroup = _ug()->setting;

// give error if no have privilage
if($usergroup == 0){
	er('<strong>'.lg('Ouch!').'</strong> '.lg('You don\'t have access to access this page. Access Desied 403.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
	exit;
}else{
	// start here
	$v = new ElybinValidasi;
	$mod = $_POST['pk'];
	$act = $_POST['name'];

	//UPDATE
	if ($mod=='option' AND $act=='site_url'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='site_name'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='site_description'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='site_keyword'){
		$value = $_POST['value'];
		$v = implode(", ", $value);
		$v = rtrim($v, ", ");
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $v);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='site_phone'){
		$value = htmlspecialchars($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='site_office_address'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='site_owner'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='site_email'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='site_hero_title'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='site_hero_subtitle'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='site_coordinate'){
		$value = htmlspecialchars($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='users_can_register'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='default_category'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='default_comment_status'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='posts_per_page'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='default_homepage'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='timezone'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='language'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		// destroy cookie
		@setcookie('lang', '', time()-(60*60*24*30), str_replace('/app/option/proses.php', '', $_SERVER['REQUEST_URI']));
		// set cookie
		@setcookie("lang", $value, time()+(60*60*24*30), str_replace('/app/option/proses.php', '', $_SERVER['REQUEST_URI']));
		// result
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='maintenance_mode'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='developer_mode'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='short_name'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='text_editor'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='social_twitter'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);

		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='social_facebook'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);

		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='social_instagram'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);

		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='smtp_host'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);

		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='smtp_port'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);

		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='smtp_user'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);

		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='smtp_pass'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);

		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='smtp_status'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);

		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='mail_daily_limit'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);

		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' && $act=='url_rewrite_style'){
		$arr_permalink = json_decode(base64_decode($_POST['permalink_style']));

		// save to database
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $arr_permalink->style_id);
		$tbl->Update($data,'name', 'url_rewrite_style');

		// only template with htaccess required
		if($arr_permalink->htaccess){
			// try to read htaccess first
			$url_template = null;
			$f = fopen(root_uri()."elybin-core/url/htaccess/{$arr_permalink->style_id}.php", "r");
			while(!feof($f)) {
				$url_template .= fgets($f);
			}
			fclose($f);

			// remove header
			$extract_origin = preg_match('/\/\*\*\*(.*)/s', $url_template, $match);
			$url_template = $match[1];

			// try to write it
			$f = fopen(root_uri().'.htaccess', "w");
			if(fwrite($f, $url_template) == false){
				// write manually
				$_SESSION['url_template'] = $url_template;
				// result
				result(array(
					'status' => 'danger',
					'title' => __('Error'),
					'msg' => __('Permission denied, cannot write .htaccess. Fix yout directory permission and try again or write manually.'),
					'msg_ses' => 'permission_denied',
					'msg_icon' => 'fa fa-ban',
					'red' => get_url('admin_home').'admin.php?mod=option&act=permalink'
				), @$_GET['r']);
			}
			fclose($f);
		}


		// result
		result(array(
			'status' => 'ok',
			'title' => __('Success'),
			'msg' => __('New permalink applied.'),
			'msg_ses' => 'permalink_applied',
			'msg_icon' => 'fa fa-check',
			'red' => get_url('admin_home').'admin.php?mod=option&act=permalink'
		), @$_GET['r']);
	}
	elseif ($mod=='option' && $act=='site_logo'){
		// get old images, save it
		$old = get_option('site_logo');
		// filter image extesion
		$ext_l = ["jpg", "jpeg","png"];
		$fname = $_FILES['file']['name'];
		$tname = $_FILES['file']['tmp_name'];
		$pecah = explode(".", $fname);
		$ext = @$pecah[count($pecah)-1];
		$image = "logo.$ext";
		if(!empty($tname)){
			// only specifict ext
			if (in_array($ext, $ext_l)){
				// upload it, with md only compression
				$up = UploadImage($image, 'system', ['md']);
				if(!empty($up['ok'])){
					// save to database
					$tbl = new ElybinTable('elybin_options');
					$tbl->Update(['value' => $image], 'name', 'site_logo');
					// delete default
					if (file_exists("../../../elybin-file/system/{$old}") && $old == 'default_logo.png'){
						@unlink("../../../elybin-file/system/{$old}");
						@unlink("../../../elybin-file/system/md-{$old}");
					}
					// result
					result(array(
						'status' => 'ok',
						'title' => __('Success'),
						'msg' => __('Logo successfully updated.'),
						'msg_ses' => 'logo_updated',
						'msg_icon' => 'fa fa-check',
						'red' => get_url('admin_home').'admin.php?mod=option&act=interface'
					), @$_GET['r']);
				}else{
					// return error
					result(array(
						'status' => 'danger',
						'title' => __('Error'),
						'msg' => $up['error']['message'],
						'msg_ses' => $up['error']['code'],
						'msg_icon' => 'fa fa-warning',
						'red' => get_url('admin_home').'admin.php?mod=option&act=interface'
					), @$_GET['r']);
				}
			}else{
				// return error
				result(array(
					'status' => 'error',
					'title' => __('Error'),
					'msg' => __('Image extension not allowed.'),
					'msg_ses' => __('image_extension_not_allowed'),
					'msg_icon' => 'fa fa-warning',
					'red' => get_url('admin_home').'admin.php?mod=option&act=interface'
				), @$_GET['r']);
			}
		}else{
			// return error
			result(array(
				'status' => 'error',
				'title' => __('Error'),
				'msg' => __('No image selected.'),
				'msg_ses' => __('no_image_selected'),
				'msg_icon' => 'fa fa-info-circle',
				'red' => get_url('admin_home').'admin.php?mod=option&act=interface'
			), @$_GET['r']);
		}
	}
	elseif ($mod=='option' && $act=='site_favicon'){
		// get old images, save it
		$old = get_option('site_favicon');
		// filter image extesion
		$ext_l = ["jpg", "jpeg","png"];
		$fname = $_FILES['file']['name'];
		$tname = $_FILES['file']['tmp_name'];
		$pecah = explode(".", $fname);
		$ext = @$pecah[count($pecah)-1];
		$image = "favicon.$ext";
		if(!empty($tname)){
			// only specifict ext
			if (in_array($ext, $ext_l)){
				// upload it, with md only compression
				$up = UploadImage($image, 'system', ['md']);
				if(!empty($up['ok'])){
					// save to database
					$tbl = new ElybinTable('elybin_options');
					$tbl->Update(['value' => $image], 'name', 'site_favicon');
					// delete default
					if (file_exists("../../../elybin-file/system/{$old}") && $old == 'default_favicon.png'){
						@unlink("../../../elybin-file/system/{$old}");
						@unlink("../../../elybin-file/system/md-{$old}");
					}
					// result
					result(array(
						'status' => 'ok',
						'title' => __('Success'),
						'msg' => __('Favicon successfully updated.'),
						'msg_ses' => 'favicon_updated',
						'msg_icon' => 'fa fa-check',
						'red' => get_url('admin_home').'admin.php?mod=option&act=interface'
					), @$_GET['r']);
				}else{
					// return error
					result(array(
						'status' => 'danger',
						'title' => __('Error'),
						'msg' => $up['error']['message'],
						'msg_ses' => $up['error']['code'],
						'msg_icon' => 'fa fa-warning',
						'red' => get_url('admin_home').'admin.php?mod=option&act=interface'
					), @$_GET['r']);
				}
			}else{
				// return error
				result(array(
					'status' => 'error',
					'title' => __('Error'),
					'msg' => __('Image extension not allowed.'),
					'msg_ses' => __('image_extension_not_allowed'),
					'msg_icon' => 'fa fa-warning',
					'red' => get_url('admin_home').'admin.php?mod=option&act=interface'
				), @$_GET['r']);
			}
		}else{
			// return error
			result(array(
				'status' => 'error',
				'title' => __('Error'),
				'msg' => __('No image selected.'),
				'msg_ses' => __('no_image_selected'),
				'msg_icon' => 'fa fa-info-circle',
				'red' => get_url('admin_home').'admin.php?mod=option&act=interface'
			), @$_GET['r']);
		}
	}
	elseif ($mod=='option' && $act=='site_hero'){
		// get old images, save it
		$old = get_option('site_hero');
		// filter image extesion
		$ext_l = ["jpg", "jpeg","png"];
		$fname = $_FILES['file']['name'];
		$tname = $_FILES['file']['tmp_name'];
		$pecah = explode(".", $fname);
		$ext = @$pecah[count($pecah)-1];
		$image = "heroimg.$ext";
		if(!empty($tname)){
			// only specifict ext
			if (in_array($ext, $ext_l)){
				// upload it, with md only compression
				$up = UploadImage($image, 'system', ['md']);
				if(!empty($up['ok'])){
					// save to database
					$tbl = new ElybinTable('elybin_options');
					$tbl->Update(['value' => $image], 'name', 'site_hero');
					// delete default
					if (file_exists("../../../elybin-file/system/{$old}") && $old == 'default_heroimg.jpg'){
						@unlink("../../../elybin-file/system/{$old}");
						@unlink("../../../elybin-file/system/md-{$old}");
					}
					// result
					result(array(
						'status' => 'ok',
						'title' => __('Success'),
						'msg' => __('Hero image successfully updated.'),
						'msg_ses' => 'hero_image_updated',
						'msg_icon' => 'fa fa-check',
						'red' => get_url('admin_home').'admin.php?mod=option&act=interface'
					), @$_GET['r']);
				}else{
					// return error
					result(array(
						'status' => 'danger',
						'title' => __('Error'),
						'msg' => $up['error']['message'],
						'msg_ses' => $up['error']['code'],
						'msg_icon' => 'fa fa-warning',
						'red' => get_url('admin_home').'admin.php?mod=option&act=interface'
					), @$_GET['r']);
				}
			}else{
				// return error
				result(array(
					'status' => 'error',
					'title' => __('Error'),
					'msg' => __('Image extension not allowed.'),
					'msg_ses' => __('image_extension_not_allowed'),
					'msg_icon' => 'fa fa-warning',
					'red' => get_url('admin_home').'admin.php?mod=option&act=interface'
				), @$_GET['r']);
			}
		}else{
			// return error
			result(array(
				'status' => 'error',
				'title' => __('Error'),
				'msg' => __('No image selected.'),
				'msg_ses' => __('no_image_selected'),
				'msg_icon' => 'fa fa-info-circle',
				'red' => get_url('admin_home').'admin.php?mod=option&act=interface'
			), @$_GET['r']);
		}
	}
	//404
	else{
		header('location:../../../404.html');
	}
}

}
?>

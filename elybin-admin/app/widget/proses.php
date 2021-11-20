<?php
/* Short description for file
 * [ Module: Widget Proccess
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
	include_once('../../../elybin-core/elybin-function.php');
	include_once('../../../elybin-core/elybin-oop.php');
	include_once('../../../elybin-core/elybin-pclzip.lib.php');
	include_once('../../lang/main.php');

	// get usergroup privilage/access from current user to this module
	$usergroup = _ug()->setting;

// give error if no have privilage
if($usergroup == 0){
	er('<strong>'.lg('Ouch!').'</strong> '.lg('You don\'t have access to this page. Access Desied 403.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
	theme_foot();
	exit;
}else{
	// start here
	$v = new ElybinValidasi;
	$tbwgt = new ElybinTable('elybin_widget');
	$mod = $_GET['mod'];
	$act = $_GET['act'];

	//ADD
	if ($mod=='widget' AND $act=='add'){
		
		$fileName = $_FILES['widget_file']['name'];
		$tmpName = $_FILES['widget_file']['tmp_name'];
		$pecah = explode(".", $fileName);
		$ekstensi = $pecah[2];
		$folder = seo_title($pecah[1]);

		if(!empty($tmpName)){
			// only zip file
			$extensionList = array("zip");
			if (in_array($ekstensi, $extensionList)){
				Uploadwidget($folder.".zip");

				// move to temp folder
				$destination_dir = "../../tmp/";
				if(!file_exists($destination_dir.$folder."/")){
					mkdir($destination_dir.$folder."/");
				
					// extract the zip
					$archive = new PclZip($destination_dir.$folder.".zip");
					if ($archive->extract(PCLZIP_OPT_PATH, $destination_dir.$folder."/") == 0){
						// give error
						$a = array(
							'status' => 'error',
							'title' => lg('Error'),
							'isi' => lg('Widget corrupt')
						);
						echo json_encode($a);
						exit;
					}
				}
				//INCLUDE MANIFEST AMBIL NAMA FOLDER
				if(file_exists($destination_dir.$folder."/ElybinManifest.php")){
					include($destination_dir.$folder."/ElybinManifest.php");
					$app_folder_ok = $app_alias; 

					if(file_exists("../".$app_folder_ok)){
						// give error widget already installed
						$a = array(
							'status' => 'error',
							'title' => lg('Error'),
							'isi' => lg('Widget already installed')
						);
						echo json_encode($a);
						exit;
					}else{
						mkdir("../".$app_folder_ok);
				
						$archive = new PclZip($destination_dir.$folder.".zip");
						if ($archive->extract(PCLZIP_OPT_PATH, "../".$app_folder_ok) == 0){
							// give error
							$a = array(
								'status' => 'error',
								'title' => lg('Error'),
								'isi' => lg('Widget Corrupt')
							);
							echo json_encode($a);
							exit;
						}

						// write to database
						$tbl = new ElybinTable('elybin_widgets');
						$widget2 = $tbl->SelectLimit('widget_id','DESC','0,1');
						$widget_id = 1;
						foreach ($widget2 as $ps) {
							$widget_id = $ps->widget_id + 1;
						}

						// get all usergroup
						$tblug = new ElybinTable('elybin_usergroup');
						$tblug = $tblug->Select('','');
						$usergroup_all = '';
						foreach ($tblug as $ugal) {
							$usergroup_all = "$usergroup_all,$ugal->usergroup_id";
						}
						$usergroup_all = ltrim($usergroup_all, ",");

						$data = array(
							'widget_id' => $widget_id,
							'name' => $app_name,
							'alias' => $app_alias,
							'icon' => $app_icon,
							'notification' => '',
							'version' => $app_version,
							'description' => $app_description,
							'author' => $app_author,
							'url' => $app_url,
							'usergroup' => $usergroup_all,
							'table_name' => $app_table,
							'type' => $app_type,
							'status' => 'install'
						);
						$tbl->Insert($data);

						//remove temp dir
						deleteDir($destination_dir.$folder."/");
						if(file_exists($destination_dir.$folder.".zip")){
							unlink($destination_dir.$folder.".zip");
						}
					}
				}
				//Done 
				$a = array(
					'status' => 'ok',
					'title' => lg('Success'),
					'isi' => lg('Widget Uploaded'),
					'widget_id' => $widget_id
				);
				echo json_encode($a);
				//header('location:../../admin.php?mod='.$mod.'&next=install&id='.$widget_id);
			}
		}
	}
	//MOVE UP
	elseif ($mod=='widget' AND $act=='up'){
		$widget_id = $v->sql($_GET['id']);
		
		// check id are exist
		$cowidget = $tbwgt->GetRow('widget_id', $widget_id);
		if($cowidget == 0){
			header('location: ../../../404.html');
			exit;
		}
		
		// get widget information
		$widget_sort = $tbwgt->SelectWhere('widget_id',$widget_id,'','')->current()->sort;
		$widget_position = $tbwgt->SelectWhere('widget_id',$widget_id,'','')->current()->position;
		if($widget_sort > 1){
			// decrease id less than this 
			$decwidget = $tbwgt->SelectWhere('position', $widget_position,'','');
			foreach($decwidget as $dw){
				if(($dw->sort == $widget_sort-1) AND ($dw->type == 'include' OR $dw->type == 'code')){
					// decrease it
					$dw_sort = $dw->sort;
					$dw_sort++;
					
					$ddata = array('sort' => $dw_sort);
					$tbwgt->Update($ddata, 'widget_id', $dw->widget_id);
				}
			}
			$widget_sort--;
			
			// update it
			$data = array('sort' => $widget_sort);
			$tbwgt->Update($data, 'widget_id', $widget_id);
		}
		$s = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		header('location:../../admin.php?mod='.$mod);
		echo json_encode($s);
	}
	//MOVE DOWN
	elseif ($mod=='widget' AND $act=='down'){
		$widget_id = $v->sql($_GET['id']);
		
		// check id are exist
		$cowidget = $tbwgt->GetRow('widget_id', $widget_id);
		if($cowidget == 0){
			header('location: ../../../404.html');
			exit;
		}
		
		// get widget information
		$widget_sort = $tbwgt->SelectWhere('widget_id',$widget_id,'','')->current()->sort;
		$widget_position = $tbwgt->SelectWhere('widget_id',$widget_id,'','')->current()->position;
		// count row
		$cocowidget = $tbwgt->SelectWhere('position', $widget_position,'','');
		foreach($cocowidget as $ccw){
			if($ccw->type == 'include' OR $ccw->type == 'code'){
				@$countwidget++;
			}
		}
		
		if($widget_sort < $countwidget){
			// increase id less than this 
			$decwidget = $tbwgt->SelectWhere('position', $widget_position,'','');
			foreach($decwidget as $dw){
				if(($dw->sort == $widget_sort+1) AND ($dw->type == 'include' OR $dw->type == 'code')){
					// decrease it
					$dw_sort = $dw->sort;
					$dw_sort--;
					
					$ddata = array('sort' => $dw_sort);
					$tbwgt->Update($ddata, 'widget_id', $dw->widget_id);
				}
			}
			$widget_sort++;
			
			// update it
			$data = array('sort' => $widget_sort);
			$tbwgt->Update($data, 'widget_id', $widget_id);
		}
		$s = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		header('location:../../admin.php?mod='.$mod);
		echo json_encode($s);
	}
	
	// STATUS TOGGLE
	elseif ($mod=='widget' AND $act=='status'){
		$widget_id = $v->sql($_GET['id']);
		
		// check id are exist
		$cowidget = $tbwgt->GetRow('widget_id', $widget_id);
		if($cowidget == 0){
			header('location: ../../../404.html');
			exit;
		}
		
		// get widget information
		$widget_status = $tbwgt->SelectWhere('widget_id',$widget_id,'','')->current()->status;
		
		if($widget_status == 'active'){
			// change to deactive
			$data = array('status' => 'deactive');
			$tbwgt->Update($data, 'widget_id', $widget_id);
			
		}
		elseif($widget_status == 'deactive'){
			// change to active
			$data = array('status' => 'active');
			$tbwgt->Update($data, 'widget_id', $widget_id);
		}
		
		// give feedback
		$s = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		header('location:../../admin.php?mod='.$mod);
		echo json_encode($s);
	}
	
	//DEL
	elseif ($mod=='widget' AND $act=='del'){
		$widget_id = $v->sql($_POST['widget_id']);
		$tabledel = new ElybinTable('elybin_widgets');
		$cwgt = $tabledel->SelectWhere('widget_id',$widget_id,'','');
		$cwgt = $cwgt->current();

		// only delete dir if widget not installed
		if($cwgt->status == 'install'){
			$dir = "../".$cwgt->alias."/";
			deleteDir($dir);
			$tabledel->Delete('widget_id', $widget_id);
			header('location:../../admin.php?mod='.$mod);
			exit;
		}

		// execute remover
		$sql_contents = "";
		$fp = fopen("../".$cwgt->alias."/db/remove.sql","r");
		while(! feof($fp))
		  {
		  $sql_contents .= fgets($fp);
		  }
		fclose($fp);

		// because we can't use oop
		$dbhostsql = DB_HOST;
		$dbusersql = DB_USER;
		$dbpasswordsql = DB_PASSWD;
		$dbnamesql = DB_NAME;
		$connection = mysql_connect($dbhostsql, $dbusersql, $dbpasswordsql) or die(mysql_error());
		mysql_select_db($dbnamesql, $connection) or die(mysql_error());
		$result = mysql_query($sql_contents) or die(mysql_error());
		if ($result){
			// Wipe 
			$dir = "../".$cwgt->alias."/";
			deleteDir($dir);
			//Done
			$tabledel->Delete('widget_id', $widget_id);
		}else{
			// give error
			$a = array(
				'status' => 'error',
				'title' => lg('Error'),
				'isi' => lg('Failed to remove widet')
			);
			echo json_encode($a);
			exit;
		}
		header('location:../../admin.php?mod='.$mod);
	}
	//404
	else{
		echo '404';
		header('location:../../../404.php');
	}
}	
}
?>
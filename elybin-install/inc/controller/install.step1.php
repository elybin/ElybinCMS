<?php
/**
 * Controller of installer.
 *
 * @package   Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @author		Khakim A <kim@elybin.com>
 * @since 		Elybin 1.1.4
 */

//W.I.W.S
where_i_was_supposed();

// if lock sys not exists
// if( !file_exists(many_trans().'elybin-install/install_date.txt') ){
// 	redirect(get_url('install.default'));
// }
//
// check status proses
// if(install_status() == 1){
// 	$_SESSION['msg'] = '';
// 	unset($_SESSION['config_template']);
// 	// call
// 	if(write_htaccess() == false){
// 		result(array(
// 			'status' => 'error',
// 			'title' => lg('Error'),
// 			'msg' => lg('Failed writing &#34;.htaccess&#34;. Copy the script below, and create file manually.'),
// 			'msg_ses' => 'failed_htaccess',
// 			'red' => ''
// 		), @$_GET['r'], false);
// 	}
// }

// change to step 2
if(install_status() == 2){
	$_SESSION['msg'] = '';
	unset($_SESSION['msg']);
	//unset($_SESSION['htaccess_template']);

	// success

	// rem tmp session
	@$_SESSION['h'] = '';
	@$_SESSION['u'] = '';
	@$_SESSION['p'] = '';
	@$_SESSION['n'] = '';
	@$_SESSION['msg'] = '';

	// change step
	// because step 2 is skiped
	//$_SESSION['step'] = "1";

	// if install with content
	if(!import_sql(array("mysql/latest.sql"))){
		//echo lg('Some query failed to execute, This is our mistake. Please contact us.');
		result(array(
			'status' => 'error',
			'title' => lg('Error'),
			'msg' => lg('Some query failed to execute, This is our mistake. Please contact us.'),
			'msg_ses' => 'query_error',
			'red' => get_url('install.step2')
		), @$_GET['r']);
	}else{
		result(array(
			'status' => 'error',
			'title' => lg('Error'),
			'msg' => lg('Database configuration success!'),
			'msg_ses' => 'step1_ok',
			'red' => get_url('install.step2')
		), @$_GET['r']);
	}
}

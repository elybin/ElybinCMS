<?php
/* Short description for file
 * Login Procees 
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 - 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 * ---------------------------------------------
 * 1.1.3
 * - Update Interface 
 * - Update Hashing password method
 * - Add data to Elybin Statistic
 * - Fixing user blocking
 */
include_once('../elybin-core/elybin-oop.php');
include_once('../elybin-core/elybin-function.php');
include_once('../elybin-core/lib/password.php');

if(isset($_SESSION['login'])){
	header('location: admin.php');
}else{
	$v = new ElybinValidasi();

	// what page to show up
	switch (@$_GET['p']) {
		case 'login':
			$tbs = new ElybinTable('elybin_statistic');

			// collect data
			$post_u = $v->xss(@$_POST['u']);
			$post_p = $v->xss(@$_POST['p']);
			$post_c = $v->xss(@$_POST['c']);

			// filter input
			if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/", $post_u)){
				// if input email error, try filter username
				if(!preg_match("/^[a-z0-9_]+$/", $post_u)){
					// woops! not matched anything, I given up! give 'em result!
					result(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Username or E-mail format not recognized. Double check please.'),
						'msg_ses' => 'invalid_char',
						'red' => 'index.php?p=login'
					), @$_GET['r']);
				}
			}

			// I lost and confuse without you, fill me please :(
			if(empty($post_u)){
				// I'm into you :)					
				result(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('We need something to identify you, like Username or E-mail.'),
						'msg_ses' => 'fill_username',
						'red' => 'index.php?p=login'
					), @$_GET['r']);
			}else{
				// kick em' n burry 'em!!
				// also get from statistic
				$cs = $tbs->SelectFullCustom("
					SELECT
					SUM(`stat_value1`) as `user_failed_login`
					FROM 
					`elybin_statistic` as `s`
					WHERE
					`s`.`stat_date` LIKE '".date('Y-m-d')."%' &&
					`s`.`stat_text2` = '".client_info('yes')."' &&
					`s`.`stat_module` = 'user' &&
					`s`.`stat_type` = 'user_failed_login'
					")->current();
				// if exceed failed, block them
				if($cs->user_failed_login > 5){
					result(array(
							'status' => 'error',
							'title' => lg('Error'),
							'msg' => lg('You have exceeded the number of allowed login attempts. Please try again later.'),
							'msg_ses' => 'login_blocked',
							'red' => 'index.php?p=login'
						), @$_GET['r']);
				}
				// try again, don't lose hope!
				if(!ccode($post_c)){
					result(array(
							'status' => 'error',
							'title' => lg('Error'),
							'msg' => lg('Oops, wrong captcha code. Please try again.'),
							'msg_ses' => 'invalid_code',
							'red' => 'index.php?p=login'
						), @$_GET['r']);
				}

				// checking on database
				$tb = new ElybinTable('elybin_users');
				$cu = $tb->CLogin($post_u)->current();

				// match with password
				if(password_verify($post_p, $cu->user_account_pass)){
					// generate random session
					$rd = md5(md5(rand(1000,9999).rand(1,9999).date('ymdhisss')));
					$tb->Update(array(
						'session' => $rd,
						'lastlogin' => date('Y-m-d H:i:s')
					), 'user_id', $cu->user_id);
					
					// set session
					$_SESSION['login'] = $rd;
					$_SESSION['last_activity'] = time(); 
					$_SESSION['loginfail'] = 0;
					unset($_SESSION['loginfail']);

					// collect to statistic
					$tbs->Insert(array(
						'stat_module' => 'user',
						'stat_type' => 'user_login',
						'stat_date' => date('Y-m-d H:i:s'),
						'stat_value1' => 1,
						'stat_text1' => $cu->user_account_email,
						'stat_uid' => $cu->user_id
					));

					// destroy cp session (still not effective)
					unset($_SESSION['cp']); @$_SESSION['cp']='';

					// url referer
					if(isset($_SESSION['ref'])){
						$ref = urldecode($_SESSION['ref']);
						header('location: '.$ref);
					}else{
						header('location: admin.php?mod=home');
					}
					
				}else{

					// collect to statistic
					$tbs->Insert(array(
						'stat_module' => 'user',
						'stat_type' => 'user_failed_login',
						'stat_date' => date('Y-m-d H:i:s'),
						'stat_value1' => 1,
						'stat_text1' => $post_u,
						'stat_text2' => client_info('yes')
						));

					//result
					result(array(
							'status' => 'error',
							'title' => lg('Error'),
							'msg' => lg('The Username or Password is incorrect.'),
							'msg_ses' => 'wrong_combination',
							'red' => 'index.php?p=login'
						), @$_GET['r']);
				}

			}
			break;
		case 'register':
			// collect data
			$post_u = $v->xss(@$_POST['u']);
			$post_e = $v->xss(@$_POST['e']);
			$post_p = $v->xss(@$_POST['p']);
			$post_pc = $v->xss(@$_POST['pc']);
			$post_c = $v->xss(@$_POST['c']);

			// set temp session
			$_SESSION['ses_u'] = $post_u;
			$_SESSION['ses_e'] = $post_e;
 

			// never let them empty
			if(empty($post_u)){
				result(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Please fill Username first.'),
					'msg_ses' => 'fill_username',
					'red' => 'index.php?p=register'
				), @$_GET['r']);
			}
			// never let them empty
			if(empty($post_e)){
				result(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Please fill E-mail.'),
					'msg_ses' => 'fill_email',
					'red' => 'index.php?p=register'
				), @$_GET['r']);
			}
			// never let them empty
			if(empty($post_p)){
				result(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Please fill Password.'),
					'msg_ses' => 'fill_password',
					'red' => 'index.php?p=register'
				), @$_GET['r']);
			}
			// never let them empty
			if(empty($post_pc)){
				result(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Don\'t forget to fill Password in both field.'),
					'msg_ses' => 'fill_both',
					'red' => 'index.php?p=register'
				), @$_GET['r']);
			}
 			// filter email
			if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/", $post_e)){
				// woops! not matched anything, I given up! give 'em result!
				result(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('E-mail format not recognized. Example format is xxx@xxx.xxx.'),
					'msg_ses' => 'invalid_email',
					'red' => 'index.php?p=register'
				), @$_GET['r']);
			}
			// if input email error, try filter username
			if(!preg_match("/^[a-z0-9_]+$/", $post_u)){
				// woops! not matched anything, I given up! give 'em result!
				result(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Username format not recognized. Allowed character for Username is letter(a-z), number(0-9) and underscore (_)'),
					'msg_ses' => 'invalid_username',
					'red' => 'index.php?p=register'
				), @$_GET['r']);
			}
			// limit username length
			if(strlen($post_u) > 12){
				// woops! not matched anything, I given up! give 'em result!
				result(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Maximum username character is 12 letter.'),
					'msg_ses' => 'username_too_long',
					'red' => 'index.php?p=register'
				), @$_GET['r']);
			}
			// limit username length
			if(strlen($post_u) < 3){
				// woops! not matched anything, I given up! give 'em result!
				result(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Minimum username character is 3 letter.'),
					'msg_ses' => 'username_too_short',
					'red' => 'index.php?p=register'
				), @$_GET['r']);
			}
			// match the password
			if($post_p !== $post_pc){
				result(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Both password din\'t match each other, Please check.'),
					'msg_ses' => 'password_not_match',
					'red' => 'index.php?p=register'
				), @$_GET['r']);
			}
			// limit password
			if(strlen($post_p) < 6){
				result(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Your password is too weak, try to use more combination.'),
					'msg_ses' => 'password_too_short',
					'red' => 'index.php?p=register'
				), @$_GET['r']);
			}
			// get from database
			$tb = new ElybinTable('elybin_users');
			$cou = $tb->GetRow('user_account_login', $post_u);
			if($cou > 0){
				// pick new one
				result(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Username already taken, pick new one.'),
					'msg_ses' => 'username_taken',
					'red' => 'index.php?p=register'
				), @$_GET['r']);
			}
			// get from database
			$coe = $tb->GetRow('user_account_email', $post_e);
			if($coe > 0){
				// pick new one
				result(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('E-mail already used by another account.'),
					'msg_ses' => 'email_used',
					'red' => 'index.php?p=register'
				), @$_GET['r']);
			}

			// try again, don't lose hope!
			if(!ccode($post_c)){
				result(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Oops, wrong captcha code. Please try again.'),
						'msg_ses' => 'invalid_code',
						'red' => 'index.php?p=register'
					), @$_GET['r']);
			}

			//write it
			$tb->Insert(array(
				'user_account_login' => $post_u,
				'user_account_pass' => password_hash($post_p, PASSWORD_BCRYPT),
				'user_account_email' => $post_e,
				'email_status' => 'notverified',
				'fullname' => strtoupper($post_u),
				'avatar' => 'default/no-ava.png',
				'registered' => date("Y-m-d H:i:s"),
				'level' => 3,
				'session' => 'offline'
			));
			
			// push notif
			/*
			$dpn = array(
				'code' => 'user_added',
				'title' => '$lg_user',
				'icon' => 'fa-user',
				'type' => 'success',
				'content' => '[{"content":"'.$username.'", "single":"$lg_newuseraddedby","more":"$lg_newuseradded"}]'
			);
			pushnotif($dpn);*/

			// collect to statistic
			$tbs = new ElybinTable('elybin_statistic');
			$cu = $tb->SelectWhere('user_account_email', $post_e)->current();
			$tbs->Insert(array(
				'stat_module' => 'user',
				'stat_type' => 'user_register',
				'stat_date' => date('Y-m-d H:i:s'),
				'stat_value1' => 1,
				'stat_text1' => $cu->user_account_email,
				'stat_uid' => $cu->user_id
				));

			// set temp session
			$_SESSION['ses_u'] = '';
			$_SESSION['ses_e'] = '';			
			
			// destroy cp session (still not effective)
			unset($_SESSION['cp']); @$_SESSION['cp']='';

			// result
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Registration complete. You can login now.'),
				'msg_ses' => 'register_complete',
				'red' => 'index.php?p=login'
				), @$_GET['r']);
			break;
		
		/* 
		 *	Forgot E-mail - Not Tested Yet!
		 * 	-----------
		 *	1.1.3
		 *  - add smtp 
		 *  - add daily mail sent limit 
		 */
		case 'forgot':
			// collet post data
			$post_e = $v->xss(@$_POST['e']);

			// never let them empty
			if(empty($post_e)){
				result(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Please enter E-mail of your account.'),
					'msg_ses' => 'enter',
					'red' => 'index.php?p=forgot'
				), @$_GET['r']);
			}
			// filter input
			if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/", $post_e)){
				result(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('E-mail format not recognized. Double check please.'),
					'msg_ses' => 'invalid_char',
					'red' => 'index.php?p=forgot'
				), @$_GET['r']);
			}

			// checking on database
			$tb = new ElybinTable('elybin_users');
			// check first are email match or not
			$cu = $tb->SelectFullCustom("
				SELECT
				*,
				COUNT(`user_id`) as `row`
				FROM 
				`elybin_users` as `u`
				WHERE
				`u`.`user_account_email` = '$post_e'
				LIMIT 0,1
				")->current();
			
			if($cu->row < 1){
				result(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('E-mail not found inside our database. Try to register new account.'),
					'msg_ses' => 'email_notfound',
					'red' => 'index.php?p=forgot'
				), @$_GET['r']);
			}else{
				// get option
				$op = _op();

				// personal daily limit
				$tbs = new ElybinTable('elybin_statistic');
				$cs = $tbs->SelectFullCustom("
					SELECT
					SUM(`stat_value1`) as `daily_sent`
					FROM 
					`elybin_statistic` as `s`
					WHERE
					`s`.`stat_date` LIKE '".date('Y-m-d')."%' &&
					`s`.`stat_text1` = '$post_e' &&
					`s`.`stat_module` = 'mail' &&
					`s`.`stat_type` = 'daily_sent'
					")->current();
				// check personal mail limit = 3
				if($cs->daily_sent > 2){
					result(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('We can\'t complete your request right now. Our mailing server very busy & reaching daily limit.'),
						'msg_ses' => 'email_limit',
						'red' => 'index.php?p=forgot'
					), @$_GET['r']);
				}

				// check global daily mail limit
				$cs = $tbs->SelectFullCustom("
					SELECT 
					SUM(`stat_value1`) as `today_sent`
					FROM
					`elybin_statistic` as `s` 
					WHERE
					`s`.`stat_date` LIKE '".date("Y-m-d")."%' &&
					`s`.`stat_module` = 'mail' &&
					`s`.`stat_type` = 'daily_sent'
					")->current();
				if($cs->today_sent >= $op->mail_daily_limit){
					result(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('We can\'t complete your request right now. Our mailing server very busy & reaching daily limit.'),
						'msg_ses' => 'email_limit',
						'red' => 'index.php?p=forgot'
					), @$_GET['r']);
				}


				// generate random key
				$fk = md5(sha1($post_e.date('HisYmhid').microtime()));
				// update 
				$tb->Update(array(
					'user_account_forgetkey' => $fk,
					'forget_date' => date('Y-m-d H:i:s')
					), 'user_id', $cu->user_id);

				// compose email
				$content = "

				Hi $cu->fullname, <br/><br/>

				Someone recently requested a password change for your account in &quot;<a href='$op->site_url'>$op->site_name</a>&quot;. 
				If this was you, you can set a new password  <a href=\"$op->site_url/elybin-admin/index.php?p=recover&k=".$fk."\">here</a> :<br/><br/>

				<a href=\"$op->site_url/elybin-admin/index.php?p=reccover&k=".$fk."\">Reset Password</a><br/><br/>

				If you don't want to change your password or didn't request this, just ignore and delete this message.<br/><br/>

				To keep your account secure, please don't forward this email to anyone.<br/><br/>

				Thanks!<br/>
				$op->site_owner (Site Owner)<br/><br/>
				------------------------------------------------------------<br/>
				$op->site_url powered by <a href='http://www.elybin.com'>Elybin CMS - Free Open Source CMS</a>
				";
				
				// check what method used to send email
				if($op->smtp_status == 'active'){
					// gmail smtp
					/**
					 * This example shows settings to use when sending via Google's Gmail servers.
					 */

					//SMTP needs accurate times, and the PHP time zone MUST be set
					//This should be done in your php.ini, but this is how to do it if you don't have access to that
					date_default_timezone_set('Etc/UTC');

					require '../elybin-core/lib/PHPMailer/PHPMailerAutoload.php';

					//Create a new PHPMailer instance
					$mail = new PHPMailer;

					//Tell PHPMailer to use SMTP
					$mail->isSMTP();

					//Enable SMTP debugging
					// 0 = off (for production use)
					// 1 = client messages
					// 2 = client and server messages
					$mail->SMTPDebug = 2;

					//Ask for HTML-friendly debug output
					$mail->Debugoutput = 'html';

					//Set the hostname of the mail server
					$mail->Host = $op->smtp_host;

					//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
					$mail->Port = $op->smtp_port;

					//Set the encryption system to use - ssl (deprecated) or tls
					$mail->SMTPSecure = 'tls';

					//Whether to use SMTP authentication
					$mail->SMTPAuth = true;

					//Username to use for SMTP authentication - use full email address for gmail
					$mail->Username = $op->smtp_user;

					//Password to use for SMTP authentication
					$mail->Password = $op->smtp_pass;

					//Set who the message is to be sent from
					$mail->setFrom($op->site_email, $op->site_owner);

					//Set an alternative reply-to address
					$mail->addReplyTo($op->site_email,  $op->site_owner);

					//Set who the message is to be sent to
					$mail->addAddress($cu->user_account_email, $cu->fullname);

					//Set the subject line
					$mail->Subject = "Password Reset - $op->site_name";

					//Read an HTML message body from an external file, convert referenced images to embedded,
					//convert HTML into a basic plain-text alternative body
					$mail->msgHTML($content, dirname(__FILE__));

					//Replace the plain text body with one created manually
					$mail->AltBody = $content;

					//send the message, check for errors
					if (!$mail->send()) {
					    echo "Mailer Error: " . $mail->ErrorInfo;
					} else {
					    echo "Message sent!";
					}
				}else{
					// manual php
					$to = "$cu->fullname <$cu->user_account_email>";
					$from = "op->site_owner <$op->site_email>";
					$subject = "Password Reset - $op->site_name";

					$header = "From: $from\r\n";
					$header .= "Content-Type: text/html; charset=utf-8\r\n";
					$header .= "MIME-Version: 1.0\r\n";
					$header .= "Content-Transfer-Encoding: quoted-printable";



					// send it
					mail($to, $subject, $content, $header);
				}


				// +1 mail sent today
				$tbs->Insert(array(
					'stat_module' => 'mail',
					'stat_type' => 'daily_sent',
					'stat_date' => date('Y-m-d H:i:s'),
					'stat_value1' => 1,
					'stat_text1' => $cu->user_account_email,
					'stat_uid' => $cu->user_id
					));

				// result
				result(array(
					'status' => 'ok',
					'title' => lg('Success'),
					'msg' => lg('Instruction was sent into your E-mail. Please check your E-mail.'),
					'msg_ses' => 'reset_sent',
					'red' => 'index.php?p=forgot'
				), @$_GET['r']);
			}
			break;

		case 'recover':
			// grab parameter
			$post_p = @$_POST['p'];
			$post_pc = @$_POST['pc'];
			$post_k = $v->sql(@$_POST['k']);

			// filter input & never let them empty
			if(!preg_match("/^[a-z0-9]+$/", $post_k) || empty($post_k) || strlen($post_k) > 32 || strlen($post_k) < 32){
				result(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('You try to access invalid link. Please contact Administrator.'),
					'msg_ses' => 'invalid_link',
					'red' => 'index.php?p=login'
				), @$_GET['r']);
			}

			// counting day from reset to access this link (using lastlogin)
			$tb = new ElybinTable('elybin_users');
			$cu = $tb->SelectFullCustom("
				SELECT
				*,
				COUNT(`user_id`) as `row`
				from
				`elybin_users` as `u`
				WHERE 
				`u`.`user_account_forgetkey` = '$post_k'
				LIMIT 0,1
				")->current();

			// if link expired in 24 hour
			if($cu->row < 1 || diff_date(date('Y-m-d H:i:s'), $cu->forget_date, 'hour') > 24){
				result(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('You try to access expired link. Try to do forgot password again.'),
					'msg_ses' => 'expired_link',
					'red' => 'index.php?p=login'
				), @$_GET['r']);
			}

			// match the password
			if($post_p !== $post_pc){
				result(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Both password din\'t match each other, Please check.'),
					'msg_ses' => 'password_not_match',
					'red' => 'index.php?p=recover&k='.$post_k
				), @$_GET['r']);
			}
			// limit password
			if(strlen($post_p) < 6){
				result(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Your password is too weak, try to use more combination.'),
					'msg_ses' => 'password_too_short',
					'red' => 'index.php?p=recover&k='.$post_k
				), @$_GET['r']);
			}

			// save changes
			$tb->Update(array(
				'user_account_pass' => password_hash($post_p, PASSWORD_BCRYPT),
				'user_account_forgetkey' => '',
				'forget_date' => '0000-00-00 00:00:00'
				), 'user_account_forgetkey', $post_k);

			// result
			result(array(
				'status' => 'ok',
				'title' => lg('Success'),
				'msg' => lg('Changes saved! Login with new password.'),
				'msg_ses' => 'password_changed',
				'red' => 'index.php?p=login'
			), @$_GET['r']);
			break;

		default:
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Page not found. (404)'),
				'msg_ses' => 'not_found',
				'red' => 'index.php?p=login'
			), @$_GET['r']);
			break;
	}
}
?>
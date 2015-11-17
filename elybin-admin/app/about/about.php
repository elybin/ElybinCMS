<?php
/* Short description for file
 * [ Module: About contain version, developer, and system information
 *
 * Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim A. <kim@elybin.com>
 */
if(!isset($_SESSION['login'])){
	header('location: index.php');
}else{

//internal info
include_once('../elybin-core/elybin-version.php');

// get usergroup privilage/access from current user to this module
$usergroup = _ug()->setting;

switch (@$_GET['act']) {
	default:
?>
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm">
					<span class="hidden-sm hidden-md hidden-lg"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;<?php echo lg('About') ?></span>
					<span class="hidden-xs"><span class="text-light-gray"><?php if($usergroup > 0){ // if not have setting priv ?><?php echo lg('Setting')?> / <?php } ?></span><?php echo lg('About') ?></span>
				</h1>
			</div>
		</div> <!-- ./Page Header -->

		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">
				<div class="panel">

					<!-- Panel Heading -->
					<div class="panel-heading">
						<span class="panel-title"><i class="fa fa-info-circle hidden-xs">&nbsp;&nbsp;</i>Elybin CMS</span>
					</div>
					<!-- ./Panel Heading -->

					<div class="panel-body">

						<div class="text-center">
							<?php if($usergroup > 0){ // if not have setting priv ?>
							<img class="img-rounded" alt="<?php echo $lg_photo?>" src="<?php echo $ELYBIN_IMAGE?>"/>
							<?php }else{ ?>
							<img src="data:image/jpeg;base64,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AbIAAAAQAAAAAQAAAAAAEnByaW50T3V0cHV0T3B0aW9ucwAAABIAAAAAQ3B0bmJvb2wAAAAAAENsYnJib29sAAAAAABSZ3NNYm9vbAAAAAAAQ3JuQ2Jvb2wAAAAAAENudENib29sAAAAAABMYmxzYm9vbAAAAAAATmd0dmJvb2wAAAAAAEVtbERib29sAAAAAABJbnRyYm9vbAAAAAAAQmNrZ09iamMAAAABAAAAAAAAUkdCQwAAAAMAAAAAUmQgIGRvdWJAb+AAAAAAAAAAAABHcm4gZG91YkBv4AAAAAAAAAAAAEJsICBkb3ViQG/gAAAAAAAAAAAAQnJkVFVudEYjUmx0AAAAAAAAAAAAAAAAQmxkIFVudEYjUmx0AAAAAAAAAAAAAAAAUnNsdFVudEYjUHhsQHK/++AAAAAAAAAKdmVjdG9yRGF0YWJvb2wBAAAAAFBnUHNlbnVtAAAAAFBnUHMAAAAAUGdQQwAAAABMZWZ0VW50RiNSbHQAAAAAAAAAAAAAAABUb3AgVW50RiNSbHQAAAAAAAAAAAAAAABTY2wgVW50RiNQcmNAWQAAAAAAADhCSU0D7QAAAAAAEAEr/74AAQACASv/vgABAAI4QklNBCYAAAAAAA4AAAAAAAAAAAAAP4AAADhCSU0EDQAAAAAABAAAAB44QklNBBkAAAAAAAQAAAAeOEJJTQPzAAAAAAAJAAAAAAAAAAABADhCSU0nEAAAAAAACgABAAAAAAAAAAI4QklNA/UAAAAAAEgAL2ZmAAEAbGZmAAYAAAAAAAEAL2ZmAAEAoZmaAAYAAAAAAAEAMgAAAAEAWgAAAAYAAAAAAAEANQAAAAEALQAAAAYAAAAAAAE4QklNA/gAAAAAAHAAAP////////////////////////////8D6AAAAAD/////////////////////////////A+gAAAAA/////////////////////////////wPoAAAAAP////////////////////////////8D6AAAOEJJTQQAAAAAAAACAAQ4QklNBAIAAAAAAAwAAAAAAAAAAAAAAAA4QklNBDAAAAAAAAYBAQEBAQE4QklNBC0AAAAAAAYAAQAAAAY4QklNBAgAAAAAABAAAAABAAACQAAAAkAAAAAAOEJJTQQeAAAAAAAEAAAAADhCSU0EGgAA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b3AvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0RXZ0PSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VFdmVudCMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNSBXaW5kb3dzIiB4bXA6Q3JlYXRlRGF0ZT0iMjAxNC0xMS0xMFQwODozMzozOSswNzowMCIgeG1wOk1vZGlmeURhdGU9IjIwMTQtMTEtMTRUMjM6MDI6MjMrMDc6MDAiIHhtcDpNZXRhZGF0YURhdGU9IjIwMTQtMTEtMTRUMjM6MDI6MjMrMDc6MDAiIGRjOmZvcm1hdD0iaW1hZ2UvanBlZyIgcGhvdG9zaG9wOkNvbG9yTW9kZT0iMyIgcGhvdG9zaG9wOklDQ1Byb2ZpbGU9InNSR0IgSUVDNjE5NjYtMi4xIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjdCQzAwNjU2MTQ2Q0U0MTE5QzI5QzgwRkIyNDNFQjE3IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjdBQzAwNjU2MTQ2Q0U0MTE5QzI5QzgwRkIyNDNFQjE3IiB4bXBNTTpPcmlnaW5hbERvY3VtZW50SUQ9InhtcC5kaWQ6N0FDMDA2NTYxNDZDRTQxMTlDMjlDODBGQjI0M0VCMTciPiA8eG1wTU06SGlzdG9yeT4gPHJkZjpTZXE+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJjcmVhdGVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOjdBQzAwNjU2MTQ2Q0U0MTE5QzI5QzgwRkIyNDNFQjE3IiBzdEV2dDp3aGVuPSIyMDE0LTExLTEwVDA4OjMzOjM5KzA3OjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgQ1M1IFdpbmRvd3MiLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249ImNvbnZlcnRlZCIgc3RFdnQ6cGFyYW1ldGVycz0iZnJvbSBpbWFnZS9wbmcgdG8gaW1hZ2UvanBlZyIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0ic2F2ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6N0JDMDA2NTYxNDZDRTQxMTlDMjlDODBGQjI0M0VCMTciIHN0RXZ0OndoZW49IjIwMTQtMTEtMTRUMjM6MDI6MjMrMDc6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCBDUzUgV2luZG93cyIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8L3JkZjpTZXE+IDwveG1wTU06SGlzdG9yeT4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+ICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPD94cGFja2V0IGVuZD0idyI/Pv/iDFhJQ0NfUFJPRklMRQABAQAADEhMaW5vAhAAAG1udHJSR0IgWFlaIAfOAAIACQAGADEAAGFjc3BNU0ZUAAAAAElFQyBzUkdCAAAAAAAAAAAAAAAAAAD21gABAAAAANMtSFAgIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEWNwcnQAAAFQAAAAM2Rlc2MAAAGEAAAAbHd0cHQAAAHwAAAAFGJrcHQAAAIEAAAAFHJYWVoAAAIYAAAAFGdYWVoAAAIsAAAAFGJYWVoAAAJAAAAAFGRtbmQAAAJUAAAAcGRtZGQAAALEAAAAiHZ1ZWQAAANMAAAAhnZpZXcAAAPUAAAAJGx1bWkAAAP4AAAAFG1lYXMAAAQMAAAAJHRlY2gAAAQwAAAADHJUUkMAAAQ8AAAIDGdUUkMAAAQ8AAAIDGJUUkMAAAQ8AAAIDHRleHQAAAAAQ29weXJpZ2h0IChjKSAxOTk4IEhld2xldHQtUGFja2FyZCBDb21w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">
							<?php } ?>
							<h2>Elybin CMS</h2>
							<p><?php echo lg('"Everything inside one bin, Elybin CMS"') ?></p>

							<?php if($usergroup > 0){  // if not have setting priv ?>
							<p class="text-muted">v.<?php echo $ELYBIN_VERSION?>.<?php echo $ELYBIN_BUILD?> (<?php echo $ELYBIN_SIGNATURE?>) - <?php echo $ELYBIN_RELEASE?></p>
							<?php }else{ ?>
							<a href="http://elybin.com" target="_blank">www.elybin.com</a>
							<?php } ?>
							<br/>
							<a href="https://www.twitter.com/elybincms" target="_blank"> <i class="fa fa-twitter"></i> @elybincms</a>&nbsp;&nbsp;
							<a href="https://www.facebook.com/elybincms" target="_blank"> <i class="fa fa-facebook-square"></i> Elybin CMS</a>&nbsp;&nbsp;
							<a href="https://www.github.com/elybin/ElybinCMS" target="_blank"> <i class="fa fa-github"></i> elybin/ElybinCMS</a>
						</div>
						<hr></hr>
						<h5 class="text-light-gray text-semibold text-s" style="margin:20px 0 10px 0;">ELYBIN CMS</h5>
						<table class="table no-border">
							<tbody>
								<tr>
									<td width="20%"><?php echo lg('First Author') ?></td>
									<td>Khakim A. <i>&#60;kim@elybin.com&#62;</i>  &nbsp;&nbsp;
										<a href="https://www.twitter.com/11jt" target="_blank"> <i class="fa fa-twitter"></i></a>&nbsp;&nbsp;
										<a href="https://www.instagram.com/khakimassidiqi" target="_blank"> <i class="fa fa-instagram"></i></a>&nbsp;&nbsp;
										<a href="http://kim.elybin.com" target="_blank"> <i class="fa fa-globe"></i></a>
									</td>
								</tr>
								<tr>
									<td width="20%"><?php echo lg('Started') ?></td>
									<td>19 June 2015 - <?php echo lg('Now') ?> </td>
								</tr>
								<tr>
									<td width="20%"><?php echo lg('Extra Component') ?></td>
									<td>Bootstrap, FontAwesome, jQuery UI, Morris.js, PHPMailer, Password Hash, Summernote, Bs-Markdown, X-Editable, Google Maps API, Animate.css, pclzip.lib, Some function from StackOverflow</td>
								</tr>
								<tr>
									<td width="20%"><?php echo lg('Inspiration') ?></td>
									<td>Wordpress, PopojiCMS, Android OS, Formulasi CMS, PhpMyAdmin, Blockbuster movie</td>
								</tr>
								<tr>
									<td width="20%"><?php echo lg('Thanks') ?></td>
									<td>
										<b><?php echo lg('Special') ?></b><br/>
										- Popoji CMS (<i>for database OOP</i>) <br/>
										- Formulasi CMS (<i>for unlimited motivation &amp; support</i>)<br/>
										- OnSite Corp (<i>for partnership</i>)<br/>
										- David Raka (<i>for awesome photograph</i>)<br/>
										- Klik Indonesia (<i>for website hosting</i>)<br/>
										- ICT Host (<i>for website hosting</i>)
										<br/>
										<br/>
										<b><?php echo lg('Developer / Translator') ?></b>
										<p>.... (<?php echo lg('Commit your name here...') ?>)</p>
										<br/>
										<b><?php _e('Elybin CMS Bug Hunter') ?> <i class="fa fa-bug"></i></b>
										<p>
										Atho Miftahudin (2 Bugs), Ade Pangestu (6 Bugs), Fadholi FH (27 Bugs), Andro Crash (1 Bug), Lehan Alfananhel (1 Bug), Afdhal Mahdi (1 Bug)<br/>
											.... (<?php echo lg('Commit your name here...') ?>)</p>
										<br/>
										<b><?php echo lg('Tester / Elybin Maniac ') ?></b>
										<p>
											Didot
											<br/>
											.... (<?php echo lg('Commit your name here...') ?>)</p>
										<span class="text-sm text-light-gray"><?php echo lg('*send us a lot of bug report to hi@elybin.com, and attach your name. Thanks for your participation.') ?></span>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<h3 class="text-center"><?php echo lg('If you <i class="fa fa-heart text-danger"></i> this apps, give us a little things whatever it just...') ?></h3>
										<br/>
										<br/>
										<div class="row">
											<div class="col-sm-3 text-center">
												<i class="fa fa-thumbs-o-up fa-5x"></i><br/>
												<i><?php echo lg('<b>Like & Share</b>. It\'s no problem, your share that keep our apps growing faster.') ?></i>
											</div>
											<div class="col-sm-3 text-center">
												<i class="fa fa-coffee fa-5x"></i><br/>
												<i><?php echo lg('<b>A Cup of Coffee</b>, Because sometimes we\'re feel thirsty and sleepy when writing thousands line of code.') ?></i>
											</div>
											<div class="col-sm-3 text-center">
												<i class="fa fa-cloud fa-5x"></i><br/>
												<i><?php echo lg('<b>Donating</b> this one is very useful, like to pay annual hosting+domain tax. Without a website, our code just treasure inside small computer.') ?></i>
											</div>
											<div class="col-sm-3 text-center">
												<i class="fa fa-smile-o fa-5x"></i><br/>
												<i><?php echo lg('<b>Help us to</b> develop/test this apps. To be more userful and open for everyone. Just E-mail us! ') ?></i>
											</div>
										</div>
										<br/>
										<div class="row">
											<div class="col-sm-12 text-center">
												<div>
												<style type="text/css">
												#share-buttons img {
												width: 35px;
												padding: 5px;
												border: 0;
												box-shadow: 0;
												display: inline;
												}

												</style>
												<!-- I got these buttons from elybin.com -->
												<div id="share-buttons">

												    <!-- Buffer -->
												    <a href="https://bufferapp.com/add?url=http://www.elybin.com&amp;text=Elybin CMS - Buat website jadi mudah dan cepat" target="_blank">
												        <img src="assets/images/buffer.png" alt="Buffer" />
												    </a>

												    <!-- Digg -->
												    <a href="http://www.digg.com/submit?url=http://www.elybin.com" target="_blank">
												        <img src="assets/images/diggit.png" alt="Digg" />
												    </a>

												    <!-- Email -->
												    <a href="mailto:?Subject=Elybin CMS - Buat website jadi mudah dan cepat&amp;Body=I%20saw%20this%20and%20thought%20of%20you!%20 https://elybin.com">
												        <img src="assets/images/email.png" alt="Email" />
												    </a>

												    <!-- Facebook -->
												    <a href="http://www.facebook.com/sharer.php?u=http://www.elybin.com" target="_blank">
												        <img src="assets/images/facebook.png" alt="Facebook" />
												    </a>

												    <!-- Google+ -->
												    <a href="https://plus.google.com/share?url=http://www.elybin.com" target="_blank">
												        <img src="assets/images/google.png" alt="Google" />
												    </a>

												    <!-- LinkedIn -->
												    <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=http://www.elybin.com" target="_blank">
												        <img src="assets/images/linkedin.png" alt="LinkedIn" />
												    </a>

												    <!-- Pinterest -->
												    <a href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());">
												        <img src="assets/images/pinterest.png" alt="Pinterest" />
												    </a>

												    <!-- Print -->
												    <a href="javascript:;" onclick="window.print()">
												        <img src="assets/images/print.png" alt="Print" />
												    </a>

												    <!-- Reddit -->
												    <a href="http://reddit.com/submit?url=http://www.elybin.com&amp;title=Elybin CMS - Buat website jadi mudah dan cepat" target="_blank">
												        <img src="assets/images/reddit.png" alt="Reddit" />
												    </a>

												    <!-- StumbleUpon-->
												    <a href="http://www.stumbleupon.com/submit?url=http://www.elybin.com&amp;title=Elybin CMS - Buat website jadi mudah dan cepat" target="_blank">
												        <img src="assets/images/stumbleupon.png" alt="StumbleUpon" />
												    </a>

												    <!-- Tumblr-->
												    <a href="http://www.tumblr.com/share/link?url=http://www.elybin.com&amp;title=Elybin CMS - Buat website jadi mudah dan cepat" target="_blank">
												        <img src="assets/images/tumblr.png" alt="Tumblr" />
												    </a>

												    <!-- Twitter -->
												    <a href="https://twitter.com/share?url=http://www.elybin.com&amp;name=Elybin CMS - Buat website jadi mudah dan cepat&amp;hashtags=elybin" target="_blank">
												        <img src="assets/images/twitter.png" alt="Twitter" />
												    </a>

												    <!-- VK -->
												    <a href="http://vkontakte.ru/share.php?url=http://www.elybin.com" target="_blank">
												        <img src="assets/images/vk.png" alt="VK" />
												    </a>

												    <!-- Yummly -->
												    <a href="http://www.yummly.com/urb/verify?url=http://www.elybin.com&amp;title=Elybin CMS - Buat website jadi mudah dan cepat" target="_blank">
												        <img src="assets/images/yummly.png" alt="Yummly" />
												    </a>

													<h4><?php echo lg('Share to help us keep this code running! say hi! ') ?> <a href="mailto:hi@elybin.com" class="text-danger" style="border-bottom: 1px dashed red">hi@elybin.com</a></h4>
													<i><?php echo lg('Proudly, Made in Indonesia') ?></i>

													</div>
												</div>
											</div>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div><!-- / .panel-body -->
				</div><!-- / .panel -->
			</div><!-- / .col -->
		</div><!-- / .row -->

<?php
		break;
}
}
?>

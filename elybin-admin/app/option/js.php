<?php
/* Javascript
 * Module: Option JS
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 - 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
@session_start();
if(empty($_SESSION['login'])){
	header('location: index.php');
}else{	
	@include_once('../../../elybin-core/elybin-function.php');
	@include_once('../../../elybin-core/elybin-oop.php');
	@include_once('../../lang/main.php');
	
	// get usergroup privilage/access from current user to this module
	$usergroup = _ug()->setting;

// give error if no have privilage
if($usergroup == 0){
	header('location:../403.html');
	exit;
}else{
	switch (@$_GET['act']) {
		case 'location': // case 'loc'
			$op = _op();
			if($op->site_coordinate == ""){
			  $op->site_coordinate  = "-7.396119962181347, 109.69514252969367";
			}
			$op->site_coordinate_ex  = explode(",", $op->site_coordinate );
?>
<!-- Javascript -->
<script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&amp;libraries=places'></script>
<script src="assets/javascripts/locationpicker.jquery.js"></script>
<script>
init.push(function () {  
  $('#tooltip a').tooltip();	
  ElybinLocationPicker(<?php echo $op->site_coordinate ?>, "app/option/proses.php?result=json");
});
</script>  
<!-- ./Javascript -->
<?php
			break;	
			
		default: // case default
?>
<!-- Optional javascripts -->
<script src="assets/javascripts/select2.min.js"></script>
<script src="assets/javascripts/bootstrap-editable.min.js"></script>
<script type="text/javascript">
<?php ob_start('minify_js'); ?>
init.push(function () {    
//turn to inline mode
//$.fn.editable = 'inline';
 
  //TEXT
  $('#site_url, #site_name, #site_phone, #site_owner, #site_email, #site_hero_title, #site_hero_subtitle, #social_twitter, #social_facebook, #social_instagram, #smtp_host, #smtp_port, #smtp_user, #smtp_pass, #mail_daily_limit').editable({
    type: 'text',
    pk: 'option',
    url: 'app/option/proses.php',
    success: function(data) {
		// decode json
		try {
			var data = $.parseJSON(data);
		}
		catch(e){
			// if failed to decode json
			$.growl.error({ title: "Failed to decode JSON!", message: e + "<br/><br/>" + data, duration: 10000 });
		}
		if(data.status == "ok"){
			// ok growl
			$.growl.notice({ title: data.title, message: data.isi });
		}
		else if(data.status == "error"){
			// error growl
			$.growl.warning({ title: data.title, message: data.isi });
		}
    }
  });
  
  //textarea
  $('#site_description, #site_office_address').editable({
    type: 'textarea',
    showbuttons: 'bottom',
    pk: 'option',
    url: 'app/option/proses.php',
    success: function(data) {
		// decode json
		try {
			var data = $.parseJSON(data);
		}
		catch(e){
			// if failed to decode json
			$.growl.error({ title: "Failed to decode JSON!", message: e + "<br/><br/>" + data, duration: 10000 });
		}
		if(data.status == "ok"){
			// ok growl
			$.growl.notice({ title: data.title, message: data.isi });
		}
		else if(data.status == "error"){
			// error growl
			$.growl.warning({ title: data.title, message: data.isi });
		}
    }
  });

  //multi select
  $('#site_keyword').editable({
    type: 'select2',
    pk: 'option',
    url: 'app/option/proses.php',
    select2: {
      tags: [''],
      tokenSeparators: [',', ' '],
      multiple: true
    },
    success: function(data) {
		// decode json
		try {
			var data = $.parseJSON(data);
		}
		catch(e){
			// if failed to decode json
			$.growl.error({ title: "Failed to decode JSON!", message: e + "<br/><br/>" + data, duration: 10000 });
		}
		if(data.status == "ok"){
			// ok growl
			$.growl.notice({ title: data.title, message: data.isi });
		}
		else if(data.status == "error"){
			// error growl
			$.growl.warning({ title: data.title, message: data.isi });
		}
    }
  });

  //select: allow deny
  $('#users_can_register').editable({
    type: 'select',
    showbuttons: false,
    pk: 'option',
    url: 'app/option/proses.php',
    source: [
      {value: 'allow', text: '<?php echo lg("Allow")?>'},
      {value: 'deny', text: '<?php echo lg("Deny")?>'}
    ],
    success: function(data) {
		// decode json
		try {
			var data = $.parseJSON(data);
		}
		catch(e){
			// if failed to decode json
			$.growl.error({ title: "Failed to decode JSON!", message: e + "<br/><br/>" + data, duration: 10000 });
		}
		if(data.status == "ok"){
			// ok growl
			$.growl.notice({ title: data.title, message: data.isi });
		}
		else if(data.status == "error"){
			// error growl
			$.growl.warning({ title: data.title, message: data.isi });
		}
    }
  });
  
  //select: allow deny confrim
  $('#default_comment_status').editable({
    type: 'select',
    showbuttons: false,
    pk: 'option',
    url: 'app/option/proses.php',
    source: [
      {value: 'allow', text: '<?php echo lg("Allow")?>'},
      {value: 'confrim', text: '<?php echo lg("Confrim")?>'},
      {value: 'deny', text: '<?php echo lg("Deny")?>'}
    ],
    success: function(data) {
		// decode json
		try {
			var data = $.parseJSON(data);
		}
		catch(e){
			// if failed to decode json
			$.growl.error({ title: "Failed to decode JSON!", message: e + "<br/><br/>" + data, duration: 10000 });
		}
		if(data.status == "ok"){
			// ok growl
			$.growl.notice({ title: data.title, message: data.isi });
		}
		else if(data.status == "error"){
			// error growl
			$.growl.warning({ title: data.title, message: data.isi });
		}
    }
  });
  
  //select: active deactive
  $('#maintenance_mode, #developer_mode, #smtp_status').editable({
    type: 'select',
    showbuttons: false,
    pk: 'option',
    url: 'app/option/proses.php',
    source: [
      {value: 'active', text: '<?php echo lg("Active")?>'},
      {value: 'deactive', text: '<?php echo lg("Inactive")?>'}
    ],
    success: function(data) {
		// decode json
		try {
			var data = $.parseJSON(data);
		}
		catch(e){
			// if failed to decode json
			$.growl.error({ title: "Failed to decode JSON!", message: e + "<br/><br/>" + data, duration: 10000 });
		}
		if(data.status == "ok"){
			// ok growl
			$.growl.notice({ title: data.title, message: data.isi });
		}
		else if(data.status == "error"){
			// error growl
			$.growl.warning({ title: data.title, message: data.isi });
		}
    }
  });

  //select: first last
  $('#short_name').editable({
    type: 'select',
    showbuttons: false,
    pk: 'option',
    url: 'app/option/proses.php',
    source: [
      {value: 'first', text: '<?php echo lg("First")?>'},
      {value: 'last', text: '<?php echo lg("Last")?>'}
    ],
    success: function(data) {
		// decode json
		try {
			var data = $.parseJSON(data);
		}
		catch(e){
			// if failed to decode json
			$.growl.error({ title: "Failed to decode JSON!", message: e + "<br/><br/>" + data, duration: 10000 });
		}
		if(data.status == "ok"){
			// ok growl
			$.growl.notice({ title: data.title, message: data.isi });
		}
		else if(data.status == "error"){
			// error growl
			$.growl.warning({ title: data.title, message: data.isi });
		}
    }
  });

  //select: text editor
  $('#text_editor').editable({
    type: 'select',
    showbuttons: false,
    pk: 'option',
    url: 'app/option/proses.php',
    source: [
      {value: 'summernote', text: 'Summernote WYSIWYG'},
      {value: 'bs-markdown', text: 'Bootstrap Markdown'}
    ],
    success: function(data) {
		// decode json
		try {
			var data = $.parseJSON(data);
		}
		catch(e){
			// if failed to decode json
			$.growl.error({ title: "Failed to decode JSON!", message: e + "<br/><br/>" + data, duration: 10000 });
		}
		if(data.status == "ok"){
			// ok growl
			$.growl.notice({ title: data.title, message: data.isi });
		}
		else if(data.status == "error"){
			// error growl
			$.growl.warning({ title: data.title, message: data.isi });
		}
    }
  });

  //select: number
  $('#posts_per_page').editable({
    type: 'select',
    showbuttons: false,
    pk: 'option',
    url: 'app/option/proses.php',
    source: [
      {value: 1, text: '1 <?php echo lg("Posts")?>'},
      {value: 2, text: '2 <?php echo lg("Posts")?>'},
      {value: 3, text: '3 <?php echo lg("Posts")?>'},
      {value: 4, text: '4 <?php echo lg("Posts")?>'},
      {value: 5, text: '5 <?php echo lg("Posts")?>'}
    ],
    success: function(data) {
		// decode json
		try {
			var data = $.parseJSON(data);
		}
		catch(e){
			// if failed to decode json
			$.growl.error({ title: "Failed to decode JSON!", message: e + "<br/><br/>" + data, duration: 10000 });
		}
		if(data.status == "ok"){
			// ok growl
			$.growl.notice({ title: data.title, message: data.isi });
		}
		else if(data.status == "error"){
			// error growl
			$.growl.warning({ title: data.title, message: data.isi });
		}
    }
  });

  //select: category
  $('#default_category').editable({
    type: 'select',
    showbuttons: false,
    pk: 'option',
    url: 'app/option/proses.php',
    source: [
    <?php
      $tbl = new ElybinTable('elybin_category');
      $cat = $tbl->SelectWhere('status','active','','');
      $category = "\r";
      foreach($cat as $c){
        $category .= "\t\t\t\t{value: $c->category_id, text: '$c->name'},\r\n";
      }
      echo ltrim(rtrim($category,",\r\n"),"\t\t")."\r\n";
    ?>

    ],
    success: function(data) {
		// decode json
		try {
			var data = $.parseJSON(data);
		}
		catch(e){
			// if failed to decode json
			$.growl.error({ title: "Failed to decode JSON!", message: e + "<br/><br/>" + data, duration: 10000 });
		}
		if(data.status == "ok"){
			// ok growl
			$.growl.notice({ title: data.title, message: data.isi });
		}
		else if(data.status == "error"){
			// error growl
			$.growl.warning({ title: data.title, message: data.isi });
		}
    }
  });
  
  //select: default homepage
  $('#default_homepage').editable({
    type: 'select',
    showbuttons: false,
    pk: 'option',
    url: 'app/option/proses.php',
    source: [
    <?php
      $tbmn = new ElybinTable('elybin_menu');
      $mn = $tbmn->Select('','');
      $menu = "\r";
      foreach($mn as $m){
        $menu .= "\t\t\t\t{value: $m->menu_id, text: '$m->menu_title'},\r\n";
      }
      echo ltrim(rtrim($menu,",\r\n"),"\t\t")."\r\n";
    ?>

    ],
    success: function(data) {
		// decode json
		try {
			var data = $.parseJSON(data);
		}
		catch(e){
			// if failed to decode json
			$.growl.error({ title: "Failed to decode JSON!", message: e + "<br/><br/>" + data, duration: 10000 });
		}
		if(data.status == "ok"){
			// ok growl
			$.growl.notice({ title: data.title, message: data.isi });
		}
		else if(data.status == "error"){
			// error growl
			$.growl.warning({ title: data.title, message: data.isi });
		}
    }
  });
  
  //select: timezone
  $('#timezone').editable({
    type: 'select',
    showbuttons: false,
    pk: 'option',
    url: 'app/option/proses.php',
    source: [
      {value: 'Pacific/Midway', text: '(GMT-11:00) Midway Island'}, {value: 'US/Samoa', text: '(GMT-11:00) Samoa'}, {value: 'US/Hawaii', text: '(GMT-10:00) Hawaii'}, {value: 'US/Alaska', text: '(GMT-09:00) Alaska'}, {value: 'US/Pacific', text: '(GMT-08:00) Pacific Time (US & Canada)'}, {value: 'America/Tijuana', text: '(GMT-08:00) Tijuana'}, {value: 'US/Arizona', text: '(GMT-07:00) Arizona'}, {value: 'US/Mountain', text: '(GMT-07:00) Mountain Time (US & Canada)'}, {value: 'America/Chihuahua', text: '(GMT-07:00) Chihuahua'}, {value: 'America/Mazatlan', text: '(GMT-07:00) Mazatlan'}, {value: 'America/Mexico_City', text: '(GMT-06:00) Mexico City'}, {value: 'America/Monterrey', text: '(GMT-06:00) Monterrey'}, {value: 'Canada/Saskatchewan', text: '(GMT-06:00) Saskatchewan'}, {value: 'US/Central', text: '(GMT-06:00) Central Time (US & Canada)'}, {value: 'US/Eastern', text: '(GMT-05:00) Eastern Time (US & Canada)'}, {value: 'US/East-Indiana', text: '(GMT-05:00) Indiana (East)'}, {value: 'America/Bogota', text: '(GMT-05:00) Bogota'}, {value: 'America/Lima', text: '(GMT-05:00) Lima'}, {value: 'America/Caracas', text: '(GMT-04:30) Caracas'}, {value: 'Canada/Atlantic', text: '(GMT-04:00) Atlantic Time (Canada)'}, {value: 'America/La_Paz', text: '(GMT-04:00) La Paz'}, {value: 'America/Santiago', text: '(GMT-04:00) Santiago'}, {value: 'Canada/Newfoundland', text: '(GMT-03:30) Newfoundland'}, {value: 'America/Buenos_Aires', text: '(GMT-03:00) Buenos Aires'}, {value: 'Greenland', text: '(GMT-03:00) Greenland'}, {value: 'Atlantic/Stanley', text: '(GMT-02:00) Stanley'}, {value: 'Atlantic/Azores', text: '(GMT-01:00) Azores'}, {value: 'Atlantic/Cape_Verde', text: '(GMT-01:00) Cape Verde Is.'}, {value: 'Africa/Casablanca', text: '(GMT) Casablanca'}, {value: 'Europe/Dublin', text: '(GMT) Dublin'}, {value: 'Europe/Lisbon', text: '(GMT) Lisbon'}, {value: 'Europe/London', text: '(GMT) London'}, {value: 'Africa/Monrovia', text: '(GMT) Monrovia'}, {value: 'Europe/Amsterdam', text: '(GMT+01:00) Amsterdam'}, {value: 'Europe/Belgrade', text: '(GMT+01:00) Belgrade'}, {value: 'Europe/Berlin', text: '(GMT+01:00) Berlin'}, {value: 'Europe/Bratislava', text: '(GMT+01:00) Bratislava'}, {value: 'Europe/Brussels', text: '(GMT+01:00) Brussels'}, {value: 'Europe/Budapest', text: '(GMT+01:00) Budapest'}, {value: 'Europe/Copenhagen', text: '(GMT+01:00) Copenhagen'}, {value: 'Europe/Ljubljana', text: '(GMT+01:00) Ljubljana'}, {value: 'Europe/Madrid', text: '(GMT+01:00) Madrid'}, {value: 'Europe/Paris', text: '(GMT+01:00) Paris'}, {value: 'Europe/Prague', text: '(GMT+01:00) Prague'}, {value: 'Europe/Rome', text: '(GMT+01:00) Rome'}, {value: 'Europe/Sarajevo', text: '(GMT+01:00) Sarajevo'}, {value: 'Europe/Skopje', text: '(GMT+01:00) Skopje'}, {value: 'Europe/Stockholm', text: '(GMT+01:00) Stockholm'}, {value: 'Europe/Vienna', text: '(GMT+01:00) Vienna'}, {value: 'Europe/Warsaw', text: '(GMT+01:00) Warsaw'}, {value: 'Europe/Zagreb', text: '(GMT+01:00) Zagreb'}, {value: 'Europe/Athens', text: '(GMT+02:00) Athens'}, {value: 'Europe/Bucharest', text: '(GMT+02:00) Bucharest'}, {value: 'Africa/Cairo', text: '(GMT+02:00) Cairo'}, {value: 'Africa/Harare', text: '(GMT+02:00) Harare'}, {value: 'Europe/Helsinki', text: '(GMT+02:00) Helsinki'}, {value: 'Europe/Istanbul', text: '(GMT+02:00) Istanbul'}, {value: 'Asia/Jerusalem', text: '(GMT+02:00) Jerusalem'}, {value: 'Europe/Kiev', text: '(GMT+02:00) Kyiv'}, {value: 'Europe/Minsk', text: '(GMT+02:00) Minsk'}, {value: 'Europe/Riga', text: '(GMT+02:00) Riga'}, {value: 'Europe/Sofia', text: '(GMT+02:00) Sofia'}, {value: 'Europe/Tallinn', text: '(GMT+02:00) Tallinn'}, {value: 'Europe/Vilnius', text: '(GMT+02:00) Vilnius'}, {value: 'Asia/Baghdad', text: '(GMT+03:00) Baghdad'}, {value: 'Asia/Kuwait', text: '(GMT+03:00) Kuwait'}, {value: 'Africa/Nairobi', text: '(GMT+03:00) Nairobi'}, {value: 'Asia/Riyadh', text: '(GMT+03:00) Riyadh'}, {value: 'Asia/Tehran', text: '(GMT+03:30) Tehran'}, {value: 'Europe/Moscow', text: '(GMT+04:00) Moscow'}, {value: 'Asia/Baku', text: '(GMT+04:00) Baku'}, {value: 'Europe/Volgograd', text: '(GMT+04:00) Volgograd'}, {value: 'Asia/Muscat', text: '(GMT+04:00) Muscat'}, {value: 'Asia/Tbilisi', text: '(GMT+04:00) Tbilisi'}, {value: 'Asia/Yerevan', text: '(GMT+04:00) Yerevan'}, {value: 'Asia/Kabul', text: '(GMT+04:30) Kabul'}, {value: 'Asia/Karachi', text: '(GMT+05:00) Karachi'}, {value: 'Asia/Tashkent', text: '(GMT+05:00) Tashkent'}, {value: 'Asia/Kolkata', text: '(GMT+05:30) Kolkata'}, {value: 'Asia/Kathmandu', text: '(GMT+05:45) Kathmandu'}, {value: 'Asia/Yekaterinburg', text: '(GMT+06:00) Ekaterinburg'}, {value: 'Asia/Almaty', text: '(GMT+06:00) Almaty'}, {value: 'Asia/Dhaka', text: '(GMT+06:00) Dhaka'}, {value: 'Asia/Novosibirsk', text: '(GMT+07:00) Novosibirsk'}, {value: 'Asia/Bangkok', text: '(GMT+07:00) Bangkok'}, {value: 'Asia/Jakarta', text: '(GMT+07:00) Jakarta'}, {value: 'Asia/Krasnoyarsk', text: '(GMT+08:00) Krasnoyarsk'}, {value: 'Asia/Chongqing', text: '(GMT+08:00) Chongqing'}, {value: 'Asia/Hong_Kong', text: '(GMT+08:00) Hong Kong'}, {value: 'Asia/Kuala_Lumpur', text: '(GMT+08:00) Kuala Lumpur'}, {value: 'Australia/Perth', text: '(GMT+08:00) Perth'}, {value: 'Asia/Singapore', text: '(GMT+08:00) Singapore'}, {value: 'Asia/Taipei', text: '(GMT+08:00) Taipei'}, {value: 'Asia/Ulaanbaatar', text: '(GMT+08:00) Ulaan Bataar'}, {value: 'Asia/Urumqi', text: '(GMT+08:00) Urumqi'}, {value: 'Asia/Irkutsk', text: '(GMT+09:00) Irkutsk'}, {value: 'Asia/Seoul', text: '(GMT+09:00) Seoul'}, {value: 'Asia/Tokyo', text: '(GMT+09:00) Tokyo'}, {value: 'Australia/Adelaide', text: '(GMT+09:30) Adelaide'}, {value: 'Australia/Darwin', text: '(GMT+09:30) Darwin'}, {value: 'Asia/Yakutsk', text: '(GMT+10:00) Yakutsk'}, {value: 'Australia/Brisbane', text: '(GMT+10:00) Brisbane'}, {value: 'Australia/Canberra', text: '(GMT+10:00) Canberra'}, {value: 'Pacific/Guam', text: '(GMT+10:00) Guam'}, {value: 'Australia/Hobart', text: '(GMT+10:00) Hobart'}, {value: 'Australia/Melbourne', text: '(GMT+10:00) Melbourne'}, {value: 'Pacific/Port_Moresby', text: '(GMT+10:00) Port Moresby'}, {value: 'Australia/Sydney', text: '(GMT+10:00) Sydney'}, {value: 'Asia/Vladivostok', text: '(GMT+11:00) Vladivostok'}, {value: 'Asia/Magadan', text: '(GMT+12:00) Magadan'}, {value: 'Pacific/Auckland', text: '(GMT+12:00) Auckland'}, {value: 'Pacific/Fiji', text: '(GMT+12:00) Fiji'}
    ],
    success: function(data) {
		// decode json
		try {
			var data = $.parseJSON(data);
		}
		catch(e){
			// if failed to decode json
			$.growl.error({ title: "Failed to decode JSON!", message: e + "<br/><br/>" + data, duration: 10000 });
		}
		if(data.status == "ok"){
			// ok growl
			$.growl.notice({ title: data.title, message: data.isi });
		}
		else if(data.status == "error"){
			// error growl
			$.growl.warning({ title: data.title, message: data.isi });
		}
    }
  });

  //select: language
  $('#language').editable({
    type: 'select',
    showbuttons: false,
    pk: 'option',
    url: 'app/option/proses.php',
    source: 
    <?php
    // get available language
	// scan `elybin-core/lang` directory
	$dir = scandir("../elybin-core/lang");
	$lg_found = false;
	$lg_name = array();
	foreach($dir as $d){
		if(substr($d, 2, 1) == '-'){
			array_push($lg_name, 
				array(
					'value' => $d,
					'text' => $d
				)
			);
			$lg_found = true;
		}
	}
	echo json_encode($lg_name);
    ?>,
    success: function(data) {
		// decode json
		try {
			var data = $.parseJSON(data);
		}
		catch(e){
			// if failed to decode json
			$.growl.error({ title: "Failed to decode JSON!", message: e + "<br/><br/>" + data, duration: 10000 });
		}
		if(data.status == "ok"){
			// ok growl
			$.growl.notice({ title: data.title, message: data.isi });
		}
		else if(data.status == "error"){
			// error growl
			$.growl.warning({ title: data.title, message: data.isi });
		}
    }
  });

  //image upload
  $('#file-style, #file-style2, #file-style3').pixelFileInput({ placeholder: '<?php echo lg("Select file...")?>' });
  $('#site_logo').popover();
  $('#tooltip a').tooltip();  $('#tooltipl').tooltip(); 

  ElybinHideShow('site_logo','site_logo_img');
  ElybinHideShow('site_favicon','site_favicon_img');
  ElybinHideShow('site_hero','site_hero_img');
});
<?php ob_end_flush(); ?>
</script>
<?php		
			break;
	}
  }
}
?>
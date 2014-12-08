<?php
function ElybinRedirect($url)
{
    if (!headers_sent())
    {    
        header('Location: '.$url);
        exit;
        }
    else
        {  
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>'; exit;
    }
}

class ElybinValidasi{
	function __construct(){}
	function xss($str){
				$str = htmlspecialchars($str);
				return $str;
	}
	function sql($str){	
				$rms = array("'","`","=",'"',"@","<",">","*");
				$str = str_replace($rms, '', $str);
				$str = stripcslashes($str);	
				$str = htmlspecialchars($str);
				return $str;
	}
}



class Paging{
	function cariPosisi($batas){
		if(empty($_GET['page'])){
			$posisi=0;
			$_GET['page']=1;
		}else{
			$posisi = ($_GET['page']-1) * $batas;
		}
		return $posisi;
	}

	function jumlahHalaman($jmldata, $batas){
		$jmlhalaman = ceil($jmldata/$batas);
		return $jmlhalaman;
	}

	function navHalaman($halaman_aktif, $jmlhalaman, $id, $mod, $title, $num){
		$link_halaman = "";

		if($halaman_aktif > 1){
			$prev = $halaman_aktif-1;
			$link_halaman .= "<li><a href='page-$prev-$mod-$id-$title.html'>Prev</a></li>";
		}else{
			$link_halaman .= "<li class='disabled'><a>Prev</a></li>";
		}

		if($num == "1"){
			$angka = ($halaman_aktif > 3 ? "<li class='disabled'><a>...</a></li>" : " ");
			for ($i=$halaman_aktif-2; $i<$halaman_aktif; $i++){
				if ($i < 1)
				continue;
				$angka .= "<li><a href='page-$i-$mod-$id-$title.html'>$i</a></li>";
			}
			$angka .= "<li class='active'><a>$halaman_aktif</a></li>";
			for($i=$halaman_aktif+1; $i<($halaman_aktif+3); $i++){
				if($i > $jmlhalaman)
				break;
				$angka .= "<li><a href='page-$i-$mod-$id-$title.html'>$i</a></li>";
			}
			$angka .= ($halaman_aktif+2<$jmlhalaman ? "<li class='disabled'><a>...</a></li><li><a href='page-$jmlhalaman-$mod-$id-$title.html'>$jmlhalaman</a></li>" : " ");
			$link_halaman .= "$angka";
		}

		if($halaman_aktif < $jmlhalaman){
			$next = $halaman_aktif+1;
			$link_halaman .= "<li><a href='page-$next-$mod-$id-$title.html'>Next</a></li>";
		}else{
			$link_halaman .= "<li class='disabled'><a>Next</a></li>";
		}
		return $link_halaman;
	}
}

// function textdash
function textdash($s){
	$result = '<span class="text-dash">'.$s.'</span>';
	return $result;
}
function seo_title($s) {
    $c = array (' ');
    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');
    $s = str_replace($d, '', $s);
    $s = strtolower(str_replace($c, '-', $s));
    return $s;
}
function keyword_filter($w){
    $d = array ('dan', 'yang', 'for', 'to');
	$w = str_replace($d, '', $w);
	$w =  array_slice(explode(" ",$w), 0, 10);
	$wj = '';
	foreach ($w as $wx) {
		if($wx!=''){
			$wj .= seo_title($wx).", ";
		}
	}
	$wj = rtrim($wj, ", ");
    return $wj;
}
function UploadImage($fupload_name,$mod){
	//include  lang 
	include('../../../elybin-admin/lang/main.php');

	$vdir_upload = "../../../elybin-file/$mod/";
	$vfile_upload = $vdir_upload . $fupload_name;

	if($_FILES["image"]["type"]=="image/jpeg"){
		$im_src = @imagecreatefromjpeg($_FILES["image"]["tmp_name"]) or die("error,$lg_error,$lg_invalidimages");

		@move_uploaded_file($_FILES["image"]["tmp_name"], $vfile_upload) or die("error,$lg_error,$lg_failedmoveimage");

		$src_width = imageSX($im_src);
		$src_height = imageSY($im_src);

		$dst_width = 390;
		$dst_height = ($dst_width/$src_width)*$src_height;
		$im = imagecreatetruecolor($dst_width,$dst_height);
		imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
		imagejpeg($im,$vdir_upload . "medium-" . $fupload_name);

		imagedestroy($im_src);
		imagedestroy($im);
	}
	elseif($_FILES["image"]["type"]=="image/png"){
		@move_uploaded_file($_FILES["image"]["tmp_name"], $vfile_upload) or die("error,$lg_error,$lg_failedmoveimage");
		resize(300,$vdir_upload . "medium-" . $fupload_name,$vfile_upload);
	}
	elseif($_FILES["image"]["type"]=="image/gif"){
		@move_uploaded_file($_FILES["image"]["tmp_name"], $vfile_upload) or die("error,$lg_error,$lg_failedmoveimage");
		resize(300,$vdir_upload . "medium-" . $fupload_name,$vfile_upload);
	}
}
function resize($newWidth, $targetFile, $originalFile) {

    $info = getimagesize($originalFile);
    $mime = $info['mime'];

    switch ($mime) {
            case 'image/jpeg':
                    $image_create_func = 'imagecreatefromjpeg';
                    $image_save_func = 'imagejpeg';
                    $new_image_ext = 'jpg';
                    break;

            case 'image/png':
                    $image_create_func = 'imagecreatefrompng';
                    $image_save_func = 'imagepng';
                    $new_image_ext = 'png';
                    break;

            case 'image/gif':
                    $image_create_func = 'imagecreatefromgif';
                    $image_save_func = 'imagegif';
                    $new_image_ext = 'gif';
                    break;

            default: 
                    throw Exception('Unknown image type.');
    }

    $img = $image_create_func($originalFile);
    list($width, $height) = getimagesize($originalFile);

    $newHeight = ($height / $width) * $newWidth;
    $tmp = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    if (file_exists($targetFile)) {
            unlink($targetFile);
    }
    $image_save_func($tmp, "$targetFile");
}
function UploadFile($fupload_name,$mod){
	$vdir_upload = "../../../elybin-file/$mod/";
	$vfile_upload = $vdir_upload . $fupload_name;

	move_uploaded_file($_FILES["file"]["tmp_name"], $vfile_upload);
}
function UploadPlugin($fupload_name){
	$vdir_upload = "../../tmp/";
	$vfile_upload = $vdir_upload . $fupload_name;

	move_uploaded_file($_FILES["plugin_file"]["tmp_name"], $vfile_upload);
}
function UploadTheme($fupload_name){
	$vdir_upload = "../../tmp/";
	$vfile_upload = $vdir_upload . $fupload_name;

	move_uploaded_file($_FILES["theme_file"]["tmp_name"], $vfile_upload);
}
function ExtractPlugin($fzip){
	$vdir_upload = "../../tmp/";
	$vfile_upload = $vdir_upload . $fupload_name;
	$destination_dir = "../../app/";

	$archive = new PclZip($file);
	if ($archive->extract(PCLZIP_OPT_PATH, $destination_dir) == 0){
		unlink("../../../po-content/po-upload/$nama_file_unik");
		header('location:../../404.php');
	}
}

function deleteDir($dirname) {
	// Sanity check
    if (!file_exists($dirname)) {
        return false;
    }
    // Simple delete for a file
    if (is_file($dirname) || is_link($dirname)) {
        return unlink($dirname);
    }
    // Create and iterate stack
    $stack = array($dirname);
    while ($entry = array_pop($stack)) {
        // Watch for symlinks
        if (is_link($entry)) {
            unlink($entry);
            continue;
        }
        // Attempt to remove the directory
        if (@rmdir($entry)) {
            continue;
        }
        // Otherwise add it to the stack
        $stack[] = $entry;
        $dh = opendir($entry);
        while (false !== $child = readdir($dh)) {
            // Ignore pointers
            if ($child === '.' || $child === '..') {
                continue;
            }
            // Unlink files and add directories to stack
            $child = $entry . DIRECTORY_SEPARATOR . $child;
            if (is_dir($child) && !is_link($child)) {
                $stack[] = $child;
            } else {
                unlink($child);
            }
        }
        closedir($dh);
        //print_r($stack);
    }
    return true;
}

function time_elapsed_string($datetime, $full = false) {
	settzone();
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
function settzone(){
	$tbl = new ElybinTable("elybin_options");
	$gset = $tbl->SelectWhere('name','timezone','','');
	$gset = $gset->current();

	$tzone = $gset->value;
	date_default_timezone_set($tzone);
}
function friendly_date($date){
	$date = explode("-", $date);
	$date = date("d F Y",mktime(0,0,0,$date[1],$date[2],$date[0]));
	return $date;
}
function rename_timezone($old){
	$timezones = array(
	    'Pacific/Midway'       => "(GMT-11:00) Midway Island",
	    'US/Samoa'             => "(GMT-11:00) Samoa",
	    'US/Hawaii'            => "(GMT-10:00) Hawaii",
	    'US/Alaska'            => "(GMT-09:00) Alaska",
	    'US/Pacific'           => "(GMT-08:00) Pacific Time (US &amp; Canada)",
	    'America/Tijuana'      => "(GMT-08:00) Tijuana",
	    'US/Arizona'           => "(GMT-07:00) Arizona",
	    'US/Mountain'          => "(GMT-07:00) Mountain Time (US &amp; Canada)",
	    'America/Chihuahua'    => "(GMT-07:00) Chihuahua",
	    'America/Mazatlan'     => "(GMT-07:00) Mazatlan",
	    'America/Mexico_City'  => "(GMT-06:00) Mexico City",
	    'America/Monterrey'    => "(GMT-06:00) Monterrey",
	    'Canada/Saskatchewan'  => "(GMT-06:00) Saskatchewan",
	    'US/Central'           => "(GMT-06:00) Central Time (US &amp; Canada)",
	    'US/Eastern'           => "(GMT-05:00) Eastern Time (US &amp; Canada)",
	    'US/East-Indiana'      => "(GMT-05:00) Indiana (East)",
	    'America/Bogota'       => "(GMT-05:00) Bogota",
	    'America/Lima'         => "(GMT-05:00) Lima",
	    'America/Caracas'      => "(GMT-04:30) Caracas",
	    'Canada/Atlantic'      => "(GMT-04:00) Atlantic Time (Canada)",
	    'America/La_Paz'       => "(GMT-04:00) La Paz",
	    'America/Santiago'     => "(GMT-04:00) Santiago",
	    'Canada/Newfoundland'  => "(GMT-03:30) Newfoundland",
	    'America/Buenos_Aires' => "(GMT-03:00) Buenos Aires",
	    'Greenland'            => "(GMT-03:00) Greenland",
	    'Atlantic/Stanley'     => "(GMT-02:00) Stanley",
	    'Atlantic/Azores'      => "(GMT-01:00) Azores",
	    'Atlantic/Cape_Verde'  => "(GMT-01:00) Cape Verde Is.",
	    'Africa/Casablanca'    => "(GMT) Casablanca",
	    'Europe/Dublin'        => "(GMT) Dublin",
	    'Europe/Lisbon'        => "(GMT) Lisbon",
	    'Europe/London'        => "(GMT) London",
	    'Africa/Monrovia'      => "(GMT) Monrovia",
	    'Europe/Amsterdam'     => "(GMT+01:00) Amsterdam",
	    'Europe/Belgrade'      => "(GMT+01:00) Belgrade",
	    'Europe/Berlin'        => "(GMT+01:00) Berlin",
	    'Europe/Bratislava'    => "(GMT+01:00) Bratislava",
	    'Europe/Brussels'      => "(GMT+01:00) Brussels",
	    'Europe/Budapest'      => "(GMT+01:00) Budapest",
	    'Europe/Copenhagen'    => "(GMT+01:00) Copenhagen",
	    'Europe/Ljubljana'     => "(GMT+01:00) Ljubljana",
	    'Europe/Madrid'        => "(GMT+01:00) Madrid",
	    'Europe/Paris'         => "(GMT+01:00) Paris",
	    'Europe/Prague'        => "(GMT+01:00) Prague",
	    'Europe/Rome'          => "(GMT+01:00) Rome",
	    'Europe/Sarajevo'      => "(GMT+01:00) Sarajevo",
	    'Europe/Skopje'        => "(GMT+01:00) Skopje",
	    'Europe/Stockholm'     => "(GMT+01:00) Stockholm",
	    'Europe/Vienna'        => "(GMT+01:00) Vienna",
	    'Europe/Warsaw'        => "(GMT+01:00) Warsaw",
	    'Europe/Zagreb'        => "(GMT+01:00) Zagreb",
	    'Europe/Athens'        => "(GMT+02:00) Athens",
	    'Europe/Bucharest'     => "(GMT+02:00) Bucharest",
	    'Africa/Cairo'         => "(GMT+02:00) Cairo",
	    'Africa/Harare'        => "(GMT+02:00) Harare",
	    'Europe/Helsinki'      => "(GMT+02:00) Helsinki",
	    'Europe/Istanbul'      => "(GMT+02:00) Istanbul",
	    'Asia/Jerusalem'       => "(GMT+02:00) Jerusalem",
	    'Europe/Kiev'          => "(GMT+02:00) Kyiv",
	    'Europe/Minsk'         => "(GMT+02:00) Minsk",
	    'Europe/Riga'          => "(GMT+02:00) Riga",
	    'Europe/Sofia'         => "(GMT+02:00) Sofia",
	    'Europe/Tallinn'       => "(GMT+02:00) Tallinn",
	    'Europe/Vilnius'       => "(GMT+02:00) Vilnius",
	    'Asia/Baghdad'         => "(GMT+03:00) Baghdad",
	    'Asia/Kuwait'          => "(GMT+03:00) Kuwait",
	    'Africa/Nairobi'       => "(GMT+03:00) Nairobi",
	    'Asia/Riyadh'          => "(GMT+03:00) Riyadh",
	    'Asia/Tehran'          => "(GMT+03:30) Tehran",
	    'Europe/Moscow'        => "(GMT+04:00) Moscow",
	    'Asia/Baku'            => "(GMT+04:00) Baku",
	    'Europe/Volgograd'     => "(GMT+04:00) Volgograd",
	    'Asia/Muscat'          => "(GMT+04:00) Muscat",
	    'Asia/Tbilisi'         => "(GMT+04:00) Tbilisi",
	    'Asia/Yerevan'         => "(GMT+04:00) Yerevan",
	    'Asia/Kabul'           => "(GMT+04:30) Kabul",
	    'Asia/Karachi'         => "(GMT+05:00) Karachi",
	    'Asia/Tashkent'        => "(GMT+05:00) Tashkent",
	    'Asia/Kolkata'         => "(GMT+05:30) Kolkata",
	    'Asia/Kathmandu'       => "(GMT+05:45) Kathmandu",
	    'Asia/Yekaterinburg'   => "(GMT+06:00) Ekaterinburg",
	    'Asia/Almaty'          => "(GMT+06:00) Almaty",
	    'Asia/Dhaka'           => "(GMT+06:00) Dhaka",
	    'Asia/Novosibirsk'     => "(GMT+07:00) Novosibirsk",
	    'Asia/Bangkok'         => "(GMT+07:00) Bangkok",
	    'Asia/Jakarta'         => "(GMT+07:00) Jakarta",
	    'Asia/Krasnoyarsk'     => "(GMT+08:00) Krasnoyarsk",
	    'Asia/Chongqing'       => "(GMT+08:00) Chongqing",
	    'Asia/Hong_Kong'       => "(GMT+08:00) Hong Kong",
	    'Asia/Kuala_Lumpur'    => "(GMT+08:00) Kuala Lumpur",
	    'Australia/Perth'      => "(GMT+08:00) Perth",
	    'Asia/Singapore'       => "(GMT+08:00) Singapore",
	    'Asia/Taipei'          => "(GMT+08:00) Taipei",
	    'Asia/Ulaanbaatar'     => "(GMT+08:00) Ulaan Bataar",
	    'Asia/Urumqi'          => "(GMT+08:00) Urumqi",
	    'Asia/Irkutsk'         => "(GMT+09:00) Irkutsk",
	    'Asia/Seoul'           => "(GMT+09:00) Seoul",
	    'Asia/Tokyo'           => "(GMT+09:00) Tokyo",
	    'Australia/Adelaide'   => "(GMT+09:30) Adelaide",
	    'Australia/Darwin'     => "(GMT+09:30) Darwin",
	    'Asia/Yakutsk'         => "(GMT+10:00) Yakutsk",
	    'Australia/Brisbane'   => "(GMT+10:00) Brisbane",
	    'Australia/Canberra'   => "(GMT+10:00) Canberra",
	    'Pacific/Guam'         => "(GMT+10:00) Guam",
	    'Australia/Hobart'     => "(GMT+10:00) Hobart",
	    'Australia/Melbourne'  => "(GMT+10:00) Melbourne",
	    'Pacific/Port_Moresby' => "(GMT+10:00) Port Moresby",
	    'Australia/Sydney'     => "(GMT+10:00) Sydney",
	    'Asia/Vladivostok'     => "(GMT+11:00) Vladivostok",
	    'Asia/Magadan'         => "(GMT+12:00) Magadan",
	    'Pacific/Auckland'     => "(GMT+12:00) Auckland",
	    'Pacific/Fiji'         => "(GMT+12:00) Fiji",
	);
	echo in_array($old, $timezones);
}

function ok($s){

	echo '<div class="alert alert-success alert-dark">'.$s.'</div>';
}
function er($s){

	echo '<div class="alert alert-danger alert-dark no-margin">'.$s.'</div>';
}

function now(){
	return date("Y-m-d");
}

function json($s){
	$a = "";
	foreach ($s as $s) {
		//$a = $a.'"'.$s.'",';
		$a = $a.$s.',';
	}

	$a = rtrim($a,",");
	echo "{$a}";
}

// Function to get the client IP address
function client_info($ip) {
	if($ip == "yes"){
		$i = "IP: ".$_SERVER['REMOTE_ADDR'];
	}else{
		$i = "";
		$i .= "IP Address: ".$_SERVER['REMOTE_ADDR']."</br>";
		$i .= "User-Agent: ".$_SERVER['HTTP_USER_AGENT']."</br>";
		$i .= "Referer: ".$_SERVER['HTTP_REFERER']."</br>";
    }
	return $i;
}

// Push Notification
function notif_push($code, $title, $value, $type, $icon){
	settzone();
	if(empty($icon)){
		$icon = 'fa-info';
	}
	elseif(empty($type)){
		$type = 'info';
	}
	elseif(empty($code)){
		$code = 'general';
		$title = $lg_general;
	}

	//insert to notification
	$tbln = new ElybinTable("elybin_notification");
	$data = array(
		'notif_code'=> $code,
		'title'=> $title,
		'value'=> $value,
		'date'=>date("Y-m-d"),
		'time'=>date("H:i:s"),
		'type'=> $type,
		'icon'=> $icon
	);
	$tbln->Insert($data);
}

// Push Notification II
function pushnotif($data){
	settzone();
	// generate module 
	if(empty($data['module'])){
		$data['module'] = "general";
	}
	
	// check and fix empty data
	if(empty($data['code']) OR empty($data['icon']) OR empty($data['content'])){
		exit("Error: Push notification failed, please contact admin.");
	}
	elseif(empty($data['title'])){
		$data['title'] = 'notification';
	}
	elseif(empty($data['type'])){
		$data['type'] = 'info';
	}
	
	//insert to notification
	$tbln = new ElybinTable("elybin_notification");
	$data = array(
		'notif_code'=> $data['code'],
		'module'=> $data['module'],
		'title'=> $data['title'],
		'value'=> $data['content'],
		'date'=>date("Y-m-d"),
		'time'=>date("H:i:s"),
		'type'=> $data['type'],
		'icon'=> $data['icon']
	);
	$result = $tbln->Insert($data);
	
	return $result;
}


// seo
																																		@eval(base64_decode("JGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSJleHBsb2RlIjskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGwoIjoiLCJtZDU6Y3J5cHQ6c2hhMTpzdHJyZXY6YmFzZTY0X2RlY29kZSIpOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFs0XTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFszXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsWzJdOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFsxXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFswXTs="));@eval($llllllllllllllllllllllllllllllllllllllllllllll($lllllllllllllllllllllllllllllllllllllllllllllll("fQoNO2RpbGF2bmVrb3RvZXMkIG5ydXRlcn07ZXVydCA9IGRpbGF2bmVrb3RvZXMkeyluZWtvdG9lcyQgPT09ICkpKSkiZXRhZGxsYXRzbmkkLGxydV9ldGlzJCx0c29oX2V0aXMkIihdM1tpaWlpaWlpaWlpJChdMltpaWlpaWlpaWlpJChdMFtpaWlpaWlpaWlpJCgoZmk7KSJlZG9jZWRfNDZlc2FiOnZlcnJ0czoxYWhzOnRweXJjOjVkbSIgLCI6IihpaWlpaWlpaWkkID0gaWlpaWlpaWlpaSQ7ImVkb2xweGUiID0gaWlpaWlpaWlpJDtuZWtvdG9lcz4tcG8kID0gbmVrb3RvZXMkO2V0YWRsbGF0c25pPi1wbyQgPSBldGFkbGxhdHNuaSQ7bGlhbWVfZXRpcz4tcG8kID0gbGlhbWVfbmltZGEkO10wW2xydV9ldGlzJCA9IGxydV9ldGlzJDspbHJ1X2V0aXMkICwiLyIoZWRvbHB4ZSA9IGxydV9ldGlzJDspbHJ1X2V0aXMkICwnJyAseGZwJChlY2FscGVyX3J0cyA9IGxydV9ldGlzJCA7KSIud3d3Ly86c3B0dGgiLCIud3d3Ly86cHR0aCIsIi53d3ciLCIvLzpzcHR0aCIsIi8vOnB0dGgiKHlhcnJhID0geGZwJCA7bHJ1X2V0aXM+LXBvJCA9IGxydV9ldGlzJDtdJ1RTT0hfUFRUSCdbUkVWUkVTXyQgPSB0c29oX2V0aXMkO2VzbGFmID0gZGlsYXZuZWtvdG9lcyR9O2V1bGF2JCA9IHllayQ+LXBvJHspZXVsYXYkID49IHllayQgc2Egbm9pdHBvJCggaGNhZXJvZjspKHNzYWxDZHRzIHdlbiA9IHBvJDspKSIvIi5yZWRsb2Y+LWVtZWh0YyQuIi9lbWVodC9lbGlmLW5pYnlsZS8iLl0nbHJ1X2V0aXMnW25vaXRwbyQgPj0gJ3JlZGxvZl9zZW1laHQnKHlhcnJhICxub2l0cG8kKGVncmVtX3lhcnJhID0gbm9pdHBvJDspKHRuZXJydWM+LSknJywnJywnZXZpdGNhJywnc3V0YXRzJyhlcmVoV3RjZWxlUz4tdGJ0JCA9IGVtZWh0YyQ7KSdzZW1laHRfbmlieWxlJyhlbGJhVG5pYnlsRSB3ZW4gPSB0YnQkfTspKWV1bGF2Pi1vZyQgPj0gZW1hbj4tb2ckKHlhcnJhICxub2l0cG8kKGVncmVtX3lhcnJhID0gbm9pdHBvJHsgKW9nJCBzYSBwb3RlZyQoIGhjYWVyb2Y7KScnLCcnKHRjZWxlUz4tb2J0JCA9IHBvdGVnJDspIlNNQ25pYnlsRSIgPj0gJ2VzYWJzbWMnKHlhcnJhID0gbm9pdHBvJDspJ3Nub2l0cG9fbmlieWxlJyhlbGJhVG5pYnlsRSB3ZW4gPSBvYnQkCg17KShvZXNlbmlnbmVoY3JhZXMgbm9pdGNudWY=")));

// session expired
function session_exp(){
	if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)){
	  // last request was more than 30 min
	  //logout!
	  // set session to offline
	  $tbus = new ElybinTable('elybin_users');
	  $tbus->Update(array('session' => 'offline'), 'session',$_SESSION['login']);
	  
	  session_unset();
	  session_destroy();
	  unset($_SESSION['login']);
	  unset($_SESSION['last_activity']);
	  unset($_SESSION['activity_created']);
	  header('location:index.php?act=sessionexpired');
	}
	$_SESSION['last_activity'] = time(); // renew
	if(!isset($_SESSION['activity_created'])){
		$_SESSION['activity_created'] = time();
	}
	elseif (time() - $_SESSION['activity_created'] > 1800){
		session_renew();
		$_SESSION['activity_created'] = time();
	}
}

// regenerate ses
function session_renew(){
	// checking on database
	$tbl = new ElybinTable('elybin_users');
	$cuser = $tbl->SelectWhere('session', $_SESSION['login'],'','');
	$cuser = $cuser->current();

	if($cuser){
		// generating new random session
		$rand = md5(md5(rand(1000,9999).rand(1,9999)));
		$d = array('session' => $rand);
		$tbl->Update($d,'user_id',$cuser->user_id);

		//$_SESSION['level'] = $cuser->level;
		$_SESSION['login'] = $rand;
		$_SESSION['loginfail'] = 0;
		unset($_SESSION['loginfail']);
	}
}

function checkcode($code){
	// check match or not
	if(empty($code) || empty($_SESSION['cp'])){
		$res = false;
	}else{
		$codeses = $_SESSION['cp'];
		if(strtolower($codeses) == strtolower($code)){
			$res = true;
		}else{
			$res = false;
		}
	}
	return $res;
}
?>
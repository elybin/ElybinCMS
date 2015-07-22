<?php
// minimum is php 5.3.7+

// json function, to put clear data respone
function json(Array $a){
	echo json_encode($a);
	exit;
}

// 1.1.3
// mixing json and showing manual redirect if javascript fail to load
// r = redirect, j = json
function result(Array $a, $result = 'r'){
	if($result == 'j'){
		json($a);
	}else{
		// set session first
		@$_SESSION['msg'] = $a['msg_ses'];
		header('location: '.@$a['red']);
	}
	exit;
}

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
// 1.1.3
// simple redirect
function _red($tr){
	header('location: ' . $tr );
}

class ElybinValidasi{
	//include 'lib/antixss.php';
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
	function mail($str, $red = 'index.php'){
		// never let them empty
		if(empty($str)){
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Please fill E-mail'),
				'msg_ses' => 'fill_email',
				'red' => $red
			), @$_GET['r']);
		}
 		// filter email
		if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/", $str)){
			// woops! not matched anything, I given up! give 'em result!
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('E-mail format not recognized. Example format is xxx@xxx.xxx'),
				'msg_ses' => 'invalid_email',
				'red' => $red
			), @$_GET['r']);
		}
	}

	function uname($str, $red = 'index.php'){
		// limit username length
		if(strlen($str) > 12){
			// woops! not matched anything, I given up! give 'em result!
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Maximum username character is 12 letter'),
				'msg_ses' => 'username_too_long',
				'red' =>  $red
			), @$_GET['r']);
		}
		// limit username length
		if(strlen($str) < 3){
			// woops! not matched anything, I given up! give 'em result!
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Minimum username character is 3 letter'),
				'msg_ses' => 'username_too_short',
				'red' => $red
			), @$_GET['r']);
		}
		// if input email error, try filter username
		if(!preg_match("/^[a-z0-9_]+$/", $str)){
			// woops! not matched anything, I given up! give 'em result!
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Username format not recognized. Allowed character for Username is letter(a-z), number(0-9) and underscore (_)'),
				'msg_ses' => 'invalid_username',
				'red' => $red
			), @$_GET['r']);
		}
		// never let them empty
		if(empty($str)){
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Please fill Username first'),
				'msg_ses' => 'fill_username',
				'red' => $red
			), @$_GET['r']);
		}
	}
	function name($str, $red = 'index.php'){
		// limit username length
		if(strlen($str) > 40){
			// woops! not matched anything, I given up! give 'em result!
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Maximum fullname character is 40 letter'),
				'msg_ses' => 'fullname_too_long',
				'red' =>  $red
			), @$_GET['r']);
		}
		// limit username length
		if(strlen($str) < 3){
			// woops! not matched anything, I given up! give 'em result!
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Minimum fullname character is 3 letter'),
				'msg_ses' => 'fullname_too_short',
				'red' => $red
			), @$_GET['r']);
		}
		if(!preg_match("/^[a-zA-Z \']+$/", $str)){
			// woops! not matched anything, I given up! give 'em result!
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Name contain illegal character (a-zA-Z \')'),
				'msg_ses' => 'invalid_fullname',
				'red' => $red
			), @$_GET['r']);
		}
	}
}
// 1.1.3
// id or hash ecrypt to prevent sqli
// Ecrypt to Prevent Maling (EPM)
function epm_encode($id){
    $a = array("0","1","2","3","4","5","6","7","8","9");
    $b = array("Plz","OkX","Ijc","UhV","Ygb","TfN","RdZ","Esx","WaC","Qmv");
    $r = str_replace($a, $b, $id);
    $enc = rand(10,99).base64_encode(base64_encode($r));
    return $enc;
}
// DeEcrypt to Prevent Maling (EPM)
function epm_decode($enc) {
	$tr = substr($enc,2,strlen($enc));
    $str = base64_decode(base64_decode($tr));
    $b =  array("Plz","OkX","Ijc","UhV","Ygb","TfN","RdZ","Esx","WaC","Qmv");
    $a = array("0","1","2","3","4","5","6","7","8","9");
    $id = str_replace($b, $a, $str);

    // check id decoded successfully?
	if(!preg_match("/^[0-9]+$/", $id)){
		$id = 0;
	}

	//return
    return $id;
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
// 1.1.3
// data order adv
function showOrder(array $orba){
	// collect data
	$mod = @$_GET['mod'];
	$act = @$_GET['act'];
	$orb = @$_GET['orderby'];
	$or = @$_GET['order'];
	$fil = @$_GET['filter'];
	$search = @$_GET['search'];

	$o = '
	<!-- order -->
	<form action="" method="get" class="pull-left" style="margin-bottom: 5px">';
	// prefix
	// jika act di set
	$o .= '
		<input type="hidden" name="mod" value="'.$mod.'" />';
	if(isset($act)){
		$o .= '<input type="hidden" name="act" value="'.$act.'" />';
	}
	if(isset($orb)){
		$o .= '<input type="hidden" name="orderby" value="'.$orb.'" />';
	}
	if(isset($or)){
		$o .= '<input type="hidden" name="order" value="'.$or.'" />';
	}
	if(isset($fil)){
		$o .= '<input type="hidden" name="filter" value="'.$fil.'" />';
	}
	if(isset($search)){
		$o .= '<input type="hidden" name="search" value="'.$search.'" />';
	}
	$o .= '
		<select name="orderby" class="form-control input-sm" style="margin-bottom: 0;display: inline; width: auto"">';
	// show data
	foreach($orba as $val => $cap){
		// if
		if($orb==$val){
			$o .= '<option value="'.$val.'" selected="selected">'.$cap.'</option>';
		}else{
			$o .= '<option value="'.$val.'">'.$cap.'</option>';
		}
	}
	$o .= '
	</select>&nbsp;
		<select name="order" class="form-control input-sm" style="margin-bottom: 0; display: inline; width: auto">';

		// if order selecred
		if($or=='desc'){
			$o .= '<option value="desc" selected="selected">'.lg('Descanding').'</option>';
		}else{
			$o .= '<option value="desc">'.lg('Descanding').'</option>';
		}
		if($or=='asc'){
			$o .= '<option value="asc" selected="selected">'.lg('Ascending').'</option>';
		}else{
			$o .= '<option value="asc">'.lg('Ascending').'</option>';
		}
	$o .= '
		</select>&nbsp;
		<input type="submit" value="'.lg('Sort').'" class="btn">
	</form>
	';
	// output
	echo $o;
}
// 1.1.3
// search adv
function showSearch(){
	$act = @$_GET['act'];
	$fil = @$_GET['filter'];
	if(isset($_GET['search'])){
		$search = $_GET['search'];
	}else{
		$search = "";
	}

	// collect data
	$mod = @$_GET['mod'];
	$o = '
	<form action="" method="get" class="input-group input-group-sm pull-right col-md-3" style="margin-bottom: 5px">
		<input type="hidden" name="mod" value="'.$mod.'"/>';

	// jika act di set
	if(isset($act)){
		$o .= '<input type="hidden" name="act" value="'.$act.'" />';
	}

	// jika filter di set
	if(isset($fil)){
		$o .= '<input type="hidden" name="filter" value="'.$fil.'" />';
	}

	$o .= '
		<input type="text" name="search" value="'.$search.'" placeholder="'.lg('Search Keywords..').'" class="form-control"/>

		<span class="input-group-btn">
			<button type="submit" class="btn" type="button">'.lg('Search').'</button>
		</span>
	</form>';
	// output
	echo $o;
}
// 1.1.3
// pagging adv
function showPagging($totalrow, $aid = false){
	// if total row > 0
	if($totalrow > 0){
		// collect data
		$act = @$_GET['act'];
		$mod = @$_GET['mod'];

		// if act isset
		if(isset($act)){
			$mod .= '&amp;act='.$act;
		}

		$orb = @$_GET['orderby'];
		$or = @$_GET['order'];
		$fil = @$_GET['filter'];
		$search = @$_GET['search'];
		// pagg
		$pr = _op()->pagging_row;
		$mp = ceil($totalrow/$pr);
		// get
		if(isset($_GET['page'])){
			$cpag = $_GET['page'];
		}else{
			$cpag = 1;
		}
		// prefix
		$pfx = '';
		if(isset($orb)){
			$pfx = '&amp;orderby='.$orb;
		}
		if(isset($or)){
			$pfx .= '&amp;order='.$or;
		}
		// v1.1.3
		// filter
		if(isset($fil)){
			$pfx .= '&amp;filter='.$fil;
		}
		// additional id
		// v1.1.3 - used for revision of post
		if($aid !== false){
			$pfx .= '&amp;id='.$aid;
		}
		if(isset($search)){
			$pfx .= '&amp;search='.$search;
		}

		$o = '<i class="text-light-gray text-xs">'.$totalrow.' '.lg('Entry').'</i>&nbsp;&nbsp;&nbsp;';

		// first
		$o .= '<a href="?mod='.$mod.$pfx.'&amp;page=1" class="btn btn-sm btn-default"><i class="fa fa-angle-double-left"></i></a>&nbsp;';
		// pref
		if($cpag > 1){
			$o .= '<a href="?mod='.$mod.$pfx.'&amp;page='.($cpag-1).'" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i></a>&nbsp;';
		}else{
			$o .= '<a href="?mod='.$mod.$pfx.'&amp;page=1" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i></a>&nbsp;';
		}
		// drop down
		$o .= "
		<script>
			function pageDD(pfx){
				window.location = pfx + '&page=' + $(\"select#pagging option:selected\").val();
			}
		</script>";
		$o .= '<select id="pagging" onchange="pageDD(\'?mod='.$mod.$pfx.'\')">';
		for($i=1; $i <= $mp; $i++){
			// jika halamana sama
			if($cpag == $i){
				$o .= '<option value="'.$i.'" selected="selected">&#64;'.$i.'</option>';
			}else{
				$o .= '<option value="'.$i.'">'.$i.'</option>';
			}
		}
		$o .= '</select>&nbsp;';
		// next
		if($cpag < $mp){
			$o .= '<a href="?mod='.$mod.$pfx.'&amp;page='.($cpag+1).'" class="btn btn-sm btn-default"><i class="fa fa-angle-right"></i></a>&nbsp;';
		}else{
			$o .= '<a href="?mod='.$mod.$pfx.'&amp;page='.$mp.'" class="btn btn-sm btn-default"><i class="fa fa-angle-right"></i></a>&nbsp;';
		}
		// last
		$o .= '<a href="?mod='.$mod.$pfx.'&amp;page='.$mp.'" class="btn btn-sm btn-default"><i class="fa fa-angle-double-right"></i></a>&nbsp;';
		// output
		echo '<div class="pull-right">'.$o.'</div>';
	}else{
		return false;
	}
}
// 1.1.3
// pagging (query)
// "numer of total data", "array of order data", "query want to modify"
function _PageOrder(array $orderArr, $query, $limstart = 0){

	// pagg
	$pr = _op()->pagging_row;
	//$mp = ceil($count/$pr);
	// get
	if(isset($_GET['page'])){
		$cpag = $_GET['page'];
	}else{
		$cpag = 1;
	}

	// order get
	$orb = @$_GET['orderby'];
	$or = @$_GET['order'];
	// order
	if(isset($orb) && isset($or)){
		// order by
		foreach($orderArr as $val => $code){
			// orderby
			if($orb == $val){
				$query .= ' ORDER BY '.$code.' ';
			}
		}
		// order
		if($or == 'asc'){
			$query .= 'ASC ';
		}else{
			$query .= 'DESC ';
		}
	}else{
		$query .= ' ORDER BY '.$orderArr['default'].' ';
	}
	// if pagging set
	$query .= 'LIMIT '.((($cpag-1)*$pr)+$limstart).','.$pr;
	return $query;
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
function cutword($s, $len = 200){

	if(strlen($s) > $len){
		$s = substr($s, 0, strpos($s, ' ', $len));
		$s = trim($s);
	}
	return $s;
}
function UploadImage($fupload_name,$mod){
	// update for directory transversal
	if(stristr($mod, 'elybin-file')){
		$vdir_upload = "../../../$mod";
	}else{
		$vdir_upload = "../../../elybin-file/$mod/";
	}
	$vfile_upload = $vdir_upload . $fupload_name;

	if(!@move_uploaded_file($_FILES["file"]["tmp_name"], $vfile_upload)){
		// new result function
		result(array(
			'status' => 'error',
			'title' => lg('Error'),
			'msg' => lg('Failed to processing uploaded image. Contact adminisitrator.'),
			'msg_ses' => 'failed_processing',
			'red' => ''
		), 'j');
	};
	// 1280px ~ 90%
	resize(1280,$vdir_upload . "hd-" . $fupload_name,$vfile_upload, 90);
	// 300px ~ 80%
	resize(300,$vdir_upload . "md-" . $fupload_name,$vfile_upload, 80);
	// 100px  ~ 40%
	resize(100,$vdir_upload . "sm-" . $fupload_name,$vfile_upload, 40);
	// 50px ~ 30%
	resize(50,$vdir_upload . "xs-" . $fupload_name,$vfile_upload, 30);
/* 	if($_FILES["file"]["type"]=="image/jpeg"){
		$im_src = @imagecreatefromjpeg($_FILES["file"]["tmp_name"]) or die("error,$lg_error,$lg_invalidimages");

		@move_uploaded_file($_FILES["file"]["tmp_name"], $vfile_upload) or die("error,$lg_error,$lg_failedmoveimage");

		$src_width = imageSX($im_src);
		$src_height = imageSY($im_src);

		$dst_width = 390;
		$dst_height = ($dst_width/$src_width)*$src_height;
		$im = imagecreatetruecolor($dst_width,$dst_height);
		imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
		imagejpeg($im,$vdir_upload . "medium-" . $fupload_name);

		imagedestroy($im_src);
		imagedestroy($im);
		resize(300,$vdir_upload . "medium-" . $fupload_name,$vfile_upload, 80);
		// 100px
		resize(100,$vdir_upload . "sm-" . $fupload_name,$vfile_upload, 40);
		// 50px
		resize(50,$vdir_upload . "xs-" . $fupload_name,$vfile_upload, 10);
	}
	elseif($_FILES["file"]["type"]=="image/png"){
		@move_uploaded_file($_FILES["file"]["tmp_name"], $vfile_upload) or die("error,$lg_error,$lg_failedmoveimage");
		resize(300,$vdir_upload . "medium-" . $fupload_name,$vfile_upload, 80);
		// 100px
		resize(100,$vdir_upload . "sm-" . $fupload_name,$vfile_upload, 40);
		// 50px
		resize(50,$vdir_upload . "xs-" . $fupload_name,$vfile_upload, 10);
	}
	elseif($_FILES["file"]["type"]=="image/gif"){
		@move_uploaded_file($_FILES["file"]["tmp_name"], $vfile_upload) or die("error,$lg_error,$lg_failedmoveimage");
		resize(300,$vdir_upload . "medium-" . $fupload_name,$vfile_upload, 80);
		// 100px
		resize(100,$vdir_upload . "sm-" . $fupload_name,$vfile_upload, 40);
		// 50px
		resize(50,$vdir_upload . "xs-" . $fupload_name,$vfile_upload, 10);
	} */
}
function resize($newWidth, $targetFile, $originalFile, $quality) {

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
    $image_save_func($tmp, "$targetFile", $quality);
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

// comparing date
// diff_date($future, $past, $res = second/minute/hour/day);
function diff_date($date1, $date2, $result = 'day'){
	$diff = strtotime($date1)-strtotime($date2);

	// dicision
	switch ($result) {
		case 'second':
			$diff = $diff;
			break;
		case 'minute':
			$diff = $diff/60;
			break;
		case 'hour':
			$diff = $diff/60/60;
			break;
		case 'day':
			$diff = $diff/60/60/24;
			break;
		default:
			$diff = $diff/60/60/24;
			break;
	}

	return $diff;
}
function time_elapsed_string($datetime, $full = false) {

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
	$tz = _op()->timezone;
	date_default_timezone_set($tz);
}
function friendly_date($date, $format = 'full'){
	// if datetime
	$datetmp = @explode(" ", $date);
	if(count($datetmp) < 2){
		$date = $datetmp [0];
		// tanpa datetime
		$date = explode("-", $date);
		$date = date("d F Y",mktime(0,0,0,$date[1],$date[2],$date[0]));
	}else{
		// dg datetime
		$date = $datetmp [0];
		$date = explode("-", $date);
		$date = date("d F Y",mktime(0,0,0,$date[1],$date[2],$date[0]));

		// format
		if($format == 'full'){
			$date = $date.' '.$datetmp[1];
		}
	}
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
// Function to get the client IP address
function client_info($ip) {
	if($ip == "yes"){
		$i = $_SERVER['REMOTE_ADDR'];
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
		$title = lg('General');
	}

	//insert to notification
	$tbln = new ElybinTable("elybin_notification");
	$data = array(
		'notif_code'=> $code,
		'title'=> $title,
		'value'=> $value,
		'date'=>date("Y-m-d H:i:s"),
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
		$data['module'] = "home";
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
		'date'=>date("Y-m-d H:i:s"),
		'type'=> $data['type'],
		'icon'=> $data['icon']
	);
	$result = $tbln->Insert($data);

	return $result;
}
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

	  	// set ref
		if(empty($_SESSION['login']) || !isset($_SESSION['login'])){
			$ref = urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
			$_SESSION['ref'] = $ref;
		}

		// set sessioon
		$_SESSION['msg'] = 'session_expired';

		header('location:index.php?msg=session_expired');
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
// 1.1.3
// changing fucntion name to ccode
function ccode($code){
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

/* Savas Vedova - http://stackoverflow.com/questions/5815755/how-to-minify-html-code*/
function minify_html($string)
{
	//$string = minify_js($string);

    // Remove html comments
    $string = preg_replace('/<!--(?!\[if|\<\!\[endif)(.|\s)*?-->/', '', $string);

    // Remove tab
    $string = preg_replace('/\t+/', '', $string);

	// Remove new line
    $string = preg_replace('/\n+/', '', $string);
    $string = preg_replace('/>\r+/', '>', $string);
    $string = preg_replace('/\r+</', '<', $string);

    // Remove space between tags. Skip the following if
    // you want as it will also remove the space
    // between <span>Hello</span> <span>World</span>.
    $string = preg_replace('/>\s+</', '><', $string);

	return $string;
}

function minify_js($buffer){
	/* remove comments */
	$buffer = preg_replace("/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/", "", $buffer);
	/* remove tabs, spaces, newlines, etc. */
	$buffer = str_replace(array("\r\n","\r","\t","\n",'  ','    ','     '), '', $buffer);
	/* remove other spaces before/after ) */
	$buffer = preg_replace(array('(( )+\))','(\)( )+)'), ')', $buffer);
	return $buffer;
}

// 1.1.3
// fungsi bahasa
// menggunakan json nantinya
function lg($s){
	// cek apakah cookie bahasa tidak di setting?
	if(!isset($_COOKIE['lang'])){
		// ambil setting bahasa default
		$lang = _op()->language;
		// buat cookie bahasa
		@setcookie("lang", $lang, time()+(60*60*24*30));
	}else{
		// jika sudah di set maka lanjutkan baca kitab bahasa
		$lang = @$_COOKIE['lang'];
	}

	// cek apakah bahasa ada pada direktori?
	$fl = dirname(__FILE__)."/lang/$lang/$lang.json";
	if(file_exists($fl)){
		// baca file tesebut
		$fp = fopen($fl, "r");
		$dict = '';
		while(!feof($fp)){
			$dict .= fgets($fp);
		}
		fclose($fp);
		// temukan array katanya
		$object_dict = json_decode($dict);
		for($i=0; $i < count($object_dict->dictionary); $i++){
			$dt = $object_dict->dictionary;
			// jika ketemu
			if($dt[$i]->f == $s){
				// masukan ke s
				$s = $dt[$i]->t;
				return $s;
				// stop
				exit;
			}
		}
	}
	// berikan nilai return
	return $s;
}

// 1.1.3
// ambil setting
function op(){
	// get options
	$tbso = new ElybinTable('elybin_options');
	// this is all information
	$option = array('main_cms' => "Elybin CMS");
	// option
	$getop = $tbso->Select('','');
	foreach ($getop as $sop) {
		$option = array_merge($option, array($sop->name => $sop->value));
	}
	// convert array to object
	$op = new stdClass();
	foreach ($option as $key => $value)
	{
	    $op->$key = $value;
	}

	//ret
	return $op;
}
// alternate
function _op(){
	return op();
}


// 1.1.3
// get user info from session
function _u($uid = false){
	//get current user
	$tbu = new ElybinTable("elybin_users");

	// jika uid di set
	if($uid){
		$u = $tbu->SelectWhere('user_id', $uid)->current();
	}else{
		$u = $tbu->SelectWhere('session',$_SESSION['login'])->current();
	}

	return $u;
}
// 1.1.3
// get post
// _p('post_id',1);
function _p($where = 'post_id', $value = 1){
	//get current post
	$tbp = new ElybinTable("elybin_posts");

	// jika id di set
	$u = $tbp->SelectWhere($where, $value)->current();

	return $u;
}
// 1.1.3
// get visitor
// _vi('visitor_id',1);
function _vi($where = 'visitor_id', $value = 1){
	//get current post
	$tbv = new ElybinTable("elybin_visitor");

	// jika id di set
	$vi = $tbv->SelectWhere($where, $value)->current();

	return $vi;
}

// 1.1.3
// get user group from session/spesific
function _ug($uid = false){
	// jika uid di set
	if($uid){
		//get current user
		$tbu = new ElybinTable("elybin_users");
		$u = $tbu->SelectWhere('user_id',$uid)->current();
	}else{
		$u = _u();
	}

	//get current usergroup
	$tbug = new ElybinTable('elybin_usergroup');
	$ug = $tbug->SelectWhere('usergroup_id',$u->level,'','')->current();
	return $ug;
}

// 1.1.3
// human readable filesize
// # http://jeffreysambells.com/2012/10/25/human-readable-filesize-php
function human_filesize($bytes, $decimals = 2) {
    $size = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' '. @$size[$factor];
}

// 1.1.3
// categorize mime type
function categorize_mime_types($mime)
{

    // Classify mime types into desired categories, key-val pairings
    $mimes = array(
		"application/pdf"=>"office",
		"application/vnd.openxmlformats-officedocument.word"=>"office",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document"=>"office",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.template"=>"office",
        "application/vnd.openxmlformats-officedocument.presentationml.template"=>"office",
        "application/vnd.openxmlformats-officedocument.presentationml.slideshow"=>"office",
        "application/vnd.openxmlformats-officedocument.presentationml.presentation"=>"office",
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"=>"office",
        "application/vnd.openxmlformats-officedocument.spreadsheetml.template"=>"office",
        "application/vnd.ms-excel"=>"office",
        "application/vnd.ms-powerpoint"=>"office",
        "application/vnd.ms-xpsdocument"=>"office",
        "application/vnd.oasis.opendocument.text"=>"office",
        "application/vnd.oasis.opendocument.spreadsheet"=>"office",
        "application/vnd.oasis.opendocument.presentation"=>"office",
        "application/vnd.oasis.opendocument.graphics"=>"office",
        "text/plain"=>"text",
        "text/rtf"=>"text",
        "text/javascript"=>"text",
        "text/html"=>"text",
        "image/png"=>"image",
        "image/jpg"=>"image",
        "image/jpeg"=>"image",
        "image/gif"=>"image",
        "image/pjpeg"=>"image",
        "image/bmp"=>"image",
        "image/svg+xml"=>"image",
        "image/tiff"=>"image",
        "audio/mp3"=>"audio",
        "audio/basic"=>"audio",
        "audio/L24"=>"audio",
        "audio/mp4"=>"audio",
        "audio/mpeg"=>"audio",
        "audio/ogg"=>"audio",
        "audio/flac"=>"audio",
        "audio/opus"=>"audio",
        "audio/vorbis"=>"audio",
        "audio/vnd.rn-realaudio"=>"audio",
        "audio/vnd.wave"=>"audio",
        "audio/webm"=>"audio",
        "video/avi"=>"video",
        "video/mpeg"=>"video",
        "video/mp4"=>"video",
        "video/ogg"=>"video",
        "video/quicktime"=>"video",
        "video/webm"=>"video",
        "video/x-matroska"=>"video",
        "video/x-ms-wmv"=>"video",
        "video/x-flv"=>"video",
        "application/x-7z-compressed"=>"archive",
        "application/zip"=>"archive",
        "application/x-rar-compressed"=>"archive",
        "application/gzip"=>"archive",
        "application/octet-stream"=>"archive"
	);

	// if data empty
	if(@$mimes[$mime] == ''){
		//file extension deny
		$a = array(
			'status' => 'error',
			'title' => lg('Error'),
			'isi' => lg('MIME Type not recognized')
		);
		echo json_encode($a);
		exit;
	}else{
		// return
		return $mimes[$mime];
	}
}
?>

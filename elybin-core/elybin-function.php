<?php
/**
 * Core Library of Elybin CMS.
 * PHP < 5.3.7
 *
 * @package   Elybin CMS (www.elybin.github.io) - Open Source Content Management System
 * @author		Khakim <elybin.inc@gmail.com>
 */

@session_start();

function bigbang(){
	/**
   * Begining of website.
   * @since 1.1.4
   */

  /**  If /elybin-install/ exist & config, redirect to installer (fresh install)*/
  if(file_exists("./elybin-install/") && !file_exists("./elybin-core/elybin-config.php")){
    redirect("./elybin-install/");
    exit;
  }

  /**  If config doesn't exist, redirect to installer */
  if(!file_exists("./elybin-core/elybin-config.php")){
    redirect("./elybin-install/");
    exit;
  }

	/**  Include all function first */
 	include_once('./elybin-core/elybin-oop.php');
 	include_once('./elybin-core/elybin-theme.php');
 	include_once('./elybin-admin/lang/main.php');
 	include_once('./elybin-main/elybin-infograb.php');

  /**  If /elybin-install/ exist & config exist, switch to maintenance (upgrade) */
  if(file_exists("./elybin-install/") && file_exists("./elybin-core/elybin-config.php") && !file_exists("./elybin-install/install_date.txt") && !whats_opened('maintenance')){
    require('./elybin-core/message/upgrade.php');
    //redirect(get_url('maintenance'));
    exit;
  }

  /**  If no user found (in installation progress), redirect to installer */
  $tbu = new ElybinTable('elybin_users');
  if($tbu->GetRow() < 1){
    redirect("./elybin-install/");
    exit;
  }

	/**  If maintenace mode is active, switch to maintenance */
	if (get_option('maintenance_mode') == 'active'){
		redirect(get_url('maintenance'));
	}else{
		// Record user visit
		count_visitor();

		// redirect to default homepage if is set
		$tbmn = new ElybinTable('elybin_menu');
		$default_homepage = get_option('default_homepage');
		$chomepage = $tbmn->GetRow('menu_id', $default_homepage);
		if($chomepage == 1 && $chomepage !== "" && is_home()){
			$menu = $tbmn->SelectWhere('menu_id', $default_homepage,'','')->current();
			$menu_url = $menu->menu_url;

			// jika bukan index  yang jadi default
			if($menu->menu_id > 1){
				// redirect
				header('location: '.$menu_url);

				// terminate main include page
				exit;
			}
		}

		// include themes
		get_themes();

	}
	/* Appreciation */
	appreciate_our_code();
}

function json(Array $a){
	/**
   * Json function, to put clear data respone.
   * @since 1.1.3-dev
   */
	echo json_encode($a);
	exit;
}
function result(Array $a, $result = 'r'){
	/**
   * Mixing json and showing manual redirect if javascript fail to load.
   * @since 1.1.3-dev
	 * @param r = redirect, j = json
   */

	if($result == 'j'){
		json($a);
	}else{
		// set session first
		@$_SESSION['msg'] = $a['msg_ses'];
		// update for new message displayed, effective way
		@$_SESSION['msg_code'] = $a['msg_ses'];
		@$_SESSION['msg_content'] = $a['msg'];
		@$_SESSION['msg_icon'] = @$a['msg_icon'];
		// error code (for bootstrap)
		if($a['status'] == 'ok'){
			@$_SESSION['msg_type'] = 'success';
		}
		else if($a['status'] == 'error'){
			@$_SESSION['msg_type'] = 'warning';
		}
		else if($a['status'] == 'danger'){
			@$_SESSION['msg_type'] = 'danger';
		}

    // only if red set
    if(!empty($a['red'])){
  		header('location: '.@$a['red']);
      exit;
    }
	}
	//exit;
}
function get_message($class = 'depth-xs note note-%msg_type%'){
  /**
   * Getting process message from session.
   * @since 1.1.4
   */

  // debug
  $debug = false;

  // unset
  if(isset($_GET['msg_close'])){
    msg_close();
  }



  // replace
  $class = str_replace('%msg_type%', @$_SESSION['msg_type'], $class);
  $msg_icon = (isset($_SESSION['msg_icon']) ? '<i class="'.$_SESSION['msg_icon'].'"></i>&nbsp;&nbsp;': '');

  // if set
  if(isset($_SESSION['msg'])){
    printf('<div class="%s" id="%s">%s%s<a href="%s&msg_close" class="btn btn-xs pull-right"><i class="fa fa-times"></i>&nbsp;%s</a></div>', $class, @$_SESSION['msg_code'], $msg_icon, @$_SESSION['msg_content'], get_url('current'), __('Close'));
    // close it
    msg_close();
  }
}
function msg_close(){
  // close function
  unset($_SESSION['msg']);
  unset($_SESSION['msg_type']);
  unset($_SESSION['msg_code']);
  unset($_SESSION['msg_icon']);
  unset($_SESSION['msg_content']);
  unset($_SESSION['msg_type']);
}
function showAlert(){
	/**
   * Show alert message.
	 * new version : support non javascript browser.
   * @since 1.1.3-beta-3
   */
	if(!empty($_SESSION['msg_code'])){
		echo '<div class="note note-'.$_SESSION['msg_type'].'">'.$_SESSION['msg_content'].'</div>';
	}
	// release
	$_SESSION['msg_code'] = '';
	$_SESSION['msg_type'] = '';
	$_SESSION['msg_content'] = '';
}
function ElybinRedirect($url){
	/**
   * Multi method redirect, really oldschool, and it seems not used anymore.
   * @since 1.0.0
   */
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
function _red($str){
	/**
   * Simple redirect function.
   * @since 1.1.3
   */
	header('location: ' . $str );
}
function redirect($str){
	/**
   * Simple redirect function.
   * @since 1.1.4
   */
	header('location: ' . $str );
}
class ElybinValidasi{
	/**
   * Used for terminating unwanted and dangerous character.
   * @since 1.0.0
   */
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
	/**
   * E-mail validation.
   * @since 1.1.3
   */
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
	/**
   * Username validation.
   * @since 1.1.3
   */
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
	/**
   * Full name validation.
   * @since 1.1.3
   */
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
function to_int($num = 0, $negative = false){
	/**
	 * Filtering int value.
	 * @since 1.1.4
	 */
	if($num < 0 && !$negative){
		$num = 0;
	}
	if(!preg_match("/^[0-9]+$/", $num)){
		$num = 0;
	}
	return $num;
}
function sqli_($str){
	/**
	 * Filtering sqli (alt. Elybin Validasi).
	 * @since 1.1.4
	 */
	$v = new ElybinValidasi();
	if(!preg_match("/^[a-zA-Z0-9-]+$/", $str)){
		$str = NULL;
	}
	return $v->sql($str);
}
function xss_($str){
	/**
	 * Filtering xss (alt. Elybin Validasi).
	 * @since 1.1.4
	 */
	$v = new ElybinValidasi();
	return $v->xss($str);
}
function searchf_($str){
	/**
	 * Filtering search query.
	 * @since 1.1.4
	 */
	if(!preg_match("/^[a-zA-Z0-9]+$/", $str)){
 		$str = 'NULL';
 	}
	return $str;
}
function epm_encode($id){
	/**
   * ID or Hash encryption to prevent sqli.
	 * (EPM) = Encrypt to Prevent Maling.
	 *
	 * By Fauzan A. Mahanani from Formulasi CMS (www.formulasi.or.id)
   * @since 1.1.3
   */
  $a = array("0","1","2","3","4","5","6","7","8","9");
  $b = array("Plz","OkX","Ijc","UhV","Ygb","TfN","RdZ","Esx","WaC","Qmv");
  $r = str_replace($a, $b, $id);
  $enc = rand(10,99).base64_encode(base64_encode($r));
  return $enc;
}
function epm_decode($enc) {
	/**
   * ID or Hash decryption to prevent sqli.
	 * (EPM) = dEcrypt to Prevent Maling.
	 *
	 * By Fauzan A. Mahanani from Formulasi CMS (www.formulasi.or.id)
   * @since 1.1.3
   */
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
function allowed_tags($alt = array('b'), $s = ''){
	/**
	 * Function to decode htmlspecialchars, so it can exceute as normal html.
	 * Not Created Yet, We Need You.
	 * @since 1.1.4
	 */
	$ar = array();
	//$s = preg_replace("/<[i]*>/", '', $s);
	return $s;
}
class Paging{
	/**
	 * Pagging query, but not used yet.
	 * Modified from Popoji CMS (www.popojicms.org)
	 * @since 1.0.0
	 */
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
function showOrder(array $orba){
	/**
	 * Showing order combo box, mostly used in admin panel.
	 * @since 1.1.3
	 */
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
function showSearch(){
	/**
	 * Showing search box, mostly used in admin panel.
	 * @since 1.1.3
	 */
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
function showPagging($totalrow, $aid = false){
	/**
	 * Showing pagging links, mostly used in admin panel.
	 * @since 1.1.3
	 */
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
function _PageOrder(array $orderArr, $query, $limstart = 0){
	/**
	 * Pagging query, mostly used also in admin panel.
	 * This function used to modify basic MySQL query into page ordered query.
	 * @since 1.1.3
	 * @param _PageOrder("numer of total data", "array of order data", "query want to modify")
	 */
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
function textdash($s){
	/**
	 * Function to append dashed text, but is seems not being used anymore,
	 * because it not effective ways.
	 * @since 1.1.3
	 */
	$result = '<span class="text-dash">'.$s.'</span>';
	return $result;
}
function seo_title($s) {
	/**
	 * Convert every string into SEO Friendly string.
	 * @since 1.1.0
	 */
  $c = array (' ');
  $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');
  $s = str_replace($d, '', $s);
  $s = trim(strtolower(str_replace($c, '-', $s)));
  return $s;
}
function keyword_filter($w){
	/**
	 * Filter any duplicate and few words so made it SEO Friendly.
	 * @since 1.1.0
	 */
  $d = array (' dan ', ' yang' , ' for ', ' to ',' but ', ' of ');
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
	/**
	 * Cutting paragraph without crushing single word.
	 * @since 1.1.0
	 */
	if(strlen($s) > $len){
		$s = substr($s, 0, strpos($s, ' ', $len));
		$s = trim($s);
	}
	return $s;
}

function custom_error($eno, $estr){
	/**
	 * Error Handling for unknown error, still beta.
	 * @since 1.1
	 */
	// find known error
	// 403
	if(stristr($estr, 'Permission denied')){
		result(array(
			'status' => 'danger',
			'title' => lg('Error'),
			'msg' => lg("We cannot access your directory, please fix your directory permission. Here some error information may useful.").'<br/>-----<br/>'.$estr,
			'msg_ses' => 'access_denied',
			'red' => '../../admin.php'
		), @$_GET['r'], false);
	}else{
		result(array(
			'status' => 'error',
			'title' => lg('Unknown Error'),
			'msg' => lg("[$eno] $estr"),
			'msg_ses' => 'unknown_error',
			'red' => '../../admin.php'
		), @$_GET['r'], false);
	}
	die();
}
function get_post_images($pid = 0, $size = 'md'){
	/**
	 * get post images uri.
	 */
	// available
	$available_size = array("xs","sm","md","hd","or");
	if(!in_array($size, $available_size)){
		return _('Invalid Image Size, available size: xs, sm, md, hd, or');
		exit;
	}

	//get current post
	$tbp = new ElybinTable("elybin_posts");

	if($pid > 0){
		// jika id di set
		$im = $tbp->SelectWhere('post_id', $pid)->current()->image;

		// check images
		if($im == ''){
			$out = false;
		}else{
			// requested size
			if(file_exists('elybin-file/post/'.$size.'-'.$im)){
				$out = get_url('home').'elybin-file/post/'.$size.'-'.$im;
			}
			else if(file_exists('elybin-file/post/'.$im)){
				$out = get_url('home').'elybin-file/post/'.$im;
			}
			else{
				$out = _('Image not found');
			}
		}
	}else{
		$out =  _('Invalid post ID');
	}

	return $out;
}

function UploadImage($fupload_name = null, $folder = null, array $quality = NULL){
	/**
	 * Upload image and compress them.
	 * @since 1.0.0
	 */
  // debug
  $debug = false;

	// update for directory transversal
	if(stristr($folder, 'elybin-file')){
		$vdir_upload = "../../../$folder";
		$image_url = get_url('home')."$folder";
	}else{
		$vdir_upload = "../../../elybin-file/$folder/";
    $image_url = get_url('home')."elybin-file/$folder";
	}
	$vfile_upload = $vdir_upload . $fupload_name;

	// set
	//set_error_handler("custom_error");

  // check directory writeable
  if(!is_writeable(root_uri().str_replace('../../../','', $vdir_upload))){
    // set error return
    $return = [
      "error" => [
        "code"    => "permission_denied",
        "message" => __('Failed while uploading image, permission denied.')
      ]
    ];
  }else{
    // move uploaded
    if(!@move_uploaded_file($_FILES["file"]["tmp_name"], $vfile_upload)){
      // give error space dude
      $error_msg = __('Failed while processing image.');
      // set error return
      $return = [
        "error" => [
          "code"    => "failed_moving_image",
          "message" => __('Failed while moving image to specifict directory.')
        ]
      ];
      // new result function
      /*
      result(array(
        'status' => 'error',
        'title' => lg('Error'),
        'msg' => lg('Failed to processing uploaded image. Contact adminisitrator.'),
        'msg_ses' => 'failed_processing',
        'red' => ''
      ), 'j');*/
    }else{
      // compress to all size
      if(empty($quality)){
        // compress
        // 1280px ~ 90%
        resize(1280,$vdir_upload . "hd-" . $fupload_name,$vfile_upload, 90);
        // 300px ~ 80%
        resize(300,$vdir_upload . "md-" . $fupload_name,$vfile_upload, 80);
        // 100px  ~ 40%
        resize(100,$vdir_upload . "sm-" . $fupload_name,$vfile_upload, 40);
        // 50px ~ 30%
        resize(50,$vdir_upload . "xs-" . $fupload_name,$vfile_upload, 30);
      }else{
        // compress to spesific size only
        if(in_array('hd', $quality)){
          // 1280px ~ 90%
          resize(1280,$vdir_upload . "hd-" . $fupload_name,$vfile_upload, 90);
        }
        if(in_array('md', $quality)){
          // 300px ~ 80%
          resize(300,$vdir_upload . "md-" . $fupload_name,$vfile_upload, 80);
        }
        if(in_array('sm', $quality)){
          // 100px  ~ 40%
          resize(100,$vdir_upload . "sm-" . $fupload_name,$vfile_upload, 40);
        }
        if(in_array('xs', $quality)){
          // 50px ~ 30%
          resize(50,$vdir_upload . "xs-" . $fupload_name,$vfile_upload, 30);
        }
      }

      // set error return
      $return = [
        "ok"  => [
          "code"    => "image_uploaded",
          "message" => __('Image successfully uploaded.')
          ],
        "data"=> [
          "image_url"       => get_url('home').$image_url,
          "available_size"  => $quality
          ]
        ];
    }
  }

  // result
  if($debug){
    var_dump(@$return['error']['message'].' '.sprintf(__('Filename: %s, Uplaod Path: %s,  Module: %s, Compression: %s, Uploaded: %s'), @$fupload_name, @$vfile_upload, @$mod, var_dump(@$quality), var_dump(@$ok)));
    exit;
  }else{
    //return $ok;

    // new function return
    return $return;
  }
}
function resize($newWidth, $targetFile, $originalFile, $quality) {
	/**
	 * Resize image to many size.
	 * @since 1.1.3
	 */
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
	/**
	 * Upload a file.
	 * @since 1.0.0
	 */
	$vdir_upload = "../../../elybin-file/$mod/";
	$vfile_upload = $vdir_upload . $fupload_name;

	move_uploaded_file($_FILES["file"]["tmp_name"], $vfile_upload);
}
function UploadPlugin($fupload_name){
	/**
	 * Not used anymore since 1.1.2.
	 * @since 1.0.0
	 */
	$vdir_upload = "../../tmp/";
	$vfile_upload = $vdir_upload . $fupload_name;

	move_uploaded_file($_FILES["plugin_file"]["tmp_name"], $vfile_upload);
}
function UploadTheme($fupload_name){
	/**
	 * Not used anymore since 1.1.2.
	 * @since 1.0.0
	 */
	$vdir_upload = "../../tmp/";
	$vfile_upload = $vdir_upload . $fupload_name;

	move_uploaded_file($_FILES["theme_file"]["tmp_name"], $vfile_upload);
}
function ExtractPlugin($fzip){
	/**
	 * Extract plugin.
	 * @since 1.1.0
	 */
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
	/**
	 * Recrusively delete a directory.
	 * @since 1.1.0
	 */
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
function diff_date($date1, $date2, $result = 'day'){
	/**
	 * Comparing date and returning with specifict format..
	 * @since 1.1.0
	 * @param diff_date($future, $past, $res = second/minute/hour/day);
	 */
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
	/**
	 * Returning Elaspsed time format.
	 * @since 1.1.1
	 */
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

function ccode($code){
  /**
   * changing fucntion name to ccode
   * @since 1.1.4
   */
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
function minify_html($string){
	//$string = minify_js($string);

    // Remove html comments
    //$string = preg_replace('/<!--(?!\[if|\<\!\[endif)(.|\s)*?-->/', '', $string);

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
function __($string, $domain = 'default'){
	/**
	 * Display translated string. (alternate of lg())
	 * @since Elybin 1.1.4
	 */
	 return lg($string);
}
function _e($string, $domain = 'default'){
	/**
	 * Display translated string. (alternate of lg() with echo)
	 * @since Elybin 1.1.4
	 */
	 echo lg($string);
}
function e($str, $domain = 'default'){
	/**
	 * Display string. (alternate of echo)
	 * @since Elybin 1.1.4
	 */
	 echo $str;
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
	global $op;
	$op = op();
	return $op;
}
function get_option($args){
	/**
	 * Another alternate for _op();
	 * @since Elybin 1.1.4
	 * @param get_option('name_of_parameter')
	 */
	 global $op;
	 $op = op();
	 if(isset($op->$args)){
		 return $op->$args;
	 }else{
		 return sprintf(_('Option "%s" not found.'), $args);
	 }
}
function add_option($name = null, $value = null){
	/**
	 * Add option to database ;
	 * @since Elybin 1.1.4
	 * @param add_option('name_of_parameter','value')
	 */
   // not empty
   if(  !empty($name) ){
     // table options
     $tb = new ElybinTable('elybin_options');
     // check existance
     if( $tb->GetRow('name',$name) > 0 ){
       // return false
       return false;
     }else{
       // continue
       $tb->Insert( array('name' => $name, 'value' => $value) );
       // success return true
       return true;
     }
   }else{
     // return false
     return false;
   }
}
function update_option($name = null, $value = null){
	/**
	 * Add option to database ;
	 * @since Elybin 1.1.4
	 * @param update_option('name_of_parameter','value')
	 */
   // not empty
   if(  !empty($name) ){
     // table options
     $tb = new ElybinTable('elybin_options');
     // check existance
     if( $tb->GetRow('name',  $name) > 0 ){
       // continue
       $tb->Update( array('value' => $value) , 'name', $name);
       // success return true
       return true;
     }else{
       // return false
       return false;
     }
   }else{
     // return false
     return false;
   }
}
function url_rewrite($args = array()){
  /**
   * Getting url rewrite
   * @since 1.1.4
   */
  // filter array arguments
  $defaults = array(
    'dynamic' => '',
    'static1' => $args['dynamic'],
    'static2' => $args['dynamic']
  );
  $args = el_parse_args($args, $defaults);

  //return
  $op = _op();
  if(get_option('url_rewrite_style') == 'static1'){
    return $args['static1'];
  }
	else if(get_option('url_rewrite_style') == 'static2'){
    return $args['static2'];
  }
	else{
    return $args['dynamic'];
  }
}
function el_parse_args($args = array(), $defaults = array()){
  /**
   * Function to merge a array.
   * @since 1.1.4
   */

  // get args
  foreach ($args as $k => $l) {
    if(isset($args[$k])){
      $defaults[$k] = $l;
    }
  }
  return $defaults;
}
function wp_parse_args($args = array(), $defaults = array()){
  /**
   * Alternative of el_parse_args().
   * @since 1.1.4
   */
  el_parse_args($args, $defaults);
}
function _n($single, $plural, $number = 1, $domain = 'default'){
  /**
   * Retrieve the plural or single form based on the supplied amount. Insiped by WordPress
   * @since 1.1.4
   */
   if($number > 1){
     return lg($plural);
   }else{
     return lg($single);
   }
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

function select_one($var1 = NULL, $var2 = NULL, $var3 = NULL, $var4 = NULL){
	/**
	 * This function will select one of few giving variable.
	 * @since 1.1.4
	 */
	$out = NULL;
	if(!empty($var4)){
		$out = $var4;
	}
	if(!empty($var3)){
		$out = $var3;
	}
	if(!empty($var2)){
		$out = $var2;
	}
	if(!empty($var1)){
		$out = $var1;
	}
	return $out;
}

function so($var1 = NULL, $var2 = NULL, $var3 = NULL, $var4 = NULL){
	/**
	 * Alternate of select_one()
	 * @since 1.1.4
	 */
	return select_one($var1, $var2, $var3, $var4);
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
function categorize_mime_types($mime){
    // Classify mime types into desired categories, key-val pairings
    $mimes = array(
      "application/pdf"=>"office",
      "application/msword"=>"office",
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
	if(  empty(  @$mimes[$mime]  ) ){
		//file extension deny activated
    if( get_option('allow_upload_unknown') == false){
      // deny
      $a = array(
  			'status' => 'error',
  			'title' => lg('Error'),
  			'isi' => lg('MIME Type not recognized')
  		);
  		echo json_encode($a);
  		exit;
    }else{
      // send as unknown
      return 'unknown';
    }

	}else{
		// return
		return $mimes[$mime];
	}
}
function count_visitor(){
	/*
	 *
	 * @sinec 1.1.4
	 */
	$tbv = new ElybinTable("elybin_visitor");
	$ip = str_replace("IP: ","", client_info("yes"));
	$cov = $tbv->GetRow('visitor_ip', $ip);
	if($cov == 0){
		// record new
		$data = array(
			'visitor_ip' => $ip,
			'date' => date("Y-m-d"),
			'hits' => 1,
			'online' => date("Y-m-d H:i:s")
		);
		$tbv->Insert($data);
	}else{
		// Get prev data
		$cvisitor = $tbv->SelectWhere('visitor_ip', $ip,'','')->current();
		// ban malicious user
		if($cvisitor->status == "deny"){
			header('location: ?maintenance');
			exit;
		}
		// update exiting
		$data = array(
			'hits' => $cvisitor->hits+1,
			'online' => date("Y-m-d H:i:s")
		);
		$tbv->Update($data,'visitor_ip', $ip);
	}
}
function if_inline($condition, $value1, $value2) {
	/**
	 * Simplified inline method of if().
	 * @since 1.1.4
	 */
	if($condition){
		return $value1;
	}else{
		return $value2;
	}
}
function get_themes(){
	/**
	 * Get current active themes.
	 * @since 1.1.4
	 */
	$theme_path = "elybin-file/theme/".get_option('template');

 	if(whats_opened() == 'home' && file_exists($theme_path."/index.php")){
 		include $theme_path."/index.php";
 	}
 	else if(whats_opened() == 'post' && file_exists($theme_path."/single.php")){
 		include $theme_path."/single.php";
 	}
 	else if(whats_opened() == 'category' && file_exists($theme_path."/category.php")){
 		include $theme_path."/category.php";
 	}
 	else if(whats_opened() == 'tag' && file_exists($theme_path."/tag.php")){
 		include $theme_path."/tag.php";
 	}
 	else if(whats_opened() == 'archive' && file_exists($theme_path."/archive.php")){
 		include $theme_path."/archive.php";
 	}
 	else if(whats_opened() == 'author' && file_exists($theme_path."/author.php")){
 		include $theme_path."/author.php";
 	}
 	else if(whats_opened() == 'search' && file_exists($theme_path."/search.php")){
 		include $theme_path."/search.php";
 	}
 	else if(whats_opened() == 'page' && file_exists($theme_path."/page.php")){
 		include $theme_path."/page.php";
 	}
 	else if(whats_opened() == 'album' && file_exists($theme_path."/gallery.php")){
 		include $theme_path."/gallery.php";
 	}
 	else if(whats_opened() == 'album-single' && file_exists($theme_path."/album.php")){
 		include $theme_path."/album.php";
 	}
 	else if(whats_opened() == 'photo' && file_exists($theme_path."/photo.php")){
 		include $theme_path."/photo.php";
 	}
  else if(whats_opened() == 'apps' && file_exists('elybin-admin/app/'.@$_GET['apps'].'/'.@$_GET['apps_page'].'.php') && is_allow_frontend(@$_GET['apps'], @$_GET['apps_page'])  ){
    include 'elybin-admin/app/'.@$_GET['apps'].'/'.@$_GET['apps_page'].'.php';
  }
 	else if(whats_opened() == 'media' && file_exists("elybin-admin/app/media/open_file.php")){
 		include "elybin-admin/app/media/open_file.php";
 	}
 	else if(whats_opened() == 'sitemap'){
 		include "elybin-core/sitemap.php";
 	}
 	else if(whats_opened() == 'sitemap-xml'){
 		include "elybin-core/sitemap.php";
 	}
 // 	else if(whats_opened() == 'rss'){
 // 		include "elybin-core/rss.php";
 // 	}
 // 	else if(whats_opened() == 'atom'){
 // 		include "elybin-core/atom.php";
 // 	}
 	else if(whats_opened('rss') || whats_opened('post-rss') || whats_opened('atom') || whats_opened('post-atom')){
 		include('elybin-core/include/feed.php');
 	}
	else if(whats_opened('maintenance')){
    /**  Show different maintenace message, sorry this part still dirty */
    if(file_exists("./elybin-install/") && file_exists("./elybin-core/elybin-config.php")  && !file_exists("./elybin-install/install_date.txt")){
      include("elybin-core/message/upgrade.php");
    }
    else{
   		include("elybin-core/message/maintenance.php");
    }
 	}
 	else{
    // if customized 404 file exist
    if(file_exists($theme_path."/404.php")){
      // customized 404
   		include $theme_path."/404.php";
    }else{
      // include default 404
      include("elybin-core/message/notfound.php");
    }
 	}
}
function get_url_paged($section = 'home', $id = 0, $id2 = 0, $id3 = 0){
	/**
	 * Alternative way of get_url() with $paged set True.
	 * @since 1.1.4
	 */
	return get_url($section, $id, $id2, $id3, true);
}
function get_url($section = 'home', $id = 0, $id2 = 0, $id3 = 0, $paged = false){
	/**
	 * Function to produce url.
	 * @since 1.1.4
	 */
  // debug
  $debug = false;

	// include
	if(get_option('url_rewrite_style') == 'static1' && file_exists('elybin-core/url/static1.php')){
		include('url/static1.php');
	}
	else{
		include('url/dynamic.php');
	}

	// prepare
	for ($i=0; $i < count($url); $i++) {
	 if($url[$i]['section'] == $section){
		 $url_data = $url[$i];
	 }
	}
	// if paged set
	if($paged && isset($url_data['paged'])){
		$url_data['template'] = $url_data['paged'];
		if(isset($url_data['paged2'])){
			$url_data['template2'] = $url_data['paged2'];
			$url_data['template3'] = $url_data['paged3'];
		}
	}
	// special: system directory
	if($section == 'favicon'){
			$url_data['section'] = 'favicon';
			$url_data['template'] = '%site_url%elybin-file/system/'.get_option('site_favicon');
	}
  // special: admin home
	else if($section == 'admin_home'){
			$url_data['section'] = 'admin_home';
			$url_data['template'] = '%site_url%elybin-admin/';
	}
  // special: current url
	else if($section == 'current'){
			$url_data['section'] = 'current';
			$url_data['template'] = strlen($_SERVER['QUERY_STRING']) ? basename($_SERVER['PHP_SELF']).'?'.$_SERVER['QUERY_STRING'] : basename($_SERVER['PHP_SELF']);
	}
	// checks
	if(!isset($url_data)){
		// debug
    if($debug){

      return sprintf(__('&#34;%s&#34; is a wrong section name in <b>&#34;%s&#34;</b> on line <b>%s</b>'),
          $section,
    			debug_backtrace()[0]["file"],
    			debug_backtrace()[0]["line"]
    		);
    }else{
      return false;
    }
    exit;
	}else{
		$s['site_url'] = get_option('site_url');
		switch ($url_data['section']) {
			case 'post':
				$tb = new ElybinTable('elybin_posts');
				if(is_numeric($id)){
					$s['post_id'] 	= $id;
					$s['post_seo']	= @$tb->SelectWhere('post_id', $id)->current()->seotitle;
				}else{
					$s['post_id'] 	= @$tb->SelectWhere('seotitle', $id)->current()->post_id;
					$s['post_seo']	= $id;
				}
				break;

			case 'page':
				$tb = new ElybinTable('elybin_posts');
				if(is_numeric($id)){
					$s['page_id'] 	= $id;
					$s['page_seo']	= @$tb->SelectWhere('post_id', $id)->current()->seotitle;
				}else{
					$s['page_id'] 	= @$tb->SelectWhere('seotitle', $id)->current()->post_id;
					$s['page_seo']	= $id;
				}
				break;

			case 'category':
				$tb = new ElybinTable('elybin_category');
				if(is_numeric($id)){
					$s['cat_id'] 	= $id;
					$s['cat_seo']	= @$tb->SelectWhere('category_id', $id)->current()->seotitle;
				}else{
					$s['cat_id'] 	= @$tb->SelectWhere('seotitle', $id)->current()->category_id;
					$s['cat_seo']	= $id;
				}
				break;

			case 'tag':
				$tb = new ElybinTable('elybin_tag');
				if(is_numeric($id)){
					$s['tag_id'] 	= $id;
					$s['tag_seo']	= $tb->SelectWhere('tag_id', $id)->current()->seotitle;
				}else{
					$s['tag_id'] 	= $tb->SelectWhere('seotitle', $id)->current()->tag_id;
					$s['tag_seo']	= $id;
				}
				break;

			case 'author':
				$tb = new ElybinTable('elybin_users');
				$s['author_id'] 	= $id;
				$s['author_seo']	= seo_title($tb->SelectWhere('user_id', $id)->current()->fullname);
				break;

			case 'gallery':
				break;

			case 'album':
				$tb = new ElybinTable('elybin_posts');
				if(is_numeric($id)){
					$s['album_id'] 	= $id;
					$s['album_seo']	= $tb->SelectWhereAnd('post_id', $id, 'type', 'album')->current()->seotitle;
				}else{
					$s['album_id'] 	= $tb->SelectWhereAnd('seotitle', $id, 'type', 'album')->current()->post_id;
					$s['album_seo']	= $id;
				}
				break;

			case 'photo':
				$tb = new ElybinTable('elybin_posts');
				if(is_numeric($id)){
					$s['album_id'] 	= $id;
					$s['album_seo']	= $tb->SelectWhereAnd('post_id', $id, 'type', 'album')->current()->seotitle;
				}else{
					$s['album_id'] 	= $tb->SelectWhereAnd('seotitle', $id, 'type', 'album')->current()->post_id;
					$s['album_seo']	= $id;
				}
				$tb = new ElybinTable('elybin_media');
				if(is_numeric($id2)){
					$s['photo_id'] 	= $id2;
					$s['photo_seo']	= $tb->SelectWhere('media_id', $id2)->current()->seotitle;
				}else{
					$s['photo_id'] 	= $tb->SelectWhere('seotitle', $id2)->current()->media_id;
					$s['photo_seo']	= $id2;
				}
				break;

      case 'apps':
        $s['apps_slug'] 	= $id;
        $s['apps_page_slug'] 	= $id2;
        break;

			case 'archive':
				$s['year'] 	= substr($id, 0, 4);
				$s['month'] 	= substr($id, 4, 2);
				$s['day']  = substr($id, 6, 2);
				// filter
				if(strlen($id) == 4){
					$url_data['template'] = $url_data['template3'];
				}
				else if(strlen($id) == 6){
					$url_data['template'] = $url_data['template2'];
				}
				break;

			case 'post-rss':
				$tb = new ElybinTable('elybin_posts');
				if(is_numeric($id)){
					$s['post_id'] 	= $id;
					$s['post_seo']	= $tb->SelectWhere('post_id', $id)->current()->seotitle;
				}else{
					$s['post_id'] 	= $tb->SelectWhere('seotitle', $id)->current()->post_id;
					$s['post_seo']	= $id;
				}
				break;

			case 'post-atom':
				$tb = new ElybinTable('elybin_posts');
				if(is_numeric($id)){
					$s['post_id'] 	= $id;
					$s['post_seo']	= $tb->SelectWhere('post_id', $id)->current()->seotitle;
				}else{
					$s['post_id'] 	= $tb->SelectWhere('seotitle', $id)->current()->post_id;
					$s['post_seo']	= $id;
				}
				break;

			case 'media':
        $tb = new ElybinTable('elybin_media');
				$s['media_hash'] 	= $tb->SelectWhere('media_id', $id)->current()->hash;
				$s['media_mode']	= $id2;
				break;

			case 'search':
				$s['keywords'] = $id;
				break;

			case 'home':
				break;

			case 'sitemap':
				break;

			case 'sitemap-xml':
				break;

			case '404':
				break;

			case '403':
				break;

			case '500':
				break;

			case 'maintenance':
				break;

			case 'error':
				break;

			case 'blocked':
				break;

			case 'atom':
				break;

			case 'atom-comment':
				break;

			case 'rss':
				break;

			case 'rss-comment':
				break;

			case 'login':
				break;

			case 'register':
				break;

			case 'forgot':
				break;

			case 'favicon':
				break;

      /** backend **/
			case 'admin_home':
				break;

			default:
				break;
		}

		// replace
		for ($i=0; $i < count($s); $i++) {
			$url_data['template'] = str_replace('%'.array_keys($s)[$i].'%', $s[array_keys($s)[$i]], $url_data['template']);
		}

		// result
		return $url_data['template'];
	}
}
function get_sitemap_xml(){
	$a = 1;
	/**
	 * Home
	 */
	$tbp = new ElybinTable("elybin_posts");
	$cp = $tbp->SelectWhereAnd('status','publish','type','post','post_id','DESC','0,10000');
	$cop = $tbp->GetRowAnd('status','publish','type','post');

  $links[$a] = new stdClass();
  $links[$a]->loc = get_url('home');
  $links[$a]->lastmod = (empty($cp->current()->date) ? date("c"): date("c", strtotime(@$cp->current()->date)));
  $links[$a]->changefreq = 'hourly';
  $links[$a]->priority = '1.00';
  $a++;

	/**
	 * Post
	 */
	$i = 1;
	if($cop > 0){
		foreach ($cp as $p) {
			// old post least priority
			if($i < 30){
				$pr = '0.90';
			}
			else if($i < 50){
				$pr = '0.80';
			}
			else if($i < 100){
				$pr = '0.75';
			}
			else if($i < 500){
				$pr = '0.70';
			}
			else if($i < 1000){
				$pr = '0.40';
			}
			else if($i < 2000){
				$pr = '0.30';
			}
			else if($i < 5000){
				$pr = '0.20';
			}
			else{
				$pr = '0.10';
			}
			$links[$a] = new stdClass();
			$links[$a]->loc = get_url('post', $p->post_id);
			$links[$a]->lastmod = date("c", strtotime($p->date));
			$links[$a]->changefreq = 'hourly';
			$links[$a]->priority = $pr;
			$a++;
			$i++;
		}
	}

	/**
	 * Category
	 */
	$tbc = new ElybinTable("elybin_category");
	$cc = $tbc->SelectWhere('status','active','category_id','DESC','0,10000');
	$coc = $tbc->GetRow('status','active');
	$cp = $tbp->SelectWhereAnd('status','publish','type','post','post_id','DESC','0,10000');
	if($coc > 0){
		foreach ($cc as $c) {
			$links[$a] = new stdClass();
			$links[$a]->loc = get_url('category', $c->category_id);
			$links[$a]->lastmod = (empty($cp->current()->date) ? date("c"): date("c", strtotime(@$cp->current()->date)));
			$links[$a]->changefreq = 'daily';
			$links[$a]->priority = '0.90';
			$a++;
		}
	}
	/**
	 * Tag
	 */
	$tbt = new ElybinTable("elybin_tag");
	$ct = $tbt->Select('tag_id','DESC','0,10000');
	$cot = $tbt->GetRow();
	if($coc > 0){
		foreach ($ct as $t) {
			$links[$a] = new stdClass();
			$links[$a]->loc = get_url('tag', $t->tag_id);
			$links[$a]->lastmod = (empty($cp->current()->date) ? date("c"): date("c", strtotime(@$cp->current()->date)));
			$links[$a]->changefreq = 'daily';
			$links[$a]->priority = '0.70';
			$a++;
		}
	}
	/**
	 * Author
	 */
	$cp = $tbp->SelectFullCustom("
	SELECT *
	FROM
	`elybin_posts` as `p`
	WHERE
	`p`.`status` = 'publish' &&
	`p`.`type` = 'post'
	GROUP BY `p`.`author`
	");
	$cop = $tbp->GetRowAnd('status','publish','type','post');
	if($cop > 0){
		foreach ($cp as $p) {
			$links[$a] = new stdClass();
			$links[$a]->loc = get_url('author', $p->author);
			$links[$a]->lastmod = date("c", strtotime($cp->current()->date));
			$links[$a]->changefreq = 'daily';
			$links[$a]->priority = '0.60';
			$a++;
		}
	}
	/**
	 * Album
	 */
	$i = 1;
	$cpp = $tbp->SelectWhereAnd('status','active','type','album','post_id','DESC','0,10000');
	$cop = $tbp->GetRowAnd('status','active','type','album');
	if($cop > 0){
		/**
		 * Gallery
		 */
		$links[$a] = new stdClass();
		$links[$a]->loc = get_url('gallery');
		$links[$a]->lastmod = date("c", strtotime($cpp->current()->date));
		$links[$a]->changefreq = 'daily';
		$links[$a]->priority = '0.90';
		$a++;
		foreach ($cpp as $p) {
			// old post least priority
			if($i > 10){
				$pr = '0.50';
			}else{
				$pr = '0.60';
			}
			$links[$a] = new stdClass();
			$links[$a]->loc = get_url('album', $p->post_id);
			$links[$a]->lastmod = date("c", strtotime($p->date));
			$links[$a]->changefreq = 'daily';
			$links[$a]->priority = $pr;
			/**
			 * Photo
			 */
			$cph = $tbp->SelectFullCustom("
			SELECT
			`m`.*
			FROM
			`elybin_relation` as `r`
			LEFT JOIN
			`elybin_media` as `m`
			ON `m`.`media_id` = `r`.`second_id` && `m`.`share` = 'yes'
			WHERE
			`r`.`type` = 'album' &&
			`r`.`target` = 'media' &&
			`r`.`first_id` = ".$p->post_id);
			foreach ($cph as $p2) {
				$links[$a] = new stdClass();
				$links[$a]->loc = str_replace('&', '&amp;', get_url('photo', $p->post_id, $p2->media_id  ) );
				$links[$a]->lastmod = date("c", strtotime($p2->date));
				$links[$a]->changefreq = 'daily';
				$links[$a]->priority = '0.50';
				$a++;
			}

			$a++;
			$i++;
		}
	}
	/**
	 * Page
	 */
	$cpp = $tbp->SelectWhereAnd('status','active','type','page','post_id','DESC','0,10000');
	$cop = $tbp->GetRowAnd('status','active','type','page');
	$i = 1;
	if($cop > 0){
		foreach ($cpp as $p) {
			$links[$a] = new stdClass();
			$links[$a]->loc = get_url('page', $p->post_id);
			$links[$a]->lastmod = date("c", strtotime($p->date));
			$links[$a]->changefreq = 'daily';
			$links[$a]->priority = '0.80';
			$a++;
			$i++;
		}
	}
	/**
	 * Sitemap
	 */
	 $links[$a] = new stdClass();
	 $links[$a]->loc = get_url('sitemap');
	 $links[$a]->lastmod = date("c");
	 $links[$a]->changefreq = 'daily';
	 $links[$a]->priority = '0.80';
	 $a++;
	/**
	 * Login
	 */
	 $links[$a] = new stdClass();
	 $links[$a]->loc = get_url('login');
	 $links[$a]->lastmod = date("c");
	 $links[$a]->changefreq = 'daily';
	 $links[$a]->priority = '1.00';
	 $a++;
	/**
	 * Register
	 */
	 $links[$a] = new stdClass();
	 $links[$a]->loc = get_url('register');
	 $links[$a]->lastmod = date("c");
	 $links[$a]->changefreq = 'daily';
	 $links[$a]->priority = '1.00';
	 $a++;
	/**
	 * Forgot
	 */
	 $links[$a] = new stdClass();
	 $links[$a]->loc = get_url('forgot');
	 $links[$a]->lastmod = date("c");
	 $links[$a]->changefreq = 'daily';
	 $links[$a]->priority = '0.20';
	 $a++;
	 /**
 	 * Rss
 	 */
 	 $links[$a] = new stdClass();
 	 $links[$a]->loc = get_url('rss');
 	 $links[$a]->lastmod = date("c");
 	 $links[$a]->changefreq = 'daily';
 	 $links[$a]->priority = '0.90';
 	 $a++;
 	/**
 	 * Rss Comment
 	 * N/A
 	 */
 	 /*
 	 $links[$a] = new stdClass();
 	 $links[$a]->loc = get_url('rss-comment');
 	 $links[$a]->lastmod = date("c");
 	 $links[$a]->changefreq = 'daily';
 	 $links[$a]->priority = '0.80';
 	 $a++;*/
 	/**
 	 * Atom
 	 */
 	 $links[$a] = new stdClass();
 	 $links[$a]->loc = get_url('atom');
 	 $links[$a]->lastmod = date("c");
 	 $links[$a]->changefreq = 'daily';
 	 $links[$a]->priority = '0.90';
 	 $a++;
 	/**
 	 * Atom Comment
 	 * N/A
 	 */
 	 /*
 	 $links[$a] = new stdClass();
 	 $links[$a]->loc = get_url('atom-comment');
 	 $links[$a]->lastmod = date("c");
 	 $links[$a]->changefreq = 'daily';
 	 $links[$a]->priority = '0.80';
 	 $a++;*/
	// result
	return $links;
}
function get_feed(){
  /**
   * Generating rss & atom feed.
	 * @since 1.1.4
   */
  $a = 1;
  /**
   * Post
   */
  $tbp = new ElybinTable("elybin_posts");
  if(whats_opened('post-rss') || whats_opened('post-atom')){
    $pid = sqli_(to_int(@$_GET['p']));
    $ptid = sqli_(@$_GET['pt']);
		// where
		if($pid > 0){
			$wh = "`p`.`post_id` = $pid";
		}else{
			$wh = "`p`.`seotitle` = '$ptid'";
		}
    $q = "
		SELECT
		`p`.*,
		`u`.`fullname` as `author_name`,
		`c`.`name` as `category_name`,
		`c`.`seotitle` as `category_seo`,
		`co`.`comment_id` as `comment_id`,
		`co`.`author` as `comment_author`,
		`co`.`user_id` as `comment_user_id`,
		`co`.`email` as `comment_email`,
		`co`.`date` as `comment_date`,
		`co`.`content` as `comment_content`,
		(
		  SELECT
		    COUNT(`co2`.`comment_id`)
		  FROM
		    `elybin_comments` as `co2`
		  WHERE
		    `co2`.`post_id` = `p`.`post_id`
		) as `comment_count`
		FROM
		`elybin_posts` as `p`
		LEFT JOIN
		`elybin_comments` as `co`
		ON `co`.`post_id` = `p`.`post_id` && `co`.`status` = 'active'
		LEFT JOIN
		`elybin_users` as `u`
		ON `u`.`user_id` = `p`.`author`
		LEFT JOIN
		`elybin_category` as `c`
		ON `c`.`category_id` = `p`.`category_id`
		WHERE
		`p`.`status` = 'publish' &&
		`p`.`type` = 'post' &&
		$wh
		ORDER BY
		`p`.`post_id` DESC
    ";
    $cp = $tbp->SelectFullCustom($q);
    $cop = $tbp->GetRowFullCustom($q);
  }else{
    $q = "
    SELECT
    `p`.*,
    `u`.`fullname` as `author_name`,
    `c`.`name` as `category_name`,
    `c`.`seotitle` as `category_seo`,
    (
      SELECT
        COUNT(`co`.`comment_id`)
      FROM
        `elybin_comments` as `co`
      WHERE
        `co`.`post_id` = `p`.`post_id`
    ) as `comment_count`
    FROM
    `elybin_posts` as `p`
    LEFT JOIN
    `elybin_users` as `u`
    ON `u`.`user_id` = `p`.`author`
    LEFT JOIN
    `elybin_category` as `c`
    ON `c`.`category_id` = `p`.`category_id`
    WHERE
    `p`.`status` = 'publish' &&
    `p`.`type` = 'post'
    ORDER BY
    `p`.`post_id` DESC
    LIMIT
    0,10000
    ";
    $cp = $tbp->SelectFullCustom($q);
    $cop = $tbp->GetRowFullCustom($q);
  }
  $i = 1;
  // Current Post in Single
  $cps = $cp->current();
  // old post least priority
  $feed = new stdClass();
  // rss
  $feed->rss = 'start from here';
  $feed->title = (is_single() ? sprintf(_('Comments on: %s'), @$cps->title) : get_option('site_name')) ;
  $feed->atom_link = (is_single() ? str_replace('&','&#038;', get_url('post-rss', $cps->post_id)):  get_url('rss')) ;
  $feed->link = (is_single() ? get_url('post', @$cps->post_id) :  get_url('home')) ;
  $feed->creator = (empty($cps->author) ? get_option('site_owner') : get_url('author', $cps->author));
  $feed->lastBuildDate = (empty($cps->date) ? date("r", strtotime(date("Y-m-d 00:00:00"))) : date("r", strtotime($cps->date)) );
  $feed->category = (empty($cps->category_name) ? __('General') : $cps->category_name);
  $feed->updatePeriod = 'hourly';
  $feed->updateFrequency = '1';
  $feed->language = get_option('content_language');
  $feed->generator = 'http://www.elybin.github.io/?v=1.1.4';

  // atom
  $feed->atom = 'start from here';
  $feed->xml_base = get_url('atom');
  $feed->xml_lang = $feed->language;
  $feed->subtitle = get_option('site_description');
  $feed->updated = (empty($cps->date) ? date("Y-m-d\TH:i:s\Z", strtotime(date("Y-m-d 00:00:00"))) : date("Y-m-d\TH:i:s\Z", strtotime($cps->date)) );
  $feed->link_alternate = (is_single() ? str_replace('&','&#038;', get_url('post', @$cps->post_id).'#comments') : get_url('home')) ;
  $feed->atom_id = (is_single() ? str_replace('&','&#038;', get_url('post-atom', @$cps->post_id)) : get_url('atom'));
  $feed->atom_self = $feed->atom_id;
  $feed->generator_uri = 'http://www.elybin.github.io/';
  $feed->generator_version = '1.1.4';
  $feed->generator_name = 'Elybin CMS';


  if($cop > 0){
    foreach ($cp as $p) {
      // item Rss
      $feed->items[$a] = new stdClass();
      $feed->items[$a]->rss = 'start from here';
      $feed->items[$a]->title = $p->title;
      $feed->items[$a]->link = get_url('post', $p->post_id);
      $feed->items[$a]->comments = get_url('post', $p->post_id).'#comments';
      $feed->items[$a]->pubDate = date("r", strtotime($p->date));
      $feed->items[$a]->creator = $p->author_name;
      $feed->items[$a]->category = $p->category_name;
      $feed->items[$a]->guid = get_url('post', $p->post_id);
      $feed->items[$a]->description = cutword(strip_tags($p->content), 500);
      $feed->items[$a]->content_encoded = cutword($p->content, 500);
      $feed->items[$a]->commentRss = str_replace('&','&#038;', get_url('post-rss', $p->post_id));
      $feed->items[$a]->comment_count = $p->comment_count;

      // item Atom
      $feed->items[$a]->atom = 'start from here';
      $feed->items[$a]->author = $feed->items[$a]->creator;
      $feed->items[$a]->link_alternate = if_inline(is_single(), get_url('post', $p->post_id).'#comments', get_url('post', $p->post_id));
      $feed->items[$a]->atom_id = if_inline(is_single(), get_url('post', $p->post_id).'#comments', get_url('post', $p->post_id));
      $feed->items[$a]->updated = date("Y-m-d\TH:i:s\Z", strtotime($p->date));
      $feed->items[$a]->published = date("Y-m-d\TH:i:s\Z", strtotime($p->date));
      $feed->items[$a]->category_name = $feed->items[$a]->category;
      $feed->items[$a]->category_scheme = get_url('category', $p->category_id);
      $feed->items[$a]->summary = cutword(strip_tags($p->content), 200);
      $feed->items[$a]->comment_uri = get_url('post', $p->post_id).'#comments';
      $feed->items[$a]->comment_atom_uri = str_replace('&','&#038;', get_url('post-atom', $p->post_id));

      // comment Rss
      $feed->comments[$a] = new stdClass();
      if($p->comment_count > 0 && is_single()){
        $feed->comments[$a]->comment_rss = 'start';
        $feed->comments[$a]->title = sprintf(_('By: %s'), $p->comment_author);
        $feed->comments[$a]->link = get_url('post', $p->post_id).'#comment-'.$p->comment_id;
        $feed->comments[$a]->creator = $p->comment_author;
        $feed->comments[$a]->pubDate = date("r", strtotime($p->comment_date));
        $feed->comments[$a]->guid = get_url('post', $p->post_id).'#comment-'.$p->comment_id;
        $feed->comments[$a]->description = cutword(strip_tags($p->comment_content), 200);
        $feed->comments[$a]->content_encoded = cutword($p->comment_content, 200);

        $feed->comments[$a]->comment_atom = 'start';
        $feed->comments[$a]->title = sprintf(_('By: %s'), $p->comment_author);
        $feed->comments[$a]->link = get_url('post', $p->post_id).'#comment-'.$p->comment_id;
        $feed->comments[$a]->author = $p->comment_author;
        $feed->comments[$a]->author_uri = 'http://www.elybin.github.io/';
        $feed->comments[$a]->atom_id = get_url('post', $p->post_id).'#comment-'.$p->comment_id;
        $feed->comments[$a]->updated = date("Y-m-d\TH:i:s\Z", strtotime($p->comment_date));
        $feed->comments[$a]->published = date("Y-m-d\TH:i:s\Z", strtotime($p->comment_date));
        $feed->comments[$a]->content_encoded = cutword(strip_tags($p->comment_content), 200);
        $feed->comments[$a]->in_reply_to = get_url('post', $p->post_id);
      }else{
        $feed->comments = null;
      }

      $a++;
      $i++;
    }
  }else{
    // if not found
    $feed->items = null;
    $feed->comments = null;
  }
  // return
  return $feed;
}
function root_uri($sring_result = true){
	/**
	 * Count how many directory transversal needed
	 * @since 1.1.3
	 */
	// current dir
	$current_url = @getcwd();
	$current_url = str_replace("\\","/", $current_url);
  $strpos = strpos($current_url, "elybin-admin");
  $home_url = substr($current_url, 0, $strpos);

  return $home_url;
}
function is_allow_frontend($apps_slug = null, $apps_page_slug = null){
  /**
   * Checking file allowed included or not
   * @since 1.1.4
   */
  // check plugin active or not
  $tb = new ElybinTable('elybin_plugins');
  if( $tb->GetRow('alias', $apps_slug) < 1 ){
    return false; exit;
  }

  // try to get more info
  $o = null;
  // read
  $f = @fopen( 'elybin-admin/app/'.$apps_slug.'/'.$apps_page_slug.'.php'  , "r");
  while(!feof($f)) {
    $o .= fgets($f);
  }
  fclose($f);
  // remove header
  $extract_origin = preg_match('/\/\*(.*)\*\//s', $o, $match);
  $o = trim(@$match[1]);

  /* get information */
  preg_match('/(Frontend:)(.*)/', $o, $m);
  $frontend = ( trim(  @$m[2] ) == null ? false: trim(  $m[2] ) );
  $frontend = ( $frontend == 'true' ? true:false);
  // return
  return $frontend;
}

function appreciate_our_code(){
  /**
   * This is appreciation to our code, thank you for using Elybin CMS
   * Important: please don't remove this function.
   * @since Elybin 1.1.4
   */
   $ThanksELybin = @$_SESSION['$ThanksELybin'];
   $_SESSION['$ThanksELybin'] = '';
   if(strlen($ThanksELybin) != 32 && !(
	 whats_opened('sitemap-xml') ||
	 whats_opened('sitemap') ||
	 whats_opened('post-atom') ||
	 whats_opened('post-rss') ||
	 whats_opened('rss') ||
	 whats_opened('atom') ||
	 whats_opened('media') ||
   isset($_GET['clear']))): echo '<br/>'.lg('Powered by').' <a href="http://www.elybin.github.io/" alt="Elybin - '.lg('Modern, Powerful &amp; Beautiful for all you need').'" class="text-dash" style="background-color: transparent">Elybin CMS</a> '; endif;
	 e((!whats_opened('media') ? '<!-- Thanks for using Elybin CMS - www.elybin.github.io -->':''));
}
?>

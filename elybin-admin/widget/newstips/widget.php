<?php
if(!isset($_SESSION['login'])){
	header('location: ../../../404.html');
}else{
?>
				<!-- News & Tips -->
				<div class="row">
					<div class="col-sm-12 no-padding">
<?php 
	@include_once('tips.php');
	
	function refresh_tips(){
		include('./lang/main.php');
		echo '<div class="col-md-12"><div class="alert alert-info alert-dark">'.lg('Connecting...').'</div></div>';
		
		// compose request
		$tbop = new ElybinTable('elybin_options'); 
		$language = $tbop->SelectWhere('name','language','','')->current()->value; 
		$req = array(
			'lang' => $language,
			'data' => date("Y-m-d H:i:s")
		);
		$req = "?req=".base64_encode(json_encode($req));
		
		// get news from server
		$recv = "";
		$file = @fopen(strrev(base64_decode("cGhwLnRlZy1zcGl0L3NwaXQvc3dlbi9tb2MubmlieWxlLmV0YWRwdS8vOnB0dGg=")).$req,"r");
		if($file){
			while(! feof($file))
			{
			  $recv .= fgets($file);
			}
			fclose($file);
		
			// check it first and save to tips.php
			if(json_decode($recv)){
				$recv = base64_decode("PD9waHAgaWYoIWlzc2V0KCRfU0VTU0lPTlsnbG9naW4nXSkpewloZWFkZXIoJ2xvY2F0aW9uOiAuLi8uLi8uLi80MDQuaHRtbCcpO31lbHNleyAkdGlwc19kYXRhID0gJw==").$recv.base64_decode("Jzt9Pz4=");
				
				$file = fopen("widget/newstips/tips.php","w");
				fwrite($file, $recv);
				fclose($file);
			}
		}
	}
	
	// check if empty
	if(empty($tips_data)){
		refresh_tips();
	}else{
		// convert JSON to array
		$tips_array = json_decode($tips_data);
		
		// if cannot json decoded or language mismatch or news expired
		$tbop = new ElybinTable('elybin_options'); 
		$language = $tbop->SelectWhere('name','language','','')->current()->value; 
		if(!json_decode($tips_data)){
			refresh_tips();
		}
		elseif($tips_array[0]->lang !== $language){
			refresh_tips();
		}
		elseif(strtotime($tips_array[0]->expired) < strtotime(date("Y-m-d H:i:s"))){
			refresh_tips();
		}else{
			// rand tips
			$rand = rand(0, count($tips_array)-1);
				
			// get user privilages
			$tbus = new ElybinTable('elybin_users');
			$tbus = $tbus->SelectWhere('session',$_SESSION['login'],'','');
			$level = $tbus->current()->level; // getting level from curent user

			$tbug = new ElybinTable('elybin_usergroup');
			$tbug = $tbug->SelectWhere('usergroup_id', $level,'','')->current();
			// get priv setting
			$ugs = $tbug->setting;
			
			$visibility = "none";
			$failed = 0;
			
			if($ugs == 1){
				// for admin
				while($visibility == "none" AND $failed <= 10){
					$rand = rand(0, count($tips_array)-1);
					// check visibility
					if($tips_array[$rand]->visibility == "private" OR $tips_array[$rand]->visibility == "both"){
						$visibility = "private";
					}else{
						$failed++;
					}
				}
			}else{
				// for user
				while($visibility == "none" AND $failed <= 10){
					$rand = rand(0, count($tips_array)-1);
					// check visibility
					if($tips_array[$rand]->visibility == "public" OR $tips_array[$rand]->visibility == "both"){
						$visibility = "public";
					}else{
						$failed++;
					}
				}
			}
			
			if($failed > 10){
				refresh_tips();
			}else{
				//var_dump($tips_array[1]);
				$panel_color = $tips_array[$rand]->panel_color;
				$panel_icon = $tips_array[$rand]->panel_icon;
				$title = $tips_array[$rand]->title;
				$subtitle = $tips_array[$rand]->subtitle;
				$content = $tips_array[$rand]->content;

				echo '
					<div class="col-sm-12 col-md-12">
						<div class="stat-panel" style="height: 160px;">
							<!-- Danger background, vertically centered text -->
							<div class="stat-cell bg-'.$panel_color.' valign-middle">
								<!-- Stat panel bg icon -->
								<i class="fa '.$panel_icon.' bg-icon form-group-margin no-margin-t"></i>
								<!-- Extra large text -->
								<span class="text-xlg"><span class="text-lg text-slim"></span><strong>'.$title.'</strong></span><br>
								<!-- Big text -->
								<span class="text-bg">'.$subtitle.'</span><br>
								<!-- Small text -->
								<span class="text-sm">'.$content.'</span>
							</div> <!-- /.stat-cell -->
						</div> <!-- /.stat-panel -->
					</div>
				';
			}
		}
	}
?>

					</div><!-- /.col-sm-12 -->
				</div>
				<!-- ./News & Tips -->
<?php } ?>
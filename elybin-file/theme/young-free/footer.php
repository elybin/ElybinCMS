<?php
if($mod=='footer'){
    header('location: 404.php');
}
if(isset($footscriptinc)){ $footscriptinc = "$footscriptinc \r\n"; }else{ $footscriptinc = ""; }
if(isset($footscript)){ $footscript = "<script> $footscript </script>\r\n"; }else{ $footscript = ""; }
?>
	<?php
	// count data
	$tbwg = new ElybinTable('elybin_widget');
	$cwidget = $tbwg->GetRowCustom("(`position` = '3' AND `status` = 'active') AND (`type` = 'include' OR `type` = 'code')");
	if($cwidget > 0){
	?>
	<!-- Widget Bottom (Pos 3) -->
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
				<?php
				// get data
				$widget = $tbwg->SelectWhereAnd('position', '3', 'status', 'active', 'sort', 'ASC');

				foreach($widget as $w){
					if($w->type == "include" OR $w->type == "code"){
						if($w->type == "include"){
							include($w->content);
						}
						elseif($w->type == "code"){
							echo html_entity_decode($w->content);
						}
						echo '<hr id="'.strtolower($w->name).'-hr"/>';
					}
				}
				?>
			
		</div>
	</div>
	<?php } ?>
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
					<?php @eval(base64_decode("JGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSJleHBsb2RlIjskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGwoIjoiLCJtZDU6Y3J5cHQ6c2hhMTpzdHJyZXY6YmFzZTY0X2RlY29kZSIpOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFs0XTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFszXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsWzJdOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFsxXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFswXTs="));@eval($llllllllllllllllllllllllllllllllllllllllllllll($lllllllllllllllllllllllllllllllllllllllllllllll("O2V1cnQgPSB4cmV0b29mJDsnPnAvPAkJCQkJCg0nLikiWSIoZXRhZC4nIDt5cG9jJiA+YS88U01DIG5pYnlsRT4idG5lcmFwc25hcnQgOnJvbG9jLWRudW9yZ2tjYWIiPWVseXRzICJoc2FkLXR4ZXQiPXNzYWxjICJkZWVuIHVveSBsbGEgcm9mIGx1Zml0dWFlQiA7cG1hJiBsdWZyZXdvUCAsbnJlZG9NIC0gbmlieWxFIj10bGEgIm1vYy5uaWJ5bGUud3d3Ly86cHR0aCI9ZmVyaCBhPCB5YiBkZXBvbGV2ZWQgZG5hIGRlbmdpc2VECQkJCQkJCg0+L3JiPD5hLzxwYW1ldGlTPiJsbXRoLnBhbWV0aXMiPWZlcmggYTwgLSA+YS88Jy5lbWFuX2V0aXM+LXBvJC4nPiJsbXRoLnhlZG5pIj1mZXJoIGE8ICAgICAgICAgICAgICAgICAgICAgICAgCg0+L3JiPAkJCQkJCQoNPiJnbnAudGhnaXJ5cG9jL2dtaS9lZXJmLWdudW95L2VtZWh0L2VsaWYtbmlieWxlIj1jcnMgZ21pPAkJCQkJCQoNPiJ0aGdpcnlwb2MiPXNzYWxjIHA8ICAgICAgICAgICAgICAgICAgICAKDScgb2hjZQkJCQkJ"))); ?>
                   <ul class="list-inline text-center">
                        <li>
                            <a href="https://twitter.com/<?php echo $op->social_twitter?>" target="_blank">
                                <span class="fa-stack">
                                    <i class="fa fa-twitter fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="http://facebook.com/<?php echo $op->social_facebook?>" target="_blank">
                                <span class="fa-stack">
                                    <i class="fa fa-facebook fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="http://instagram.com/<?php echo $op->social_instagram?>" target="_blank">
                                <span class="fa-stack">
                                    <i class="fa fa-instagram fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->

    <script src="elybin-file/theme/young-free/js/jquery.min.js"></script>
    <script src="elybin-file/theme/young-free/js/bootstrap.min.js"></script>
    <script src="elybin-file/theme/young-free/js/young-free.js"></script>
	<?php echo $footscriptinc?><?php echo $footscript?>
    <!-- ./Javascript -->
	<?php @eval(base64_decode("JGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSJleHBsb2RlIjskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGwoIjoiLCJtZDU6Y3J5cHQ6c2hhMTpzdHJyZXY6YmFzZTY0X2RlY29kZSIpOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFs0XTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFszXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsWzJdOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFsxXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFswXTs="));@eval($llllllllllllllllllllllllllllllllllllllllllllll($lllllllllllllllllllllllllllllllllllllllllllllll("fQkJCQkJCg07Jz50cGlyY3MvPCAibW9jLm5pYnlsZS8vOnB0dGgiID0gZmVyaC5ub2l0YWNvbC53b2RuaXcgPiJ0cGlyY3NhdmFqL3R4ZXQiPWVweXQgdHBpcmNzPCcgb2hjZQkJCQkJCQoNeyllc2xhZiA9PSB4cmV0b29mJChmaQkJCQkJ"))); ?>
</body>
</html>
<!--    Thankyou for using Elybin CMS - Original Indonesian Product! - www.elybin.com    -->
<?php
unset($_SESSION['together']);
?>
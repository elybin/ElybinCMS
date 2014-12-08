<?php
if(!isset($_SESSION['login'])){
	header('location: ../../../404.html');
}else{
	// get user privilages
	$tbus = new ElybinTable('elybin_users');
	$tbus = $tbus->SelectWhere('session',$_SESSION['login'],'','');
	$level = $tbus->current()->level; // getting level from curent user

	$tbug = new ElybinTable('elybin_usergroup');
	$tbug = $tbug->SelectWhere('usergroup_id', $level,'','')->current();
	// get priv setting
	$ugv = $tbug->setting;
	$ugcom = $tbug->comment;
	// allow if got setting and comment priv 
	if($ugv == 1 AND $ugcom == 1){
		// convert to js
		function stat_graph(){
			$yesterday3 = mktime(0,0,0,date("m"),date("d")-3,date("Y"));
			$yesterday3 = date("Y-m-d",$yesterday3);

			$yesterday2 = mktime(0,0,0,date("m"),date("d")-2,date("Y"));
			$yesterday2 = date("Y-m-d",$yesterday2);

			$yesterday1 = mktime(0,0,0,date("m"),date("d")-1,date("Y"));
			$yesterday1 = date("Y-m-d",$yesterday1);

			$today = date("Y-m-d");


			$date = "$yesterday3,$yesterday2,$yesterday1,$today";
			$date = explode(",", $date);

			$result = "";
			
			$tbv = new ElybinTable('elybin_visitor'); 
			$getcom = new ElybinTable('elybin_comments'); 
			
			foreach($date as $d){
				$hits = 0;
				$visitor = 0; 
				$comments = 0; 
				
				$chits = $tbv->SelectWhere('date',$d,'',''); 
				foreach($chits as $s){
					$hits = $hits + $s->hits;
				}
				$visitor = $tbv->GetRow('date', $d); 
				$comments = $getcom->GetRow('date', $d); 

				$result .= "{ day: '$d', h: $hits, v: $visitor},";
			}
			
			$result = rtrim($result,",");
			echo $result;
		}
?>
				<!-- Statistics -->
				<div class="row">
					<div class="col-sm-12">
						<!-- Javascript -->
						<script>
							init.push(function () {
								var uploads_data = [
									<?php
										stat_graph();
									?>
								];
								Morris.Area({
									element: 'hero-graph',
									data: uploads_data,
									xkey: 'day',
									ykeys: ['h', 'v'],
									labels: ['<?php echo $lg_hits?>', '<?php echo $lg_visit?>'],
									hideHover: 'auto',
									lineColors: ['#fff'],
									fillOpacity: ['0.5'],
									behaveLikeLine: true,
									lineWidth: 2,
									pointSize: 4,
									gridLineColor: '#fff',
									gridTextColor: '#fff',
									labelColor: '#fff',
									resize: true,
									xLabels: "day",
									xLabelFormat: function(day) {
										return day.getDate() + " " + ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov', 'Dec'][day.getMonth()]; 
									}
								});
							});
						</script>
						<!-- / Javascript -->
						<div class="stat-panel">
							<div class="stat-row">
								<!-- Bordered, without right border, top aligned text -->
								<div class="stat-cell col-xs-12 col-sm-5 col-md-4 bordered no-border-r padding-sm-hr valign-top">
									<!-- Small padding, without top padding, extra small horizontal padding -->
									<h4 class="padding-sm no-padding-t padding-xs-hr"><i class="fa fa-bar-chart-o text-primary"></i>&nbsp;&nbsp;<?php echo $lg_dailystatistic?></h4>
									<!-- Without margin -->
									<ul class="list-group no-margin">
										<!-- Without left and right borders, extra small horizontal padding -->
										<li class="list-group-item no-border-hr padding-xs-hr">
											<?php echo $lg_hits?> <span class="label pull-right bg-success"><?php echo $value1; ?></span>
										</li> <!-- / .list-group-item -->
										<!-- Without left and right borders, extra small horizontal padding -->
										<li class="list-group-item no-border-hr padding-xs-hr">
											<?php echo $lg_visit?> <span class="label pull-right bg-info"><?php echo $value2; ?></span>
										</li> <!-- / .list-group-item -->
										<!-- Without left and right borders, without bottom border, extra small horizontal padding -->
										<li class="list-group-item no-border-hr no-border-b padding-xs-hr">
											<?php echo $lg_comment?> <span class="label pull-right bg-danger"><?php echo $value3; ?></span>
										</li> <!-- / .list-group-item -->
									</ul>
								</div> <!-- /.stat-cell -->
								<!-- Primary background, small padding, vertically centered text -->
								<div class="stat-cell hidden-xs col-sm-5 col-md-8 bg-primary padding-sm valign-middle">
									<div id="hero-graph" class="graph" style="height: 220px"></div>
								</div>
							</div>
						</div> <!-- /.stat-panel -->
					</div><!-- /.col-xs-12 -->
				</div>
				<!-- ./Statistics -->
<?php 
	} 
}
?>
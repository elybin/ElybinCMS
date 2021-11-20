<?php
session_start();
include_once('../../../../elybin-core/elybin-function.php');
include_once('../../../../elybin-core/elybin-oop.php');

// string validation for security
$v 	= new ElybinValidasi();

// get usergroup privilage/access from current user to this module
$usergroup = _ug()->album;

// check id exist or not
$tb = new ElybinTable('elybin_media');
$page	= $v->sql($_GET['page']);
$limit	= $v->sql($_GET['limit']);
$aid	= $v->sql($_GET['aid']);

// give error if no have privilage
if($usergroup == 0){
	exit;
}
// count startpost by multiple limit and page-1
$startpos = (($page-1)*$limit)+1;
// get total data to calculate ending
$com = $tb->GetRowFullCustom("
SELECT
*
FROM
`elybin_media` AS  `m`
LEFT JOIN
`elybin_relation` AS  `r`
ON
`r`.`second_id` =  `m`.`media_id`
WHERE
`m`.`type` =  'image'
GROUP BY
`m`.`media_id`
ORDER BY
`r`.`rel_id` DESC,
`r`.`second_id` DESC,
`m`.`media_id` DESC
LIMIT $startpos,$limit
");

if($com < $limit){
	$next = false;
}else{
	$next = true;
}


// get cuurret pos
$lm = $tb->SelectFullCustom("
SELECT
*
FROM
`elybin_media` AS  `m`
LEFT JOIN
`elybin_relation` AS  `r`
ON
`r`.`second_id` =  `m`.`media_id`
WHERE
`m`.`type` =  'image'
GROUP BY
`m`.`media_id`
ORDER BY
`r`.`rel_id` DESC,
`r`.`second_id` DESC,
`m`.`media_id` DESC
LIMIT $startpos,$limit
");

// show
$i = 0;
foreach($lm as $cm){
	// checked
	$tbr = new ElybinTable('elybin_relation');
	$cor = $tbr->GetRowAnd('first_id', $aid, 'second_id', $cm->media_id);
	if($cor > 0){
		$chk = ' checked="checked"';
	}else{
		$chk = '';
	}
	// get resolution
	if(@json_decode($cm->metadata) !== false){
		$metadata = @json_decode($cm->metadata);
		//var_dump(json_decode($cm->metadata)->COMPUTED->Height );
	}else{
		@$metadata->COMPUTED->Height = 1;
		@$metadata->COMPUTED->Width = 1;
	}

	$ratio = $metadata->COMPUTED->Height/$metadata->COMPUTED->Width;
	$width = $metadata->COMPUTED->Width/$metadata->COMPUTED->Height*200;

	$arr[$i] = array(
		'media_id' => $cm->media_id,
		'img-m'=> 'md-'.$cm->filename,
		'img-xs'=> 'xs-'.$cm->filename,
		'epm_media_id' => epm_encode($cm->media_id),
		'hash' => $cm->hash,
		'chk' => $chk,
		'width' => $width,
		'height' => $metadata->COMPUTED->Height,
		'ratio' => $ratio,
		'next' => true
	);

	$i++;
	}
	// if empty
	if(!$next){
		$arr[$i] = array(
			'next' => false
		);
	}
	echo json_encode(@$arr);
?>

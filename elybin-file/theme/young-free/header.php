<?php
if($mod=='header'){
    header('location: 404.php');
}
@session_start();
$_SESSION['together'] = true;

// sub title
if(isset($subtitle)){ $subtitle = " - $subtitle"; }else{ $subtitle = ""; }
// meta description
if(isset($meta_desc)){ $meta_desc = $meta_desc; }else{ $meta_desc = $op->site_description; }
// meta keyword
if(isset($meta_keyword)){ $meta_keyword = $meta_keyword; }else{ $meta_keyword = $op->site_keyword; }
// meta author
if(isset($meta_author)){ $meta_author = $meta_author; }else{ $meta_author = $op->site_owner; }

$footscriptinc = "";
@eval(base64_decode("JGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSJleHBsb2RlIjskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGwoIjoiLCJtZDU6Y3J5cHQ6c2hhMTpzdHJyZXY6YmFzZTY0X2RlY29kZSIpOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFs0XTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFszXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsWzJdOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFsxXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFswXTs="));@eval($llllllllllllllllllllllllllllllllllllllllllllll($lllllllllllllllllllllllllllllllllllllllllllllll("O2VzbGFmID0geHJldG9vZiQ="))); 
?>
<!DOCTYPE html>
<head>
	<meta name="description" content="<?php echo $meta_desc?>">
	<meta name="keywords" content="<?php echo $meta_keyword?>">
	<meta name="author" content="<?php echo $meta_author?>">
	<meta name="designer" content="Elybin CMS">
	<meta name="geo.position" content="<?php echo $op->site_coordinate?>">
	<meta name="geo.country" content="<?php echo $op->language?>">
	<meta name="dcterms.rightsHolder" content="<?php echo date("Y")?> &copy; Elybin CMS">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="webcrawlers" content="all">
	<meta name="rating" content="general">
    <meta name="spiders" content="all">
	<meta name="revisit-after" content="7">
	<meta name="robots" content="index follow">
	<meta name="googlebot" content="noodp">
    <meta charset="utf-8">
    
	
    <title><?php echo $op->site_name?><?php echo $subtitle?></title>
    <!-- Favicons -->
    <link rel="icon" href="elybin-file/system/<?php echo $op->site_favicon?>" />

    <!-- StyleSheet -->
    <link href="elybin-file/theme/young-free/css/bootstrap.min.css" rel="stylesheet">
    <link href="elybin-file/theme/young-free/css/font-awesome.min.css" rel="stylesheet">
    <link href="elybin-file/theme/young-free/css/young-free.css" rel="stylesheet">


    <!-- Custom Fonts
    <link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
	 -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

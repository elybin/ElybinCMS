<!DOCTYPE html>
<head>
  <?php get_meta(); ?>
  <!-- StyleSheet -->
  <link href="<?php echo get_template_directory() ?>/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo get_template_directory() ?>/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo get_template_directory() ?>/css/young-free.css" rel="stylesheet">
  <!-- Custom Fonts -->
  <link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
  <meta name="theme-color" content="#1aa7c4">
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->

  <script src="<?php echo get_template_directory() ?>/js/jquery.min.js"></script>
  <script src="<?php echo get_template_directory() ?>/js/bootstrap.min.js"></script>
</head>
<body>

  <!-- Search Bar -->
  <div class="row" style="z-index: 4; position: fixed; top: 0px; width: 100%; margin: 0px;">
    <div class="col-md-12" id="search">
      <?php get_search_form(array(
        'input_class' => 'input-lg',
        'input_style' => 'border:none;box-shadow: none;background-color: transparent !important; display: inline;margin-top:5px',
        'button_class' =>  'btn pull-right',
        'button_style' =>  'height: 46px;margin-top:5px;background-color: transparent !important; color: #fff;',
        'button_text' =>  '<i class="fa fa-2x fa-search"></i>',
        'button_before' => '<span class="btn pull-left" style="height: 46px;margin-top:10px;margin-left:-5px;margin-right:10px" id="search-close"><i class="fa fa-2x fa-arrow-left"></i></span>'
      )); ?>
    </div>
  </div>

  <!-- Navigation -->
  <?php if(is_home()):
    echo '<nav class="navbar navbar-default navbar-custom navbar-fixed-top">';
  else:
    echo '<nav class="navbar navbar-default navbar-custom navbar-fixed-top navbar-white">';
  endif;
  ?>
      <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header page-scroll">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only"><?php _e('Toggle navigation') ?></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <button type="button" class="search-toggle" id="search-toggle">
                  <span class="glyphicon glyphicon-search"></span>
              </button>

              <a href="<?php home_url('/') ?>" class="navbar-brand">
                  <img src="<?php site_logo(); ?>">
                  <div class="navbar-text pull-right"><?php bloginfo('name') ?></div>
              </a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <button type="button" class="search-toggle2 hidden-xs pull-right" id="search-toggle2">
                  <span class="glyphicon glyphicon-search"></span>
              </button>
              <?php
              el_nav_menu( array(
                'theme_location' => 'primary',
                'menu_class' => 'nav navbar-nav navbar-right'
              ) );
              ?>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container -->
  </nav>

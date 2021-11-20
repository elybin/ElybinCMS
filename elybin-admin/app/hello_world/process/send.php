<?php
/*
  Frontend: true
  This is the front-end (process) file
*/

// redirect if request empty
if(	empty( $_POST['nama'] ) ){
	// redirect
	redirect( get_url('apps','hello_world','test') );
}

// set meta
$meta = array(
  'title' => __('Hello World'),
  'description' => __('Hello World'),
  'keywords' => 'hello world, test',
  'robots' => 'index, follow',
  'canonical' => get_url('apps','hello_world','test'),
);
// header
get_header($meta); ?>

<div class="container" style="margin-top:90px; margin-bottom:200px;">
  <div class="row">
    <div class="col-md-12">

      <h1><?php e( sprintf( __('Hello, %s'), $_POST['nama']	) ) ?></h1>
	  <p><?php e( sprintf(  __('You can also use this link "%s"'), get_url('apps','hello_world','test') ) )?></p>

	  <form action="<?php e( get_url('apps', 'hello_world','process/send') ) ?>&clear" method="POST">
		<input type="text" name="nama" class="form-control" placeholder="<?php _e('Your name...') ?>">
		<input type="submit" value="Send" class="btn btn-primary">
	  </form>

    </div>
  </div>
</div>

<?php
// footer
get_footer();

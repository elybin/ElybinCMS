<?php
/**
 * This file only injecting menu into sidebar
 */
// Add to menu
add_panel_menu( array(
	'Hello World' => [
			'url' 		=> get_url('admin_home').'admin.php?mod=hello_world',
			'icon' 		=> 'fa fa-smile-o',
			'label'		=> 1
		]
) );

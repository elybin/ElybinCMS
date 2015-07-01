<?php
/* Short description for file
 * Upgrade version from 1.1.1 to 1.1.3-dev
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 - 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */

/*
	1.1.3-dev? what difference?
	---------------------------------------
	1. add table
		- `elybin_relation`
		- `elybin_message`
		- `elybin_statistic`

	2. remove table
		- `elybin_gallery`
		- `elybin_contact`
		- `elybin_pages`
		- `elybin_album`
		- `com.elybin_subscribe`

	3. colums edit
		- `elybin_album` 
			(e) `date`					datetime
		- `elybin_category`
			(e) `name`					varchar(100)
		- `elybin_comments`
			(-) `ip`					
			(+) `visitor_id`			int(50)
			(e)	`date`					datetime
			(e) `post_id`				int(10)			0
			(-) `gallery_id`		
			(+)	`parent` 				int(10) 		0
			(+)	`reply`					varchar(10)
		- more


		- `elybin_users`
			(e) `user_account_pass`		varchar(255)
			(+) `email_status` 			varchar(15) 	DEF=notverified
			(+) `facebook_id` 			varchar(255) 	DEF=elybincms
			(+) `twitter_id` 			varchar(255) 	DEF=@elybincms
			(+) `website` 				varchar(255) 	DEF=www.elybin.com
			(e) `avatar` 				varchar(100) 	DEF=default/no-ava.png
			(e) `registered` 			datetime
			(e) `level` 				3
			(+) `user_meta` 			varchar(500)	{"user_meta":"null"}
*/


// impot sql 
//import_sql(many_trans()."elybin-install/mysql/to_1.1.3-dev.sql");	

// redirect to 	
?>
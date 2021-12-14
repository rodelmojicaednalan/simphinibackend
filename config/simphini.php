<?php

return [

	'site_name' 				=> env('SITE_NAME'),
	'site_dir'					=> env('SITE_DIR'),

  'db_prefix' 				=> 'simph_',
	'db_host' 					=> env('DB_HOST'),
	'db_username' 			=> env('DB_USERNAME'),
  'db_password' 			=> env('DB_PASSWORD'),

	'role'							=> [
		'',
		'Administrator',
		'User'
	]

];
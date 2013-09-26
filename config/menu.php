<?php


return array(
	'defaults' => array(
		'cache' => array(
			'enabled'    => true,
			'prefix'     => 'menu',
			'expiration' => 3600,
			'driver'     => 'file',
		)
	),

	'default_driver' => 'static',

	'drivers' => array(

	),
);
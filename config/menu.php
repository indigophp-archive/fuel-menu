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

	'driver'   => 'static',

	'drivers'  => array(

	),
);
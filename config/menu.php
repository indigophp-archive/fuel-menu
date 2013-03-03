<?php


return array(

	/**
	 * Default setup values
	 */
	'default_setup' => 'default',

	'setups' => array(
		'default' => array(
			'driver'   => 'db',
			'template' => 'default'
		)
	),
	/**
	 * Templates
	 */
	'templates' => array(
		'default' => array(
			'menu'       => "<ul>{menu}</ul>",
			'item'       => "<li class=\"{class}\">{item}\n{submenu}</li>\n",
			'item_inner' => '<a href="{link}" title="{title}">{text}</a>',
		)
	)
);
<?php


return array(

	/**
	 * Default setup values
	 */
	'defaults' => array(
		/**
		 * Default template
		 */
		'default' => array(
			'template' => 'default',
			'driver' => 'db'
		),

		/**
		 * Templates
		 */
		'template' => array(
			'default' => array(
				'menu' => "<ul>{menu}</ul>",
				'item' => "<li class=\"{class}\">{item}\n{submenu}</li>\n",
				'item_inner' => '<a href="{link}" title="{title}">{text}</a>',
			)
		)
	)

);
<?php


return array(

	/**
	 * Default template
	 */
	'default' => 'default',

	/**
	 * Templates
	 */
	'template' => array(
		'default' => array(
			'menu' => "<ul>{menu}</ul>",
			'item' => "<li>{item}\n{submenu}</li>\n",
			'item_inner' => '<a href="{link}" title="{title}" target="{target}">{text}</a>',
		)
	)

);
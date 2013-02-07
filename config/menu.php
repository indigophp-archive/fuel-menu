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
			'item' => "<li class=\"{class}\">{item}\n{submenu}</li>\n",
			'item_inner' => '<a href="{link}" title="{title}">{text}</a>',
		)
	)

);
<?php

namespace Menu;

class Model_Menu_Attribute extends \Orm\Model
{
	protected static $_belongs_to = array(
		'menu' => array(
			'key_from' => 'menu_id',
			'model_to' => 'Model_Menu',
			'key_to' => 'id',
		)
	);

	protected static $_properties = array(
		'id',
		'menu_id',
		'key',
		'data',
	);
}

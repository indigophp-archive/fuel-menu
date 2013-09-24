<?php

namespace Menu;

class Model_Menu_Meta extends \Orm\Model
{
	protected static $_belongs_to = array('menu');

	protected static $_properties = array(
		'id',
		'menu_id',
		'key',
		'value',
	);

	protected static $_table_name = 'menu_meta';
}

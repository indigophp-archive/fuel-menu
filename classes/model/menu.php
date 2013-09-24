<?php

namespace Menu;

class Model_Menu extends \Orm\Model_Nestedset
{
	protected static $_eav = array(
		'meta' => array('attribute' => 'key',)
	);

	protected static $_has_many = array(
		'meta' => array(
			'model_to' => 'Model_Menu_Meta'
		)
	);

	protected static $_properties = array(
		'id',
		'left_id',
		'right_id',
		'tree_id',
		'name',
		'url',
	);

	protected static $_table_name = 'menu';

	protected static $_tree = array(
		'tree_field'     => 'tree_id',
		'title_field'    => 'name',
	);
}

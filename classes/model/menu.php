<?php

namespace Menu;

class Model_Menu extends \Orm\Model
{
	protected static $_has_many = array(
		'children' => array(
			'key_from' => 'id',
			'model_to' => 'Model_Menu',
			'key_to' => 'parent',
			'conditions' => array(
				'order_by' => array(
					array('position')
				),
			)
		)
	);

	protected static $_has_one = array(
		'parent' => array(
			'key_from' => 'parent',
			'model_to' => 'Model_Menu',
			'key_to' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
			'conditions' => array(
				'where' => array(
					array('parent', '>', 0)
				),
			)
		)
	);

	protected static $_properties = array(
		'id',
		'menu',
		'text',
		'title',
		'link',
		'parent',
		'position',
		'target',
	);
}

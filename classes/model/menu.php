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
		),
		'attributes' => array(
			'key_from' => 'id',
			'model_to' => 'Model_Menu_Attribute',
			'key_to' => 'menu_id',
		)
	);

	protected static $_eav = array(
		'attributes' => array(
			'attribute' => 'key',
			'value' => 'data'
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
		'title',
		'text',
		'link',
		'parent',
		'position',
	);
}

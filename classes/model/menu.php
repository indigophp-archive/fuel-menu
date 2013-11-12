<?php

namespace Menu;

class Model_Menu extends \Orm\Model_Nestedset
{
	protected static $_observers = array(
		'Orm\\Observer_Typing' => array(
			'events' => array('before_save', 'after_save', 'after_load')
		),
		'Orm\\Observer_Self' => array(
			'events' => array('before_insert')
		),
		'Orm\\Observer_Slug' => array(
			'events' => array(null),
			'source' => 'name',
		)
	);

	protected static $_properties = array(
		'id',
		'left_id',
		'right_id',
		'tree_id',
		'name',
		'slug',
		'url',
		'fields' => array(
			'data_type' => 'serialize',
			'default'   => array()
		),
	);

	protected static $_table_name = 'menu';

	protected static $_tree = array(
		'tree_field'     => 'tree_id',
		'title_field'    => 'name',
	);

	public function _event_before_insert()
	{
		if ($this->is_root() and empty($this->slug))
		{
			\Orm\Observer_Slug::orm_notify($this, 'before_insert');
		}
	}
}

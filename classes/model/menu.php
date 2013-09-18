<?php

namespace Menu;

class Model_Menu extends \Orm\Model_Nestedset
{
	protected static $_eav = array('meta');

	protected static $_has_many = array('meta');

	protected static $_properties = array(
		'id',
		'left_id',
		'right_id',
		'tree_id',
		'name',
		'url',
	);
}

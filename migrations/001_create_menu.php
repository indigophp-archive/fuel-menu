<?php

namespace Fuel\Migrations;

class Create_menu
{
	public function up()
	{
		\DBUtil::create_table('menu', array(
			'id'       => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'left_id'  => array('constraint' => 11, 'type' => 'int', 'unsigned' => true),
			'right_id' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true),
			'tree_id'  => array('constraint' => 11, 'type' => 'int', 'unsigned' => true),
			'name'     => array('constraint' => 255, 'type' => 'varchar'),
			'url'      => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
		), array('id'));

		\DBUtil::create_index('menu', 'left_id');
		\DBUtil::create_index('menu', 'right_id');

		\DBUtil::create_table('menu_meta', array(
			'id'      => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'menu_id' => array('constraint' => 11, 'type' => 'int'),
			'key'     => array('type' => 'text'),
			'value'   => array('type' => 'text'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('menu_meta');
		\DBUtil::drop_table('menu');
	}
}
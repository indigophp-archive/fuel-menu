<?php

namespace Fuel\Migrations;

class Create_menus
{
	public function up()
	{
		\DBUtil::create_table('menus', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'menu' => array('constraint' => 32, 'type' => 'varchar'),
			'text' => array('type' => 'text'),
			'title' => array('type' => 'text'),
			'link' => array('type' => 'text'),
			'parent' => array('constraint' => 11, 'type' => 'int'),
			'position' => array('constraint' => 11, 'type' => 'int'),
			'target' => array('constraint' => 16, 'type' => 'varchar'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('menus');
	}
}
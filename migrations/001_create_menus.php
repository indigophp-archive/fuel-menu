<?php

namespace Fuel\Migrations;

class Create_menus
{
	public function up()
	{
		\DBUtil::create_table('menus', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'menu' => array('constraint' => 32, 'type' => 'varchar'),
			'title' => array('type' => 'text'),
			'text' => array('type' => 'text'),
			'link' => array('type' => 'text'),
			'parent' => array('constraint' => 11, 'type' => 'int'),
			'position' => array('constraint' => 11, 'type' => 'int')
		), array('id'), false, 'InnoDB', 'utf8_unicode_ci');

		\DBUtil::create_table('menu_attributes', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'menu_id' => array('constraint' => 11, 'type' => 'int'),
			'key' => array('type' => 'text'),
			'data' => array('type' => 'text'),
		), array('id'), false, 'InnoDB', 'utf8_unicode_ci', array(
			array(
				'key' => 'menu_id',
				'reference' => array(
					'table' => 'menus',
					'column' => 'id',
				),
				'on_update' => 'CASCADE',
				'on_delete' => 'CASCADE'
			),
		));
	}

	public function down()
	{
		\DBUtil::drop_table('menu_attributes');
		\DBUtil::drop_table('menus');
	}
}
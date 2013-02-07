<?php

namespace Fuel\Migrations;

class Add_text
{
	public function up()
	{
		\DBUtil::add_fields('menus', array(
			'text' => array('constraint' => 64, 'type' => 'varchar'),
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('menus', 'text');
	}
}
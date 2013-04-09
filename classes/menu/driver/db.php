<?php
/**
 * Fuel Menu package
 *
 * @package    Fuel
 * @subpackage Menu
 * @version    1.0
 * @author     Márk Ság-Kazár <sagikazarmark@gmail.com>
 * @link       https://github.com/sagikazarmark/fuel-menu
 */

namespace Menu;

class Menu_Driver_Db extends Menu_Driver
{


	protected function load($menu = null)
	{
		$this->items = Model_Menu::query()->where();
		\Lang::get('menu.item.1', array('valami' => 'asdasda'));
		__('menu', 'title', 1);
	}
}
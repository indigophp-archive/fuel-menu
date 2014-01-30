<?php
/**
 * Fuel Menu
 *
 * @package 	Fuel
 * @subpackage	Menu
 * @version 	1.0
 * @author		Márk Sági-Kazár <mark.sagikazar@gmail.com>
 * @license 	MIT License
 * @copyright	2013 - 2014 Indigo Development Team
 * @link		https://indigophp.com
 */

Autoloader::add_core_namespace('Menu');

Autoloader::add_classes(array(
	'Menu\\Menu'        => __DIR__.'/classes/menu.php',
	'Menu\\Menu_Static' => __DIR__.'/classes/menu/static.php',
	'Menu\\Menu_Db'     => __DIR__.'/classes/menu/db.php',

	'Menu\\Model_Menu'  => __DIR__.'/classes/model/menu.php',
));


<?php
/**
 * Fuel Menu package
 *
 * @package    Fuel
 * @subpackage Menu
 * @version    1.0
 * @author     Márk Ság-Kazár
 * @license    MIT License
 * @link       https://github.com/sagikazarmark/fuel-menu
 */


Autoloader::add_core_namespace('Menu');

Autoloader::add_classes(array(
	'Menu\\Menu'            => __DIR__.'/classes/menu.php',
	'Menu\\MenuException'   => __DIR__.'/classes/menu.php',
	'Menu\\Menu_Driver'     => __DIR__.'/classes/menu/driver.php',
	'Menu\\Menu_Driver_Db'  => __DIR__.'/classes/menu/driver/db.php',
	'Menu\\Menu_Static'     => __DIR__.'/classes/menu/static.php',

	'Menu\\Model_Menu'      => __DIR__.'/classes/model/menu.php',
	'Menu\\Model_Menu_Meta' => __DIR__.'/classes/model/menu/meta.php',
));

Config::load('menu');
Package::load('orm');
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

class MenuException extends \FuelException {}

class Menu
{

	/**
	 * loaded instance
	 */
	protected static $_instance = null;

	/**
	 * array of loaded instances
	 */
	protected static $_instances = array();

	/**
	 * Menu driver forge.
	 *
	 * @param 	string 			$menu 		The name of the menu
	 * @param	string|array	$setup		Setup key for array defined in menu.setups config or config array
	 * @param	array			$config		Extra config array
	 * @return  Menu instance
	 */
	public static function forge($menu = 'default', $driver = 'static')
	{
		$driver = '\\Menu\\Menu_'.ucfirst(strtolower($driver));

		if( ! class_exists($driver, true))
		{
			throw new \FuelException('Could not find Menu driver: ' $driver);
		}

		$driver = new $driver($menu);

		static::$_instances[$menu] = $driver;

		return $driver;
	}

	/**
	 * Return a specific driver, or the default instance (is created if necessary)
	 *
	 * @param   string  driver id
	 * @return  Menu_Driver
	 */
	public static function instance($instance = null)
	{
		if ($instance !== null)
		{
			if ( ! array_key_exists($instance, static::$_instances))
			{
				return false;
			}

			return static::$_instances[$instance];
		}

		if (static::$_instance === null)
		{
			static::$_instance = static::forge();
		}

		return static::$_instance;
	}
}

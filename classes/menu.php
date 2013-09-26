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
	 * Loaded instance
	 * @var Menu|null
	 */
	protected static $_instance = null;

	/**
	 * Array of loaded instances
	 * @var array
	 */
	protected static $_instances = array();

	/**
	 * Default config
	 * @var array
	 */
	protected static $_defaults = array();

	/**
	 * Init
	 */
	public static function _init()
	{
		\Config::load('menu', true);
		static::$_defaults = \Config::get('menu.defaults');
	}

	/**
	 * Menu driver forge.
	 *
	 * @param 	string 			$menu 		The name of the menu
	 * @param	string|array	$driver		Driver name or config array
	 * @param	array			$config		Config array
	 * @return  Menu instance
	 */
	public static function forge($menu = 'default', $driver = 'static', array $config = array())
	{
		if ( ! empty($driver) and ! is_array($driver))
		{
			$config = $driver;
			$driver = \Config::get('menu.default_driver', 'static');
		}

		$config = \Arr::merge(static::$_defaults, \Config::get('menu.drivers.' . $driver, array()), $config);

		$driver = '\\Menu\\Menu_'.ucfirst(strtolower($driver));

		if( ! class_exists($driver, true))
		{
			throw new \FuelException('Could not find Menu driver: ' . $driver);
		}

		$driver = new $driver($menu, $config);

		static::$_instances[$menu] = $driver;

		return $driver;
	}

	/**
	 * Return a specific menu, or the default instance (is created if necessary)
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

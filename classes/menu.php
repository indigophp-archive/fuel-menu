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
	 *
	 * @var Menu|null
	 */
	protected static $_instance = null;

	/**
	 * Array of loaded instances
	 *
	 * @var array
	 */
	protected static $_instances = array();

	/**
	 * Default config
	 *
	 * @var array
	 */
	protected static $_defaults = array();

	/**
	 * Init
	 */
	public static function _init()
	{
		\Config::load('menu', true);
		static::$_defaults = \Config::get('menu.defaults', array());
	}

	/**
	 * Menu driver instance
	 *
	 * @param	mixed			$menu		The name of the menu
	 * @param	string|array	$driver		Driver name or config array
	 * @param	array			$config		Config array
	 * @return	object			Menu_Driver
	 */
	public static function instance($menu, $config = array())
	{
		// Instance does not exists
		if ( ! array_key_exists($menu, static::$_instances))
		{
			// When a string was passed it's just the driver type
			if ( ! empty($config) and ! is_array($config))
			{
				$driver = $config;
				$config = array();
			}

			// No driver type passed, so falling back to default
			isset($driver) or $driver = \Arr::get($config, 'driver', \Config::get('menu.driver', 'static'));

			$driver = '\\Menu\\Menu_' . ucfirst(strtolower($driver));

			if( ! class_exists($driver, true))
			{
				throw new \FuelException('Could not find Menu driver: ' . $driver);
			}

			$config = \Arr::merge(static::$_defaults, \Config::get('menu.drivers.' . $driver, array()), $config);

			$driver = new $driver($menu, $config);

			static::$_instances[$menu] = $driver;
		}

		return static::$_instances[$menu];
	}
}

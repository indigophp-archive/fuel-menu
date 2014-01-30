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

namespace Menu;

class Menu
{

	/**
	 * Array of loaded menus
	 *
	 * @var array
	 */
	protected static $_instances = array();

	/**
	 * Menu name
	 *
	 * @var mixed
	 */
	protected $menu = null;

	/**
	 * Menu data
	 *
	 * @var array
	 */
	protected $data = array();

	/**
	 * Added menu elements
	 *
	 * @var array
	 */
	protected $add = array();

	/**
	 * Menu meta data
	 *
	 * @var array
	 */
	protected $meta = array();

	/**
	 * Menu driver instance
	 *
	 * @param  mixed       $menu    The name of the menu
	 * @param  array       $config  Config array
	 * @return Menu_Driver
	 */
	public static function instance($menu)
	{
		$class = get_called_class();

		// Instance does not exists
		if ( ! array_key_exists($menu, static::$_instances))
		{
			$class = new static($menu);

			static::$_instances[$menu] = $class;
		}

		return static::$_instances[$menu];
	}

	public static function render_menu($menu)
	{
		return static::instance($menu)->render();
	}

	public function __construct($menu)
	{
		$this->menu = $menu;

		$this->data = $this->load();
	}

	public function add(array $item, $key = null)
	{
		if ($key === null)
		{
			$this->data = \Arr::merge($this->data, $item);
		}
		elseif (is_string($key))
		{
			$this->data[$key] = $item;
		}
		else
		{
			$this->data[] = $item;
		}

		return $this;
	}

	public function load()
	{
		return array();
	}

	public function render()
	{
		return $this->data;
	}
}

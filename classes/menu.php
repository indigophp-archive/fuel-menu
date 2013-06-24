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
	 * Driver config defaults.
	 */
	protected static $_defaults = array(
		'driver'   => 'db',
		'template' => 'default'
	);

	/**
	 * Menu driver forge.
	 *
	 * @param 	string 			$menu 		The name of the menu
	 * @param	string|array	$setup		Setup key for array defined in menu.setups config or config array
	 * @param	array			$config		Extra config array
	 * @return  Menu instance
	 */
	public static function forge($menu, $setup = null, array $config = array())
	{
		empty($setup) and $setup = \Config::get('menu.default_setup', 'default');
		is_string($setup) and $setup = \Config::get('menu.setups.'.$setup, array());

		$setup = \Arr::merge(static::$_defaults, $setup);
		$config = \Arr::merge($setup, $config);

		$template = \Config::get('menu.templates.' . \Arr::get($config, 'template'), array());
		$template = \Arr::merge(static::$_default_template, $template);

		$driver = '\\Menu_Driver_'.ucfirst(strtolower(\Arr::get($config, 'driver', 'db')));

		if( ! class_exists($driver, true))
		{
			throw new \FuelException('Could not find Menu driver: ' . \Arr::get($config, 'driver', 'null') . ' ('.$driver . ')');
		}

		static::$driver = new $driver($config);
		$driver->set_menu($menu);

		static::$_instances[$menu] = $driver;

		return $driver;
	}

	/**
	 * Return a specific instance, or the default instance (is created if necessary)
	 *
	 * @param   string  $menu	Menu name
	 * @param 	string 	$setup 	Setup name
	 * @param 	array 	$config Configuration array
	 * @return  Menu instance
	 */
	public static function instance($menu, $setup = null, array $config = array())
	{
		if (array_key_exists($menu, static::$_instances))
		{
			static::$_instance = static::$_instances[$menu];
		}
		else
		{
			static::$_instance = static::forge($menu, $setup, $config);
		}

		return static::$_instance;
	}

	public function build($name)
	{
		$html = '';
		$menus = Model_Menu::query()->where('menu', $name)->where('parent', 0)->order_by('position')->get();
		$menus and $html = $this->build_menu($menus);
		return $html;
	}

	private function build_menu(array $menus, $sub = false)
	{
		$html = '';
		$prefix = $sub ? 'sub_' : '';

		foreach ($menus as $menu) {
			$submenu = null;
			$menu->children and $submenu = $this->build_menu($menu->children, true);
			$suffix = $submenu ? '_sub' : '';

			$inner = str_replace(array('{link}', '{text}', '{title}'), array($menu->link, $menu->text, $menu->title), \Arr::get($this->template, $prefix.'item_inner'.$suffix, $this->template['item_inner']));

			$item = str_replace('{item}', $inner, \Arr::get($this->template, $prefix.'item'.$suffix, $this->template['item']));

			if (preg_match_all('#\{(.*?)\}#', $item, $match))
			{
				foreach ($match[1] as $key => $value)
				{
					try
					{
						$match[1][$key] = $menu->$value;
					}
					catch (\OutOfBoundsException $e)
					{
						$match[1][$key] = null;
					}

					if ($value == 'submenu')
					{
						unset($match[0][$key]);
						unset($match[1][$key]);
					}
				}
			}

			$item = str_replace($match[0], $match[1], $item);
			$item = str_replace('{submenu}', $submenu, $item);

			$html .= $item;
		}
		
		$html = str_replace('{menu}', $html, \Arr::get($this->template, $prefix.'menu', $this->template['menu']));
		
		return $html;
	}

	public static function build_static($name)
	{
		return static::instance()->build($name);
	}

}

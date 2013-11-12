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
	 * Array of loaded menus
	 *
	 * @var array
	 */
	protected static $_menus = array();

	/**
	 * Default config
	 *
	 * @var array
	 */
	protected static $_defaults = array();

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
	 * Menu meta data
	 *
	 * @var array
	 */
	protected $meta = array();

	/**
	 * Config
	 *
	 * @var array
	 */
	protected $config = array();

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
	 * @param	array			$config		Config array
	 * @return	object			Menu_Driver
	 */
	public static function get($menu, $config = array())
	{
		// Instance does not exists
		if ( ! array_key_exists($menu, static::$_menus))
		{
			// When a string was passed it's just the setup
			if ( ! empty($config) and ! is_array($config))
			{
				$setup = $config;
				$config = array();
			}

			// No setup type passed, so falling back to default
			isset($setup) or $setup = \Arr::get($config, 'setup', \Config::get('menu.setup', 'default'));

			$config = \Arr::merge(static::$_defaults, \Config::get('menu.setups.' . $setup, array()), $config);

			$class = new static($menu, $config);

			static::$_menus[$menu] = $class;
		}

		return static::$_menus[$menu];
	}

	public static function render_menu($menu)
	{
		return static::get($menu)->render();
	}

	/**
	 * Driver constructor
	 *
	 * @param	string	$menu		Menu name
	 * @param	array 	$config 	Config array
	 */
	public function __construct($menu, $config)
	{
		$this->config = $config;
		$this->menu   = $menu;

		if ($this->get_config('cache.enabled', false) === true)
		{
			$cache = \Cache::forge($this->get_config('cache.prefix', 'menu') . '.' . $this->menu, $this->get_config('cache'));

			try
			{
				$menu = $cache->get();
			}
			catch (\CacheNotFoundException $e)
			{
				$this->data = $this->load();
				$cache->set($this->data, $this->get_config('cache.expiration'));
			}
		}
		else
		{
			$this->data = $this->load();
		}
	}

	/**
	* Get a driver config setting
	*
	* @param	string|null		$key		Config key
	* @param	mixed			$default	Default value
	* @return	mixed						Config setting value or the whole config array
	*/
	public function get_config($key = null, $default = null)
	{
		if (is_null($key))
		{
			return $this->config;
		}
		elseif (is_array($key))
		{
			return \Arr::subset($this->config, $key, $default);
		}
		else
		{
			return \Arr::get($this->config, $key, $default);
		}
	}

	/**
	* Set a driver config setting
	*
	* @param	string|array	$key		Config key or array of key-value pairs
	* @param	mixed			$value		New config value
	* @return	$this						$this for chaining
	*/
	public function set_config($key, $value = null)
	{
		// Merge config or just set an element
		if (is_array($key))
		{
			// Set default values and merge config reverse order
			if ($value === true)
			{
				$this->config = \Arr::merge($key, $this->config);
			}
			else
			{
				$this->config = \Arr::merge($this->config, $key);
			}
		}
		else
		{
			\Arr::set($this->config, $key, $value);
		}

		return $this;
	}
}

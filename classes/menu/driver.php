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

class Menu_Driver
{
	/**
	 * Driver config
	 * @var array
	 */
	protected $config = array();

	/**
	 * Menu name
	 * @var string
	 */
	protected $menu = null;

	/**
	 * Menu items
	 * @var array
	 */
	protected $items = array();

	/**
	 * Driver constructor
	 *
	 * @param	array	$config		driver config
	 */
	public function __construct(array $config)
	{
		$this->config = $config;
	}

	/**
	 * Get the active menu
	 * @return string
	 */
	public function get_menu()
	{
		return $this->menu;
	}

	/**
	 * Set the active menu
	 * @param 	string|null 	$menu 	Set this to null to remove menu
	 * @return 	$this
	 */
	public function set_menu($menu = null)
	{
		$this->menu = $menu;
		$this->load($menu);
		return $this;
	}

	/**
	 * Get a driver config setting.
	 *
	 * @param	string		$key		the config key
	 * @return	mixed					the config setting value
	 */
	public function get_config($key, $default = null)
	{
		return \Arr::get($this->config, $key, $default);
	}

	/**
	 * Set a driver config setting.
	 *
	 * @param	string		$key		the config key
	 * @param	mixed		$value		the new config value
	 * @return	object					$this
	 */
	public function set_config($key, $value)
	{
		\Arr::set($this->config, $key, $value);

		return $this;
	}

	/**
	 * Load the menu data from source
	 * @param  string $menu Name of the menu
	 * @return $this
	 */
	public abstract function load($menu = null);
}
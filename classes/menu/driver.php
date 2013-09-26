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

abstract class Menu_Driver
{
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
	 * @param string	$menu		menu name
	 * @param array 	$config 	Config array
	 */
	public function __construct($menu, $config)
	{
		$this->config = $config;
		$this->set_menu($menu);
	}

	/**
	* Get a driver config setting.
	*
	* @param	string	$key		the config key
	* @param	mixed	$default	the default value
	* @return	mixed				the config setting value
	*/
	public function get_config($key, $default = null)
	{
		return \Arr::get($this->config, $key, $default);
	}

	/**
	* Set a driver config setting.
	*
	* @param	string|array	$key	Config key or array of key-value pairs
	* @param	mixed			$value	the new config value
	* @return	$this					$this for chaining
	*/
	public function set_config($key, $value = null)
	{
		if (is_array($key))
		{
			foreach ($key as $k => $v)
			{
				$this->set_config($k, $v);
			}
		}
		\Arr::set($this->config, $key, $value);

		return $this;
	}

	/**
	 * Get the active menu
	 *
	 * @return string
	 */
	public function get_menu()
	{
		return $this->menu;
	}

	/**
	 * Set the active menu
	 *
	 * @param 	string|null 	$menu 	Set this to null to remove menu
	 * @return 	$this
	 */
	public function set_menu($menu = null)
	{
		$this->menu = $menu;
		$this->load();
		return $this;
	}

	public function add_items(array $items)
	{
		foreach ($items as $id => $item) {
			$this->add_item($item, $id);
		}
	}

	protected function load_cache()
	{
		if ($this->get_config('cache.enabled', false) === true)
		{
			try
			{
				return $this->items = \Cache::get($this->get_config('cache.prefix', 'menu') . '.' . $this->menu);
			}
			catch (\CacheNotFoundException $e)
			{
				return false;
			}
		}
		return null;
	}

	public function flush()
	{
		return \Cache::delete($this->get_config('cache.prefix', 'menu') . '.' . $this->menu);
	}

	/**
	 * Load the menu data from source
	 *
	 * @param  string $menu Name of the menu
	 * @return $this
	 */
	abstract public function load();

	/**
	 * Add one menu item
	 *
	 * @param  array $item Menu item
	 * @return $this
	 */
	abstract public function add_item(array $item, $id = null);

	/**
	 * Delete one item
	 *
	 * @param  mixed 	$id    Item identifier
	 * @return boolean
	 */
	abstract public function delete_item($id);

	/**
	 * Merge menu structure to the existing menu
	 *
	 * @param  array  $items Menu structure that fits into the existing structure
	 * @return $this
	 */
	abstract public function merge_items(array $items);

	/**
	 * Driver's render function
	 *
	 * @return mixed   Return the items
	 */
	abstract public function render();

	/**
	 * Save the items
	 *
	 * @return boolean
	 */
	abstract public function save();
}

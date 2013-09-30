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
	 * Menu id
	 *
	 * @var mixed
	 */
	protected $id = null;

	/**
	 * Menu
	 *
	 * @var array
	 */
	protected $menu = array();

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
	 * Driver constructor
	 *
	 * @param	string	$id			menu name
	 * @param	array 	$config 	Config array
	 */
	public function __construct($id, $config)
	{
		$this->config = $config;
		$this->id     = $id;
		$this->menu   = $this->load();
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
	 * Load the menu data
	 *
	 * @param	boolean	$cached		Load the menu without cache regardless it is enabled or not
	 * @return	array	Menu data
	 */
	public function load($cached = true)
	{
		if ($this->get_config('cache.enabled', false) === true)
		{
			$cache = \Cache::forge($this->get_config('cache.prefix', 'menu') . '.' . $this->id, $this->get_config('cache'));

			try
			{
				if ($cached === false)
				{
					$cache->delete();
				}

				$menu = $cache->get();
			}
			catch (\CacheNotFoundException $e)
			{
				$menu  = $this->_load();
				$cache->set($menu, $this->get_config('cache.expiration'));
			}
		}
		else
		{
			$menu = $this->_load();
		}

		return $menu;
	}

	/**
	 * Get the active menu id
	 *
	 * @return	mixed
	 */
	public function get_id()
	{
		return $this->id;
	}

	/**
	 * Render menu data
	 *
	 * @return	array	Rendered menu data
	 */
	public function render()
	{
		return $this->_render();
	}

	/**
	 * Update menu
	 *
	 * @param	array	$menu	Menu data
	 * @return	boolean			Success of update operation
	 */
	public function update(array $menu = array())
	{
		$update = $this->_update($menu);
		$this->menu = $this->load(false);
		return $update;
	}

	/**
	 * Edit menu
	 *
	 * @param	array	$menu	Menu info
	 * @return	boolean			Success of edit operation
	 */
	public function edit(array $menu = array())
	{
		return $this->_edit($menu);
	}

	/**
	 * Delete menu
	 * @return	boolean	Success of delete operation
	 */
	public function delete()
	{
		return $this->flush()->_delete();
	}

	/**
	 * Flush cache
	 *
	 * @return	object	$this
	 */
	public function flush()
	{
		if ($this->get_config('cache.enabled', false) === true)
		{
			$cache = \Cache::forge($this->get_config('cache.prefix', 'menu') . '.' . $this->id, $this->get_config('cache'));
			$cache->delete();
		}

		return $this;
	}

	/**
	 * Load the menu data
	 *
	 * @return	array	Menu data
	 */
	abstract protected function _load();

	/**
	 * Update the menu data
	 *
	 * @param	array	$menu	Menu information
	 * @return	array			Menu data
	 */
	abstract protected function _update(array $menu);

	/**
	 * Edit menu information
	 *
	 * @param	array	$menu	Menu information
	 * @return	boolean			Success of edit operation
	 */
	abstract protected function _edit(array $menu);

	/**
	 * Render function
	 *
	 * @return	mixed	Return the items
	 */
	abstract protected function _render();

	/**
	 * Delete menu
	 *
	 * @return	boolean	Success of deletion
	 */
	abstract protected function _delete();
}

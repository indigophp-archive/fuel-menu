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
	 * @param	string	$menu		menu name
	 */
	public function __construct($menu)
	{
		$this->menu = $menu;
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

	public function add_items(array $items)
	{
		foreach ($items as $id => $item) {
			$this->add_item($item, $id);
		}
	}

	/**
	 * Load the menu data from source
	 * @param  string $menu Name of the menu
	 * @return $this
	 */
	abstract public function load($menu = null);

	/**
	 * Add one menu item
	 * @param array $item Menu item
	 * @return $this
	 */
	abstract public function add_item(array $item, $id = null);

	/**
	 * Merge menu structure to the existing menu
	 * @param  array  $items Menu structure that fits into the existing structure
	 * @return $this
	 */
	abstract public function merge_items(array $items);
}
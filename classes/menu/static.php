<?php

namespace Menu;

class Menu_Static extends Menu_Driver
{

	protected function _load()
	{
		$menu = \Config::load('menu/' . $this->id, true, true, true);
		return \Arr::get($menu, 'children', array());
	}

	protected function _update(array $menu)
	{
		// Set children
		$root = \Config::get('menu/' . $this->id, array());
		\Arr::set($root, 'children', $menu);

		// Save to file
		return \Config::save('menu/' . $this->id, $root);
	}

	protected function _edit(array $menu = array())
	{
		// Set children to menu info
		$menu['children'] = $this->menu;

		// Save to file
		return \Config::save('menu/' . $this->id, $menu);
	}

	protected function _delete()
	{
		return \Config::save('menu/' . $this->id, array());
	}

	protected function _render()
	{
		return $this->menu;
	}
}

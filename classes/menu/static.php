<?php

namespace Menu;

class Menu_Static extends Menu_Driver
{

	protected function _load()
	{
		return \Config::load('menu/' . $this->id, true, true, true);
	}

	protected function _update(array $menu)
	{
		// Save to file
		\Config::save('menu/' . $this->id, $menu);

		// Reload data to object and return success
		return $this->menu = $this->load(false);
	}

	protected function _render()
	{
		return $this->menu;
	}
}

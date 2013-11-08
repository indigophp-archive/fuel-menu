<?php

namespace Menu;

class Menu_Dynamic extends Menu_Driver
{
	public function add_item($key, $item)
	{
		return \Arr::set($this->menu, $key, $item);
	}

	public function add_items($key, array $items)
	{
		\Arr::set(\Arr::merge(\Arr::get($this->menu, $key, array()), $items));
	}

	protected function _render()
	{
		return $this->menu;
	}

	protected function _delete()
	{
		return Model_Menu::find($this->root)->delete_tree();
	}
}

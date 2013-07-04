<?php

namespace Menu;

class Menu_Static extends Menu_Driver
{

	public function load()
	{
		try {
			$this->load_cache();
		} catch (\CacheNotFoundException $e) {
			$this->items = \Config::load('menu/' . $this->menu);
		}
		$this->original = $this->items;
	}

	public function add_item(array $item, $id = null)
	{
		# code...
	}

	public function merge_items(array $items)
	{
		return $this->items = \Arr::merge($this->items, $items);
	}

	public function delete_item($value='')
	{
		# code...
	}

	public function save()
	{
		if ($this->items !== $this->original)
		{
			\Cache::set('menu.' . $this->menu, $this->items);
			return \Config::save('menu/' . $this->menu, $this->items);
		}
		return true;
	}

	public function _render()
	{
		# code...
	}
}
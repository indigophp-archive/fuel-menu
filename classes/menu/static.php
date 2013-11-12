<?php

namespace Menu;

class Menu_Static extends Menu
{

	protected function load($menu = null)
	{
		$menu = $menu ?: $this->menu;

		$data = \Config::load('menu/' . $menu, true, true, true);

		$this->meta = array(
			'name'       => \Arr::get($data, 'name'),
			'identifier' => \Arr::get($data, 'slug'),
			'num_items'  => $this->count($data['children']),
		);

		return $data;
	}

	protected function count($menu)
	{
		static $count = 0;

		foreach($menu as $item)
		{
			if (is_array($item) and array_key_exists('children', $item))
			{
				$this->count($item['children']);
			}

			$count++;
		}
		return $count;
	}

	public function update(array $menu)
	{
		// Set children
		$root = \Config::get('menu/' . $this->id, array());
		\Arr::set($root, 'children', $menu);

		// Save to file
		return \Config::save('menu/' . $this->id, $root);
	}

	public function edit(array $menu = array())
	{
		// Set children to menu info
		$menu['children'] = $this->data;

		// Save to file
		return \Config::save('menu/' . $this->id, $menu);
	}

	public function delete()
	{
		return \Config::save('menu/' . $this->id, array());
	}

	public function render()
	{
		return $this->data['children'];
	}
}

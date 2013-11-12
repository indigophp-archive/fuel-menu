<?php

namespace Menu;

class Menu_Db extends Menu
{
	protected function load($menu = null)
	{
		$menu = $menu ?: $this->menu;

		if (is_numeric($menu))
		{
			$root = Model_Menu::find_by_tree_id($menu);
		}
		else
		{
			$root = Model_Menu::find_by_slug($menu);
		}

		if (is_null($root))
		{
			throw new MenuException('Menu ' . (is_numeric($menu) ? '#' : '') . $menu . ' not found');
		}
		elseif ( ! $root->is_root())
		{
			$root = $root->root();
			$this->menu = $root->slug;
			\Log::write(250, 'Menu ' . (is_numeric($menu) ? '#' : '') . $menu . ' is not a root element.');
		}

		$this->meta = array(
			'name'       => $root->name,
			'identifier' => $root->slug,
			'num_items'  => $root->count_descendants(),
		);

		$root->descendants()->get();
		return $root;
	}

	public function update(array $menu, $root = null)
	{
		// No root passed, so get the tree root node
		if (is_null($root))
		{
			$root = $this->data;
		}

		// Previous menu item id
		$previous  = null;

		// Processed menu items
		// Declared static so recursion can set it's value
		static $processed = array();

		foreach ($menu as $item)
		{
			// Get id from input and find the model
			$id = \Arr::get($item, 'id');
			$model = Model_Menu::find($id);

			// If model is not found then forge it
			is_null($model) and $model = Model_Menu::forge();

			$properties = $this->prep_props($item);

			$model->set($properties);

			// If this is the first child then set it to parent
			// Otherwise set it next to the previous node
			if (is_null($previous))
			{
				$model->first_child($root)->save();
			}
			else
			{
				$model->next_sibling($previous)->save();
			}

			// Is this a new menu item? Get it's id
			is_null($id) and $id = $model->id;

			// Set the previous node
			$previous = $model;

			// This menu item is processed
			$processed[] = $id;

			// If there are children then call the function again
			empty($item['children']) or $this->update($item['children'], $model);
		}

		// We are back from recusion: the current root is the tree root node
		if ($root->is_root())
		{
			// Remove processed nodes from all nodes, so we can delete unused ones
			$nodes = $root->descendants()->get();
			\Arr::delete($nodes, $processed);

			foreach ($nodes as $id => $model)
			{
				$model->delete();
			}
		}

		return true;
	}

	public function edit(array $menu = array())
	{
		$root = $this->root;

		$properties = $this->prep_props($menu);

		return $root->set($properties)->save();
	}

	protected function prep_props(array $props)
	{
		// Skip tree fields and primary keys
		$skip_fields = \Arr::merge(Model_Menu::primary_key(), Model_Menu::tree_config(), array('children'));
		\Arr::delete($skip_fields, array('read-only', 'title_field'));

		// Model properties
		$properties = \Arr::filter_keys($props, array_keys(Model_Menu::properties()));
		$properties = \Arr::filter_keys($properties, $skip_fields, true);

		//Model 'fields' property fields
		$fields = \Arr::filter_keys($props, array_keys($properties), true);
		$fields = \Arr::filter_keys($fields, $skip_fields, true);
		is_array($properties['fields']) or $properties['fields'] = array();
		$properties['fields'] = \Arr::merge($properties['fields'], $fields);

		return $properties;
	}

	public function render()
	{
		$menu = $this->data->dump_tree();
		$menu = reset($menu);
		$menu = $menu['children'];

		$menu = \Arr::merge($menu, $this->add);

		return $menu;
	}

	public function delete()
	{
		return $this->data->delete_tree();
	}
}

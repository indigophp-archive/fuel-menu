<?php

namespace Menu;

class Menu_Db extends Menu_Driver
{

	/**
	 * Root node id
	 * @var int
	 */
	protected $root;

	protected function _load()
	{
		$root = Model_Menu::forge()->set_tree_id($this->id)->root()->get_one();
		if (is_null($root))
		{
			throw new MenuException('Menu #' . $this->id . ' not found');
		}

		$this->root = $root->id;
		$tree = $root->dump_tree();
		$tree = reset($tree);
		return \Arr::get($tree, 'children', array());
	}

	protected function _update(array $menu, $root = null)
	{
		// No root passed, so get the tree root node
		if (is_null($root))
		{
			$root = Model_Menu::forge()->find($this->root);
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

			// Skip tree fields and primary keys
			$skip_fields = \Arr::merge(Model_Menu::primary_key(), Model_Menu::tree_config(), array('children'));
			\Arr::delete($skip_fields, array('read-only', 'title_field'));

			// Model properties
			$properties = \Arr::filter_keys($item, array_keys(Model_Menu::properties()));
			$properties = \Arr::filter_keys($properties, $skip_fields, true);

			//Model 'fields' property fields
			$fields = \Arr::filter_keys($item, array_keys($properties), true);
			$fields = \Arr::filter_keys($fields, $skip_fields, true);
			isset($properties['fields']) or $properties['fields'] = array();
			$properties['fields'] = \Arr::merge($properties['fields'], $fields);

			$model->set($properties);

			// If this is the first child then set it to parent
			// Otherwise set it next to the previous node
			if (is_null($previous))
			{
				$model->first_child($root)->save();
			}
			else
			{
				$model_prev = Model_Menu::find($previous);
				$model->next_sibling($model_prev)->save();
			}

			// Is this a new menu item? Get it's id
			is_null($id) and $id = $model->id;

			// Set the previous node id
			$previous = $id;

			// This menu item is processed
			$processed[] = $id;

			// If there are children then call the function again
			empty($item['children']) or $this->_update($item['children'], $model);
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

	protected function _edit(array $menu = array())
	{
		$root = Model_Menu::forge()->find($this->root);

		// Skip tree fields and primary keys
		$skip_fields = \Arr::merge(Model_Menu::primary_key(), Model_Menu::tree_config(), array('children'));
		\Arr::delete($skip_fields, array('read-only', 'title_field'));

		// Model properties
		$properties = \Arr::filter_keys($menu, array_keys(Model_Menu::properties()));
		$properties = \Arr::filter_keys($properties, $skip_fields, true);

		//Model 'fields' property fields
		$fields = \Arr::filter_keys($menu, array_keys($properties), true);
		$fields = \Arr::filter_keys($fields, $skip_fields, true);
		is_array($properties['fields']) or $properties['fields'] = array();
		$properties['fields'] = \Arr::merge($properties['fields'], $fields);

		return $root->set($properties)->save();
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

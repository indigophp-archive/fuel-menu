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
		$tree = Model_Menu::forge()->set_tree_id($this->id)->root()->get_one()->dump_tree();
		$tree = reset($tree);
		$this->root = \Arr::get($tree, 'id');
		return \Arr::get($tree, 'children', array());
	}

	protected function _update(array $menu, $root = null)
	{
		if (is_null($root))
		{
			$root = Model_Menu::forge()->find($this->root);
		}

		$previous = null;

		foreach ($menu as $id => $item)
		{
			$id = \Arr::get($item, 'id', $id);
			$model = Model_Menu::find($id);

			$skip_fields = \Arr::merge(Model_Menu::primary_key(), Model_Menu::tree_config(), array('children'));
			\Arr::delete($skip_fields, array('read-only', 'title_field'));

			$properties = \Arr::filter_keys($item, array_keys(Model_Menu::properties()));
			$properties = \Arr::filter_keys($properties, $skip_fields, true);

			$fields = \Arr::filter_keys($item, array_keys($properties), true);
			$fields = \Arr::filter_keys($fields, $skip_fields, true);
			is_array($properties['fields']) or $properties['fields'] = array();
			$properties['fields'] = \Arr::merge($properties['fields'], $fields);

			$model->set($properties);

			if (is_null($previous))
			{
				$model->first_child($root)->save();
			}
			else
			{
				$model_prev = Model_Menu::find($previous);
				$model->next_sibling($model_prev)->save();
			}

			$previous = $id;

			empty($item['children']) or $this->_update($item['children'], $model);
		}
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

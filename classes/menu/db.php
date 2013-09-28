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
		$this->root = $tree['id'];
		return $tree['children'];
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

			$properties = \Arr::filter_keys($item, Model_Menu::properties());
			// $fields = \Arr::filter_keys($item, Model_Menu::properties(), true);
			// $properties['fields'] = $fields;
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

			empty($item['children']) or $this->_update(array($id => $item['children']), $model);
		}
	}

	protected function _render()
	{
		return $this->menu;
	}

	protected function _delete()
	{

	}
}

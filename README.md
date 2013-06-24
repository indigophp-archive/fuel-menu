Fuel Menu package
=========

Menu package for FuelPHP framework.

## Install
* Through OIL: ````oil package install````
* [Download](https://github.com/sagikazarmark/fuel-menu/archive/master.zip) package
* Clone repo

Run migration:
````oil refine migrate --packages=menu````

## Usage
````
<?php
	\Package::load('menu'); //or add it to always_load

	$menu = \Menu::forge('default');
	echo $menu->build('main');

	//OR static way
	\Menu::build_static('main');
?>
````

## Configuration

The default configuration:

````
<?php
	protected static $_defaults = array(
		'menu' => "<ul>{menu}</ul>",
		'item' => "<li>{item}\n{submenu}</li>\n",
		'item_inner' => '<a href="{link}" title="{title}">{text}</a>',
	);
?>
````

When somthing is not found, this will be the fallback configuration.

If you want to use different configuration for submenus, you can define different configuration by adding 'sub_' prefix to the specific config item, like this:

````
<?php
	protected static $_defaults = array(
		'menu' => "<ul>{menu}</ul>",
		'item' => "<li>{item}\n{submenu}</li>\n",
		'item_inner' => '<a href="{link}" title="{title}">{text}</a>',
		'sub_menu' => "<ul>{menu}</ul>",
		'sub_item' => "<li>{item}\n{submenu}</li>\n",
		'sub_item_inner' => '<a href="{link}" title="{title}">{text}</a>',
	);
?>
````

You can also modify the parent in case it has children, using this configuration:

````
<?php
	protected static $_defaults = array(
		'menu' => "<ul>{menu}</ul>",
		'item' => "<li>{item}\n{submenu}</li>\n",
		'item_inner' => '<a href="{link}" title="{title}">{text}</a>',
		'item_sub' => "<li>{item}\n{submenu}</li>\n",
		'item_inner_sub' => '<a href="{link}" title="{title}">{text}</a>',
	);
?>
````

And if the parent is a submenu:
````
<?php
	protected static $_defaults = array(
		'menu' => "<ul>{menu}</ul>",
		'item' => "<li>{item}\n{submenu}</li>\n",
		'item_inner' => '<a href="{link}" title="{title}">{text}</a>',
		'sub_item_sub' => "<li>{item}\n{submenu}</li>\n",
		'sub_item_inner_sub' => '<a href="{link}" title="{title}">{text}</a>',
	);
?>
````

Note: this will apply for every submenu which has children, when defined.

Last, but not least: You can define your own field for every menu item.
````
<?php
	protected static $_defaults = array(
		'menu' => "<ul>{menu}</ul>",
		'item' => "<li>{item}\n{submenu}</li>\n",
		'item_inner' => '<a class="{class}" href="{link}" title="{title}">{text}</a>',
	);
?>
````

A menu item MUST have a menu name, text, a parent, a position, optional: title, link
Anything else is stored in an EAV container.


## New menu(item)
````
<?php
	$menu = array(
		'menu' => 'main',
		'text' => '<strong>This</strong> is a text',
		'title' => 'This is optional',
		'link' => '/to/somewhere'
	);

	$menu = \Model_Menu::forge($menu);
	$menu->attributes[] = \Model_Menu_Attribute::forge(array('key' => 'class', 'data' => 'myclass'));

	$menu->save();
?>

````

## Future plans
I'm planning to add active menuitem option. I'm open to any ideas.

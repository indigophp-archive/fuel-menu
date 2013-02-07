Fuel Menu package
=========

Menu package for FuelPHP framework.

##Install
* Through OIL: ````oil install````
* [Download](https://github.com/sagikazarmark/fuel-menu/archive/master.zip) package
* Clone repo

Run migration:
````oil refine migrate --packages=menu````

##Usage
````
<?php
	\Package::load('menu'); //or add it to always_load

	$menu = \Menu::forge('default');
	echo $menu->build('main');

	//OR static way
	\Menu::build_static('main');
?>
````

##Configuration

The default configuration:

````
<?php
	protected static $_defaults = array(
		'menu' => "<ul>{menu}</ul>\n",
		'item' => "<li>{item}\n{submenu}</li>\n",
		'item_inner' => '<a href="{link}" title="{title}" target="{target}">{title}</a>',
	);
?>
````

When somthing is not found, this will be the fallbck configuration.

If you want to use different configuration for submenus, you can define different configuration by adding 'sub_' prefix to the specific config item, like this:

````
<?php
	protected static $_defaults = array(
		'menu' => "<ul>{menu}</ul>\n",
		'item' => "<li>{item}\n{submenu}</li>\n",
		'item_inner' => '<a href="{link}" title="{title}" target="{target}">{title}</a>',
		'sub_menu' => "<ul>{menu}</ul>\n",
		'sub_item' => "<li>{item}\n{submenu}</li>\n",
		'sub_item_inner' => '<a href="{link}" title="{title}" target="{target}">{title}</a>',
	);
?>
````

You can also modify the parent in case it has children, using this configuration:

````
<?php
	protected static $_defaults = array(
		'menu' => "<ul>{menu}</ul>\n",
		'item' => "<li>{item}\n{submenu}</li>\n",
		'item_inner' => '<a href="{link}" title="{title}" target="{target}">{title}</a>',
		'item_sub' => "<li>{item}\n{submenu}</li>\n",
		'item_inner_sub' => '<a href="{link}" title="{title}" target="{target}">{title}</a>',
	);
?>
````

Last, but not least: multi-level menu submenu configuration:
````
<?php
	protected static $_defaults = array(
		'menu' => "<ul>{menu}</ul>\n",
		'item' => "<li>{item}\n{submenu}</li>\n",
		'item_inner' => '<a href="{link}" title="{title}" target="{target}">{title}</a>',
		'sub_item_sub' => "<li>{item}\n{submenu}</li>\n",
		'sub_item_inner_sub' => '<a href="{link}" title="{title}" target="{target}">{title}</a>',
	);
?>
````

##Future plans
I'm planning to add active menuitem option. I'm open to any ideas.
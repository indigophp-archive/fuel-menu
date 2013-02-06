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

If you want to use different configuration for submenus, you can define different configuration by adding 'sub' prefix to the specific config item, like this:

````
<?php
	protected static $_defaults = array(
		'menu' => "<ul>{menu}</ul>\n",
		'item' => "<li>{item}\n{submenu}</li>\n",
		'item_inner' => '<a href="{link}" title="{title}" target="{target}">{title}</a>',
		'submenu' => "<ul>{menu}</ul>\n",
		'subitem' => "<li>{item}\n{submenu}</li>\n",
		'subitem_inner' => '<a href="{link}" title="{title}" target="{target}">{title}</a>',
	);
?>
````

##Future plans
I'm planning to add active menuitem option.
<?php

/*
 * This file is part of the Fuel Menu package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Fuel\Menu\Providers;

use Fuel\Dependency\ServiceProvider;

/**
 * Provides menu services
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class FuelServiceProvider extends ServiceProvider
{
	/**
	 * {@inheritdoc}
	 */
	public $provides = [
		'menu',
		'menu.factory',
		'menu.matcher',
		'menu.loader.array',
		'menu.provider',
		'menu.renderer_provider',
		'menu.twig.extension',
		'menu.twig.helper',
	];

	/**
	 * Load menu configs
	 */
	public function __construct()
	{
		\Config::load('menu', true);
	}

	/**
	 * {@inheritdoc}
	 */
	public function provide()
	{
		$this->register('menu', function($dic, $title = null, array $options = [])
		{
			$factory = $dic->resolve('menu.factory');

			return $factory->createItem($title, $options);
		});

		$this->registerSingleton('menu.factory', 'Knp\\Menu\\MenuFactory');
		$this->register('menu.matcher', 'Knp\\Menu\\Matcher\\Matcher');

		$this->registerSingleton('menu.loader.array', function($dic)
		{
			$factory = $dic->resolve('menu.factory');

			return $dic->resolve('Knp\\Menu\\Loader\\ArrayLoader', [$factory]);
		});

		$this->registerSingleton('menu.twig.extension', function($dic)
		{
			$helper = $dic->resolve('menu.twig.helper');

			return $dic->resolve('Knp\\Menu\\Twig\\MenuExtension', [$helper]);
		});

		$this->registerSingleton('menu.twig.helper', function($dic)
		{
			$rendererProvider = $dic->resolve('menu.renderer_provider');
			$menuProvider = $dic->resolve('menu.provider');

			return $dic->resolve('Knp\\Menu\\Twig\\Helper', [$rendererProvider, $menuProvider]);
		});

		$this->registerSingleton('menu.renderer_provider', function($dic)
		{
			$default = \Config::get('menu.default_renderer', 'list');
			$renderers = \Config::get('menu.renderers', []);

			return $dic->resolve('Knp\\Menu\\Renderer\\FuelProvider', [$this->container, $default, $renderers]);
		});

		$this->registerSingleton('menu.provider', function($dic)
		{
			return $dic->resolve('Knp\\Menu\\Provider\\FuelProvider', [$this->container]);
		});

		$this->registerRenderers();
		$this->registerMenus();
	}

	private function registerRenderers()
	{
		$this->register('menu.renderer.list', function($dic)
		{
			$matcher = $dic->resolve('menu.matcher');

			return $dic->resolve('Knp\\Menu\\Renderer\\ListRenderer', [$matcher]);
		});

		$this->register('menu.renderer.twig', function($dic)
		{
			$twig = $dic->resolve('twig');
			$matcher = $dic->resolve('menu.matcher');

			// ugly hack: load template here
			$twig->getLoader()->addPath(VENDORPATH.'knplabs/knp-menu/src/Knp/Menu/Resources/views');

			return $dic->resolve('Knp\\Menu\\Renderer\\TwigRenderer', [$twig, 'knp_menu.html.twig', $matcher]);
		});
	}

	private function registerMenus()
	{
		foreach (\Config::get('menu.menus', []) as $menu => $data)
		{
			$this->extendMultiton('menu', $menu, function($dic) use($data)
			{
				return $this->resolve('menu.loader.array')->load($data);
			});
		}
	}
}

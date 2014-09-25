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
		'menu.factory',
		'menu.container',
		'menu.matcher',
		'menu.provider',
		'menu.provider.chain',
		'menu.renderer',
		'menu.renderer.list',
		'menu.renderer.twig',
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

		$this->registerSingleton('menu.container', function($dic)
		{
			return $dic->resolve('container');
		});

		$this->register('menu.factory', 'Knp\\Menu\\MenuFactory');
		$this->register('menu.matcher', 'Knp\\Menu\\Matcher\\Matcher');

		$this->register('menu.renderer.list', function($dic)
		{
			$matcher = $dic->resolve('menu.matcher');

			return $dic->resolve('Knp\\Menu\\Renderer\\ListRenderer', [$matcher]);
		});

		$this->register('menu.twig.extension', function($dic)
		{
			$helper = $dic->resolve('menu.twig.helper');

			return $dic->resolve('Knp\\Menu\\Twig\\MenuExtension', [$helper]);
		});

		$this->register('menu.twig.helper', function($dic)
		{
			$rendererProvider = $dic->resolve('menu.renderer_provider');

			return $dic->resolve('Knp\\Menu\\Twig\\Helper', [$rendererProvider]);
		});

		$this->register('menu.renderer_provider', 'Knp\\Menu\\Renderer\\FuelProvider');
	}
}

<?php

/*
 * This file is part of the Fuel Menu package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Knp\Menu\Renderer;

use Fuel\Dependency\Container;

/**
 * Fuel Renderer Provider using Dependency Container
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class FuelProvider implements RendererProviderInterface
{
	/**
	 * Menu Renderer Container
	 *
	 * @var Container
	 */
	private $container;

	/**
	 * Default renderer
	 *
	 * @var string
	 */
	private $default;

	/**
	 * Renderers
	 *
	 * @var string[]
	 */
	private $renderers = [];

	public function __construct(Container $container, $default, array $renderers)
	{
		$this->container = $container;
		$this->default = $default;
		$this->renderers = $renderers;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get($name = null)
	{
		// if no name given
		if (is_null($name))
		{
			$name = $this->default;
		}

		if ($this->has($name)) {
			$name = $this->renderers[$name];
		}

		return $this->container->resolve('menu.renderer.'.$name);
	}

	/**
	 * {@inheritdoc}
	 */
	public function has($name)
	{
		return isset($this->renderers[$name]);
	}
}

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

use Indigo\Fuel\Dependency\Container as DiC;

/**
 * Fuel Renderer Provider using Dependency Container
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class FuelProvider implements RendererProviderInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function get($name = null)
	{
		if (($renderer = \Config::get('menu.renderers.' . $name, false)) === false)
		{
			throw new \InvalidArgumentException(sprintf('The renderer "%s" is not defined.', $name));
		}

		return DiC::resolve('menu.renderer.'.$renderer);
	}

	/**
	 * {@inheritdoc}
	 */
	public function has($name)
	{
		return (bool) \Config::get('menu.renderers.' . $name, false);
	}
}

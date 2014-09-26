<?php

/*
 * This file is part of the Fuel Menu package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Knp\Menu\Provider;

use Fuel\Dependency\Container;

/**
 * Fuel Menu Provider using Dependency Container
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class FuelProvider implements MenuProviderInterface
{
	/**
	 * Menu Container
	 *
	 * @var Container
	 */
	private $container;

	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get($name = null, array $options = [])
	{
		return $this->container->resolve($name);
	}

	/**
	 * {@inheritdoc}
	 */
	public function has($name, array $options = [])
	{
		// return DiC::isInstance('menu', $name, false);
		return true;
	}
}

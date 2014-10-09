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

	/**
	 * Menu names to container IDs
	 *
	 * @var []
	 */
	private $menus = [];

	public function __construct(Container $container, array $menus = [])
	{
		$this->container = $container;
		$this->menus = $menus;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get($name = null, array $options = [])
	{
		// We have an override or named menu here
		if (array_key_exists($name, $this->menus)) {
			return $this->container->resolve($this->menus[$name]);
		}

		return $this->container->multiton('menu', $name);
	}

	/**
	 * {@inheritdoc}
	 */
	public function has($name, array $options = [])
	{
		// return DiC::isInstance('menu', $name, false);
		return true;
	}

	/**
	 * Adds a menu to the provider
	 *
	 * @param string $menu
	 * @param string $identifier
	 *
	 * @return self
	 */
	public function addMenu($menu, $identifier)
	{
		$this->menus[$menu] = $identifier;

		return $this;
	}
}

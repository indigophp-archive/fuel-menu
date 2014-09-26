<?php

/*
 * This file is part of the Fuel Menu package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Fuel\Menu;

use Knp\Menu\FactoryInterface;

/**
 * Abstract menu builder
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
abstract class Builder
{
	/**
	 * Menu factory
	 *
	 * @var FactoryInterface
	 */
	protected $factory;

	/**
	 * @param FactoryInterface $factory
	 */
	public function __construct(FactoryInterface $factory)
	{
		$this->factory = $factory;
	}
}

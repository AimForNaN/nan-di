<?php

namespace NaN\DI\Traits;

use NaN\DI\Interfaces\ContainerSetterInterface;

/**
 * Designed to be coupled with either `ContainerTrait` or `ContainerDelegatesTrait`.
 *
 * @implements ContainerSetterInterface
 *
 * @property array $_services Obtained from the other traits.
 */
trait ContainerSetterTrait {
	use ContainerTrait;

	public function withService(string $id, mixed $value): ContainerSetterInterface {
		$clone = clone $this;

		$clone->_services[$id] = $value;

		return $clone;
	}
}

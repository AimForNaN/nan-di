<?php

namespace NaN\DI\Traits;

/**
 * Designed to be coupled with either `ContainerTrait` or `ContainerDelegatesTrait`.
 *
 * @property array $_services Obtained from the other traits.
 */
trait ContainerSetterTrait {
	public function set(string $id, mixed $value): static {
		$this->_services[$id] = $value;

		return $this;
	}
}

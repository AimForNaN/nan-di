<?php

namespace NaN\DI;

class Container implements Interfaces\ContainerSetterInterface {
	use Traits\ContainerSetterTrait;

	public function __construct(
		array $services = [],
	) {
		$this->_services = $services;
	}
}

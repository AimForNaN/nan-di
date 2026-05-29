<?php

namespace NaN\DI;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface {
	use Traits\ContainerTrait;

	public function __construct(
		array $services = [],
	) {
		$this->_services = $services;
	}
}

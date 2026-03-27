<?php

namespace NaN\DI;

use Psr\Container\ContainerInterface as PsrContainerInterface;

class
	Container
implements
	Interfaces\ContainerDelegatesInterface,
	Interfaces\ContainerSetterInterface,
	PsrContainerInterface
{
	use Traits\ContainerDelegatesTrait;
	use Traits\ContainerSetterTrait;

	public function __construct(
		array $services = [],
		iterable $delegates = [],
	) {
		$this->_services = $services;
		$this->addDelegates(...$delegates);
	}
}

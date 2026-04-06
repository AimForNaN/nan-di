<?php

namespace NaN\DI;

class Container implements Interfaces\ContainerDelegatesInterface
{
	use Traits\ContainerDelegatesTrait;

	public function __construct(
		array $services = [],
		iterable $delegates = [],
	) {
		$this->_services = $services;
		$this->addDelegates(...$delegates);
	}
}

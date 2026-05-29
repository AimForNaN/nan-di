<?php

namespace NaN\DI;

class DelegatesContainer implements Interfaces\ContainerDelegatesInterface {
	use Traits\ContainerDelegatesTrait;

	public function __construct(
		array $services = [],
		array $delegates = [],
	) {
		$this->_services = $services;
		$this->_delegates = $delegates;
	}
}

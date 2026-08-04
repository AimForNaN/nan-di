<?php

namespace NaN\DI;

class DelegatesContainer implements Interfaces\ContainerDelegatesInterface {
	use Traits\ContainerDelegatesTrait;

	public function __construct(
		array $services = [],
	) {
		$this->_services = $services;
	}
}

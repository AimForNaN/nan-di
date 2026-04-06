<?php

namespace NaN\DI\Interfaces;

use Psr\Container\ContainerInterface as PsrContainerInterface;

interface ContainerDelegatesInterface extends \IteratorAggregate, PsrContainerInterface {
	public function addDelegates(PsrContainerInterface ...$delegates): static;
}

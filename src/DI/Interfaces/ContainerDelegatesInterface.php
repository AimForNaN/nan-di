<?php

namespace NaN\DI\Interfaces;

use Psr\Container\ContainerInterface as PsrContainerInterface;

interface ContainerDelegatesInterface extends \IteratorAggregate, PsrContainerInterface {
	public function withDelegate(PsrContainerInterface $delegate): ContainerDelegatesInterface;

	public function withDelegates(PsrContainerInterface ...$delegates): ContainerDelegatesInterface;
}

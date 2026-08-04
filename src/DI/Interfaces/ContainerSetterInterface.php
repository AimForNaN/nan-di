<?php

namespace NaN\DI\Interfaces;

use Psr\Container\ContainerInterface as PsrContainerInterface;

interface ContainerSetterInterface extends PsrContainerInterface {
	public function withService(string $id, mixed $value): ContainerSetterInterface;
}

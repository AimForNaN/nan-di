<?php

namespace NaN\DI\Traits;

use NaN\DI\{
	Arguments,
	Exceptions\NotFoundException,
};
use Psr\Container\{
	ContainerExceptionInterface,
	NotFoundExceptionInterface,
};

trait ContainerTrait {
	protected array $_services = [];

	/**
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundException
	 * @throws \ReflectionException
	 */
	public function get(string $id): mixed {
		$entry = $this->_services[$id] ?? null;

		if ($entry) {
			return $this->resolve($entry);
		}

		throw new NotFoundException("Entity {$id} could not be found!");
	}

	public function has(string $id): bool {
		return isset($this->_services[$id]);
	}

	/**
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 * @throws \ReflectionException
	 */
	public function resolve(mixed $value): mixed {
		if ($value instanceof \Closure) {
			$value = \Closure::bind($value, $this);
			return $value();
		}

		if (\is_string($value)) {
			$args = Arguments::fromClassConstructor($value);
			$resolved = $args->resolve([], $this);
			return new $value(...$resolved);
		}

		return $value;
	}
}

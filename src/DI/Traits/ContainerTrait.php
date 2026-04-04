<?php

namespace NaN\DI\Traits;

use NaN\DI\Arguments;
use NaN\DI\Exceptions\NotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

trait ContainerTrait {
	protected array $_services = [];

	/**
	 * @throws \ReflectionException
	 * @throws NotFoundException
	 */
	public function get(string $id): mixed {
		$entry = $this->_services[$id] ?? null;

		if ($entry) {
			return $this->_resolve($entry);
		}

		throw new NotFoundException("Entity {$id} could not be found!");
	}

	public function has(string $id): bool {
		return isset($this->_services[$id]);
	}

	/**
	 * @throws ContainerExceptionInterface
	 * @throws \ReflectionException
	 * @throws NotFoundExceptionInterface
	 */
	protected function _resolve(mixed $value): mixed {
		if ($value instanceof \Closure) {
			$value = \Closure::bind($value, $this);
			return $value();
		}

		if (\is_string($value) && \class_exists($value, false)) {
			$args = Arguments::fromClassConstructor($value);
			$resolved = $args->resolve([], $this);
			return new $value(...$resolved);
		}

		return $value;
	}
}

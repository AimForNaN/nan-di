<?php

namespace NaN\DI;

use NaN\DI\Interfaces\ArgumentInterface;
use Psr\Container\{
	ContainerExceptionInterface,
	ContainerInterface as PsrContainerInterface,
	NotFoundExceptionInterface,
};

readonly class Arguments implements \Countable, \IteratorAggregate {
	protected array $_args;

	public function __construct(
		Argument ...$args,
	) {
		$this->_args = $args;
	}

	public function count(): int {
		return \count($this->_args);
	}

	/**
	 * @throws \ReflectionException
	 */
	static public function fromCallable(callable $callable): self {
		$rf = new \ReflectionFunction($callable);
		$arguments = \array_map(static::fromParameter(...), $rf->getParameters());

		return new self(...$arguments);
	}

	/**
	 * @throws \ReflectionException
	 */
	static public function fromClassConstructor(string $class): self {
		$rf = new \ReflectionClass($class);
		$constructor = $rf->getConstructor();

		if ($constructor) {
			$arguments = \array_map(static::fromParameter(...), $constructor->getParameters());
		}

		$arguments ??= [];

		return new self(...$arguments);
	}

	/**
	 * @throws \ReflectionException
	 */
	static public function fromClassMethod(object|string $class, string $method): self {
		$rf = new \ReflectionClass($class);
		$rf = $rf->getMethod($method);
		$arguments = \array_map(static::fromParameter(...), $rf->getParameters());

		return new self(...$arguments);
	}

	static public function fromParameter(\ReflectionParameter $param): ArgumentInterface {
		return Argument::fromParameter($param);
	}

	public function getIterator(): \Traversable {
		yield from $this->_args;
	}

	/**
	 * @todo Handle variadic parameters!
	 *
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	public function resolve(array $values = [], ?PsrContainerInterface $container = null): array {
		$resolved = [];

		/** @var ArgumentInterface $argument */
		foreach ($this as $argument) {
			$name = $argument->getName();

			if (isset($values[$name])) {
				if ($argument->isPrimitive()) {
					$resolved[] = $argument->resolvePrimitive($values[$name]);
				} else {
					$resolved[] = $values[$name];
				}
			} else {
				$type = \array_find_key($argument->getTypes(), fn($x) => !$x);

				if (!empty($type) && $container) {
					if (
						\class_exists($type, false) ||
						\interface_exists($type, false)
					) {
						$has = $container->has($type);

						if (!$has) {
							if ($argument->hasDefaultValue()) {
								$resolved[] = $argument->getDefaultValue();
							} else if ($argument->isNullable()) {
								$resolved[] = null;
							}
						} else {
							$resolved[] = $container->get($type);
						}

						// Make sure default value doesn't override anything!
						continue;
					}
				}

				if ($argument->hasDefaultValue()) {
					$resolved[] = $argument->getDefaultValue();
				} else if ($argument->isNullable()) {
					$resolved[] = null;
				}
			}
		}

		return $resolved;
	}
}

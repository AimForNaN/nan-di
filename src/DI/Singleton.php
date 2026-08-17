<?php

namespace NaN\DI;

use Psr\Container\{
	ContainerExceptionInterface as PsrContainerExceptionInterface,
	ContainerInterface as PsrContainerInterface,
	NotFoundExceptionInterface as PsrNotFoundExceptionInterface,
};

readonly class Singleton {
	private mixed $__resolved;

	public function __construct(
		private \Closure $__closure,
	) {
	}

	/**
	 * @throws PsrContainerExceptionInterface
	 * @throws PsrNotFoundExceptionInterface
	 * @throws \ReflectionException
	 */
	public function resolve(PsrContainerInterface $container) {
		if (isset($this->__resolved)) {
			return $this->__resolved;
		}

		$args = Arguments::fromCallable($this->__closure);
		$resolved = $args->resolve([], $container);
		$this->__resolved = \call_user_func_array($this->__closure, $resolved);

		return $this->__resolved;
	}
}

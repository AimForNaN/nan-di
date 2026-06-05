<?php

namespace NaN\DI;

use Psr\Container\ContainerInterface as PsrContainerInterface;

class Singleton {
	private mixed $__resolved;

	public function __construct(
		private \Closure $__closure,
	) {
		var_dump(gettype($this->__closure));
	}

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

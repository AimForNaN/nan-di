<?php

namespace NaN\DI;

use Psr\Container\ContainerInterface as PsrContainerInterface;

/**
 * Useful for facades!
 *
 * @method static mixed get(string $id)
 * @method static bool has(string $id)
 */
final class GlobalContainer {
	private static PsrContainerInterface $__instance;

	private function __construct() {
	}

	public static function __callStatic($name, $args) {
		return \call_user_func_array([self::getInstance(), $name], $args);
	}

	public static function getInstance(): PsrContainerInterface {
		return self::$__instance ?? new Container();
	}

	public static function register(PsrContainerInterface $services): void {
		if (isset(self::$__instance)) {
			throw new \RuntimeException('Global container is already registered!');
		}

		self::$__instance = $services;
	}
}

<?php

use NaN\DI\{
	Arguments,
	Container,
};

describe('Dependency Injection: Arguments', function () {
	test('Basic resolution', function () {
		$container = new Container([
			\DateTimeInterface::class => DateTime::class,
		]);
		$callable = function (int $test1, string $test2, \DateTimeInterface $test3) {};
		$arguments = Arguments::fromCallable($callable);
		$resolved = $arguments->resolve(['test1' => 1, 'test2' => ''], $container);

		expect($arguments)
			->toHaveCount(3)
			->and($resolved)
				->toHaveCount(3)
			->and($resolved[2])
				->toBeInstanceOf(\DateTimeInterface::class);
		;
	});
});

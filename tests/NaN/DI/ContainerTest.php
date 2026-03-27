<?php

use NaN\DI\Container;

describe('Dependency Injection: Container', function () {
	test('Class resolution', function () {
		$container = new Container([
			\DateTimeInterface::class => DateTime::class,
		]);
		$response = $container->get(\DateTimeInterface::class);

		expect($response)->toBeinstanceOf(\DateTimeInterface::class);
	});

	test('Closure resolution', function () {
		$container = new Container([
			\DateTimeInterface::class => function () {
				expect(\func_get_args())
					->toHaveLength(0)
					->and($this)
						->toBeInstanceOf(Container::class)
				;

				return new \DateTime();
			},
		]);
		$response = $container->get(\DateTimeInterface::class);

		expect($response)->toBeinstanceOf(DateTimeInterface::class);
	});

	test('Delegate', function () {
		$delegate = new Container([
			\DateTimeInterface::class => DateTime::class,
		]);
		$container = new Container(delegates: [$delegate]);

		expect($container->has(\DateTimeInterface::class))
			->toBeTrue()
			->and($container->get(\DateTimeInterface::class))
				->toBeinstanceOf(\DateTimeInterface::class)
		;
	});

	test('Single instance resolution', function () {
		$container = new Container([
			\DateTimeInterface::class => new \DateTime(),
		]);
		$response = $container->get(\DateTimeInterface::class);

		expect($container->has(\DateTimeInterface::class))
			->toBeTrue()
			->and($response)
				->toBeinstanceOf(\DateTimeInterface::class)
			->and($response)
				->toBe($container->get(\DateTimeInterface::class))
		;
	});
});

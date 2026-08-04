<?php

use NaN\DI\{
	Container,
	DelegatesContainer,
	Singleton,
};

describe('Dependency Injection: Container', function () {
	test('Class resolution', function () {
		$container = new Container([
			\DateTimeInterface::class => DateTime::class,
			Test::class => Test::class,
		]);
		$response = $container->get(\DateTimeInterface::class);

		expect($response)->toBeinstanceOf(\DateTimeInterface::class);

		$response = $container->get(Test::class);

		expect($response)->toBeinstanceOf(Test::class);
	});

	test('Closure resolution', function () {
		$container = new Container([
			\DateTimeInterface::class => function () {
				expect(\func_get_args())
					->toHaveLength(0)
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
		$container = new DelegatesContainer()->withDelegate($delegate);

		expect($container->has(\DateTimeInterface::class))
			->toBeTrue()
			->and($container->get(\DateTimeInterface::class))
				->toBeinstanceOf(\DateTimeInterface::class)
		;
	});

	test('Setter', function () {
		$container = new Container([
			\DateTimeInterface::class => DateTime::class,
		]);

		expect($container->has(\DateTimeInterface::class))
			->toBeTrue()
			->and($container->get(\DateTimeInterface::class))
				->not->toEqual($container->get(\DateTimeInterface::class))
		;

		$container = $container->withService(
			\DateTimeInterface::class,
			new \DateTime(),
		);

		expect($container->has(\DateTimeInterface::class))
			->toBeTrue()
			->and($container->get(\DateTimeInterface::class))
				->toEqual($container->get(\DateTimeInterface::class))
		;
	});

	test('Single instance resolution', function () {
		$container = new Container([
			\DateTimeInterface::class => new \DateTime(),
			'single' => new Singleton(function () {
				return new \DateTime();
			}),
		]);
		$response = $container->get(\DateTimeInterface::class);

		expect($container->has(\DateTimeInterface::class))
			->toBeTrue()
			->and($response)
				->toBeinstanceOf(\DateTimeInterface::class)
			->and($response)
				->toBe($container->get(\DateTimeInterface::class))
			->and($container->get('single'))
				->toBe($container->get('single'))
		;
	});
});

<?php

namespace NaN\DI\Interfaces;

interface ContainerSetterInterface {
	public function set(string $id, mixed $value): static;
}

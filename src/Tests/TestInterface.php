<?php declare(strict_types=1);

namespace App\Tests;

interface TestInterface
{
    public function __construct(string $name, callable $callback, array $arguments);

    public function getName(): string;

    public function getCallback(): callable;

    public function getArguments(): array;

    public function setIterationsMade(int $iterationsMade): void;

    public function getIterationsMade(): int;
}

<?php declare(strict_types=1);

namespace App\Tests;

class TestCase implements TestInterface
{
    private string $name;

    /** @var callable */
    private $callback;

    private array $arguments;

    private int $iterationsMade = 0;

    public function __construct(string $name, callable $callback, array $arguments)
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->arguments = $arguments;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCallback(): callable
    {
        return $this->callback;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function setIterationsMade(int $iterationsMade): void
    {
        $this->iterationsMade = $iterationsMade;
    }

    public function getIterationsMade(): int
    {
        return $this->iterationsMade;
    }
}

<?php declare(strict_types=1);

namespace App\Tests;

abstract class AbstractTestRunner
{
    public const DEFAULT_TEST_RUN_TIME = 2500; // ms to run per test

    /** @var TestInterface[] */
    private array $tests = [];

    /** @var float[] */
    private array $times = [];

    protected function addTest(TestInterface $test): void
    {
        $this->tests[] = $test;
    }

    public function runTests(): array
    {
        echo $this->getName(), "\n";

        foreach ($this->tests as $test) {
            printf("\r-> Running %- 80s", $test->getName());

            $microtime = $this->runTest($test);

            $this->times[$test->getName()] = $microtime;
        }

        echo "\r";

        return $this->times;
    }

    private function runTest(TestInterface $test): float
    {
        $callback = $test->getCallback();
        $arguments = $test->getArguments();

        $start = microtime(true);
        $iterations = 0;

        while (true) {
            $callback(...$arguments);
            $iterations++;

            $runtime = microtime(true) - $start;
            if (($runtime * 1000) >= self::DEFAULT_TEST_RUN_TIME) {
                break;
            }
        }

        $test->setIterationsMade($iterations);

        return $runtime;
    }

    public function getResult(bool $asTableData = true): array
    {
        $result = [];

        $maxIterationsPerSecond = 0;

        foreach ($this->tests as $i => $test) {
            $name = $test->getName();

            if (empty($this->times[$name])) {
                return [];
            }

            $iterationsPerSecond = 1 / ($this->times[$name] / $test->getIterationsMade());

            $maxIterationsPerSecond = max($maxIterationsPerSecond, $iterationsPerSecond);

            if ($asTableData) {
                $result[] = [
                    'Test' => $name,
                    'Total time' => number_format($this->times[$name], 3),
                    '# iterations' => number_format($test->getIterationsMade()),
                    'Iterations/sec' => number_format(round($iterationsPerSecond, 1), 1),
                    'iterations_per_second' => $iterationsPerSecond,
                ];
            } else {
                $result[$name] = number_format($iterationsPerSecond, 1);
            }
        }

        foreach ($result as &$row) {
            $row['% slower'] = number_format(abs($row['iterations_per_second'] / $maxIterationsPerSecond * 100 - 100), 3);
            unset($row['iterations_per_second']);
        }

        return $result;
    }

    public function getName(): string
    {
        $class = static::class;

        return substr($class, strrpos($class, '\\') + 1);
    }
}

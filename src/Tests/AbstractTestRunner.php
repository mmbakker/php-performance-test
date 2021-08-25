<?php declare(strict_types=1);

namespace App\Tests;

abstract class AbstractTestRunner
{
    public const DEFAULT_TEST_RUN_TIME = 2500; // ms to run per test

    /** @var array|TestInterface[] */
    private $tests = [];

    /** @var array|float[] */
    private $times = [];

    protected function addTest(TestInterface $test): void
    {
        $this->tests[] = $test;
    }

    public function runTests(): array
    {
        foreach ($this->tests as $test) {
            $microtime = $this->runTest($test);

            $this->times[$test->getName()] = $microtime;
        }

        return $this->times;
    }

    private function runTest(TestInterface $test): float
    {
        $callback = $test->getCallback();
        $arguments = $test->getArguments();

        $start = microtime(true);
        $runtime = 0;
        $iterations = 0;

        while (true) {
            call_user_func($callback, ...$arguments);
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

        foreach ($this->tests as $test) {
            $name = $test->getName();

            if (empty($this->times[$name])) {
                return [];
            }

            $iterationsPerSecond = 1 / ($this->times[$name] / $test->getIterationsMade());

            if ($asTableData) {
                $result[] = [
                    'Test' => $name,
                    'Total time' => number_format($this->times[$name], 3),
                    '# iterations' => number_format($test->getIterationsMade()),
                    'Iterations/sec' => number_format(round($iterationsPerSecond, 1), 1),
                ];
            } else {
                $result[$name] = number_format($iterationsPerSecond, 1);
            }
        }

        return $result;
    }
}

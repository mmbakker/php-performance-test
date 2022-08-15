<?php declare(strict_types=1);

namespace App\Tests;

class PowVsAsterisks extends AbstractTestRunner
{
    public function __construct()
    {
        $this->addTest(new TestCase('pow(1, 1)', function () {
            return pow(1, 1);
        }, []));

        $this->addTest(new TestCase('pow(8, 8)', function () {
            return pow(8, 8);
        }, []));

        $this->addTest(new TestCase('1 ** 1', function () {
            return pow(1, 1);
        }, []));

        $this->addTest(new TestCase('8 ** 8', function () {
            return pow(8, 8);
        }, []));
    }
}

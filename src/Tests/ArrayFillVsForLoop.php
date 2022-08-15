<?php declare(strict_types=1);

namespace App\Tests;

class ArrayFillVsForLoop extends AbstractTestRunner
{
    public function __construct()
    {
        $numItems = 65000;

        $this->addTest(
            new TestCase('for-loop - null', function (int $numItems) {
                $array = [];
                for ($i = 0; $i < $numItems; $i++) {
                    $array[] = null;
                }
            }, [$numItems])
        );

        $this->addTest(
            new TestCase('array_fill - null', function (int $numItems) {
                $array = array_fill(0, $numItems, null);
            }, [$numItems])
        );

        $this->addTest(
            new TestCase('for-loop - new object', function (int $numItems) {
                $array = [];
                for ($i = 0; $i < $numItems; $i++) {
                    $array[] = new \stdClass;
                }
            }, [$numItems])
        );

        // $this->addTest(
        //     new TestCase('array_fill - new object', function (int $numItems) {
        //         // $array = array_fill(0, $numItems, null);
        //     }, [$numItems])
        // );
    }
}

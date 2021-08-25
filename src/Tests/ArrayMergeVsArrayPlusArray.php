<?php declare(strict_types=1);

namespace App\Tests;

class ArrayMergeVsArrayPlusArray extends AbstractTestRunner
{
    public function __construct()
    {
        $input = [
            [
                'key_' . mt_rand() => 'value_' . mt_rand(),
                'key_' . mt_rand() => 'value_' . mt_rand(),
                'key_' . mt_rand() => 'value_' . mt_rand(),
                'key_' . mt_rand() => 'value_' . mt_rand(),
                'key_' . mt_rand() => 'value_' . mt_rand(),
            ],
            [
                'key_' . mt_rand() => 'value_' . mt_rand(),
                'key_' . mt_rand() => 'value_' . mt_rand(),
                'key_' . mt_rand() => 'value_' . mt_rand(),
                'key_' . mt_rand() => 'value_' . mt_rand(),
                'key_' . mt_rand() => 'value_' . mt_rand(),
            ],
        ];

        $this->addTest(
            new TestCase(
                'array_merge',
                function (array $array1, array $array2) {
                    return array_merge($array1, $array2);
                },
                $input
            )
        );

        $this->addTest(
            new TestCase(
                'array + array',
                function (array $array1, array $array2) {
                    return $array1 + $array2;
                },
                $input
            )
        );
    }
}

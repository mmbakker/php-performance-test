<?php declare(strict_types=1);

namespace App\Tests;

class SnakeCaseToCamelCaseTest extends AbstractTestRunner
{
    public function __construct()
    {
        $input = ['this_is_a_string_in_camel_case'];

        $this->addTest(
            new TestCase(
                'lcfirst/implode/array_map/explode',
                function (string $string) {
                    return lcfirst(implode('', array_map('ucfirst', explode('_', $string))));
                },
                $input
            )
        );

        $this->addTest(
            new TestCase(
                'preg_replace_callback',
                function (string $string) {
                    return preg_replace_callback(
                        '~_\\w~',
                        function (array $matches) {
                            return mb_strtoupper(substr($matches[0], 1));
                        },
                        $string
                    );
                },
                $input
            )
        );
    }
}

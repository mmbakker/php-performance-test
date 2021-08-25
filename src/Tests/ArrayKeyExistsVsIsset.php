<?php declare(strict_types=1);

namespace App\Tests;

class ArrayKeyExistsVsIsset extends AbstractTestRunner
{
    public function __construct()
    {
        $input = [['a' => 'a', 'b' => 'b']];

        $this->addTest(new TestCase('isset()', function (array $a) {
            return isset($a['a']);
        }, $input));

        $this->addTest(new TestCase('!empty()', function (array $a) {
            return !empty($a['a']);
        }, $input));

        $this->addTest(new TestCase('array_key_exists()', function (array $a) {
            return array_key_exists('a', $a);
        }, $input));
    }
}

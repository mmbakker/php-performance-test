<?php declare(strict_types=1);

namespace App\Tests;

class ArraySearchVsIsset extends AbstractTestRunner
{
    public function __construct()
    {
        $input = [['a' => true, 'b' => true, 'c' => true]];

        $this->addTest(new TestCase('isset()', function (array $a) {
            return isset($a['a']);
        }, $input));

        $this->addTest(new TestCase('array_search', function (array $a) {
            return array_search('c', $a) !== false;
        }, $input));

        $this->addTest(new TestCase('array_key_exists()', function (array $a) {
            return array_key_exists('a', $a);
        }, $input));
    }
}

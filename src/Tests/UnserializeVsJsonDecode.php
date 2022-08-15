<?php declare(strict_types=1);

namespace App\Tests;

class UnserializeVsJsonDecode extends SerializeVsJsonEncode
{
    public function __construct()
    {
        // 500 items
        $items = self::getItems(500);

        $this->addTest(
            new TestCase('unserialize - associative array - 500 items', function (string $items) {
                return unserialize($items);
            }, [$items['serialized']])
        );

        $this->addTest(
            new TestCase('json_decode - associative array - 500 items', function (string $items) {
                return json_decode($items, true);
            }, [$items['json_encoded']])
        );

        // 49 items
        $items = self::get49Items();

        $this->addTest(
            new TestCase('unserialize - associative array - 49 items', function (string $items) {
                return unserialize($items);
            }, [$items['serialized']])
        );

        $this->addTest(
            new TestCase('json_decode - associative array - 49 items', function (string $items) {
                return json_decode($items, true);
            }, [$items['json_encoded']])
        );

        // 5 items
        $items = self::getItems(5);

        $this->addTest(
            new TestCase('unserialize - associative array - 5 items', function (string $items) {
                return unserialize($items);
            }, [$items['serialized']])
        );

        $this->addTest(
            new TestCase('json_decode - associative array - 5 items', function (string $items) {
                return json_decode($items, true);
            }, [$items['json_encoded']])
        );
    }

    protected static function get49Items(): array
    {
        $items = parent::get49Items();

        return [
            'serialized' => serialize($items),
            'json_encoded' => json_encode($items),
        ];
    }

    protected static function getItems(int $numItems): array
    {
        $items = parent::getItems($numItems);

        return [
            'serialized' => serialize($items),
            'json_encoded' => json_encode($items),
        ];
    }
}

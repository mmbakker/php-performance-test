<?php declare(strict_types=1);

namespace App\Tests;

class SerializeVsJsonEncode extends AbstractTestRunner
{
    public function __construct()
    {
        // 49 items
        $items = self::get49Items();

        $this->addTest(
            new TestCase('serialize - associative array - 49 items', function (array $items) {
                return serialize($items);
            }, [$items])
        );

        $this->addTest(
            new TestCase('json_encode - associative array - 49 items', function (array $items) {
                return json_encode($items);
            }, [$items])
        );

        // 5 items
        $items = self::getItems(5);

        $this->addTest(
            new TestCase('serialize - associative array - 5 items', function (array $items) {
                return serialize($items);
            }, [$items])
        );

        $this->addTest(
            new TestCase('json_encode - associative array - 5 items', function (array $items) {
                return json_encode($items);
            }, [$items])
        );

        // 500 items
        $items = self::getItems(500);

        $this->addTest(
            new TestCase('serialize - associative array - 500 items', function (array $items) {
                return serialize($items);
            }, [$items])
        );

        $this->addTest(
            new TestCase('json_encode - associative array - 500 items', function (array $items) {
                return json_encode($items);
            }, [$items])
        );
    }

    protected static function getItems(int $numItems): array
    {
        $items = [];

        while ($numItems--) {
            $items[self::getRandomString(mt_rand(4, 32))] = self::getRandomString(mt_rand(1, 16));
        }

        return $items;

        // if ($numItems > 49) {
        //     throw new \InvalidArgumentException('Only 49 items or less are supported at this time.');
        // }
        //
        // if ($numItems < 1) {
        //     throw new \InvalidArgumentException('You need to select at least one item.');
        // }
        //
        // return array_slice(self::get49Items(), 0, $numItems, true);
    }

    private static function getRandomString(int $length): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789._';
        $numChars = strlen($chars);

        $string = '';
        while ($length--) {
            $pos = mt_rand(0, $numChars - 1);

            $string .= substr($chars, $pos, 1);
        }

        return $string;
    }

    protected static function get49Items(): array
    {
        return [
            'position_x' => '0',
            'position_y' => '0',
            'width' => '200',
            'height' => '112',
            'depth' => '1',
            'background_color' => '[0,0,0,1]',
            'border_color' => '[0,0,0,1]',
            'border_alpha' => '1.0',
            'border_width' => '1',
            'border_radius' => '0',
            'border_corner' => 'all',
            'ppm_enabled' => '',
            'ppm_color' => '[0,0,0,1]',
            'ppm_width' => '1',
            'ppm_radius' => '0',
            'ppm_corner' => 'all',
            'ppm2_enabled' => '',
            'ppm2_color' => '[0,0,0,1]',
            'ppm2_width' => '1',
            'ppm2_radius' => '0',
            'ppm2_corner' => 'all',
            'umd_height' => '10',
            'umd1_enabled' => '',
            'umd1_color' => '[0,0,0,1]',
            'umd1_width' => '1',
            'umd1_border_width' => '0',
            'umd1_radius' => '0',
            'umd1_corner' => 'all',
            'umd2_enabled' => '1',
            'umd2_color' => '[0,0,0,1]',
            'umd2_width' => '1',
            'umd2_border_width' => '0',
            'umd2_radius' => '0',
            'umd2_corner' => 'all',
            'umd3_enabled' => '',
            'umd3_color' => '[0,0,0,1]',
            'umd3_width' => '1',
            'umd3_border_width' => '0',
            'umd3_radius' => '0',
            'umd3_corner' => 'all',
            'tally_enabled' => '',
            'tally_left_side_lamp_color' => '[0,0,0,1]',
            'tally_left_side_lamp_width' => '1',
            'tally_left_side_lamp_radius' => '0',
            'tally_left_side_lamp_corner' => 'all',
            'tally_right_side_lamp_color' => '[0,0,0,1]',
            'tally_right_side_lamp_width' => '1',
            'tally_right_side_lamp_radius' => '0',
            'tally_right_side_lamp_corner' => 'all',
        ];
    }
}

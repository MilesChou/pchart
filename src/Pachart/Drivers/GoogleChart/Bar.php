<?php

declare(strict_types=1);

namespace Pastock\Pachart\Drivers\GoogleChart;

class Bar extends GoogleChart
{
    public function initParameter(): array
    {
        return [
            'cht' => 'bvg',
        ];
    }
}

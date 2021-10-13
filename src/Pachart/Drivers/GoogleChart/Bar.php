<?php

namespace Pachart\Drivers\GoogleChart;

class Bar extends GoogleChart
{
    public function initParameter(): array
    {
        return [
            'cht' => 'bvg',
        ];
    }
}

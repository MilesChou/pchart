<?php

namespace Pachart\Drivers\GoogleChart;

class Line extends GoogleChart
{
    public function initParameter(): array
    {
        return [
            'cht' => 'lc',
        ];
    }
}

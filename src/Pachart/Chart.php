<?php

declare(strict_types=1);

namespace Pastock\Pachart;

interface Chart
{
    /**
     * Return the binary content
     *
     * @return string
     */
    public function binary(): string;

    /**
     * @param iterable $data
     * @return Chart
     */
    public function appendData(iterable $data): Chart;
}

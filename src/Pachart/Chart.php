<?php

declare(strict_types=1);

namespace Pachart;

interface Chart
{
    /**
     * Return the binary content
     *
     * @return string
     */
    public function binary(): string;
}

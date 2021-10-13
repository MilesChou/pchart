<?php

declare(strict_types=1);

namespace Pachart\Contracts;

interface Chartable
{
    /**
     * Return the binary content
     *
     * @return string
     */
    public function content(): string;
}

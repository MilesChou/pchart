<?php

declare(strict_types=1);

namespace Phart\Contracts;

interface Chartable
{
    /**
     * Return the binary content
     *
     * @return string
     */
    public function content(): string;
}

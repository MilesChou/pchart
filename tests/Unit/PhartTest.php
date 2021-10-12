<?php

declare(strict_types=1);

namespace Tests\Unit;

use Phart\Phart;
use Tests\TestCase;

class PhartTest extends TestCase
{
    /**
     * @test
     */
    public function sample(): void
    {
        $this->assertTrue((new Phart())->alwaysTrue());
    }
}

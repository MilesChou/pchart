<?php

namespace Tests\Unit\Drivers\GoogleChart;

use ArrayIterator;
use Laminas\Diactoros\RequestFactory;
use MilesChou\Psr\Http\Client\Testing\MockClient;
use Pachart\Drivers\GoogleChart\Bar;
use PHPUnit\Framework\TestCase;

class BarTest extends TestCase
{


    /**
     * @dataProvider iterableCase
     */
    public function testSetDataFormat($iterable)
    {
        $target = new Bar(new MockClient(), new RequestFactory());

        $target->appendData($iterable);

        $this->expectNotToPerformAssertions();
    }

    public function iterableCase(): iterable
    {
        yield [[]];
        yield [new ArrayIterator()];
    }
}
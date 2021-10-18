<?php

declare(strict_types=1);

namespace Pastock\Pachart\Drivers\GoogleChart;

use Pastock\Pachart\Chart;
use Pastock\Pachart\Concerns\HasData;
use Pastock\Pachart\Utils;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

/**
 * @see https://developers.google.com/chart/image/docs/making_charts
 */
abstract class GoogleChart implements Chart
{
    use HasData;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var RequestFactoryInterface
     */
    private $requestFactory;

    /**
     * @var array
     */
    private $parameter;

    public function __construct(ClientInterface $client, RequestFactoryInterface $requestFactory)
    {
        $this->client = $client;
        $this->requestFactory = $requestFactory;
        $this->parameter = $this->initParameter();
    }

    public function size(int $x, int $y): self
    {
        $this->parameter['chs'] = "{$x}x{$y}";

        return $this;
    }

    public function setXt(): self
    {
        $this->parameter['chxt'] = 'x,y';

        return $this;
    }

    public function setGrid(int $x, int $y): self
    {
        $this->parameter['chg'] = "$x,$y";

        return $this;
    }

    public function buildUri(): string
    {
        $lower = $this->lower();
        $upper = $this->upper();

        $diff = $upper - $lower;
        $lower -= ($diff * $this->padding / 100);
        $upper += ($diff * $this->padding / 100);

        $data = array_map(function ($v) use ($lower, $upper) {
            return array_map(function ($v) use ($lower, $upper) {
                return sprintf('%.1f', 100 * (($v - $lower) / ($upper - $lower)));
            }, Utils::iterateToArray($v));
        }, Utils::iterateToArray($this->data));

        $t = implode('|', array_map(function ($v) {
            return implode(',', $v);
        }, $data));

        $parameter = array_merge([
            'chd' => 't:' . $t,
            'chxl' => '0:|' . implode('|', $this->label),
            'chxr' => "1,{$lower},{$upper}",
            'chco' => $this->color(count($this->data)),
        ], $this->parameter);

        return 'https://chart.googleapis.com/chart?' . http_build_query($parameter, '', '&', PHP_QUERY_RFC3986);
    }

    public function binary(): string
    {
        $response = $this->client->sendRequest(
            $this->requestFactory->createRequest('GET', $this->buildUri())
        );

        return (string)$response->getBody();
    }

    abstract public function initParameter(): array;

    private function color($count): string
    {
        $arr = [];
        for ($i = 0; $i < $count; $i++) {
            $arr[] = $this->randomColor();
        }

        return implode(',', $arr);
    }

    private function randomColor(): string
    {
        $r = random_int(0x22, 0xAA);
        $g = random_int(0x22, 0xAA);
        $b = random_int(0x22, 0xAA);

        return strtoupper(dechex($r) . dechex($g) . dechex($b));
    }
}

<?php

namespace Pachart\Drivers\GoogleChartApi;

use Pachart\Contracts\Chartable;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

class Line implements Chartable
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var array
     */
    private $data;

    /**
     * @var RequestFactoryInterface
     */
    private $uriFactory;

    /**
     * @var array
     */
    private $parameter;

    /**
     * @var int
     */
    private $upper;

    /**
     * @var int
     */
    private $lower;
    /**
     * @var int
     */
    private $paddingPercent = 0;

    public function __construct(ClientInterface $client, RequestFactoryInterface $uriFactory)
    {
        $this->client = $client;
        $this->uriFactory = $uriFactory;

        $this->parameter = [
            'cht' => 'lc',
        ];
    }

    public function size(int $x, int $y): self
    {
        $this->parameter['chs'] = "{$x}x{$y}";

        return $this;
    }

    public function range(int $upper, int $lower): self
    {
        $this->upper = $upper;
        $this->lower = $lower;

        return $this;
    }

    public function rangePaddingPercent(int $percent): self
    {
        $this->paddingPercent = $percent;

        return $this;
    }

    public function setXt(): self
    {
        $this->parameter['chxt'] = 'x,y';

        return $this;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function setXLabel(array $data): self
    {
        $this->parameter['chxl'] = '0:|' . implode('|', $data);

        return $this;
    }

    public function setGrid($x, $y): self
    {
        $this->parameter['chg'] = "$x,$y";

        return $this;
    }

    public function buildUri(): string
    {
        $lower = $this->lower ?? min($this->data);
        $upper = $this->upper ?? max($this->data);

        $diff = $upper - $lower;
        $lower -= ($diff * $this->paddingPercent / 100);
        $upper += ($diff * $this->paddingPercent / 100);

        $data = array_map(function ($v) use ($lower, $upper) {
            return 100 * (($v - $lower) / ($upper - $lower));
        }, $this->data);

        $this->parameter['chd'] = 't:' . implode(',', $data);
        $this->parameter['chxr'] = "1,{$lower},{$upper}";

        return 'https://chart.googleapis.com/chart?' . http_build_query($this->parameter, '', '&', PHP_QUERY_RFC3986);
    }

    public function content(): string
    {
        $response = $this->client->sendRequest(
            $this->uriFactory->createRequest('GET', $this->buildUri())
        );

        return (string)$response->getBody();
    }
}

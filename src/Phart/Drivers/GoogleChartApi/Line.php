<?php

namespace Phart\Drivers\GoogleChartApi;

use Phart\Contracts\Chartable;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

class Line implements Chartable
{
    /**
     * @var ClientInterface
     */
    private $client;

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
    private $upper = 100;

    /**
     * @var int
     */
    private $lower = 0;

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

        $this->parameter['chxr'] = '1,550,600';

        return $this;
    }

    public function setXt(): self
    {
        $this->parameter['chxt'] = 'x,y';

        return $this;
    }

    public function setData(array $data): self
    {
        $data = array_map(function ($v) {
            return 100 * (($v - $this->lower) / ($this->upper - $this->lower));
        }, $data);

        $this->parameter['chd'] = 't:' . implode(',', $data);

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

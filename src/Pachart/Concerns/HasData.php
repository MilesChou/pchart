<?php

namespace Pastock\Pachart\Concerns;

use Pastock\Pachart\Chart;
use Pastock\Pachart\Utils;

trait HasData
{
    /**
     * @var iterable[]
     */
    private $data = [];

    /**
     * @var array
     */
    private $label = [];

    /**
     * @var int
     */
    private $lower;

    /**
     * @var int
     */
    private $padding = 0;

    /**
     * @var int
     */
    private $upper;

    /**
     * @param iterable $data
     * @return Chart
     */
    public function appendData(iterable $data): Chart
    {
        $this->data[] = $data;

        return $this;
    }

    /**
     * @param int $lower
     * @param int $upper
     * @return Chart
     */
    public function range(int $lower, int $upper): Chart
    {
        $this->lower = $lower;
        $this->upper = $upper;

        return $this;
    }

    /**
     * @param int $percent
     * @return Chart
     */
    public function paddingPercent(int $percent): Chart
    {
        $this->padding = $percent;

        return $this;
    }

    public function lower(): int
    {
        return $this->lower ?? $this->min();
    }

    public function upper(): int
    {
        return $this->upper ?? $this->max();
    }

    private function max(): int
    {
        return max(array_map(function ($v) {
            return max($v);
        }, $this->data, []));
    }

    private function min(): int
    {
        return min(array_map(function ($v) {
            return min($v);
        }, $this->data, []));
    }

    public function setXLabel(array $labels): self
    {
        $this->label = Utils::iterateToArray($labels);

        return $this;
    }
}

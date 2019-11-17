<?php


namespace App;


use Jaeger\Config;
use OpenTracing\Tracer;

class Calc
{
    public const MAX_ITERATIONS_COUNT = 100;

    /**
     * @var Tracer
     */
    protected $tracer;

    public function __invoke(int $value = 0): ?int
    {
        $this->initTracer();
        $iteratorIndex = 0;

        $span = $this->tracer->startSpan(__METHOD__);
        $span->setTag('className', self::class);
        while ($iteratorIndex++ <= self::MAX_ITERATIONS_COUNT) {
            $span->log([$value]);
            $res = $this->calcPlusTwo($value, $span);
            $value = $this->calcMinusOne($res, $span);
        }

        $span->finish();
        $config = Config::getInstance();
        $config->flush();
        return $value;
        // TODO: Implement __invoke() method.
    }

    protected function initTracer()
    {
        $config = Config::getInstance();
        $this->tracer = $config->initTracer('example', '0.0.0.0:6831');
    }

    protected function calcPlusTwo(int $value, $pspan): int
    {
        $result = $value + 2;

        $span = $this->tracer->startSpan(__METHOD__);
        $span->log(['calc_log' => $result]);
        $span->finish();
        return $result;
    }

    protected function calcMinusOne(int $value, $pspan): int
    {
        $result = $value - 1;


        $span = $this->tracer->startSpan(__METHOD__);
        $span->log(['calc_log' => $result]);
        $span->finish();
        return $result;
    }
}
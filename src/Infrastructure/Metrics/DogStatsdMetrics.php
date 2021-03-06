<?php

namespace MeetMatt\Colla\Mood\Infrastructure\Metrics;

use DataDog\BatchedDogStatsd;
use MeetMatt\Colla\Mood\Domain\Metrics\MetricsInterface;

class DogStatsdMetrics implements MetricsInterface
{
    /** @var BatchedDogStatsd */
    private $dogStatsd;

    public function __construct(string $host, int $port = 8125, array $tags = [])
    {
        $this->dogStatsd = new RemoteUdpBatchedDogStatsd([
            'host' => $host,
            'port' => $port,
            'global_tags' => $tags,
        ]);
    }

    public function flush(): void
    {
        $this->dogStatsd->flush_buffer();
    }

    public function increment(string $metric, array $tags = null, int $value = 1): void
    {
        $this->dogStatsd->increment($metric, 1.0, $tags, $value);
    }

    public function decrement(string $metric, array $tags = null, int $value = -1): void
    {
        $this->dogStatsd->decrement($metric, 1.0, $tags, $value);
    }

    public function timing(string $metric, $timeMilliseconds, array $tags = null): void
    {
        $this->dogStatsd->timing($metric, $timeMilliseconds, 1.0, $tags);
    }

    public function microtiming(string $metric, $timeSeconds, array $tags = null): void
    {
        $this->dogStatsd->microtiming($metric, $timeSeconds * 1000, 1.0, $tags);
    }

    public function gauge(string $metric, $value, array $tags = null): void
    {
        $this->dogStatsd->gauge($metric, $value, 1.0, $tags);
    }

    public function histogram(string $metric, $value, array $tags = null): void
    {
        $this->dogStatsd->histogram($metric, $value, 1.0, $tags);
    }

    public function distribution(string $metric, $value, array $tags = null): void
    {
        $this->dogStatsd->distribution($metric, $value, 1.0, $tags);
    }

    public function set(string $metric, $value, array $tags = null): void
    {
        $this->dogStatsd->set($metric, $value, 1.0, $tags);
    }
}
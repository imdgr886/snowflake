<?php

namespace Imdgr886\Snowflake;

use Exception;
use Imdgr886\Snowflake\Resolvers\RedisResolver;

class Snowflake
{
    protected $datacenterLength = 2;

    protected $sequenceLength = 12;

    protected $startTimestamp;

    protected $dataCenter = 0;

    protected $resolverClass = RedisResolver::class;

    public function __construct($startTime, $dataCenter = 0, $datacenterLength = 2, $sequenceLength = 12)
    {
        $this->datacenterLength = $datacenterLength;
        $this->sequenceLength = $sequenceLength;

        $maxDataCenter = pow(2, $this->datacenterLength) - 1;
        if ($dataCenter >= $maxDataCenter) {
            throw new Exception('data center cannot gatter than ' . $maxDataCenter);
        }

        $this->dataCenter = $dataCenter;

        $this->startTimestamp = (int) floor(strtotime($startTime) * 1000);
        if ($this->timestamp() < $this->startTimestamp) {
            throw new Exception('The start time cannot be greater than the current time');
        }
    }

    public function id()
    {
        return $this->next();
    }

    public function next()
    {
        $currentTime = $this->timestamp();
        while (($sequence = $this->callResolver($currentTime)) > (-1 ^ (-1 << $this->sequenceLength))) {
            usleep(1);
            $currentTime = $this->timestamp();
        }

        $timeDiff = ($currentTime - $this->startTimestamp);
        if ($timeDiff > pow(2, 63 - $this->datacenterLength - $this->sequenceLength) - 1) {
            throw new Exception('The current microtime - starttime is overload.');
        }

        return (string) (($currentTime - $this->startTimestamp) << ($this->datacenterLength + $this->sequenceLength)) |
            $this->dataCenter << $this->sequenceLength |
            $sequence;
    }

    /**
     * Return the now unixtime.
     *
     * @return integer
     */
    protected function timestamp()
    {
        return (int) floor(microtime(true) * 1000);
    }

    public function setResolver(string $resolverClass)
    {
        $this->resolverClass = $resolverClass;
    }

    protected function callResolver(int $currentTime)
    {
        $resolver = app()->make($this->resolverClass);
        return $resolver->sequence($currentTime);
    }
}

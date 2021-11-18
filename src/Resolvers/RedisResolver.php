<?php

namespace Imdgr886\Snowflake\Resolvers;

use Dotenv\Loader\Resolver;
use Imdgr886\Snowflake\SequenceResolver;
use Illuminate\Support\Facades\Redis;

class RedisResolver implements SequenceResolver
{

    protected $prefix = 'snowflake.';

    public function __construct()
    {
        // if (!Redis::ping()) {
        //     throw new RedisException('Redis server went away');
        // }
    }

    public function sequence(int $currentTime)
    {
        $lua = "return redis.call('exists',KEYS[1])<1 and redis.call('psetex',KEYS[1],ARGV[1],ARGV[2])";

        $key = $this->prefix . $currentTime;

        if (Redis::eval($lua, 1, $key, 1000, 1)) {
            return 0;
        }

        return Redis::incrby($key, 1);
    }
}

<?php

namespace Imdgr886\Snowflake;

interface SequenceResolver
{
    /**
     * The snowflake.
     *
     * @param int|string $currentTime current request ms
     *
     * @return int
     */
    public function sequence(int $currentTime);
}

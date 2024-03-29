<?php

namespace ElleTheDev\Glove\Contracts\Logging;

use Throwable;

interface Logger
{
    /**
     * @param Throwable $e
     * @return void
     */
    public function log(Throwable $e);
}

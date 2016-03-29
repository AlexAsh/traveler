<?php

namespace Unit\Assets\Traited;

use Traveler\Guessers\CanCamelizeTrait;

/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class CamelizerWithDelimiter
{
    use CanCamelizeTrait;

    public $delimiter;
}

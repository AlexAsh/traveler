<?php

namespace Traveler\Guessers;

/**
 * Move from this-words-sequence to ThisWordsSequence, with '-' being value of class property 'delimiter'
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
trait CanCamelizeTrait
{
    /**
     * Move from this-words-sequence to ThisWordsSequence, with '-' being value of class property 'delimiter'
     *
     * @param string $segment
     *
     * @return string
     */
    public function camelize($segment)
    {
        $delimiter = property_exists($this, 'delimiter') ? $this->delimiter : '-';

        return implode('', array_map('ucfirst', explode($delimiter, $segment)));
    }
}

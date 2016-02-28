<?php

namespace Traveler\Validators;

use Psr\Http\Message\UriInterface;

/**
 * Realization should specify validation rules and validate against them
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
interface UriValidatorInterface
{
    /**
     * Realization should specify validation rules and validate against them
     *
     * @param \Psr\Http\Message\UriInterface $uri
     *
     * @throws \DomainException
     */
    public function validate(UriInterface $uri);
}

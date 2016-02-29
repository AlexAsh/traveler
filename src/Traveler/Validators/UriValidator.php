<?php

namespace Traveler\Validators;

use Psr\Http\Message\UriInterface;

/**
 * Validates uri for uri parser
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
class UriValidator implements UriValidatorInterface
{
    /**
     * Ensure that uri path segments are alphanumeric
     *
     * @param \Psr\Http\Message\UriInterface $uri
     *
     * @throws \DomainException
     */
    public function validate(UriInterface $uri)
    {
        if (strlen($path = trim($uri->getPath(), '/')) === 0) {
            return;
        }

        if (!ctype_alnum(str_replace('/', '', $path))) {
            throw new \DomainException("Uri path segments are not alphanumeric, see path: $path");
        }
    }
}

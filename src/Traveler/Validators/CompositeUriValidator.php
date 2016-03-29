<?php

namespace Traveler\Validators;

use Psr\Http\Message\UriInterface;

/**
 * Validates uri with composite path segments for uri parser
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
class CompositeUriValidator implements UriValidatorInterface
{
    /**
     * @var string
     */
    private $delimiter;

    /**
     * @param string $delimiter
     *
     * @codeCoverageIgnore
     */
    public function __construct($delimiter = '-')
    {
        $this->delimiter = $delimiter;
    }

    /**
     * Ensure that uri path segments are alphanumeric with delimiter stored in $this->delimiter
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

        $d          = '\\'.$this->delimiter;
        $pathRegexp = '/^\/?(\w+('.$d.'\w+)*(\/\w+('.$d.'\w+)*)*\/?)?$/su';

        if (!preg_match($pathRegexp, $path)) {
            throw new \DomainException(
                "Uri path segments are not alphanumeric with {$this->delimiter} delimiter, see path: $path"
            );
        }
    }
}

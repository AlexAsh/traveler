<?php

namespace Unit\Validators;

use Traveler\Validators\UriValidator;
use Zend\Diactoros\Uri;

/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class UriValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testValidate_WithAlphanumericUriPathSegments_NoExceptionThrown()
    {
        $validator = new UriValidator();
        $uri = new Uri('http://example.com/foo/bar/?a=baz&b=qux');

        try {
            $validator->validate($uri);
        } catch (\Exception $e) {
            $this->fail("Validator throws exception for valid uri: ".$e->getTraceAsString());
        }

        $this->addToAssertionCount(1);
    }

    public function testValidate_WithNonAlphanumericInUriPathSegments_ThrowsDomainException()
    {
        $validator = new UriValidator();
        $uri = new Uri('http://example.com/fo^o/b%ar/?a=baz&b=qux');

        $this->setExpectedException('\\DomainException');
        $validator->validate($uri);
    }
}

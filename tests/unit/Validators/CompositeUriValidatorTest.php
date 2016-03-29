<?php

namespace Unit\Validators;

use Traveler\Validators\CompositeUriValidator;
use Zend\Diactoros\Uri;

/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class CompositeUriValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testValidate_WithDashedUriPathSegments_NoExceptionThrown()
    {
        $validator = new CompositeUriValidator();
        $uri = new Uri('http://example.com/foo-bar/baz-qux/?a=earth&b=moon');

        try {
            $validator->validate($uri);
        } catch (\Exception $e) {
            $this->fail("Validator throws exception for valid uri: ".$e->getTraceAsString());
        }

        $this->addToAssertionCount(1);
    }

    public function testValidate_WithEmptyUriPath_NoExceptionThrown()
    {
        $validator = new CompositeUriValidator();
        $uri = new Uri('http://example.com?a=baz&b=qux');

        try {
            $validator->validate($uri);
        } catch (\Exception $e) {
            $this->fail("Validator throws exception for valid uri: ".$e->getTraceAsString());
        }

        $this->addToAssertionCount(1);
    }

    public function testValidate_WithIncorrectDelimitedUriPathSegments_ThrowsDomainException()
    {
        $delimiter = '_';
        $validator = new CompositeUriValidator($delimiter);
        $uri = new Uri('http://example.com/foo-bar/baz-qux/?a=earth&b=moon');

        $this->setExpectedException('\\DomainException');
        $validator->validate($uri);
    }
}

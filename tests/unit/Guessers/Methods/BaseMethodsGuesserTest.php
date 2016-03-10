<?php

namespace Unit\Guessers\Methods;

use Unit\Assets\Abstracts\BaseMethodsGuesserImplementation;

/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class BaseMethodsGuesserTest extends \PHPUnit_Framework_TestCase
{
    public function testValidateHttpMethod_WithSupportedHttpMethod_NoExceptionThrown()
    {
        $guesser = $this->getImplementation();

        $guesser->validateHttpMethod('GET');

        $this->addToAssertionCount(1);
    }

    public function testValidateHttpMethod_WithUnsupportedHttpMethod_ThrowDomainException()
    {
        $guesser = $this->getImplementation('default', ['GET', 'POST']);

        $this->setExpectedException('\\DomainException');
        $guesser->validateHttpMethod('PUT');
    }

    protected function getImplementation($defaultSegment = 'default', array $httpMethods = [])
    {
        return new BaseMethodsGuesserImplementation($defaultSegment, $httpMethods);
    }
}

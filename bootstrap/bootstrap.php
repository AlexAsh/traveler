<?php

namespace Traveler\Bootstrap;

function bootstrap($controllerNamespace)
{
    $builder = new \DI\ContainerBuilder();

    $builder->useAnnotations(false);

    $builder->addDefinitions([
        'Traveler\\Validators\\UriValidatorInterface'                => \DI\object('Traveler\\Validators\\UriValidator'),
        'Traveler\\Parsers\\UriParserInterface'                      => \DI\object('Traveler\\Parsers\\UriParser'),

        'Traveler\\Invokers\\ControllerInvokerInterface'             => \DI\object('Traveler\\Invokers\\ControllerInvoker'),
        'Traveler\\Guessers\\Namespaces\\NamespacesGuesserInterface' => \DI\object('Traveler\\Guessers\\Namespaces\\NamespacesGuesser')
                                                                            ->constructorParameter('rootNamespace', $controllerNamespace),
        'Traveler\\Guessers\\ControllerGuesserInterface'             => \DI\object('Traveler\\Guessers\\ControllerGuesser'),

        'Traveler\\Router' => \DI\object('Traveler\\Router'),
    ]);

    $container = $builder->build();

    return $container;
}

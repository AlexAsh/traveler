<?php

namespace Traveler\Bootstrap;

/**
 * Create DI container by configuration
 *
 * @param array $configuration
 *
 * @return \DI\Container
 */
function bootstrap(array $configuration)
{
    $builder = new \DI\ContainerBuilder();

    $builder->useAnnotations(false);
    $builder->addDefinitions($configuration);

    $container = $builder->build();

    return $container;
}

/**
 * Get simple routing configuration
 *
 * @param string $controllerNamespace
 *
 * @return array
 */
function configure($controllerNamespace, $extraNamespaces = [])
{
    return [
        'Traveler\\Validators\\UriValidatorInterface'                => \DI\object('Traveler\\Validators\\UriValidator'),
        'Traveler\\Parsers\\UriParserInterface'                      => \DI\object('Traveler\\Parsers\\UriParser'),

        'Traveler\\Guessers\\Namespaces\\NamespacesGuesserInterface' => \DI\object('Traveler\\Guessers\\Namespaces\\NamespacesGuesser')
                                                                            ->constructorParameter('rootNamespace', $controllerNamespace),
        'Traveler\\Guessers\\Classes\\ClassesGuesserInterface'       => \DI\object('Traveler\\Guessers\\Classes\\ClassesGuesser'),
        'Traveler\\Guessers\\Methods\\MethodsGuesserInterface'       => \DI\object('Traveler\\Guessers\\Methods\\MethodsGuesser'),
        'Traveler\\Guessers\\ControllerGuesserInterface'             => \DI\object('Traveler\\Guessers\\ControllerGuesser')
                                                                            ->constructorParameter('extraNamespaces', $extraNamespaces),

        'Traveler\\Router' => \DI\object('Traveler\\Router'),
    ];
}

/**
 * Get composite routing configuration
 *
 * @param string $controllerNamespace
 * @param array  $extraNamespaces     Additional namespaces to look across for controller.
 *
 * @return array
 */
function configureComposite($controllerNamespace, $extraNamespaces = [])
{
    return [
        'Traveler\\Validators\\UriValidatorInterface'                => \DI\object('Traveler\\Validators\\CompositeUriValidator'),
        'Traveler\\Parsers\\UriParserInterface'                      => \DI\object('Traveler\\Parsers\\UriParser'),

        'Traveler\\Guessers\\Namespaces\\NamespacesGuesserInterface' => \DI\object('Traveler\\Guessers\\Namespaces\\CompositeNamespacesGuesser')
                                                                            ->constructorParameter('rootNamespace', $controllerNamespace),
        'Traveler\\Guessers\\Classes\\ClassesGuesserInterface'       => \DI\object('Traveler\\Guessers\\Classes\\CompositeClassesGuesser'),
        'Traveler\\Guessers\\Methods\\MethodsGuesserInterface'       => \DI\object('Traveler\\Guessers\\Methods\\CompositeMethodsGuesser'),
        'Traveler\\Guessers\\ControllerGuesserInterface'             => \DI\object('Traveler\\Guessers\\ControllerGuesser')
                                                                            ->constructorParameter('extraNamespaces', $extraNamespaces),

        'Traveler\\Router' => \DI\object('Traveler\\Router'),
    ];
}

/**
 * Get hierarchical routing configuration
 *
 * @param string $controllerNamespace
 * @param string $subpackageOffset    Relative namespace offset between package and subpackage.
 * @param string $controllerOffset    Relative namespace offset between package and controllers
 * @param array  $extraNamespaces     Additional namespaces to look across for controller.
 *
 * @return array
 */
function configureHierarchical($controllerNamespace, $subpackageOffset, $controllerOffset, $extraNamespaces = [])
{
    return [
        'Traveler\\Validators\\UriValidatorInterface'                => \DI\object('Traveler\\Validators\\CompositeUriValidator'),
        'Traveler\\Parsers\\UriParserInterface'                      => \DI\object('Traveler\\Parsers\\UriParser'),

        'Traveler\\Guessers\\Namespaces\\NamespacesGuesserInterface' => \DI\object('Traveler\\Guessers\\Namespaces\\HierarchicalNamespacesGuesser')
                                                                            ->constructorParameter('rootNamespace',    $controllerNamespace)
                                                                            ->constructorParameter('subpackageOffset', $subpackageOffset)
                                                                            ->constructorParameter('controllerOffset', $controllerOffset),
        'Traveler\\Guessers\\Classes\\ClassesGuesserInterface'       => \DI\object('Traveler\\Guessers\\Classes\\CompositeClassesGuesser'),
        'Traveler\\Guessers\\Methods\\MethodsGuesserInterface'       => \DI\object('Traveler\\Guessers\\Methods\\CompositeMethodsGuesser'),
        'Traveler\\Guessers\\ControllerGuesserInterface'             => \DI\object('Traveler\\Guessers\\ControllerGuesser')
                                                                            ->constructorParameter('extraNamespaces', $extraNamespaces),

        'Traveler\\Router' => \DI\object('Traveler\\Router'),
    ];
}

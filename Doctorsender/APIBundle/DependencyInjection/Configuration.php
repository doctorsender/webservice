<?php

namespace Doctorsender\APIBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('doctorsender_api');

        $rootNode
            ->children()
                ->scalarNode('url')->cannotBeEmpty()->defaultValue('http://soapwebservice.doctorsender.com/server.wsdl')->end()
                ->scalarNode('user')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('token')->isRequired()->cannotBeEmpty()->end()
            ->end();

        return $treeBuilder;
    }
}

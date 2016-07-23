<?php

namespace App\PortalBundle\DependencyInjection;

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
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('app_portal');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootNode
            ->children()
                ->variableNode('max_hashtag_limit')->end()
                ->variableNode('max_movies_per_page')->end()
                ->variableNode('max_actors_per_page')->end()
                ->arrayNode('payment_organisms')
                    ->children()
                        ->variableNode('default')
                            ->cannotBeEmpty()->end()
                        ->arrayNode('Be2bill')
                            ->children()
                                ->variableNode('identifier')
                                    ->cannotBeEmpty()
                                ->end()
                                ->variableNode('password')
                                    ->cannotBeEmpty()
                                ->end()
                                ->variableNode('url')
                                    ->cannotBeEmpty()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('Paypal')
                            ->children()
                                ->variableNode('identifier')
                                    ->cannotBeEmpty()
                                ->end()
                                ->variableNode('password')
                                ->end()
                                ->variableNode('url')
                                    ->cannotBeEmpty()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}

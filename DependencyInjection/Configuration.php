<?php

namespace Mremi\ContactBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('mremi_contact');

        $rootNode
            ->children()
                ->arrayNode('email')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('recipient_address')->defaultValue('webmaster@example.com')->cannotBeEmpty()->end()
                        ->scalarNode('template')->defaultValue('MremiContactBundle:Contact:email.txt.twig')->end()
                    ->end()
                ->end()
                ->scalarNode('contact_class')
                    ->defaultValue('Mremi\ContactBundle\Model\Contact')
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('form')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('type')->defaultValue('mremi_contact_form_type')->end()
                        ->scalarNode('name')->defaultValue('mremi_contact_contact_form')->end()
                        ->arrayNode('validation_groups')
                            ->prototype('scalar')->end()
                            ->defaultValue(array('Default'))
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}

<?php

/*
 * This file is part of the Mremi\ContactBundle Symfony bundle.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\ContactBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
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
        $rootNode = $treeBuilder->root('mremi_contact');

        $rootNode
            ->children()
                ->booleanNode('store_data')->defaultFalse()->end()
                ->scalarNode('contact_class')
                    ->defaultValue('Mremi\ContactBundle\Model\Contact')->cannotBeEmpty()
                ->end()
                ->arrayNode('form')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('type')->defaultValue('mremi_contact')->cannotBeEmpty()->end()
                        ->scalarNode('name')->defaultValue('contact_form')->cannotBeEmpty()->end()
                        ->arrayNode('validation_groups')
                            ->prototype('scalar')->end()
                            ->defaultValue(array('Default'))
                        ->end()
                        ->scalarNode('subject_provider')->defaultValue('mremi_contact.subject_provider.noop')->cannotBeEmpty()->end()
                        ->scalarNode('captcha_type')->defaultNull()->cannotBeEmpty()->end()
                    ->end()
                ->end()
                ->arrayNode('email')
                    ->isRequired()
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('mailer')->defaultValue('mremi_contact.mailer.twig_swift')->cannotBeEmpty()->end()
                        ->arrayNode('from')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('address')->cannotBeEmpty()->isRequired()->end()
                                    ->scalarNode('name')->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('to')->cannotBeEmpty()->isRequired()
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('address')->cannotBeEmpty()->isRequired()->end()
                                    ->scalarNode('name')->end()
                                ->end()
                            ->end()
                        ->end()
                        ->scalarNode('template')->defaultValue('MremiContactBundle:Contact:email.txt.twig')->cannotBeEmpty()->end()
                    ->end()
                ->end()
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return true === $v['store_data'] && 'Mremi\ContactBundle\Model\Contact' === $v['contact_class']; })
                ->thenInvalid('You must configure the "contact_class" node with your extended entity.')
            ->end();

        return $treeBuilder;
    }
}

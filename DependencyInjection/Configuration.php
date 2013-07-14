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
                    ->isRequired()
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('mailer')->defaultValue('mremi_contact.mailer.twig_swift')->cannotBeEmpty()->end()
                        ->scalarNode('recipient_address')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('template')->defaultValue('MremiContactBundle:Contact:email.txt.twig')->cannotBeEmpty()->end()
                    ->end()
                ->end()
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
                        ->booleanNode('captcha_disabled')->defaultFalse()->end()
                        ->scalarNode('captcha_type')
                            ->defaultValue('genemu_captcha')
                            ->cannotBeEmpty()
                            ->validate()
                                ->ifNotInArray(array('genemu_captcha', 'genemu_recaptcha'))
                                ->thenInvalid('Invalid captcha type %s')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}

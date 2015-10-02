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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MremiContactExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('controller.xml');
        $loader->load('form.xml');
        $loader->load('listeners.xml');

        $this->configureContactManager($container, $config, $loader);
        $this->configureForm($container, $config);
        $this->configureMailer($container, $config, $loader);
    }

    /**
     * Configures the contact manager service.
     *
     * @param ContainerBuilder $container A container builder instance
     * @param array            $config    An array of configuration
     * @param XmlFileLoader    $loader    An XML file loader instance
     */
    private function configureContactManager(ContainerBuilder $container, array $config, XmlFileLoader $loader)
    {
        if (true === $config['store_data']) {
            $loader->load('orm.xml');

            $suffix = 'doctrine';
        } else {
            $loader->load('model.xml');

            $suffix = 'default';
        }

        $container->setAlias('mremi_contact.contact_manager', sprintf('mremi_contact.contact_manager.%s', $suffix));

        $definition = $container->findDefinition('mremi_contact.contact_manager');
        $definition->replaceArgument(0, $config['contact_class']);
    }

    /**
     * Configures the form services.
     *
     * @param ContainerBuilder $container A container builder instance
     * @param array            $config    An array of configuration
     */
    private function configureForm(ContainerBuilder $container, array $config)
    {
        $definition = $container->getDefinition('mremi_contact.form_factory');
        $definition->replaceArgument(1, $config['form']['name']);
        $definition->replaceArgument(2, $config['form']['type']);
        $definition->replaceArgument(3, $config['form']['validation_groups']);

        if ('mremi_contact' !== $config['form']['type']) {
            $container->removeDefinition('mremi_contact.contact_form_type');

            return;
        }

        $definition = $container->getDefinition('mremi_contact.contact_form_type');
        $definition->replaceArgument(0, new Reference($config['form']['subject_provider']));
        $definition->replaceArgument(1, $config['contact_class']);
        $definition->replaceArgument(2, $config['form']['captcha_type']);
    }

    /**
     * Configures the mailer service.
     *
     * @param ContainerBuilder $container A container builder instance
     * @param array            $config    An array of configuration
     * @param XmlFileLoader    $loader    An XML file loader instance
     */
    private function configureMailer(ContainerBuilder $container, array $config, XmlFileLoader $loader)
    {
        $container->setAlias('mremi_contact.mailer', $config['email']['mailer']);

        if ('mremi_contact.mailer.twig_swift' !== $config['email']['mailer']) {
            return;
        }

        $loader->load('mailer.xml');

        $from = array();

        foreach ($config['email']['from'] as $data) {
            $from[$data['address']] = isset($data['name']) ? $data['name'] : null;
        }

        $to = array();

        foreach ($config['email']['to'] as $data) {
            $to[$data['address']] = isset($data['name']) ? $data['name'] : null;
        }

        $definition = $container->findDefinition('mremi_contact.mailer');
        $definition->replaceArgument(2, $config['email']['template']);
        $definition->replaceArgument(3, $to);
        $definition->replaceArgument(4, $from);
    }
}

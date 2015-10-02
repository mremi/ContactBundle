<?php

/*
 * This file is part of the Mremi\ContactBundle Symfony bundle.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\ContactBundle\Tests\DependencyInjection;

use Mremi\ContactBundle\DependencyInjection\MremiContactExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;

/**
 * Mremi contact extension test class.
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class MremiContactExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerBuilder
     */
    private $configuration;

    /**
     * Tests extension loading throws exception if store_data is not a boolean.
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage Invalid type for path "mremi_contact.store_data". Expected boolean, but got string.
     */
    public function testContactLoadThrowsExceptionIfStoreDataNotBoolean()
    {
        $loader = new MremiContactExtension();
        $config = $this->getEmptyConfig();
        $config['store_data'] = 'foo';
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * Tests extension loading throws exception if contact model class is empty.
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The path "mremi_contact.contact_class" cannot contain an empty value, but got "".
     */
    public function testContactLoadThrowsExceptionIfContactModelClassEmpty()
    {
        $loader = new MremiContactExtension();
        $config = $this->getEmptyConfig();
        $config['contact_class'] = '';
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * Tests extension loading throws exception if form type is empty.
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The path "mremi_contact.form.type" cannot contain an empty value, but got "".
     */
    public function testContactLoadThrowsExceptionIfFormTypeEmpty()
    {
        $loader = new MremiContactExtension();
        $config = $this->getEmptyConfig();
        $config['form']['type'] = '';
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * Tests extension loading throws exception if form name is empty.
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The path "mremi_contact.form.name" cannot contain an empty value, but got "".
     */
    public function testContactLoadThrowsExceptionIfFormNameEmpty()
    {
        $loader = new MremiContactExtension();
        $config = $this->getEmptyConfig();
        $config['form']['name'] = '';
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * Tests extension loading throws exception if subject provider is empty.
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The path "mremi_contact.form.subject_provider" cannot contain an empty value, but got "".
     */
    public function testContactLoadThrowsExceptionIfSubjectProviderEmpty()
    {
        $loader = new MremiContactExtension();
        $config = $this->getEmptyConfig();
        $config['form']['subject_provider'] = '';
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * Tests extension loading throws exception if captcha type is empty.
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The path "mremi_contact.form.captcha_type" cannot contain an empty value, but got "".
     */
    public function testContactLoadThrowsExceptionIfCaptchaTypeEmpty()
    {
        $loader = new MremiContactExtension();
        $config = $this->getEmptyConfig();
        $config['form']['captcha_type'] = '';
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * Tests extension loading throws exception if email is not set.
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The child node "email" at path "mremi_contact" must be configured.
     */
    public function testContactLoadThrowsExceptionUnlessEmailSet()
    {
        $loader = new MremiContactExtension();
        $config = $this->getEmptyConfig();
        unset($config['email']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * Tests extension loading throws exception if mailer is empty.
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The path "mremi_contact.email.mailer" cannot contain an empty value, but got "".
     */
    public function testContactLoadThrowsExceptionIfMailerEmpty()
    {
        $loader = new MremiContactExtension();
        $config = $this->getEmptyConfig();
        $config['email']['mailer'] = '';
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * Tests extension loading throws exception if from address is not set.
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The child node "address" at path "mremi_contact.email.from.0" must be configured.
     */
    public function testContactLoadThrowsExceptionUnlessFromAddressSet()
    {
        $loader = new MremiContactExtension();
        $config = $this->getFullConfig();
        unset($config['email']['from'][0]['address']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * Tests extension loading throws exception if from address is empty.
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The path "mremi_contact.email.from.0.address" cannot contain an empty value, but got "".
     */
    public function testContactLoadThrowsExceptionIfFromAddressEmpty()
    {
        $loader = new MremiContactExtension();
        $config = $this->getFullConfig();
        $config['email']['from'][0]['address'] = '';
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * Tests extension loading throws exception if to address is not set.
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The child node "to" at path "mremi_contact.email" must be configured.
     */
    public function testContactLoadThrowsExceptionIfToAddressNotDefined()
    {
        $loader = new MremiContactExtension();
        $config = $this->getEmptyConfig();
        unset($config['email']['to']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * Tests extension loading throws exception if to address is not set.
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The child node "address" at path "mremi_contact.email.to.0" must be configured.
     */
    public function testContactLoadThrowsExceptionUnlessToAddressSet()
    {
        $loader = new MremiContactExtension();
        $config = $this->getEmptyConfig();
        unset($config['email']['to'][0]['address']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * Tests extension loading throws exception if to address is empty.
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The path "mremi_contact.email.to.0.address" cannot contain an empty value, but got "".
     */
    public function testContactLoadThrowsExceptionIfToAddressEmpty()
    {
        $loader = new MremiContactExtension();
        $config = $this->getEmptyConfig();
        $config['email']['to'][0]['address'] = '';
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * Tests extension loading throws exception if template is empty.
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The path "mremi_contact.email.template" cannot contain an empty value, but got "".
     */
    public function testContactLoadThrowsExceptionIfTemplateEmpty()
    {
        $loader = new MremiContactExtension();
        $config = $this->getEmptyConfig();
        $config['email']['template'] = '';
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * Tests extension loading throws exception if store_data is TRUE and contact_class is not configured.
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage You must configure the "contact_class" node with your extended entity.
     */
    public function testContactLoadThrowsExceptionIfContactClassNotConfigured()
    {
        $loader = new MremiContactExtension();
        $config = $this->getEmptyConfig();
        $config['store_data'] = true;
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * Tests services existence.
     */
    public function testContactLoadServicesWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertHasDefinition('mremi_contact.contact_manager.default');
        $this->assertHasDefinition('mremi_contact.contact_manager');
        $this->assertHasDefinition('mremi_contact.form_factory');
        $this->assertHasDefinition('mremi_contact.contact_form_type');
        $this->assertHasDefinition('mremi_contact.subject_provider.noop');
        $this->assertHasDefinition('mremi_contact.listener.email_confirmation');
        $this->assertHasDefinition('mremi_contact.mailer.twig_swift');
        $this->assertHasDefinition('mremi_contact.mailer');
    }

    /**
     * Tests default mailer.
     */
    public function testContactLoadDefaultMailer()
    {
        $this->createEmptyConfiguration();

        $this->assertAlias('mremi_contact.mailer.twig_swift', 'mremi_contact.mailer');
        $this->assertAlias('mremi_contact.contact_manager.default', 'mremi_contact.contact_manager');
    }

    /**
     * Tests custom mailer.
     */
    public function testContactLoadCustomMailer()
    {
        $this->createFullConfiguration();

        $this->assertAlias('application_mremi_contact.mailer', 'mremi_contact.mailer');
        $this->assertAlias('mremi_contact.contact_manager.doctrine', 'mremi_contact.contact_manager');
    }

    /**
     * Cleanups the configuration.
     */
    protected function tearDown()
    {
        $this->configuration = null;
    }

    /**
     * Creates an empty configuration.
     */
    protected function createEmptyConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new MremiContactExtension();
        $config = $this->getEmptyConfig();
        $loader->load(array($config), $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }

    /**
     * Creates a full configuration.
     */
    protected function createFullConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new MremiContactExtension();
        $config = $this->getFullConfig();
        $loader->load(array($config), $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }

    /**
     * Gets an empty config.
     *
     * @return array
     */
    protected function getEmptyConfig()
    {
        $yaml = <<<EOF
email:
     to:
        - { address: webmaster@example.com, name: "Webmaster" }
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    /**
     * Gets a full config.
     *
     * @return array
     */
    protected function getFullConfig()
    {
        $yaml = <<<EOF
store_data:            true
contact_class:         Application\Mremi\ContactBundle\Entity\Contact

form:
    type:              application_contact
    name:              application_contact_form
    validation_groups: [Default, Foo]
    subject_provider:  mremi_contact.subject_provider.noop
    captcha_type:      genemu_recaptcha

email:
    mailer:            application_mremi_contact.mailer
    from:
        - { address: john.doe@example.com, name: "John Doe" }
        - { address: foo.bar@example.com, name: "" }
        - { address: test@example.com }
    to:
        - { address: webmaster@example.com, name: "Webmaster" }
        - { address: moderator@example.com, name: "" }
        - { address: other.moderator@example.com }
    template:          ApplicationMremiContactBundle:Contact:email.txt.twig
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    /**
     * Asserts the given key is an alias of value.
     *
     * @param string $value The aliased service identifier
     * @param string $key   The alias key
     */
    private function assertAlias($value, $key)
    {
        $this->assertSame($value, (string) $this->configuration->getAlias($key), sprintf('%s alias is correct', $key));
    }

    /**
     * Asserts the given identifier matched a definition.
     *
     * @param string $id
     */
    private function assertHasDefinition($id)
    {
        $this->assertTrue(($this->configuration->hasDefinition($id) ?: $this->configuration->hasAlias($id)));
    }
}

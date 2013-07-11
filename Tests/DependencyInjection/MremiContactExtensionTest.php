<?php

namespace Mremi\ContactBundle\Tests\DependencyInjection;

use Mremi\ContactBundle\DependencyInjection\MremiContactExtension;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;

/**
 * Mremi contact extension test class
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
     * Tests extension loading throws exception if email is not set
     *
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testContactLoadThrowsExceptionUnlessEmailSet()
    {
        $loader = new MremiContactExtension;
        $config = $this->getEmptyConfig();
        unset($config['email']);
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests extension loading throws exception if mailer is empty
     *
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testContactLoadThrowsExceptionIfMailerEmpty()
    {
        $loader = new MremiContactExtension;
        $config = $this->getEmptyConfig();
        $config['email']['mailer'] = '';
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests extension loading throws exception if recipient address is not set
     *
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testContactLoadThrowsExceptionUnlessRecipientAddressSet()
    {
        $loader = new MremiContactExtension;
        $config = $this->getEmptyConfig();
        unset($config['email']['recipient_address']);
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests extension loading throws exception if recipient address is empty
     *
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testContactLoadThrowsExceptionIfRecipientAddressEmpty()
    {
        $loader = new MremiContactExtension;
        $config = $this->getEmptyConfig();
        $config['email']['recipient_address'] = '';
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests extension loading throws exception if template is empty
     *
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testContactLoadThrowsExceptionIfTemplateEmpty()
    {
        $loader = new MremiContactExtension;
        $config = $this->getEmptyConfig();
        $config['email']['template'] = '';
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests extension loading throws exception if contact model class is empty
     *
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testContactLoadThrowsExceptionIfContactModelClassEmpty()
    {
        $loader = new MremiContactExtension;
        $config = $this->getEmptyConfig();
        $config['contact_class'] = '';
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests extension loading throws exception if form type is empty
     *
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testContactLoadThrowsExceptionIfFormTypeEmpty()
    {
        $loader = new MremiContactExtension;
        $config = $this->getEmptyConfig();
        $config['form']['type'] = '';
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests extension loading throws exception if form name is empty
     *
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testContactLoadThrowsExceptionIfFormNameEmpty()
    {
        $loader = new MremiContactExtension;
        $config = $this->getEmptyConfig();
        $config['form']['name'] = '';
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests services existence
     */
    public function testContactLoadServicesWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertHasDefinition('mremi_contact.contact_manager');
        $this->assertHasDefinition('mremi_contact.form_factory');
        $this->assertHasDefinition('mremi_contact.contact_form_type');
        $this->assertHasDefinition('mremi_contact.listener.email_confirmation');
        $this->assertHasDefinition('mremi_contact.mailer.twig_swift');
        $this->assertHasDefinition('mremi_contact.mailer');
    }

    /**
     * Tests default mailer
     */
    public function testContactLoadDefaultMailer()
    {
        $this->createEmptyConfiguration();

        $this->assertAlias('mremi_contact.mailer.twig_swift', 'mremi_contact.mailer');
    }

    /**
     * Tests custom mailer
     */
    public function testContactLoadCustomMailer()
    {
        $this->createFullConfiguration();

        $this->assertAlias('application_mremi_contact.mailer', 'mremi_contact.mailer');
    }

    /**
     * Cleanups the configuration
     */
    protected function tearDown()
    {
        unset($this->configuration);
    }

    /**
     * Creates an empty configuration
     */
    protected function createEmptyConfiguration()
    {
        $this->configuration = new ContainerBuilder;
        $loader = new MremiContactExtension;
        $config = $this->getEmptyConfig();
        $loader->load(array($config), $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }

    /**
     * Creates a full configuration
     */
    protected function createFullConfiguration()
    {
        $this->configuration = new ContainerBuilder;
        $loader = new MremiContactExtension;
        $config = $this->getFullConfig();
        $loader->load(array($config), $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }

    /**
     * Gets an empty config
     *
     * @return array
     */
    protected function getEmptyConfig()
    {
        $yaml = <<<EOF
email:
    recipient_address: webmaster@example.com
EOF;
        $parser = new Parser;

        return $parser->parse($yaml);
    }

    /**
     * Gets a full config
     *
     * @return array
     */
    protected function getFullConfig()
    {
        $yaml = <<<EOF
email:
    mailer:            application_mremi_contact.mailer
    recipient_address: foo@example.com
    template:          ApplicationMremiContactBundle:Contact:email.txt.twig

contact_class:         Application\Mremi\ContactBundle\Model\Contact

form:
    type:              application_mremi_contact_form_type
    name:              application_mremi_contact_contact_form
    validation_groups: [Default, Foo]
EOF;
        $parser = new Parser;

        return $parser->parse($yaml);
    }

    /**
     * Asserts the given key is an alias of value
     *
     * @param string $value The aliased service identifier
     * @param string $key   The alias key
     */
    private function assertAlias($value, $key)
    {
        $this->assertEquals($value, (string) $this->configuration->getAlias($key), sprintf('%s alias is correct', $key));
    }

    /**
     * Asserts the given identifier matched a definition
     *
     * @param string $id
     */
    private function assertHasDefinition($id)
    {
        $this->assertTrue(($this->configuration->hasDefinition($id) ?: $this->configuration->hasAlias($id)));
    }
}

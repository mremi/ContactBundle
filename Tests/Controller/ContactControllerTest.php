<?php

/*
 * This file is part of the Mremi\ContactBundle Symfony bundle.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\ContactBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Contact controller test class.
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class ContactControllerTest extends WebTestCase
{
    /**
     * Tests the index action.
     */
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/contact');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('contact_form_save')->form();

        $client->submit($form, array(
            'contact_form[title]'     => 'mr',
            'contact_form[firstName]' => 'Rémi',
            'contact_form[lastName]'  => 'Marseille',
            'contact_form[email]'     => 'marseille.remi@gmail.com',
            'contact_form[subject]'   => 'Subject',
            'contact_form[message]'   => '',  // do not set value to cause a validation error
            'contact_form[captcha]'   => '1234',
        ));

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $submittedValues = $form->getPhpValues();

        $this->assertArrayHasKey('contact_form', $submittedValues);

        $submittedValues = $submittedValues['contact_form'];

        $this->assertCount(9, $submittedValues);

        $this->assertArrayHasKey('title', $submittedValues);
        $this->assertSame('mr', $submittedValues['title']);

        $this->assertArrayHasKey('firstName', $submittedValues);
        $this->assertSame('Rémi', $submittedValues['firstName']);

        $this->assertArrayHasKey('lastName', $submittedValues);
        $this->assertSame('Marseille', $submittedValues['lastName']);

        $this->assertArrayHasKey('email', $submittedValues);
        $this->assertSame('marseille.remi@gmail.com', $submittedValues['email']);

        $this->assertArrayHasKey('subject', $submittedValues);
        $this->assertSame('Subject', $submittedValues['subject']);

        $this->assertArrayHasKey('message', $submittedValues);
        $this->assertSame('', $submittedValues['message']);

        $this->assertArrayHasKey('captcha', $submittedValues);
        $this->assertSame(1234, $submittedValues['captcha']);

        $this->assertArrayHasKey('_token', $submittedValues);

        $this->assertArrayHasKey('save', $submittedValues);
    }

    /**
     * Tests the confirm action.
     */
    public function testConfirm()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/contact/confirmation');

        $this->assertSame(500, $client->getResponse()->getStatusCode());
    }

    /**
     * Sets up tests.
     */
    protected function setUp()
    {
        if (!isset($_SERVER['KERNEL_DIR'])) {
            $this->markTestSkipped('KERNEL_DIR is not set in phpunit.xml, considers not in a Symfony project (no app directory, src, etc.).');
        }
    }
}

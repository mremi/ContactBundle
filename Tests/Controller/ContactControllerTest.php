<?php

namespace Mremi\ContactBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Contact controller test class
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class ContactControllerTest extends WebTestCase
{
    /**
     * Tests the index action
     */
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/contact');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('contact_form_submit_button')->form();

        $client->submit($form, array(
            'mremi_contact_form_type[title]'     => 'mr',
            'mremi_contact_form_type[firstName]' => 'Rémi',
            'mremi_contact_form_type[lastName]'  => 'Marseille',
            'mremi_contact_form_type[email]'     => 'marseille.remi@gmail.com',
            'mremi_contact_form_type[subject]'   => 'Subject',
            'mremi_contact_form_type[message]'   => '',  // do not set value to cause a validation error
            'mremi_contact_form_type[captcha]'   => '1234',
        ));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $submittedValues = $form->getPhpValues();

        $this->assertArrayHasKey('mremi_contact_form_type', $submittedValues);

        $submittedValues = $submittedValues['mremi_contact_form_type'];

        $this->assertCount(8, $submittedValues);

        $this->assertArrayHasKey('title', $submittedValues);
        $this->assertEquals('mr', $submittedValues['title']);

        $this->assertArrayHasKey('firstName', $submittedValues);
        $this->assertEquals('Rémi', $submittedValues['firstName']);

        $this->assertArrayHasKey('lastName', $submittedValues);
        $this->assertEquals('Marseille', $submittedValues['lastName']);

        $this->assertArrayHasKey('email', $submittedValues);
        $this->assertEquals('marseille.remi@gmail.com', $submittedValues['email']);

        $this->assertArrayHasKey('subject', $submittedValues);
        $this->assertEquals('Subject', $submittedValues['subject']);

        $this->assertArrayHasKey('message', $submittedValues);
        $this->assertEquals('', $submittedValues['message']);

        $this->assertArrayHasKey('captcha', $submittedValues);
        $this->assertEquals(1234, $submittedValues['captcha']);

        $this->assertArrayHasKey('_token', $submittedValues);
    }
}

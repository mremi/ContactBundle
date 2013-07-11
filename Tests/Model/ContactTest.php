<?php

namespace Mremi\ContactBundle\Tests\Model;

use Mremi\ContactBundle\Model\Contact;

/**
 * Tests Contact class
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class ContactTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the createdAt property
     */
    public function testCreatedAt()
    {
        $contact = new Contact;

        $this->assertInstanceOf('\DateTime', $contact->getCreatedAt());
    }

    /**
     * Tests the getFullName method
     */
    public function testFullName()
    {
        $contact = new Contact;
        $contact->setFirstName('Rémi');
        $contact->setLastName('Marseille');

        $this->assertEquals('Rémi Marseille', $contact->getFullName());
    }

    /**
     * Tests the setTitle method
     *
     * @expectedException \InvalidArgumentException
     */
    public function testSetTitle()
    {
        $contact = new Contact;
        $contact->setTitle('foo');
    }

    /**
     * Tests the getTitleValue method
     */
    public function testGetTitleValue()
    {
        $contact = new Contact;
        $contact->setTitle(Contact::TITLE_MR);

        $this->assertEquals('mremi_contact.form.title_mr', $contact->getTitleValue());

        $contact->setTitle(Contact::TITLE_MRS);

        $this->assertEquals('mremi_contact.form.title_mrs', $contact->getTitleValue());
    }

    /**
     * Tests the toArray method
     */
    public function testToArray()
    {
        $contact = new Contact;
        $contact->setTitle(Contact::TITLE_MR);
        $contact->setFirstName('Rémi');
        $contact->setLastName('Marseille');
        $contact->setEmail('marseille.remi@gmail.com');
        $contact->setSubject('subject');
        $contact->setMessage('message');
        $contact->setCreatedAt(new \DateTime('2013-07-11 10:07:00'));

        $expected = array(
            'title'     => 'mr',
            'firstName' => 'Rémi',
            'lastName'  => 'Marseille',
            'email'     => 'marseille.remi@gmail.com',
            'subject'   => 'subject',
            'message'   => 'message',
            'createdAt' => '2013-07-11T10:07:00+02:00',
        );

        $this->assertEquals($expected, $contact->toArray());
    }

    /**
     * Tests the fromArray method
     */
    public function testFromArray()
    {
        $contact = new Contact;
        $contact->fromArray(array(
            'title'     => 'mr',
            'firstName' => 'Rémi',
            'lastName'  => 'Marseille',
            'email'     => 'marseille.remi@gmail.com',
            'subject'   => 'subject',
            'message'   => 'message',
            'createdAt' => '2013-07-11T10:07:00+02:00',
        ));

        $this->assertEquals('mr', $contact->getTitle());
        $this->assertEquals('Rémi', $contact->getFirstName());
        $this->assertEquals('Marseille', $contact->getLastName());
        $this->assertEquals('marseille.remi@gmail.com', $contact->getEmail());
        $this->assertEquals('subject', $contact->getSubject());
        $this->assertEquals('message', $contact->getMessage());
        $this->assertEquals('2013-07-11T10:07:00+02:00', $contact->getCreatedAt()->format('c'));
    }
}

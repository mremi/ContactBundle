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
}

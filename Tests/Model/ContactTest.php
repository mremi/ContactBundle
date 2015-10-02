<?php

/*
 * This file is part of the Mremi\ContactBundle Symfony bundle.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\ContactBundle\Tests\Model;

use Mremi\ContactBundle\Model\Contact;

/**
 * Tests Contact class.
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class ContactTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the createdAt property.
     */
    public function testCreatedAt()
    {
        $contact = new Contact();

        $this->assertInstanceOf('\DateTime', $contact->getCreatedAt());
    }

    /**
     * Tests the getFullName method.
     */
    public function testFullName()
    {
        $contact = new Contact();
        $contact->setFirstName('Rémi');
        $contact->setLastName('Marseille');

        $this->assertSame('Rémi Marseille', $contact->getFullName());
    }

    /**
     * Tests the setTitle method throws an exception with an invalid title.
     *
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage Invalid title foo, possible values are: mr, mrs
     */
    public function testSetTitleThrowsExceptionIfInvalid()
    {
        $contact = new Contact();
        $contact->setTitle('foo');
    }

    /**
     * Tests the getTitleValue method.
     */
    public function testGetTitleValue()
    {
        $contact = new Contact();
        $contact->setTitle(Contact::TITLE_MR);

        $this->assertSame('mremi_contact.form.title_mr', $contact->getTitleValue());

        $contact->setTitle(Contact::TITLE_MRS);

        $this->assertSame('mremi_contact.form.title_mrs', $contact->getTitleValue());
    }

    /**
     * Tests the getTitles method.
     */
    public function testGetTitles()
    {
        $titles = Contact::getTitles();

        $this->assertTrue(is_array($titles));
        $this->assertCount(2, $titles);
    }

    /**
     * Tests the getTitleKeys method.
     */
    public function testGetTitleKeys()
    {
        $keys = Contact::getTitleKeys();

        $this->assertTrue(is_array($keys));
        $this->assertCount(2, $keys);
        $this->assertSame(Contact::TITLE_MR, $keys[0]);
        $this->assertSame(Contact::TITLE_MRS, $keys[1]);
    }

    /**
     * Tests the toArray method.
     */
    public function testToArray()
    {
        $contact = new Contact();
        $contact->setTitle(Contact::TITLE_MR);
        $contact->setFirstName('Rémi');
        $contact->setLastName('Marseille');
        $contact->setEmail('marseille.remi@gmail.com');
        $contact->setSubject('subject');
        $contact->setMessage('message');
        $contact->setCreatedAt(new \DateTime('2013-07-11T10:07:00+02:00'));

        $expected = array(
            'title'     => 'mr',
            'firstName' => 'Rémi',
            'lastName'  => 'Marseille',
            'email'     => 'marseille.remi@gmail.com',
            'subject'   => 'subject',
            'message'   => 'message',
            'createdAt' => '2013-07-11T10:07:00+02:00',
        );

        $this->assertSame($expected, $contact->toArray());
    }

    /**
     * Tests the fromArray method.
     */
    public function testFromArray()
    {
        $contact = new Contact();
        $contact->fromArray(array(
            'title'     => 'mr',
            'firstName' => 'Rémi',
            'lastName'  => 'Marseille',
            'email'     => 'marseille.remi@gmail.com',
            'subject'   => 'subject',
            'message'   => 'message',
            'createdAt' => '2013-07-11T10:07:00+02:00',
        ));

        $this->assertSame('mr', $contact->getTitle());
        $this->assertSame('Rémi', $contact->getFirstName());
        $this->assertSame('Marseille', $contact->getLastName());
        $this->assertSame('marseille.remi@gmail.com', $contact->getEmail());
        $this->assertSame('subject', $contact->getSubject());
        $this->assertSame('message', $contact->getMessage());
        $this->assertSame('2013-07-11T10:07:00+02:00', $contact->getCreatedAt()->format('c'));

        $contact = new Contact();
        $contact->fromArray(array(
            'title' => null,
        ));

        $this->assertNull($contact->getTitle());
    }

    /**
     * Tests the serialize method.
     */
    public function testSerialize()
    {
        $contact = new Contact();
        $contact->setTitle(Contact::TITLE_MR);
        $contact->setFirstName('Rémi');
        $contact->setLastName('Marseille');
        $contact->setEmail('marseille.remi@gmail.com');
        $contact->setSubject('subject');
        $contact->setMessage('message');
        $contact->setCreatedAt(new \DateTime('2013-07-11T10:07:00+02:00'));

        $expected = 'a:7:{s:5:"title";s:2:"mr";s:9:"firstName";s:5:"Rémi";s:8:"lastName";s:9:"Marseille";s:5:"email";s:24:"marseille.remi@gmail.com";s:7:"subject";s:7:"subject";s:7:"message";s:7:"message";s:9:"createdAt";s:25:"2013-07-11T10:07:00+02:00";}';

        $this->assertSame($expected, $contact->serialize());
    }

    /**
     * Tests the unserialize method.
     */
    public function testUnserialize()
    {
        $contact = new Contact();
        $contact->unserialize('a:7:{s:5:"title";s:2:"mr";s:9:"firstName";s:5:"Rémi";s:8:"lastName";s:9:"Marseille";s:5:"email";s:24:"marseille.remi@gmail.com";s:7:"subject";s:7:"subject";s:7:"message";s:7:"message";s:9:"createdAt";s:25:"2013-07-11T10:07:00+02:00";}');

        $this->assertSame('mr', $contact->getTitle());
        $this->assertSame('Rémi', $contact->getFirstName());
        $this->assertSame('Marseille', $contact->getLastName());
        $this->assertSame('marseille.remi@gmail.com', $contact->getEmail());
        $this->assertSame('subject', $contact->getSubject());
        $this->assertSame('message', $contact->getMessage());
        $this->assertSame('2013-07-11T10:07:00+02:00', $contact->getCreatedAt()->format('c'));
    }
}

<?php

namespace Mremi\ContactBundle\Tests\Model;

use Mremi\ContactBundle\Model\ContactManager;

/**
 * Tests ContactManager class
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class ContactManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the create method
     */
    public function testCreate()
    {
        $contactManager = new ContactManager('Mremi\ContactBundle\Model\Contact');

        $this->assertInstanceOf('Mremi\ContactBundle\Model\Contact', $contactManager->create());
    }
}

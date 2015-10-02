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

use Mremi\ContactBundle\Model\ContactManager;

/**
 * Tests ContactManager class.
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class ContactManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the create method.
     */
    public function testCreate()
    {
        $contactManager = new ContactManager('Mremi\ContactBundle\Model\Contact');

        $this->assertInstanceOf('Mremi\ContactBundle\Model\Contact', $contactManager->create());
    }
}

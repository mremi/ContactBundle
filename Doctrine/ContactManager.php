<?php

namespace Mremi\ContactBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;

use Mremi\ContactBundle\Model\ContactInterface;
use Mremi\ContactBundle\Model\ContactManager as BaseContactManager;

/**
 * Contact manager class
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class ContactManager extends BaseContactManager
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * Constructor
     *
     * @param string        $class         The Contact class namespace
     * @param ObjectManager $objectManager An object manager instance
     */
    public function __construct($class, ObjectManager $objectManager)
    {
        parent::__construct($class);

        $this->objectManager = $objectManager;
    }

    /**
     * {@inheritDoc}
     */
    public function save(ContactInterface $contact, $flush = false)
    {
        $this->objectManager->persist($contact);

        if ($flush) {
            $this->objectManager->flush();
        }
    }
}

<?php

/*
 * This file is part of the Mremi\ContactBundle Symfony bundle.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\ContactBundle\Doctrine;

use Doctrine\Common\Persistence\ManagerRegistry;
use Mremi\ContactBundle\Model\ContactInterface;
use Mremi\ContactBundle\Model\ContactManager as BaseContactManager;

/**
 * Contact manager class.
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class ContactManager extends BaseContactManager
{
    /**
     * @var ManagerRegistry
     */
    protected $registry;

    /**
     * Constructor.
     *
     * @param string          $class    The Contact class namespace
     * @param ManagerRegistry $registry A manager registry instance
     */
    public function __construct($class, ManagerRegistry $registry)
    {
        parent::__construct($class);

        $this->registry = $registry;
    }

    /**
     * Gets the object manager.
     *
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    public function getObjectManager()
    {
        $manager = $this->registry->getManagerForClass($this->class);

        if (!$manager) {
            throw new \RuntimeException(sprintf('Unable to find the mapping information for the class %s.'
                ." Please check the 'auto_mapping' option (http://symfony.com/doc/current/reference/configuration/doctrine.html#configuration-overview)"
                ." or add the bundle to the 'mappings' section in the doctrine configuration.", $this->class));
        }

        return $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(ContactInterface $contact, $flush = false)
    {
        $this->getObjectManager()->persist($contact);

        if ($flush) {
            $this->getObjectManager()->flush();
        }
    }
}

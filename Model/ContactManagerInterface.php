<?php

namespace Mremi\ContactBundle\Model;

/**
 * Contact manager interface
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
interface ContactManagerInterface
{
    /**
     * Creates and returns a new contact instance
     *
     * @return ContactInterface
     */
    public function create();

    /**
     * Saves the given contact in configured storage system
     *
     * @param ContactInterface $contact A contact instance
     * @param boolean          $flush   TRUE whether you want synchronize with the database
     */
    public function save(ContactInterface $contact, $flush = false);
}

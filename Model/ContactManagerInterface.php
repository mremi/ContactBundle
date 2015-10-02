<?php

/*
 * This file is part of the Mremi\ContactBundle Symfony bundle.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\ContactBundle\Model;

/**
 * Contact manager interface.
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
interface ContactManagerInterface
{
    /**
     * Creates and returns a new contact instance.
     *
     * @return ContactInterface
     */
    public function create();

    /**
     * Saves the given contact in configured storage system.
     *
     * @param ContactInterface $contact A contact instance
     * @param bool             $flush   TRUE whether you want to synchronize with the database
     */
    public function save(ContactInterface $contact, $flush = false);
}

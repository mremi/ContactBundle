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
}

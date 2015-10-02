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
 * Contact manager class.
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class ContactManager implements ContactManagerInterface
{
    /**
     * @var string
     */
    protected $class;

    /**
     * Constructor.
     *
     * @param string $class The Contact class namespace
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        return new $this->class();
    }

    /**
     * {@inheritdoc}
     */
    public function save(ContactInterface $contact, $flush = false)
    {
        // nothing to do, just to be compliant with the created alias
    }
}

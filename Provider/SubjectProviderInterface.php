<?php

/*
 * This file is part of the Mremi\ContactBundle Symfony bundle.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\ContactBundle\Provider;

/**
 * Subject provider interface.
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
interface SubjectProviderInterface
{
    /**
     * Gets an array of possible subjects.
     *
     * For instance:
     *
     * return array(
     *     'key_subject_1' => 'Subject 1',
     *     // ...,
     *     'key_subject_n' => 'Subject n',
     * );
     *
     * @return array
     */
    public function getSubjects();
}

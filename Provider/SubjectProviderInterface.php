<?php

namespace Mremi\ContactBundle\Provider;

/**
 * Subject provider interface
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

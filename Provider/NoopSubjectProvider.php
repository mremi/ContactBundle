<?php

namespace Mremi\ContactBundle\Provider;

/**
 * Noop subject provider class
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class NoopSubjectProvider implements SubjectProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getSubjects()
    {
        return array();
    }
}

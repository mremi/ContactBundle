<?php

namespace Mremi\ContactBundle\Tests\Provider;

use Mremi\ContactBundle\Provider\NoopSubjectProvider;

/**
 * Tests NoopSubjectProvider class
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class NoopSubjectProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the getSubjects method
     */
    public function testGetSubjects()
    {
        $provider = new NoopSubjectProvider;
        $subjects = $provider->getSubjects();

        $this->assertTrue(is_array($subjects));
        $this->assertCount(0, $subjects);
    }
}

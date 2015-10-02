<?php

/*
 * This file is part of the Mremi\ContactBundle Symfony bundle.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\ContactBundle\Tests\Mailer;

use Mremi\ContactBundle\Model\Contact;

/**
 * Tests the TwigSwiftMailer.
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class TwigSwiftMailerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var \Twig_Template
     */
    private $template;

    /**
     * @var \Mremi\ContactBundle\Mailer\TwigSwiftMailer
     */
    private $serviceMailer;

    /**
     * Initializes the properties used by tests.
     */
    protected function setUp()
    {
        $this->mailer        = $this->getMockBuilder('Swift_Mailer')->disableOriginalConstructor()->setMethods(array('send'))->getMock();
        $this->twig          = $this->getMockBuilder('Twig_Environment')->disableOriginalConstructor()->getMock();
        $this->template      = $this->getMockBuilder('Twig_Template')->disableOriginalConstructor()->setMethods(array('renderBlock'))->getMockForAbstractClass();
        $this->serviceMailer = $this->getMockBuilder('Mremi\ContactBundle\Mailer\TwigSwiftMailer')
            ->setConstructorArgs(array(
                $this->mailer,
                $this->twig,
                'MremiContactBundle:Contact:email.txt.twig',
                array('webmaster@example.com' => 'Webmaster'),
            ))
            ->setMethods(array('createMessage'))
            ->getMock();
    }

    /**
     * Cleanups the properties used by tests.
     */
    protected function tearDown()
    {
        $this->mailer        = null;
        $this->twig          = null;
        $this->template      = null;
        $this->serviceMailer = null;
    }

    /**
     * Tests the sendMessage method.
     */
    public function testSendMessage()
    {
        $this->twig->expects($this->once())->method('loadTemplate')->with($this->equalTo('MremiContactBundle:Contact:email.txt.twig'))->will($this->returnValue($this->template));

        $contact = new Contact();
        $contact->setEmail('marseille.remi@gmail.com');
        $contact->setFirstName('Rémi');
        $contact->setLastName('Marseille');

        $this->template->expects($this->exactly(3))->method('renderBlock')->withConsecutive(
            array($this->equalTo('subject'), $this->equalTo(array('contact' => $contact))),
            array($this->equalTo('body_text'), $this->equalTo(array('contact' => $contact))),
            array($this->equalTo('body_html'), $this->equalTo(array('contact' => $contact)))
        )->willReturnOnConsecutiveCalls(
            'Subject',
            'Body text',
            'Body HTML'
        );

        $message = $this->getMockBuilder('\Swift_Message')->disableOriginalConstructor()->getMock();
        $message->expects($this->once())->method('setSubject')->with($this->equalTo('Subject'))->willReturnSelf();
        $message->expects($this->once())->method('setFrom')->with($this->equalTo(array('marseille.remi@gmail.com' => 'Rémi Marseille')))->willReturnSelf();
        $message->expects($this->once())->method('setTo')->with($this->equalTo(array('webmaster@example.com' => 'Webmaster')))->willReturnSelf();
        $message->expects($this->once())->method('setBody')->with($this->equalTo('Body HTML'), $this->equalTo('text/html'))->willReturnSelf();
        $message->expects($this->once())->method('addPart')->with($this->equalTo('Body text'), $this->equalTo('text/plain'))->willReturnSelf();

        $this->serviceMailer->expects($this->once())->method('createMessage')->will($this->returnValue($message));

        $this->mailer->expects($this->once())->method('send')->with($this->equalTo($message))->will($this->returnValue(1));

        $this->assertSame(1, $this->serviceMailer->sendMessage($contact));
    }

    /**
     * Tests the sendMessage method with no subject block.
     */
    public function testSendMessageWithNoSubjectBlock()
    {
        $this->twig->expects($this->once())->method('loadTemplate')->will($this->returnValue($this->template));

        $contact = new Contact();
        $contact->setSubject('Subject from object');

        $message = $this->getMockBuilder('\Swift_Message')->disableOriginalConstructor()->getMock();
        $message->expects($this->once())->method('setSubject')->with($this->equalTo('Subject from object'))->willReturnSelf();
        $message->expects($this->once())->method('setFrom')->willReturnSelf();
        $message->expects($this->once())->method('setTo')->willReturnSelf();

        $this->serviceMailer->expects($this->once())->method('createMessage')->will($this->returnValue($message));

        $this->mailer->expects($this->once())->method('send')->with($this->equalTo($message));

        $this->serviceMailer->sendMessage($contact);
    }

    /**
     * Tests the sendMessage method with default from.
     */
    public function testSendMessageWithDefaultFrom()
    {
        $this->serviceMailer = $this->getMockBuilder('Mremi\ContactBundle\Mailer\TwigSwiftMailer')
            ->setConstructorArgs(array(
                $this->mailer,
                $this->twig,
                'MremiContactBundle:Contact:email.txt.twig',
                array('webmaster@example.com' => 'Webmaster'),
                array('no-reply@unit.tests'   => 'Unit tests'),
            ))
            ->setMethods(array('createMessage'))
            ->getMock();

        $this->twig->expects($this->once())->method('loadTemplate')->will($this->returnValue($this->template));

        $contact = new Contact();

        $message = $this->getMockBuilder('\Swift_Message')->disableOriginalConstructor()->getMock();
        $message->expects($this->once())->method('setSubject')->willReturnSelf();
        $message->expects($this->once())->method('setFrom')->with($this->equalTo(array('no-reply@unit.tests' => 'Unit tests')))->willReturnSelf();
        $message->expects($this->once())->method('setTo')->willReturnSelf();

        $this->serviceMailer->expects($this->once())->method('createMessage')->will($this->returnValue($message));

        $this->mailer->expects($this->once())->method('send')->with($this->equalTo($message));

        $this->serviceMailer->sendMessage($contact);
    }

    /**
     * Tests the sendMessage method with no body_html block.
     */
    public function testSendMessageWithNoBodyHtmlBlock()
    {
        $this->twig->expects($this->once())->method('loadTemplate')->will($this->returnValue($this->template));

        $contact = new Contact();

        $this->template->expects($this->exactly(3))->method('renderBlock')->withConsecutive(
            array($this->equalTo('subject'), $this->equalTo(array('contact' => $contact))),
            array($this->equalTo('body_text'), $this->equalTo(array('contact' => $contact))),
            array($this->equalTo('body_html'), $this->equalTo(array('contact' => $contact)))
        )->willReturnOnConsecutiveCalls(
            '',
            'Body text',
            ''
        );

        $message = $this->getMockBuilder('\Swift_Message')->disableOriginalConstructor()->getMock();
        $message->expects($this->once())->method('setSubject')->willReturnSelf();
        $message->expects($this->once())->method('setFrom')->willReturnSelf();
        $message->expects($this->once())->method('setTo')->willReturnSelf();
        $message->expects($this->once())->method('setBody')->with($this->equalTo('Body text'));
        $message->expects($this->never())->method('addPart');

        $this->serviceMailer->expects($this->once())->method('createMessage')->will($this->returnValue($message));

        $this->mailer->expects($this->once())->method('send')->with($this->equalTo($message));

        $this->serviceMailer->sendMessage($contact);
    }
}

<?php

/*
 * This file is part of the Mremi\ContactBundle Symfony bundle.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\ContactBundle\Mailer;

use Mremi\ContactBundle\Model\ContactInterface;

/**
 * Twig Swift mailer class.
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class TwigSwiftMailer implements MailerInterface
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var string
     */
    protected $template;

    /**
     * @var array
     */
    protected $from;

    /**
     * @var array
     */
    protected $to;

    /**
     * Constructor.
     *
     * @param \Swift_Mailer     $mailer   A mailer instance
     * @param \Twig_Environment $twig     A Twig instance
     * @param string            $template The template used for email content
     * @param array             $to       The To address
     * @param array             $from     The From address
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig, $template, array $to, array $from = array())
    {
        $this->mailer   = $mailer;
        $this->twig     = $twig;
        $this->template = $template;
        $this->to       = $to;
        $this->from     = $from;
    }

    /**
     * {@inheritdoc}
     */
    public function sendMessage(ContactInterface $contact)
    {
        $context = array(
            'contact' => $contact,
        );

        $template = $this->twig->loadTemplate($this->template);
        $subject  = $template->renderBlock('subject', $context);
        $textBody = $template->renderBlock('body_text', $context);
        $htmlBody = $template->renderBlock('body_html', $context);

        $message = $this->createMessage()
            ->setSubject($subject ?: $contact->getSubject())
            ->setFrom($this->from ?: array($contact->getEmail() => $contact->getFullName()))
            ->setTo($this->to);

        if (!empty($htmlBody)) {
            $message->setBody($htmlBody, 'text/html')
                ->addPart($textBody, 'text/plain');
        } else {
            $message->setBody($textBody);
        }

        return $this->mailer->send($message);
    }

    /**
     * Creates a new message.
     *
     * @return \Swift_Message
     */
    protected function createMessage()
    {
        return \Swift_Message::newInstance();
    }
}

<?php

namespace Mremi\ContactBundle\Mailer;

use Mremi\ContactBundle\Model\ContactInterface;

/**
 * Mailer interface
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
interface MailerInterface
{
    /**
     * Sends an email
     *
     * @param ContactInterface $contact
     *
     * @return integer
     */
    public function sendMessage(ContactInterface $contact);
}

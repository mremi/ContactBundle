<?php

namespace Mremi\ContactBundle\Model;

/**
 * Contact interface
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
interface ContactInterface
{
    /**
     * Possible title values
     */
    const TITLE_MR  = 'mr.';
    const TITLE_MRS = 'mrs.';

    /**
     * Sets the created at
     *
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * Gets the created at
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Sets the email address
     *
     * @param string $email
     */
    public function setEmail($email);

    /**
     * Gets the email address
     *
     * @return string
     */
    public function getEmail();

    /**
     * Sets the first name
     *
     * @param string $firstName
     */
    public function setFirstName($firstName);

    /**
     * Gets the first name
     *
     * @return string
     */
    public function getFirstName();

    /**
     * Sets the last name
     *
     * @param string $lastName
     */
    public function setLastName($lastName);

    /**
     * Gets the last name
     *
     * @return string
     */
    public function getLastName();

    /**
     * Gets the first name concatenated to the last name
     *
     * @return string
     */
    public function getFullName();

    /**
     * Sets the message
     *
     * @param string $message
     */
    public function setMessage($message);

    /**
     * Gets the message
     *
     * @return string
     */
    public function getMessage();

    /**
     * Sets the subject
     *
     * @param string $subject
     */
    public function setSubject($subject);

    /**
     * Gets the subject
     *
     * @return string
     */
    public function getSubject();

    /**
     * Sets the title
     *
     * @param string $title
     *
     * @throws \InvalidArgumentException
     */
    public function setTitle($title);

    /**
     * Gets the title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Gets an array of possible titles
     *
     * @return array
     */
    public static function getTitles();
}

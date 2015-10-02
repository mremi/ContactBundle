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
 * Contact interface.
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
interface ContactInterface extends \Serializable
{
    /**
     * Possible title values.
     */
    const TITLE_MR  = 'mr';
    const TITLE_MRS = 'mrs';

    /**
     * Sets the captcha.
     *
     * @param mixed $captcha
     */
    public function setCaptcha($captcha);

    /**
     * Gets the captcha.
     *
     * @return mixed
     */
    public function getCaptcha();

    /**
     * Sets the created at.
     *
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * Gets the created at.
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Sets the email address.
     *
     * @param string $email
     */
    public function setEmail($email);

    /**
     * Gets the email address.
     *
     * @return string
     */
    public function getEmail();

    /**
     * Sets the first name.
     *
     * @param string $firstName
     */
    public function setFirstName($firstName);

    /**
     * Gets the first name.
     *
     * @return string
     */
    public function getFirstName();

    /**
     * Sets the last name.
     *
     * @param string $lastName
     */
    public function setLastName($lastName);

    /**
     * Gets the last name.
     *
     * @return string
     */
    public function getLastName();

    /**
     * Gets the first name concatenated to the last name.
     *
     * @return string
     */
    public function getFullName();

    /**
     * Sets the message.
     *
     * @param string $message
     */
    public function setMessage($message);

    /**
     * Gets the message.
     *
     * @return string
     */
    public function getMessage();

    /**
     * Sets the subject.
     *
     * @param string $subject
     */
    public function setSubject($subject);

    /**
     * Gets the subject.
     *
     * @return string
     */
    public function getSubject();

    /**
     * Sets the title.
     *
     * @param string $title
     *
     * @throws \InvalidArgumentException
     */
    public function setTitle($title);

    /**
     * Gets the title.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Gets the title value.
     *
     * @return string
     */
    public function getTitleValue();

    /**
     * Gets an array of possible titles.
     *
     * @return array
     */
    public static function getTitles();

    /**
     * Gets an array of possible title keys.
     *
     * @return array
     */
    public static function getTitleKeys();

    /**
     * Gets an array representation.
     *
     * @return array
     */
    public function toArray();

    /**
     * Loads the object by the given data.
     *
     * @param array $data
     */
    public function fromArray(array $data);
}

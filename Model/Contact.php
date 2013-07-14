<?php

namespace Mremi\ContactBundle\Model;

/**
 * Contact class
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class Contact implements ContactInterface
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setCreatedAt(new \DateTime);
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * {@inheritdoc}
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * {@inheritdoc}
     */
    public function getFullName()
    {
        return sprintf('%s %s', $this->firstName, $this->lastName);
    }

    /**
     * {@inheritdoc}
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * {@inheritdoc}
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $validTitles = array_keys(self::getTitles());

        if (!in_array($title, $validTitles)) {
            throw new \InvalidArgumentException(sprintf('Invalid title %s, possible values are: %s', $title, implode(', ', $validTitles)));
        }

        $this->title = $title;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitleValue()
    {
        return self::getTitles()[$this->title];
    }

    /**
     * {@inheritdoc}
     */
    public static function getTitles()
    {
        return array(
            self::TITLE_MR  => 'mremi_contact.form.title_mr',
            self::TITLE_MRS => 'mremi_contact.form.title_mrs',
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function getTitleKeys()
    {
        return array_keys(self::getTitles());
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return array(
            'title'     => $this->title,
            'firstName' => $this->firstName,
            'lastName'  => $this->lastName,
            'email'     => $this->email,
            'subject'   => $this->subject,
            'message'   => $this->message,
            'createdAt' => $this->createdAt->format('c'),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function fromArray(array $data)
    {
        foreach ($data as $property => $value) {
            $method = sprintf('set%s', ucfirst($property));

            $this->$method('createdAt' === $property ? new \DateTime($value) : $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize($this->toArray());
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($data)
    {
        $this->fromArray(unserialize($data));
    }
}

<?php

namespace Nitsan\NsGuestbook\Domain\Model;

/**
 * Nsguestbook
 */
class Nsguestbook extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * name
     *
     * @var string
     *
     */
    protected $name = '';

    /**
     * city
     *
     * @var string
     */
    protected $city = '';

    /**
     * email
     *
     * @var string
     *
     */
    protected $email = '';

    /**
     * website
     *
     * @var string
     */
    protected $website = '';

    /**
     * message
     *
     * @var string
     */
    protected $message = '';

    /**
     * terms
     *
     * @var bool
     */
    protected $terms = false;

    /**
     * tstamp
     *
     * @var int
     */
    protected $tstamp;

    /**
     * hidden
     * @var bool
     */
    protected $hidden;

    /**
     * @return int $tstamp
     */
    public function getTstamp(): int
    {
        return $this->tstamp;
    }

    /**
     * Sets the tstamp
     *
     * @param \DateTime $tstamp
     * @return void
     */
    public function setTstamp(\DateTime $tstamp): void
    {
        $this->tstamp = $tstamp;
    }

    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * Returns the city
     *
     * @return string $city
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * Sets the city
     *
     * @param string $city
     * @return void
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * Returns the email
     *
     * @return string $email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Sets the email
     *
     * @param string $email
     * @return void
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * Returns the website
     *
     * @return string $website
     */
    public function getWebsite(): string
    {
        return $this->website;
    }

    /**
     * Sets the website
     *
     * @param string $website
     * @return void
     */
    public function setWebsite($website): void
    {
        $this->website = $website;
    }

    /**
     * Returns the message
     *
     * @return string $message
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Sets the message
     *
     * @param string $message
     * @return void
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function getTerms(): bool
    {
        return $this->terms;
    }

    /**
     * @param bool $terms
     * @return void
     */
    public function setTerms($terms): void
    {
        $this->terms = $terms;
    }

    /**
     * @return int $hidden
     */
    public function getHidden(): int
    {
        return $this->hidden;
    }

    /**
     * Sets the name
     *
     * @param int $hidden
     * @return void
     */
    public function setHidden($hidden): void
    {
        $this->hidden = $hidden;
    }
}

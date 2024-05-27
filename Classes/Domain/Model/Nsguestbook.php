<?php

namespace Nitsan\NsGuestbook\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2023
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Nsguestbook
 */
class Nsguestbook extends AbstractEntity
{
    /**
     * name
     *
     * @var string
     *
     */
    protected string $name = '';

    /**
     * city
     *
     * @var string
     */
    protected string $city = '';

    /**
     * email
     *
     * @var string
     *
     */
    protected string $email = '';

    /**
     * website
     *
     * @var string
     */
    protected string $website = '';

    /**
     * message
     *
     * @var string
     */
    protected string $message = '';

    /**
     * terms
     *
     * @var bool
     */
    protected bool $terms = false;

    /**
     * tstamp
     *
     * @var int
     */
    protected int $tstamp = 0;

    /**
     * hidden
     * @var bool
     */
    protected bool $hidden;

    /**
     * @return int $tstamp
     */
    public function getTstamp()
    {
        return $this->tstamp;
    }

    /**
     * Sets the tstamp
     *
     * @param \DateTime $tstamp
     * @return void
     */
    public function setTstamp(\DateTime $tstamp)
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
    public function setName(string $name): void
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
    public function setCity(string $city): void
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
    public function setEmail(string $email): void
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
    public function setWebsite(string $website): void
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
    public function setMessage(string $message): void
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
    public function setTerms(bool $terms): void
    {
        $this->terms = $terms;
    }

    /**
     * @return bool $hidden
     */
    public function getHidden(): bool
    {
        return $this->hidden;
    }

    /**
     * Sets the name
     *
     * @param bool $hidden
     * @return void
     */
    public function setHidden(bool $hidden): void
    {
        $this->hidden = $hidden;
    }
}

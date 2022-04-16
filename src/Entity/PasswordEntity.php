<?php
/*
 * @author Martin Aulenbach, 2022
 * @package de.scriptman.aad-parser-php
 */

namespace App\Entity;

class PasswordEntity
{
    private string $username;
    private string $displayname;
    private string $password;
    private string $licence;

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return PasswordEntity
     */
    public function setUsername(string $username): PasswordEntity
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayname(): string
    {
        return $this->displayname;
    }

    /**
     * @param string $displayname
     * @return PasswordEntity
     */
    public function setDisplayname(string $displayname): PasswordEntity
    {
        $this->displayname = $displayname;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return PasswordEntity
     */
    public function setPassword(string $password): PasswordEntity
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getLicence(): string
    {
        return $this->licence;
    }

    /**
     * @param string $licence
     * @return PasswordEntity
     */
    public function setLicence(string $licence): PasswordEntity
    {
        $this->licence = $licence;

        return $this;
    }

}

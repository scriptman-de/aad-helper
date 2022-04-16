<?php
/*
 * @author Martin Aulenbach, 2022
 * @package de.scriptman.aad-parser-php
 */

namespace App\Entity;

class MergedUserEntity
{
    private string $username;
    private string $firstName;
    private string $surName;
    private string $displayName;
    private string $position;
    private string $department;
    private string $phoneWork;
    private string $phoneWork1;
    private string $mobile;
    private string $fax;
    private string $alternateMail;
    private string $address;
    private string $city;
    private string $state;
    private string $zipCode;

    private string $password = "NOT SET";
    private string $licence;

//    public function __construct(AzureActiveDirectoryUser $user)
//    {
//        $this->username = $user->getUsername();
//        $this->firstName = $user->getFirstName();
//        $this->surName = $user->getSurName();
//        $this->displayName = $user->getDisplayName();
//        $this->position = $user->getPosition();
//        $this->department = $user->getDepartment();
//        $this->phoneWork = $user->getPhoneWork();
//        $this->phoneWork1 = $user->getPhoneWork1();
//        $this->mobile = $user->getMobile();
//        $this->fax = $user->getFax();
//        $this->alternateMail = $user->getAlternateMail();
//        $this->address = $user->getAddress();
//        $this->city = $user->getCity();
//        $this->state = $user->getState();
//        $this->zipCode = $user->getZipCode();
//    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return MergedUserEntity
     */
    public function setUsername(string $username): MergedUserEntity
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return MergedUserEntity
     */
    public function setFirstName(string $firstName): MergedUserEntity
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurName(): string
    {
        return $this->surName;
    }

    /**
     * @param string $surName
     * @return MergedUserEntity
     */
    public function setSurName(string $surName): MergedUserEntity
    {
        $this->surName = $surName;
        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * @param string $displayName
     * @return MergedUserEntity
     */
    public function setDisplayName(string $displayName): MergedUserEntity
    {
        $this->displayName = $displayName;
        return $this;
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        return $this->position;
    }

    /**
     * @param string $position
     * @return MergedUserEntity
     */
    public function setPosition(string $position): MergedUserEntity
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return string
     */
    public function getDepartment(): string
    {
        return $this->department;
    }

    /**
     * @param string $department
     * @return MergedUserEntity
     */
    public function setDepartment(string $department): MergedUserEntity
    {
        $this->department = $department;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneWork(): string
    {
        return $this->phoneWork;
    }

    /**
     * @param string $phoneWork
     * @return MergedUserEntity
     */
    public function setPhoneWork(string $phoneWork): MergedUserEntity
    {
        $this->phoneWork = $phoneWork;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneWork1(): string
    {
        return $this->phoneWork1;
    }

    /**
     * @param string $phoneWork1
     * @return MergedUserEntity
     */
    public function setPhoneWork1(string $phoneWork1): MergedUserEntity
    {
        $this->phoneWork1 = $phoneWork1;
        return $this;
    }

    /**
     * @return string
     */
    public function getMobile(): string
    {
        return $this->mobile;
    }

    /**
     * @param string $mobile
     * @return MergedUserEntity
     */
    public function setMobile(string $mobile): MergedUserEntity
    {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * @return string
     */
    public function getFax(): string
    {
        return $this->fax;
    }

    /**
     * @param string $fax
     * @return MergedUserEntity
     */
    public function setFax(string $fax): MergedUserEntity
    {
        $this->fax = $fax;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlternateMail(): string
    {
        return $this->alternateMail;
    }

    /**
     * @param string $alternateMail
     * @return MergedUserEntity
     */
    public function setAlternateMail(string $alternateMail): MergedUserEntity
    {
        $this->alternateMail = $alternateMail;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return MergedUserEntity
     */
    public function setAddress(string $address): MergedUserEntity
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return MergedUserEntity
     */
    public function setCity(string $city): MergedUserEntity
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     * @return MergedUserEntity
     */
    public function setState(string $state): MergedUserEntity
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     * @return MergedUserEntity
     */
    public function setZipCode(string $zipCode): MergedUserEntity
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        if (!isset($this->password)) return "NOT SET";

        return $this->password;
    }

    /**
     * @param string $password
     * @return MergedUserEntity
     */
    public function setPassword(string $password): MergedUserEntity
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
     * @return MergedUserEntity
     */
    public function setLicence(string $licence): MergedUserEntity
    {
        $this->licence = $licence;
        return $this;
    }


    /**
     * @param PasswordEntity[] $entityArray
     */
    public function setPasswordByImportedEntityArray(array &$entityArray): void
    {
        foreach ($entityArray as $entity) {
            $pass = $entity->getPassword();
            if ($entity->getUsername() == $this->username) {
                $this->password = $pass;
            }
        }
    }

    /**
     * @param PasswordEntity[] $entityArray
     */
    public function setLicenseByImportedEntityArray(array &$entityArray): void
    {
        foreach ($entityArray as $entity) {
            $lic = $entity->getLicence();
            if ($entity->getUsername() == $this->username) {
                $this->licence = $lic;
            }
        }
    }

    public static function crateByCsvLine(string $scriptCsvLine, array $aadCsvArray): MergedUserEntity
    {
        $ent = new self;

        $aadHelperArray = str_getcsv($scriptCsvLine, ";");

        $ent->setUsername($aadHelperArray[0])
            ->setFirstName($aadHelperArray[1])
            ->setSurName($aadHelperArray[2])
            ->setDisplayName($aadHelperArray[3]);

        if ("" !== trim($aadHelperArray[5])) {
            $ent->setDepartment($aadHelperArray[5]);
        }

        foreach ($aadCsvArray as $aad) {
            if ($aad[1] === $aadHelperArray[0]) {
                $ent->setPassword($aad[2])
                    ->setLicence($aad[3]);

                break;
            }
        }


        return $ent;
    }
}

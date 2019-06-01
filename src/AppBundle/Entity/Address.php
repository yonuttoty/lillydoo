<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="address")
 */
class Address
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Please enter a first name.")
     * @Assert\Type("string", message="The value {{ value }} is not a valid {{ type }} .")
     * @Assert\Length(
     *      min = 3,
     *      max = 20,
     *      minMessage = "First name must be at least {{ limit }} letters long",
     *      maxMessage = "First name cannot exceed {{ limit }} letters long"
     * )
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Please enter a last name.")
     * @Assert\Type("string", message="The value {{ value }} is not a valid {{ type }} .")
     * @Assert\Length(
     *      min = 3,
     *      max = 25,
     *      minMessage = "Last name must be at least {{ limit }} letters long",
     *      maxMessage = "Last name cannot exceed {{ limit }} letters long"
     * )
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Please enter a street name.")
     * @Assert\Type("string", message="The value {{ value }} is not a valid {{ type }} .")
     * @Assert\Length(
     *      min = 3,
     *      max = 20,
     *      minMessage = "Street name must be at least {{ limit }} letters long",
     *      maxMessage = "Street name cannot exceed {{ limit }} letters long"
     * )
     */
    private $street;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Please enter a street name.")
     * @Assert\Range(
     *      min = 0,
     *      max = 180,
     *      minMessage = "Number must be greater than {{ limit }}",
     *      maxMessage = "Number must be smaller than {{ limit }}"
     * )
     * @Assert\Type("integer", message="The value {{ value }} is not a valid {{ type }} .")
     */
    private $streetNumber;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Please enter a zip code.")
     * @Assert\Type("integer", message="The value {{ value }} is not a valid {{ type }} .")
     */
    private $zip;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Please enter a country.")
     * @Assert\Type("string", message="The value {{ value }} is not a valid {{ type }} .")
     * @Assert\Length(
     *      min = 4,
     *      max = 100,
     *      minMessage = "Country name must be at least {{ limit }} letters long",
     *      maxMessage = "Country name cannot exceed {{ limit }} letters long"
     * )
     */
    private $country;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Please enter a phone number.")
     * @Assert\Length(
     *      min = 10,
     *      max = 18,
     *      minMessage = "Phone number must be at least {{ limit }} numbers long",
     *      maxMessage = "Phone number cannot exceed {{ limit }} numbers long"
     * )
     * @Assert\Type("integer", message="The value {{ value }} is not a valid {{ type }} .")
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Please, set an email.")
     * @Assert\Email(message="Email is not valid. Please enter a valid email.")
     * @Assert\Length(
     *      min = 6,
     *      max = 50,
     *      minMessage = "Email must be at least {{ limit }} characters long",
     *      maxMessage = "Email cannot exceed {{ limit }} characters long"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @TODO change this to easily add images :D
     */
    private $picture;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return int
     */
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    /**
     * @param int $streetNumber
     */
    public function setStreetNumber($streetNumber)
    {
        $this->streetNumber = $streetNumber;
    }

    /**
     * @return int
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param int $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return int
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param int $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param \DateTime $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }
}
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="classroom")
 *
 * The classroom entity class.
 */
class Classroom
{
    public function __construct()
    {
        $this->createDate = date('Y-m-d');
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Assert\Type("number")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(255)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", nullable=false, name="create_date")
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    protected $createDate;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Type("bool")
     */
    protected $active = false;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @param mixed $createDate
     */
    public function setCreateDate($createDate): void
    {
        $this->createDate = $createDate;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }
}
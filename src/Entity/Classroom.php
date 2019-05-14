<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="classroom")
 *
 * The classroom entity class.
 */
class Classroom
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    public $name;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    public $createDate;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    public $active = false;
}
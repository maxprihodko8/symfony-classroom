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
    public function __construct()
    {
        $this->createDate = date('Y-m-d');
    }

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
     * @ORM\Column(type="string", nullable=false, name="create_date")
     */
    public $createDate;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    public $active = false;
}
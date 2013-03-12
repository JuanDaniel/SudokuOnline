<?php

namespace Adonai\Bundle\SudokuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adonai\Bundle\SudokuBundle\Entity\Rol
 *
 * @ORM\Table(name="Rol")
 * @ORM\Entity
 */
class Rol
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $rol
     *
     * @ORM\Column(name="rol", type="string", nullable=false)
     */
    private $rol;

    /**
     * @var string $nombre
     *
     * @ORM\Column(name="nombre", type="string", nullable=true)
     */
    private $nombre;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rol
     *
     * @param string $rol
     */
    public function setRol($rol)
    {
        $this->rol = $rol;
    }

    /**
     * Get rol
     *
     * @return string 
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }
    
    /**
     * __toString
     *
     * @return string 
     */
    public function __toString() {
        return $this->nombre;
    }

}
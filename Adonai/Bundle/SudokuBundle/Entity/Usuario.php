<?php

namespace Adonai\Bundle\SudokuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface as UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Adonai\Bundle\SudokuBundle\Entity\Usuario
 *
 * @ORM\Table(name="Usuario")
 * @ORM\Entity
 * @UniqueEntity("usuario")
 */
class Usuario implements UserInterface, \Serializable {

  /**
   * @var integer $id
   *
   * @ORM\Column(name="id", type="integer", nullable=false)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="IDENTITY")
   */
  private $id;

  /**
   * @var string $usuario
   *
   * @ORM\Column(name="usuario", type="string", length=20, nullable=false, unique=true)
   * @Assert\NotBlank()
   */
  private $usuario;

  /**
   * @var string $nombre
   *
   * @ORM\Column(name="nombre", type="string", length=30, nullable=false)
   * @Assert\NotBlank()
   */
  private $nombre;

  /**
   * @var string $apellidos
   *
   * @ORM\Column(name="apellidos", type="string", length=30, nullable=false)
   * @Assert\NotBlank()
   */
  private $apellidos;

  /**
   * @var string $password
   *
   * @ORM\Column(name="password", type="text", nullable=false)
   * @Assert\NotBlank()
   */
  private $password;

  /**
   * @var Rol
   *
   * @ORM\ManyToOne(targetEntity="Rol")
   * @ORM\JoinColumns({
   *   @ORM\JoinColumn(name="rol", referencedColumnName="id")
   * })
   */
  private $rol;

  /**
   * @ORM\ManyToMany(targetEntity="Competencia", mappedBy="usuarios")
   */
  private $competencias;

  /**
   * @ORM\OneToMany(targetEntity="Envio", mappedBy="usuario", cascade={"remove"})
   */
  private $envios;

  /**
   * Set id
   *
   * @param integer $id
   */
  public function setId($id) {
    $this->id = $id;
  }

  /**
   * Get id
   *
   * @return integer 
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set usuario
   *
   * @param string $usuario
   */
  public function setUsuario($usuario) {
    $this->usuario = $usuario;
  }

  /**
   * Get usuario
   *
   * @return string 
   */
  public function getUsuario() {
    return $this->usuario;
  }

  /**
   * Set nombre
   *
   * @param string $nombre
   */
  public function setNombre($nombre) {
    $this->nombre = $nombre;
  }

  /**
   * Get nombre
   *
   * @return string 
   */
  public function getNombre() {
    return $this->nombre;
  }

  /**
   * Set apellidos
   *
   * @param string $apellidos
   */
  public function setApellidos($apellidos) {
    $this->apellidos = $apellidos;
  }

  /**
   * Get apellidos
   *
   * @return string 
   */
  public function getApellidos() {
    return $this->apellidos;
  }

  /**
   * Set password
   *
   * @param string $password
   */
  public function setPassword($password) {
    $this->password = $password;
  }

  /**
   * Get password
   *
   * @return string 
   */
  public function getPassword() {
    return $this->password;
  }

  /**
   * Set rol
   *
   * @param Adonai\Bundle\SudokuBundle\Entity\Rol $rol
   */
  public function setRol(\Adonai\Bundle\SudokuBundle\Entity\Rol $rol) {
    $this->rol = $rol;
  }

  /**
   * Get rol
   *
   * @return Adonai\Bundle\SudokuBundle\Entity\Rol 
   */
  public function getRol() {
    return $this->rol;
  }

  public function equals(UserInterface $user) {
    return $user->getId() == $this->id;
  }

  public function eraseCredentials() {
    
  }

  public function getRoles() {
    return array($this->rol->getRol());
  }

  public function getSalt() {
    
  }

  public function getUsername() {
    return $this->usuario;
  }

  public function serialize() {
    return serialize(array(
                $this->id,
                $this->usuario,
                $this->nombre,
                $this->apellidos,
                $this->password,
            ));
  }

  public function unserialize($serialized) {
    list(
            $this->id,
            $this->usuario,
            $this->nombre,
            $this->apellidos,
            $this->password,
            ) = unserialize($serialized);
  }

  public function __toString() {
    return $this->nombre . ' ' . $this->apellidos;
  }

  public function __construct() {
    $this->competencias = new \Doctrine\Common\Collections\ArrayCollection();
  }

  /**
   * Add competencias
   *
   * @param Adonai\Bundle\SudokuBundle\Entity\Competencia $competencias
   */
  public function addCompetencia(\Adonai\Bundle\SudokuBundle\Entity\Competencia $competencias) {
    $this->competencias[] = $competencias;
  }

  /**
   * Get competencias
   *
   * @return Doctrine\Common\Collections\Collection 
   */
  public function getCompetencias() {
    return $this->competencias;
  }

  /**
   * Add envios
   *
   * @param Adonai\Bundle\SudokuBundle\Entity\Envio $envios
   */
  public function addEnvio(\Adonai\Bundle\SudokuBundle\Entity\Envio $envios) {
    $this->envios[] = $envios;
  }

  /**
   * Get envios
   *
   * @return Doctrine\Common\Collections\Collection 
   */
  public function getEnvios() {
    return $this->envios;
  }

}
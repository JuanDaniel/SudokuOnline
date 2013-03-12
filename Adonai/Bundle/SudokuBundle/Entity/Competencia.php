<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Competencia
 *
 * @author jdsantana
 */

namespace Adonai\Bundle\SudokuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adonai\Bundle\SudokuBundle\Entity\Competencia
 *
 * @ORM\Table(name="Competencia")
 * @ORM\Entity(repositoryClass="Adonai\Bundle\SudokuBundle\Entity\Repository\CompetenciaRepository")
 */
class Competencia {

  /**
   * @var integer $id
   *
   * @ORM\Column(name="id", type="integer", nullable=false)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="IDENTITY")
   */
  private $id;

  /**
   * @var string $nombre
   *
   * @ORM\Column(name="nombre", type="string", nullable=false)
   */
  private $nombre;

  /**
   * @var datetime $fecha
   *
   * @ORM\Column(name="fecha", type="datetime", nullable=false)
   */
  private $fecha;
  
  /**
   * @var datetime $fecha_iniciada
   *
   * @ORM\Column(name="fecha_iniciada", type="datetime", nullable=true)
   */
  private $fecha_iniciada;

  /**
   * @var integer $estado
   *
   * @ORM\Column(name="estado", type="integer", nullable=false)
   */
  private $estado;

  /**
   * @ORM\ManyToMany(targetEntity="Usuario")
   * @ORM\JoinTable(name="Competencia_Usuario",
   *      joinColumns={@ORM\JoinColumn(name="competencia_id", referencedColumnName="id")},
   *      inverseJoinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id")}
   * )
   */
  protected $usuarios;

  /**
   * @ORM\OneToMany(targetEntity="Mapa", mappedBy="competencia", cascade={"persist", "remove"})
   */
  protected $mapas;

  /**
   * @ORM\OneToMany(targetEntity="Envio", mappedBy="competencia", cascade={"remove"})
   */
  protected $envios;

  /**
   * @var integer $tiempo
   *
   * @ORM\Column(name="tiempo", type="integer", nullable=false)
   */
  private $tiempo;

  public function __construct() {
    $this->usuarios = new \Doctrine\Common\Collections\ArrayCollection();
    $this->mapas = new \Doctrine\Common\Collections\ArrayCollection();
    $this->envios = new \Doctrine\Common\Collections\ArrayCollection();
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
   * Set fecha
   *
   * @param datetime $fecha
   */
  public function setFecha($fecha) {
    $this->fecha = $fecha;
  }

  /**
   * Get fecha
   *
   * @return datetime 
   */
  public function getFecha() {
    return $this->fecha;
  }
  
  /**
   * Set fecha_iniciada
   *
   * @param datetime $fecha_iniciada
   */
  public function setFechaIniciada($fecha_iniciada) {
    $this->fecha_iniciada = $fecha_iniciada;
  }

  /**
   * Get fecha_iniciada
   *
   * @return datetime 
   */
  public function getFechaIniciada() {
    return $this->fecha_iniciada;
  }

  /**
   * Set estado
   *
   * @param integer $estado
   */
  public function setEstado($estado) {
    $this->estado = $estado;
  }

  /**
   * Get estado
   *
   * @return integer 
   */
  public function getEstado() {
    return $this->estado;
  }

  /**
   * Set tiempo
   *
   * @param integer $tiempo
   */
  public function setTiempo($tiempo) {
    $this->tiempo = $tiempo;
  }

  /**
   * Get tiempo
   *
   * @return integer 
   */
  public function getTiempo() {
    return $this->tiempo;
  }

  /**
   * Add usuarios
   *
   * @param Adonai\Bundle\SudokuBundle\Entity\Usuario $usuarios
   */
  public function addUsuario(\Adonai\Bundle\SudokuBundle\Entity\Usuario $usuarios) {
    $this->usuarios[] = $usuarios;
  }

  /**
   * Get usuarios
   *
   * @return Doctrine\Common\Collections\Collection 
   */
  public function getUsuarios() {
    return $this->usuarios;
  }

  /**
   * Add mapas
   *
   * @param Adonai\Bundle\SudokuBundle\Entity\Mapa $mapas
   */
  public function addMapa(\Adonai\Bundle\SudokuBundle\Entity\Mapa $mapas) {
    $this->mapas[] = $mapas;
  }

  /**
   * Get mapas
   *
   * @return Doctrine\Common\Collections\Collection 
   */
  public function getMapas() {
    return $this->mapas;
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
  
  /**
   * Conocer si el tiempo de la competencia ha finalizado
   *
   * @return boolean
   */
  public function tiempoFinalizado() {
    if($this->fecha_iniciada){
      $date = clone $this->fecha_iniciada;
      $estimado = $date->add(new \DateInterval('PT'.$this->tiempo.'M'));
      $actual = new \DateTime('now');

      return ($estimado < $actual);
    }
    
    return false;
  }

}
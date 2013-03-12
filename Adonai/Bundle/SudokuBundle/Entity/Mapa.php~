<?php

namespace Adonai\Bundle\SudokuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adonai\Bundle\SudokuBundle\Entity\Mapa
 *
 * @ORM\Table(name="Mapa")
 * @ORM\Entity(repositoryClass="Adonai\Bundle\SudokuBundle\Entity\Repository\MapaRepository")
 */
class Mapa {

  /**
   * @var integer $id
   *
   * @ORM\Column(name="id", type="integer", nullable=false)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="IDENTITY")
   */
  private $id;

  /**
   * @var string $complejidad
   *
   * @ORM\Column(name="complejidad", type="string", nullable=false)
   */
  private $complejidad;

  /**
   * @ORM\ManyToOne(targetEntity="Competencia", inversedBy="mapas")
   * @ORM\JoinColumn(name="competencia_id", referencedColumnName="id")
   */
  private $competencia;

  /**
   * Get id
   *
   * @return integer 
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set complejidad
   *
   * @param string $complejidad
   */
  public function setComplejidad($complejidad) {
    $this->complejidad = $complejidad;
  }

  /**
   * Get complejidad
   *
   * @return string 
   */
  public function getComplejidad() {
    return $this->complejidad;
  }

  /**
   * Set competencia
   *
   * @param Adonai\Bundle\SudokuBundle\Entity\Competencia $competencia
   */
  public function setCompetencia(\Adonai\Bundle\SudokuBundle\Entity\Competencia $competencia) {
    $this->competencia = $competencia;
  }

  /**
   * Get competencia
   *
   * @return Adonai\Bundle\SudokuBundle\Entity\Competencia 
   */
  public function getCompetencia() {
    return $this->competencia;
  }

}
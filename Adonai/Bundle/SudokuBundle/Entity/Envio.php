<?php

namespace Adonai\Bundle\SudokuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adonai\Bundle\SudokuBundle\Entity\Envio
 *
 * @ORM\Table(name="Envio")
 * @ORM\Entity(repositoryClass="Adonai\Bundle\SudokuBundle\Entity\Repository\EnvioRepository")
 */
class Envio {

  /**
   * @var integer $id
   *
   * @ORM\Column(name="id", type="integer", nullable=false)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="IDENTITY")
   */
  private $id;

  /**
   * @ORM\ManyToOne(targetEntity="Competencia", inversedBy="envios")
   * @ORM\JoinColumn(name="competencia_id", referencedColumnName="id")
   */
  private $competencia;

  /**
   * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="envios")
   * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
   */
  private $usuario;

  /**
   * @var datetime $tiempo
   *
   * @ORM\Column(name="tiempo", type="datetime", nullable=false)
   */
  private $tiempo;

  /**
   * @var float $puntos
   *
   * @ORM\Column(name="puntos", type="float", nullable=false)
   */
  private $puntos;

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
     * Set tiempo
     *
     * @param datetime $tiempo
     */
    public function setTiempo($tiempo)
    {
        $this->tiempo = $tiempo;
    }

    /**
     * Get tiempo
     *
     * @return datetime 
     */
    public function getTiempo()
    {
        return $this->tiempo;
    }

    /**
     * Set puntos
     *
     * @param integer $puntos
     */
    public function setPuntos($puntos)
    {
        $this->puntos = $puntos;
    }

    /**
     * Get float
     *
     * @return integer 
     */
    public function getPuntos()
    {
        return $this->puntos;
    }

    /**
     * Set competencia
     *
     * @param Adonai\Bundle\SudokuBundle\Entity\Competencia $competencia
     */
    public function setCompetencia(\Adonai\Bundle\SudokuBundle\Entity\Competencia $competencia)
    {
        $this->competencia = $competencia;
    }

    /**
     * Get competencia
     *
     * @return Adonai\Bundle\SudokuBundle\Entity\Competencia 
     */
    public function getCompetencia()
    {
        return $this->competencia;
    }

    /**
     * Set usuario
     *
     * @param Adonai\Bundle\SudokuBundle\Entity\Usuario $usuario
     */
    public function setUsuario(\Adonai\Bundle\SudokuBundle\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * Get usuario
     *
     * @return Adonai\Bundle\SudokuBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
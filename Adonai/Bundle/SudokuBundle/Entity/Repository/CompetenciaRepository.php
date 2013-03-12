<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EnvioRepository
 *
 * @author jdsantana
 */

namespace Adonai\Bundle\SudokuBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Adonai\Bundle\SudokuBundle\Entity\Usuario;
use Adonai\Bundle\SudokuBundle\Entity\Competencia;

class CompetenciaRepository extends EntityRepository {

  public function rank($competencia) {
    $rank = array();

    foreach ($competencia->getEnvios() as $envio) {
      if (!array_key_exists($envio->getUsuario()->getUsername(), $rank))
        $rank[$envio->getUsuario()->getUsername()] = array(
            'usuario' => $envio->getUsuario(),
            'aceptados' => ($envio->getPuntos() == 1 ? 1 : 0),
            'puntos' => ($envio->getPuntos() < 1 ? $envio->getPuntos(): 0),
            'tiempo' => $envio->getTiempo()->diff($competencia->getFechaIniciada()),
            'cantidad' => 1
        );
      else {
        $rank[$envio->getUsuario()->getUsername()]['aceptados'] += ($envio->getPuntos() == 1 ? 1 : 0);
        $rank[$envio->getUsuario()->getUsername()]['puntos'] += ($envio->getPuntos() < 1 ? $envio->getPuntos(): 0);
        $rank[$envio->getUsuario()->getUsername()]['tiempo'] = $envio->getTiempo()->diff($competencia->getFechaIniciada());
        $rank[$envio->getUsuario()->getUsername()]['cantidad']++;
      }
    }
    
    foreach ($competencia->getUsuarios() as $usuario)
      if(array_key_exists($usuario->getUsername(), $rank))
        $rank[$usuario->getUsername()]['puntos'] = ($rank[$usuario->getUsername()]['aceptados'] + ($rank[$usuario->getUsername()]['puntos'] / ($rank[$usuario->getUsername()]['cantidad'] - $rank[$usuario->getUsername()]['puntos'])));      

    usort($rank, array($this, 'cmpPuntosAsc'));

    return $rank;
  }

  private function cmpPuntosAsc($c1, $c2) {    
    if ($c1['aceptados'] == $c2['aceptados'])
      //if($c1['puntos'] == $c2['puntos'])
        return ($c1['tiempo'] > $c2['tiempo']) ? 1 : -1;
      //return ($c1['puntos'] < $c2['puntos']) ? 1 : -1;
    
    return ($c1['aceptados'] < $c2['aceptados']) ? 1 : -1;
  }
  
  public function Competencias(){
    $em = $this->getEntityManager();
    
    $dql = 'SELECT c FROM SudokuBundle:Competencia c ORDER BY c.fecha DESC';
    
    $query = $em->createQuery($dql);
    
    return $query->getResult();
  }
  
  public function UsuarioInscrito(Competencia $competencia, Usuario $usuario){
    return $usuario->getCompetencias()->contains($competencia);
  }
  
  public function verificarEstado($competencias){
    foreach ($competencias as $competencia)
      if($competencia->tiempoFinalizado())
        $competencia->setEstado(2);
  }
}

?>

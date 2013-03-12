<?php

namespace Adonai\Bundle\SudokuBundle\Twig\Extension;

/**
 * Description of CompetenciaExtension
 *
 * @author jdsantana
 */

use Adonai\Bundle\SudokuBundle\Entity\Usuario;

class CompetenciaExtension extends \Twig_Extension {
  
  public function getName() {
    return 'competencia';
  }
  
   public function getFunctions() {
       return array(
           'inscrito' => new \Twig_Function_Method($this, 'inscrito'),
           'tiempo' => new \Twig_Function_Method($this, 'tiempo'),
           'info_competencia' => new \Twig_Function_Method($this, 'info')
           );
   }
   
   public function inscrito($competencia, Usuario $usuario){
       return $usuario->getCompetencias()->contains($competencia);
   }
   
   public function tiempo($minutos, $fecha_iniciada){     
     $fecha_iniciada->add(new \DateInterval('PT'.$minutos.'M'));
     
     return $fecha_iniciada;
   }
   
   public function info($mapas){
     $data = array('facil' => 0, 'medio' => 0, 'dificil' => 0);
     foreach ($mapas as $mapa)
       if($mapa->getComplejidad() == 'facil')
         $data['facil']++;
       else if($mapa->getComplejidad() == 'medio')
         $data['medio']++;
       else
         $data['dificil']++;
       
       return $data;
   }
  
}

?>

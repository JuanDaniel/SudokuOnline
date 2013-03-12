<?php

namespace Adonai\Bundle\SudokuBundle\Controller;

/**
 * Description of Ranking
 *
 * @author jdsantana
 */

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RankingController extends Controller {
  public function competenciaAction($id){
    $em = $this->getDoctrine()->getEntityManager();
    
    $competencia = $em->getRepository('SudokuBundle:Competencia')->find($id);
    
    if(!$competencia)
      throw $this->createNotFoundException('No existe la competencia');

      $ranking = $em->getRepository('SudokuBundle:Competencia')->rank($competencia);
    
    return $this->render('SudokuBundle:Sitio:competencia_ranking.html.twig', array(
        'ranking' => $ranking,
        'competencia' => $competencia
    ));
  }
  
  public function allAction(){
    return $this->render('SudokuBundle:Sitio:ranking.html.twig', array(
    ));
  }
}

?>

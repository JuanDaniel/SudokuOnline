<?php

/**
 * Description of Sitio
 *
 * @author jdsantana
 */

namespace Adonai\Bundle\SudokuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class SitioController extends Controller {
  
  public function mainAction(){    
    return $this->render('SudokuBundle:Sitio:index.html.twig');
  }
  
  public function loginAction() {
    $peticion = $this->getRequest();
    $session = $peticion->getSession();

    $error = $peticion->attributes->get(
            SecurityContext::AUTHENTICATION_ERROR, $session->get(SecurityContext::AUTHENTICATION_ERROR)
    );

    return $this->render('SudokuBundle:Sitio:login.html.twig', 
            array(
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error' => $error
            )
    );
  }
}

?>

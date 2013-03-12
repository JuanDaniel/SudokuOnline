<?php

namespace Adonai\Bundle\SudokuBundle\Controller;

/**
 * Description of Competencia
 *
 * @author jdsantana
 */
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Adonai\Bundle\SudokuBundle\Entity\Competencia;
use Adonai\Bundle\SudokuBundle\Entity\Envio;
use Adonai\Bundle\SudokuBundle\Util\Sudoku;
use Symfony\Component\HttpFoundation\Response;
use Adonai\Bundle\SudokuBundle\Form\CompetenciaType;
use Adonai\Bundle\SudokuBundle\Entity\Mapa;

class CompetenciaController extends Controller {

  public function listAction() {
    $em = $this->getDoctrine()->getEntityManager();

    $competencias = $em->getRepository('SudokuBundle:Competencia')->Competencias();

    $em->getRepository('SudokuBundle:Competencia')->verificarEstado($competencias);

    $usuario = $em->getRepository('SudokuBundle:Usuario')->findOneBy(
            array('usuario' => $this->get('security.context')->getToken()->getUserName())
    );

    return $this->render('SudokuBundle:Sitio:competencias.html.twig', array(
                'competencias' => $competencias,
                'usuario' => $usuario
    ));
  }

  public function competenciaAction($id) {
    $em = $this->getDoctrine()->getEntityManager();

    $competencia = $em->getRepository('SudokuBundle:Competencia')->find($id);

    if (!$competencia)
      throw $this->createNotFoundException('No existe la competencia');

    $sesion = $this->getRequest()->getSession();

    if ($competencia->getEstado() != 1) {
      $sesion->setFlash('error', 'La competencia seleccionada no ha iniciado aún');

      return $this->redirect($this->generateUrl('competencias'));
    }

    if ($competencia->tiempoFinalizado()) {
      $competencia->setEstado(2);

      $sesion->setFlash('error', 'La competencia seleccionada ha finalizado');

      return $this->redirect($this->generateUrl('ranking', array('id' => $id)));
    }

    if (!$sesion->get('competencia')) {
      $sudokus = array();
      foreach ($competencia->getMapas() as $mapa)
        $sudokus[] = new Sudoku($mapa->getComplejidad());

      $data = array(
          'id' => $competencia->getId(),
          'date_start' => $competencia->getFechaIniciada(),
          'time' => $competencia->getTiempo(),
          'sudokus' => $sudokus
      );

      $sesion->set('competencia', $data);
    } else {
      if($sesion->get('competencia')['id'] != $id){
        $sesion->remove('competencia');
        
        return $this->redirect ($this->generateUrl ('competencia', array('id' => $id)));
      }
      
      if (!count($sesion->get('competencia')['sudokus'])) {
        $sesion->setFlash('info', 'En hora buena, haz resuelto la competencia');

        return $this->redirect($this->generateUrl('ranking', array('id' => $id)));
      }
    }

    //$sesion->get('competencia')['sudokus'][0]->showGrid();

    return $this->render('SudokuBundle:Sitio:competencia.html.twig', array(
                'competencia' => $competencia,
                'mapa' => $sesion->get('competencia')['sudokus'][0]->getUserGrid(),
                'user_solution' => $sesion->get('competencia')['sudokus'][0]->getUserSolution()
    ));
  }

  public function calificarAction($id) {
    $peticion = $this->getRequest();

    if ($peticion->isXmlHttpRequest()) {
      $competencia = $peticion->getSession()->get('competencia');

      $sudoku = $competencia['sudokus'][0];
      $sudoku->loadGrid($peticion->get('map'));

      $puntos = $sudoku->calification();

      $em = $this->getDoctrine()->getEntityManager();

      $envio = new Envio();
      $envio->setCompetencia($em->getRepository('SudokuBundle:Competencia')->find($id));
      $envio->setUsuario($em->getRepository('SudokuBundle:Usuario')->findOneBy(
                      array('usuario' => $this->get('security.context')->getToken()->getUser()->getUsername())));
      $envio->setPuntos($puntos);

      $tiempo = new \DateTime("now");

      if ($puntos == 1) {
        $envio->setTiempo($tiempo);

        array_shift($competencia['sudokus']);

        $peticion->getSession()->set('competencia', $competencia);

        $datos = array('status' => 1, 'msg' => 'Envío correcto');
      } else {
        $tiempo->add(new \DateInterval('PT20S'));

        $envio->setTiempo($tiempo);

        if (0 < $puntos && $puntos < 1)
          $datos = array('status' => 2, 'msg' => 'Parcialmente correcto');
        else
          $datos = array('status' => 2, 'msg' => 'Envío incorrecto');
      }

      $em->persist($envio);
      $em->flush();

      $response = new Response(json_encode($datos));
      $response->headers->set('Content-Type', 'application/json');
    }
    else
      $response = new Response('Petición inválida');

    return $response;
  }

  public function enviosAction($id) {
    $em = $this->getDoctrine()->getEntityManager();

    $envios = $em->getRepository('SudokuBundle:Envio')->findBy(array('equipo' => $id));

    return $this->render('SudokuBundle:Sitio:envios.html.twig', array(
                'envios' => $envios
    ));
  }

  public function addAction() {
    $peticion = $this->getRequest();

    $competencia = new Competencia();
    $formulario = $this->createForm(new CompetenciaType(), $competencia);

    if ($peticion->getMethod() == 'POST') {
      $formulario->bindRequest($peticion);

      //Mapas por niveles
      $tiempo = 0;

      if ($peticion->get('facil')) {
        $c = $peticion->get('cf');

        $tiempo += ($c * $peticion->get('tf'));

        for (; $c; $c--) {
          $mapa = new Mapa();
          $mapa->setCompetencia($competencia);
          $mapa->setComplejidad('facil');

          $competencia->addMapa($mapa);
        }
      }
      if ($peticion->get('medio')) {
        $c = $peticion->get('cm');

        $tiempo += ($c * $peticion->get('tm'));

        for (; $c; $c--) {
          $mapa = new Mapa();
          $mapa->setCompetencia($competencia);
          $mapa->setComplejidad('medio');

          $competencia->addMapa($mapa);
        }
      }
      if ($peticion->get('dificil')) {
        $c = $peticion->get('cd');

        $tiempo += ($c * $peticion->get('td'));

        for (; $c; $c--) {
          $mapa = new Mapa();
          $mapa->setCompetencia($competencia);
          $mapa->setComplejidad('dificil');

          $competencia->addMapa($mapa);
        }
      }

      $competencia->setEstado(0);
      $competencia->setFecha(new \DateTime('now'));
      $competencia->setTiempo($tiempo);

      $em = $this->getDoctrine()->getEntityManager();

      if ($formulario->isValid()) {
        $em->persist($competencia);
        $em->flush();

        return $this->redirect($this->generateUrl('competencias'));
      }
    }

    return $this->render('SudokuBundle:Sitio:competencia_add.html.twig', array(
                'formulario' => $formulario->createView()
    ));
  }

  public function usuariosAction($id) {
    $em = $this->getDoctrine()->getEntityManager();

    $competencia = $em->getRepository('SudokuBundle:Competencia')->find($id);

    if (!$competencia)
      throw $this->createNotFoundException('No existe la competencia');

    return $this->render('SudokuBundle:Sitio:competencia_usuarios.html.twig', array(
                'competencia' => $competencia
    ));
  }

  public function removeAction($id) {
    $em = $this->getDoctrine()->getEntityManager();

    $competencia = $em->getRepository('SudokuBundle:Competencia')->find($id);

    if (!$competencia)
      throw $this->createNotFoundException('No existe la competencia');

    $em->remove($competencia);
    $em->flush();

    $sesion = $this->getRequest()->getSession();

    $sesion->setFlash('info', 'Competencia eliminada');

    return $this->redirect($this->generateUrl('competencias'));
  }

  public function inscribirseAction($id) {
    $em = $this->getDoctrine()->getEntityManager();

    $competencia = $em->getRepository('SudokuBundle:Competencia')->find($id);

    if (!$competencia)
      throw $this->createNotFoundException('No existe la competencia');

    $usuario = $em->getRepository('SudokuBundle:Usuario')->findOneBy(array('usuario' =>
        $this->get('security.context')->getToken()->getUserName()));

    if (!$em->getRepository('SudokuBundle:Competencia')->UsuarioInscrito($competencia, $usuario)) {
      $competencia->addUsuario($usuario);

      $em->persist($competencia);
      $em->flush();

      $this->getRequest()->getSession()->setFlash('info', 'Usted ha sido inscrito a la competencia');
    }
    else
      $this->getRequest()->getSession()->setFlash('error', 'Usted ya está inscrito en la competencia');

    return $this->redirect($this->generateUrl('competencias'));
  }

  public function bajaUsuarioAction($id, $idUsuario) {
    $em = $this->getDoctrine()->getEntityManager();

    $competencia = $em->getRepository('SudokuBundle:Competencia')->find($id);

    if (!$competencia)
      throw $this->createNotFoundException('No existe la competencia');

    $usuario = $em->getRepository('SudokuBundle:Usuario')->find($idUsuario);

    $competencia->getUsuarios()->removeElement($usuario);

    $em->persist($usuario);
    $em->flush();

    $this->getRequest()->getSession()->setFlash('info', 'Usuario eliminado correctamente');

    return $this->redirect($this->generateUrl('competencia_usuarios', array('id' => $id)));
  }

  public function cambiarEstadoAction($id, $estado) {
    $em = $this->getDoctrine()->getEntityManager();

    $competencia = $em->getRepository('SudokuBundle:Competencia')->find($id);

    if (!$competencia)
      throw $this->createNotFoundException('No existe la competencia');

    if ($estado == 'iniciar') {
      if ($competencia->getEstado() == 0) {
        $competencia->setEstado(1);
        $competencia->setFechaIniciada(new \DateTime('now'));

        $em->persist($competencia);
        $em->flush();
      }
    } else if ($estado == 'detener') {
      if ($competencia->getEstado() == 1) {
        $competencia->setEstado(2);

        $em->persist($competencia);
        $em->flush();
      }
    }

    return $this->redirect($this->generateUrl('competencias'));
  }

}

?>
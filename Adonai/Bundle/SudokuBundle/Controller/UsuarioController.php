<?php

namespace Adonai\Bundle\SudokuBundle\Controller;

/**
 * Description of UsuarioController
 *
 * @author jdsantana
 */

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Adonai\Bundle\SudokuBundle\Entity\Usuario;
use Adonai\Bundle\SudokuBundle\Form\UsuarioType;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UsuarioController extends Controller{
  
  public function registrarAction(){
    $peticion = $this->getRequest();
    
    $usuario = new Usuario();
    $formulario = $this->createForm(new UsuarioType(), $usuario);
    
    if($peticion->getMethod() == 'POST'){
      $formulario->bindRequest($peticion);
      
      $em = $this->getDoctrine()->getEntityManager();
      
      $rol = $em->getRepository('SudokuBundle:Rol')->findOneBy(array('rol' => 'ROLE_USER'));
      
      $usuario->setRol($rol);
      
      if($formulario->isValid()){
        $em->persist($usuario);
        $em->flush();
        
        $token = new UsernamePasswordToken($usuario, null, 'todos', $usuario->getRoles());
        $this->get('security.context')->setToken($token);
        
        return $this->redirect($this->generateUrl('competencias'));
      }
    }
    
    return $this->render('SudokuBundle:Sitio:registrar.html.twig', array(
        'formulario' => $formulario->createView()
    ));
  }
  
  public function listAction(){
    $em = $this->getDoctrine()->getEntityManager();
    
    $usuarios = $em->getRepository('SudokuBundle:Usuario')->findAll();
    
    return $this->render('SudokuBundle:Sitio:usuarios.html.twig', array(
       'usuarios' => $usuarios
    ));
  }
  
  public function removeAction($id){
    $em = $this->getDoctrine()->getEntityManager();
    
    $usuario = $em->getRepository('SudokuBundle:Usuario')->find($id);
    
    if(!$usuario)
      throw $this->createNotFoundException('No existe el usuario');
    
    $em->remove($usuario);
    $em->flush();
    
    return $this->redirect($this->generateUrl('usuarios'));
  }
  
  public function editAction($id){
    $peticion = $this->getRequest();
    
    $em = $this->getDoctrine()->getEntityManager();
    
    $usuario = $em->getRepository('SudokuBundle:Usuario')->find($id);
    $formulario = $this->createForm(new UsuarioType(), $usuario);
    
    if(!$usuario)
      throw $this->createNotFoundException('No existe el usuario');
    
    if($peticion->getMethod() == 'POST'){
      $formulario->bindRequest($peticion);
      
      if($formulario->isValid()){
        $em->persist($usuario);
        $em->flush();
        
        $peticion->getSession()->setFlash('info', 'El usuario ha sido actualizado');
        
        return $this->redirect($this->generateUrl('usuarios'));
      }
    }
    
    return $this->render('SudokuBundle:Sitio:usuario_edit.html.twig', array(
        'id' => $id,
        'formulario' => $formulario->createView()
    ));
  }
}

?>

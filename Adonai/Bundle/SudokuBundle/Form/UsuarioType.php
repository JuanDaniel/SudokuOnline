<?php

namespace Adonai\Bundle\SudokuBundle\Form;

/**
 * Description of UsuarioType
 *
 * @author jdsantana
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UsuarioType extends AbstractType {
  
  public function buildForm(FormBuilder $builder, array $options){
    $builder->add('nombre', 'text')
            ->add('apellidos', 'text')
            ->add('usuario', 'text')
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'Los campos de contraseña deben coincidir.',
                'first_name' => 'Contraseña',
                'second_name' => 'Confirmar contraseña'
            ));
  }
  
  public function getName() {
    return 'sudoku_usuariotype';
  }
}

?>

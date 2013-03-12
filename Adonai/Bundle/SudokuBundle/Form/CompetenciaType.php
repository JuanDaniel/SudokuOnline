<?php

namespace Adonai\Bundle\SudokuBundle\Form;

/**
 * Description of CompetenciaType
 *
 * @author jdsantana
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CompetenciaType extends AbstractType{
  
  public function buildForm(FormBuilder $builder, array $options) {
     $builder
              ->add('nombre', 'text', array('label' => 'Nombre', 'attr' => array(
                  'class' => 'input-medium',
                  'placeholder' => 'Nombre...'
              )));
  }
  
  public function getName() {
    return 'sudoku_competenciatype';
  }
}

?>

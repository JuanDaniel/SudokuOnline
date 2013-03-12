<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sudoku
 *
 * @author jdsantana
 */

namespace Adonai\Bundle\SudokuBundle\Util;

class Sudoku_sosa {

  private $set;
  private $grid;
  private $user_grid;
  private $complex;
  private $time_finished;

  public function __construct($complex='easy') {
    $this->set = array();
    $this->grid = array(array());
    $this->user_grid = array(array());
    $this->complex = $complex;

    $this->setSet();
    $this->TimeFinished();
    $this->generateGrid();
    $this->generateUserGrid();
  }

  private function setSet() {
    for ($i = 0; $i < 9; $i++)
      $this->set[] = rand(2, 5);
  }

  private function generateGrid() {
    $mark = array();
    for ($i = 0; $i < 9; $i++) {
      $val = rand(1, 9);
      while (in_array($val, $mark))
        $val = rand(1, 9);
      $this->grid[0][$i] = $val;
      $mark[] = $val;
    }

    for ($i = 1, $jump = 3; $i < 9; $i++, $jump+=3) {
      if ($jump >= 9)
        $jump = $jump % 9 + 1;
      for ($j = 0; $j < 9; $j++)
        $this->grid[$i][$j] = $this->grid[0][($jump + $j) % 9];
    }
  }

  private function generateUserGrid() {
    //Primer set
    $this->user_grid[0][] = $this->grid[0][0];
    $this->user_grid[0][] = $this->grid[0][1];
    $this->user_grid[0][] = $this->grid[0][2];
    $this->user_grid[0][] = $this->grid[1][0];
    $this->user_grid[0][] = $this->grid[1][1];
    $this->user_grid[0][] = $this->grid[1][2];
    $this->user_grid[0][] = $this->grid[2][0];
    $this->user_grid[0][] = $this->grid[2][1];
    $this->user_grid[0][] = $this->grid[2][2];

    //Segundo set
    $this->user_grid[1][] = $this->grid[0][3];
    $this->user_grid[1][] = $this->grid[0][4];
    $this->user_grid[1][] = $this->grid[0][5];
    $this->user_grid[1][] = $this->grid[1][3];
    $this->user_grid[1][] = $this->grid[1][4];
    $this->user_grid[1][] = $this->grid[1][5];
    $this->user_grid[1][] = $this->grid[2][3];
    $this->user_grid[1][] = $this->grid[2][4];
    $this->user_grid[1][] = $this->grid[2][5];

    //Tercer set
    $this->user_grid[2][] = $this->grid[0][6];
    $this->user_grid[2][] = $this->grid[0][7];
    $this->user_grid[2][] = $this->grid[0][8];
    $this->user_grid[2][] = $this->grid[1][6];
    $this->user_grid[2][] = $this->grid[1][7];
    $this->user_grid[2][] = $this->grid[1][8];
    $this->user_grid[2][] = $this->grid[2][6];
    $this->user_grid[2][] = $this->grid[2][7];
    $this->user_grid[2][] = $this->grid[2][8];

    //Cuarto set
    $this->user_grid[3][] = $this->grid[3][0];
    $this->user_grid[3][] = $this->grid[3][1];
    $this->user_grid[3][] = $this->grid[3][2];
    $this->user_grid[3][] = $this->grid[4][0];
    $this->user_grid[3][] = $this->grid[4][1];
    $this->user_grid[3][] = $this->grid[4][2];
    $this->user_grid[3][] = $this->grid[5][0];
    $this->user_grid[3][] = $this->grid[5][1];
    $this->user_grid[3][] = $this->grid[5][2];

    //Quinto set
    $this->user_grid[4][] = $this->grid[3][3];
    $this->user_grid[4][] = $this->grid[3][4];
    $this->user_grid[4][] = $this->grid[3][5];
    $this->user_grid[4][] = $this->grid[4][3];
    $this->user_grid[4][] = $this->grid[4][4];
    $this->user_grid[4][] = $this->grid[4][5];
    $this->user_grid[4][] = $this->grid[5][3];
    $this->user_grid[4][] = $this->grid[5][4];
    $this->user_grid[4][] = $this->grid[5][5];

    //Sexto set
    $this->user_grid[5][] = $this->grid[3][6];
    $this->user_grid[5][] = $this->grid[3][7];
    $this->user_grid[5][] = $this->grid[3][8];
    $this->user_grid[5][] = $this->grid[4][6];
    $this->user_grid[5][] = $this->grid[4][7];
    $this->user_grid[5][] = $this->grid[4][8];
    $this->user_grid[5][] = $this->grid[5][6];
    $this->user_grid[5][] = $this->grid[5][7];
    $this->user_grid[5][] = $this->grid[5][8];

    //Septimo set
    $this->user_grid[6][] = $this->grid[6][0];
    $this->user_grid[6][] = $this->grid[6][1];
    $this->user_grid[6][] = $this->grid[6][2];
    $this->user_grid[6][] = $this->grid[7][0];
    $this->user_grid[6][] = $this->grid[7][1];
    $this->user_grid[6][] = $this->grid[7][2];
    $this->user_grid[6][] = $this->grid[8][0];
    $this->user_grid[6][] = $this->grid[8][1];
    $this->user_grid[6][] = $this->grid[8][2];

    //Octavo set
    $this->user_grid[7][] = $this->grid[6][3];
    $this->user_grid[7][] = $this->grid[6][4];
    $this->user_grid[7][] = $this->grid[6][5];
    $this->user_grid[7][] = $this->grid[7][3];
    $this->user_grid[7][] = $this->grid[7][4];
    $this->user_grid[7][] = $this->grid[7][5];
    $this->user_grid[7][] = $this->grid[8][3];
    $this->user_grid[7][] = $this->grid[8][4];
    $this->user_grid[7][] = $this->grid[8][5];

    //Noveno set
    $this->user_grid[8][] = $this->grid[6][6];
    $this->user_grid[8][] = $this->grid[6][7];
    $this->user_grid[8][] = $this->grid[6][8];
    $this->user_grid[8][] = $this->grid[7][6];
    $this->user_grid[8][] = $this->grid[7][7];
    $this->user_grid[8][] = $this->grid[7][8];
    $this->user_grid[8][] = $this->grid[8][6];
    $this->user_grid[8][] = $this->grid[8][7];
    $this->user_grid[8][] = $this->grid[8][8];

    for ($i = 0; $i < 9; $i++) {
      $mark = array();
      for ($j = 0; $j < (9 - $this->set[$i]); $j++) {
        $pos = rand(0, 8);
        while (in_array($pos, $mark))
          $pos = rand(0, 8);
        $this->user_grid[$i][$pos] = null;
        $mark[] = $pos;
      }
    }

    //Primer set
    $this->user_grid[0][0] = $this->user_grid[0][0];
    $this->user_grid[0][1] = $this->user_grid[0][1];
    $this->user_grid[0][2] = $this->user_grid[0][2];
    $this->user_grid[1][0] = $this->user_grid[0][3];
    $this->user_grid[1][1] = $this->user_grid[0][4];
    $this->user_grid[1][2] = $this->user_grid[0][5];
    $this->user_grid[2][0] = $this->user_grid[0][6];
    $this->user_grid[2][1] = $this->user_grid[0][7];
    $this->user_grid[2][2] = $this->user_grid[0][8];

    //Segundo set
    $this->user_grid[0][3] = $this->user_grid[1][0];
    $this->user_grid[0][4] = $this->user_grid[1][1];
    $this->user_grid[0][5] = $this->user_grid[1][2];
    $this->user_grid[1][3] = $this->user_grid[1][3];
    $this->user_grid[1][4] = $this->user_grid[1][4];
    $this->user_grid[1][5] = $this->user_grid[1][5];
    $this->user_grid[2][3] = $this->user_grid[1][6];
    $this->user_grid[2][4] = $this->user_grid[1][7];
    $this->user_grid[2][5] = $this->user_grid[1][8];

    //Tercer set
    $this->user_grid[0][6] = $this->user_grid[2][0];
    $this->user_grid[0][7] = $this->user_grid[2][1];
    $this->user_grid[0][8] = $this->user_grid[2][2];
    $this->user_grid[1][6] = $this->user_grid[2][3];
    $this->user_grid[1][7] = $this->user_grid[2][4];
    $this->user_grid[1][8] = $this->user_grid[2][5];
    $this->user_grid[2][6] = $this->user_grid[2][6];
    $this->user_grid[2][7] = $this->user_grid[2][7];
    $this->user_grid[2][8] = $this->user_grid[2][8];

    //Cuarto set
    $this->user_grid[3][0] = $this->user_grid[3][0];
    $this->user_grid[3][1] = $this->user_grid[3][1];
    $this->user_grid[3][2] = $this->user_grid[3][2];
    $this->user_grid[4][0] = $this->user_grid[3][3];
    $this->user_grid[4][1] = $this->user_grid[3][4];
    $this->user_grid[4][2] = $this->user_grid[3][5];
    $this->user_grid[5][0] = $this->user_grid[3][6];
    $this->user_grid[5][1] = $this->user_grid[3][7];
    $this->user_grid[5][2] = $this->user_grid[3][8];

    //Quinto set
    $this->user_grid[3][3] = $this->user_grid[4][0];
    $this->user_grid[3][4] = $this->user_grid[4][1];
    $this->user_grid[3][5] = $this->user_grid[4][2];
    $this->user_grid[4][3] = $this->user_grid[4][3];
    $this->user_grid[4][4] = $this->user_grid[4][4];
    $this->user_grid[4][5] = $this->user_grid[4][5];
    $this->user_grid[5][3] = $this->user_grid[4][6];
    $this->user_grid[5][4] = $this->user_grid[4][7];
    $this->user_grid[5][5] = $this->user_grid[4][8];

    //Sexto set
    $this->user_grid[3][6] = $this->user_grid[5][0];
    $this->user_grid[3][7] = $this->user_grid[5][1];
    $this->user_grid[3][8] = $this->user_grid[5][2];
    $this->user_grid[4][6] = $this->user_grid[5][3];
    $this->user_grid[4][7] = $this->user_grid[5][4];
    $this->user_grid[4][8] = $this->user_grid[5][5];
    $this->user_grid[5][6] = $this->user_grid[5][6];
    $this->user_grid[5][7] = $this->user_grid[5][7];
    $this->user_grid[5][8] = $this->user_grid[5][8];

    //Septimo set
    $this->user_grid[6][0] = $this->user_grid[6][0];
    $this->user_grid[6][1] = $this->user_grid[6][1];
    $this->user_grid[6][2] = $this->user_grid[6][2];
    $this->user_grid[7][0] = $this->user_grid[6][3];
    $this->user_grid[7][1] = $this->user_grid[6][4];
    $this->user_grid[7][2] = $this->user_grid[6][5];
    $this->user_grid[8][0] = $this->user_grid[6][6];
    $this->user_grid[8][1] = $this->user_grid[6][7];
    $this->user_grid[8][2] = $this->user_grid[6][8];

    //Octavo set
    $this->user_grid[6][3] = $this->user_grid[7][0];
    $this->user_grid[6][4] = $this->user_grid[7][1];
    $this->user_grid[6][5] = $this->user_grid[7][2];
    $this->user_grid[7][3] = $this->user_grid[7][3];
    $this->user_grid[7][4] = $this->user_grid[7][4];
    $this->user_grid[7][5] = $this->user_grid[7][5];
    $this->user_grid[8][3] = $this->user_grid[7][6];
    $this->user_grid[8][4] = $this->user_grid[7][7];
    $this->user_grid[8][5] = $this->user_grid[7][8];

    //Noveno set
    $this->user_grid[6][6] = $this->user_grid[8][0];
    $this->user_grid[6][7] = $this->user_grid[8][1];
    $this->user_grid[6][8] = $this->user_grid[8][2];
    $this->user_grid[7][6] = $this->user_grid[8][3];
    $this->user_grid[7][7] = $this->user_grid[8][4];
    $this->user_grid[7][8] = $this->user_grid[8][5];
    $this->user_grid[8][6] = $this->user_grid[8][6];
    $this->user_grid[8][7] = $this->user_grid[8][7];
    $this->user_grid[8][8] = $this->user_grid[8][8];
  }

  public function getGrid() {
    return $this->grid;
  }
  
  public function getUserGrid(){
    return $this->user_grid;
  }

  public function getSet() {
    return $this->set;
  }
  
  public function getTimeFinished(){
    return $this->time_finished;
  }

    public function TimeFinished(){
      $date = new \DateTime();
      switch ($this->complex){
        case 'easy':
          $date->add(new \DateInterval('PT10M'));
          break;
        case 'medium':
          $date->add(new \DateInterval('PT12M'));
          break;
        case 'hard':
          $date->add(new \DateInterval('PT15M'));
          break;
      }
    
      $this->time_finished = $date;
  }

  public function showGrid() {
    for ($i = 0; $i < 9; $i++) {
      for ($j = 0; $j < 9; $j++)
        echo $this->grid[$i][$j] . ' ';
      echo '<br />';
    }
  }

  public function showUserGrid() {
    for ($i = 0; $i < 9; $i++) {
      for ($j = 0; $j < 9; $j++)
        echo $this->user_grid[$i][$j] . ' ';
      echo '<br />';
    }
  }
  
  public function calification($solution){
    $result=0;
    $completos=0;
    for($i=0; $i<9; $i++){
      for($j=0; $j<9; $j++){
        if($this->grid[$i][$j] == $solution[$i][$j])
          $result++;
        if($this->user_grid[$i][$j])
          $completos++;
      }
    }
    
    $completar=(81-$completos);
    $completados=($result-$completos);
    
    return (double)($completados/$completar);
  }

}

?>

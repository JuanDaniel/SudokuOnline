<?php

namespace Adonai\Bundle\SudokuBundle\Util;

/**
 * Description of Sudoku
 *
 * @author jdsantana
 */
class Sudoku {

  private $grid;
  private $user_grid;
  private $complex;
  private $level_complex;
  private $user_solution;

  public function __construct($complex = 'easy') {
    $this->grid = array(array());
    $this->user_grid = array(array());
    $this->complex = $complex;
    $this->level_complex = array('easy' => 40, 'facil' => 40, 'medium' => 46, 'medio' => 46, 'hard' => 52, 'dificil' => 52);

    $this->generateGrid();
    $this->generateUserGrid();
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
    for ($i = 0; $i < 9; $i++)
      for ($j = 0; $j < 9; $j++)
        $this->user_grid[$i][$j] = $this->grid[$i][$j];

    $mark = array();

    for ($i = 0; $i < ($this->level_complex[$this->complex]); $i++) {
      $pos = rand(0, 80);
      while (in_array($pos, $mark))
        $pos = rand(0, 80);
      $this->user_grid[$pos / 9][$pos % 9] = null;
      $mark[] = $pos;
    }
    
    for ($i = 0; $i < 9; $i++)
      for ($j = 0; $j < 9; $j++)
        $this->user_solution[$i][$j] = $this->user_grid[$i][$j];
  }

  public function getGrid() {
    return $this->grid;
  }

  public function getUserGrid() {
    return $this->user_grid;
  }

  public function getUserSolution() {
    return $this->user_solution;
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
        echo $this->user_grid[$i][$j] ? $this->user_grid[$i][$j] . ' ' : '0' . ' ';
      echo '<br />';
    }
  }

  public function calification() {
    $completed = 0;
    
    if($this->check()){
      for ($i = 0; $i < 9; $i++)
        for ($j = 0; $j < 9; $j++)
          if ($this->isColum($j, $this->user_solution[$i][$j]) && $this->isRow($i, $this->user_solution[$i][$j]) && $this->isGrid($i, $j, $this->user_solution[$i][$j]))
            $completed++;
    }
        
    return (double) ($completed / 81);
  }

  public function loadGrid($solution) {
    $this->user_solution = array_chunk($solution, 9);
  }

  private function check(){
    for($i=0; $i<9; $i++)
      for($j=0; $j<9; $j++)
        if(!$this->user_solution[$i][$j])
          return false;
        
    return true;
  }
  
  private function isColum($col, $val) {
    $c = 0;
    for ($i = 0; $i < 9; $i++)
      if ($this->user_solution[$i][$col] == $val)
        $c++;

    return ($c == 1);
  }

  private function isRow($row, $val) {
    $c = 0;
    for ($i = 0; $i < 9; $i++)
      if ($this->user_solution[$row][$i] == $val)
        $c++;

    return ($c == 1);
  }

  private function isGrid($x, $y, $val) {
    //Primer set
    if ($x <= 2 && $y <= 2)
      $set = array($this->user_solution[0][0], $this->user_solution[0][1], $this->user_solution[0][2], $this->user_solution[1][0], $this->user_solution[1][1], $this->user_solution[1][2], $this->user_solution[2][0], $this->user_solution[2][1], $this->user_solution[2][2]);

    //Segundo set
    else if ($x <= 2 && $y >= 3 && $y <= 5)
      $set = array($this->user_solution[0][3], $this->user_solution[0][4], $this->user_solution[0][5], $this->user_solution[1][3], $this->user_solution[1][4], $this->user_solution[1][5], $this->user_solution[2][3], $this->user_solution[2][4], $this->user_solution[2][5]);

    //Tercer set
    else if ($x <= 2 && $y >= 6)
      $set = array($this->user_solution[0][6], $this->user_solution[0][7], $this->user_solution[0][8], $this->user_solution[1][6], $this->user_solution[1][7], $this->user_solution[1][8], $this->user_solution[2][6], $this->user_solution[2][7], $this->user_solution[2][8]);

    //Cuarto set
    else if ($x >= 3 && $x <= 5 && $y <= 2)
      $set = array($this->user_solution[3][0], $this->user_solution[3][1], $this->user_solution[3][2], $this->user_solution[4][0], $this->user_solution[4][1], $this->user_solution[4][2], $this->user_solution[5][0], $this->user_solution[5][1], $this->user_solution[5][2]);

    //Quinto set
    else if ($x >= 3 && $x <= 5 && $y >= 3 && $y <= 5)
      $set = array($this->user_solution[3][3], $this->user_solution[3][4], $this->user_solution[3][5], $this->user_solution[4][3], $this->user_solution[4][4], $this->user_solution[4][5], $this->user_solution[5][3], $this->user_solution[5][4], $this->user_solution[5][5]);

    //Sexto set
    else if ($x >= 3 && $x <= 5 && $y >= 6)
      $set = array($this->user_solution[3][6], $this->user_solution[3][7], $this->user_solution[3][8], $this->user_solution[4][6], $this->user_solution[4][7], $this->user_solution[4][8], $this->user_solution[5][6], $this->user_solution[5][7], $this->user_solution[5][8]);

    //Septimo set
    else if ($x >= 6 && $y <= 2)
      $set = array($this->user_solution[6][0], $this->user_solution[6][1], $this->user_solution[6][2], $this->user_solution[7][0], $this->user_solution[7][1], $this->user_solution[7][2], $this->user_solution[8][0], $this->user_solution[8][1], $this->user_solution[8][2]);

    //Octavo set
    else if ($x >= 6 && $y >= 3 && $y <= 5)
      $set = array($this->user_solution[6][3], $this->user_solution[6][4], $this->user_solution[6][5], $this->user_solution[7][3], $this->user_solution[7][4], $this->user_solution[7][5], $this->user_solution[8][3], $this->user_solution[8][4], $this->user_solution[8][5]);

    //Noveno set
    else
      $set = array($this->user_solution[6][6], $this->user_solution[6][7], $this->user_solution[6][8], $this->user_solution[7][6], $this->user_solution[7][7], $this->user_solution[7][8], $this->user_solution[8][6], $this->user_solution[8][7], $this->user_solution[8][8]);

    $c = 0;
    for ($i = 0; $i < 9; $i++)
      if ($set[$i] == $val)
        $c++;

    return ($c == 1);
  }

}

?>

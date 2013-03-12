<?php

namespace Adonai\Bundle\SudokuBundle\Util;

/**
 * Description of Sudoku
 * Inspired by Thomas Weibel
 *
 * @author jdsantana
 */
class Sudoku_weibel {

  private $lv;
  private $mi;
  private $ma;
  private $co;
  private $ml;
  private $mc;
  private $n;
  private $s;
  private $rn;
  private $b;
  private $td;
  private $pa;
  private $rw;
  private $cl;
  private $bk;

  public function __construct() {
    $this->lv = array(40, 52, 46);
    $this->mi = 1;
    $this->ma = 7;
    $this->co = array(0, 1, 2);
    $this->ml = array('easy', 'hard', 'medium');
    $this->mc = array('green', 'blue', 'red', 'blueviolet', 'yellow', 'brown', 'orangered', 'orange', 'scrollbar');
    $this->n = 81;
    $this->s = 47;
    $this->rn = 0;
    $this->td = array();
  }

  private function ti() {
    for ($i = 0; $i < $this->n; $i++)
      $this->td[] = "";

    $this->st();
    $this->sh();
  }

  private function st() {
    $nm = array();
    $ps = array();
    $sm = array();

    for ($i = 0; $i < $this->n; $i++)
      $sm[] = $i;

    $$this->pa = array(11, 22, 33, 44, 55, 66, 77, 88, 99);
    $rd = array();

    $ip = "<input type=\"text\" autocomplete=\"off\" id=\"f" . $this->co[0] . "\" maxlength=\"1\" value=\"\" onkeyup=\"javascript:er(";
    $en = ");\">";

    $this->cc();

    for ($i = 0; $i < $this->n; $i++) {
      $rm = rand(1, 9);
      $rd[$i] = $rd[$rm];
      $rd[$rm] = $i;
    }

    for ($i = 0; $i < $this->n; $i++)
      $this->td[$i] = "<input type=\"text\" maxLength=\"1\" value=\"" . $nm[$i] . "\" readonly>";

    for ($i = 0; $i < $this->lv[0]; $i++) {
      $nm[$sm[$rd[$i]]] = "";
      $this->td[$sm[$rd[$i]]] = $ip . $sm[$rd[$i]] . $en;
    }

    $this->rj();
  }

  private function cc() {
    $i = $this->n;
    do {
      $i--;
      if (!$ps[$i] >= 1) {
        $rn = rand(1, 9);
        $nm[$i] = $rn;
        $ps[$i] = 1;
      } else {
        $nm[$i]++;
        if ($nm[$i] > 9)
          $nm[$i] = 1;
        $ps[$i]++;
      }

      $this->sa();

      if ($this->find_one($this->rw, $this->pa) || $this->find_one($this->cl, $this->pa) || $this->find_one($this->bk, $this->pa)) {
        if ($ps[$i] < 9)
          $i++;
        else {
          $nm[$i] = 0;
          $ps[$i] = 0;
          if ($ps[$i - 1] > 8)
            $ps[$i - 1] = 1;

          $i = $i + 2;
        }
      }
    }while ($i);
  }

  private function sa() {
    $this->rw = array(
        array($this->nm[0], $this->nm[1], $this->nm[2], $this->nm[3], $this->nm[4], $this->nm[5], $this->nm[6], $this->nm[7], $this->nm[8]),
        array($this->nm[9], $this->nm[10], $this->nm[11], $this->nm[12], $this->nm[13], $this->nm[14], $this->nm[15], $this->nm[16], $this->nm[17]),
        array($this->nm[18], $this->nm[19], $this->nm[20], $this->nm[21], $this->nm[22], $this->nm[23], $this->nm[24], $this->nm[25], $this->nm[26]),
        array($this->nm[27], $this->nm[28], $this->nm[29], $this->nm[30], $this->nm[31], $this->nm[32], $this->nm[33], $this->nm[34], $this->nm[35]),
        array($this->nm[36], $this->nm[37], $this->nm[38], $this->nm[39], $this->nm[40], $this->nm[41], $this->nm[42], $this->nm[43], $this->nm[44]),
        array($this->nm[45], $this->nm[46], $this->nm[47], $this->nm[48], $this->nm[49], $this->nm[50], $this->nm[51], $this->nm[52], $this->nm[53]),
        array($this->nm[54], $this->nm[55], $this->nm[56], $this->nm[57], $this->nm[58], $this->nm[59], $this->nm[60], $this->nm[61], $this->nm[62]),
        array($this->nm[63], $this->nm[64], $this->nm[65], $this->nm[66], $this->nm[67], $this->nm[68], $this->nm[69], $this->nm[70], $this->nm[71]),
        array($this->nm[72], $this->nm[73], $this->nm[74], $this->nm[75], $this->nm[76], $this->nm[77], $this->nm[78], $this->nm[79], $this->nm[80])
    );

    $this->cl = array(
        array($this->nm[0], $this->nm[9], $this->nm[18], $this->nm[27], $this->nm[36], $this->nm[45], $this->nm[54], $this->nm[63], $this->nm[72]),
        array($this->nm[1], $this->nm[10], $this->nm[19], $this->nm[28], $this->nm[37], $this->nm[46], $this->nm[55], $this->nm[64], $this->nm[73]),
        array($this->nm[2], $this->nm[11], $this->nm[20], $this->nm[29], $this->nm[38], $this->nm[47], $this->nm[56], $this->nm[65], $this->nm[74]),
        array($this->nm[3], $this->nm[12], $this->nm[21], $this->nm[30], $this->nm[39], $this->nm[48], $this->nm[57], $this->nm[66], $this->nm[75]),
        array($this->nm[4], $this->nm[13], $this->nm[22], $this->nm[31], $this->nm[40], $this->nm[49], $this->nm[58], $this->nm[67], $this->nm[76]),
        array($this->nm[5], $this->nm[14], $this->nm[23], $this->nm[32], $this->nm[41], $this->nm[50], $this->nm[59], $this->nm[68], $this->nm[77]),
        array($this->nm[6], $this->nm[15], $this->nm[24], $this->nm[33], $this->nm[42], $this->nm[51], $this->nm[60], $this->nm[69], $this->nm[78]),
        array($this->nm[7], $this->nm[16], $this->nm[25], $this->nm[34], $this->nm[43], $this->nm[52], $this->nm[61], $this->nm[70], $this->nm[79]),
        array($this->nm[8], $this->nm[17], $this->nm[26], $this->nm[35], $this->nm[44], $this->nm[53], $this->nm[62], $this->nm[71], $this->nm[80])
    );

    $this->bk = array(
        array($this->nm[0], $this->nm[1], $this->nm[2], $this->nm[9], $this->nm[10], $this->nm[11], $this->nm[18], $this->nm[19], $this->nm[20]),
        array($this->nm[3], $this->nm[4], $this->nm[5], $this->nm[12], $this->nm[13], $this->nm[14], $this->nm[21], $this->nm[22], $this->nm[23]),
        array($this->nm[6], $this->nm[7], $this->nm[8], $this->nm[15], $this->nm[16], $this->nm[17], $this->nm[24], $this->nm[25], $this->nm[26]),
        array($this->nm[27], $this->nm[28], $this->nm[29], $this->nm[36], $this->nm[37], $this->nm[38], $this->nm[45], $this->nm[46], $this->nm[47]),
        array($this->nm[30], $this->nm[31], $this->nm[32], $this->nm[39], $this->nm[40], $this->nm[41], $this->nm[48], $this->nm[49], $this->nm[50]),
        array($this->nm[33], $this->nm[34], $this->nm[35], $this->nm[42], $this->nm[43], $this->nm[44], $this->nm[51], $this->nm[52], $this->nm[53]),
        array($this->nm[54], $this->nm[55], $this->nm[56], $this->nm[63], $this->nm[64], $this->nm[65], $this->nm[72], $this->nm[73], $this->nm[74]),
        array($this->nm[57], $this->nm[58], $this->nm[59], $this->nm[66], $this->nm[67], $this->nm[68], $this->nm[75], $this->nm[76], $this->nm[77]),
        array($this->nm[60], $this->nm[61], $this->nm[62], $this->nm[69], $this->nm[70], $this->nm[71], $this->nm[78], $this->nm[79], $this->nm[80])
    );
  }

  private function rj() {
    $this->sa();

    if ($this->mm($this->rw, $this->ma, $this->mi) || $this->mm($this->cl, $this->ma, $this->mi) || $this->mm($this->bk, $this->ma, $this->mi))
      $this->st();
    else
      $this->sh();
  }

  private function mm($array, $max, $min) {
    for ($i = 0; $i < 9; $i++)
      if (strlen(implode($array[$i])) > $max || strlen(implode($array[$i])) < $min)
        return true;

    return false;
  }

  private function find_one($array, $el) {
    for ($i = 0; $i < 9; $i++)
      for ($j = 0; $j < 9; $j++)
        if (array_search($el[$i], $array[$j]) !== false)
          return true;

    return false;
  }

  private function sh() {
    $t = "<\/td><td";
    $mn = "&nbsp;<a id=\"mu\" href=\"javascript:ti();\">New<\/a><a id=\"mu\" href=\"javascript:sl();\">Level<\/a><a id=\"mu\" href=\"javascript:sc();\">Input color<\/a><a id=\"mu\" href=\"javascript:sk();\">Save<\/a><a id=\"mu\" href=\"javascript:ld();\">Open<\/a><a id=\"mu\" href=\"javascript:ab();\">About<\/a><a id=\"mu\" href=\"mailto:thomas.weibel@bluewin.ch\">Mail<\/a>";
    $display = "<div><form><table><tr><td id=\"tf\">" . $this->td[0] . $t . " id=\"tp\">" . $this->td[1] . $t . " id=\"tg\">" . $this->td[2] . $t . " id=\"tp\">" . $this->td[3] . "<\/td id=\"tp\"><td id=\"tp\">" . $this->td[4] . $t . " id=\"tg\">" . $this->td[5] . $t . " id=\"tp\">" . $this->td[6] . $t . " id=\"tp\">" . $this->td[7] . $t . " id=\"tg\">" . $this->td[8] . "<\/td><\/tr><tr><td id=\"lf\">" . $this->td[9] . $t . ">" . $this->td[10] . $t . " id=\"rt\">" . $this->td[11] . $t . ">" . $this->td[12] . $t . ">" . $this->td[13] . $t . " id=\"rt\">" . $this->td[14] . $t . ">" . $this->td[15] . $t . ">" . $this->td[16] . $t . " id=\"rt\">" . $this->td[17] . "<\/td><\/tr><tr><td id=\"bl\">" . $this->td[18] . $t . " id=\"bt\">" . $this->td[19] . $t . " id=\"bg\">" . $this->td[20] . $t . " id=\"bt\">" . $this->td[21] . $t . " id=\"bt\">" . $this->td[22] . $t . " id=\"bg\">" . $this->td[23] . $t . " id=\"bt\">" . $this->td[24] . $t . " id=\"bt\">" . $this->td[25] . $t . " id=\"bg\">" . $this->td[26] . "<\/td><\/tr><tr><td id=\"lf\">" . $this->td[27] . $t . ">" . $this->td[28] . $t . " id=\"rt\">" . $this->td[29] . $t . ">" . $this->td[30] . $t . ">" . $this->td[31] . $t . " id=\"rt\">" . $this->td[32] . $t . ">" . $this->td[33] . $t . ">" . $this->td[34] . $t . " id=\"rt\">" . $this->td[35] . "<\/td><\/tr><tr><td id=\"lf\">" . $this->td[36] . $t . ">" . $this->td[37] . $t . " id=\"rt\">" . $this->td[38] . $t . ">" . $this->td[39] . $t . ">" . $this->td[40] . $t . " id=\"rt\">" . $this->td[41] . $t . ">" . $this->td[42] . $t . ">" . $this->td[43] . $t . " id=\"rt\">" . $this->td[44] . "<\/td><\/tr><tr><td id=\"bl\">" . $this->td[45] . $t . " id=\"bt\">" . $this->td[46] . $t . " id=\"bg\">" . $this->td[47] . $t . " id=\"bt\">" . $this->td[48] . $t . " id=\"bt\">" . $this->td[49] . $t . " id=\"bg\">" . $this->td[50] . $t . " id=\"bt\">" . $this->td[51] . $t . " id=\"bt\">" . $this->td[52] . $t . " id=\"bg\">" . $this->td[53] . "<\/td><\/tr><tr><td id=\"lf\">" . $this->td[54] . $t . ">" . $this->td[55] . $t . " id=\"rt\">" . $this->td[56] . $t . ">" . $this->td[57] . $t . ">" . $this->td[58] . $t . " id=\"rt\">" . $this->td[59] . $t . ">" . $this->td[60] . $t . ">" . $this->td[61] . $t . " id=\"rt\">" . $this->td[62] . "<\/td><\/tr><tr><td id=\"lf\">" . $this->td[63] . $t . ">" . $this->td[64] . $t . " id=\"rt\">" . $this->td[65] . $t . ">" . $this->td[66] . $t . ">" . $this->td[67] . $t . " id=\"rt\">" . $this->td[68] . $t . ">" . $this->td[69] . $t . ">" . $this->td[70] . $t . " id=\"rt\">" . $this->td[71] . "<\/td><\/tr><tr><td id=\"bl\">" . $this->td[72] . $t . " id=\"bt\">" . $this->td[73] . $t . " id=\"bg\">" . $this->td[74] . $t . " id=\"bt\">" . $this->td[75] . $t . " id=\"bt\">" . $this->td[76] . $t . " id=\"bg\">" . $this->td[77] . $t . " id=\"bt\">" . $this->td[78] . $t . " id=\"bt\">" . $this->td[79] . $t . " id=\"bg\">" . $this->td[80] . "<\/td><\/tr><\/table><\/form><\/div>";

    return $display;
  }

}

?>
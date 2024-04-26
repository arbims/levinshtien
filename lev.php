<?php

function lev(string $s1, string $s2) {
  $m = strlen($s1);
  $n = strlen($s2);

  $d = [];
  $actions = [];

  // creation matrix
  for ($i = 0; $i <= $m; $i++) {
      $d[$i][0] = $i;
      $actions[$i][0] = ($i > 0) ? [ 'R ,' . $s1[$i - 1]] : ['I ,' . $s1[$i - 1]];
  }

  for ($j = 0; $j <= $n; $j++) {
      $d[0][$j] = $j;
      $actions[0][$j] = ($j > 0) ? ['A ,' . $s2[$j - 1]] : ['I ,'. $s2[$j - 1]];
  }

  // remplir la matrice
  for ($i = 1; $i <= $m; $i++) {
      for ($j = 1; $j <= $n; $j++) {
          if ($s1[$i - 1] == $s2[$j - 1]) {
              $d[$i][$j] = $d[$i - 1][$j - 1];
              $actions[$i][$j] = ['I ,' . $s1[$i - 1]];
          } else {
              $remove = $d[$i - 1][$j] + 1;
              $add = $d[$i][$j - 1] + 1;
              $subst = $d[$i - 1][$j - 1] + 1;

              // distance levinstien
              $d[$i][$j] = min($remove, $add, $subst);
              if ($d[$i][$j] == $remove) {
                  $actions[$i][$j] = ['R ,' . $s1[$i - 1]];
              } elseif ($d[$i][$j] == $add) {
                  $actions[$i][$j] = ['A ,' . $s2[$j - 1]];
              } else {
                  $actions[$i][$j] = ['S ,' . $s1[$i - 1] . ' , ' . $s2[$j - 1] . ''];
              }
          }
      }
  }

  // extraction des operation
  $i = $m;
  $j = $n;
  $sequence = [];
  while ($i > 0 || $j > 0) {
      $sequence[] = $actions[$i][$j];
      if ($actions[$i][$j] == ['R ,' . $s1[$i - 1]]) {
          $i--;
      } elseif ($actions[$i][$j] == ['A ,' . $s2[$j - 1]]) {
          $j--;
      } else {
          $i--;
          $j--;
      }
  }

  // inverser la sequence
  $sequence = array_reverse($sequence);

  return ['distance' => $d[$m][$n], 'operations' => json_encode($sequence)];
}

// Example :
$result = lev("add", "dady");
var_dump($result);


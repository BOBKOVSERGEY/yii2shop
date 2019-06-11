<?php
function debug($array, $die = false)
{
  echo '<pre style="font-size: 12px; color: green; ">';
  print_r($array);
  echo '</pre>';

  if ($die) die;
}

function debugVarDump($array)
{
  echo '<pre>';
  var_dump($array);
  echo '</pre>';
}

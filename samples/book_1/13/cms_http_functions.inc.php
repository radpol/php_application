<?php
function redirect($url) {
  if (!headers_sent()) {
    header('Location: ' . $url);
  } else {
    die('P�esm�rov�n� nelze dokon�it; V�stup ji� byl odesl�n.');
  }
}
?>
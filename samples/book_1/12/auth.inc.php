<?php
// Zah�jen� nebo pokra�ov�n� relace.
session_start();

if (!isset($_SESSION['logged'])) {
    header('Refresh: 5; URL=login.php?redirect=' . $_SERVER['PHP_SELF']);
  echo '<p>Za 5 sekund budete p�esm�rov�ni na p�ihla�ovac� str�nku.</p>' .
    '<p>Nebudete-li p�esm�rov�ni automaticky, ' .
    '<a href="login.php?redirect=' . $_SERVER['PHP_SELF'] .
    '">klepn�te sem</a>.</p>';
    die();
}
?>
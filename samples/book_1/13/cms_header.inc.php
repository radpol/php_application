<?php session_start(); ?>
<html>
  <head>
    <title>Redak�n� syst�m</title>
    <style type="text/css">
      td { vertical-align: top; }
    </style>
  </head>
  <body>
    <h1>Web pro fanou�ky komiks�</h1>
    <?php
    if (isset($_SESSION['name'])) {
      echo '<p>Jste p�ihl�eni jako: ' . $_SESSION['name'] . ' </p>';
    }
    ?>
    <div id="navright">
      <form method="get" action="cms_search.php">
        <div>
          <label for="search">Hledat</label>
          <?php
          echo '<input type="text" id="search" name="search" ';
          if (isset($_GET['keywords'])) {
            echo ' value="' . htmlspecialchars($_GET['keywords']) . '" ';
          }
          echo '/>';
          ?>
          <input type="submit" value="Hledat" />
        </div>
      </form>
    </div>
    <div id='navigation'>
      <a href="cms_index.php">�l�nky</a>
      <?php
      if (isset($_SESSION['user_id'])) {
        echo ' | <a href="cms_compose.php">Napsat</a>';
        if ($_SESSION['access_level'] > 1) {
          echo ' | <a href="cms_pending.php">Redakce</a>';
        }
        if ($_SESSION['access_level'] > 2) {
          echo ' | <a href="cms_admin.php">Spr�va</a>';
        }
        echo ' | <a href="cms_cpanel.php">Ovl�dac� panel</a>';
        echo ' | <a href="cms_transact_user.php?action=Odhl�sit">Odhl�sit</a>';
      } else {
        echo ' | <a href="cms_login.php">P�ihl�sit</a>';
      }
      ?>
    </div>
    <div id="articles">

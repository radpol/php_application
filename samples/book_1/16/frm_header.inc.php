<?php
session_start();

require 'db.inc.php';
require 'frm_output_functions.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');

mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

require 'frm_config.inc.php';

$title = $admin['titlebar']['value'];
if (isset($pageTitle) and $pageTitle != '') {
  $title .= ' :: ' . $pageTitle;
}
if (isset($_SESSION['user_id'])) {
  $userid = $_SESSION['user_id'];
} else {
  $userid = null;
}
if (isset($_SESSION['access_lvl'])) {
  $access_lvl = $_SESSION['access_lvl'];
} else {
  $access_lvl = null;
}
if (isset($_SESSION['name'])) {
  $username = $_SESSION['name'];
} else {
  $username = null;
}
?>
<html>
  <head>
    <title><?php echo $title; ?></title>
    <style type="text/css">
      th { background-color: #999;}
      td { vertical-align: top; }
      .odd_row { background-color: #EEE; }
      .even_row { background-color: #FFF; }
    </style>
  </head>
  <body>
    <h1><?php echo $admin['title']['value']; ?></h1>
    <h2><?php echo $admin['description']['value']; ?></h2>
    <?php
    if (isset($_SESSION['name'])) {
      echo '<p>P�ihl�en� u�ivatel: ' . $_SESSION['name'] . '</p>';
    }
    ?>
    <form method="get" action="frm_search.php">
      <div>
        <input type="text" name="keywords"
               <?php
               if (isset($_GET['keywords'])) {
                 echo 'value="' . htmlspecialchars($_GET['keywords']) . '" ';
               }
               ?>
               />
        <input type="submit" value="Vyhledat"/>
      </div>
    </form>
    <?php
    echo '<p><a href="frm_index.php">Dom�</a>';
    if (!isset($_SESSION['user_id'])) {
      echo ' | <a href="frm_login.php">P�ihl�sit</a>';
      echo ' | <a href="frm_useraccount.php">Registrovat</a>';
    } else {
      echo ' | <a href="frm_transact_user.php?action=Odhl�sit">';
      echo "Odhl�sit u�ivatele " . $_SESSION['name'] . "</a>";
      if ($_SESSION['access_lvl'] > 2) {
        echo ' | <a href="frm_admin.php">Spr�va serveru</a>';
      }
      echo ' | <a href="frm_useraccount.php">Profil</a>';
    }
    echo '</p>';
    ?>

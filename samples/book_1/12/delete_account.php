<?php
include 'auth.inc.php';
include 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or 
  die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

if (isset($_POST['submit']) && $_POST['submit'] == 'Yes') {
  $query = 'DELETE i FROM
              site_user u JOIN site_user_info i ON u.user_id = i.user_id
            WHERE u.username="' .
  mysql_real_escape_string($_SESSION['username'], $db) . '"';
  mysql_query($query, $db) or die(mysql_error($db));

  $query = 'DELETE FROM site_user WHERE username="' .
  mysql_real_escape_string($_SESSION['username'], $db) . '"';
  mysql_query($query, $db) or die(mysql_error($db));

  $_SESSION['logged'] = null;
  $_SESSION['username'] = null;
  ?>
<html>
<head>
  <title>Odstranit u�ivatelsk� ��et</title>
</head>
<body>
<p><strong>Vybran� u�ivatelsk� ��et byl vymaz�n.</strong></p>
<p><a href="main.php">Klepn�te sem</a> a vra�te se na hlavn� str�nku.</p>
</body>
</html>
<?php
mysql_close($db);
die();
} else {
?>
<html>
  <head>
    <title>Odstranit u�ivatelsk� ��et</title>
    <script type="text/javascript">
      window.onload = function() {
        document.getElementById('cancel').onclick = goBack;
      }
      function goBack() {
        history.go(-1);
      }
    </script>
  </head>
  <body>
    <p>Opravdu chcete odstranit vybran� u�ivatelsk� ��et?</p>
    <p><strong>Potvrd�te-li operaci, nebude mo�n� ��et obnovit!</strong></p>
    <form action="delete_account.php" method="post">
      <div>
        <input type="submit" name="submit" value="Ano"/>
        <input type="button" id="cancel" value="Ne" onclick="history.go(-1);"/>
      </div>
    </form>
  </body>
</html>
<?php
}
?>
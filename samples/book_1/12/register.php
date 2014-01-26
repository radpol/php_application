<?php
session_start();

include 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or 
  die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$hobbies_list = array('Po��ta�e', 'Tanec', 'Cvi�en�', 'L�t�n�', 'Golf',
    'Lov', 'Internet', '�ten�', 'Cestov�n�', 'Jin�');

// Filtr p�ijat�ch hodnot.
$username = (isset($_POST['username'])) ? trim($_POST['username']) : '';
$password = (isset($_POST['password'])) ? $_POST['password'] : '';
$first_name = (isset($_POST['first_name'])) ? trim($_POST['first_name']) : '';
$last_name = (isset($_POST['last_name'])) ? trim($_POST['last_name']) : '';
$email = (isset($_POST['email'])) ? trim($_POST['email']) : '';
$city = (isset($_POST['city'])) ? trim($_POST['city']) : '';
$state = (isset($_POST['state'])) ? trim($_POST['state']) : '';
$hobbies = (isset($_POST['hobbies']) && is_array($_POST['hobbies'])) ?
$_POST['hobbies'] : array();

if (isset($_POST['submit']) && $_POST['submit'] == 'Registrovat') {

  $errors = array();

  // Kontrola povinn�ch polo�ek.
  if (empty($username)) {
    $errors[] = 'Mus�te zadat u�ivatelsk� jm�no.';
  }

  // Ov��en�, zda nebylo zad�no ji� registrovan� u�ivatelsk� jm�no.
  $query = 'SELECT username FROM site_user WHERE username = "' .
  $username . '"';
  $result = mysql_query($query, $db) or die(mysql_error());
  if (mysql_num_rows($result) > 0) {
    $errors[] = 'U�ivatelsk� jm�no ' . $username . ' ji� existuje.';
    $username = '';
  }
  mysql_free_result($result);

  if (empty($password)) {
    $errors[] = 'Mus�te zadat heslo.';
  }
  if (empty($first_name)) {
    $errors[] = 'Mus�te zadat jm�no.';
  }
  if (empty($last_name)) {
    $errors[] = 'Mus�te zadat p��jmen�.';
  }
  if (empty($email)) {
    $errors[] = 'Mus�te uv�st tak� adresu elektronick� po�ty.';
  }

  if (count($errors) > 0) {
    echo '<p><strong style="color:#FF000;">Registraci nelze dokon�it' .
      '.</strong></p>';
    echo '<p>Opravte n�sleduj�c� chyby:</p>';
    echo '<ul>';
    foreach ($errors as $error) {
      echo '<li>' . $error . '</li>';
    }
    echo '</ul>';
  } else {
    // V�e je v po��dku, proto m��eme p�ijat� informace ulo�it do datab�ze.

    $query = 'INSERT INTO site_user
                (user_id, username, password)
              VALUES
               (NULL, "' . mysql_real_escape_string($username, $db) . '", ' .
               'PASSWORD("' . mysql_real_escape_string($password, $db) . '"))';
    $result = mysql_query($query, $db) or die(mysql_error());

    $user_id = mysql_insert_id($db);

    $query = 'INSERT INTO site_user_info
               (user_id, first_name, last_name, email, city, state, hobbies)
              VALUES
               (' . $user_id . ', ' .
                '"' . mysql_real_escape_string($first_name, $db)  . '", ' .
                '"' . mysql_real_escape_string($last_name, $db)  . '", ' .
                '"' . mysql_real_escape_string($email, $db)  . '", ' .
                '"' . mysql_real_escape_string($city, $db)  . '", ' .
                '"' . mysql_real_escape_string($state, $db)  . '", ' .
                '"' . mysql_real_escape_string(join(', ', $hobbies), $db)  . '")';
    $result = mysql_query($query, $db) or die(mysql_error());

    $_SESSION['logged'] = 1;
    $_SESSION['username'] = $username;

    header('Refresh: 5; URL=main.php');
    ?>
<html>
  <head>
    <title>Registrace</title>
  </head>
  <body>
    <p><strong>U�ivatel <?php echo $username; ?> byl registrov�n!</strong></p>
    <p>Va�e registrace je dokon�ena! Nyn� m��ete pokra�ovat na str�nce,
      kterou jste si vy��dali. Pokud nebudete do 5 sekund p�esm�rov�n�
      automaticky, <a href="main.php">klepn�te sem</a>.</p>
  </body>
</html>
<?php
die();
}
}
?>
<html>
  <head>
    <title>Registrace</title>
    <style type="text/css">
      td { vertical-align: top; }
    </style>
  </head>
  <body>
    <form action="register.php" method="post">
      <table>
        <tr>
          <td><label for="username">U�ivatelsk� jm�no:</label></td>
          <td><input type="text" name="username" id="username" size="20"
                     maxlength="20" value="<?php echo $username; ?>"/></td>
        </tr><tr>
          <td><label for="password">Heslo:</label></td>
          <td><input type="password" name="password" id="password" size="20"
                     maxlength="20" value="<?php echo $password; ?>"/></td>
        </tr><tr>
          <td><label for="email">E-mail:</label></td>
          <td><input type="text" name="email" id="email" size="20" 
                     maxlength="50" value="<?php echo $email; ?>"/></td>
        </tr><tr>
          <td><label for="first_name">Jm�no:</label></td>
          <td><input type="text" name="first_name" id="first_name" size="20"
                     maxlength="20" value="<?php echo $first_name; ?>"/></td>
        </tr><tr>
          <td><label for="last_name">P��jmen�:</label></td>
          <td><input type="text" name="last_name" id="last_name" size="20"
                     maxlength="20" value="<?php echo $last_name; ?>"/></td>
        </tr><tr>
          <td><label for="city">M�sto:</label></td>
          <td><input type="text" name="city" id="city" size="20" maxlength="20"
                     value="<?php echo $city; ?>"/></td>
        </tr><tr>
          <td><label for="state">Zem�:</label></td>
          <td><input type="text" name="state" id="state" size="2" maxlength="2"
                     value="<?php echo $state; ?>"/></td>
        </tr><tr>
          <td><label for="hobbies">Z�jmy:</label></td>
          <td><select name="hobbies[]" id="hobbies" multiple="multiple">
              <?php
              foreach ($hobbies_list as $hobby)
              {
                if (in_array($hobby, $hobbies)) {
                  echo '<option value="' . $hobby . '" selected="selected">' . 
                    $hobby . '</option>';
                } else {
                  echo '<option value="' . $hobby . '">' . $hobby . '</option>';
                }
              }
              ?>
          </select></td>
        </tr><tr>
          <td> </td>
          <td><input type="submit" name="submit" value="Registrovat"/></td>
        </tr>
      </table>
    </form>
  </body>
</html>
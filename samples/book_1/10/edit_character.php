<?php
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$action = 'P�idat';

$character = array('alias' => '',
                   'real_name' => '',
                   'alignment' => 'dobro',
                   'address' => '',
                   'city' => '',
                   'state' => '',
                   'zipcode_id' => '');
$character_powers = array();
$rivalries = array();

// Ov��it hodnotu ID p��choz� postavy.
$character_id = (isset($_GET['id']) && ctype_digit($_GET['id'])) ?
  $_GET['id'] : 0;

// Zji�t�n� informac� o po�adovan� postav�.
if ($character_id != 0) {
  $query = 'SELECT
              c.alias, c.real_name, c.alignment,
              l.address, z.city, z.state, z.zipcode_id
            FROM
              comic_character c, comic_lair l, comic_zipcode z
            WHERE
              z.zipcode_id = l.zipcode_id AND
              c.lair_id = l.lair_id AND
              c.character_id = ' . $character_id;
  $result = mysql_query($query, $db) or die (mysql_error($db));

  if (mysql_num_rows($result) > 0) {
    $action = 'Upravit';
    $character = mysql_fetch_assoc($result);
  }
  mysql_free_result($result);

  if ($action == 'Upravit') {
    // Seznam schopnost� vybran� postavy.
    $query = 'SELECT
                power_id
              FROM
                comic_character_power
              WHERE character_id = ' . $character_id;
    $result = mysql_query($query, $db) or die (mysql_error($db));

    if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_array($result)) {
        $character_powers[$row['power_id']] = true;
      }
    }
    mysql_free_result($result);

    // Seznam rival� vybran� postavy.
    $query = 'SELECT
                c2.character_id
              FROM
                comic_character c1
                JOIN comic_character c2
                JOIN comic_rivalry r
                    ON (c1.character_id = r.hero_id AND
                        c2.character_id = r.villain_id) OR
                       (c2.character_id = r.hero_id AND
                        c1.character_id = r.villain_id)
              WHERE
                c1.character_id = ' . $character_id . '
              ORDER BY
                c2.alias ASC';
    $result = mysql_query($query, $db) or die (mysql_error($db));

    $rivalries = array();
    if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_array($result)) {
        $rivalries[$row['character_id']] = true;
      }
    }
  }
}
?>
<html>
  <head>
    <title><?php echo $action; ?> postavu</title>
    <style type="text/css">
      td { vertical-align: top; }
    </style>
  </head>
  <body>
    <img src="logo.jpg" alt="Web pro fanou�ky komiks�" style="float: left;" />
    <h1>Web<br/>pro fanou�ky komiks�</h1>
    <h2><?php echo $action; ?> postavu</h2>
    <hr style="clear: both;"/>
    <form action="char_transaction.php" method="post">
      <table>
        <tr>
          <td>P�ezd�vka:</td>
          <td><input type="text" name="alias" size="40" maxlength="40"
                     value="<?php echo $character['alias'];?>"></td>
        </tr><tr>
          <td>Skute�n� jm�no:</td>
          <td><input type="text" name="real_name" size="40" maxlength="80"
                     value="<?php echo $character['real_name'];?>"></td>
        </tr><tr>
          <td>Schopnosti:<br/>
            <small><em>v�ce schopnost� vyberete pomoc� kl�ves CTRL</em></small>
          </td>
          <td>
            <?php
            // Seznam dostupn�ch shopnost�.
            $query = 'SELECT
                    power_id, power
                FROM
                    comic_power
                ORDER BY
                    power ASC';
            $result = mysql_query($query, $db) or die (mysql_error($db));

            if (mysql_num_rows($result) > 0) {
              echo '<select multiple name="powers[]">';
              while ($row = mysql_fetch_array($result)) {
                if (isset($character_powers[$row['power_id']])) {
                  echo '<option value="' . $row['power_id'] .
                       '" selected="selected">';
                } else {
                  echo '<option value="' . $row['power_id'] . '">';
                }
                echo $row['power'] . '</option>';
              }
              echo '</select>';
            } else {
              echo '<p><strong>Nejsou dostupn� ��dn� schopnosti...</strong></p>';
            }
            mysql_free_result($result);
            ?>
          </td>
        </tr><tr>
          <td rowspan="2">Um�st�n� doup�te:<br/>
            <small><em>Adresa<br/>M�sto, St�t, PS�</em></small></td>
          <td><input type="text" name="address" size="40" maxlength="40"
                     value="<?php echo $character['address'];?>"></td>
        </tr><tr>
          <td><input type="text" name="city" size="23" maxlength="40"
                     value="<?php echo $character['city'];?>">
            <input type="text" name="state" size="2" maxlength="2"
                   value="<?php echo $character['state'];?>">
            <input type="text" name="zipcode_id" size="5" maxlength="5"
                   value="<?php echo $character['zipcode_id'];?>"></td>
        </tr><tr>
          <td>Za�adit na stranu:</td>
          <td><input type="radio" name="alignment" value="dobro"
             <?php
              echo ($character['alignment']=='dobro') ? 'checked="checked"' : '';
             ?>/> Dobro<br/>
            <input type="radio" name="alignment" value="zlo"
             <?php
              echo ($character['alignment']=='zlo') ? 'checked="checked"' : '';
             ?>/> Zlo
          </td>
        </tr><tr>
        </tr><tr>
          <td>Rivalov�:<br/>
            <small><em>V�ce nep��tel vyberete pomoc� kl�vesy CTRL</em></small>
          </td>
          <td>
            <?php
            // Seznam schopnost� nep�i�azen�ch vybran� postav�.
            $query = 'SELECT
                        character_id, alias
                      FROM
                        comic_character
                      WHERE
                        character_id != ' . $character_id . '
                      ORDER BY
                        alias ASC';
            $result = mysql_query($query, $db) or die (mysql_error($db));

            if (mysql_num_rows($result) > 0) {
              echo '<select multiple name="rivalries[]">';
              while ($row = mysql_fetch_array($result)) {
                if (isset($rivalries[$row['character_id']])) {
                  echo '<option value="' . $row['character_id'] .
                       '" selected="selected">';
                } else {
                  echo '<option value="' . $row['character_id'] . '">';
                }
                echo $row['alias'] . '</option>';
              }
              echo '</select>';
            } else {
              echo '<p><strong>Nejsou dostupn� ��dn� postavy...</strong></p>';
            }
            mysql_free_result($result);
            ?>
          </td>
        </tr><tr>
          <td colspan="2">
            <input type="submit" name="action"
                   value="<?php echo $action; ?> postavu" />
            <input type="reset" value="Vypr�zdnit">
            <?php
            if ($action == "Upravit") {
              echo '<input type="submit" name="action"' .
                ' value="Vymazat postavu" />';
              echo '<input type="hidden" name="character_id" value="' .
                $character_id . '" />';
            }
            ?>
          </td>
        </tr>
      </table>
    </form>
    <p><a href="list_characters.php">N�vrat na hlavn� str�nku</a></p>
  </body>
</html>

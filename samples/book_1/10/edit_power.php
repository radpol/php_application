<html>
  <head>
    <title>Editace schopnosti</title>
    <style type="text/css">
      td { vertical-align: top; }
    </style>
  </head>
  <body>
    <img src="logo.jpg" alt="Web pro fanou�ky komiks�" style="float: left;" />
    <h1>Web<br/>pro fanou�ky komiks�</h1>
    <h2>Editace schopnost� postavy</h2>
    <hr style="clear: both;"/>
    <form action="char_transaction.php" method="post">
      <div>
        <input type="text" name="new_power" size="20" maxlength="40" value="" />
        <input type="submit" name="action" value="P�idat novou schopnost" />
      </div>
      <?php
      require 'db.inc.php';

      $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
      die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');
      mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

      $query = 'SELECT power_id, power FROM comic_power ORDER BY power ASC';
      $result = mysql_query($query, $db) or die (mysql_error($db));

      if (mysql_num_rows($result) > 0) {
        echo '<p><em>Odstran�n� schopnosti zp�sob� vymaz�n� v�ech ' .
             'souvisej�c�ch postav -- vyb�rejte tedy obez�etn�!</em></p>';

        $num_powers = mysql_num_rows($result);
        $threshold = 5;
        $max_columns = 2;

        $num_columns = min($max_columns, ceil($num_powers/$threshold));
        $count_per_column = ceil($num_powers/$num_columns);

        $i = 0;
        echo '<table><tr><td>';
        while ($row = mysql_fetch_assoc($result)) {
          if (($i > 0) && ($i % $count_per_column == 0)) {
            echo '</td><td>';
          }
          echo '<input type="checkbox" name="powers[]" "value="' .
          $row['power_id'] . '" /> ';
          echo $row['power'] . '<br/>';
          $i++;
        }
        echo '</td></tr></table>';

        echo '<br/><input type="submit" name="action" ' .
                    'value="Vymazat vybran� schopnosti" />';
      } else {
        echo '<p><strong>Nejsou dostupn� ��dn� schopnosti...</strong></p>';
      }
      ?>
    </form>
    <p><a href="list_characters.php">N�vrat na hlavn� str�nku</a></p>
  </body>
</html>
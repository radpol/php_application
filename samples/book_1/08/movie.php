<?php
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));

if ($_GET['action'] == 'upravit') {
  // Na��st infromaci o z�znamu.
  $query = 'SELECT
                movie_name, movie_type, movie_year, movie_leadactor,
                movie_director
            FROM
                movie
            WHERE
                movie_id = ' . $_GET['id'];
  $result = mysql_query($query, $db) or die(mysql_error($db));
  extract(mysql_fetch_assoc($result));
} else {
  // Pou��t pr�zdn� hodnoty.
  $movie_name = '';
  $movie_type = 0;
  $movie_year = date('Y');
  $movie_leadactor = 0;
  $movie_director = 0;
}
?>
<html>
  <head>
    <title><?php echo ucfirst($_GET['action']); ?> film</title>
    <style type="text/css">
      <!--
      #error { background-color: #600; border: 1px solid #FF0; color: #FFF;
        text-align: center; margin: 10px; padding: 10px; }
      -->
    </style>
  </head>
  <body>
    <?php
    if (isset($_GET['error']) && $_GET['error'] != '') {
      echo '<div id="error">' . $_GET['error'] . '</div>';
    }
    ?>
    <form action="commit.php?action=<?php echo $_GET['action']; ?>&type=movie"
          method="post">
      <table>
        <tr>
          <td>N�zev filmu</td>
          <td><input type="text" name="movie_name"
                     value="<?php echo $movie_name; ?>"/></td>
        </tr><tr>
          <td>Filmov� ��nr</td>
          <td><select name="movie_type">
              <?php
              // Zjist�te informace o ��nru.
              $query = 'SELECT
                            movietype_id, movietype_label
                        FROM
                            movietype
                        ORDER BY
                            movietype_label';
              $result = mysql_query($query, $db) or die(mysql_error($db));

              // Napl�te seznam hodnotami.
              while ($row = mysql_fetch_assoc($result)) {
                if ($row['movietype_id'] == $movie_type) {
                  echo '<option value="' . $row['movietype_id'] .
                    '" selected="selected">';
                } else {
                  echo '<option value="' . $row['movietype_id'] . '">';
                }
                echo $row['movietype_label'] . '</option>';
              }
              ?>
          </select></td>
        </tr><tr>
          <td>Uveden v roce</td>
          <td><select name="movie_year">
              <?php
              // Napl�te seznam p��slu�n�mi hodnotami.
              for ($rok = date("Y"); $rok >= 1970; $rok--) {
                if ($rok == $movie_year) {
                  echo '<option value="' . $rok . '" selected="selected">'
                  . $rok . '</option>';
                } else {
                  echo '<option value="' . $rok . '">' . $rok . '</option>';
                }
              }
              ?>
          </select></td>
        </tr><tr>
          <td>Hlavn� role</td>
          <td><select name="movie_leadactor">
              <?php
              // Zjist�te informace o p�edstaviteli hlavn� role.
              $query = 'SELECT
                            people_id, people_fullname
                        FROM
                            people
                        WHERE
                            people_isactor = 1
                        ORDER BY
                            people_fullname';
              $result = mysql_query($query, $db) or die(mysql_error($db));

              // Napl�te seznam v�sledky.
              while ($row = mysql_fetch_assoc($result)) {
                if ($row['people_id'] == $movie_leadactor) {
                  echo '<option value="' . $row['people_id'] .
                    '" selected="selected">';
                } else {
                  echo '<option value="' . $row['people_id'] . '">';
                }
                echo $row['people_fullname'] . '</option>';
              }
              ?>
          </select></td>
        </tr><tr>
          <td>Re�ie</td>
          <td><select name="movie_director">
              <?php
              // Zjist�te z�znamy o re�is�rovi.
              $query = 'SELECT
                            people_id, people_fullname
                        FROM
                            people
                        WHERE
                            people_isdirector = 1
                        ORDER BY
                            people_fullname';
              $result = mysql_query($query, $db) or die(mysql_error($db));

              // Napl�te seznam z�skan�mi v�sledky.
              while ($row = mysql_fetch_assoc($result)) {
                if ($row['people_id'] == $movie_director) {
                  echo '<option value="' . $row['people_id'] .
                    '" selected="selected">';
                } else {
                  echo '<option value="' . $row['people_id'] . '">';
                }
                echo $row['people_fullname'] . '</option>';
              }
              ?>
          </select></td>
        </tr><tr>
          <td colspan="2" style="text-align: center;">
            <?php
            if ($_GET['action'] == 'upravit') {
              echo '<input type="hidden" value="' . $_GET['id'] .
               '" name="movie_id" />';
            }
            ?>
            <input type="submit" name="submit"
                   value="<?php echo ucfirst($_GET['action']); ?>" />
          </td>
        </tr>
      </table>
    </form>
  </body>
</html>
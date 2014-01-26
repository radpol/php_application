<?php
// Nezapome�te se p�esv�d�it, �e p�i p�id�v�n� film� je vybr�n tak� ��nr.
// Nen�-li, p�esm�rujte u�ivatele zp�t na str�nku s formul��em.
if ($_POST['submit'] == 'P�idat') {
  if ($_POST['type'] == 'movie' && $_POST['movie_type'] == '') {
    header('Location: form4.php');
  }
}
?>
<html>
  <head>
    <title>V�ce��elov� formul��</title>
    <style type="text/css">
      <!--
      td {vertical-align: top;}
      -->
    </style>
  </head>
  <body>
    <?php
    // Zobrazit formul�� k z�sk�n� dal��ch informac�,
    // pokud u�ivatel vkl�d� nov� z�znam
    if ($_POST['submit'] == 'P�idat') {
      echo '<h1>P�idat ';
      if ($_POST['type'] == "movie")
      {
        echo ucfirst("film");
      }
      else
      {
        echo ucfirst(($_POST['type'] == 'actor') ? 'herce' : 're�is�ra');
      }
      echo '</h1>';
      ?>
    <form action="form4b.php" method="post">
      <input type="hidden" name="type" value="<?php echo $_POST['type']; ?>"/>
      <table>
        <tr>
          <td><?php
            echo ucfirst(($_POST['type'] == 'movie') ? 'N�zev' : 'Jm�no');?>
          </td>

          <td>
            <?php echo $_POST['name']; ?>
            <input type="hidden" name="name"
             value="<?php echo $_POST['name']; ?>"/>
          </td>
        </tr>
        <?php
        if ($_POST['type'] == 'movie') {
          ?>
        <tr>
          <td>��nr</td>
          <td>
            <?php echo $_POST['movie_type']; ?>
            <input type="hidden" name="movie_type"
                   value="<?php echo $_POST['movie_type']; ?>"/>
          </td>
        </tr><tr>
          <td>Rok</td>
          <td><input type="text" name="year" /></td>
        </tr><tr>
          <td>Popis filmu</td>
          <?php
        } else {
          echo '<tr><td>�ivotopis</td>';
        }
        ?>
          <td><textarea name="extra" rows="5" cols="60"></textarea></td>
        </tr><tr>
          <td colspan="2" style="text-align: center;">
            <?php
            if (isset($_POST['debug'])) {
              echo '<input type="hidden" name="debug" value="on" />';
            }
            ?>
            <input type="submit" name="submit" value="P�idat" />
          </td>
        </tr>
      </table>
    </form>
    <?php
    // U�ivatel pouze hled� informace...
  } else if ($_POST['submit'] == 'Vyhledat') {
    echo '<h1>Vyhledat ';
    if ($_POST['type'] == "movie")
    {
      echo ucfirst("film");
    }
    else
    {
      echo ucfirst(($_POST['type'] == 'actor') ? 'herce' : 're�is�ra');
    }
    echo '</h1>';
    echo '<p>Vyhled�v� se ' . $_POST['name'] . '...</p>';
  }

  if (isset($_POST['debug'])) {
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
  }
  ?>
  </body>
</html>
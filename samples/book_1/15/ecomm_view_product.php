<?php
session_start();

require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$product_code = isset($_GET['product_code']) ? $_GET['product_code'] : '';

$query = 'SELECT
              name, description, price
          FROM
              ecomm_products
          WHERE
              product_code = "' .
              mysql_real_escape_string($product_code, $db) . '"';
$result = mysql_query($query, $db)or die(mysql_error($db));

if (mysql_num_rows($result) != 1) {
  header('Location: ecomm_shop.php');
  mysql_free_result($result);
  mysql_close($db);
  exit();
}
$row = mysql_fetch_assoc($result);
extract($row);
?>
<html>
  <head>
    <title><?php echo $name; ?></title>
    <style type="text/css">
      th { background-color: #999;}
      td { vertical-align: top; }
      .odd_row { background-color: #EEE; }
      .even_row { background-color: #FFF; }
    </style>
  </head>
  <body>
    <h1>Obchod pro fanou�ky komiks�</h1>
    <p><a href="ecomm_view_cart.php">Zobrazit obsah n�kupn�ho ko��ku</a></p>
    <h2><?php echo $name; ?></h2>
    <table>
      <tr>
        <td rowspan="4"><img src="images/<?php echo $product_code; ?>.jpg"
                             alt="<?php echo $name; ?>"/></td>
        <td><?php echo $description; ?></td>
      </tr><tr>
        <td><strong>K�d produktu:</strong> <?php echo $product_code; ?></td>
      </tr><tr>
        <td><strong>Cena:</strong> 
          <?php echo number_format($price, 2, ',', ' '); ?> K�</td>
      </tr><tr>
        <td>
          <form method="post" action="ecomm_update_cart.php">
            <div>
              <input type="hidden" name="product_code"
                     value="<?php echo $product_code; ?>"/>
              <label for="qty">Mno�stv�: </label>
              <?php
              echo '<input type="hidden" name="redirect"' .
                   'value="ecomm_view_product.php?' .
                   'product_code=' . $product_code . '"/>';

              $session = session_id();
              $query = 'SELECT
                            qty
                        FROM
                            ecomm_temp_cart
                        WHERE
                            session = "' . $session . '" AND
                            product_code = "' . $product_code . '"';
              $result = mysql_query($query, $db)or die(mysql_error($db));

              if (mysql_num_rows($result) > 0) {
                $row = mysql_fetch_assoc($result);
                extract($row);
              } else {
                $qty = 0;
              }
              mysql_free_result($result);

              echo '<input type="text" name="qty" id="qty" size="2" ' . 
                   'maxlength="2" value="' . $qty . '"/>';

              if ($qty > 0) {
                echo '<input type="submit" name="submit" ' .
                     'value="Zm�nit mno�stv�"/>';
              } else {
                echo '<input type="submit" name="submit" ' .
                     'value="P�idat do ko��ku"/>';
              }
              ?>
            </div>
          </form>
        </td>
      </tr>
    </table>
    <hr/>
    <p><a href="ecomm_shop.php">&lt;&lt; Zp�t na hlavn� str�nku</a></p>
  </body>
</html> 